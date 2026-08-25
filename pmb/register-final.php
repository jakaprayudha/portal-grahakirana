<?php

session_start();

require_once '../config/connect.php';


/**
 * =========================================================
 * AUTHENTICATION
 * =========================================================
 */

if (
   empty($_SESSION['pmb_logged_in']) ||
   empty($_SESSION['pmb_user_id'])
) {

   header('Location: ./login-pmb.php');
   exit;
}


$userId = (int) $_SESSION['pmb_user_id'];


/**
 * =========================================================
 * AMBIL DATA PESERTA
 * =========================================================
 */

$stmt = $pdo->prepare("

    SELECT

        id,
        fullname,
        gender,
        place,
        datebirth,

        number_id,
        phone_number,
        email_register,

        register_uid,
        register_type,

        register_pmb.id_program,
        id_provider,

        tahap_aktif,
        status_pendaftaran,
        status_daftar_ulang,

        nilai_tpa,
        nilai_wawancara,
        nilai_akhir,

        account_status,

        created_at,
        updated_at,
        ms_program_studi.program_name,
        ms_program_studi.program_degree

    FROM register_pmb
      LEFT JOIN ms_program_studi ON ms_program_studi.id_program = register_pmb.id_program


    WHERE id = :id

    LIMIT 1

");


$stmt->execute([
   'id' => $userId
]);


$pmbUser = $stmt->fetch(
   PDO::FETCH_ASSOC
);


/**
 * =========================================================
 * USER TIDAK DITEMUKAN
 * =========================================================
 */

if (!$pmbUser) {

   session_destroy();

   header('Location: ./login-pmb.php');

   exit;
}


/**
 * =========================================================
 * GUARD TAHAP
 * =========================================================
 *
 * Tahap 06 = Pengumuman
 *
 */

$tahapAktif =
   (int) (
      $pmbUser['tahap_aktif']
      ?? 1
   );


if ($tahapAktif < 6) {

   header('Location: ./welcome');

   exit;
}


/**
 * =========================================================
 * DATA PESERTA
 * =========================================================
 */

$namaPeserta =
   trim(
      $pmbUser['fullname'] ?? ''
   );

if ($namaPeserta === '') {

   $namaPeserta = '-';
}


$idPendaftaran =
   trim(
      $pmbUser['register_uid'] ?? ''
   );

if ($idPendaftaran === '') {

   $idPendaftaran = '-';
}


$jalur =
   trim(
      $pmbUser['register_type'] ?? ''
   );

if ($jalur === '') {

   $jalur = '-';
}


/**
 * =========================================================
 * NORMALISASI JALUR
 * =========================================================
 */

$jalurDisplay = $jalur;

switch (strtoupper($jalur)) {

   case '01':
      $jalurDisplay = 'Reguler';
      break;

   case '02':
      $jalurDisplay = 'Prestasi';
      break;

   case '03':
      $jalurDisplay = 'Beasiswa';
      break;
}


/**
 * =========================================================
 * PROGRAM STUDI
 * =========================================================
 *
 * Untuk sementara menggunakan id_program.
 *
 * Jika nanti tabel master program studi sudah tersedia,
 * bagian ini bisa langsung diganti JOIN.
 *
 */

$programStudi = '-';

if (
   !empty($pmbUser['id_program'])
) {

   $programStudi =
      $pmbUser['program_degree'] . " - " . $pmbUser['program_name'];
}


/**
 * =========================================================
 * TAHUN AKADEMIK
 * =========================================================
 */

$tahunPmb = '2026/2027';


/**
 * =========================================================
 * STATUS KELULUSAN
 * =========================================================
 */

$statusKelulusan =
   strtoupper(
      trim(
         $pmbUser['status_pendaftaran']
            ?? ''
      )
   );


/**
 * =========================================================
 * STATUS DAFTAR ULANG
 * =========================================================
 */

$statusDaftarUlang =
   strtoupper(
      trim(
         $pmbUser['status_daftar_ulang']
            ?? 'BELUM_DIAJUKAN'
      )
   );


/**
 * =========================================================
 * STATUS DISPLAY
 * =========================================================
 */

$statusDaftarUlangDisplay =
   'Belum Diajukan';


switch ($statusDaftarUlang) {

   case 'DIAJUKAN':

      $statusDaftarUlangDisplay =
         'Sedang Diproses';

      break;


   case 'DIVERIFIKASI':

      $statusDaftarUlangDisplay =
         'Sedang Diverifikasi';

      break;


   case 'DITERIMA':

      $statusDaftarUlangDisplay =
         'Diterima';

      break;


   case 'DITOLAK':

      $statusDaftarUlangDisplay =
         'Ditolak';

      break;
}


/**
 * =========================================================
 * STATUS LULUS
 * =========================================================
 */

$isLulus =
   ($statusKelulusan === 'LULUS');


$isTidakLulus =
   ($statusKelulusan === 'TIDAK_LULUS');


/**
 * =========================================================
 * NILAI
 * =========================================================
 */

$nilaiTPA =
   $pmbUser['nilai_tpa'];


$nilaiWawancara =
   $pmbUser['nilai_wawancara'];


$nilaiAkhir =
   $pmbUser['nilai_akhir'];


/**
 * =========================================================
 * FORMAT NILAI
 * =========================================================
 */

function formatNilai($nilai): string
{

   if (
      $nilai === null ||
      $nilai === ''
   ) {

      return '—';
   }


   return number_format(
      (float) $nilai,
      2,
      ',',
      '.'
   );
}


/**
 * =========================================================
 * TANGGAL PENGUMUMAN
 * =========================================================
 */

$tanggalPengumuman = '—';


if (
   !empty($pmbUser['updated_at'])
) {

   $timestamp =
      strtotime(
         $pmbUser['updated_at']
      );


   if ($timestamp !== false) {

      $tanggalPengumuman =
         date(
            'd/m/Y H:i',
            $timestamp
         );
   }
}


/**
 * =========================================================
 * LABEL HASIL
 * =========================================================
 */

if ($isLulus) {

   $resultTitle =
      'SELAMAT, ANDA LULUS!';

   $resultDescription =
      'Berdasarkan hasil seleksi Penerimaan Mahasiswa Baru, Anda dinyatakan LULUS dan berhak melanjutkan ke tahap daftar ulang.';

   $resultIcon =
      'uil-trophy';

   $resultIconColor =
      'text-primary';
} elseif ($isTidakLulus) {

   $resultTitle =
      'ANDA BELUM LULUS';

   $resultDescription =
      'Berdasarkan hasil seleksi Penerimaan Mahasiswa Baru, Anda dinyatakan belum lulus pada periode penerimaan ini.';

   $resultIcon =
      'uil-info-circle';

   $resultIconColor =
      'text-primary';
} else {

   $resultTitle =
      'HASIL SELEKSI BELUM TERSEDIA';

   $resultDescription =
      'Hasil seleksi Anda belum ditetapkan atau masih dalam proses pengumuman oleh panitia PMB.';

   $resultIcon =
      'uil-clock';

   $resultIconColor =
      'text-primary';
}


/**
 * =========================================================
 * PAGE
 * =========================================================
 */

$page =
   'Pengumuman Kelulusan PMB';

?>
<!DOCTYPE html>

<html lang="en">

<head>

   <base href="../">

   <?php
   require '../head.php';
   ?>

   <style>
      /* =========================================================
         PMB - TAHAP 06
         PENGUMUMAN KELULUSAN
      ========================================================= */

      .pmb-announcement-section {
         padding-top: 60px;
         padding-bottom: 80px;
      }

      .pmb-page-header {
         margin-bottom: 40px;
      }

      .pmb-page-header h2 {
         font-size: 2.5rem;
      }

      .pmb-participant-card {
         border: 0;
      }

      .pmb-participant-id {
         font-size: 13px;
         font-weight: 700;
         letter-spacing: .4px;
      }

      .pmb-result-hero {
         position: relative;
         overflow: hidden;
         border: 0;
      }

      .pmb-result-hero::before {
         content: "";
         position: absolute;
         width: 280px;
         height: 280px;
         border-radius: 50%;
         background: rgba(255, 255, 255, .07);
         right: -100px;
         top: -140px;
      }

      .pmb-result-hero::after {
         content: "";
         position: absolute;
         width: 180px;
         height: 180px;
         border-radius: 50%;
         background: rgba(255, 255, 255, .05);
         left: -90px;
         bottom: -90px;
      }

      .pmb-result-content {
         position: relative;
         z-index: 2;
      }

      .pmb-result-icon {
         width: 90px;
         height: 90px;
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         margin: 0 auto 25px;
         background: #fff;
      }

      .pmb-result-icon i {
         font-size: 42px;
      }

      .pmb-result-label {
         font-size: 13px;
         font-weight: 700;
         letter-spacing: 1px;
      }

      .pmb-result-title {
         font-size: 42px;
         font-weight: 700;
      }

      .pmb-result-name {
         font-size: 24px;
         font-weight: 600;
      }

      .pmb-detail-card {
         border: 0;
      }

      .pmb-detail-row {
         display: flex;
         align-items: flex-start;
         padding: 15px 0;
         border-bottom: 1px solid #edf0f3;
      }

      .pmb-detail-row:last-child {
         border-bottom: 0;
         padding-bottom: 0;
      }

      .pmb-detail-icon {
         width: 40px;
         height: 40px;
         min-width: 40px;
         border-radius: 9px;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-right: 13px;
      }

      .pmb-detail-label {
         color: #8a8f98;
         font-size: 12px;
         margin-bottom: 3px;
      }

      .pmb-detail-value {
         font-size: 14px;
         font-weight: 600;
      }

      .pmb-score-card {
         border: 1px solid #edf0f3;
         border-radius: 12px;
         padding: 22px 15px;
         text-align: center;
         height: 100%;
      }

      .pmb-score-value {
         font-size: 30px;
         font-weight: 700;
      }

      .pmb-score-label {
         font-size: 12px;
         color: #8a8f98;
         margin-top: 4px;
      }

      .pmb-status-pill {
         display: inline-flex;
         align-items: center;
         border-radius: 30px;
         padding: 8px 15px;
         font-size: 12px;
         font-weight: 700;
      }

      .pmb-next-card {
         border: 0;
      }

      .pmb-next-icon {
         width: 62px;
         height: 62px;
         min-width: 62px;
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-right: 20px;
      }

      .pmb-process {
         position: relative;
      }

      .pmb-process::before {
         content: "";
         position: absolute;
         left: 23px;
         top: 25px;
         bottom: 25px;
         width: 2px;
         background: #e8ecf1;
      }

      .pmb-process-item {
         display: flex;
         position: relative;
         z-index: 2;
         margin-bottom: 25px;
      }

      .pmb-process-item:last-child {
         margin-bottom: 0;
      }

      .pmb-process-number {
         width: 48px;
         height: 48px;
         min-width: 48px;
         border-radius: 50%;
         background: #fff;
         border: 2px solid #dfe4ea;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-right: 18px;
         color: #8a8f98;
         font-weight: 700;
      }

      .pmb-process-number.complete {
         background: #2b9a59;
         border-color: #2b9a59;
         color: #fff;
      }

      .pmb-process-number.active {
         background: #3f78e0;
         border-color: #3f78e0;
         color: #fff;
      }

      @media (max-width: 991.98px) {

         .pmb-announcement-section {
            padding-top: 50px;
            padding-bottom: 60px;
         }

         .pmb-page-header h2 {
            font-size: 2.2rem;
         }

         .pmb-result-title {
            font-size: 36px;
         }

         .pmb-process::before {
            display: none;
         }

      }

      @media (max-width: 767.98px) {

         .pmb-announcement-section {
            padding-top: 35px;
            padding-bottom: 50px;
         }

         .pmb-page-header {
            margin-bottom: 30px;
         }

         .pmb-page-header h2 {
            font-size: 1.8rem;
         }

         .pmb-page-header p {
            font-size: 14px;
            line-height: 1.6;
         }

         .pmb-participant-card .card-body {
            padding: 20px !important;
         }

         .pmb-result-hero .card-body {
            padding: 35px 20px !important;
         }

         .pmb-result-icon {
            width: 75px;
            height: 75px;
         }

         .pmb-result-icon i {
            font-size: 35px;
         }

         .pmb-result-title {
            font-size: 30px;
         }

         .pmb-result-name {
            font-size: 20px;
         }

         .pmb-detail-card .card-body {
            padding: 20px !important;
         }

         .pmb-score-value {
            font-size: 25px;
         }

         .pmb-next-icon {
            width: 52px;
            height: 52px;
            min-width: 52px;
            margin-right: 15px;
         }

      }

      @media (max-width: 575.98px) {

         .pmb-page-header h2 {
            font-size: 1.6rem;
         }

         .pmb-result-title {
            font-size: 27px;
         }

         .pmb-result-name {
            font-size: 18px;
         }

         .pmb-detail-row {
            display: block;
         }

         .pmb-detail-icon {
            margin-bottom: 10px;
         }

         .pmb-score-card {
            padding: 18px 10px;
         }

         .pmb-process-item {
            margin-bottom: 20px;
         }

         .pmb-process-number {
            width: 42px;
            height: 42px;
            min-width: 42px;
            margin-right: 12px;
         }

      }
   </style>

</head>


<body>

   <div class="content-wrapper">


      <?php
      require '../navbar.php';
      ?>


      <!-- =====================================================
        SECTION : TAHAP 06
   ====================================================== -->

      <section class="wrapper bg-light pmb-announcement-section">

         <div class="container">


            <!-- =================================================
              HEADER
         ================================================== -->

            <div class="row pmb-page-header">

               <div class="col-lg-9">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

                     TAHAP 06

                  </span>


                  <h2 class="display-4 mb-3">

                     Pengumuman Kelulusan

                  </h2>


                  <p class="lead fs-18 mb-0">

                     Lihat hasil akhir seleksi Penerimaan Mahasiswa Baru
                     dan informasi tahapan selanjutnya.

                  </p>

               </div>

            </div>


            <!-- =================================================
              PARTICIPANT
         ================================================== -->

            <div class="card shadow-sm pmb-participant-card mb-7">

               <div class="card-body p-5">

                  <div class="row align-items-center">


                     <div class="col-lg">

                        <div class="d-flex align-items-center">

                           <div class="icon btn btn-circle btn-lg btn-soft-primary me-4">

                              <i class="uil uil-user"></i>

                           </div>


                           <div>

                              <span class="text-uppercase text-muted fs-13 fw-bold">

                                 Peserta PMB

                              </span>


                              <h4 class="mb-1">

                                 <?= htmlspecialchars(
                                    $namaPeserta,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </h4>


                              <p class="mb-0 text-muted pmb-participant-id">

                                 ID Pendaftaran:

                                 <span class="text-primary">

                                    <?= htmlspecialchars(
                                       $idPendaftaran,
                                       ENT_QUOTES,
                                       'UTF-8'
                                    ) ?>

                                 </span>

                              </p>

                           </div>

                        </div>

                     </div>


                     <div class="col-lg-auto mt-4 mt-lg-0">

                        <span class="badge bg-soft-primary text-primary rounded-pill px-4 py-2">

                           <?= htmlspecialchars(
                              $jalurDisplay,
                              ENT_QUOTES,
                              'UTF-8'
                           ) ?>

                        </span>

                     </div>


                  </div>

               </div>

            </div>


            <!-- =================================================
              RESULT HERO
         ================================================== -->

            <div class="card bg-primary text-white shadow-lg pmb-result-hero mb-7">

               <div class="card-body p-6 p-md-8 text-center">

                  <div class="pmb-result-content">


                     <div class="pmb-result-icon <?= $resultIconColor ?>">

                        <i class="uil <?= $resultIcon ?>"></i>

                     </div>


                     <div class="pmb-result-label text-white opacity-75 text-uppercase mb-2">

                        HASIL SELEKSI PMB

                     </div>


                     <h1 class="pmb-result-title text-white mb-3">

                        <?= htmlspecialchars(
                           $resultTitle,
                           ENT_QUOTES,
                           'UTF-8'
                        ) ?>

                     </h1>


                     <div class="pmb-result-name text-white mb-4">

                        <?= htmlspecialchars(
                           $namaPeserta,
                           ENT_QUOTES,
                           'UTF-8'
                        ) ?>

                     </div>


                     <p class="text-white opacity-75 mb-0 mx-auto"
                        style="max-width:650px;">

                        <?= htmlspecialchars(
                           $resultDescription,
                           ENT_QUOTES,
                           'UTF-8'
                        ) ?>

                     </p>


                  </div>

               </div>

            </div>


            <!-- =================================================
              RESULT DETAIL
         ================================================== -->

            <div class="row gx-lg-8 gy-6">


               <!-- =================================================
                 LEFT
            ================================================== -->

               <div class="col-lg-8">


                  <!-- =================================================
                    DETAIL KELULUSAN
               ================================================== -->

                  <div class="card shadow-sm pmb-detail-card mb-6">

                     <div class="card-body p-5 p-md-6">


                        <div class="mb-6">

                           <span class="text-uppercase text-muted fs-13 fw-bold">

                              Detail Pengumuman

                           </span>


                           <h3 class="mt-2 mb-2">

                              Informasi Kelulusan

                           </h3>


                           <p class="text-muted mb-0">

                              Informasi resmi hasil seleksi peserta.

                           </p>

                        </div>


                        <!-- PROGRAM STUDI -->

                        <div class="pmb-detail-row">

                           <div class="pmb-detail-icon bg-soft-primary text-primary">

                              <i class="uil uil-graduation-cap"></i>

                           </div>


                           <div>

                              <div class="pmb-detail-label">

                                 Program Studi

                              </div>


                              <div class="pmb-detail-value">

                                 <?= htmlspecialchars(
                                    $programStudi,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <!-- JALUR -->

                        <div class="pmb-detail-row">

                           <div class="pmb-detail-icon bg-soft-green text-green">

                              <i class="uil uil-sign-alt"></i>

                           </div>


                           <div>

                              <div class="pmb-detail-label">

                                 Jalur Pendaftaran

                              </div>


                              <div class="pmb-detail-value">

                                 <?= htmlspecialchars(
                                    $jalurDisplay,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <!-- TAHUN -->

                        <div class="pmb-detail-row">

                           <div class="pmb-detail-icon bg-soft-yellow text-yellow">

                              <i class="uil uil-calendar-alt"></i>

                           </div>


                           <div>

                              <div class="pmb-detail-label">

                                 Tahun Akademik

                              </div>


                              <div class="pmb-detail-value">

                                 <?= htmlspecialchars(
                                    $tahunPmb,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <!-- STATUS -->

                        <div class="pmb-detail-row">

                           <div class="pmb-detail-icon bg-soft-green text-green">

                              <i class="uil uil-check-circle"></i>

                           </div>


                           <div>

                              <div class="pmb-detail-label">

                                 Status Kelulusan

                              </div>


                              <div class="pmb-detail-value <?= $isLulus ? 'text-green' : '' ?>">

                                 <?= htmlspecialchars(
                                    $statusKelulusan ?: 'BELUM DITETAPKAN',
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <!-- TANGGAL -->

                        <div class="pmb-detail-row">

                           <div class="pmb-detail-icon bg-soft-info text-info">

                              <i class="uil uil-clock"></i>

                           </div>


                           <div>

                              <div class="pmb-detail-label">

                                 Tanggal Pengumuman

                              </div>


                              <div class="pmb-detail-value">

                                 <?= htmlspecialchars(
                                    $tanggalPengumuman,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </div>

                           </div>

                        </div>


                     </div>

                  </div>


                  <!-- =================================================
                    NILAI
               ================================================== -->

                  <div class="card shadow-sm border-0 mb-6">

                     <div class="card-body p-5 p-md-6">


                        <div class="mb-6">

                           <span class="text-uppercase text-muted fs-13 fw-bold">

                              Rekapitulasi

                           </span>


                           <h3 class="mt-2 mb-2">

                              Hasil Penilaian

                           </h3>


                           <p class="text-muted mb-0">

                              Rekap nilai seleksi yang digunakan dalam
                              proses penetapan hasil.

                           </p>

                        </div>


                        <div class="row gx-3">


                           <!-- TPA -->

                           <div class="col-md-4 mb-3 mb-md-0">

                              <div class="pmb-score-card">

                                 <div class="pmb-score-value text-primary">

                                    <?= formatNilai($nilaiTPA) ?>

                                 </div>


                                 <div class="pmb-score-label">

                                    Nilai TPA

                                 </div>

                              </div>

                           </div>


                           <!-- WAWANCARA -->

                           <div class="col-md-4 mb-3 mb-md-0">

                              <div class="pmb-score-card">

                                 <div class="pmb-score-value text-green">

                                    <?= formatNilai($nilaiWawancara) ?>

                                 </div>


                                 <div class="pmb-score-label">

                                    Nilai Wawancara

                                 </div>

                              </div>

                           </div>


                           <!-- FINAL -->

                           <div class="col-md-4">

                              <div class="pmb-score-card">

                                 <div class="pmb-score-value text-primary">

                                    <?= formatNilai($nilaiAkhir) ?>

                                 </div>


                                 <div class="pmb-score-label">

                                    Nilai Akhir

                                 </div>

                              </div>

                           </div>


                        </div>


                        <div class="alert alert-primary alert-icon mt-5 mb-0">

                           <i class="uil uil-info-circle"></i>


                           <p class="mb-0 fs-14">

                              Nilai yang ditampilkan mengikuti kebijakan
                              publikasi hasil seleksi yang ditetapkan oleh
                              panitia PMB.

                           </p>

                        </div>


                     </div>

                  </div>


                  <!-- =================================================
                    NEXT STEP
               ================================================== -->

                  <?php if ($isLulus): ?>

                     <div class="card bg-soft-green border-0 pmb-next-card">

                        <div class="card-body p-5">


                           <div class="d-flex align-items-center">

                              <div class="pmb-next-icon bg-green text-white">

                                 <i class="uil uil-file-check-alt fs-25"></i>

                              </div>


                              <div class="flex-grow-1">

                                 <span class="text-uppercase text-muted fs-13 fw-bold">

                                    Tahap Berikutnya

                                 </span>


                                 <h4 class="mb-1">

                                    Daftar Ulang

                                 </h4>


                                 <p class="text-muted mb-0 fs-14">

                                    Lengkapi proses daftar ulang untuk
                                    mengonfirmasi penerimaan Anda sebagai
                                    mahasiswa baru.

                                 </p>

                              </div>

                           </div>


                           <hr class="my-5">


                           <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">


                              <span class="text-muted fs-13">

                                 <i class="uil uil-info-circle me-1"></i>

                                 Pastikan memperhatikan batas waktu daftar ulang.

                              </span>


                              <?php if ($statusDaftarUlang === 'DITERIMA'): ?>

                                 <span class="badge bg-soft-green text-green rounded-pill px-4 py-2">

                                    <i class="uil uil-check-circle me-1"></i>

                                    Daftar Ulang Diterima

                                 </span>

                              <?php elseif ($statusDaftarUlang === 'DIAJUKAN'): ?>

                                 <span class="badge bg-soft-primary text-primary rounded-pill px-4 py-2">

                                    <i class="uil uil-clock me-1"></i>

                                    Daftar Ulang Sedang Diproses

                                 </span>

                              <?php else: ?>

                                 <a
                                    href="./pmb/daftar-ulang.php"
                                    class="btn btn-primary rounded btn-icon btn-icon-end">

                                    Lanjut Daftar Ulang

                                    <i class="uil uil-arrow-right"></i>

                                 </a>

                              <?php endif; ?>


                           </div>


                        </div>

                     </div>

                  <?php endif; ?>


               </div>


               <!-- =================================================
                 RIGHT
            ================================================== -->

               <div class="col-lg-4">


                  <!-- =================================================
                    STATUS CARD
               ================================================== -->

                  <div class="card shadow-sm border-0 mb-6">

                     <div class="card-body p-6">


                        <span class="text-uppercase text-muted fs-13 fw-bold">

                           Status Anda

                        </span>


                        <h4 class="mt-2 mb-5">

                           Tahapan PMB

                        </h4>


                        <div class="pmb-process">


                           <?php

                           $steps = [

                              1 => [
                                 'title'  => 'Registrasi Akun',
                                 'desc'   => 'Akun berhasil dibuat'
                              ],

                              2 => [
                                 'title'  => 'Data & Dokumen',
                                 'desc'   => 'Data dan dokumen'
                              ],

                              3 => [
                                 'title'  => 'Kartu Peserta',
                                 'desc'   => 'Kartu peserta'
                              ],

                              4 => [
                                 'title'  => 'Jadwal Seleksi',
                                 'desc'   => 'Jadwal seleksi'
                              ],

                              5 => [
                                 'title'  => 'Seleksi',
                                 'desc'   => 'TPA & wawancara'
                              ],

                              6 => [
                                 'title'  => 'Pengumuman',
                                 'desc'   => 'Hasil seleksi'
                              ],

                              7 => [
                                 'title'  => 'Daftar Ulang',
                                 'desc'   => 'Pendaftaran ulang'
                              ]

                           ];


                           foreach (
                              $steps as $stepNo => $step
                           ):

                              if (
                                 $tahapAktif > $stepNo
                              ) {

                                 $stepClass =
                                    'complete';
                              } elseif (
                                 $tahapAktif === $stepNo
                              ) {

                                 $stepClass =
                                    'active';
                              } else {

                                 $stepClass =
                                    '';
                              }


                              $stepStatus =
                                 'Belum dimulai';


                              if (
                                 $tahapAktif > $stepNo
                              ) {

                                 $stepStatus =
                                    'Selesai';
                              } elseif (
                                 $tahapAktif === $stepNo
                              ) {

                                 $stepStatus =
                                    'Sedang berlangsung';
                              }


                              if (
                                 $stepNo === 6 &&
                                 $isLulus
                              ) {

                                 $stepStatus =
                                    'LULUS';
                              }


                              if (
                                 $stepNo === 7 &&
                                 $statusDaftarUlang === 'DIAJUKAN'
                              ) {

                                 $stepStatus =
                                    'Diajukan';
                              }


                              if (
                                 $stepNo === 7 &&
                                 $statusDaftarUlang === 'DITERIMA'
                              ) {

                                 $stepStatus =
                                    'Diterima';
                              }

                           ?>

                              <div class="pmb-process-item">

                                 <div class="pmb-process-number <?= $stepClass ?>">

                                    <?php if ($stepClass === 'complete'): ?>

                                       <i class="uil uil-check"></i>

                                    <?php else: ?>

                                       <?= $stepNo ?>

                                    <?php endif; ?>

                                 </div>


                                 <div>

                                    <h6 class="mb-1">

                                       <?= htmlspecialchars(
                                          $step['title'],
                                          ENT_QUOTES,
                                          'UTF-8'
                                       ) ?>

                                    </h6>


                                    <?php if (
                                       $stepNo === 6 &&
                                       $isLulus
                                    ): ?>

                                       <span class="badge bg-soft-green text-green rounded-pill">

                                          LULUS

                                       </span>

                                    <?php else: ?>

                                       <p class="text-muted fs-13 mb-0">

                                          <?= htmlspecialchars(
                                             $stepStatus,
                                             ENT_QUOTES,
                                             'UTF-8'
                                          ) ?>

                                       </p>

                                    <?php endif; ?>


                                 </div>

                              </div>

                           <?php endforeach; ?>


                        </div>

                     </div>

                  </div>


                  <!-- =================================================
                    IMPORTANT
               ================================================== -->

                  <div class="card bg-soft-yellow border-0 mb-6">

                     <div class="card-body p-6">


                        <div class="icon btn btn-circle btn-sm btn-soft-yellow mb-4">

                           <i class="uil uil-exclamation-triangle"></i>

                        </div>


                        <h4 class="mb-3">

                           Perhatikan

                        </h4>


                        <p class="text-muted fs-14 mb-4">

                           Status kelulusan harus diperhatikan bersama
                           informasi batas waktu daftar ulang yang akan
                           ditentukan oleh panitia.

                        </p>


                        <p class="text-muted fs-14 mb-0">

                           <strong>

                              Jangan melewati batas waktu daftar ulang.

                           </strong>

                        </p>


                     </div>

                  </div>


                  <!-- =================================================
                    CONTACT
               ================================================== -->

                  <div class="card bg-soft-primary border-0">

                     <div class="card-body p-6">


                        <div class="icon btn btn-circle btn-sm btn-soft-primary mb-4">

                           <i class="uil uil-headphones"></i>

                        </div>


                        <h4 class="mb-2">

                           Butuh Bantuan?

                        </h4>


                        <p class="text-muted fs-14 mb-4">

                           Hubungi panitia PMB jika terdapat pertanyaan
                           mengenai hasil seleksi atau proses daftar ulang.

                        </p>


                        <a
                           href="https://wa.me/6281367969843"
                           target="_blank"
                           rel="noopener"
                           class="btn btn-sm btn-outline-primary rounded">

                           Hubungi Panitia

                           <i class="uil uil-arrow-right ms-1"></i>

                        </a>


                     </div>

                  </div>


               </div>


            </div>


            <!-- =================================================
              FOOTER ACTION
         ================================================== -->

            <?php if ($isLulus): ?>

               <div class="row mt-8">

                  <div class="col-lg-10 mx-auto">

                     <div class="card bg-soft-primary border-0">

                        <div class="card-body p-5">

                           <div class="row align-items-center">


                              <div class="col-lg">

                                 <div class="d-flex align-items-center">

                                    <div class="icon btn btn-circle btn-lg btn-primary me-4">

                                       <i class="uil uil-file-check-alt"></i>

                                    </div>


                                    <div>

                                       <span class="text-uppercase text-muted fs-13 fw-bold">

                                          Tahap Berikutnya

                                       </span>


                                       <h4 class="mb-1">

                                          Daftar Ulang Mahasiswa Baru

                                       </h4>


                                       <p class="mb-0 text-muted">

                                          Lanjutkan ke proses daftar ulang
                                          untuk menyelesaikan penerimaan mahasiswa baru.

                                       </p>

                                    </div>

                                 </div>

                              </div>


                              <div class="col-lg-auto mt-4 mt-lg-0">


                                 <?php if ($statusDaftarUlang === 'DIAJUKAN'): ?>

                                    <span class="badge bg-soft-primary text-primary rounded-pill px-4 py-2">

                                       <i class="uil uil-clock me-1"></i>

                                       Sedang Diproses

                                    </span>


                                 <?php elseif ($statusDaftarUlang === 'DITERIMA'): ?>

                                    <span class="badge bg-soft-green text-green rounded-pill px-4 py-2">

                                       <i class="uil uil-check-circle me-1"></i>

                                       Diterima

                                    </span>


                                 <?php else: ?>

                                    <a
                                       href="./pmb/daftar-ulang.php"
                                       class="btn btn-primary rounded btn-icon btn-icon-end">

                                       Daftar Ulang Sekarang

                                       <i class="uil uil-arrow-right"></i>

                                    </a>

                                 <?php endif; ?>


                              </div>


                           </div>

                        </div>

                     </div>

                  </div>

               </div>

            <?php endif; ?>


         </div>

      </section>


   </div>


   <!-- =========================================================
     FOOTER
========================================================== -->

   <?php
   require '../footer2.php';
   ?>


   <!-- =========================================================
     PROGRESS
========================================================== -->

   <div class="progress-wrap">

      <svg
         class="progress-circle svg-content"
         width="100%"
         height="100%"
         viewBox="-1 -1 102 102">

         <path
            d="M50,1 a49,49 0,0,1 0,98 a49,49 0,0,1 0,-98" />

      </svg>

   </div>


   <!-- =========================================================
     JS
========================================================== -->

   <script src="./assets/js/plugins.js"></script>

   <script src="./assets/js/theme.js"></script>

</body>

</html>