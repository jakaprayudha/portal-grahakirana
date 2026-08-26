<?php

session_start();

header(
   'Content-Type: application/json; charset=UTF-8'
);

require_once __DIR__ . '/../config/connect.php';


/**
 * =========================================================
 * JSON RESPONSE
 * =========================================================
 */

function responseJson(
   bool $success,
   string $message,
   array $data = [],
   int $statusCode = 200
): void {

   http_response_code($statusCode);

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
   $_SESSION['pmb_logged_in'] !== true ||
   empty($_SESSION['pmb_user_id'])
) {

   responseJson(
      false,
      'Sesi login telah berakhir. Silakan login kembali.',
      [],
      401
   );
}


$userId = (int) $_SESSION['pmb_user_id'];


/**
 * =========================================================
 * VALIDASI USER ID
 * =========================================================
 */

if ($userId < 1) {

   responseJson(
      false,
      'ID peserta tidak valid.',
      [],
      400
   );
}


/**
 * =========================================================
 * ONLY POST
 * =========================================================
 */

if (
   ($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST'
) {

   responseJson(
      false,
      'Method tidak diizinkan.',
      [],
      405
   );
}


/**
 * =========================================================
 * CEK PDO
 * =========================================================
 */

if (
   !isset($pdo) ||
   !($pdo instanceof PDO)
) {

   responseJson(
      false,
      'Koneksi database tidak tersedia.',
      [],
      500
   );
}


/**
 * =========================================================
 * AMBIL DATA PESERTA
 * =========================================================
 */

try {

   $stmt = $pdo->prepare("

        SELECT

            id,
            fullname,
            register_uid,

            tahap_aktif,

            status_pendaftaran,
            status_kelulusan,
            status_daftar_ulang

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
    * PESERTA TIDAK DITEMUKAN
    * =====================================================
    */

   if (!$user) {

      responseJson(
         false,
         'Data peserta tidak ditemukan.',
         [],
         404
      );
   }


   /**
    * =====================================================
    * NORMALISASI STATUS
    * =====================================================
    */

   $statusKelulusan =
      strtoupper(
         trim(
            $user['status_kelulusan']
               ?? ''
         )
      );


   $statusDaftarUlang =
      strtoupper(
         trim(
            $user['status_daftar_ulang']
               ?? ''
         )
      );


   if (
      $statusDaftarUlang === ''
   ) {

      $statusDaftarUlang =
         'BELUM_DIAJUKAN';
   }


   $tahapAktif =
      (int) (
         $user['tahap_aktif']
         ?? 1
      );


   /**
    * =====================================================
    * HARUS LULUS
    *
    * TIDAK LAGI MENGGUNAKAN:
    *
    * tahap_aktif >= 7
    *
    * Karena peserta yang baru mendapatkan hasil LULUS
    * bisa saja masih memiliki tahap_aktif = 5.
    *
    * Selama status_kelulusan = LULUS,
    * daftar ulang sudah boleh diakses.
    * =====================================================
    */

   if (
      $statusKelulusan !== 'LULUS'
   ) {

      responseJson(
         false,
         'Anda belum dinyatakan lulus seleksi.',
         [
            'id' =>
            (int) $user['id'],

            'fullname' =>
            $user['fullname'],

            'status_kelulusan' =>
            $statusKelulusan ?: null,

            'status_pendaftaran' =>
            $user['status_pendaftaran'],

            'tahap_aktif' =>
            $tahapAktif
         ],
         422
      );
   }


   /**
    * =====================================================
    * CEK STATUS DAFTAR ULANG
    * =====================================================
    *
    * BELUM_DIAJUKAN
    *     -> boleh mengajukan
    *
    * DITOLAK
    *     -> boleh mengajukan kembali
    *
    * DIAJUKAN
    *     -> tidak boleh submit lagi
    *
    * DIVERIFIKASI
    *     -> tidak boleh submit lagi
    *
    * DITERIMA
    *     -> sudah selesai
    *
    * =====================================================
    */


   /**
    * -----------------------------------------------------
    * SUDAH DIAJUKAN
    * -----------------------------------------------------
    */

   if (
      $statusDaftarUlang === 'DIAJUKAN'
   ) {

      responseJson(
         false,
         'Daftar ulang sudah diajukan dan sedang menunggu verifikasi panitia.',
         [
            'id' =>
            (int) $user['id'],

            'register_uid' =>
            $user['register_uid'],

            'status_daftar_ulang' =>
            'DIAJUKAN',

            'status_pendaftaran' =>
            $user['status_pendaftaran'],

            'tahap_aktif' =>
            $tahapAktif
         ],
         409
      );
   }


   /**
    * -----------------------------------------------------
    * SEDANG DIVERIFIKASI
    * -----------------------------------------------------
    */

   if (
      $statusDaftarUlang === 'DIVERIFIKASI'
   ) {

      responseJson(
         false,
         'Daftar ulang sedang dalam proses verifikasi panitia.',
         [
            'id' =>
            (int) $user['id'],

            'register_uid' =>
            $user['register_uid'],

            'status_daftar_ulang' =>
            'DIVERIFIKASI',

            'status_pendaftaran' =>
            $user['status_pendaftaran'],

            'tahap_aktif' =>
            $tahapAktif
         ],
         409
      );
   }


   /**
    * -----------------------------------------------------
    * SUDAH DITERIMA
    * -----------------------------------------------------
    */

   if (
      $statusDaftarUlang === 'DITERIMA'
   ) {

      responseJson(
         false,
         'Daftar ulang Anda sudah diterima.',
         [
            'id' =>
            (int) $user['id'],

            'register_uid' =>
            $user['register_uid'],

            'status_daftar_ulang' =>
            'DITERIMA',

            'status_pendaftaran' =>
            $user['status_pendaftaran'],

            'tahap_aktif' =>
            $tahapAktif
         ],
         409
      );
   }


   /**
    * -----------------------------------------------------
    * VALIDASI STATUS
    * -----------------------------------------------------
    *
    * Hanya dua status yang boleh masuk ke proses update:
    *
    * BELUM_DIAJUKAN
    * DITOLAK
    *
    * -----------------------------------------------------
    */

   if (
      !in_array(
         $statusDaftarUlang,
         [
            'BELUM_DIAJUKAN',
            'DITOLAK'
         ],
         true
      )
   ) {

      responseJson(
         false,
         'Status daftar ulang saat ini tidak dapat diproses.',
         [
            'status_daftar_ulang' =>
            $statusDaftarUlang
         ],
         409
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
    * UPDATE DAFTAR ULANG
    * =====================================================
    *
    * PENTING:
    *
    * - Tidak mengubah tahap_aktif.
    * - Status kelulusan tetap LULUS.
    * - status_pendaftaran menjadi DAFTAR_ULANG.
    * - status_daftar_ulang menjadi DIAJUKAN.
    *
    * =====================================================
    */

   $stmt = $pdo->prepare("

        UPDATE register_pmb

        SET

            status_daftar_ulang = 'DIAJUKAN',

            status_pendaftaran = 'DAFTAR_ULANG',

            updated_at = NOW()

        WHERE id = :id

        AND status_kelulusan = 'LULUS'

        AND (
            status_daftar_ulang IS NULL
            OR status_daftar_ulang = ''
            OR status_daftar_ulang = 'BELUM_DIAJUKAN'
            OR status_daftar_ulang = 'DITOLAK'
        )

        LIMIT 1

    ");


   $stmt->execute(
      [
         'id' => $userId
      ]
   );


   /**
    * =====================================================
    * CEK UPDATE
    * =====================================================
    */

   if (
      $stmt->rowCount() < 1
   ) {

      if (
         $pdo->inTransaction()
      ) {

         $pdo->rollBack();
      }


      /**
       * Ambil ulang status untuk mengetahui
       * apakah ada perubahan status oleh proses lain.
       */

      $checkStmt =
         $pdo->prepare("

                SELECT

                    status_kelulusan,
                    status_daftar_ulang,
                    status_pendaftaran,
                    tahap_aktif

                FROM register_pmb

                WHERE id = :id

                LIMIT 1

            ");


      $checkStmt->execute(
         [
            'id' => $userId
         ]
      );


      $current =
         $checkStmt->fetch(
            PDO::FETCH_ASSOC
         );


      if (!$current) {

         responseJson(
            false,
            'Data peserta tidak ditemukan.',
            [],
            404
         );
      }


      $currentStatus =
         strtoupper(
            trim(
               $current['status_daftar_ulang']
                  ?? ''
            )
         );


      if (
         $currentStatus === 'DIAJUKAN'
      ) {

         responseJson(
            false,
            'Daftar ulang sudah diajukan dan sedang menunggu verifikasi panitia.',
            [
               'status_daftar_ulang' =>
               'DIAJUKAN'
            ],
            409
         );
      }


      responseJson(
         false,
         'Data daftar ulang tidak berhasil diperbarui.',
         [
            'status_kelulusan' =>
            $current['status_kelulusan'],

            'status_daftar_ulang' =>
            $current['status_daftar_ulang'],

            'status_pendaftaran' =>
            $current['status_pendaftaran'],

            'tahap_aktif' =>
            (int) $current['tahap_aktif']
         ],
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
    * SUCCESS RESPONSE
    * =====================================================
    */

   responseJson(
      true,
      'Pengajuan daftar ulang berhasil dikirim. Silakan menunggu verifikasi panitia.',
      [
         'id' =>
         (int) $user['id'],

         'fullname' =>
         $user['fullname'],

         'register_uid' =>
         $user['register_uid'],

         'status_kelulusan' =>
         'LULUS',

         'status_daftar_ulang' =>
         'DIAJUKAN',

         'status_pendaftaran' =>
         'DAFTAR_ULANG',

         /**
          * Tahap database tidak diubah.
          * Jika sebelumnya 5, tetap 5.
          */
         'tahap_aktif' =>
         $tahapAktif,

         'redirect' =>
         null
      ],
      200
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


   /**
    * =====================================================
    * ERROR LOG
    * =====================================================
    */

   error_log(
      'AJUKAN DAFTAR ULANG PDO ERROR: ' .
         $e->getMessage()
   );


   responseJson(
      false,
      'Terjadi kesalahan saat mengajukan daftar ulang.',
      [],
      500
   );
} catch (
   Throwable $e
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


   /**
    * =====================================================
    * ERROR LOG
    * =====================================================
    */

   error_log(
      'AJUKAN DAFTAR ULANG ERROR: ' .
         $e->getMessage()
   );


   responseJson(
      false,
      'Terjadi kesalahan sistem saat mengajukan daftar ulang.',
      [],
      500
   );
}
