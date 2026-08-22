<?php

session_start();

/**
 * =========================================================
 * AUTHENTICATION GUARD
 * =========================================================
 */

if (
   empty($_SESSION['pmb_logged_in']) ||
   empty($_SESSION['pmb_user_id'])
) {

   header('Location: login-pmb');
   exit;
}


/**
 * =========================================================
 * DATABASE
 * =========================================================
 */

require_once __DIR__ . '/../config/connect.php';


/**
 * =========================================================
 * AMBIL DATA USER TERBARU
 * =========================================================
 */

try {

   $stmt = $pdo->prepare("
        SELECT
            id,
            fullname,
            email_register,
            phone_number,
            register_uid,
            register_type,
            tahap_aktif,
            status_pendaftaran,
            account_status
        FROM register_pmb
        WHERE id = :id
        LIMIT 1
    ");

   $stmt->execute([
      'id' => (int) $_SESSION['pmb_user_id']
   ]);

   $pmbUser = $stmt->fetch(PDO::FETCH_ASSOC);


   /**
    * User tidak ditemukan
    */

   if (!$pmbUser) {

      session_unset();
      session_destroy();

      header('Location: login-pmb');
      exit;
   }


   /**
    * Akun diblokir
    */

   if ($pmbUser['account_status'] === 'BLOCKED') {

      session_unset();
      session_destroy();

      header('Location: login-pmb?status=blocked');
      exit;
   }


   /**
    * Update session dari database
    */

   $_SESSION['pmb_fullname'] =
      $pmbUser['fullname'];

   $_SESSION['pmb_email'] =
      $pmbUser['email_register'];

   $_SESSION['pmb_tahap_aktif'] =
      (int) $pmbUser['tahap_aktif'];

   $_SESSION['pmb_status_pendaftaran'] =
      $pmbUser['status_pendaftaran'];


   /**
    * Tahap aktif
    */

   $tahapAktif =
      max(
         1,
         min(
            8,
            (int) $pmbUser['tahap_aktif']
         )
      );
} catch (PDOException $e) {

   http_response_code(500);

   die('Terjadi kesalahan saat memuat dashboard.');
}


/**
 * =========================================================
 * KONFIGURASI TAHAP PMB
 * =========================================================
 */

$pmbStages = [

   1 => [
      'name' => 'Pendaftaran',
      'icon' => 'uil-edit',
      'page' => 'pmb/register-data'
   ],

   2 => [
      'name' => 'Data & Dokumen',
      'icon' => 'uil-file-alt',
      'page' => 'pmb/register-data.php'
   ],

   3 => [
      'name' => 'Kartu Peserta',
      'icon' => 'uil-credit-card',
      'page' => 'kartu-peserta.php'
   ],

   4 => [
      'name' => 'Jadwal Seleksi',
      'icon' => 'uil-calendar-alt',
      'page' => 'jadwal-seleksi.php'
   ],

   5 => [
      'name' => 'Seleksi',
      'icon' => 'uil-clipboard-alt',
      'page' => 'hasil-seleksi.php'
   ],

   6 => [
      'name' => 'Kelulusan',
      'icon' => 'uil-trophy',
      'page' => 'pengumuman-kelulusan.php'
   ],

   7 => [
      'name' => 'Daftar Ulang',
      'icon' => 'uil-file-check-alt',
      'page' => 'daftar-ulang.php'
   ],

   8 => [
      'name' => 'SIAKAD',
      'icon' => 'uil-graduation-cap',
      'page' => 'siakad.php'
   ]

];


/**
 * =========================================================
 * PROGRESS
 * =========================================================
 */

$progress =
   (($tahapAktif - 1) / 8) * 100;

$progress =
   max(0, min(100, $progress));

$progressFormatted =
   number_format($progress, 1);

$completedStages =
   max(0, $tahapAktif - 1);


/**
 * =========================================================
 * STATUS TAHAP AKTIF
 * =========================================================
 */

$currentStage =
   $pmbStages[$tahapAktif];

?>
<?php

$tahapAktif = (int) ($pmbUser['tahap_aktif'] ?? 1);

$statusPendaftaran =
   $pmbUser['status_pendaftaran'] ?? 'REGISTRASI';


// =========================================================
// STATUS KELULUSAN
// =========================================================

if ($statusPendaftaran === 'LULUS') {

   $statusKelulusan = 'LULUS';

   $statusKelulusanClass = 'text-green';

   $statusKelulusanBg = 'bg-soft-green';

   $statusKelulusanIcon = 'uil-check-circle';
} elseif ($statusPendaftaran === 'TIDAK_LULUS') {

   $statusKelulusan = 'TIDAK LULUS';

   $statusKelulusanClass = 'text-red';

   $statusKelulusanBg = 'bg-soft-red';

   $statusKelulusanIcon = 'uil-times-circle';
} elseif ($tahapAktif >= 5) {

   $statusKelulusan = 'Menunggu Hasil';

   $statusKelulusanClass = 'text-yellow';

   $statusKelulusanBg = 'bg-soft-yellow';

   $statusKelulusanIcon = 'uil-clock';
} else {

   $statusKelulusan = 'Belum Seleksi';

   $statusKelulusanClass = 'text-muted';

   $statusKelulusanBg = 'bg-soft-gray';

   $statusKelulusanIcon = 'uil-minus-circle';
}


// =========================================================
// PROGRAM STUDI
// =========================================================

$programStudi = '-';

if (!empty($pmbUser['id_program'])) {

   /*
    * Sementara karena tabel program studi belum
    * kita hubungkan di controller.
    *
    * Nanti ganti dengan nama program studi
    * dari tabel program.
    */

   $programStudi =
      'Program Studi #' .
      (int) $pmbUser['id_program'];
}


// =========================================================
// STATUS DAFTAR ULANG
// =========================================================

if ($statusPendaftaran === 'MAHASISWA') {

   $statusDaftarUlang = 'Selesai';

   $statusDaftarUlangClass = 'text-green';

   $statusDaftarUlangBg = 'bg-soft-green';

   $statusDaftarUlangIcon = 'uil-check-circle';
} elseif ($statusPendaftaran === 'DAFTAR_ULANG') {

   $statusDaftarUlang = 'Belum Diajukan';

   $statusDaftarUlangClass = 'text-yellow';

   $statusDaftarUlangBg = 'bg-soft-yellow';

   $statusDaftarUlangIcon = 'uil-clock';
} else {

   $statusDaftarUlang = 'Belum Dibuka';

   $statusDaftarUlangClass = 'text-muted';

   $statusDaftarUlangBg = 'bg-soft-gray';

   $statusDaftarUlangIcon = 'uil-lock';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

   <base href="../">

   <?php
   $page = 'Dashboard PMB';
   require '../head.php';
   ?>

   <style>
      /* =========================================================
         PMB DASHBOARD
      ========================================================= */

      .pmb-dashboard {
         padding-top: 55px;
         padding-bottom: 90px;
      }

      .pmb-dashboard-header {
         margin-bottom: 35px;
      }

      .pmb-dashboard-header h2 {
         font-size: 2.5rem;
      }


      /* =========================================================
         WELCOME CARD
      ========================================================= */

      .pmb-welcome-card {
         border: 0;
         overflow: hidden;
         position: relative;
      }

      .pmb-welcome-card::before {
         content: "";
         position: absolute;
         width: 300px;
         height: 300px;
         border-radius: 50%;
         background: rgba(255, 255, 255, .07);
         right: -100px;
         top: -160px;
      }

      .pmb-welcome-card::after {
         content: "";
         position: absolute;
         width: 180px;
         height: 180px;
         border-radius: 50%;
         background: rgba(255, 255, 255, .05);
         left: -80px;
         bottom: -100px;
      }

      .pmb-welcome-content {
         position: relative;
         z-index: 2;
      }

      .pmb-avatar {
         width: 72px;
         height: 72px;
         min-width: 72px;
         border-radius: 50%;
         background: #fff;
         color: #3f78e0;
         display: flex;
         align-items: center;
         justify-content: center;
      }


      /* =========================================================
         PARTICIPANT META
      ========================================================= */

      .pmb-meta {
         display: flex;
         flex-wrap: wrap;
         gap: 8px 25px;
      }

      .pmb-meta-item {
         font-size: 13px;
      }


      /* =========================================================
         PROGRESS
      ========================================================= */

      .pmb-progress-card {
         border: 0;
      }

      .pmb-progress {
         height: 9px;
         background: #e9edf2;
         border-radius: 20px;
         overflow: hidden;
      }

      .pmb-progress-bar {
         height: 100%;
         width: 87.5%;
         background: #3f78e0;
         border-radius: 20px;
      }


      /* =========================================================
         STAGE TABS
      ========================================================= */

      .pmb-stage-nav {
         display: flex;
         gap: 10px;
         overflow-x: auto;
         padding-bottom: 8px;
         scrollbar-width: thin;
      }

      .pmb-stage-nav::-webkit-scrollbar {
         height: 5px;
      }

      .pmb-stage-tab {
         flex: 0 0 auto;
         min-width: 105px;
         border: 1px solid #e5e9ef;
         background: #fff;
         border-radius: 12px;
         padding: 15px 12px;
         text-align: center;
         transition: all .2s ease;
         cursor: pointer;
      }

      .pmb-stage-tab:hover {
         border-color: #3f78e0;
         transform: translateY(-2px);
      }

      .pmb-stage-tab.active {
         background: #3f78e0;
         border-color: #3f78e0;
         color: #fff;
         box-shadow: 0 8px 20px rgba(63, 120, 224, .18);
      }

      .pmb-stage-tab.locked {
         background: #f8f9fa;
         color: #9aa1aa;
         cursor: not-allowed;
      }

      .pmb-stage-number {
         font-size: 11px;
         font-weight: 700;
         letter-spacing: .5px;
         margin-bottom: 6px;
      }

      .pmb-stage-name {
         font-size: 12px;
         font-weight: 600;
         line-height: 1.35;
      }

      .pmb-stage-check {
         display: block;
         font-size: 15px;
         margin-bottom: 5px;
      }


      /* =========================================================
         CURRENT STAGE
      ========================================================= */

      .pmb-current-card {
         border: 0;
      }

      .pmb-current-icon {
         width: 65px;
         height: 65px;
         min-width: 65px;
         border-radius: 14px;
         display: flex;
         align-items: center;
         justify-content: center;
      }


      /* =========================================================
         PREVIEW CONTENT
      ========================================================= */

      .pmb-preview-row {
         display: flex;
         align-items: flex-start;
         padding: 17px 0;
         border-bottom: 1px solid #edf0f3;
      }

      .pmb-preview-row:last-child {
         border-bottom: 0;
      }

      .pmb-preview-icon {
         width: 40px;
         height: 40px;
         min-width: 40px;
         border-radius: 9px;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-right: 13px;
      }

      .pmb-preview-label {
         font-size: 12px;
         color: #8a8f98;
         margin-bottom: 3px;
      }

      .pmb-preview-value {
         font-size: 14px;
         font-weight: 600;
      }


      /* =========================================================
         SIDE TIMELINE
      ========================================================= */

      .pmb-timeline {
         position: relative;
      }

      .pmb-timeline::before {
         content: "";
         position: absolute;
         left: 21px;
         top: 25px;
         bottom: 25px;
         width: 2px;
         background: #e7ebf0;
      }

      .pmb-timeline-item {
         display: flex;
         position: relative;
         z-index: 2;
         margin-bottom: 22px;
      }

      .pmb-timeline-item:last-child {
         margin-bottom: 0;
      }

      .pmb-timeline-number {
         width: 44px;
         height: 44px;
         min-width: 44px;
         border-radius: 50%;
         border: 2px solid #dfe4ea;
         background: #fff;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-right: 15px;
         color: #8a8f98;
         font-size: 13px;
         font-weight: 700;
      }

      .pmb-timeline-number.complete {
         background: #2b9a59;
         border-color: #2b9a59;
         color: #fff;
      }

      .pmb-timeline-number.active {
         background: #3f78e0;
         border-color: #3f78e0;
         color: #fff;
      }

      .pmb-timeline-number.locked {
         background: #f8f9fa;
      }


      /* =========================================================
         QUICK MENU
      ========================================================= */

      .pmb-quick-card {
         border: 0;
         height: 100%;
      }

      .pmb-quick-item {
         display: flex;
         align-items: center;
         padding: 13px 0;
         border-bottom: 1px solid #edf0f3;
      }

      .pmb-quick-item:last-child {
         border-bottom: 0;
      }

      .pmb-quick-icon {
         width: 40px;
         height: 40px;
         min-width: 40px;
         border-radius: 9px;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-right: 12px;
      }


      /* =========================================================
         MOBILE
      ========================================================= */

      @media (max-width: 991.98px) {

         .pmb-dashboard {
            padding-top: 45px;
            padding-bottom: 70px;
         }

         .pmb-dashboard-header h2 {
            font-size: 2.2rem;
         }

         .pmb-timeline::before {
            display: none;
         }

      }


      @media (max-width: 767.98px) {

         .pmb-dashboard {
            padding-top: 30px;
            padding-bottom: 55px;
         }

         .pmb-dashboard-header h2 {
            font-size: 1.8rem;
         }

         .pmb-dashboard-header p {
            font-size: 14px;
            line-height: 1.6;
         }

         .pmb-welcome-card .card-body {
            padding: 25px 20px !important;
         }

         .pmb-avatar {
            width: 58px;
            height: 58px;
            min-width: 58px;
         }

         .pmb-meta {
            display: block;
         }

         .pmb-meta-item {
            margin-bottom: 5px;
         }

         .pmb-current-card .card-body,
         .pmb-progress-card .card-body {
            padding: 22px !important;
         }

      }


      @media (max-width: 575.98px) {

         .pmb-dashboard-header h2 {
            font-size: 1.6rem;
         }

         .pmb-stage-tab {
            min-width: 90px;
            padding: 12px 8px;
         }

         .pmb-stage-name {
            font-size: 11px;
         }

         .pmb-current-icon {
            width: 52px;
            height: 52px;
            min-width: 52px;
         }

         .pmb-preview-row {
            display: block;
         }

         .pmb-preview-icon {
            margin-bottom: 10px;
         }

         .pmb-timeline-item {
            margin-bottom: 18px;
         }

      }
   </style>

</head>


<body>

   <div class="content-wrapper">

      <?php
      require '../navbar.php';
      ?>


      <!-- =========================================================
        DASHBOARD
   ========================================================== -->

      <section class="wrapper bg-light pmb-dashboard">

         <div class="container">


            <!-- =====================================================
              HEADER
         ====================================================== -->

            <div class="row pmb-dashboard-header">

               <div class="col-lg-8">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

                     PORTAL PMB

                  </span>

                  <h2 class="display-4 mb-3">

                     Selamat Datang,
                     <?= htmlspecialchars($pmbUser['fullname']) ?>! 👋

                  </h2>
                  <p class="lead fs-18 mb-0">

                     Pantau seluruh proses Penerimaan Mahasiswa Baru
                     Anda dari satu dashboard.

                  </p>

               </div>

            </div>


            <!-- =====================================================
              WELCOME
         ====================================================== -->

            <div class="card bg-primary text-white shadow-lg pmb-welcome-card mb-6">

               <div class="card-body p-5 p-md-6">

                  <div class="pmb-welcome-content">

                     <div class="row align-items-center">


                        <div class="col-lg">

                           <div class="d-flex align-items-center">


                              <div class="pmb-avatar me-4">

                                 <i class="uil uil-user fs-30"></i>

                              </div>


                              <div>

                                 <span class="text-white opacity-75 text-uppercase fs-13 fw-bold">

                                    Peserta PMB

                                 </span>

                                 <h3 class="text-white mt-1 mb-2">

                                    <?= htmlspecialchars($pmbUser['fullname']) ?>

                                 </h3>


                                 <div class="pmb-meta">

                                    <span class="pmb-meta-item text-white opacity-75">

                                       <i class="uil uil-card-atm me-1"></i>

                                       UID:

                                       <strong class="text-white">

                                          <?= htmlspecialchars($pmbUser['register_uid'] ?? '-') ?>

                                       </strong>

                                    </span>


                                    <span class="pmb-meta-item text-white opacity-75">

                                       <i class="uil uil-envelope me-1"></i>

                                       <?= htmlspecialchars($pmbUser['email_register']) ?>

                                    </span>


                                    <span class="pmb-meta-item text-white opacity-75">

                                       <i class="uil uil-sign-alt me-1"></i>

                                       <?= htmlspecialchars($pmbUser['register_type'] ?? '-') ?>

                                    </span>

                                 </div>
                              </div>

                           </div>

                        </div>


                        <div class="col-lg-auto mt-4 mt-lg-0">

                           <span class="badge bg-white text-primary rounded-pill px-4 py-2">

                              AKTIF

                           </span>

                        </div>


                     </div>

                  </div>

               </div>

            </div>


            <!-- =====================================================
              PROGRESS
         ====================================================== -->

            <div class="card shadow-sm pmb-progress-card mb-6">

               <div class="card-body p-5">


                  <div class="row align-items-center mb-4">

                     <div class="col">

                        <span class="text-uppercase text-muted fs-13 fw-bold">

                           Progress Pendaftaran

                        </span>

                        <h4 class="mt-2 mb-0">

                           Tahap <?= $tahapAktif ?> dari 08

                        </h4>

                     </div>


                     <div class="col-auto">

                        <strong class="text-primary">

                           <?= $progressFormatted ?>%

                        </strong>

                     </div>

                  </div>


                  <div class="pmb-progress">

                     <div
                        class="pmb-progress-bar"
                        style="width: <?= $progress ?>%;">

                     </div>

                  </div>


                  <div class="d-flex justify-content-between mt-3">

                     <small class="text-green fw-bold">

                        ✓ <?= $completedStages ?> tahap selesai

                     </small>


                     <small class="text-primary fw-bold">

                        <?= htmlspecialchars($currentStage['name']) ?> aktif

                     </small>

                  </div>


               </div>

            </div>


            <!-- =====================================================
              STAGE TABS
         ====================================================== -->

            <div class="card shadow-sm border-0 mb-6">

               <div class="card-body p-4">


                  <div class="mb-4">

                     <span class="text-uppercase text-muted fs-13 fw-bold">

                        Perjalanan PMB

                     </span>

                     <h4 class="mt-2 mb-0">

                        Tahapan Pendaftaran

                     </h4>

                  </div>


                  <div class="pmb-stage-nav">

                     <?php foreach ($pmbStages as $number => $stage): ?>

                        <?php

                        $isComplete = $number < $tahapAktif;
                        $isActive   = $number === $tahapAktif;
                        $isLocked   = $number > $tahapAktif;

                        if ($isComplete) {
                           $class = 'complete';
                        } elseif ($isActive) {
                           $class = 'active';
                        } else {
                           $class = 'locked';
                        }

                        ?>

                        <button
                           type="button"
                           class="pmb-stage-tab <?= $class ?>"
                           data-stage="<?= $number ?>"
                           <?= $isLocked ? 'disabled' : '' ?>>

                           <span class="pmb-stage-check">

                              <?php if ($isComplete): ?>

                                 ✓

                              <?php elseif ($isActive): ?>

                                 ●

                              <?php else: ?>

                                 🔒

                              <?php endif; ?>

                           </span>

                           <div class="pmb-stage-number">

                              TAHAP <?= str_pad($number, 2, '0', STR_PAD_LEFT) ?>

                           </div>

                           <div class="pmb-stage-name">

                              <?= htmlspecialchars($stage['name']) ?>

                           </div>

                        </button>

                     <?php endforeach; ?>

                  </div>

               </div>

            </div>


            <!-- =====================================================
              CURRENT STAGE
         ====================================================== -->

            <div id="stageContent">


               <div class="row gx-lg-8 gy-6">


                  <!-- =================================================
                    MAIN
               ================================================== -->

                  <div class="col-lg-8">


                     <div class="card shadow-sm pmb-current-card">

                        <div class="card-body p-5 p-md-6">


                           <div class="d-flex align-items-start mb-6">

                              <div class="pmb-current-icon bg-soft-primary text-primary me-4">

                                 <i class="uil <?= htmlspecialchars($currentStage['icon']) ?> fs-28"></i>

                              </div>


                              <div>

                                 <span class="text-uppercase text-primary fs-13 fw-bold">

                                    TAHAP <?= str_pad($tahapAktif, 2, '0', STR_PAD_LEFT) ?>

                                 </span>


                                 <h3 class="mt-1 mb-2">

                                    <?= htmlspecialchars($currentStage['name']) ?>

                                 </h3>


                                 <p class="text-muted mb-0">

                                    <?= $tahapAktif === 1
                                       ? 'Lengkapi proses registrasi untuk melanjutkan ke tahap berikutnya.'
                                       : 'Silakan lanjutkan proses pada tahap ini untuk melanjutkan pendaftaran Anda.'
                                    ?>

                                 </p>

                              </div>

                           </div>


                           <!-- Status -->

                           <div class="alert alert-primary alert-icon mb-5">

                              <i class="uil uil-info-circle"></i>

                              <p class="mb-0">

                                 Tahap ini sedang aktif.
                                 Silakan selesaikan seluruh persyaratan
                                 sebelum batas waktu yang ditentukan.

                              </p>

                           </div>

                           <!-- =================================================
     PREVIEW : STATUS KELULUSAN
================================================== -->

                           <div class="pmb-preview-row">

                              <div
                                 class="pmb-preview-icon
      <?= $statusKelulusanBg ?>
      <?= $statusKelulusanClass ?>">

                                 <i class="uil <?= $statusKelulusanIcon ?>"></i>

                              </div>

                              <div>

                                 <div class="pmb-preview-label">

                                    Status Kelulusan

                                 </div>

                                 <div
                                    class="pmb-preview-value
         <?= $statusKelulusanClass ?>">

                                    <?= htmlspecialchars(
                                       $statusKelulusan
                                    ) ?>

                                 </div>

                              </div>

                           </div>


                           <!-- =================================================
     PREVIEW : PROGRAM STUDI
================================================== -->

                           <div class="pmb-preview-row">

                              <div
                                 class="pmb-preview-icon
      bg-soft-primary
      text-primary">

                                 <i class="uil uil-graduation-cap"></i>

                              </div>

                              <div>

                                 <div class="pmb-preview-label">

                                    Program Studi

                                 </div>

                                 <div class="pmb-preview-value">

                                    <?= htmlspecialchars(
                                       $programStudi
                                    ) ?>

                                 </div>

                              </div>

                           </div>


                           <!-- =================================================
     PREVIEW : DAFTAR ULANG
================================================== -->

                           <div class="pmb-preview-row">

                              <div
                                 class="pmb-preview-icon
      <?= $statusDaftarUlangBg ?>
      <?= $statusDaftarUlangClass ?>">

                                 <i class="uil <?= $statusDaftarUlangIcon ?>"></i>

                              </div>

                              <div>

                                 <div class="pmb-preview-label">

                                    Status Daftar Ulang

                                 </div>

                                 <div
                                    class="pmb-preview-value
         <?= $statusDaftarUlangClass ?>">

                                    <?= htmlspecialchars(
                                       $statusDaftarUlang
                                    ) ?>

                                 </div>

                              </div>

                           </div>

                           <div class="d-flex justify-content-end mt-5">

                              <a
                                 href="./<?= htmlspecialchars($currentStage['page']) ?>"
                                 class="btn btn-primary rounded btn-icon btn-icon-end">

                                 Lanjutkan <?= htmlspecialchars($currentStage['name']) ?>

                                 <i class="uil uil-arrow-right"></i>

                              </a>

                           </div>


                        </div>

                     </div>

                  </div>


                  <!-- =================================================
                    SIDE
               ================================================== -->

                  <div class="col-lg-4">


                     <div class="card shadow-sm border-0 mb-6">

                        <div class="card-body p-5">


                           <span class="text-uppercase text-muted fs-13 fw-bold">

                              Status Tahapan

                           </span>

                           <h4 class="mt-2 mb-5">

                              Progress PMB

                           </h4>


                           <div class="pmb-timeline">

                              <?php foreach ($pmbStages as $number => $stage): ?>

                                 <?php

                                 if ($number < $tahapAktif) {

                                    $timelineClass = 'complete';
                                    $timelineIcon = '✓';
                                    $timelineStatus = 'Selesai';
                                 } elseif ($number === $tahapAktif) {

                                    $timelineClass = 'active';
                                    $timelineIcon = $number;
                                    $timelineStatus = 'Aktif';
                                 } else {

                                    $timelineClass = 'locked';
                                    $timelineIcon = '🔒';
                                    $timelineStatus = 'Menunggu';
                                 }

                                 ?>

                                 <div class="pmb-timeline-item">

                                    <div class="pmb-timeline-number <?= $timelineClass ?>">

                                       <?= $timelineIcon ?>

                                    </div>


                                    <div>

                                       <h6 class="mb-1">

                                          <?= htmlspecialchars($stage['name']) ?>

                                       </h6>


                                       <?php if ($number === $tahapAktif): ?>

                                          <span class="badge bg-soft-primary text-primary rounded-pill">

                                             Aktif

                                          </span>

                                       <?php else: ?>

                                          <small class="text-muted">

                                             <?= $timelineStatus ?>

                                          </small>

                                       <?php endif; ?>

                                    </div>

                                 </div>

                              <?php endforeach; ?>

                           </div>

                        </div>

                     </div>


                     <!-- Quick menu -->

                     <div class="card bg-soft-primary border-0">

                        <div class="card-body p-5">

                           <span class="text-uppercase text-muted fs-13 fw-bold">

                              Akses Cepat

                           </span>

                           <h4 class="mt-2 mb-4">

                              Menu PMB

                           </h4>


                           <div class="pmb-quick-item">

                              <div class="pmb-quick-icon bg-white text-primary">

                                 <i class="uil uil-file-alt"></i>

                              </div>

                              <a
                                 href="./pages/data-dokumen.php"
                                 class="text-reset">

                                 Data & Dokumen

                              </a>

                           </div>


                           <div class="pmb-quick-item">

                              <div class="pmb-quick-icon bg-white text-primary">

                                 <i class="uil uil-credit-card"></i>

                              </div>

                              <a
                                 href="./pages/kartu-peserta.php"
                                 class="text-reset">

                                 Kartu Peserta

                              </a>

                           </div>


                           <div class="pmb-quick-item">

                              <div class="pmb-quick-icon bg-white text-primary">

                                 <i class="uil uil-calendar-alt"></i>

                              </div>

                              <a
                                 href="./pages/jadwal-seleksi.php"
                                 class="text-reset">

                                 Jadwal Seleksi

                              </a>

                           </div>


                           <div class="pmb-quick-item">

                              <div class="pmb-quick-icon bg-white text-primary">

                                 <i class="uil uil-trophy"></i>

                              </div>

                              <a
                                 href="./pages/hasil-seleksi.php"
                                 class="text-reset">

                                 Hasil Seleksi

                              </a>

                           </div>


                        </div>

                     </div>

                  </div>


               </div>

            </div>


            <!-- =====================================================
              INFORMATION
         ====================================================== -->

            <div class="row mt-7">

               <div class="col-lg-10 mx-auto">

                  <div class="card bg-soft-yellow border-0">

                     <div class="card-body p-5">

                        <div class="d-flex align-items-start">

                           <div class="icon btn btn-circle btn-sm btn-soft-yellow me-3">

                              <i class="uil uil-info-circle"></i>

                           </div>

                           <div>

                              <h5 class="mb-1">

                                 Tentang Dashboard PMB

                              </h5>

                              <p class="text-muted fs-14 mb-0">

                                 Anda dapat kembali membuka tahapan yang
                                 telah selesai untuk melihat atau mencetak
                                 informasi sebelumnya. Tahapan yang belum
                                 tersedia tidak dapat diakses sampai proses
                                 sebelumnya selesai.

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
     JS
========================================================== -->

   <script src="./assets/js/plugins.js"></script>

   <script src="./assets/js/theme.js"></script>

   <script>
      const PMB_ACTIVE_STAGE =
         <?= (int) $tahapAktif ?>;


      const PMB_STAGES = <?= json_encode(
                              $pmbStages,
                              JSON_UNESCAPED_UNICODE |
                                 JSON_UNESCAPED_SLASHES
                           ) ?>;

      document
         .querySelectorAll('.pmb-stage-tab')
         .forEach(function(tab) {

            tab.addEventListener('click', function() {

               const stage =
                  parseInt(
                     this.dataset.stage,
                     10
                  );

               if (stage > PMB_ACTIVE_STAGE) {

                  showToast(
                     'info',
                     'Tahap ini belum dapat diakses.'
                  );

                  return;
               }

               showStage(stage);

            });

         });


      function showStage(stage) {

         stage = parseInt(stage, 10);

         if (!PMB_STAGES[stage]) {
            return;
         }

         /*
          * Tahap yang belum dicapai
          */
         if (stage > PMB_ACTIVE_STAGE) {

            showToast(
               'info',
               'Tahap ini belum dapat diakses.'
            );

            return;
         }

         const data = PMB_STAGES[stage];

         const isCurrent =
            stage === PMB_ACTIVE_STAGE;

         const isPreview =
            stage < PMB_ACTIVE_STAGE;

         const stageContent =
            document.getElementById('stageContent');

         if (!stageContent) {
            return;
         }

         stageContent.innerHTML = `

      <div class="row gx-lg-8 gy-6">

         <div class="col-lg-8">

            <div class="card shadow-sm pmb-current-card">

               <div class="card-body p-5 p-md-6">

                  <div class="d-flex align-items-start mb-6">

                     <div class="pmb-current-icon bg-soft-primary text-primary me-4">

                        <i class="uil ${data.icon} fs-28"></i>

                     </div>

                     <div>

                        <span class="text-uppercase text-primary fs-13 fw-bold">

                           TAHAP ${String(stage).padStart(2, '0')}

                        </span>

                        <h3 class="mt-1 mb-2">

                           ${data.name}

                        </h3>

                        <p class="text-muted mb-0">

                           ${
                              isCurrent
                              ? 'Tahap ini sedang aktif dan perlu Anda selesaikan.'
                              : 'Tahap ini telah selesai dan dapat Anda preview kembali.'
                           }

                        </p>

                     </div>

                  </div>


                  <div class="
                     alert
                     ${isCurrent ? 'alert-primary' : 'alert-success'}
                     alert-icon
                     mb-5
                  ">

                     <i class="
                        uil
                        ${isCurrent
                           ? 'uil-info-circle'
                           : 'uil-check-circle'}
                     "></i>

                     <p class="mb-0">

                        ${
                           isCurrent
                           ? 'Tahap ini sedang aktif.'
                           : 'Tahap ini telah selesai.'
                        }

                     </p>

                  </div>


                  <div class="pmb-preview-row">

                     <div class="pmb-preview-icon bg-soft-primary text-primary">

                        <i class="uil uil-user"></i>

                     </div>

                     <div>

                        <div class="pmb-preview-label">
                           Peserta
                        </div>

                        <div class="pmb-preview-value">

                           <?= htmlspecialchars($pmbUser['fullname']) ?>

                        </div>

                     </div>

                  </div>


                  <div class="pmb-preview-row">

                     <div class="pmb-preview-icon bg-soft-primary text-primary">

                        <i class="uil uil-envelope"></i>

                     </div>

                     <div>

                        <div class="pmb-preview-label">
                           Email
                        </div>

                        <div class="pmb-preview-value">

                           <?= htmlspecialchars($pmbUser['email_register']) ?>

                        </div>

                     </div>

                  </div>


                  <div class="d-flex justify-content-end mt-5">

                     <a
                        href="./${data.page}"
                        class="btn ${
                           isCurrent
                           ? 'btn-primary'
                           : 'btn-outline-primary'
                        } rounded btn-icon btn-icon-end">

                        ${
                           isCurrent
                           ? 'Lanjutkan'
                           : 'Preview'
                        }

                        <i class="uil uil-arrow-right"></i>

                     </a>

                  </div>

               </div>

            </div>

         </div>


         <div class="col-lg-4">

            <div class="card bg-soft-primary border-0">

               <div class="card-body p-5">

                  <span class="text-uppercase text-muted fs-13 fw-bold">

                     Status Tahap

                  </span>

                  <h4 class="mt-2 mb-4">

                     Tahap ${String(stage).padStart(2, '0')}

                  </h4>

                  <p class="text-muted fs-14 mb-0">

                     ${
                        isCurrent
                        ? 'Tahap ini sedang aktif. Selesaikan proses untuk membuka tahap berikutnya.'
                        : 'Tahap ini telah dilewati. Anda dapat melihat kembali informasi tahap ini.'
                     }

                  </p>

               </div>

            </div>

         </div>

      </div>

   `;

         /*
          * Scroll ke content
          */
         stageContent.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
         });
      }
   </script>


</body>

</html>