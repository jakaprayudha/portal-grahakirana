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
      email_register,
      phone_number,

      register_uid,
      register_type,

      id_program,
      id_provider,

      tahap_aktif,
      status_pendaftaran,
      account_status,

      nilai_tpa,
      nilai_wawancara,
      nilai_akhir,

      status_kelulusan,
      catatan_hasil,
      hasil_diumumkan_at,

      created_at

   FROM register_pmb

   WHERE id = :id

   LIMIT 1

");


$stmt->execute([
   'id' => $userId
]);


$pmbUser =
   $stmt->fetch(
      PDO::FETCH_ASSOC
   );


/**
 * =========================================================
 * PESERTA TIDAK DITEMUKAN
 * =========================================================
 */

if (!$pmbUser) {

   session_destroy();

   header('Location: ./login-pmb.php');

   exit;
}


/**
 * =========================================================
 * GUARD TAHAP 05
 * =========================================================
 *
 * Tahap 05 dapat diakses jika peserta sudah melewati
 * minimal tahap 04.
 *
 * =========================================================
 */

if (
   (int) $pmbUser['tahap_aktif'] < 4
) {

   header('Location: ./welcome.php');

   exit;
}


/**
 * =========================================================
 * DATA DISPLAY
 * =========================================================
 */

$namaPeserta =
   $pmbUser['fullname']
   ?: '-';


$idPendaftaran =
   $pmbUser['register_uid']
   ?: '-';


$jalur =
   $pmbUser['register_type']
   ?: '-';


/**
 * =========================================================
 * NILAI
 * =========================================================
 */

$nilaiTPA =
   $pmbUser['nilai_tpa'] !== null
   ? (float) $pmbUser['nilai_tpa']
   : null;


$nilaiWawancara =
   $pmbUser['nilai_wawancara'] !== null
   ? (float) $pmbUser['nilai_wawancara']
   : null;


$nilaiAkhir =
   $pmbUser['nilai_akhir'] !== null
   ? (float) $pmbUser['nilai_akhir']
   : null;


$statusKelulusan =
   strtoupper(
      $pmbUser['status_kelulusan']
         ?: 'BELUM_DIUMUMKAN'
   );


$catatanHasil =
   $pmbUser['catatan_hasil']
   ?: 'Hasil seleksi belum diumumkan.';


/**
 * =========================================================
 * STATUS HASIL
 * =========================================================
 */

if (
   $statusKelulusan === 'LULUS'
) {

   $hasilLabel =
      'LULUS';

   $hasilBadge =
      'LULUS';

   $hasilClass =
      'pmb-result-success';

   $hasilBadgeClass =
      'bg-soft-green text-green';

   $hasilIcon =
      'uil-check-circle';

   $hasilDescription =
      'Selamat! Anda dinyatakan lulus seleksi Penerimaan Mahasiswa Baru.';
} elseif (
   $statusKelulusan === 'TIDAK_LULUS'
) {

   $hasilLabel =
      'TIDAK LULUS';

   $hasilBadge =
      'TIDAK LULUS';

   $hasilClass =
      'pmb-result-failed';

   $hasilBadgeClass =
      'bg-soft-red text-red';

   $hasilIcon =
      'uil-times-circle';

   $hasilDescription =
      'Anda belum dinyatakan lulus pada seleksi Penerimaan Mahasiswa Baru.';
} else {

   $hasilLabel =
      'MENUNGGU HASIL';

   $hasilBadge =
      'BELUM DIUMUMKAN';

   $hasilClass =
      'pmb-result-pending';

   $hasilBadgeClass =
      'bg-soft-yellow text-yellow';

   $hasilIcon =
      'uil-clock';

   $hasilDescription =
      'Hasil seleksi akan tersedia setelah seluruh proses seleksi selesai dan diverifikasi oleh panitia.';
}


/**
 * =========================================================
 * STATUS SELEKSI
 * =========================================================
 */

if (
   $statusKelulusan === 'LULUS' ||
   $statusKelulusan === 'TIDAK_LULUS'
) {

   $statusSeleksiLabel =
      'Seleksi Selesai';

   $statusSeleksiBadge =
      'SELESAI';
} else {

   $statusSeleksiLabel =
      'Seleksi Sedang Berlangsung';

   $statusSeleksiBadge =
      'PROSES';
}


/**
 * =========================================================
 * TAHUN PMB
 * =========================================================
 */

$tahunPmb =
   '2026/2027';


/**
 * =========================================================
 * AMBIL JADWAL SELEKSI
 * =========================================================
 */

$stmtJadwal =
   $pdo->prepare("

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

      WHERE tahun_akademik = :tahun

      ORDER BY
         urutan ASC,
         tanggal ASC,
         jam_mulai ASC

   ");


$stmtJadwal->execute([
   'tahun' => $tahunPmb
]);


$jadwalSeleksi =
   $stmtJadwal->fetchAll(
      PDO::FETCH_ASSOC
   );


/**
 * =========================================================
 * HELPER TANGGAL
 * =========================================================
 */

$hariIndonesia = [

   'Sunday' =>
   'Minggu',

   'Monday' =>
   'Senin',

   'Tuesday' =>
   'Selasa',

   'Wednesday' =>
   'Rabu',

   'Thursday' =>
   'Kamis',

   'Friday' =>
   'Jumat',

   'Saturday' =>
   'Sabtu'

];


$bulanIndonesia = [

   'January' =>
   'Januari',

   'February' =>
   'Februari',

   'March' =>
   'Maret',

   'April' =>
   'April',

   'May' =>
   'Mei',

   'June' =>
   'Juni',

   'July' =>
   'Juli',

   'August' =>
   'Agustus',

   'September' =>
   'September',

   'October' =>
   'Oktober',

   'November' =>
   'November',

   'December' =>
   'Desember'

];


function formatTanggalIndonesia(
   $tanggal,
   $hariIndonesia,
   $bulanIndonesia
) {

   if (
      empty($tanggal)
   ) {

      return '-';
   }


   $timestamp =
      strtotime($tanggal);


   if (!$timestamp) {

      return '-';
   }


   $hari =
      $hariIndonesia[date('l', $timestamp)]
      ?? date('l', $timestamp);


   $bulan =
      $bulanIndonesia[date('F', $timestamp)]
      ?? date('F', $timestamp);


   return
      $hari .
      ', ' .
      date('d', $timestamp) .
      ' ' .
      $bulan .
      ' ' .
      date('Y', $timestamp);
}


/**
 * =========================================================
 * CARI JADWAL TPA & WAWANCARA
 * =========================================================
 */

$jadwalTPA = null;

$jadwalWawancara = null;


foreach (
   $jadwalSeleksi
   as $jadwal
) {

   $namaSeleksi =
      strtolower(
         $jadwal['nama_seleksi']
            ?? ''
      );


   $kategori =
      strtolower(
         $jadwal['kategori']
            ?? ''
      );


   $gabungan =
      $namaSeleksi .
      ' ' .
      $kategori;


   if (
      $jadwalTPA === null &&
      (
         strpos(
            $gabungan,
            'tpa'
         ) !== false
         ||
         strpos(
            $gabungan,
            'potensi akademik'
         ) !== false
      )
   ) {

      $jadwalTPA =
         $jadwal;
   }


   if (
      $jadwalWawancara === null &&
      strpos(
         $gabungan,
         'wawancara'
      ) !== false
   ) {

      $jadwalWawancara =
         $jadwal;
   }
}


/**
 * =========================================================
 * CEK STATUS TPA / WAWANCARA
 * =========================================================
 */

$tpaSelesai =
   $nilaiTPA !== null;


$wawancaraSelesai =
   $nilaiWawancara !== null;


$semuaNilaiAda =
   $nilaiTPA !== null &&
   $nilaiWawancara !== null;


/**
 * =========================================================
 * PAGE
 * =========================================================
 */

$page =
   'Pelaksanaan & Hasil Seleksi PMB';

?>
<!DOCTYPE html>

<html lang="id">

<head>

   <base href="../">

   <?php
   require '../head.php';
   ?>


   <style>
      /* =====================================================
         PMB - TAHAP 05
      ===================================================== */

      .pmb-result-section {

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


      /* =====================================================
         STATUS
      ===================================================== */

      .pmb-status-card {

         border: 0;

         overflow: hidden;

      }


      .pmb-status-icon {

         width: 70px;

         height: 70px;

         min-width: 70px;

         border-radius: 50%;

         display: flex;

         align-items: center;

         justify-content: center;

      }


      /* =====================================================
         EXAM
      ===================================================== */

      .pmb-exam-card {

         border: 0;

         transition: all .2s ease;

      }


      .pmb-exam-card:hover {

         transform: translateY(-2px);

         box-shadow:
            0 15px 40px rgba(0, 0, 0, .07);

      }


      .pmb-exam-icon {

         width: 55px;

         height: 55px;

         min-width: 55px;

         border-radius: 12px;

         display: flex;

         align-items: center;

         justify-content: center;

      }


      .pmb-exam-info {

         display: flex;

         align-items: flex-start;

         margin-bottom: 15px;

      }


      .pmb-exam-info>i {

         width: 25px;

         margin-top: 2px;

         color: #3f78e0;

      }


      .pmb-exam-label {

         font-size: 12px;

         color: #8a8f98;

         margin-bottom: 2px;

      }


      .pmb-exam-value {

         font-size: 14px;

         font-weight: 600;

      }


      /* =====================================================
         RESULT
      ===================================================== */

      .pmb-result-box {

         border: 2px dashed #dfe5ec;

         border-radius: 14px;

         padding: 30px;

         text-align: center;

      }


      .pmb-result-icon {

         width: 85px;

         height: 85px;

         border-radius: 50%;

         display: flex;

         align-items: center;

         justify-content: center;

         margin: 0 auto 20px;

      }


      .pmb-result-pending {

         background: #fff8e6;

         color: #d99a00;

      }


      .pmb-result-success {

         background: #e9f8ef;

         color: #2b9a59;

      }


      .pmb-result-failed {

         background: #fff0f0;

         color: #d63939;

      }


      .pmb-score-card {

         border: 1px solid #edf0f3;

         border-radius: 10px;

         padding: 20px;

         text-align: center;

      }


      .pmb-score {

         font-size: 30px;

         font-weight: 700;

      }


      .pmb-score-label {

         font-size: 12px;

         color: #8a8f98;

      }


      /* =====================================================
         TIMELINE
      ===================================================== */

      .pmb-result-timeline {

         position: relative;

      }


      .pmb-result-timeline::before {

         content: "";

         position: absolute;

         left: 23px;

         top: 30px;

         bottom: 30px;

         width: 2px;

         background: #e9edf2;

      }


      .pmb-result-timeline-item {

         position: relative;

         display: flex;

         align-items: flex-start;

         margin-bottom: 28px;

      }


      .pmb-result-number {

         width: 48px;

         height: 48px;

         min-width: 48px;

         border-radius: 50%;

         background: #fff;

         border: 2px solid #dfe5ec;

         display: flex;

         align-items: center;

         justify-content: center;

         position: relative;

         z-index: 2;

         margin-right: 18px;

         color: #8a8f98;

         font-weight: 700;

      }


      .pmb-result-number.complete {

         border-color: #2b9a59;

         background: #2b9a59;

         color: #fff;

      }


      .pmb-result-number.active {

         border-color: #3f78e0;

         background: #3f78e0;

         color: #fff;

      }


      /* =====================================================
         RESULT MESSAGE
      ===================================================== */

      .pmb-result-message {

         max-width: 650px;

         margin: 0 auto;

         line-height: 1.7;

      }


      .pmb-announcement-date {

         font-size: 12px;

         color: #8a8f98;

         margin-top: 12px;

      }


      /* =====================================================
         MOBILE
      ===================================================== */

      @media (max-width: 991.98px) {

         .pmb-result-section {

            padding-top: 50px;

            padding-bottom: 60px;

         }


         .pmb-page-header h2 {

            font-size: 2.2rem;

         }


         .pmb-result-timeline::before {

            display: none;

         }

      }


      @media (max-width: 767.98px) {

         .pmb-result-section {

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


         .pmb-status-icon {

            width: 58px;

            height: 58px;

            min-width: 58px;

         }


         .pmb-result-box {

            padding: 25px 18px;

         }


         .pmb-result-icon {

            width: 70px;

            height: 70px;

         }


         .pmb-score {

            font-size: 25px;

         }

      }


      @media (max-width: 575.98px) {

         .pmb-page-header h2 {

            font-size: 1.6rem;

         }


         .pmb-status-card .card-body {

            padding: 18px !important;

         }


         .pmb-exam-icon {

            width: 48px;

            height: 48px;

            min-width: 48px;

         }


         .pmb-result-box {

            padding: 20px 15px;

         }


         .pmb-result-timeline-item {

            margin-bottom: 22px;

         }


         .pmb-result-number {

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
     SECTION
====================================================== -->

      <section
         class="wrapper bg-light pmb-result-section">

         <div class="container">


            <!-- =================================================
     HEADER
================================================== -->

            <div class="row pmb-page-header">

               <div class="col-lg-9">

                  <span
                     class="badge
          bg-soft-primary
          text-primary
          rounded-pill
          mb-3">

                     TAHAP 05

                  </span>


                  <h2 class="display-4 mb-3">

                     Pelaksanaan & Hasil Seleksi

                  </h2>


                  <p class="lead fs-18 mb-0">

                     Pantau pelaksanaan seleksi dan lihat hasil
                     seleksi Penerimaan Mahasiswa Baru
                     melalui Portal PMB.

                  </p>

               </div>

            </div>


            <!-- =================================================
     PARTICIPANT
================================================== -->

            <div
               class="card
          shadow-sm
          pmb-participant-card
          mb-7">

               <div class="card-body p-5">

                  <div class="row align-items-center">


                     <div class="col-lg">

                        <div class="d-flex align-items-center">


                           <div
                              class="icon
          btn
          btn-circle
          btn-lg
          btn-soft-primary
          me-4">

                              <i class="uil uil-user"></i>

                           </div>


                           <div>

                              <span
                                 class="text-uppercase
          text-muted
          fs-13
          fw-bold">

                                 Peserta PMB

                              </span>


                              <h4 class="mb-1">

                                 <?= htmlspecialchars(
                                    $namaPeserta,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </h4>


                              <p
                                 class="mb-0
          text-muted
          pmb-participant-id">

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


                     <div
                        class="col-lg-auto
          mt-4
          mt-lg-0">

                        <span
                           class="badge
          bg-soft-primary
          text-primary
          rounded-pill
          px-4
          py-2">

                           <?= htmlspecialchars(
                              $jalur,
                              ENT_QUOTES,
                              'UTF-8'
                           ) ?>

                        </span>

                     </div>


                  </div>

               </div>

            </div>


            <!-- =================================================
     STATUS SELEKSI
================================================== -->

            <div
               class="card
          bg-primary
          text-white
          shadow-lg
          pmb-status-card
          mb-7">

               <div class="card-body p-5 p-md-6">

                  <div class="row align-items-center">


                     <div class="col-lg">

                        <div class="d-flex align-items-center">


                           <div
                              class="pmb-status-icon
          bg-white
          text-primary
          me-4">

                              <i class="uil uil-clipboard-alt fs-28"></i>

                           </div>


                           <div>

                              <span
                                 class="text-white
          opacity-75
          text-uppercase
          fs-13
          fw-bold">

                                 Status Seleksi

                              </span>


                              <h3 class="text-white mt-1 mb-2">

                                 <?= htmlspecialchars(
                                    $statusSeleksiLabel,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </h3>


                              <p
                                 class="text-white
          opacity-75
          mb-0">

                                 <?php if ($statusKelulusan === 'LULUS'): ?>

                                    Seluruh proses seleksi telah selesai
                                    dan hasil telah ditetapkan.

                                 <?php elseif ($statusKelulusan === 'TIDAK_LULUS'): ?>

                                    Seluruh proses seleksi telah selesai
                                    dan hasil telah ditetapkan.

                                 <?php else: ?>

                                    Pastikan seluruh tahapan seleksi yang
                                    dijadwalkan telah Anda ikuti.

                                 <?php endif; ?>

                              </p>

                           </div>

                        </div>

                     </div>


                     <div
                        class="col-lg-auto
          mt-4
          mt-lg-0">

                        <span
                           class="badge
          bg-white
          text-primary
          rounded-pill
          px-4
          py-2">

                           <?= $statusSeleksiBadge ?>

                        </span>

                     </div>


                  </div>

               </div>

            </div>


            <!-- =================================================
     MAIN CONTENT
================================================== -->

            <div class="row gx-lg-8 gy-6">


               <!-- =================================================
     LEFT
================================================== -->

               <div class="col-lg-8">


                  <!-- =================================================
     PELAKSANAAN
================================================== -->

                  <div
                     class="card
          shadow-sm
          border-0
          mb-6">

                     <div class="card-body p-5 p-md-6">


                        <div class="mb-6">

                           <span
                              class="text-uppercase
          text-muted
          fs-13
          fw-bold">

                              Pelaksanaan

                           </span>


                           <h3 class="mt-2 mb-2">

                              Riwayat Seleksi

                           </h3>


                           <p class="text-muted mb-0">

                              Status pelaksanaan dan hasil setiap
                              tahapan seleksi.

                           </p>

                        </div>


                        <!-- =================================================
     TPA
================================================== -->

                        <?php if ($jadwalTPA): ?>

                           <div
                              class="card
          pmb-exam-card
          mb-4">

                              <div class="card-body p-5">


                                 <div
                                    class="d-flex
          align-items-start">


                                    <div
                                       class="pmb-exam-icon
          bg-soft-primary
          text-primary
          me-4">

                                       <i class="uil uil-file-alt fs-24"></i>

                                    </div>


                                    <div class="flex-grow-1">


                                       <div
                                          class="d-flex
          justify-content-between
          align-items-start
          flex-wrap
          gap-2">


                                          <div>

                                             <span
                                                class="badge
          bg-soft-primary
          text-primary
          rounded-pill
          mb-2">

                                                SELEKSI 01

                                             </span>


                                             <h4 class="mb-1">

                                                <?= htmlspecialchars(
                                                   $jadwalTPA['nama_seleksi'],
                                                   ENT_QUOTES,
                                                   'UTF-8'
                                                ) ?>

                                             </h4>

                                          </div>


                                          <span
                                             class="badge
          <?= $tpaSelesai
                              ? 'bg-soft-green text-green'
                              : 'bg-soft-yellow text-yellow'
            ?>
          rounded-pill">

                                             <?php if ($tpaSelesai): ?>

                                                <i class="uil uil-check me-1"></i>
                                                Selesai

                                             <?php else: ?>

                                                <i class="uil uil-clock me-1"></i>
                                                Menunggu Nilai

                                             <?php endif; ?>

                                          </span>


                                       </div>


                                       <hr class="my-4">


                                       <div class="row">


                                          <!-- TANGGAL -->

                                          <div class="col-md-6">

                                             <div class="pmb-exam-info">

                                                <i class="uil uil-calendar-alt"></i>

                                                <div>

                                                   <div class="pmb-exam-label">

                                                      Tanggal

                                                   </div>

                                                   <div class="pmb-exam-value">

                                                      <?= htmlspecialchars(
                                                         formatTanggalIndonesia(
                                                            $jadwalTPA['tanggal'],
                                                            $hariIndonesia,
                                                            $bulanIndonesia
                                                         ),
                                                         ENT_QUOTES,
                                                         'UTF-8'
                                                      ) ?>

                                                   </div>

                                                </div>

                                             </div>

                                          </div>


                                          <!-- WAKTU -->

                                          <div class="col-md-6">

                                             <div class="pmb-exam-info">

                                                <i class="uil uil-clock"></i>

                                                <div>

                                                   <div class="pmb-exam-label">

                                                      Waktu

                                                   </div>

                                                   <div class="pmb-exam-value">

                                                      <?= htmlspecialchars(
                                                         date(
                                                            'H.i',
                                                            strtotime(
                                                               $jadwalTPA['jam_mulai']
                                                            )
                                                         ),
                                                         ENT_QUOTES,
                                                         'UTF-8'
                                                      ) ?>

                                                      –

                                                      <?= htmlspecialchars(
                                                         date(
                                                            'H.i',
                                                            strtotime(
                                                               $jadwalTPA['jam_selesai']
                                                            )
                                                         ),
                                                         ENT_QUOTES,
                                                         'UTF-8'
                                                      ) ?>

                                                      WIB

                                                   </div>

                                                </div>

                                             </div>

                                          </div>


                                          <!-- LOKASI -->

                                          <div class="col-md-6">

                                             <div class="pmb-exam-info">

                                                <i class="uil uil-location-point"></i>

                                                <div>

                                                   <div class="pmb-exam-label">

                                                      Lokasi

                                                   </div>

                                                   <div class="pmb-exam-value">

                                                      <?= htmlspecialchars(
                                                         $jadwalTPA['lokasi'] ?: '-',
                                                         ENT_QUOTES,
                                                         'UTF-8'
                                                      ) ?>

                                                   </div>

                                                </div>

                                             </div>

                                          </div>


                                          <!-- NILAI -->

                                          <div class="col-md-6">

                                             <div class="pmb-exam-info">

                                                <i class="uil uil-chart"></i>

                                                <div>

                                                   <div class="pmb-exam-label">

                                                      Nilai TPA

                                                   </div>

                                                   <div class="pmb-exam-value text-primary">

                                                      <?= $nilaiTPA !== null
                                                         ? number_format(
                                                            $nilaiTPA,
                                                            2,
                                                            ',',
                                                            '.'
                                                         )
                                                         : 'Belum tersedia'
                                                      ?>

                                                   </div>

                                                </div>

                                             </div>

                                          </div>


                                       </div>

                                    </div>

                                 </div>

                              </div>

                           </div>

                        <?php endif; ?>


                        <!-- =================================================
     WAWANCARA
================================================== -->

                        <?php if ($jadwalWawancara): ?>

                           <div
                              class="card
          pmb-exam-card">

                              <div class="card-body p-5">


                                 <div
                                    class="d-flex
          align-items-start">


                                    <div
                                       class="pmb-exam-icon
          bg-soft-green
          text-green
          me-4">

                                       <i class="uil uil-comments fs-24"></i>

                                    </div>


                                    <div class="flex-grow-1">


                                       <div
                                          class="d-flex
          justify-content-between
          align-items-start
          flex-wrap
          gap-2">


                                          <div>

                                             <span
                                                class="badge
          bg-soft-green
          text-green
          rounded-pill
          mb-2">

                                                SELEKSI 02

                                             </span>


                                             <h4 class="mb-1">

                                                <?= htmlspecialchars(
                                                   $jadwalWawancara['nama_seleksi'],
                                                   ENT_QUOTES,
                                                   'UTF-8'
                                                ) ?>

                                             </h4>

                                          </div>


                                          <span
                                             class="badge
          <?= $wawancaraSelesai
                              ? 'bg-soft-green text-green'
                              : 'bg-soft-yellow text-yellow'
            ?>
          rounded-pill">

                                             <?php if ($wawancaraSelesai): ?>

                                                <i class="uil uil-check me-1"></i>
                                                Selesai

                                             <?php else: ?>

                                                <i class="uil uil-clock me-1"></i>
                                                Menunggu Nilai

                                             <?php endif; ?>

                                          </span>


                                       </div>


                                       <hr class="my-4">


                                       <div class="row">


                                          <!-- TANGGAL -->

                                          <div class="col-md-6">

                                             <div class="pmb-exam-info">

                                                <i class="uil uil-calendar-alt"></i>

                                                <div>

                                                   <div class="pmb-exam-label">

                                                      Tanggal

                                                   </div>

                                                   <div class="pmb-exam-value">

                                                      <?= htmlspecialchars(
                                                         formatTanggalIndonesia(
                                                            $jadwalWawancara['tanggal'],
                                                            $hariIndonesia,
                                                            $bulanIndonesia
                                                         ),
                                                         ENT_QUOTES,
                                                         'UTF-8'
                                                      ) ?>

                                                   </div>

                                                </div>

                                             </div>

                                          </div>


                                          <!-- WAKTU -->

                                          <div class="col-md-6">

                                             <div class="pmb-exam-info">

                                                <i class="uil uil-clock"></i>

                                                <div>

                                                   <div class="pmb-exam-label">

                                                      Waktu

                                                   </div>

                                                   <div class="pmb-exam-value">

                                                      <?= htmlspecialchars(
                                                         date(
                                                            'H.i',
                                                            strtotime(
                                                               $jadwalWawancara['jam_mulai']
                                                            )
                                                         ),
                                                         ENT_QUOTES,
                                                         'UTF-8'
                                                      ) ?>

                                                      –

                                                      <?= htmlspecialchars(
                                                         date(
                                                            'H.i',
                                                            strtotime(
                                                               $jadwalWawancara['jam_selesai']
                                                            )
                                                         ),
                                                         ENT_QUOTES,
                                                         'UTF-8'
                                                      ) ?>

                                                      WIB

                                                   </div>

                                                </div>

                                             </div>

                                          </div>


                                          <!-- LOKASI -->

                                          <div class="col-md-6">

                                             <div class="pmb-exam-info">

                                                <i class="uil uil-location-point"></i>

                                                <div>

                                                   <div class="pmb-exam-label">

                                                      Lokasi

                                                   </div>

                                                   <div class="pmb-exam-value">

                                                      <?= htmlspecialchars(
                                                         $jadwalWawancara['lokasi'] ?: '-',
                                                         ENT_QUOTES,
                                                         'UTF-8'
                                                      ) ?>

                                                   </div>

                                                </div>

                                             </div>

                                          </div>


                                          <!-- NILAI -->

                                          <div class="col-md-6">

                                             <div class="pmb-exam-info">

                                                <i class="uil uil-chart"></i>

                                                <div>

                                                   <div class="pmb-exam-label">

                                                      Nilai Wawancara

                                                   </div>

                                                   <div class="pmb-exam-value text-primary">

                                                      <?= $nilaiWawancara !== null
                                                         ? number_format(
                                                            $nilaiWawancara,
                                                            2,
                                                            ',',
                                                            '.'
                                                         )
                                                         : 'Belum tersedia'
                                                      ?>

                                                   </div>

                                                </div>

                                             </div>

                                          </div>


                                       </div>

                                    </div>

                                 </div>

                              </div>

                           </div>

                        <?php endif; ?>


                        <?php if (
                           !$jadwalTPA &&
                           !$jadwalWawancara
                        ): ?>

                           <div class="alert alert-info">

                              <i class="uil uil-info-circle me-2"></i>

                              Jadwal seleksi belum tersedia.

                           </div>

                        <?php endif; ?>


                     </div>

                  </div>


                  <!-- =================================================
     HASIL SELEKSI
================================================== -->

                  <div
                     class="card
          shadow-sm
          border-0
          mb-6">

                     <div class="card-body p-5 p-md-6">


                        <div class="mb-6">

                           <span
                              class="text-uppercase
          text-muted
          fs-13
          fw-bold">

                              Hasil

                           </span>


                           <h3 class="mt-2 mb-2">

                              Hasil Seleksi

                           </h3>


                           <p class="text-muted mb-0">

                              Hasil akhir berdasarkan penilaian TPA
                              dan wawancara.

                           </p>

                        </div>


                        <!-- =================================================
     RESULT BOX
================================================== -->

                        <div
                           class="pmb-result-box">


                           <div
                              class="pmb-result-icon
          <?= $hasilClass ?>">

                              <i
                                 class="uil
          <?= $hasilIcon ?>
          fs-35"></i>

                           </div>


                           <span
                              class="badge
          <?= $hasilBadgeClass ?>
          rounded-pill
          mb-3">

                              <?= $hasilBadge ?>

                           </span>


                           <h3 class="mb-3">

                              <?= $hasilLabel ?>

                           </h3>


                           <p
                              class="text-muted
          mb-0
          pmb-result-message">

                              <?= htmlspecialchars(
                                 $hasilDescription,
                                 ENT_QUOTES,
                                 'UTF-8'
                              ) ?>

                           </p>


                           <?php if (
                              !empty($pmbUser['hasil_diumumkan_at'])
                           ): ?>

                              <div class="pmb-announcement-date">

                                 <i class="uil uil-calendar-alt me-1"></i>

                                 Diumumkan pada:

                                 <?= htmlspecialchars(
                                    date(
                                       'd-m-Y H:i',
                                       strtotime(
                                          $pmbUser['hasil_diumumkan_at']
                                       )
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                                 WIB

                              </div>

                           <?php endif; ?>


                           <?php if (
                              $statusKelulusan !==
                              'BELUM_DIUMUMKAN'
                              &&
                              !empty($catatanHasil)
                           ): ?>

                              <div class="mt-4">

                                 <div class="alert alert-light mb-0">

                                    <strong>
                                       Catatan Panitia
                                    </strong>

                                    <br>

                                    <?= nl2br(
                                       htmlspecialchars(
                                          $catatanHasil,
                                          ENT_QUOTES,
                                          'UTF-8'
                                       )
                                    ) ?>

                                 </div>

                              </div>

                           <?php endif; ?>


                        </div>


                        <!-- =================================================
     SCORE
================================================== -->

                        <div class="row gx-3 mt-5">


                           <div class="col-md-4 mb-3 mb-md-0">

                              <div class="pmb-score-card">

                                 <div class="pmb-score text-primary">

                                    <?= $nilaiTPA !== null
                                       ? number_format(
                                          $nilaiTPA,
                                          2,
                                          ',',
                                          '.'
                                       )
                                       : '—'
                                    ?>

                                 </div>


                                 <div class="pmb-score-label">

                                    Nilai TPA

                                 </div>

                              </div>

                           </div>


                           <div class="col-md-4 mb-3 mb-md-0">

                              <div class="pmb-score-card">

                                 <div class="pmb-score text-primary">

                                    <?= $nilaiWawancara !== null
                                       ? number_format(
                                          $nilaiWawancara,
                                          2,
                                          ',',
                                          '.'
                                       )
                                       : '—'
                                    ?>

                                 </div>


                                 <div class="pmb-score-label">

                                    Nilai Wawancara

                                 </div>

                              </div>

                           </div>


                           <div class="col-md-4">

                              <div class="pmb-score-card">

                                 <div class="pmb-score text-primary">

                                    <?= $nilaiAkhir !== null
                                       ? number_format(
                                          $nilaiAkhir,
                                          2,
                                          ',',
                                          '.'
                                       )
                                       : '—'
                                    ?>

                                 </div>


                                 <div class="pmb-score-label">

                                    Nilai Akhir

                                 </div>

                              </div>

                           </div>


                        </div>


                        <div class="text-center mt-4">

                           <small class="text-muted">

                              Bobot Nilai Akhir:
                              TPA 50% + Wawancara 50%

                           </small>

                        </div>


                     </div>

                  </div>


                  <!-- =================================================
     TIMELINE
================================================== -->

                  <div
                     class="card
          shadow-sm
          border-0">

                     <div class="card-body p-5 p-md-6">


                        <span
                           class="text-uppercase
          text-muted
          fs-13
          fw-bold">

                           Proses PMB

                        </span>


                        <h3 class="mt-2 mb-6">

                           Perjalanan Pendaftaran Anda

                        </h3>


                        <div
                           class="pmb-result-timeline">


                           <!-- 01 -->

                           <div class="pmb-result-timeline-item">

                              <div class="pmb-result-number complete">

                                 <i class="uil uil-check"></i>

                              </div>


                              <div>

                                 <h5 class="mb-1">

                                    Registrasi Akun

                                 </h5>


                                 <p class="text-muted fs-14 mb-0">

                                    Akun PMB berhasil dibuat.

                                 </p>

                              </div>

                           </div>


                           <!-- 02 -->

                           <div class="pmb-result-timeline-item">

                              <div class="pmb-result-number complete">

                                 <i class="uil uil-check"></i>

                              </div>


                              <div>

                                 <h5 class="mb-1">

                                    Data & Dokumen

                                 </h5>


                                 <p class="text-muted fs-14 mb-0">

                                    Biodata dan dokumen telah dilengkapi.

                                 </p>

                              </div>

                           </div>


                           <!-- 03 -->

                           <div class="pmb-result-timeline-item">

                              <div
                                 class="pmb-result-number
   complete">

                                 <i class="uil uil-check"></i>

                              </div>


                              <div>

                                 <h5 class="mb-1">

                                    Kartu Peserta

                                 </h5>


                                 <p class="text-muted fs-14 mb-0">

                                    Kartu peserta telah diterbitkan.

                                 </p>

                              </div>

                           </div>


                           <!-- 04 -->

                           <div class="pmb-result-timeline-item">

                              <div
                                 class="pmb-result-number
   complete">

                                 <i class="uil uil-check"></i>

                              </div>


                              <div>

                                 <h5 class="mb-1">

                                    Jadwal Seleksi

                                 </h5>


                                 <p class="text-muted fs-14 mb-0">

                                    Jadwal seleksi telah diterbitkan.

                                 </p>

                              </div>

                           </div>


                           <!-- 05 -->

                           <div class="pmb-result-timeline-item">

                              <div
                                 class="pmb-result-number
   <?= $statusKelulusan !== 'BELUM_DIUMUMKAN'
      ? 'complete'
      : 'active'
   ?>">

                                 <?php if (
                                    $statusKelulusan !==
                                    'BELUM_DIUMUMKAN'
                                 ): ?>

                                    <i class="uil uil-check"></i>

                                 <?php else: ?>

                                    5

                                 <?php endif; ?>

                              </div>


                              <div>

                                 <h5 class="mb-1">

                                    Pelaksanaan & Hasil Seleksi

                                 </h5>


                                 <p class="text-muted fs-14 mb-0">

                                    <?php if (
                                       $statusKelulusan === 'LULUS'
                                    ): ?>

                                       Seleksi selesai dan peserta dinyatakan lulus.

                                    <?php elseif (
                                       $statusKelulusan === 'TIDAK_LULUS'
                                    ): ?>

                                       Seleksi selesai dan hasil telah ditetapkan.

                                    <?php else: ?>

                                       Menunggu seluruh proses seleksi selesai.

                                    <?php endif; ?>

                                 </p>

                              </div>

                           </div>


                        </div>

                     </div>

                  </div>


               </div>


               <!-- =================================================
     RIGHT
================================================== -->

               <div class="col-lg-4">


                  <!-- =================================================
     ACTION
================================================== -->

                  <div
                     class="card
          bg-primary
          text-white
          border-0
          shadow-lg
          mb-6">

                     <div class="card-body p-6">


                        <span
                           class="text-white
          opacity-75
          text-uppercase
          fs-13
          fw-bold">

                           Tindakan Anda

                        </span>


                        <h3
                           class="text-white
          mt-2
          mb-4">

                           <?php if (
                              $statusKelulusan === 'LULUS'
                           ): ?>

                              Lanjutkan Daftar Ulang

                           <?php elseif (
                              $statusKelulusan === 'TIDAK_LULUS'
                           ): ?>

                              Informasi Hasil Seleksi

                           <?php else: ?>

                              Pantau Hasil Seleksi

                           <?php endif; ?>

                        </h3>


                        <p
                           class="text-white
          opacity-75
          mb-5">

                           <?php if (
                              $statusKelulusan === 'LULUS'
                           ): ?>

                              Anda dapat melanjutkan ke proses
                              daftar ulang melalui Portal PMB.

                           <?php elseif (
                              $statusKelulusan === 'TIDAK_LULUS'
                           ): ?>

                              Informasi hasil seleksi Anda telah
                              ditetapkan oleh panitia.

                           <?php else: ?>

                              Hasil akan tersedia setelah proses
                              seleksi selesai.

                           <?php endif; ?>

                        </p>


                        <?php if (
                           $statusKelulusan === 'LULUS'
                        ): ?>

                           <div class="d-grid">

                              <a
                                 href="./pmb/register-repeat"
                                 class="btn btn-white text-primary rounded">

                                 Daftar Ulang

                                 <i class="uil uil-arrow-right ms-1"></i>

                              </a>

                           </div>

                        <?php else: ?>

                           <div class="d-grid">

                              <a
                                 href="./pmb/register-schedule.php"
                                 class="btn btn-white text-primary rounded">

                                 Lihat Jadwal Seleksi

                                 <i class="uil uil-arrow-right ms-1"></i>

                              </a>

                           </div>

                        <?php endif; ?>


                     </div>

                  </div>


                  <!-- =================================================
     RESULT INFORMATION
================================================== -->

                  <div
                     class="card
          shadow-sm
          border-0
          mb-6">

                     <div class="card-body p-6">


                        <span
                           class="text-uppercase
          text-muted
          fs-13
          fw-bold">

                           Informasi Penilaian

                        </span>


                        <h4 class="mt-2 mb-5">

                           Komponen Nilai

                        </h4>


                        <div class="d-flex mb-4">

                           <div
                              class="icon
          btn
          btn-circle
          btn-sm
          btn-soft-primary
          me-3
          flex-shrink-0">

                              <i class="uil uil-file-alt"></i>

                           </div>


                           <div>

                              <h6 class="mb-1">

                                 Tes Potensi Akademik

                              </h6>


                              <p
                                 class="text-muted
          fs-13
          mb-0">

                                 Bobot nilai:

                                 <strong>50%</strong>

                              </p>

                           </div>

                        </div>


                        <div class="d-flex mb-4">

                           <div
                              class="icon
          btn
          btn-circle
          btn-sm
          btn-soft-green
          me-3
          flex-shrink-0">

                              <i class="uil uil-comments"></i>

                           </div>


                           <div>

                              <h6 class="mb-1">

                                 Wawancara

                              </h6>


                              <p
                                 class="text-muted
          fs-13
          mb-0">

                                 Bobot nilai:

                                 <strong>50%</strong>

                              </p>

                           </div>

                        </div>


                        <div class="d-flex">

                           <div
                              class="icon
          btn
          btn-circle
          btn-sm
          btn-soft-yellow
          me-3
          flex-shrink-0">

                              <i class="uil uil-calculator-alt"></i>

                           </div>


                           <div>

                              <h6 class="mb-1">

                                 Nilai Akhir

                              </h6>


                              <p
                                 class="text-muted
          fs-13
          mb-0">

                                 TPA × 50% + Wawancara × 50%

                              </p>

                           </div>

                        </div>


                     </div>

                  </div>


                  <!-- =================================================
     HELP
================================================== -->

                  <div
                     class="card
          bg-soft-yellow
          border-0">

                     <div class="card-body p-6">


                        <div
                           class="icon
          btn
          btn-circle
          btn-sm
          btn-soft-yellow
          mb-4">

                           <i class="uil uil-headphones"></i>

                        </div>


                        <h4 class="mb-2">

                           Butuh Bantuan?

                        </h4>


                        <p
                           class="text-muted
          fs-14
          mb-4">

                           Jika terdapat kendala pada hasil atau
                           status seleksi, silakan hubungi panitia PMB.

                        </p>


                        <a
                           href="https://wa.me/6281367969843?text=Halo%20Panitia%20PMB%20STIH%20Graha%20Kirana%2C%20saya%20ingin%20bertanya%20mengenai%20hasil%20seleksi."
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn
          btn-sm
          btn-outline-primary
          rounded">

                           Hubungi Panitia

                           <i class="uil uil-whatsapp ms-1"></i>

                        </a>


                     </div>

                  </div>


               </div>


            </div>


            <!-- =================================================
     NEXT STEP
================================================== -->

            <div
               class="row
          mt-8">

               <div
                  class="col-lg-10
          mx-auto">


                  <div
                     class="card
          bg-soft-primary
          border-0">


                     <div class="card-body p-5">


                        <div class="row align-items-center">


                           <div class="col-lg">


                              <div class="d-flex align-items-center">


                                 <div
                                    class="icon
          btn
          btn-circle
          btn-lg
          btn-primary
          me-4">

                                    <i class="uil uil-award"></i>

                                 </div>


                                 <div>

                                    <span
                                       class="text-uppercase
          text-muted
          fs-13
          fw-bold">

                                       Tahap Berikutnya

                                    </span>


                                    <h4 class="mb-1">

                                       <?php if (
                                          $statusKelulusan === 'LULUS'
                                       ): ?>

                                          Daftar Ulang

                                       <?php elseif (
                                          $statusKelulusan === 'TIDAK_LULUS'
                                       ): ?>

                                          Proses PMB Selesai

                                       <?php else: ?>

                                          Pengumuman Kelulusan

                                       <?php endif; ?>

                                    </h4>


                                    <p class="mb-0 text-muted">

                                       <?php if (
                                          $statusKelulusan === 'LULUS'
                                       ): ?>

                                          Selamat! Anda dapat melanjutkan
                                          ke proses daftar ulang.

                                       <?php elseif (
                                          $statusKelulusan === 'TIDAK_LULUS'
                                       ): ?>

                                          Hasil seleksi telah ditetapkan.

                                       <?php else: ?>

                                          Setelah hasil seleksi ditetapkan,
                                          status kelulusan akan tersedia
                                          melalui Portal PMB.

                                       <?php endif; ?>

                                    </p>

                                 </div>

                              </div>

                           </div>


                           <div
                              class="col-lg-auto
          mt-4
          mt-lg-0">

                              <span
                                 class="badge
          bg-soft-primary
          text-primary
          rounded-pill
          px-4
          py-2">

                                 <?php if (
                                    $statusKelulusan === 'LULUS'
                                 ): ?>

                                    TAHAP 07

                                 <?php elseif (
                                    $statusKelulusan === 'TIDAK_LULUS'
                                 ): ?>

                                    SELESAI

                                 <?php else: ?>

                                    TAHAP 06

                                 <?php endif; ?>


                                 <i class="uil uil-arrow-right ms-1"></i>

                              </span>

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


   <script src="./assets/js/plugins.js"></script>

   <script src="./assets/js/theme.js"></script>


</body>

</html>