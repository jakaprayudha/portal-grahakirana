<?php

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
 * METHOD
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
      'Koneksi database PDO tidak tersedia.',
      [],
      500
   );
}


/**
 * =========================================================
 * DATA FORM
 * =========================================================
 */

$fullname = trim(
   $_POST['nama_lengkap'] ?? ''
);

$email = strtolower(
   trim($_POST['email'] ?? '')
);

$phone = trim(
   $_POST['no_hp'] ?? ''
);

$registerType = trim(
   $_POST['jalur_pendaftaran'] ?? ''
);

$password = $_POST['password'] ?? '';

$passwordConfirmation =
   $_POST['password_confirmation'] ?? '';



/**
 * =========================================================
 * VALIDASI NAMA
 * =========================================================
 */

if ($fullname === '') {

   responseJson(
      false,
      'Nama lengkap wajib diisi.',
      [
         'field' => 'nama_lengkap'
      ],
      422
   );
}


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
 * NORMALISASI PHONE
 * =========================================================
 */

$phone = preg_replace(
   '/[^0-9+]/',
   '',
   $phone
);

if ($phone === '') {

   responseJson(
      false,
      'Nomor HP wajib diisi.',
      [
         'field' => 'no_hp'
      ],
      422
   );
}


/*
 * +628123456789
 * ↓
 * 08123456789
 */
if (str_starts_with($phone, '+62')) {

   $phone = '0' . substr($phone, 3);
}


/*
 * 628123456789
 * ↓
 * 08123456789
 */ elseif (str_starts_with($phone, '62')) {

   $phone = '0' . substr($phone, 2);
}


$phone = preg_replace(
   '/[^0-9]/',
   '',
   $phone
);


if (
   strlen($phone) < 10 ||
   strlen($phone) > 15
) {

   responseJson(
      false,
      'Nomor HP tidak valid.',
      [
         'field' => 'no_hp'
      ],
      422
   );
}


/**
 * =========================================================
 * JALUR PENDAFTARAN
 * =========================================================
 */

if (
   !in_array(
      $registerType,
      ['Reguler', 'Eksekutif', 'Pindahan'],
      true
   )
) {

   responseJson(
      false,
      'Silakan pilih jalur pendaftaran.',
      [
         'field' => 'jalur_pendaftaran'
      ],
      422
   );
}


/**
 * =========================================================
 * PASSWORD
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


if (strlen($password) < 8) {

   responseJson(
      false,
      'Password minimal 8 karakter.',
      [
         'field' => 'password'
      ],
      422
   );
}


if ($password !== $passwordConfirmation) {

   responseJson(
      false,
      'Konfirmasi password tidak sama.',
      [
         'field' => 'password_confirmation'
      ],
      422
   );
}


/**
 * =========================================================
 * DATABASE PROCESS
 * =========================================================
 */

try {


   /**
    * =====================================================
    * CEK EMAIL
    * =====================================================
    */

   $stmt = $pdo->prepare("
        SELECT id
        FROM register_pmb
        WHERE LOWER(email_register) = LOWER(:email)
        LIMIT 1
    ");

   $stmt->execute([
      'email' => $email
   ]);

   if ($stmt->fetch()) {

      responseJson(
         false,
         'Email sudah terdaftar. Silakan gunakan email lain atau login.',
         [
            'field' => 'email'
         ],
         409
      );
   }


   /**
    * =====================================================
    * CEK PHONE
    * =====================================================
    */

   $stmt = $pdo->prepare("
        SELECT id
        FROM register_pmb
        WHERE phone_number = :phone
        LIMIT 1
    ");

   $stmt->execute([
      'phone' => $phone
   ]);

   if ($stmt->fetch()) {

      responseJson(
         false,
         'Nomor HP sudah terdaftar. Silakan gunakan nomor lain atau login.',
         [
            'field' => 'no_hp'
         ],
         409
      );
   }


   /**
    * =====================================================
    * GENERATE UID
    * =====================================================
    */

   $registerUid =
      bin2hex(random_bytes(16));


   /**
    * =====================================================
    * PASSWORD HASH
    * =====================================================
    */

   $passwordHash =
      password_hash(
         $password,
         PASSWORD_DEFAULT
      );


   /**
    * =====================================================
    * INSERT
    * =====================================================
    */

   $sql = "
        INSERT INTO register_pmb (

            fullname,
            email_register,
            phone_number,
            register_uid,
            register_type,
            password_hash,
            account_status,
            tahap_aktif,
            status_pendaftaran,
            created_at

        ) VALUES (

            :fullname,
            :email,
            :phone,
            :register_uid,
            :register_type,
            :password_hash,
            'ACTIVE',
            1,
            'REGISTRASI',
            NOW()

        )
    ";


   $stmt = $pdo->prepare($sql);


   $stmt->execute([

      'fullname' =>
      $fullname,

      'email' =>
      $email,

      'phone' =>
      $phone,

      'register_uid' =>
      $registerUid,

      'register_type' =>
      $registerType,

      'password_hash' =>
      $passwordHash

   ]);


   /**
    * =====================================================
    * ID
    * =====================================================
    */

   $id =
      $pdo->lastInsertId();


   /**
    * =====================================================
    * SUCCESS
    * =====================================================
    */

   responseJson(
      true,
      'Registrasi berhasil. Silakan login untuk melanjutkan pendaftaran.',
      [
         'id' => $id,
         'register_uid' => $registerUid,
         'redirect' => 'pmb/login-pmb'
      ],
      201
   );
} catch (PDOException $e) {


   /**
    * =====================================================
    * DATABASE ERROR
    * =====================================================
    *
    * SEMENTARA untuk debugging lokal.
    *
    * Setelah berhasil, kita sembunyikan lagi detail ini.
    */

   responseJson(
      false,
      'Database Error: ' . $e->getMessage(),
      [
         'sql_state' => $e->errorInfo[0] ?? null,
         'driver_code' => $e->errorInfo[1] ?? null
      ],
      500
   );
} catch (Throwable $e) {


   responseJson(
      false,
      'PHP Error: ' . $e->getMessage(),
      [
         'file' => basename($e->getFile()),
         'line' => $e->getLine()
      ],
      500
   );
}
