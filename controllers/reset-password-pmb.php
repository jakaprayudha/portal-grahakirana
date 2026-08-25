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
 * EMAIL
 * =========================================================
 */

$email =
   trim(
      $_POST['email']
         ?? ''
   );


if ($email === '') {

   responseJson(
      false,
      'Email pendaftaran wajib diisi.'
   );
}


if (
   !filter_var(
      $email,
      FILTER_VALIDATE_EMAIL
   )
) {

   responseJson(
      false,
      'Format email tidak valid.'
   );
}


/**
 * =========================================================
 * CARI PESERTA
 * =========================================================
 */

try {

   $stmt =
      $pdo->prepare("

         SELECT

            id,
            fullname,
            email_register,
            account_status

         FROM register_pmb

         WHERE email_register = :email

         LIMIT 1

      ");


   $stmt->execute(
      [
         'email' => $email
      ]
   );


   $peserta =
      $stmt->fetch(
         PDO::FETCH_ASSOC
      );


   if (!$peserta) {

      responseJson(
         false,
         'Email pendaftaran tidak ditemukan.'
      );
   }


   /**
    * =====================================================
    * CEK ACCOUNT
    * =====================================================
    */

   if (
      isset($peserta['account_status']) &&
      strtoupper(
         $peserta['account_status']
      ) === 'BLOCKED'
   ) {

      responseJson(
         false,
         'Akun Anda sedang diblokir. Silakan hubungi panitia PMB.'
      );
   }


   /**
    * =====================================================
    * GENERATE PASSWORD 6 DIGIT
    * =====================================================
    *
    * random_int() digunakan agar angka
    * tidak mudah ditebak seperti rand().
    *
    */

   $newPassword =
      str_pad(
         (string) random_int(
            0,
            999999
         ),
         6,
         '0',
         STR_PAD_LEFT
      );


   /**
    * =====================================================
    * HASH PASSWORD
    * =====================================================
    */

   $passwordHash =
      password_hash(
         $newPassword,
         PASSWORD_DEFAULT
      );


   if (!$passwordHash) {

      throw new RuntimeException(
         'Gagal membuat password baru.'
      );
   }


   /**
    * =====================================================
    * UPDATE DATABASE
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
         $peserta['id']
      ]
   );


   /**
    * =====================================================
    * SUCCESS
    * =====================================================
    */

   responseJson(
      true,
      'Password berhasil direset. Silakan gunakan password baru untuk login.',
      [
         'id' =>
         (int) $peserta['id'],

         'password' =>
         $newPassword
      ]
   );
} catch (
   Throwable $e
) {

   error_log(
      'RESET PASSWORD PMB ERROR: ' .
         $e->getMessage()
   );


   http_response_code(500);


   responseJson(
      false,
      'Gagal melakukan reset password. Silakan coba kembali.'
   );
}
