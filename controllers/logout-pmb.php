<?php

/**
 * =========================================================
 * LOGOUT PMB
 * =========================================================
 */

session_start();


/**
 * =========================================================
 * SIMPAN SESSION ID
 * =========================================================
 */

$sessionId = session_id();


/**
 * =========================================================
 * HAPUS SEMUA DATA SESSION
 * =========================================================
 */

$_SESSION = [];


/**
 * =========================================================
 * HAPUS COOKIE SESSION
 * =========================================================
 */

if (
   ini_get('session.use_cookies')
) {

   $params =
      session_get_cookie_params();

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
 * REDIRECT
 * =========================================================
 *
 * Jangan menggunakan URL/domain absolut.
 * Tetap fleksibel terhadap lokasi instalasi portal.
 *
 */

header(
   'Location: ../pmb/login-pmb'
);

exit;
