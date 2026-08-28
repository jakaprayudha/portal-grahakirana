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
   header('Location: ./login-pmb');
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
        agama,
        place,
        datebirth,
        number_id,
        phone_number,
        email_register,
        address_card,
        provinsi,
        kabupaten,
        kecamatan,
        kelurahan,
        school_name,
        school_npsn,
        school_address,
        number_nisn,
        year_graduation,
        name_father,
        name_mother,
        number_kk,
        number_nik_kk,
        register_uid,
        register_type,
        id_program,
        id_provider,
        file_ktp,
        file_kk,
        file_ijazah,
        file_dokumen,
        tahap_aktif,
        status_pendaftaran,
        account_status,
        created_at
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

   header('Location: ./login-pmb');
   exit;
}


/**
 * =========================================================
 * GUARD TAHAP 03
 * =========================================================
 */

if ((int) $pmbUser['tahap_aktif'] < 2) {

   header('Location: ./welcome');

   exit;
}


/**
 * =========================================================
 * DATA DISPLAY
 * =========================================================
 */

$namaPeserta =
   $pmbUser['fullname'] ?: '-';

$emailPeserta =
   $pmbUser['email_register'] ?: '-';

$idPendaftaran =
   $pmbUser['register_uid'] ?: '-';

$jalur =
   $pmbUser['register_type'] ?: '-';


/**
 * =========================================================
 * TAHUN PMB
 * =========================================================
 */

$tahunPmb = '2026/2027';


/**
 * =========================================================
 * FOTO PESERTA
 * =========================================================
 *
 * file_dokumen saat ini digunakan sebagai pasfoto.
 */

$fotoPeserta = null;


if (!empty($pmbUser['file_dokumen'])) {

   $fotoPath =
      '../uploads/pmb/' .
      $pmbUser['file_dokumen'];

   if (is_file($fotoPath)) {

      $fotoPeserta =
         'uploads/pmb/' .
         rawurlencode(
            $pmbUser['file_dokumen']
         );
   }
}


/**
 * =========================================================
 * QR DATA
 * =========================================================
 *
 * Gunakan register_uid.
 */

$qrData =
   $idPendaftaran;


/**
 * =========================================================
 * GET JADWAL SELEKSI
 * =========================================================
 *
 * Sumber:
 * pmb_jadwal_seleksi
 *
 * Hanya mengambil jadwal aktif / terjadwal.
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
    WHERE tahun_akademik = :tahun_akademik
      AND status = 'TERJADWAL'
    ORDER BY
        urutan ASC,
        tanggal ASC,
        jam_mulai ASC
");

$stmtJadwal->execute([
   'tahun_akademik' => $tahunPmb
]);

$jadwalSeleksi =
   $stmtJadwal->fetchAll(PDO::FETCH_ASSOC);


/**
 * =========================================================
 * JUMLAH JADWAL
 * =========================================================
 */

$totalJadwal =
   count($jadwalSeleksi);


/**
 * =========================================================
 * JADWAL SELEKSI BERIKUTNYA
 * =========================================================
 *
 * Digunakan untuk countdown.
 */

$jadwalBerikutnya = null;

foreach ($jadwalSeleksi as $jadwal) {

   $tanggalJamMulai =
      $jadwal['tanggal'] .
      ' ' .
      $jadwal['jam_mulai'];

   $timestamp =
      strtotime($tanggalJamMulai);

   if (
      $timestamp !== false &&
      $timestamp >= time()
   ) {

      $jadwalBerikutnya =
         $jadwal;

      break;
   }
}


/**
 * =========================================================
 * DATA COUNTDOWN
 * =========================================================
 */

$countdownTarget = null;

if ($jadwalBerikutnya) {

   $countdownTarget =
      $jadwalBerikutnya['tanggal'] .
      'T' .
      $jadwalBerikutnya['jam_mulai'];
}

/**
 * =========================================================
 * DISPLAY JADWAL BERIKUTNYA
 * =========================================================
 */

$seleksiBerikutnyaNama = 'Belum Ada Jadwal';

$seleksiBerikutnyaTanggal = '-';

$seleksiBerikutnyaWaktu = '-';

if ($jadwalBerikutnya) {

   $seleksiBerikutnyaNama =
      $jadwalBerikutnya['nama_seleksi'];

   /**
    * Format tanggal Indonesia
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

   $timestamp =
      strtotime($jadwalBerikutnya['tanggal']);

   $hari =
      $hariIndonesia[date('l', $timestamp)] ?? date('l', $timestamp);

   $bulan =
      $bulanIndonesia[date('F', $timestamp)] ?? date('F', $timestamp);

   $seleksiBerikutnyaTanggal =
      $hari . ', ' .
      date('d', $timestamp) . ' ' .
      $bulan . ' ' .
      date('Y', $timestamp);


   /**
    * Format jam
    */

   $jamMulai =
      date(
         'H.i',
         strtotime(
            $jadwalBerikutnya['jam_mulai']
         )
      );

   $jamSelesai =
      date(
         'H.i',
         strtotime(
            $jadwalBerikutnya['jam_selesai']
         )
      );

   $seleksiBerikutnyaWaktu =
      $jamMulai .
      ' – ' .
      $jamSelesai .
      ' WIB';
}

/**
 * =========================================================
 * PAGE
 * =========================================================
 */

$page = 'Jadwal Seleksi PMB';

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <base href="../">

   <?php
   $page = 'Jadwal Seleksi PMB';
   require '../head.php';
   ?>

   <style>
      /* =========================================================
         PMB - TAHAP 04
         JADWAL SELEKSI
      ========================================================= */

      .pmb-schedule-section {
         padding-top: 60px;
         padding-bottom: 80px;
      }

      .pmb-page-header {
         margin-bottom: 40px;
      }

      .pmb-page-header h2 {
         font-size: 2.5rem;
      }

      /* Participant mini card */
      .pmb-participant-card {
         border: 0;
      }

      .pmb-participant-id {
         font-size: 13px;
         font-weight: 700;
         letter-spacing: .4px;
      }

      /* Status */
      .pmb-status-badge {
         font-size: 12px;
         font-weight: 700;
         border-radius: 30px;
         padding: 7px 13px;
      }

      /* Schedule card */
      .pmb-schedule-card {
         border: 0;
         overflow: hidden;
         transition: all .2s ease;
      }

      .pmb-schedule-card:hover {
         transform: translateY(-3px);
         box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
      }

      .pmb-schedule-header {
         padding: 22px 25px;
         border-bottom: 1px solid rgba(0, 0, 0, .06);
      }

      .pmb-schedule-body {
         padding: 25px;
      }

      .pmb-schedule-icon {
         width: 55px;
         height: 55px;
         min-width: 55px;
         border-radius: 12px;
         display: flex;
         align-items: center;
         justify-content: center;
      }

      .pmb-schedule-date {
         font-size: 30px;
         font-weight: 700;
         line-height: 1;
      }

      .pmb-schedule-month {
         font-size: 12px;
         font-weight: 700;
         text-transform: uppercase;
         color: #8a8f98;
         letter-spacing: .5px;
      }

      .pmb-schedule-info {
         display: flex;
         align-items: flex-start;
         margin-bottom: 16px;
      }

      .pmb-schedule-info:last-child {
         margin-bottom: 0;
      }

      .pmb-schedule-info i {
         width: 24px;
         margin-top: 2px;
         color: #3f78e0;
      }

      .pmb-schedule-info-label {
         font-size: 12px;
         color: #8a8f98;
         margin-bottom: 2px;
      }

      .pmb-schedule-info-value {
         font-size: 14px;
         font-weight: 600;
      }

      /* Timeline */
      .pmb-timeline {
         position: relative;
      }

      .pmb-timeline::before {
         content: "";
         position: absolute;
         left: 25px;
         top: 30px;
         bottom: 30px;
         width: 2px;
         background: #e9edf2;
      }

      .pmb-timeline-item {
         position: relative;
         display: flex;
         align-items: flex-start;
         margin-bottom: 35px;
      }

      .pmb-timeline-item:last-child {
         margin-bottom: 0;
      }

      .pmb-timeline-number {
         width: 52px;
         height: 52px;
         min-width: 52px;
         border-radius: 50%;
         background: #fff;
         border: 2px solid #3f78e0;
         color: #3f78e0;
         display: flex;
         align-items: center;
         justify-content: center;
         font-weight: 700;
         position: relative;
         z-index: 2;
         margin-right: 20px;
      }

      .pmb-timeline-number.active {
         background: #3f78e0;
         color: #fff;
      }

      /* Reminder */
      .pmb-reminder {
         border: 0;
      }

      /* Preparation */
      .pmb-preparation-item {
         display: flex;
         align-items: flex-start;
         margin-bottom: 18px;
      }

      .pmb-preparation-item:last-child {
         margin-bottom: 0;
      }

      .pmb-preparation-check {
         width: 32px;
         height: 32px;
         min-width: 32px;
         border-radius: 50%;
         background: #edf7f0;
         color: #2b9a59;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-right: 12px;
      }

      /* Mobile */
      @media (max-width: 991.98px) {

         .pmb-schedule-section {
            padding-top: 50px;
            padding-bottom: 60px;
         }

         .pmb-page-header h2 {
            font-size: 2.2rem;
         }

         .pmb-timeline::before {
            display: none;
         }

      }

      @media (max-width: 767.98px) {

         .pmb-schedule-section {
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

         .pmb-schedule-header {
            padding: 18px;
         }

         .pmb-schedule-body {
            padding: 20px;
         }

         .pmb-schedule-date {
            font-size: 25px;
         }

         .pmb-timeline-item {
            margin-bottom: 25px;
         }

         .pmb-timeline-number {
            width: 44px;
            height: 44px;
            min-width: 44px;
            margin-right: 14px;
         }

      }

      @media (max-width: 575.98px) {

         .pmb-page-header h2 {
            font-size: 1.6rem;
         }

         .pmb-schedule-card .card-body {
            padding: 18px !important;
         }

         .pmb-schedule-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
         }

         .pmb-schedule-info-value {
            font-size: 13px;
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
           SECTION : TAHAP 04 - JADWAL SELEKSI
      ====================================================== -->

      <section class="wrapper bg-light pmb-schedule-section">

         <div class="container">


            <!-- =================================================
                 HEADER
            ================================================== -->

            <div class="row pmb-page-header">

               <div class="col-lg-9">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
                     TAHAP 04
                  </span>

                  <h2 class="display-4 mb-3">
                     Jadwal Seleksi PMB
                  </h2>

                  <p class="lead fs-18 mb-0">
                     Lihat jadwal pelaksanaan seleksi penerimaan mahasiswa baru
                     yang harus Anda ikuti.
                  </p>

               </div>

            </div>

            <?php
            require 'header.php';
            ?>





            <!-- =================================================
                 SCHEDULE OVERVIEW
            ================================================== -->

            <div class="row gx-lg-8 gy-6">


               <!-- =================================================
                    LEFT : TIMELINE
               ================================================== -->

               <div class="col-lg-8">


                  <div class="card shadow-sm border-0">

                     <div class="card-body p-5 p-md-6">


                        <div class="mb-6">

                           <span class="text-uppercase text-muted fs-13 fw-bold">
                              Agenda Seleksi
                           </span>

                           <h3 class="mt-2 mb-2">
                              Tahapan Seleksi Anda
                           </h3>

                           <p class="text-muted mb-0">
                              Pastikan hadir sesuai jadwal yang telah ditentukan.
                           </p>

                        </div>


                        <?php if (empty($jadwalSeleksi)): ?>

                           <div class="alert alert-info">

                              <i class="uil uil-info-circle me-2"></i>

                              Jadwal seleksi belum tersedia.
                              Silakan periksa kembali Portal PMB secara berkala.

                           </div>

                        <?php else: ?>


                           <?php foreach ($jadwalSeleksi as $index => $jadwal): ?>

                              <?php

                              $nomor =
                                 $index + 1;


                              /*
       * Format tanggal
       */

                              $timestamp =
                                 strtotime($jadwal['tanggal']);

                              $tanggalHari =
                                 date('l', $timestamp);

                              $tanggalAngka =
                                 date('d', $timestamp);

                              $tanggalBulan =
                                 date('F', $timestamp);

                              $tanggalTahun =
                                 date('Y', $timestamp);


                              /*
       * Bahasa Indonesia
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


                              $hari =
                                 $hariIndonesia[$tanggalHari]
                                 ?? $tanggalHari;


                              $bulan =
                                 $bulanIndonesia[$tanggalBulan]
                                 ?? $tanggalBulan;


                              /*
       * Jam
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


                              /*
       * Warna berdasarkan urutan
       */

                              if ($nomor === 1) {

                                 $icon =
                                    'uil-file-alt';

                                 $iconBg =
                                    'bg-soft-primary';

                                 $iconColor =
                                    'text-primary';

                                 $badgeBg =
                                    'bg-soft-primary';

                                 $badgeColor =
                                    'text-primary';
                              } else {

                                 $icon =
                                    'uil-comments';

                                 $iconBg =
                                    'bg-soft-green';

                                 $iconColor =
                                    'text-green';

                                 $badgeBg =
                                    'bg-soft-green';

                                 $badgeColor =
                                    'text-green';
                              }

                              ?>


                              <!-- =================================================
           TIMELINE ITEM
      ================================================== -->

                              <div class="pmb-timeline-item">


                                 <!-- Number -->

                                 <div
                                    class="pmb-timeline-number
            <?= $nomor === 1 ? 'active' : '' ?>">

                                    <?= $nomor ?>

                                 </div>


                                 <div class="flex-grow-1">


                                    <div class="card pmb-schedule-card mb-0">


                                       <!-- HEADER -->

                                       <div class="pmb-schedule-header">

                                          <div class="d-flex align-items-center">


                                             <div
                                                class="pmb-schedule-icon
                        <?= $iconBg ?>
                        <?= $iconColor ?>
                        me-4">

                                                <i
                                                   class="uil
                           <?= $icon ?>
                           fs-24">
                                                </i>

                                             </div>


                                             <div class="flex-grow-1">


                                                <span
                                                   class="badge
                           <?= $badgeBg ?>
                           <?= $badgeColor ?>
                           rounded-pill mb-2">

                                                   <?= htmlspecialchars(
                                                      $jadwal['kategori']
                                                   ) ?>

                                                </span>


                                                <h4 class="mb-0">

                                                   <?= htmlspecialchars(
                                                      $jadwal['nama_seleksi']
                                                   ) ?>

                                                </h4>

                                             </div>


                                             <span
                                                class="badge
                        bg-soft-green
                        text-green
                        rounded-pill">

                                                Terjadwal

                                             </span>


                                          </div>

                                       </div>


                                       <!-- BODY -->

                                       <div class="pmb-schedule-body">


                                          <!-- DATE -->

                                          <div
                                             class="d-flex
                     align-items-center
                     mb-5">

                                             <div
                                                class="text-center
                        me-4">

                                                <div
                                                   class="pmb-schedule-date
                           <?= $iconColor ?>">

                                                   <?= htmlspecialchars(
                                                      $tanggalAngka
                                                   ) ?>

                                                </div>


                                                <div
                                                   class="pmb-schedule-month">

                                                   <?= htmlspecialchars(
                                                      $bulan
                                                   ) ?>

                                                </div>

                                             </div>


                                             <div>

                                                <h5 class="mb-1">

                                                   <?= htmlspecialchars(
                                                      $hari
                                                   ) ?>,

                                                   <?= htmlspecialchars(
                                                      $tanggalAngka
                                                   ) ?>

                                                   <?= htmlspecialchars(
                                                      $bulan
                                                   ) ?>

                                                   <?= htmlspecialchars(
                                                      $tanggalTahun
                                                   ) ?>

                                                </h5>


                                                <p
                                                   class="text-muted
                           mb-0
                           fs-14">

                                                   Tahun Akademik
                                                   <?= htmlspecialchars(
                                                      $jadwal['tahun_akademik']
                                                   ) ?>

                                                </p>

                                             </div>

                                          </div>


                                          <!-- TIME -->

                                          <div class="pmb-schedule-info">

                                             <i
                                                class="uil uil-clock
                        <?= $iconColor ?>">
                                             </i>

                                             <div>

                                                <div
                                                   class="pmb-schedule-info-label">

                                                   Waktu

                                                </div>

                                                <div
                                                   class="pmb-schedule-info-value">

                                                   <?= htmlspecialchars(
                                                      $waktu
                                                   ) ?>

                                                </div>

                                             </div>

                                          </div>


                                          <!-- LOCATION -->

                                          <div class="pmb-schedule-info">

                                             <i
                                                class="uil uil-location-point
                        <?= $iconColor ?>">
                                             </i>

                                             <div>

                                                <div
                                                   class="pmb-schedule-info-label">

                                                   Lokasi

                                                </div>

                                                <div
                                                   class="pmb-schedule-info-value">

                                                   <?= htmlspecialchars(
                                                      $jadwal['lokasi']
                                                   ) ?>

                                                </div>

                                             </div>

                                          </div>


                                          <!-- ROOM -->

                                          <div class="pmb-schedule-info">

                                             <i
                                                class="uil uil-building
                        <?= $iconColor ?>">
                                             </i>

                                             <div>

                                                <div
                                                   class="pmb-schedule-info-label">

                                                   Ruangan

                                                </div>

                                                <div
                                                   class="pmb-schedule-info-value">

                                                   <?= htmlspecialchars(
                                                      $jadwal['ruangan'] ?: '-'
                                                   ) ?>

                                                </div>

                                             </div>

                                          </div>


                                          <!-- METHOD -->

                                          <div class="pmb-schedule-info">

                                             <i
                                                class="uil uil-monitor
                        <?= $iconColor ?>">
                                             </i>

                                             <div>

                                                <div
                                                   class="pmb-schedule-info-label">

                                                   Metode

                                                </div>

                                                <div
                                                   class="pmb-schedule-info-value">

                                                   <?= htmlspecialchars(
                                                      $jadwal['metode']
                                                   ) ?>

                                                </div>

                                             </div>

                                          </div>


                                          <hr class="my-5">


                                          <!-- NOTE -->

                                          <div
                                             class="d-flex
                     justify-content-between
                     align-items-center
                     flex-wrap
                     gap-3">

                                             <span
                                                class="text-muted fs-13">

                                                <i
                                                   class="uil
                           uil-info-circle
                           me-1">
                                                </i>

                                                <?= htmlspecialchars(
                                                   $jadwal['keterangan']
                                                      ?: 'Tidak ada keterangan.'
                                                ) ?>

                                             </span>

                                             <a
                                                href="./pmb/register-schedule-details?id=<?= (int) $jadwal['id'] ?>"
                                                class="btn btn-sm btn-outline-primary rounded">

                                                Lihat Detail

                                                <i class="uil uil-arrow-right ms-1"></i>

                                             </a>

                                          </div>


                                       </div>

                                    </div>

                                 </div>

                              </div>


                           <?php endforeach; ?>


                        <?php endif; ?>
                     </div>

                  </div>


                  <!-- =================================================
                       DOWNLOAD
                  ================================================== -->

                  <div class="card bg-soft-primary border-0 mt-6">

                     <div class="card-body p-5">

                        <div class="row align-items-center">

                           <div class="col-lg">

                              <div class="d-flex align-items-center">

                                 <div class="icon btn btn-circle btn-lg btn-primary me-4">

                                    <i class="uil uil-print"></i>

                                 </div>

                                 <div>

                                    <h4 class="mb-1">
                                       Simpan Jadwal Seleksi
                                    </h4>

                                    <p class="mb-0 text-muted fs-14">
                                       Cetak atau simpan jadwal untuk referensi
                                       selama proses seleksi.
                                    </p>

                                 </div>

                              </div>

                           </div>

                           <div class="col-lg-auto mt-4 mt-lg-0">

                              <a
                                 href="./pmb/print/print-jadwal"
                                 target="_blank"
                                 rel="noopener"
                                 class="btn btn-primary rounded btn-icon btn-icon-end">

                                 Cetak Jadwal

                                 <i class="uil uil-print"></i>

                              </a>
                           </div>

                        </div>

                     </div>

                  </div>


               </div>


               <!-- =================================================
                    RIGHT : INFORMATION
               ================================================== -->

               <div class="col-lg-4">


                  <!-- =================================================
                       COUNTDOWN
                  ================================================== -->

                  <!-- =================================================
     NEXT SELECTION COUNTDOWN
================================================== -->

                  <div class="card bg-primary text-white border-0 shadow-lg mb-6">

                     <div class="card-body p-6">


                        <!-- Label -->

                        <span class="text-uppercase text-white opacity-75 fs-13 fw-bold">

                           Seleksi Berikutnya

                        </span>


                        <!-- Nama Seleksi -->

                        <h3 class="text-white mt-2 mb-2">

                           <?= htmlspecialchars(
                              $seleksiBerikutnyaNama
                           ) ?>

                        </h3>


                        <!-- Tanggal & Waktu -->

                        <?php if ($jadwalBerikutnya): ?>

                           <p class="text-white opacity-75 mb-5 fs-14">

                              <i class="uil uil-calendar-alt me-1"></i>

                              <?= htmlspecialchars(
                                 $seleksiBerikutnyaTanggal
                              ) ?>


                              <span class="mx-2">•</span>


                              <i class="uil uil-clock me-1"></i>

                              <?= htmlspecialchars(
                                 $seleksiBerikutnyaWaktu
                              ) ?>

                           </p>

                        <?php else: ?>

                           <p class="text-white opacity-75 mb-5 fs-14">

                              Jadwal seleksi belum tersedia.

                           </p>

                        <?php endif; ?>


                        <!-- Countdown -->

                        <div class="row text-center gx-2">


                           <!-- HARI -->

                           <div class="col-3">

                              <div class="bg-white bg-opacity-10 rounded p-3">

                                 <div
                                    class="fs-24 fw-bold text-white"
                                    id="countDays">

                                    00

                                 </div>

                                 <small class="text-white opacity-75">

                                    Hari

                                 </small>

                              </div>

                           </div>


                           <!-- JAM -->

                           <div class="col-3">

                              <div class="bg-white bg-opacity-10 rounded p-3">

                                 <div
                                    class="fs-24 fw-bold text-white"
                                    id="countHours">

                                    00

                                 </div>

                                 <small class="text-white opacity-75">

                                    Jam

                                 </small>

                              </div>

                           </div>


                           <!-- MENIT -->

                           <div class="col-3">

                              <div class="bg-white bg-opacity-10 rounded p-3">

                                 <div
                                    class="fs-24 fw-bold text-white"
                                    id="countMinutes">

                                    00

                                 </div>

                                 <small class="text-white opacity-75">

                                    Menit

                                 </small>

                              </div>

                           </div>


                           <!-- DETIK -->

                           <div class="col-3">

                              <div class="bg-white bg-opacity-10 rounded p-3">

                                 <div
                                    class="fs-24 fw-bold text-white"
                                    id="countSeconds">

                                    00

                                 </div>

                                 <small class="text-white opacity-75">

                                    Detik

                                 </small>

                              </div>

                           </div>


                        </div>

                     </div>

                  </div>


                  <!-- =================================================
                       PREPARATION
                  ================================================== -->

                  <div class="card shadow-sm border-0 mb-6">

                     <div class="card-body p-6">

                        <span class="text-uppercase text-muted fs-13 fw-bold">
                           Persiapan
                        </span>

                        <h4 class="mt-2 mb-5">
                           Yang Perlu Disiapkan
                        </h4>


                        <div class="pmb-preparation-item">

                           <div class="pmb-preparation-check">
                              <i class="uil uil-check"></i>
                           </div>

                           <div>

                              <h6 class="mb-1">
                                 Kartu Peserta
                              </h6>

                              <p class="text-muted fs-13 mb-0">
                                 Bawa kartu peserta PMB yang telah diterbitkan.
                              </p>

                           </div>

                        </div>


                        <div class="pmb-preparation-item">

                           <div class="pmb-preparation-check">
                              <i class="uil uil-check"></i>
                           </div>

                           <div>

                              <h6 class="mb-1">
                                 Identitas Diri
                              </h6>

                              <p class="text-muted fs-13 mb-0">
                                 Bawa KTP atau identitas yang digunakan saat
                                 pendaftaran.
                              </p>

                           </div>

                        </div>


                        <div class="pmb-preparation-item">

                           <div class="pmb-preparation-check">
                              <i class="uil uil-check"></i>
                           </div>

                           <div>

                              <h6 class="mb-1">
                                 Hadir Tepat Waktu
                              </h6>

                              <p class="text-muted fs-13 mb-0">
                                 Disarankan hadir minimal 30 menit sebelum
                                 jadwal seleksi.
                              </p>

                           </div>

                        </div>


                        <div class="pmb-preparation-item">

                           <div class="pmb-preparation-check">
                              <i class="uil uil-check"></i>
                           </div>

                           <div>

                              <h6 class="mb-1">
                                 Perlengkapan
                              </h6>

                              <p class="text-muted fs-13 mb-0">
                                 Siapkan alat tulis dan perlengkapan lain
                                 sesuai informasi panitia.
                              </p>

                           </div>

                        </div>

                     </div>

                  </div>


                  <!-- =================================================
                       CONTACT
                  ================================================== -->

                  <div class="card bg-soft-yellow border-0">

                     <div class="card-body p-6">

                        <div class="icon btn btn-circle btn-sm btn-soft-yellow mb-4">

                           <i class="uil uil-headphones"></i>

                        </div>

                        <h4 class="mb-2">
                           Butuh Bantuan?
                        </h4>

                        <p class="text-muted fs-14 mb-4">
                           Hubungi panitia PMB jika terdapat perubahan jadwal
                           atau kendala pada proses seleksi.
                        </p>

                        <a
                           href="https://wa.me/6281367969843?text=Halo%20Panitia%20PMB%20STIH%20Graha%20Kirana%2C%20saya%20ingin%20bertanya%20mengenai%20pendaftaran%20mahasiswa%20baru."
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn btn-sm btn-outline-primary rounded">

                           Hubungi Panitia

                           <i class="uil uil-whatsapp ms-1"></i>

                        </a>

                     </div>

                  </div>


               </div>

            </div>


            <!-- =================================================
     NEXT STEP : TAHAP 05
================================================== -->

            <!-- =========================================================
     NEXT STAGE - TAHAP 05
========================================================== -->

            <div class="row mt-8">

               <div class="col-lg-10 mx-auto">

                  <div
                     class="
            card
            bg-soft-primary
            border-0
            shadow-sm
            h-100
            pmb-next-stage-card
         ">

                     <div class="card-body p-5">

                        <div class="row align-items-center">


                           <!-- =============================================
                    INFO
               ============================================== -->

                           <div class="col-lg">

                              <div
                                 class="
                        d-flex
                        align-items-start
                     ">

                                 <div
                                    class="
                           icon
                           btn
                           btn-circle
                           btn-lg
                           btn-primary
                           me-4
                           flex-shrink-0
                        ">

                                    <i class="uil uil-clipboard-alt"></i>

                                 </div>


                                 <div>

                                    <span
                                       class="
                              text-uppercase
                              text-primary
                              fs-13
                              fw-bold
                           ">

                                       Tahap Berikutnya

                                    </span>


                                    <h4
                                       class="
                              mb-1
                              text-dark
                           ">

                                       Pelaksanaan &amp; Hasil Seleksi

                                    </h4>


                                    <p
                                       class="
                              mb-0
                              text-muted
                           ">

                                       Setelah seleksi selesai, hasil akan diproses
                                       oleh tim seleksi dan diumumkan melalui Portal PMB.

                                    </p>

                                 </div>

                              </div>

                           </div>



                           <!-- =============================================
                    ACTION
               ============================================== -->

                           <div
                              class="
                     col-lg-auto
                     mt-4
                     mt-lg-0
                  ">

                              <div
                                 class="text-lg-end">


                                 <!-- ======================================
                          TAHAP
                     ======================================= -->

                                 <div class="mb-2">

                                    <span
                                       class="
                              badge
                              bg-soft-primary
                              text-primary
                              rounded-pill
                              px-4
                              py-2
                           ">

                                       Tahap 05

                                       <i
                                          class="
                                 uil
                                 uil-arrow-right
                                 ms-1
                              ">
                                       </i>

                                    </span>

                                 </div>



                                 <!-- ======================================
                          BUTTONS
                     ======================================= -->

                                 <div
                                    class="
                           d-flex
                           align-items-center
                           justify-content-lg-end
                           gap-2
                        ">


                                    <!-- ==================================
                             KEMBALI
                        =================================== -->

                                    <button
                                       type="button"
                                       onclick="history.back()"
                                       class="
                              btn
                              btn-outline-primary
                              btn-sm
                              rounded-pill
                              px-4
                           ">

                                       <i
                                          class="
                                 uil
                                 uil-arrow-left
                                 me-1
                              ">
                                       </i>

                                       Kembali

                                    </button>



                                    <!-- ==================================
                             LIHAT HASIL
                        =================================== -->

                                    <a
                                       href="./pmb/register-test"
                                       class="
                              btn
                              btn-primary
                              btn-sm
                              rounded-pill
                              px-4
                           ">

                                       Lihat Hasil Seleksi

                                       <i
                                          class="
                                 uil
                                 uil-arrow-right
                                 ms-1
                              ">
                                       </i>

                                    </a>


                                 </div>


                              </div>

                           </div>


                        </div>

                     </div>

                  </div>

               </div>

            </div>

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
   <script>
      /* =========================================================
   COUNTDOWN SELEKSI PMB
   Target diambil dari pmb_jadwal_seleksi
========================================================= */

      /**
       * Target countdown dari PHP
       *
       * Contoh:
       * 2026-09-15T09:00:00
       */

      const countdownTarget =
         <?= $countdownTarget
            ? json_encode($countdownTarget)
            : 'null' ?>;


      function updateCountdown() {

         const daysElement =
            document.getElementById("countDays");

         const hoursElement =
            document.getElementById("countHours");

         const minutesElement =
            document.getElementById("countMinutes");

         const secondsElement =
            document.getElementById("countSeconds");


         /*
          * Pastikan element tersedia
          */

         if (
            !daysElement ||
            !hoursElement ||
            !minutesElement ||
            !secondsElement
         ) {
            return;
         }


         /*
          * Tidak ada jadwal
          */

         if (!countdownTarget) {

            daysElement.innerText = "00";
            hoursElement.innerText = "00";
            minutesElement.innerText = "00";
            secondsElement.innerText = "00";

            return;
         }


         /*
          * Konversi target
          *
          * Server:
          * 2026-09-15T09:00:00
          */

         const targetDate =
            new Date(countdownTarget).getTime();


         const now =
            new Date().getTime();


         const distance =
            targetDate - now;


         /*
          * Jadwal sudah dimulai / lewat
          */

         if (distance <= 0) {

            daysElement.innerText = "00";
            hoursElement.innerText = "00";
            minutesElement.innerText = "00";
            secondsElement.innerText = "00";

            return;
         }


         /*
          * Hitung hari
          */

         const days =
            Math.floor(
               distance /
               (1000 * 60 * 60 * 24)
            );


         /*
          * Hitung jam
          */

         const hours =
            Math.floor(
               (
                  distance %
                  (1000 * 60 * 60 * 24)
               ) /
               (1000 * 60 * 60)
            );


         /*
          * Hitung menit
          */

         const minutes =
            Math.floor(
               (
                  distance %
                  (1000 * 60 * 60)
               ) /
               (1000 * 60)
            );


         /*
          * Hitung detik
          */

         const seconds =
            Math.floor(
               (
                  distance %
                  (1000 * 60)
               ) /
               1000
            );


         /*
          * Tampilkan
          */

         daysElement.innerText =
            String(days).padStart(2, "0");


         hoursElement.innerText =
            String(hours).padStart(2, "0");


         minutesElement.innerText =
            String(minutes).padStart(2, "0");


         secondsElement.innerText =
            String(seconds).padStart(2, "0");

      }


      /*
      =========================================================
      INITIAL
      =========================================================
      */

      updateCountdown();


      /*
      =========================================================
      UPDATE SETIAP 1 DETIK
      =========================================================
      */

      setInterval(
         updateCountdown,
         1000
      );
   </script>

</body>

</html>