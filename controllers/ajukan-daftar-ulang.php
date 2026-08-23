<?php

session_start();

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/connect.php';


/**
 * =========================================================
 * RESPONSE
 * =========================================================
 */

function responseJson(
   bool $success,
   string $message,
   array $data = [],
   int $statusCode = 200
): void {

   http_response_code($statusCode);

   echo json_encode([
      'success' => $success,
      'message' => $message,
      'data'    => $data
   ], JSON_UNESCAPED_UNICODE);

   exit;
}


/**
 * =========================================================
 * AUTHENTICATION
 * =========================================================
 */

if (
   empty($_SESSION['pmb_logged_in']) ||
   empty($_SESSION['pmb_user_id'])
) {

   responseJson(
      false,
      'Sesi login telah berakhir. Silakan login kembali.',
      [],
      401
   );
}


$userId = (int) $_SESSION['pmb_user_id'];


/**
 * =========================================================
 * ONLY POST
 * =========================================================
 */

if (
   $_SERVER['REQUEST_METHOD'] !== 'POST'
) {

   responseJson(
      false,
      'Method tidak diizinkan.',
      [],
      405
   );
}


/**
 * =========================================================
 * AMBIL DATA PESERTA
 * =========================================================
 */

try {

   $stmt = $pdo->prepare("

        SELECT

            id,
            fullname,
            register_uid,
            tahap_aktif,
            status_pendaftaran,
            status_kelulusan,
            status_daftar_ulang

        FROM register_pmb

        WHERE id = :id

        LIMIT 1

    ");

   $stmt->execute([
      'id' => $userId
   ]);

   $user = $stmt->fetch(PDO::FETCH_ASSOC);


   if (!$user) {

      responseJson(
         false,
         'Data peserta tidak ditemukan.',
         [],
         404
      );
   }


   /**
    * =====================================================
    * HARUS LULUS
    * =====================================================
    */

   if (
      strtoupper(
         $user['status_kelulusan'] ?? ''
      ) !== 'LULUS'
   ) {

      responseJson(
         false,
         'Anda belum dinyatakan lulus seleksi.',
         [],
         422
      );
   }


   /**
    * =====================================================
    * HARUS TAHAP 07
    * =====================================================
    */

   if (
      (int) $user['tahap_aktif'] < 7
   ) {

      responseJson(
         false,
         'Tahap daftar ulang belum dapat diakses.',
         [
            'tahap_aktif' =>
            (int) $user['tahap_aktif']
         ],
         422
      );
   }


   /**
    * =====================================================
    * CEK STATUS DAFTAR ULANG
    * =====================================================
    */

   $statusDaftarUlang =
      strtoupper(
         $user['status_daftar_ulang']
            ?: 'BELUM_DIAJUKAN'
      );


   /**
    * Sudah diajukan
    */

   if (
      $statusDaftarUlang === 'DIAJUKAN'
   ) {

      responseJson(
         false,
         'Daftar ulang sudah diajukan dan sedang menunggu verifikasi panitia.',
         [
            'status_daftar_ulang' =>
            'DIAJUKAN'
         ],
         409
      );
   }


   /**
    * Sedang diverifikasi
    */

   if (
      $statusDaftarUlang === 'DIVERIFIKASI'
   ) {

      responseJson(
         false,
         'Daftar ulang sedang dalam proses verifikasi panitia.',
         [
            'status_daftar_ulang' =>
            'DIVERIFIKASI'
         ],
         409
      );
   }


   /**
    * Sudah diterima
    */

   if (
      $statusDaftarUlang === 'DITERIMA'
   ) {

      responseJson(
         false,
         'Daftar ulang Anda sudah diterima.',
         [
            'status_daftar_ulang' =>
            'DITERIMA'
         ],
         409
      );
   }


   /**
    * =====================================================
    * UPDATE
    * =====================================================
    */

   $pdo->beginTransaction();


   $stmt = $pdo->prepare("

        UPDATE register_pmb

        SET

            status_daftar_ulang = 'DIAJUKAN',

            status_pendaftaran = 'DAFTAR_ULANG',

            updated_at = NOW()

        WHERE id = :id

        LIMIT 1

    ");


   $stmt->execute([
      'id' => $userId
   ]);


   if (
      $stmt->rowCount() < 1
   ) {

      $pdo->rollBack();

      responseJson(
         false,
         'Data daftar ulang tidak berhasil diperbarui.',
         [],
         500
      );
   }


   $pdo->commit();


   /**
    * =====================================================
    * SUCCESS
    * =====================================================
    */

   responseJson(
      true,
      'Pengajuan daftar ulang berhasil dikirim. Silakan menunggu verifikasi panitia.',
      [
         'id' =>
         (int) $user['id'],

         'register_uid' =>
         $user['register_uid'],

         'status_daftar_ulang' =>
         'DIAJUKAN',

         'status_pendaftaran' =>
         'DAFTAR_ULANG',

         'tahap_aktif' =>
         (int) $user['tahap_aktif'],

         'redirect' =>
         null
      ],
      200
   );
} catch (PDOException $e) {

   if (
      $pdo->inTransaction()
   ) {

      $pdo->rollBack();
   }


   responseJson(
      false,
      'Terjadi kesalahan saat mengajukan daftar ulang.',
      [],
      500
   );
}
