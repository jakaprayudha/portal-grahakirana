<?php

/**
 * =========================================================
 * LOGOUT ADMIN PMB
 * =========================================================
 */

session_start();


/**
 * =========================================================
 * HAPUS SESSION
 * =========================================================
 */

$_SESSION = [];


/**
 * =========================================================
 * HAPUS COOKIE SESSION
 * =========================================================
 */

if (ini_get('session.use_cookies')) {

   $params = session_get_cookie_params();

   setcookie(
      session_name(),
      '',
      time() - 42000,
      $params['path'],
      $params['domain'],
      $params['secure'],
      $params['httponly']
   );
}


/**
 * =========================================================
 * DESTROY SESSION
 * =========================================================
 */

session_destroy();


/**
 * =========================================================
 * REDIRECT KE LOGIN ADMIN
 * =========================================================
 *
 * Dari:
 * controllers/admin/logout.php
 *
 * Kembali ke:
 * admin/index.php
 *
 */

header(
   'Location: ../../admin/index'
);

exit;
