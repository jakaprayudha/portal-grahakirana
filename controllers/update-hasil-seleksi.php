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
   empty($_SESSION['admin_logged_in']) ||
   $_SESSION['admin_logged_in'] !== true ||
   empty($_SESSION['admin_user_id'])
) {

   http_response_code(401);

   responseJson(
      false,
      'Sesi admin telah berakhir.'
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
 * GET INPUT
 * =========================================================
 */

$id = filter_input(
   INPUT_POST,
   'id',
   FILTER_VALIDATE_INT
);


$nilaiTpa =
   $_POST['nilai_tpa']
   ?? null;


$nilaiWawancara =
   $_POST['nilai_wawancara']
   ?? null;


$catatanHasil =
   trim(
      $_POST['catatan_hasil']
         ?? ''
   );


/**
 * =========================================================
 * VALIDATION ID
 * =========================================================
 */

if (
   !$id ||
   $id < 1
) {

   responseJson(
      false,
      'ID peserta tidak valid.'
   );
}


/**
 * =========================================================
 * VALIDATION NILAI TPA
 * =========================================================
 */

if (
   $nilaiTpa === null ||
   $nilaiTpa === '' ||
   !is_numeric($nilaiTpa)
) {

   responseJson(
      false,
      'Nilai TPA wajib diisi.'
   );
}


/**
 * =========================================================
 * VALIDATION NILAI WAWANCARA
 * =========================================================
 */

if (
   $nilaiWawancara === null ||
   $nilaiWawancara === '' ||
   !is_numeric($nilaiWawancara)
) {

   responseJson(
      false,
      'Nilai wawancara wajib diisi.'
   );
}


/**
 * =========================================================
 * CONVERT NILAI
 * =========================================================
 */

$nilaiTpa =
   (float) $nilaiTpa;


$nilaiWawancara =
   (float) $nilaiWawancara;


/**
 * =========================================================
 * RANGE NILAI
 * =========================================================
 */

if (
   $nilaiTpa < 0 ||
   $nilaiTpa > 100
) {

   responseJson(
      false,
      'Nilai TPA harus berada antara 0 sampai 100.'
   );
}


if (
   $nilaiWawancara < 0 ||
   $nilaiWawancara > 100
) {

   responseJson(
      false,
      'Nilai wawancara harus berada antara 0 sampai 100.'
   );
}


/**
 * =========================================================
 * NILAI AKHIR
 * =========================================================
 *
 * Bobot:
 *
 * TPA       = 50%
 * Wawancara = 50%
 *
 */

$nilaiAkhir =
   (
      $nilaiTpa * 0.50
   )
   +
   (
      $nilaiWawancara * 0.50
   );


$nilaiAkhir =
   round(
      $nilaiAkhir,
      2
   );


/**
 * =========================================================
 * PENENTUAN KELULUSAN OTOMATIS
 * =========================================================
 *
 * Nilai akhir >= 75
 *      -> LULUS
 *
 * Nilai akhir < 75
 *      -> TIDAK_LULUS
 *
 */

if (
   $nilaiAkhir >= 75
) {

   $statusKelulusan =
      'LULUS';

   $statusPendaftaran =
      'LULUS';
} else {

   $statusKelulusan =
      'TIDAK_LULUS';

   $statusPendaftaran =
      'TIDAK_LULUS';
}


/**
 * =========================================================
 * TAHAP AKTIF
 * =========================================================
 *
 * Setelah hasil seleksi diproses,
 * peserta masuk tahap 05.
 *
 */

$tahapAktif = 5;


/**
 * =========================================================
 * FORMAT NILAI DATABASE
 * =========================================================
 */

$nilaiTpaDb =
   number_format(
      $nilaiTpa,
      2,
      '.',
      ''
   );


$nilaiWawancaraDb =
   number_format(
      $nilaiWawancara,
      2,
      '.',
      ''
   );


$nilaiAkhirDb =
   number_format(
      $nilaiAkhir,
      2,
      '.',
      ''
   );


/**
 * =========================================================
 * CEK PESERTA
 * =========================================================
 */

$stmt = $pdo->prepare("

    SELECT
        id,
        fullname,
        tahap_aktif,
        status_pendaftaran

    FROM register_pmb

    WHERE id = :id

    LIMIT 1

");


$stmt->execute(
   [
      'id' => $id
   ]
);


$peserta =
   $stmt->fetch(
      PDO::FETCH_ASSOC
   );


if (!$peserta) {

   responseJson(
      false,
      'Data peserta tidak ditemukan.'
   );
}


/**
 * =========================================================
 * UPDATE DATABASE
 * =========================================================
 */

try {

   $pdo->beginTransaction();


   $stmt =
      $pdo->prepare("

         UPDATE register_pmb

         SET

            nilai_tpa =
               :nilai_tpa,

            nilai_wawancara =
               :nilai_wawancara,

            nilai_akhir =
               :nilai_akhir,

            status_kelulusan =
               :status_kelulusan,

            status_pendaftaran =
               :status_pendaftaran,

            tahap_aktif =
               :tahap_aktif,

            catatan_hasil =
               :catatan_hasil,

            hasil_diumumkan_at =
               NOW(),

            updated_at =
               NOW()

         WHERE id = :id

         LIMIT 1

      ");


   $stmt->execute(
      [

         'nilai_tpa' =>
         $nilaiTpaDb,

         'nilai_wawancara' =>
         $nilaiWawancaraDb,

         'nilai_akhir' =>
         $nilaiAkhirDb,

         'status_kelulusan' =>
         $statusKelulusan,

         'status_pendaftaran' =>
         $statusPendaftaran,

         'tahap_aktif' =>
         $tahapAktif,

         'catatan_hasil' =>
         $catatanHasil !== ''
            ? $catatanHasil
            : null,

         'id' =>
         $id

      ]
   );


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

      'Hasil seleksi berhasil disimpan.',

      [

         'id' =>
         $id,

         'fullname' =>
         $peserta['fullname'],

         'nilai_tpa' =>
         $nilaiTpaDb,

         'nilai_wawancara' =>
         $nilaiWawancaraDb,

         'nilai_akhir' =>
         $nilaiAkhirDb,

         'batas_kelulusan' =>
         '75.00',

         'status_kelulusan' =>
         $statusKelulusan,

         'status_pendaftaran' =>
         $statusPendaftaran,

         'tahap_aktif' =>
         $tahapAktif,

         'hasil_diumumkan_at' =>
         date('Y-m-d H:i:s')

      ]
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
      'UPDATE HASIL SELEKSI ERROR: ' .
         $e->getMessage()
   );


   http_response_code(500);


   responseJson(
      false,
      'Gagal menyimpan hasil seleksi.'
   );
}
