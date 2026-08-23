<?php

session_start();

require_once '../../config/connect.php';


/**
 * =========================================================
 * RESPONSE JSON
 * =========================================================
 */

header('Content-Type: application/json; charset=utf-8');


function responseJson(
   bool $success,
   string $message,
   array $data = [],
   int $status = 200
): void {

   http_response_code($status);

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
 * INPUT
 * =========================================================
 */

$username =
   trim(
      $_POST['username'] ?? ''
   );


$password =
   $_POST['password'] ?? '';


$remember =
   !empty($_POST['remember']);


/**
 * =========================================================
 * VALIDATION
 * =========================================================
 */

if ($username === '') {

   responseJson(
      false,
      'Username wajib diisi.',
      [
         'field' => 'username'
      ],
      422
   );
}


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
 * GET USER
 * =========================================================
 *
 * Hanya user dengan roles = admin
 *
 * status = 1 dianggap aktif.
 *
 */

$stmt = $pdo->prepare("

    SELECT
        id,
        uid,
        fullname,
        username,
        password,
        roles,
        path,
        status,
        id_program,
        id_collage

    FROM ms_user

    WHERE username = :username

      AND LOWER(TRIM(roles)) = 'admin'

      AND status = 1

    LIMIT 1

");


$stmt->execute([
   'username' => $username
]);


$user =
   $stmt->fetch(
      PDO::FETCH_ASSOC
   );


/**
 * =========================================================
 * USER NOT FOUND
 * =========================================================
 */

if (!$user) {

   responseJson(
      false,
      'Username atau password salah.',
      [],
      401
   );
}


/**
 * =========================================================
 * PASSWORD
 * =========================================================
 *
 * Kita support dua kemungkinan:
 *
 * 1. password_hash()
 * 2. password lama/plain text
 *
 * Prioritas password_verify().
 *
 */

$passwordValid = false;


/**
 * PASSWORD HASH
 */

if (
   password_verify(
      $password,
      $user['password']
   )
) {

   $passwordValid = true;
}


/**
 * =========================================================
 * FALLBACK PASSWORD LAMA
 * =========================================================
 *
 * Hanya digunakan jika database lama menyimpan
 * password secara plain text.
 *
 */

if (
   !$passwordValid &&
   hash_equals(
      (string) $user['password'],
      (string) $password
   )
) {

   $passwordValid = true;
}


/**
 * =========================================================
 * INVALID PASSWORD
 * =========================================================
 */

if (!$passwordValid) {

   responseJson(
      false,
      'Username atau password salah.',
      [],
      401
   );
}


/**
 * =========================================================
 * REGENERATE SESSION
 * =========================================================
 */

session_regenerate_id(true);


/**
 * =========================================================
 * ADMIN SESSION
 * =========================================================
 */

$_SESSION['admin_logged_in'] = true;

$_SESSION['admin_user_id'] =
   (int) $user['id'];

$_SESSION['admin_uid'] =
   $user['uid'];

$_SESSION['admin_username'] =
   $user['username'];

$_SESSION['admin_fullname'] =
   $user['fullname'];

$_SESSION['admin_roles'] =
   $user['roles'];

$_SESSION['admin_path'] =
   $user['path'];

$_SESSION['admin_id_program'] =
   $user['id_program'];

$_SESSION['admin_id_collage'] =
   $user['id_collage'];

$_SESSION['admin_login_at'] =
   date('Y-m-d H:i:s');


/**
 * =========================================================
 * UPDATE LOGIN
 * =========================================================
 */

try {

   $update = $pdo->prepare("

        UPDATE ms_user

        SET
            login_at = :login_at,
            status_login = :status_login

        WHERE id = :id

        LIMIT 1

    ");


   $update->execute([
      'login_at'    => date('Y-m-d H:i:s'),
      'status_login' => 'LOGIN',
      'id'           => $user['id']
   ]);
} catch (Throwable $e) {

   /**
    * Login tetap dianggap berhasil.
    *
    * Kegagalan update audit login tidak
    * membatalkan session admin.
    */
}


/**
 * =========================================================
 * SUCCESS
 * =========================================================
 */

responseJson(
   true,
   'Login administrator berhasil.',
   [
      'id'       => (int) $user['id'],
      'uid'      => $user['uid'],
      'fullname' => $user['fullname'],
      'username' => $user['username'],
      'roles'    => $user['roles'],
      'redirect' => '../admin/dashboard.php'
   ]
);
