<?php

/**
 * =========================================================
 * CONTROLLER : AKTIVASI SIAKAD
 * =========================================================
 */

ob_start();

session_start();

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/connect.php';


/**
 * =========================================================
 * CLEAN OUTPUT
 * =========================================================
 */

function responseJSON(
   bool $success,
   string $message,
   int $status = 200,
   array $data = []
): void {

   // Buang warning / notice / output lain
   if (ob_get_length()) {
      ob_clean();
   }

   http_response_code($status);

   echo json_encode(
      [
         'success' => $success,
         'message' => $message,
         'data'    => $data
      ],
      JSON_UNESCAPED_UNICODE |
         JSON_UNESCAPED_SLASHES
   );

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

   responseJSON(
      false,
      'Sesi login telah berakhir. Silakan login kembali.',
      401
   );
}


$userId = (int) $_SESSION['pmb_user_id'];


/**
 * =========================================================
 * METHOD
 * =========================================================
 */

if (
   $_SERVER['REQUEST_METHOD'] !== 'POST'
) {

   responseJSON(
      false,
      'Method tidak diizinkan.',
      405
   );
}


/**
 * =========================================================
 * AGREEMENT
 * =========================================================
 */

$agreement =
   $_POST['agreement'] ?? '';


if ($agreement !== '1') {

   responseJSON(
      false,
      'Silakan menyetujui pernyataan aktivasi terlebih dahulu.',
      422,
      [
         'field' => 'agreement'
      ]
   );
}


/**
 * =========================================================
 * DATABASE
 * =========================================================
 */

try {

   /**
    * =====================================================
    * GET MAHASISWA
    * =====================================================
    */

   $stmt = $pdo->prepare("

        SELECT

            id,
            fullname,
            register_uid,
            status_pendaftaran,
            tahap_aktif,
            nim,
            siakad_status

        FROM register_pmb

        WHERE id = :id

        LIMIT 1

    ");

   $stmt->execute([
      'id' => $userId
   ]);

   $user =
      $stmt->fetch(PDO::FETCH_ASSOC);


   /**
    * =====================================================
    * USER NOT FOUND
    * =====================================================
    */

   if (!$user) {

      responseJSON(
         false,
         'Data mahasiswa tidak ditemukan.',
         404
      );
   }


   /**
    * =====================================================
    * CHECK STATUS MAHASISWA
    * =====================================================
    */

   $statusPendaftaran =
      strtoupper(
         trim(
            $user['status_pendaftaran'] ?? ''
         )
      );


   if (
      $statusPendaftaran !== 'MAHASISWA'
   ) {

      responseJSON(
         false,
         'Akun belum berstatus mahasiswa.',
         422
      );
   }


   /**
    * =====================================================
    * CHECK NIM
    * =====================================================
    */

   $nim =
      trim(
         $user['nim'] ?? ''
      );


   if ($nim === '') {

      responseJSON(
         false,
         'NIM belum diterbitkan. Aktivasi SIAKAD belum dapat dilakukan.',
         422
      );
   }


   /**
    * =====================================================
    * CURRENT STATUS
    * =====================================================
    */

   $currentStatus =
      strtoupper(
         trim(
            $user['siakad_status']
               ?? 'BELUM_AKTIVASI'
         )
      );


   /**
    * =====================================================
    * SUDAH AKTIF
    * =====================================================
    */

   if (
      $currentStatus === 'AKTIF'
   ) {

      responseJSON(
         true,
         'Akun SIAKAD Anda sudah aktif.',
         200,
         [
            'id' =>
            (int) $user['id'],

            'fullname' =>
            $user['fullname'],

            'nim' =>
            $nim,

            'siakad_status' =>
            'AKTIF',

            'redirect' =>
            './pmb/welcome-mahasiswa.php'
         ]
      );
   }


   /**
    * =====================================================
    * TRANSACTION
    * =====================================================
    */

   $pdo->beginTransaction();


   /**
    * =====================================================
    * UPDATE
    * =====================================================
    */

   $update = $pdo->prepare("

        UPDATE register_pmb

        SET

            siakad_status = 'AKTIF',

            updated_at = CURRENT_TIMESTAMP

        WHERE id = :id

        LIMIT 1

    ");


   $update->execute([
      'id' => $userId
   ]);


   /**
    * =====================================================
    * VERIFY UPDATE
    * =====================================================
    */

   $verify = $pdo->prepare("

        SELECT

            siakad_status

        FROM register_pmb

        WHERE id = :id

        LIMIT 1

    ");


   $verify->execute([
      'id' => $userId
   ]);


   $newStatus =
      strtoupper(
         trim(
            (string)
            $verify->fetchColumn()
         )
      );


   if (
      $newStatus !== 'AKTIF'
   ) {

      $pdo->rollBack();

      responseJSON(
         false,
         'Aktivasi SIAKAD gagal disimpan.',
         500
      );
   }


   /**
    * =====================================================
    * COMMIT
    * =====================================================
    */

   $pdo->commit();


   /**
    * =====================================================
    * SUCCESS
    * =====================================================
    */

   responseJSON(
      true,
      'Akun SIAKAD berhasil diaktifkan.',
      200,
      [
         'id' =>
         (int) $user['id'],

         'fullname' =>
         $user['fullname'],

         'nim' =>
         $nim,

         'siakad_status' =>
         'AKTIF',

         'redirect' =>
         './pmb/welcome-mahasiswa.php'
      ]
   );
} catch (PDOException $e) {

   if (
      isset($pdo) &&
      $pdo->inTransaction()
   ) {

      $pdo->rollBack();
   }


   /**
    * Untuk development:
    * tampilkan error database sebagai JSON,
    * bukan HTML.
    */

   responseJSON(
      false,
      'Database Error: ' . $e->getMessage(),
      500
   );
} catch (Throwable $e) {

   if (
      isset($pdo) &&
      $pdo->inTransaction()
   ) {

      $pdo->rollBack();
   }


   responseJSON(
      false,
      'System Error: ' . $e->getMessage(),
      500
   );
}
