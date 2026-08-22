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

                     Selamat Datang, Jaka! 👋

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

                                    Jaka Prayudha

                                 </h3>


                                 <div class="pmb-meta">


                                    <span class="pmb-meta-item text-white opacity-75">

                                       <i class="uil uil-card-atm me-1"></i>

                                       ID:
                                       <strong class="text-white">
                                          99-26-69-74-01-001
                                       </strong>

                                    </span>


                                    <span class="pmb-meta-item text-white opacity-75">

                                       <i class="uil uil-graduation-cap me-1"></i>

                                       Ilmu Hukum

                                    </span>


                                    <span class="pmb-meta-item text-white opacity-75">

                                       <i class="uil uil-sign-alt me-1"></i>

                                       Reguler

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

                           Tahap 07 dari 08

                        </h4>

                     </div>


                     <div class="col-auto">

                        <strong class="text-primary">

                           87.5%

                        </strong>

                     </div>

                  </div>


                  <div class="pmb-progress">

                     <div class="pmb-progress-bar"></div>

                  </div>


                  <div class="d-flex justify-content-between mt-3">

                     <small class="text-green fw-bold">

                        ✓ 6 tahap selesai

                     </small>

                     <small class="text-primary fw-bold">

                        Daftar Ulang aktif

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


                     <!-- 01 -->

                     <div
                        class="pmb-stage-tab"
                        onclick="showStage(1)">

                        <span class="pmb-stage-check text-green">

                           ✓

                        </span>

                        <div class="pmb-stage-number">

                           TAHAP 01

                        </div>

                        <div class="pmb-stage-name">

                           Pendaftaran

                        </div>

                     </div>


                     <!-- 02 -->

                     <div
                        class="pmb-stage-tab"
                        onclick="showStage(2)">

                        <span class="pmb-stage-check text-green">

                           ✓

                        </span>

                        <div class="pmb-stage-number">

                           TAHAP 02

                        </div>

                        <div class="pmb-stage-name">

                           Data & Dokumen

                        </div>

                     </div>


                     <!-- 03 -->

                     <div
                        class="pmb-stage-tab"
                        onclick="showStage(3)">

                        <span class="pmb-stage-check text-green">

                           ✓

                        </span>

                        <div class="pmb-stage-number">

                           TAHAP 03

                        </div>

                        <div class="pmb-stage-name">

                           Kartu Peserta

                        </div>

                     </div>


                     <!-- 04 -->

                     <div
                        class="pmb-stage-tab"
                        onclick="showStage(4)">

                        <span class="pmb-stage-check text-green">

                           ✓

                        </span>

                        <div class="pmb-stage-number">

                           TAHAP 04

                        </div>

                        <div class="pmb-stage-name">

                           Jadwal Seleksi

                        </div>

                     </div>


                     <!-- 05 -->

                     <div
                        class="pmb-stage-tab"
                        onclick="showStage(5)">

                        <span class="pmb-stage-check text-green">

                           ✓

                        </span>

                        <div class="pmb-stage-number">

                           TAHAP 05

                        </div>

                        <div class="pmb-stage-name">

                           Seleksi

                        </div>

                     </div>


                     <!-- 06 -->

                     <div
                        class="pmb-stage-tab"
                        onclick="showStage(6)">

                        <span class="pmb-stage-check text-green">

                           ✓

                        </span>

                        <div class="pmb-stage-number">

                           TAHAP 06

                        </div>

                        <div class="pmb-stage-name">

                           Kelulusan

                        </div>

                     </div>


                     <!-- 07 ACTIVE -->

                     <div
                        class="pmb-stage-tab active"
                        onclick="showStage(7)">

                        <span class="pmb-stage-check">

                           ●

                        </span>

                        <div class="pmb-stage-number">

                           TAHAP 07

                        </div>

                        <div class="pmb-stage-name">

                           Daftar Ulang

                        </div>

                     </div>


                     <!-- 08 -->

                     <div
                        class="pmb-stage-tab locked">

                        <span class="pmb-stage-check">

                           🔒

                        </span>

                        <div class="pmb-stage-number">

                           TAHAP 08

                        </div>

                        <div class="pmb-stage-name">

                           SIAKAD

                        </div>

                     </div>


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

                                 <i class="uil uil-file-check-alt fs-28"></i>

                              </div>


                              <div>

                                 <span class="text-uppercase text-primary fs-13 fw-bold">

                                    TAHAP 07

                                 </span>

                                 <h3 class="mt-1 mb-2">

                                    Daftar Ulang

                                 </h3>

                                 <p class="text-muted mb-0">

                                    Lengkapi proses daftar ulang untuk
                                    mengonfirmasi penerimaan Anda.

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


                           <!-- Preview -->

                           <div class="pmb-preview-row">

                              <div class="pmb-preview-icon bg-soft-green text-green">

                                 <i class="uil uil-check-circle"></i>

                              </div>

                              <div>

                                 <div class="pmb-preview-label">

                                    Status Kelulusan

                                 </div>

                                 <div class="pmb-preview-value text-green">

                                    LULUS

                                 </div>

                              </div>

                           </div>


                           <div class="pmb-preview-row">

                              <div class="pmb-preview-icon bg-soft-primary text-primary">

                                 <i class="uil uil-graduation-cap"></i>

                              </div>

                              <div>

                                 <div class="pmb-preview-label">

                                    Program Studi

                                 </div>

                                 <div class="pmb-preview-value">

                                    Ilmu Hukum

                                 </div>

                              </div>

                           </div>


                           <div class="pmb-preview-row">

                              <div class="pmb-preview-icon bg-soft-yellow text-yellow">

                                 <i class="uil uil-clock"></i>

                              </div>

                              <div>

                                 <div class="pmb-preview-label">

                                    Status Daftar Ulang

                                 </div>

                                 <div class="pmb-preview-value">

                                    Belum Diajukan

                                 </div>

                              </div>

                           </div>


                           <div class="d-flex justify-content-end mt-5">

                              <a
                                 href="./pages/daftar-ulang.php"
                                 class="btn btn-primary rounded btn-icon btn-icon-end">

                                 Lanjutkan Daftar Ulang

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


                              <!-- 01 -->

                              <div class="pmb-timeline-item">

                                 <div class="pmb-timeline-number complete">

                                    ✓

                                 </div>

                                 <div>

                                    <h6 class="mb-1">

                                       Pendaftaran

                                    </h6>

                                    <small class="text-muted">

                                       Selesai

                                    </small>

                                 </div>

                              </div>


                              <!-- 02 -->

                              <div class="pmb-timeline-item">

                                 <div class="pmb-timeline-number complete">

                                    ✓

                                 </div>

                                 <div>

                                    <h6 class="mb-1">

                                       Data & Dokumen

                                    </h6>

                                    <small class="text-muted">

                                       Lengkap

                                    </small>

                                 </div>

                              </div>


                              <!-- 03 -->

                              <div class="pmb-timeline-item">

                                 <div class="pmb-timeline-number complete">

                                    ✓

                                 </div>

                                 <div>

                                    <h6 class="mb-1">

                                       Kartu Peserta

                                    </h6>

                                    <small class="text-muted">

                                       Diterbitkan

                                    </small>

                                 </div>

                              </div>


                              <!-- 04 -->

                              <div class="pmb-timeline-item">

                                 <div class="pmb-timeline-number complete">

                                    ✓

                                 </div>

                                 <div>

                                    <h6 class="mb-1">

                                       Jadwal Seleksi

                                    </h6>

                                    <small class="text-muted">

                                       Selesai

                                    </small>

                                 </div>

                              </div>


                              <!-- 05 -->

                              <div class="pmb-timeline-item">

                                 <div class="pmb-timeline-number complete">

                                    ✓

                                 </div>

                                 <div>

                                    <h6 class="mb-1">

                                       Seleksi

                                    </h6>

                                    <small class="text-muted">

                                       Selesai

                                    </small>

                                 </div>

                              </div>


                              <!-- 06 -->

                              <div class="pmb-timeline-item">

                                 <div class="pmb-timeline-number complete">

                                    ✓

                                 </div>

                                 <div>

                                    <h6 class="mb-1">

                                       Kelulusan

                                    </h6>

                                    <small class="text-muted">

                                       Lulus

                                    </small>

                                 </div>

                              </div>


                              <!-- 07 -->

                              <div class="pmb-timeline-item">

                                 <div class="pmb-timeline-number active">

                                    7

                                 </div>

                                 <div>

                                    <h6 class="mb-1">

                                       Daftar Ulang

                                    </h6>

                                    <span class="badge bg-soft-primary text-primary rounded-pill">

                                       Aktif

                                    </span>

                                 </div>

                              </div>


                              <!-- 08 -->

                              <div class="pmb-timeline-item">

                                 <div class="pmb-timeline-number locked">

                                    🔒

                                 </div>

                                 <div>

                                    <h6 class="mb-1">

                                       SIAKAD

                                    </h6>

                                    <small class="text-muted">

                                       Menunggu

                                    </small>

                                 </div>

                              </div>


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
   require '../footer-pmb.php';
   ?>


   <!-- =========================================================
     JS
========================================================== -->

   <script src="./assets/js/plugins.js"></script>

   <script src="./assets/js/theme.js"></script>


   <script>
      /*
       * =========================================================
       * PMB STAGE PREVIEW
       * =========================================================
       *
       * Tahapan yang sudah selesai dapat dibuka kembali
       * untuk preview.
       *
       * Tahap aktif diarahkan ke halaman proses.
       *
       */

      function showStage(stage) {

         const stageContent = document.getElementById('stageContent');

         /*
          * Untuk sementara preview sederhana.
          * Nantinya data dapat diambil melalui AJAX/API.
          */

         const stages = {

            1: {
               title: 'Pendaftaran',
               icon: 'uil-edit',
               description: 'Informasi pendaftaran akun PMB.',
               status: 'Selesai',
               color: 'green',
               action: './pages/pendaftaran.php'
            },

            2: {
               title: 'Data & Dokumen',
               icon: 'uil-file-alt',
               description: 'Data pribadi dan dokumen pendaftaran.',
               status: 'Lengkap',
               color: 'green',
               action: './pages/data-dokumen.php'
            },

            3: {
               title: 'Kartu Peserta',
               icon: 'uil-credit-card',
               description: 'Kartu peserta seleksi PMB.',
               status: 'Diterbitkan',
               color: 'green',
               action: './pages/kartu-peserta.php'
            },

            4: {
               title: 'Jadwal Seleksi',
               icon: 'uil-calendar-alt',
               description: 'Jadwal pelaksanaan seleksi.',
               status: 'Selesai',
               color: 'green',
               action: './pages/jadwal-seleksi.php'
            },

            5: {
               title: 'Pelaksanaan & Hasil Seleksi',
               icon: 'uil-clipboard-alt',
               description: 'Riwayat pelaksanaan dan hasil seleksi.',
               status: 'Selesai',
               color: 'green',
               action: './pages/hasil-seleksi.php'
            },

            6: {
               title: 'Pengumuman Kelulusan',
               icon: 'uil-trophy',
               description: 'Informasi hasil akhir seleksi PMB.',
               status: 'Lulus',
               color: 'green',
               action: './pages/pengumuman-kelulusan.php'
            },

            7: {
               title: 'Daftar Ulang',
               icon: 'uil-file-check-alt',
               description: 'Lengkapi proses daftar ulang mahasiswa baru.',
               status: 'Aktif',
               color: 'primary',
               action: './pages/daftar-ulang.php'
            }

         };


         const data = stages[stage];

         if (!data) {
            return;
         }


         const colorClass =
            data.color === 'green' ?
            'bg-soft-green text-green' :
            'bg-soft-primary text-primary';


         const statusClass =
            data.color === 'green' ?
            'bg-soft-green text-green' :
            'bg-soft-primary text-primary';


         stageContent.innerHTML = `

         <div class="row gx-lg-8 gy-6">

            <div class="col-lg-8">

               <div class="card shadow-sm pmb-current-card">

                  <div class="card-body p-5 p-md-6">

                     <div class="d-flex align-items-start mb-6">

                        <div class="pmb-current-icon ${colorClass} me-4">

                           <i class="uil ${data.icon} fs-28"></i>

                        </div>

                        <div>

                           <span class="text-uppercase text-primary fs-13 fw-bold">

                              TAHAP ${String(stage).padStart(2,'0')}

                           </span>

                           <h3 class="mt-1 mb-2">

                              ${data.title}

                           </h3>

                           <p class="text-muted mb-0">

                              ${data.description}

                           </p>

                        </div>

                     </div>


                     <div class="alert alert-primary alert-icon mb-5">

                        <i class="uil uil-eye"></i>

                        <p class="mb-0">

                           Anda sedang melihat preview tahap
                           yang telah dilalui.

                        </p>

                     </div>


                     <div class="pmb-preview-row">

                        <div class="pmb-preview-icon ${colorClass}">

                           <i class="uil uil-check-circle"></i>

                        </div>

                        <div>

                           <div class="pmb-preview-label">

                              Status

                           </div>

                           <div class="pmb-preview-value">

                              ${data.status}

                           </div>

                        </div>

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

                              Jaka Prayudha

                           </div>

                        </div>

                     </div>


                     <div class="d-flex justify-content-end mt-5">

                        <a
                           href="${data.action}"
                           class="btn btn-outline-primary rounded btn-icon btn-icon-end">

                           Buka Detail

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

                        Preview Tahap

                     </span>

                     <h4 class="mt-2 mb-4">

                        Tahap ${String(stage).padStart(2,'0')}

                     </h4>

                     <p class="text-muted fs-14 mb-0">

                        Tahapan ini sudah dilewati.
                        Anda tetap dapat membuka kembali detail
                        untuk melihat informasi sebelumnya.

                     </p>

                  </div>

               </div>

            </div>

         </div>

      `;

      }
   </script>

</body>

</html>