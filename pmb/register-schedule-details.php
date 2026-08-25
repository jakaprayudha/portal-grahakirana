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
        register_uid,
        email_register,
        phone_number,
        tahap_aktif,
        status_pendaftaran,
        account_status
    FROM register_pmb
    WHERE id = :id
    LIMIT 1
");

$stmt->execute([
   'id' => $userId
]);

$pmbUser = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$pmbUser) {

   session_destroy();

   header('Location: ./login-pmb.php');

   exit;
}


/**
 * =========================================================
 * GUARD TAHAP 04
 * =========================================================
 */

if ((int) $pmbUser['tahap_aktif'] < 2) {

   header('Location: ./welcome');

   exit;
}


/**
 * =========================================================
 * AMBIL ID JADWAL
 * =========================================================
 */

$jadwalId =
   isset($_GET['id'])
   ? (int) $_GET['id']
   : 0;


if ($jadwalId <= 0) {

   header('Location: ./register-schedule.php');

   exit;
}


/**
 * =========================================================
 * TAHUN PMB
 * =========================================================
 */

$tahunPmb = '2026/2027';


/**
 * =========================================================
 * AMBIL DETAIL JADWAL
 * =========================================================
 */

$stmtJadwal = $pdo->prepare("

   SELECT
      id,
      nama_seleksi,
      kategori,
      tanggal,
      jam_mulai,
      jam_selesai,
      lokasi,
      ruangan,
      metode,
      keterangan,
      urutan,
      status,
      tahun_akademik

   FROM pmb_jadwal_seleksi

   WHERE id = :id
     AND tahun_akademik = :tahun_akademik

   LIMIT 1

");

$stmtJadwal->execute([
   'id' => $jadwalId,
   'tahun_akademik' => $tahunPmb
]);

$jadwal = $stmtJadwal->fetch(PDO::FETCH_ASSOC);


if (!$jadwal) {

   header('Location: ./register-schedule.php');

   exit;
}


/**
 * =========================================================
 * FORMAT TANGGAL
 * =========================================================
 */

$hariIndonesia = [

   'Sunday'    => 'Minggu',
   'Monday'    => 'Senin',
   'Tuesday'   => 'Selasa',
   'Wednesday' => 'Rabu',
   'Thursday'  => 'Kamis',
   'Friday'    => 'Jumat',
   'Saturday'  => 'Sabtu'

];

$bulanIndonesia = [

   'January'   => 'Januari',
   'February'  => 'Februari',
   'March'     => 'Maret',
   'April'     => 'April',
   'May'       => 'Mei',
   'June'      => 'Juni',
   'July'      => 'Juli',
   'August'    => 'Agustus',
   'September' => 'September',
   'October'   => 'Oktober',
   'November'  => 'November',
   'December'  => 'Desember'

];


$timestamp = strtotime($jadwal['tanggal']);

$hari =
   $hariIndonesia[date('l', $timestamp)]
   ?? date('l', $timestamp);

$bulan =
   $bulanIndonesia[date('F', $timestamp)]
   ?? date('F', $timestamp);


$tanggalLengkap =
   $hari .
   ', ' .
   date('d', $timestamp) .
   ' ' .
   $bulan .
   ' ' .
   date('Y', $timestamp);


$tanggalAngka = date('d', $timestamp);

$bulanPendek = date('M', $timestamp);


/**
 * =========================================================
 * FORMAT JAM
 * =========================================================
 */

$jamMulai =
   date(
      'H.i',
      strtotime($jadwal['jam_mulai'])
   );

$jamSelesai =
   date(
      'H.i',
      strtotime($jadwal['jam_selesai'])
   );

$waktu =
   $jamMulai .
   ' – ' .
   $jamSelesai .
   ' WIB';


/**
 * =========================================================
 * STATUS
 * =========================================================
 */

$statusJadwal =
   strtoupper($jadwal['status'] ?? '');


if ($statusJadwal === 'TERJADWAL') {

   $statusLabel = 'Terjadwal';
   $statusClass = 'bg-soft-green text-green';
   $statusIcon = 'uil-check-circle';
} elseif ($statusJadwal === 'SELESAI') {

   $statusLabel = 'Selesai';
   $statusClass = 'bg-soft-primary text-primary';
   $statusIcon = 'uil-check';
} else {

   $statusLabel =
      ucfirst(
         strtolower(
            $statusJadwal ?: 'Informasi'
         )
      );

   $statusClass = 'bg-soft-yellow text-yellow';
   $statusIcon = 'uil-clock';
}


/**
 * =========================================================
 * PAGE
 * =========================================================
 */

$page = 'Detail Seleksi PMB';

?>

<!DOCTYPE html>

<html lang="id">

<head>

   <base href="../">

   <?php

   $page = 'Detail Seleksi PMB';

   require '../head.php';

   ?>

   <style>
      /* =====================================================
         PMB DETAIL PAGE
      ===================================================== */

      .pmb-detail-section {

         padding-top: 45px;
         padding-bottom: 80px;

      }


      /* =====================================================
         BACK
      ===================================================== */

      .pmb-detail-header {

         margin-bottom: 25px;

      }


      .pmb-back-button {

         display: inline-flex;

         align-items: center;

         gap: 3px;

         font-weight: 600;

         padding: 9px 15px;

         transition: all .25s ease;

      }


      .pmb-back-button:hover {

         transform: translateX(-3px);

      }


      /* =====================================================
         PARTICIPANT
      ===================================================== */

      .pmb-participant-card {

         background: #fff;

         border: 1px solid rgba(0, 0, 0, .06);

         border-radius: 16px;

      }


      .pmb-participant-avatar {

         width: 50px;

         height: 50px;

         min-width: 50px;

         border-radius: 50%;

         display: flex;

         align-items: center;

         justify-content: center;

      }


      .pmb-participant-name {

         font-size: 17px;

         font-weight: 700;

      }


      /* =====================================================
         HERO
      ===================================================== */

      .pmb-detail-hero {

         position: relative;

         overflow: hidden;

         border: 0;

         border-radius: 20px;

         box-shadow:
            0 15px 45px rgba(38, 57, 77, .10);

      }


      .pmb-detail-hero-top {

         position: relative;

         padding: 38px;

         overflow: hidden;

      }


      .pmb-detail-hero-top::after {

         content: "";

         position: absolute;

         width: 240px;

         height: 240px;

         border-radius: 50%;

         background: rgba(255, 255, 255, .08);

         right: -80px;

         top: -100px;

      }


      .pmb-detail-hero-top::before {

         content: "";

         position: absolute;

         width: 150px;

         height: 150px;

         border-radius: 50%;

         background: rgba(255, 255, 255, .05);

         right: 100px;

         bottom: -90px;

      }


      .pmb-detail-hero-content {

         position: relative;

         z-index: 2;

      }


      .pmb-detail-icon {

         width: 70px;

         height: 70px;

         min-width: 70px;

         border-radius: 18px;

         display: flex;

         align-items: center;

         justify-content: center;

         box-shadow:
            0 10px 25px rgba(0, 0, 0, .08);

      }


      .pmb-detail-category {

         display: inline-flex;

         align-items: center;

         font-size: 12px;

         font-weight: 700;

         letter-spacing: .7px;

         text-transform: uppercase;

         opacity: .8;

      }


      .pmb-detail-title {

         font-size: 2.1rem;

         line-height: 1.2;

         font-weight: 700;

         margin: 8px 0;

      }


      .pmb-detail-year {

         font-size: 14px;

         opacity: .75;

      }


      .pmb-status-badge {

         display: inline-flex;

         align-items: center;

         white-space: nowrap;

         font-weight: 600;

      }


      /* =====================================================
         HERO DATE
      ===================================================== */

      .pmb-date-box {

         position: relative;

         z-index: 3;

         margin: -25px 30px 0;

         background: #fff;

         border-radius: 16px;

         padding: 18px 22px;

         box-shadow:
            0 10px 35px rgba(0, 0, 0, .08);

      }


      .pmb-date-number {

         font-size: 36px;

         line-height: 1;

         font-weight: 800;

      }


      .pmb-date-month {

         font-size: 12px;

         font-weight: 700;

         text-transform: uppercase;

         letter-spacing: .5px;

      }


      .pmb-date-text {

         font-size: 15px;

         font-weight: 600;

      }


      .pmb-date-time {

         font-size: 13px;

         color: #7d8490;

      }


      /* =====================================================
         INFORMATION CARDS
      ===================================================== */

      .pmb-info-card {

         height: 100%;

         padding: 20px;

         background: #fff;

         border: 1px solid rgba(0, 0, 0, .06);

         border-radius: 14px;

         transition:
            transform .25s ease,
            box-shadow .25s ease;

      }


      .pmb-info-card:hover {

         transform: translateY(-3px);

         box-shadow:
            0 12px 30px rgba(0, 0, 0, .07);

      }


      .pmb-info-icon {

         width: 42px;

         height: 42px;

         min-width: 42px;

         border-radius: 11px;

         display: flex;

         align-items: center;

         justify-content: center;

         margin-right: 13px;

      }


      .pmb-info-label {

         color: #8a919b;

         font-size: 11px;

         font-weight: 600;

         text-transform: uppercase;

         letter-spacing: .3px;

         margin-bottom: 4px;

      }


      .pmb-info-value {

         color: #343a40;

         font-size: 15px;

         line-height: 1.45;

         font-weight: 600;

         word-break: break-word;

      }


      /* =====================================================
         NOTE
      ===================================================== */

      .pmb-detail-note {

         position: relative;

         border: 1px solid rgba(63, 120, 224, .12);

         background: #f5f8fd;

         padding: 20px;

         border-radius: 14px;

      }


      .pmb-note-icon {

         width: 42px;

         height: 42px;

         min-width: 42px;

         border-radius: 11px;

         display: flex;

         align-items: center;

         justify-content: center;

      }


      /* =====================================================
         PREPARATION
      ===================================================== */

      .pmb-preparation-card {

         height: 100%;

         padding: 22px;

         background: #fff;

         border: 1px solid rgba(0, 0, 0, .06);

         border-radius: 14px;

         transition: all .25s ease;

      }


      .pmb-preparation-card:hover {

         transform: translateY(-3px);

         box-shadow:
            0 12px 30px rgba(0, 0, 0, .06);

      }


      .pmb-detail-check {

         width: 38px;

         height: 38px;

         min-width: 38px;

         border-radius: 11px;

         display: flex;

         align-items: center;

         justify-content: center;

         background: #edf8f1;

         color: #2b9a59;

         margin-bottom: 14px;

      }


      /* =====================================================
         ACTION
      ===================================================== */

      .pmb-contact-action {

         padding: 25px;

         border-radius: 18px;

         background: #fff;

         border: 1px solid rgba(0, 0, 0, .06);

         display: flex;

         justify-content: space-between;

         align-items: center;

         gap: 20px;

      }


      /* =====================================================
         MOBILE
      ===================================================== */

      @media (max-width: 991.98px) {

         .pmb-detail-hero-top {

            padding: 30px;

         }

         .pmb-detail-title {

            font-size: 1.8rem;

         }

      }


      @media (max-width: 767.98px) {

         .pmb-detail-section {

            padding-top: 25px;

            padding-bottom: 55px;

         }


         .pmb-detail-header {

            margin-bottom: 18px;

         }


         .pmb-back-button {

            width: 100%;

            justify-content: center;

         }


         .pmb-participant-card .card-body {

            padding: 18px !important;

         }


         .pmb-participant-name {

            font-size: 16px;

         }


         .pmb-participant-status {

            margin-top: 15px;

         }


         .pmb-detail-hero-top {

            padding: 25px 20px;

         }


         .pmb-detail-hero-top .d-flex {

            flex-wrap: wrap;

         }


         .pmb-detail-icon {

            width: 58px;

            height: 58px;

            min-width: 58px;

            border-radius: 15px;

            margin-right: 14px !important;

         }


         .pmb-detail-title {

            font-size: 1.45rem;

         }


         .pmb-detail-category {

            font-size: 10px;

         }


         .pmb-status-wrapper {

            width: 100%;

            margin-top: 18px;

         }


         .pmb-status-badge {

            width: 100%;

            justify-content: center;

         }


         .pmb-date-box {

            margin: -18px 15px 0;

            padding: 16px;

         }


         .pmb-date-number {

            font-size: 30px;

         }


         .pmb-date-text {

            font-size: 13px;

         }


         .pmb-info-card {

            padding: 17px;

         }


         .pmb-info-value {

            font-size: 14px;

         }


         .pmb-detail-note {

            padding: 17px;

         }


         .pmb-preparation-card {

            padding: 18px;

         }


         .pmb-contact-action {

            flex-direction: column;

            align-items: stretch;

            text-align: center;

            padding: 20px;

         }


         .pmb-contact-action .btn {

            width: 100%;

            justify-content: center;

         }

      }


      @media (max-width: 380px) {

         .pmb-detail-title {

            font-size: 1.3rem;

         }


         .pmb-detail-hero-top {

            padding: 22px 16px;

         }


         .pmb-date-box {

            margin-left: 10px;

            margin-right: 10px;

         }


         .pmb-info-card {

            padding: 15px;

         }

      }
   </style>

</head>


<body>

   <div class="content-wrapper">


      <!-- =====================================================
           NAVBAR
      ====================================================== -->

      <?php require '../navbar.php'; ?>


      <!-- =====================================================
           DETAIL SELEKSI
      ====================================================== -->

      <section class="wrapper bg-light pmb-detail-section">

         <div class="container">


            <!-- =================================================
                 BACK
            ================================================== -->

            <div class="pmb-detail-header">

               <a
                  href="javascript:history.back();"
                  class="btn btn-sm btn-outline-primary rounded pmb-back-button">

                  <i class="uil uil-arrow-left me-1"></i>

                  Kembali ke Jadwal Seleksi

               </a>

            </div>


            <!-- =================================================
                 PARTICIPANT
            ================================================== -->

            <div class="card pmb-participant-card shadow-sm mb-5">

               <div class="card-body p-4">

                  <div class="row align-items-center">


                     <div class="col-lg">

                        <div class="d-flex align-items-center">

                           <div
                              class="pmb-participant-avatar
                              bg-soft-primary
                              text-primary
                              me-3">

                              <i class="uil uil-user fs-22"></i>

                           </div>


                           <div>

                              <span
                                 class="text-uppercase text-muted fs-12 fw-bold">

                                 Peserta PMB

                              </span>


                              <div class="pmb-participant-name">

                                 <?= htmlspecialchars(
                                    $pmbUser['fullname'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </div>


                              <div class="text-muted fs-13">

                                 ID Pendaftaran:

                                 <strong class="text-primary">

                                    <?= htmlspecialchars(
                                       $pmbUser['register_uid'],
                                       ENT_QUOTES,
                                       'UTF-8'
                                    ) ?>

                                 </strong>

                              </div>

                           </div>

                        </div>

                     </div>


                     <div class="col-lg-auto pmb-participant-status mt-3 mt-lg-0">

                        <span
                           class="badge bg-soft-green text-green rounded-pill px-3 py-2">

                           <i class="uil uil-check-circle me-1"></i>

                           Peserta Aktif

                        </span>

                     </div>


                  </div>

               </div>

            </div>


            <!-- =================================================
                 HERO
            ================================================== -->

            <div class="pmb-detail-hero mb-6">


               <div
                  class="bg-primary text-white pmb-detail-hero-top">

                  <div class="pmb-detail-hero-content">

                     <div class="d-flex align-items-start">


                        <div
                           class="pmb-detail-icon
                           bg-white
                           text-primary
                           me-4">

                           <i class="uil uil-clipboard-alt fs-30"></i>

                        </div>


                        <div class="flex-grow-1">

                           <span class="pmb-detail-category">

                              <?= htmlspecialchars(
                                 $jadwal['kategori'] ?: 'Seleksi',
                                 ENT_QUOTES,
                                 'UTF-8'
                              ) ?>

                           </span>


                           <h1 class="pmb-detail-title text-white">

                              <?= htmlspecialchars(
                                 $jadwal['nama_seleksi'],
                                 ENT_QUOTES,
                                 'UTF-8'
                              ) ?>

                           </h1>


                           <div class="pmb-detail-year">

                              Tahun Akademik

                              <?= htmlspecialchars(
                                 $jadwal['tahun_akademik'],
                                 ENT_QUOTES,
                                 'UTF-8'
                              ) ?>

                           </div>

                        </div>


                        <div class="pmb-status-wrapper ms-3">

                           <span
                              class="badge
                              <?= $statusClass ?>
                              rounded-pill
                              px-3 py-2
                              pmb-status-badge">

                              <i
                                 class="uil
                                 <?= $statusIcon ?>
                                 me-1"></i>

                              <?= htmlspecialchars(
                                 $statusLabel,
                                 ENT_QUOTES,
                                 'UTF-8'
                              ) ?>

                           </span>

                        </div>


                     </div>

                  </div>

               </div>


               <!-- =================================================
                    DATE BOX
               ================================================== -->

               <div class="pmb-date-box">

                  <div class="row align-items-center">


                     <div class="col-auto">

                        <div class="pmb-date-number text-primary">

                           <?= htmlspecialchars(
                              $tanggalAngka,
                              ENT_QUOTES,
                              'UTF-8'
                           ) ?>

                        </div>

                        <div class="pmb-date-month text-primary">

                           <?= htmlspecialchars(
                              $bulan,
                              ENT_QUOTES,
                              'UTF-8'
                           ) ?>

                        </div>

                     </div>


                     <div class="col">

                        <div class="pmb-date-text">

                           <?= htmlspecialchars(
                              $tanggalLengkap,
                              ENT_QUOTES,
                              'UTF-8'
                           ) ?>

                        </div>


                        <div class="pmb-date-time mt-1">

                           <i class="uil uil-clock me-1"></i>

                           <?= htmlspecialchars(
                              $waktu,
                              ENT_QUOTES,
                              'UTF-8'
                           ) ?>

                        </div>

                     </div>

                  </div>

               </div>


               <!-- =================================================
                    INFORMATION
               ================================================== -->

               <div class="card-body p-4 p-md-6">


                  <div class="mb-5">

                     <span
                        class="text-uppercase text-muted fs-12 fw-bold">

                        Informasi Pelaksanaan

                     </span>

                     <h3 class="mt-2 mb-2">

                        Detail Jadwal Seleksi

                     </h3>

                     <p class="text-muted mb-0 fs-14">

                        Pastikan Anda memahami seluruh informasi
                        pelaksanaan sebelum mengikuti seleksi.

                     </p>

                  </div>


                  <div class="row gx-3 gy-3">


                     <!-- LOKASI -->

                     <div class="col-sm-6">

                        <div class="pmb-info-card">

                           <div class="d-flex align-items-start">

                              <div
                                 class="pmb-info-icon
                                 bg-soft-yellow
                                 text-yellow">

                                 <i class="uil uil-location-point"></i>

                              </div>

                              <div>

                                 <div class="pmb-info-label">

                                    Lokasi

                                 </div>

                                 <div class="pmb-info-value">

                                    <?= htmlspecialchars(
                                       $jadwal['lokasi'] ?: '-',
                                       ENT_QUOTES,
                                       'UTF-8'
                                    ) ?>

                                 </div>

                              </div>

                           </div>

                        </div>

                     </div>


                     <!-- RUANGAN -->

                     <div class="col-sm-6">

                        <div class="pmb-info-card">

                           <div class="d-flex align-items-start">

                              <div
                                 class="pmb-info-icon
                                 bg-soft-primary
                                 text-primary">

                                 <i class="uil uil-building"></i>

                              </div>

                              <div>

                                 <div class="pmb-info-label">

                                    Ruangan

                                 </div>

                                 <div class="pmb-info-value">

                                    <?= htmlspecialchars(
                                       $jadwal['ruangan'] ?: '-',
                                       ENT_QUOTES,
                                       'UTF-8'
                                    ) ?>

                                 </div>

                              </div>

                           </div>

                        </div>

                     </div>


                     <!-- METODE -->

                     <div class="col-sm-6">

                        <div class="pmb-info-card">

                           <div class="d-flex align-items-start">

                              <div
                                 class="pmb-info-icon
                                 bg-soft-primary
                                 text-primary">

                                 <i class="uil uil-monitor"></i>

                              </div>

                              <div>

                                 <div class="pmb-info-label">

                                    Metode

                                 </div>

                                 <div class="pmb-info-value">

                                    <?= htmlspecialchars(
                                       $jadwal['metode'] ?: '-',
                                       ENT_QUOTES,
                                       'UTF-8'
                                    ) ?>

                                 </div>

                              </div>

                           </div>

                        </div>

                     </div>


                     <!-- KATEGORI -->

                     <div class="col-sm-6">

                        <div class="pmb-info-card">

                           <div class="d-flex align-items-start">

                              <div
                                 class="pmb-info-icon
                                 bg-soft-green
                                 text-green">

                                 <i class="uil uil-tag-alt"></i>

                              </div>

                              <div>

                                 <div class="pmb-info-label">

                                    Kategori

                                 </div>

                                 <div class="pmb-info-value">

                                    <?= htmlspecialchars(
                                       $jadwal['kategori'] ?: '-',
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
                       INFORMATION NOTE
                  ================================================== -->

                  <div class="pmb-detail-note mt-4">

                     <div class="d-flex align-items-start">


                        <div
                           class="pmb-note-icon
                           bg-soft-primary
                           text-primary
                           me-3">

                           <i class="uil uil-info-circle fs-20"></i>

                        </div>


                        <div>

                           <span
                              class="text-uppercase text-muted fs-11 fw-bold">

                              Informasi Penting

                           </span>


                           <p class="text-muted mb-0 mt-1 fs-14">

                              <?= nl2br(
                                 htmlspecialchars(
                                    $jadwal['keterangan']
                                       ?: 'Tidak ada keterangan tambahan untuk jadwal ini.',
                                    ENT_QUOTES,
                                    'UTF-8'
                                 )
                              ) ?>

                           </p>

                        </div>


                     </div>

                  </div>


               </div>

            </div>


            <!-- =================================================
                 PERSIAPAN
            ================================================== -->

            <div class="mb-5">

               <span
                  class="text-uppercase text-muted fs-12 fw-bold">

                  Persiapan Peserta

               </span>


               <h3 class="mt-2 mb-2">

                  Yang Perlu Disiapkan

               </h3>


               <p class="text-muted fs-14">

                  Pastikan seluruh kebutuhan berikut sudah disiapkan
                  sebelum datang ke lokasi seleksi.

               </p>

            </div>


            <div class="row gx-3 gy-3 mb-6">


               <!-- KARTU -->

               <div class="col-md-6">

                  <div class="pmb-preparation-card">

                     <div class="pmb-detail-check">

                        <i class="uil uil-ticket fs-18"></i>

                     </div>


                     <h5 class="mb-2">

                        Kartu Peserta PMB

                     </h5>


                     <p class="text-muted fs-13 mb-0">

                        Bawa kartu peserta PMB yang telah diterbitkan
                        melalui Portal PMB.

                     </p>

                  </div>

               </div>


               <!-- IDENTITAS -->

               <div class="col-md-6">

                  <div class="pmb-preparation-card">

                     <div class="pmb-detail-check">

                        <i class="uil uil-user-square fs-18"></i>

                     </div>


                     <h5 class="mb-2">

                        Identitas Diri

                     </h5>


                     <p class="text-muted fs-13 mb-0">

                        Bawa KTP atau identitas yang digunakan
                        saat melakukan pendaftaran.

                     </p>

                  </div>

               </div>


               <!-- TEPAT WAKTU -->

               <div class="col-md-6">

                  <div class="pmb-preparation-card">

                     <div class="pmb-detail-check">

                        <i class="uil uil-clock fs-18"></i>

                     </div>


                     <h5 class="mb-2">

                        Hadir Tepat Waktu

                     </h5>


                     <p class="text-muted fs-13 mb-0">

                        Disarankan hadir minimal 30 menit
                        sebelum jadwal seleksi dimulai.

                     </p>

                  </div>

               </div>


               <!-- PERLENGKAPAN -->

               <div class="col-md-6">

                  <div class="pmb-preparation-card">

                     <div class="pmb-detail-check">

                        <i class="uil uil-edit fs-18"></i>

                     </div>


                     <h5 class="mb-2">

                        Perlengkapan

                     </h5>


                     <p class="text-muted fs-13 mb-0">

                        Siapkan alat tulis dan perlengkapan lain
                        sesuai informasi dari panitia.

                     </p>

                  </div>

               </div>


            </div>


            <!-- =================================================
                 CONTACT
            ================================================== -->

            <div class="pmb-contact-action">


               <div>

                  <span
                     class="text-uppercase text-muted fs-11 fw-bold">

                     Butuh Bantuan?

                  </span>


                  <h5 class="mb-1 mt-1">

                     Ada yang ingin ditanyakan?

                  </h5>


                  <p class="text-muted fs-13 mb-0">

                     Hubungi panitia PMB untuk mendapatkan informasi
                     lebih lanjut.

                  </p>

               </div>


               <div>

                  <a
                     href="https://wa.me/6281367969843?text=Halo%20Panitia%20PMB%20STIH%20Graha%20Kirana%2C%20saya%20ingin%20bertanya%20mengenai%20jadwal%20seleksi."
                     target="_blank"
                     rel="noopener noreferrer"
                     class="btn btn-primary rounded btn-icon btn-icon-end">

                     Hubungi Panitia

                     <i class="uil uil-whatsapp"></i>

                  </a>

               </div>


            </div>


         </div>

      </section>


   </div>


   <!-- =========================================================
        FOOTER
   ========================================================== -->

   <?php require '../footer2.php'; ?>


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