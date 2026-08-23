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
 * GET DATA PESERTA
 * =========================================================
 */

$stmt = $pdo->prepare("

    SELECT

        id,
        fullname,
        gender,
        agama,
        ukuran_baju,

        place,
        datebirth,

        number_id,
        phone_number,
        email_register,

        register_uid,
        register_type,

        id_program,
        id_provider,

        tahap_aktif,
        status_pendaftaran,

        nilai_tpa,
        nilai_wawancara,
        nilai_akhir,

        status_kelulusan,
        catatan_hasil,
        hasil_diumumkan_at,

        jenis_pembiayaan,

        nim,
        siakad_status,
        ktm_status,
        krs_status,

        account_status,

        created_at,
        updated_at

    FROM register_pmb

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
 * GUARD MAHASISWA
 * =========================================================
 *
 * Halaman SIAKAD hanya bisa diakses apabila:
 *
 * status_pendaftaran = MAHASISWA
 *
 */

$statusPendaftaran =
   strtoupper(
      trim(
         $pmbUser['status_pendaftaran'] ?? ''
      )
   );


if (
   $statusPendaftaran !== 'MAHASISWA'
) {

   header('Location: ./welcome.php');

   exit;
}


/**
 * =========================================================
 * DATA DISPLAY
 * =========================================================
 */

$namaMahasiswa =
   trim(
      $pmbUser['fullname'] ?? ''
   );


if ($namaMahasiswa === '') {

   $namaMahasiswa = '-';
}


$nim =
   trim(
      $pmbUser['nim'] ?? ''
   );


if ($nim === '') {

   $nim = 'Belum diterbitkan';
}


$idPendaftaran =
   trim(
      $pmbUser['register_uid'] ?? ''
   );


if ($idPendaftaran === '') {

   $idPendaftaran = '-';
}


/**
 * =========================================================
 * PROGRAM STUDI
 * =========================================================
 *
 * Sementara menampilkan ID program.
 *
 * Jika tabel master program sudah ada,
 * bagian ini tinggal diganti JOIN.
 *
 */

$programStudi = '-';


if (
   !empty($pmbUser['id_program'])
) {

   $programStudi =
      'Program Studi #' .
      $pmbUser['id_program'];
}


/**
 * =========================================================
 * TAHUN ANGKATAN
 * =========================================================
 */

$tahunAngkatan = date(
   'Y',
   strtotime(
      $pmbUser['created_at']
   )
);


/**
 * =========================================================
 * STATUS SIAKAD
 * =========================================================
 */

$siakadStatus =
   strtoupper(
      trim(
         $pmbUser['siakad_status']
            ?? 'BELUM_AKTIVASI'
      )
   );


$siakadAktif =
   $siakadStatus === 'AKTIF';


/**
 * =========================================================
 * STATUS KTM
 * =========================================================
 */

$ktmStatus =
   strtoupper(
      trim(
         $pmbUser['ktm_status']
            ?? 'BELUM_TERBIT'
      )
   );


$ktmTerbit =
   $ktmStatus === 'TERBIT';


/**
 * =========================================================
 * STATUS KRS
 * =========================================================
 */

$krsStatus =
   strtoupper(
      trim(
         $pmbUser['krs_status']
            ?? 'BELUM_DIBUKA'
      )
   );


/**
 * =========================================================
 * LABEL STATUS SIAKAD
 * =========================================================
 */

if ($siakadAktif) {

   $siakadLabel =
      'Aktif';

   $siakadBadge =
      'bg-soft-green text-green';
} else {

   $siakadLabel =
      'Menunggu Aktivasi';

   $siakadBadge =
      'bg-soft-yellow text-yellow';
}


/**
 * =========================================================
 * LABEL KTM
 * =========================================================
 */

if ($ktmTerbit) {

   $ktmLabel =
      'Sudah Terbit';

   $ktmBadge =
      'bg-soft-green text-green';
} else {

   $ktmLabel =
      'Belum Terbit';

   $ktmBadge =
      'bg-soft-yellow text-yellow';
}


/**
 * =========================================================
 * LABEL KRS
 * =========================================================
 */

switch ($krsStatus) {

   case 'DIBUKA':

      $krsLabel =
         'Sudah Dibuka';

      $krsBadge =
         'bg-soft-primary text-primary';

      break;


   case 'SUDAH_DIISI':

      $krsLabel =
         'Sudah Diisi';

      $krsBadge =
         'bg-soft-green text-green';

      break;


   default:

      $krsLabel =
         'Belum Dibuka';

      $krsBadge =
         'bg-soft-yellow text-yellow';

      break;
}


/**
 * =========================================================
 * PROGRESS
 * =========================================================
 */

$progress = 1;


/**
 * Akun PMB
 */

$progress++;


/**
 * Status MAHASISWA
 */

if (
   $statusPendaftaran === 'MAHASISWA'
) {

   $progress++;
}


/**
 * SIAKAD aktif
 */

if ($siakadAktif) {

   $progress++;
}


/**
 * KTM terbit
 */

if ($ktmTerbit) {

   $progress++;
}


/**
 * KRS aktif/diisi
 */

if (
   $krsStatus === 'DIBUKA' ||
   $krsStatus === 'SUDAH_DIISI'
) {

   $progress++;
}


/**
 * Maksimum 3 agar sesuai UI sebelumnya.
 */

$progress =
   min(
      $progress,
      3
   );


/**
 * =========================================================
 * PAGE
 * =========================================================
 */

$page =
   'SIAKAD Mahasiswa';

?>
<!DOCTYPE html>

<html lang="id">

<head>

   <base href="../">

   <?php
   require '../head.php';
   ?>


   <style>
      /**
         * =====================================================
         * SIAKAD MAHASISWA
         * =====================================================
         */

      .siakad-hero {
         border: 0;
         overflow: hidden;
      }


      .siakad-status-card {
         border: 0;
      }


      .siakad-status-icon {

         width: 58px;
         height: 58px;

         border-radius: 50%;

         display: flex;

         align-items: center;
         justify-content: center;

         flex-shrink: 0;

      }


      .siakad-info-row {

         display: flex;

         align-items: center;

         padding: 14px 0;

         border-bottom: 1px solid #edf0f3;

      }


      .siakad-info-row:last-child {

         border-bottom: 0;

      }


      .siakad-info-icon {

         width: 42px;
         height: 42px;

         border-radius: 10px;

         display: flex;

         align-items: center;
         justify-content: center;

         margin-right: 14px;

         flex-shrink: 0;

      }


      .siakad-info-label {

         font-size: 12px;

         color: #8a8f98;

         margin-bottom: 3px;

      }


      .siakad-info-value {

         font-size: 14px;

         font-weight: 600;

      }


      .siakad-action-card {

         border: 1px solid #edf0f3;

         transition:
            transform .2s ease,
            box-shadow .2s ease;

      }


      .siakad-action-card:hover {

         transform: translateY(-3px);

         box-shadow:
            0 10px 30px rgba(0,
               0,
               0,
               .07);

      }


      .siakad-action-icon {

         width: 54px;
         height: 54px;

         border-radius: 12px;

         display: flex;

         align-items: center;
         justify-content: center;

         margin-bottom: 18px;

      }


      .siakad-progress {

         height: 8px;

         border-radius: 20px;

      }


      @media (max-width: 767.98px) {

         .siakad-info-row {

            align-items: flex-start;

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
         SECTION
    ====================================================== -->

      <section class="wrapper bg-light py-12">

         <div class="container">


            <!-- =================================================
                 HEADER
            ================================================== -->

            <div class="row mb-7">

               <div class="col-lg-9">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

                     SIAKAD MAHASISWA

                  </span>


                  <h2 class="display-4 mb-3">

                     Selamat Datang,
                     <?= htmlspecialchars(
                        $namaMahasiswa,
                        ENT_QUOTES,
                        'UTF-8'
                     ) ?>

                  </h2>


                  <p class="lead fs-18 mb-0">

                     Selamat! Anda telah resmi menjadi mahasiswa.
                     Kelola proses akademik Anda melalui Portal SIAKAD.

                  </p>

               </div>

            </div>


            <!-- =================================================
                 PROFILE CARD
            ================================================== -->

            <div class="card shadow-sm siakad-status-card mb-7">

               <div class="card-body p-5">

                  <div class="row align-items-center">


                     <!-- PROFILE -->

                     <div class="col-lg">

                        <div class="d-flex align-items-center">

                           <div class="icon btn btn-circle btn-lg btn-soft-primary me-4">

                              <i class="uil uil-graduation-cap"></i>

                           </div>


                           <div>

                              <span class="text-uppercase text-muted fs-13 fw-bold">

                                 Mahasiswa

                              </span>


                              <h4 class="mb-1">

                                 <?= htmlspecialchars(
                                    $namaMahasiswa,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </h4>


                              <p class="mb-0 text-muted">

                                 NIM:

                                 <span class="text-primary fw-bold">

                                    <?= htmlspecialchars(
                                       $nim,
                                       ENT_QUOTES,
                                       'UTF-8'
                                    ) ?>

                                 </span>

                              </p>

                           </div>

                        </div>

                     </div>


                     <!-- STATUS -->

                     <div class="col-lg-auto mt-4 mt-lg-0">

                        <span class="badge bg-soft-green text-green rounded-pill px-4 py-2">

                           <i class="uil uil-check-circle me-1"></i>

                           Mahasiswa Aktif

                        </span>

                     </div>


                  </div>

               </div>

            </div>


            <!-- =================================================
                 INFO
            ================================================== -->

            <div class="row gx-lg-8 gy-6 mb-7">


               <!-- =================================================
                     DATA MAHASISWA
                ================================================== -->

               <div class="col-lg-7">

                  <div class="card shadow-sm border-0 h-100">

                     <div class="card-body p-5 p-md-6">


                        <span class="text-uppercase text-muted fs-13 fw-bold">

                           Informasi Akademik

                        </span>


                        <h3 class="mt-2 mb-5">

                           Data Mahasiswa

                        </h3>


                        <!-- NIM -->

                        <div class="siakad-info-row">

                           <div class="siakad-info-icon bg-soft-primary text-primary">

                              <i class="uil uil-user-square"></i>

                           </div>


                           <div>

                              <div class="siakad-info-label">

                                 NIM

                              </div>


                              <div class="siakad-info-value">

                                 <?= htmlspecialchars(
                                    $nim,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <!-- NAMA -->

                        <div class="siakad-info-row">

                           <div class="siakad-info-icon bg-soft-green text-green">

                              <i class="uil uil-user"></i>

                           </div>


                           <div>

                              <div class="siakad-info-label">

                                 Nama Mahasiswa

                              </div>


                              <div class="siakad-info-value">

                                 <?= htmlspecialchars(
                                    $namaMahasiswa,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <!-- PROGRAM -->

                        <div class="siakad-info-row">

                           <div class="siakad-info-icon bg-soft-yellow text-yellow">

                              <i class="uil uil-graduation-cap"></i>

                           </div>


                           <div>

                              <div class="siakad-info-label">

                                 Program Studi

                              </div>


                              <div class="siakad-info-value">

                                 <?= htmlspecialchars(
                                    $programStudi,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <!-- ANGKATAN -->

                        <div class="siakad-info-row">

                           <div class="siakad-info-icon bg-soft-primary text-primary">

                              <i class="uil uil-calendar-alt"></i>

                           </div>


                           <div>

                              <div class="siakad-info-label">

                                 Tahun Angkatan

                              </div>


                              <div class="siakad-info-value">

                                 <?= htmlspecialchars(
                                    $tahunAngkatan,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <!-- ID PMB -->

                        <div class="siakad-info-row">

                           <div class="siakad-info-icon bg-soft-green text-green">

                              <i class="uil uil-ticket"></i>

                           </div>


                           <div>

                              <div class="siakad-info-label">

                                 ID Pendaftaran PMB

                              </div>


                              <div class="siakad-info-value">

                                 <?= htmlspecialchars(
                                    $idPendaftaran,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </div>

                           </div>

                        </div>


                     </div>

                  </div>

               </div>


               <!-- =================================================
                     PROGRESS
                ================================================== -->

               <div class="col-lg-5">

                  <div class="card shadow-sm border-0 h-100">

                     <div class="card-body p-5 p-md-6">


                        <span class="text-uppercase text-muted fs-13 fw-bold">

                           Status Proses

                        </span>


                        <h3 class="mt-2 mb-5">

                           Aktivasi Mahasiswa

                        </h3>


                        <!-- PROGRESS -->

                        <div class="d-flex justify-content-between mb-2">

                           <span class="fs-14">

                              Progress

                           </span>


                           <strong>

                              <?= $progress ?> / 3

                           </strong>

                        </div>


                        <div class="progress siakad-progress mb-5">

                           <div
                              class="progress-bar bg-primary"
                              role="progressbar"
                              style="width: <?= ($progress / 3) * 100 ?>%;">

                           </div>

                        </div>


                        <!-- STATUS SIAKAD -->

                        <div class="d-flex align-items-center mb-4">

                           <div class="icon btn btn-circle btn-sm btn-soft-primary me-3">

                              <i class="uil uil-key-skeleton"></i>

                           </div>


                           <div class="flex-grow-1">

                              <div class="fs-13 fw-bold">

                                 Aktivasi SIAKAD

                              </div>

                              <span class="badge <?= $siakadBadge ?> rounded-pill mt-1">

                                 <?= htmlspecialchars(
                                    $siakadLabel,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </span>

                           </div>

                        </div>


                        <!-- KTM -->

                        <div class="d-flex align-items-center mb-4">

                           <div class="icon btn btn-circle btn-sm btn-soft-green me-3">

                              <i class="uil uil-card-atm"></i>

                           </div>


                           <div class="flex-grow-1">

                              <div class="fs-13 fw-bold">

                                 Kartu Tanda Mahasiswa

                              </div>


                              <span class="badge <?= $ktmBadge ?> rounded-pill mt-1">

                                 <?= htmlspecialchars(
                                    $ktmLabel,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </span>

                           </div>

                        </div>


                        <!-- KRS -->

                        <div class="d-flex align-items-center">

                           <div class="icon btn btn-circle btn-sm btn-soft-yellow me-3">

                              <i class="uil uil-book-open"></i>

                           </div>


                           <div class="flex-grow-1">

                              <div class="fs-13 fw-bold">

                                 Kartu Rencana Studi

                              </div>


                              <span class="badge <?= $krsBadge ?> rounded-pill mt-1">

                                 <?= htmlspecialchars(
                                    $krsLabel,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </span>

                           </div>

                        </div>


                     </div>

                  </div>

               </div>


            </div>


            <!-- =================================================
                 ACTION
            ================================================== -->

            <div class="row gx-lg-6 gy-6">


               <!-- =================================================
                     AKTIVASI SIAKAD
                ================================================== -->

               <div class="col-lg-4">

                  <div class="card siakad-action-card h-100">

                     <div class="card-body p-5">


                        <div class="siakad-action-icon bg-soft-primary text-primary">

                           <i class="uil uil-key-skeleton fs-24"></i>

                        </div>


                        <span class="text-uppercase text-muted fs-13 fw-bold">

                           Tahap 01

                        </span>


                        <h4 class="mt-2 mb-3">

                           Aktivasi SIAKAD

                        </h4>


                        <?php if ($siakadAktif): ?>

                           <p class="text-muted fs-14 mb-4">

                              Akun SIAKAD Anda sudah aktif dan
                              dapat digunakan untuk mengakses
                              layanan akademik.

                           </p>


                           <span class="badge bg-soft-green text-green rounded-pill px-4 py-2">

                              <i class="uil uil-check-circle me-1"></i>

                              Akun Aktif

                           </span>

                        <?php else: ?>

                           <p class="text-muted fs-14 mb-4">

                              Aktivasi akun SIAKAD diperlukan
                              sebelum Anda dapat menggunakan
                              layanan akademik.

                           </p>


                           <a
                              href="./pmb/aktivasi-siakad.php"
                              class="btn btn-primary rounded btn-icon btn-icon-end">

                              Aktivasi Sekarang

                              <i class="uil uil-arrow-right"></i>

                           </a>

                        <?php endif; ?>


                     </div>

                  </div>

               </div>


               <!-- =================================================
                     KTM
                ================================================== -->

               <div class="col-lg-4">

                  <div class="card siakad-action-card h-100">

                     <div class="card-body p-5">


                        <div class="siakad-action-icon bg-soft-green text-green">

                           <i class="uil uil-card-atm fs-24"></i>

                        </div>


                        <span class="text-uppercase text-muted fs-13 fw-bold">

                           Tahap 02

                        </span>


                        <h4 class="mt-2 mb-3">

                           Kartu Tanda Mahasiswa

                        </h4>


                        <?php if ($ktmTerbit): ?>

                           <p class="text-muted fs-14 mb-4">

                              KTM Anda sudah diterbitkan
                              dan dapat digunakan sebagai
                              identitas mahasiswa.

                           </p>


                           <a
                              href="./pmb/ktm.php"
                              target="_blank"
                              class="btn btn-outline-primary rounded btn-icon btn-icon-end">

                              Lihat KTM

                              <i class="uil uil-arrow-right"></i>

                           </a>

                        <?php else: ?>

                           <p class="text-muted fs-14 mb-4">

                              KTM akan tersedia setelah
                              proses penerbitan selesai.

                           </p>


                           <span class="badge bg-soft-yellow text-yellow rounded-pill px-4 py-2">

                              Belum Terbit

                           </span>

                        <?php endif; ?>


                     </div>

                  </div>

               </div>


               <!-- =================================================
                     KRS
                ================================================== -->

               <div class="col-lg-4">

                  <div class="card siakad-action-card h-100">

                     <div class="card-body p-5">


                        <div class="siakad-action-icon bg-soft-yellow text-yellow">

                           <i class="uil uil-book-open fs-24"></i>

                        </div>


                        <span class="text-uppercase text-muted fs-13 fw-bold">

                           Tahap 03

                        </span>


                        <h4 class="mt-2 mb-3">

                           Kartu Rencana Studi

                        </h4>


                        <?php if (
                           $krsStatus === 'DIBUKA'
                        ): ?>

                           <p class="text-muted fs-14 mb-4">

                              Pengisian KRS sudah dibuka.
                              Silakan pilih mata kuliah
                              sesuai ketentuan akademik.

                           </p>


                           <a
                              href="./pmb/krs.php"
                              class="btn btn-primary rounded btn-icon btn-icon-end">

                              Isi KRS

                              <i class="uil uil-arrow-right"></i>

                           </a>


                        <?php elseif (
                           $krsStatus === 'SUDAH_DIISI'
                        ): ?>

                           <p class="text-muted fs-14 mb-4">

                              KRS Anda sudah diisi.

                           </p>


                           <a
                              href="./pmb/krs.php"
                              class="btn btn-outline-primary rounded btn-icon btn-icon-end">

                              Lihat KRS

                              <i class="uil uil-arrow-right"></i>

                           </a>


                        <?php else: ?>

                           <p class="text-muted fs-14 mb-4">

                              Pengisian KRS belum dibuka
                              oleh bagian akademik.

                           </p>


                           <span class="badge bg-soft-yellow text-yellow rounded-pill px-4 py-2">

                              Belum Dibuka

                           </span>

                        <?php endif; ?>


                     </div>

                  </div>

               </div>


            </div>


            <!-- =================================================
                 INFORMATION
            ================================================== -->

            <div class="row mt-7">

               <div class="col-lg-10 mx-auto">

                  <div class="card bg-soft-primary border-0">

                     <div class="card-body p-5">


                        <div class="d-flex align-items-start">


                           <div class="icon btn btn-circle btn-sm btn-soft-primary me-4 flex-shrink-0">

                              <i class="uil uil-info-circle"></i>

                           </div>


                           <div>

                              <h4 class="mb-2">

                                 Informasi Akademik

                              </h4>


                              <p class="text-muted fs-14 mb-0">

                                 Gunakan Portal SIAKAD untuk
                                 mengelola aktivitas akademik.
                                 Aktivasi akun, penerbitan KTM,
                                 dan pembukaan KRS mengikuti
                                 proses administrasi akademik.

                              </p>

                           </div>


                        </div>


                     </div>

                  </div>

               </div>

            </div>


         </div>

      </section>


   </div>


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


   <script src="./assets/js/plugins.js"></script>

   <script src="./assets/js/theme.js"></script>


</body>

</html>