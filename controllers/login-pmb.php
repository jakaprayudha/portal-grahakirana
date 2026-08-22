<?php

/**
 * =========================================================
 * CONTROLLER : LOGIN PMB
 * =========================================================
 *
 * Login menggunakan:
 * - email
 * - password
 *
 * Table:
 * - register_pmb
 *
 * =========================================================
 */

session_start();

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/connect.php';


/**
 * =========================================================
 * RESPONSE JSON
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
 * ONLY POST
 * =========================================================
 */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

   responseJson(
      false,
      'Method tidak diizinkan.',
      [],
      405
   );
}


/**
 * =========================================================
 * CHECK PDO
 * =========================================================
 */

if (!isset($pdo) || !($pdo instanceof PDO)) {

   responseJson(
      false,
      'Koneksi database tidak tersedia.',
      [],
      500
   );
}


/**
 * =========================================================
 * AMBIL DATA
 * =========================================================
 */

$email = strtolower(
   trim($_POST['email'] ?? '')
);

$password =
   $_POST['password'] ?? '';


/**
 * =========================================================
 * VALIDASI EMAIL
 * =========================================================
 */

if ($email === '') {

   responseJson(
      false,
      'Email wajib diisi.',
      [
         'field' => 'email'
      ],
      422
   );
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

   responseJson(
      false,
      'Format email tidak valid.',
      [
         'field' => 'email'
      ],
      422
   );
}


/**
 * =========================================================
 * VALIDASI PASSWORD
 * =========================================================
 */

if ($password === '') {

   responseJson(
      false,
      'Password wajib diisi.',
      [
         'field' => 'password'
      ],
      422
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
    * CARI AKUN BERDASARKAN EMAIL
    * =====================================================
    */

   $stmt = $pdo->prepare("
        SELECT
            id,
            fullname,
            email_register,
            phone_number,
            password_hash,
            account_status,
            tahap_aktif,
            status_pendaftaran,
            register_uid,
            register_type
        FROM register_pmb
        WHERE LOWER(email_register) = :email
        LIMIT 1
    ");


   $stmt->execute([
      'email' => $email
   ]);


   $user =
      $stmt->fetch(PDO::FETCH_ASSOC);


   /**
    * =====================================================
    * EMAIL TIDAK DITEMUKAN
    * =====================================================
    *
    * Jangan beritahu apakah email memang ada atau tidak.
    */

   if (!$user) {

      responseJson(
         false,
         'Email atau password salah.',
         [
            'field' => 'email'
         ],
         401
      );
   }


   /**
    * =====================================================
    * CEK ACCOUNT STATUS
    * =====================================================
    */

   if ($user['account_status'] === 'BLOCKED') {

      responseJson(
         false,
         'Akun Anda diblokir. Silakan hubungi administrator PMB.',
         [],
         403
      );
   }


   if ($user['account_status'] !== 'ACTIVE') {

      responseJson(
         false,
         'Akun Anda belum aktif.',
         [],
         403
      );
   }


   /**
    * =====================================================
    * VERIFY PASSWORD
    * =====================================================
    */

   if (
      empty($user['password_hash']) ||
      !password_verify(
         $password,
         $user['password_hash']
      )
   ) {

      responseJson(
         false,
         'Email atau password salah.',
         [
            'field' => 'password'
         ],
         401
      );
   }


   /**
    * =====================================================
    * REGENERATE SESSION ID
    * =====================================================
    */

   session_regenerate_id(true);


   /**
    * =====================================================
    * SESSION PMB
    * =====================================================
    */

   $_SESSION['pmb_logged_in'] = true;

   $_SESSION['pmb_user_id'] =
      (int) $user['id'];

   $_SESSION['pmb_register_uid'] =
      $user['register_uid'];

   $_SESSION['pmb_fullname'] =
      $user['fullname'];

   $_SESSION['pmb_email'] =
      $user['email_register'];

   $_SESSION['pmb_tahap_aktif'] =
      (int) $user['tahap_aktif'];

   $_SESSION['pmb_status_pendaftaran'] =
      $user['status_pendaftaran'];

   $_SESSION['pmb_login_time'] =
      date('Y-m-d H:i:s');


   /**
    * =====================================================
    * UPDATE LAST LOGIN
    * =====================================================
    */

   $stmt = $pdo->prepare("
        UPDATE register_pmb
        SET last_login = NOW()
        WHERE id = :id
        LIMIT 1
    ");


   $stmt->execute([
      'id' => $user['id']
   ]);


   /**
    * =====================================================
    * SUCCESS
    * =====================================================
    */

   responseJson(
      true,
      'Login berhasil. Selamat datang kembali.',
      [
         'id' =>
         (int) $user['id'],

         'register_uid' =>
         $user['register_uid'],

         'fullname' =>
         $user['fullname'],

         'email' =>
         $user['email_register'],

         'tahap_aktif' =>
         (int) $user['tahap_aktif'],

         'status_pendaftaran' =>
         $user['status_pendaftaran'],

         'redirect' =>
         'pmb/welcome'
      ],
      200
   );
} catch (PDOException $e) {


   /**
    * =====================================================
    * DATABASE ERROR
    * =====================================================
    *
    * Untuk development/local.
    * Jangan tampilkan detail SQL di production.
    */

   responseJson(
      false,
      'Database Error: ' . $e->getMessage(),
      [
         'sql_state' =>
         $e->errorInfo[0] ?? null,

         'driver_code' =>
         $e->errorInfo[1] ?? null
      ],
      500
   );
} catch (Throwable $e) {


   responseJson(
      false,
      'PHP Error: ' . $e->getMessage(),
      [
         'file' =>
         basename($e->getFile()),

         'line' =>
         $e->getLine()
      ],
      500
   );
}
