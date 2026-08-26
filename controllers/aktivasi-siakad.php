<?php

/**
 * =========================================================
 * CONTROLLER : AKTIVASI SIAKAD
 * =========================================================
 *
 * Generate NPM otomatis:
 *
 * YY-KODE_KAMPUS-KODE_PRODI-KODE_JALUR-NOMOR_URUT
 *
 * Contoh:
 * 26-69-74-01-001
 *
 */


ob_start();

session_start();

header(
   'Content-Type: application/json; charset=utf-8'
);

require_once __DIR__ . '/../config/connect.php';


/**
 * =========================================================
 * JSON RESPONSE
 * =========================================================
 */

function responseJSON(
   bool $success,
   string $message,
   int $status = 200,
   array $data = []
): void {

   /*
     * Bersihkan output warning / notice
     */
   if (
      ob_get_length()
   ) {
      ob_clean();
   }


   http_response_code(
      $status
   );


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


$userId =
   (int) $_SESSION['pmb_user_id'];


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


if (
   $agreement !== '1'
) {

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
    * GET DATA MAHASISWA
    * =====================================================
    */

   $stmt =
      $pdo->prepare("
            SELECT
                id,
                fullname,
                register_uid,
                status_pendaftaran,
                tahap_aktif,
                nim,
                siakad_status,
                register_type,
                id_program,
                created_at
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


   /**
    * =====================================================
    * USER NOT FOUND
    * =====================================================
    */

   if (
      !$user
   ) {

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
    * CURRENT SIAKAD STATUS
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
    *
    * Kalau sudah aktif jangan generate NPM baru.
    *
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
            $user['nim'],

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
    * LOCK DATA PESERTA
    * =====================================================
    *
    * Supaya dua request aktivasi bersamaan tidak
    * membuat proses NPM ganda.
    *
    */

   $lockStmt =
      $pdo->prepare("
            SELECT
                id,
                fullname,
                nim,
                register_type,
                id_program,
                created_at
            FROM register_pmb
            WHERE id = :id
            FOR UPDATE
        ");


   $lockStmt->execute(
      [
         'id' => $userId
      ]
   );


   $lockedUser =
      $lockStmt->fetch(
         PDO::FETCH_ASSOC
      );


   if (
      !$lockedUser
   ) {

      $pdo->rollBack();

      responseJSON(
         false,
         'Data mahasiswa tidak ditemukan.',
         404
      );
   }


   /**
    * =====================================================
    * CEK NIM LAMA
    * =====================================================
    *
    * Jika NIM sudah pernah diterbitkan,
    * jangan membuat NIM baru.
    *
    */

   $nim =
      trim(
         $lockedUser['nim'] ?? ''
      );


   /**
    * =====================================================
    * GENERATE NPM
    * =====================================================
    */

   if (
      $nim === ''
   ) {


      /**
       * =================================================
       * TAHUN MASUK
       * =================================================
       *
       * Menggunakan tahun created_at.
       *
       * Contoh:
       * 2026 -> 26
       *
       */

      $createdAt =
         $lockedUser['created_at']
         ?? null;


      if (
         $createdAt
      ) {

         $tahunMasuk =
            date(
               'Y',
               strtotime(
                  $createdAt
               )
            );
      } else {

         $tahunMasuk =
            date('Y');
      }


      $kodeTahun =
         substr(
            $tahunMasuk,
            -2
         );


      /**
       * =================================================
       * KODE KAMPUS
       * =================================================
       *
       * STIH Graha Kirana = 69
       *
       */

      $kodeKampus =
         '69';


      /**
       * =================================================
       * KODE PRODI
       * =================================================
       *
       * Ilmu Hukum = 74
       *
       */

      $kodeProdi =
         '74';


      /**
       * =================================================
       * KODE JALUR
       * =================================================
       *
       * 01 = REGULER
       * 02 = EKSEKUTIF
       * 03 = PINDAHAN
       *
       */

      $registerType =
         strtoupper(
            trim(
               $lockedUser['register_type']
                  ?? ''
            )
         );


      switch ($registerType) {

         case 'REGULER':

            $kodeJalur =
               '01';

            break;


         case 'EKSEKUTIF':

            $kodeJalur =
               '02';

            break;


         case 'PINDAHAN':

            $kodeJalur =
               '03';

            break;


         default:

            /*
                 * Jika tipe jalur tidak dikenal,
                 * jangan membuat NPM yang salah.
                 */

            $pdo->rollBack();

            responseJSON(
               false,
               'Kode jalur akademik peserta belum valid.',
               422,
               [
                  'register_type' =>
                  $lockedUser['register_type']
                     ?? null
               ]
            );
      }


      /**
       * =================================================
       * CARI NOMOR URUT
       * =================================================
       *
       * Format:
       *
       * 26-69-74-01-001
       * 26-69-74-01-002
       * 26-69-74-01-003
       *
       */

      $prefix =
         $kodeTahun .
         '-' .
         $kodeKampus .
         '-' .
         $kodeProdi .
         '-' .
         $kodeJalur .
         '-';


      /**
       * Ambil nomor terbesar untuk:
       *
       * Tahun
       * Kampus
       * Prodi
       * Jalur
       *
       */

      $sequenceStmt =
         $pdo->prepare("
                SELECT
                    MAX(
                        CAST(
                            SUBSTRING_INDEX(
                                nim,
                                '-',
                                -1
                            ) AS UNSIGNED
                        )
                    ) AS nomor_terakhir
                FROM register_pmb
                WHERE nim LIKE :prefix
            ");


      $sequenceStmt->execute(
         [
            'prefix' =>
            $prefix . '%'
         ]
      );


      $lastNumber =
         $sequenceStmt->fetchColumn();


      if (
         $lastNumber === false ||
         $lastNumber === null
      ) {

         $lastNumber =
            0;
      }


      $nextNumber =
         ((int) $lastNumber) + 1;


      /**
       * =================================================
       * BATAS NOMOR
       * =================================================
       *
       * 001 - 999
       *
       */

      if (
         $nextNumber > 999
      ) {

         $pdo->rollBack();

         responseJSON(
            false,
            'Nomor urut NPM untuk jalur ini sudah mencapai batas 999.',
            422
         );
      }


      /**
       * =================================================
       * FORMAT NOMOR URUT
       * =================================================
       */

      $nomorUrut =
         str_pad(
            (string) $nextNumber,
            3,
            '0',
            STR_PAD_LEFT
         );


      /**
       * =================================================
       * BENTUK NPM
       * =================================================
       */

      $nim =
         $prefix .
         $nomorUrut;


      /**
       * =================================================
       * UPDATE NPM
       * =================================================
       */

      $updateNim =
         $pdo->prepare("
                UPDATE register_pmb
                SET
                    nim = :nim,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :id
                LIMIT 1
            ");


      $updateNim->execute(
         [
            'nim' =>
            $nim,

            'id' =>
            $userId
         ]
      );
   }


   /**
    * =====================================================
    * AKTIVASI SIAKAD
    * =====================================================
    */

   $updateSiakad =
      $pdo->prepare("
            UPDATE register_pmb
            SET
                siakad_status = 'AKTIF',
                updated_at = CURRENT_TIMESTAMP
            WHERE id = :id
            LIMIT 1
        ");


   $updateSiakad->execute(
      [
         'id' =>
         $userId
      ]
   );


   /**
    * =====================================================
    * VERIFY
    * =====================================================
    */

   $verify =
      $pdo->prepare("
            SELECT
                nim,
                siakad_status
            FROM register_pmb
            WHERE id = :id
            LIMIT 1
        ");


   $verify->execute(
      [
         'id' =>
         $userId
      ]
   );


   $verified =
      $verify->fetch(
         PDO::FETCH_ASSOC
      );


   $verifiedNim =
      trim(
         $verified['nim'] ?? ''
      );


   $verifiedStatus =
      strtoupper(
         trim(
            $verified['siakad_status']
               ?? ''
         )
      );


   /**
    * =====================================================
    * VERIFY NPM
    * =====================================================
    */

   if (
      $verifiedNim === ''
   ) {

      $pdo->rollBack();

      responseJSON(
         false,
         'NPM gagal diterbitkan.',
         500
      );
   }


   /**
    * =====================================================
    * VERIFY SIAKAD
    * =====================================================
    */

   if (
      $verifiedStatus !== 'AKTIF'
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
      'Akun SIAKAD berhasil diaktifkan dan NPM berhasil diterbitkan.',
      200,
      [
         'id' =>
         (int) $user['id'],

         'fullname' =>
         $user['fullname'],

         'nim' =>
         $verifiedNim,

         'siakad_status' =>
         'AKTIF',

         'redirect' =>
         './pmb/welcome-mahasiswa.php'
      ]
   );
} catch (
   PDOException $e
) {


   /**
    * =====================================================
    * ROLLBACK
    * =====================================================
    */

   if (
      isset($pdo) &&
      $pdo->inTransaction()
   ) {

      $pdo->rollBack();
   }


   error_log(
      'AKTIVASI SIAKAD DATABASE ERROR: ' .
         $e->getMessage()
   );


   responseJSON(
      false,
      'Database Error: ' .
         $e->getMessage(),
      500
   );
} catch (
   Throwable $e
) {


   if (
      isset($pdo) &&
      $pdo->inTransaction()
   ) {

      $pdo->rollBack();
   }


   error_log(
      'AKTIVASI SIAKAD SYSTEM ERROR: ' .
         $e->getMessage()
   );


   responseJSON(
      false,
      'System Error: ' .
         $e->getMessage(),
      500
   );
}
