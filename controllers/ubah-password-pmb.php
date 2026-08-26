<?php

session_start();

require_once __DIR__ . '/../config/connect.php';


/**
 * =========================================================
 * JSON RESPONSE
 * =========================================================
 */

header(
   'Content-Type: application/json; charset=UTF-8'
);


function responseJson(
   bool $success,
   string $message,
   array $data = []
): void {

   echo json_encode(
      [
         'success' => $success,
         'message' => $message,
         'data'    => $data
      ],
      JSON_UNESCAPED_UNICODE
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
   $_SESSION['pmb_logged_in'] !== true ||
   empty($_SESSION['pmb_user_id'])
) {

   http_response_code(401);

   responseJson(
      false,
      'Sesi login PMB telah berakhir.'
   );
}


/**
 * =========================================================
 * METHOD
 * =========================================================
 */

if (
   $_SERVER['REQUEST_METHOD'] !== 'POST'
) {

   http_response_code(405);

   responseJson(
      false,
      'Method tidak diperbolehkan.'
   );
}


/**
 * =========================================================
 * INPUT
 * =========================================================
 */

$userId =
   (int) $_SESSION['pmb_user_id'];


$passwordLama =
   $_POST['password_lama']
   ?? '';


$passwordBaru =
   $_POST['password_baru']
   ?? '';


$passwordKonfirmasi =
   $_POST['password_konfirmasi']
   ?? '';


/**
 * =========================================================
 * VALIDATION
 * =========================================================
 */

if (
   $passwordLama === ''
) {

   responseJson(
      false,
      'Password lama wajib diisi.'
   );
}


if (
   $passwordBaru === ''
) {

   responseJson(
      false,
      'Password baru wajib diisi.'
   );
}


if (
   strlen($passwordBaru) < 6
) {

   responseJson(
      false,
      'Password baru minimal 6 karakter.'
   );
}


if (
   $passwordKonfirmasi === ''
) {

   responseJson(
      false,
      'Konfirmasi password wajib diisi.'
   );
}


if (
   $passwordBaru !==
   $passwordKonfirmasi
) {

   responseJson(
      false,
      'Konfirmasi password tidak sesuai.'
   );
}


if (
   $passwordLama ===
   $passwordBaru
) {

   responseJson(
      false,
      'Password baru harus berbeda dengan password lama.'
   );
}


/**
 * =========================================================
 * GET USER
 * =========================================================
 */

try {

   $stmt =
      $pdo->prepare("

         SELECT

            id,
            password_hash,
            account_status

         FROM register_pmb

         WHERE id = :id

         LIMIT 1

      ");


   $stmt->execute(
      [
         'id' => $userId
      ]
   );


   $user =
      $stmt->fetch(
         PDO::FETCH_ASSOC
      );


   if (!$user) {

      responseJson(
         false,
         'Data akun tidak ditemukan.'
      );
   }


   /**
    * =====================================================
    * CEK STATUS AKUN
    * =====================================================
    */

   if (
      isset($user['account_status']) &&
      strtoupper(
         $user['account_status']
      ) === 'BLOCKED'
   ) {

      responseJson(
         false,
         'Akun Anda sedang diblokir.'
      );
   }


   /**
    * =====================================================
    * VERIFY PASSWORD LAMA
    * =====================================================
    */

   if (
      empty($user['password_hash']) ||
      !password_verify(
         $passwordLama,
         $user['password_hash']
      )
   ) {

      responseJson(
         false,
         'Password lama tidak sesuai.'
      );
   }


   /**
    * =====================================================
    * HASH PASSWORD BARU
    * =====================================================
    */

   $passwordHash =
      password_hash(
         $passwordBaru,
         PASSWORD_DEFAULT
      );


   if (!$passwordHash) {

      throw new RuntimeException(
         'Gagal membuat hash password.'
      );
   }


   /**
    * =====================================================
    * UPDATE PASSWORD
    * =====================================================
    */

   $stmt =
      $pdo->prepare("

         UPDATE register_pmb

         SET

            password_hash = :password_hash,

            updated_at = NOW()

         WHERE id = :id

         LIMIT 1

      ");


   $stmt->execute(
      [
         'password_hash' =>
         $passwordHash,

         'id' =>
         $userId
      ]
   );


   /**
    * =====================================================
    * SUCCESS
    * =====================================================
    */

   responseJson(
      true,
      'Password berhasil diubah.',
      [
         'id' =>
         $userId
      ]
   );
} catch (
   Throwable $e
) {

   error_log(
      'UBAH PASSWORD PMB ERROR: ' .
         $e->getMessage()
   );


   http_response_code(500);


   responseJson(
      false,
      'Gagal mengubah password. Silakan coba kembali.'
   );
}
