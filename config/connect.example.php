<?php

/**
 * =========================================================
 * DATABASE CONNECTION
 * STIH GRAHA KIRANA - PMB
 * =========================================================
 */

$host = 'localhost';
$dbname = 'db_grahakirana';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";

$options = [
   PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
   PDO::ATTR_EMULATE_PREPARES   => false,
];

try {

   $pdo = new PDO(
      $dsn,
      $username,
      $password,
      $options
   );
} catch (PDOException $e) {

   http_response_code(500);

   die('Database connection failed.');
}
