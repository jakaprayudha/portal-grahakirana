<!DOCTYPE html>
<html lang="en">

<head>
   <base href="../">

   <?php
   $page = 'SIAKAD Mahasiswa';
   require '../head.php';
   ?>

   <style>
      /* =========================================================
         PMB - TAHAP 08
         SIAKAD
      ========================================================= */

      .siakad-section {
         padding-top: 60px;
         padding-bottom: 80px;
      }

      .siakad-header {
         margin-bottom: 40px;
      }

      .siakad-header h2 {
         font-size: 2.5rem;
      }

      /* =========================================================
         STUDENT CARD
      ========================================================= */

      .siakad-student-card {
         border: 0;
      }

      .siakad-avatar {
         width: 70px;
         height: 70px;
         min-width: 70px;
         border-radius: 50%;
         background: #edf3ff;
         color: #3f78e0;
         display: flex;
         align-items: center;
         justify-content: center;
      }

      .siakad-nim {
         font-size: 13px;
         font-weight: 700;
         letter-spacing: .4px;
      }

      /* =========================================================
         HERO
      ========================================================= */

      .siakad-hero {
         border: 0;
         overflow: hidden;
         position: relative;
      }

      .siakad-hero::before {
         content: "";
         position: absolute;
         width: 280px;
         height: 280px;
         border-radius: 50%;
         background: rgba(255, 255, 255, .07);
         right: -100px;
         top: -130px;
      }

      .siakad-hero::after {
         content: "";
         position: absolute;
         width: 180px;
         height: 180px;
         border-radius: 50%;
         background: rgba(255, 255, 255, .05);
         left: -80px;
         bottom: -100px;
      }

      .siakad-hero-content {
         position: relative;
         z-index: 2;
      }

      .siakad-hero-icon {
         width: 75px;
         height: 75px;
         min-width: 75px;
         border-radius: 50%;
         background: #fff;
         color: #3f78e0;
         display: flex;
         align-items: center;
         justify-content: center;
      }

      /* =========================================================
         STEP CARDS
      ========================================================= */

      .siakad-step-card {
         border: 0;
         height: 100%;
         transition: all .2s ease;
      }

      .siakad-step-card:hover {
         transform: translateY(-4px);
         box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
      }

      .siakad-step-icon {
         width: 62px;
         height: 62px;
         border-radius: 14px;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-bottom: 22px;
      }

      .siakad-step-number {
         font-size: 12px;
         font-weight: 700;
         letter-spacing: .5px;
      }

      .siakad-step-status {
         margin-top: 20px;
      }

      /* =========================================================
         PROGRESS
      ========================================================= */

      .siakad-progress {
         height: 8px;
         border-radius: 20px;
         background: #e9edf2;
         overflow: hidden;
      }

      .siakad-progress-bar {
         height: 100%;
         border-radius: 20px;
         width: 33.33%;
         background: #3f78e0;
      }

      /* =========================================================
         ACTIVATION
      ========================================================= */

      .siakad-activation-list {
         margin: 0;
         padding: 0;
         list-style: none;
      }

      .siakad-activation-list li {
         display: flex;
         align-items: flex-start;
         margin-bottom: 16px;
      }

      .siakad-activation-list li:last-child {
         margin-bottom: 0;
      }

      .siakad-check {
         width: 28px;
         height: 28px;
         min-width: 28px;
         border-radius: 50%;
         background: #edf7f0;
         color: #2b9a59;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-right: 12px;
      }

      /* =========================================================
         KTM
      ========================================================= */

      .ktm-card {
         position: relative;
         overflow: hidden;
         border-radius: 15px;
         background: #fff;
         border: 1px solid #e5e9ef;
         box-shadow: 0 15px 45px rgba(0, 0, 0, .08);
      }

      .ktm-header {
         padding: 20px 25px;
         background: #3f78e0;
         color: #fff;
      }

      .ktm-logo {
         width: 48px;
         height: 48px;
         border-radius: 8px;
         background: #fff;
         padding: 5px;
         object-fit: contain;
      }

      .ktm-title {
         font-size: 17px;
         font-weight: 700;
      }

      .ktm-subtitle {
         font-size: 11px;
         opacity: .8;
      }

      .ktm-body {
         padding: 25px;
      }

      .ktm-photo {
         width: 100px;
         height: 125px;
         border-radius: 7px;
         background: #f2f4f7;
         border: 1px solid #e0e4e9;
         display: flex;
         align-items: center;
         justify-content: center;
      }

      .ktm-info-row {
         display: flex;
         padding: 7px 0;
      }

      .ktm-label {
         width: 100px;
         font-size: 11px;
         color: #8a8f98;
      }

      .ktm-value {
         flex: 1;
         font-size: 12px;
         font-weight: 600;
      }

      .ktm-footer {
         padding: 12px 25px;
         background: #fafbfc;
         border-top: 1px dashed #dfe4ea;
         font-size: 10px;
         color: #8a8f98;
      }

      /* =========================================================
         KRS
      ========================================================= */

      .krs-status {
         border-radius: 30px;
         padding: 7px 13px;
         font-size: 12px;
         font-weight: 700;
      }

      .krs-summary {
         border: 1px solid #edf0f3;
         border-radius: 12px;
         padding: 20px;
         text-align: center;
         height: 100%;
      }

      .krs-summary-value {
         font-size: 27px;
         font-weight: 700;
      }

      .krs-summary-label {
         font-size: 12px;
         color: #8a8f98;
      }

      /* =========================================================
         PROCESS
      ========================================================= */

      .siakad-process {
         position: relative;
      }

      .siakad-process::before {
         content: "";
         position: absolute;
         left: 23px;
         top: 25px;
         bottom: 25px;
         width: 2px;
         background: #e8ecf1;
      }

      .siakad-process-item {
         display: flex;
         position: relative;
         z-index: 2;
         margin-bottom: 25px;
      }

      .siakad-process-item:last-child {
         margin-bottom: 0;
      }

      .siakad-process-number {
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

      .siakad-process-number.complete {
         background: #2b9a59;
         border-color: #2b9a59;
         color: #fff;
      }

      .siakad-process-number.active {
         background: #3f78e0;
         border-color: #3f78e0;
         color: #fff;
      }

      /* =========================================================
         MOBILE
      ========================================================= */

      @media (max-width: 991.98px) {

         .siakad-section {
            padding-top: 50px;
            padding-bottom: 60px;
         }

         .siakad-header h2 {
            font-size: 2.2rem;
         }

         .siakad-process::before {
            display: none;
         }

      }

      @media (max-width: 767.98px) {

         .siakad-section {
            padding-top: 35px;
            padding-bottom: 50px;
         }

         .siakad-header h2 {
            font-size: 1.8rem;
         }

         .siakad-header p {
            font-size: 14px;
            line-height: 1.6;
         }

         .siakad-student-card .card-body {
            padding: 20px !important;
         }

         .siakad-hero .card-body {
            padding: 30px 20px !important;
         }

         .siakad-hero-icon {
            width: 60px;
            height: 60px;
            min-width: 60px;
         }

         .siakad-step-card .card-body {
            padding: 22px !important;
         }

         .ktm-body {
            padding: 20px;
         }

      }

      @media (max-width: 575.98px) {

         .siakad-header h2 {
            font-size: 1.6rem;
         }

         .siakad-hero-icon {
            width: 52px;
            height: 52px;
            min-width: 52px;
            margin-right: 13px !important;
         }

         .ktm-header {
            padding: 16px;
         }

         .ktm-body {
            padding: 16px;
         }

         .ktm-photo {
            width: 80px;
            height: 100px;
         }

         .ktm-label {
            width: 85px;
         }

         .siakad-process-item {
            margin-bottom: 20px;
         }

         .siakad-process-number {
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
           SECTION : TAHAP 08
      ====================================================== -->

      <section class="wrapper bg-light siakad-section">

         <div class="container">


            <!-- =================================================
                 HEADER
            ================================================== -->

            <div class="row siakad-header">

               <div class="col-lg-9">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
                     TAHAP 08
                  </span>

                  <h2 class="display-4 mb-3">
                     SIAKAD Mahasiswa
                  </h2>

                  <p class="lead fs-18 mb-0">
                     Aktivasi akun akademik, penerbitan Kartu Tanda Mahasiswa
                     dan pengisian Kartu Rencana Studi.
                  </p>

               </div>

            </div>


            <!-- =================================================
                 STUDENT
            ================================================== -->

            <div class="card shadow-sm siakad-student-card mb-7">

               <div class="card-body p-5">

                  <div class="row align-items-center">


                     <div class="col-lg">

                        <div class="d-flex align-items-center">

                           <div class="siakad-avatar me-4">

                              <i class="uil uil-graduation-cap fs-30"></i>

                           </div>

                           <div>

                              <span class="text-uppercase text-muted fs-13 fw-bold">
                                 Mahasiswa Baru
                              </span>

                              <h4 class="mb-1">
                                 Jaka Prayudha
                              </h4>

                              <p class="mb-0 text-muted siakad-nim">

                                 NIM:

                                 <span class="text-primary">
                                    —
                                 </span>

                                 &nbsp; • &nbsp;

                                 Ilmu Hukum

                              </p>

                           </div>

                        </div>

                     </div>


                     <div class="col-lg-auto mt-4 mt-lg-0">

                        <span class="badge bg-soft-green text-green rounded-pill px-4 py-2">

                           <i class="uil uil-check-circle me-1"></i>

                           Diterima

                        </span>

                     </div>


                  </div>

               </div>

            </div>


            <!-- =================================================
                 HERO
            ================================================== -->

            <div class="card bg-primary text-white shadow-lg siakad-hero mb-7">

               <div class="card-body p-5 p-md-6">

                  <div class="siakad-hero-content">

                     <div class="d-flex align-items-center">


                        <div class="siakad-hero-icon me-4">

                           <i class="uil uil-university fs-30"></i>

                        </div>


                        <div>

                           <span class="text-white opacity-75 text-uppercase fs-13 fw-bold">
                              Sistem Akademik
                           </span>

                           <h3 class="text-white mt-1 mb-2">
                              Selamat Datang di SIAKAD
                           </h3>

                           <p class="text-white opacity-75 mb-0">

                              Setelah proses daftar ulang diverifikasi,
                              Anda dapat mengakses layanan akademik mahasiswa.

                           </p>

                        </div>


                     </div>

                  </div>

               </div>

            </div>


            <!-- =================================================
                 3 STEP
            ================================================== -->

            <div class="row gx-lg-5 gy-5 mb-8">


               <!-- =================================================
                    AKTIVASI
               ================================================== -->

               <div class="col-lg-4">

                  <div class="card shadow-sm siakad-step-card">

                     <div class="card-body p-5">


                        <span class="text-primary siakad-step-number">
                           LANGKAH 01
                        </span>


                        <div class="siakad-step-icon bg-soft-primary text-primary mt-3">

                           <i class="uil uil-user-check fs-27"></i>

                        </div>


                        <h3 class="mb-3">
                           Aktivasi Akun
                        </h3>


                        <p class="text-muted fs-14">

                           Aktifkan akun SIAKAD menggunakan kredensial
                           mahasiswa yang telah diberikan oleh institusi.

                        </p>


                        <ul class="siakad-activation-list mt-4">


                           <li>

                              <div class="siakad-check">

                                 <i class="uil uil-check fs-14"></i>

                              </div>

                              <span class="fs-13">
                                 Akun mahasiswa dibuat
                              </span>

                           </li>


                           <li>

                              <div class="siakad-check">

                                 <i class="uil uil-check fs-14"></i>

                              </div>

                              <span class="fs-13">
                                 Email mahasiswa tersedia
                              </span>

                           </li>


                           <li>

                              <div class="siakad-check">

                                 <i class="uil uil-check fs-14"></i>

                              </div>

                              <span class="fs-13">
                                 Password dapat dibuat
                              </span>

                           </li>


                        </ul>


                        <div class="siakad-step-status">

                           <span class="badge bg-soft-yellow text-yellow rounded-pill">

                              <i class="uil uil-clock me-1"></i>

                              Menunggu Aktivasi

                           </span>

                        </div>


                        <div class="d-grid mt-4">

                           <button
                              type="button"
                              class="btn btn-primary rounded">

                              Aktivasi Akun

                              <i class="uil uil-arrow-right ms-1"></i>

                           </button>

                        </div>


                     </div>

                  </div>

               </div>


               <!-- =================================================
                    KTM
               ================================================== -->

               <div class="col-lg-4">

                  <div class="card shadow-sm siakad-step-card">

                     <div class="card-body p-5">


                        <span class="text-green siakad-step-number">
                           LANGKAH 02
                        </span>


                        <div class="siakad-step-icon bg-soft-green text-green mt-3">

                           <i class="uil uil-credit-card fs-27"></i>

                        </div>


                        <h3 class="mb-3">
                           Kartu Tanda Mahasiswa
                        </h3>


                        <p class="text-muted fs-14">

                           KTM diterbitkan setelah akun mahasiswa
                           aktif dan data mahasiswa tervalidasi.

                        </p>


                        <div class="siakad-step-status">

                           <span class="badge bg-soft-yellow text-yellow rounded-pill">

                              <i class="uil uil-clock me-1"></i>

                              Belum Terbit

                           </span>

                        </div>


                        <div class="d-grid mt-4">

                           <button
                              type="button"
                              class="btn btn-outline-primary rounded"
                              disabled>

                              Lihat KTM

                              <i class="uil uil-arrow-right ms-1"></i>

                           </button>

                        </div>


                     </div>

                  </div>

               </div>


               <!-- =================================================
                    KRS
               ================================================== -->

               <div class="col-lg-4">

                  <div class="card shadow-sm siakad-step-card">

                     <div class="card-body p-5">


                        <span class="text-yellow siakad-step-number">
                           LANGKAH 03
                        </span>


                        <div class="siakad-step-icon bg-soft-yellow text-yellow mt-3">

                           <i class="uil uil-book-open fs-27"></i>

                        </div>


                        <h3 class="mb-3">
                           KRS
                        </h3>


                        <p class="text-muted fs-14">

                           Pilih mata kuliah semester pertama
                           setelah status akademik Anda aktif.

                        </p>


                        <div class="siakad-step-status">

                           <span class="badge bg-soft-yellow text-yellow rounded-pill">

                              <i class="uil uil-lock me-1"></i>

                              Belum Dibuka

                           </span>

                        </div>


                        <div class="d-grid mt-4">

                           <button
                              type="button"
                              class="btn btn-outline-primary rounded"
                              disabled>

                              Isi KRS

                              <i class="uil uil-arrow-right ms-1"></i>

                           </button>

                        </div>


                     </div>

                  </div>

               </div>


            </div>


            <!-- =================================================
                 PROGRESS
            ================================================== -->

            <div class="card shadow-sm border-0 mb-7">

               <div class="card-body p-5">


                  <div class="row align-items-center mb-4">

                     <div class="col">

                        <span class="text-uppercase text-muted fs-13 fw-bold">
                           Progress Akademik
                        </span>

                        <h4 class="mt-2 mb-0">
                           Onboarding Mahasiswa
                        </h4>

                     </div>

                     <div class="col-auto">

                        <strong class="text-primary">
                           1 / 3
                        </strong>

                     </div>

                  </div>


                  <div class="siakad-progress">

                     <div class="siakad-progress-bar"></div>

                  </div>


                  <div class="row mt-3">

                     <div class="col-4">

                        <small class="text-primary fw-bold">
                           Aktivasi
                        </small>

                     </div>

                     <div class="col-4 text-center">

                        <small class="text-muted">
                           KTM
                        </small>

                     </div>

                     <div class="col-4 text-end">

                        <small class="text-muted">
                           KRS
                        </small>

                     </div>

                  </div>

               </div>

            </div>


            <!-- =================================================
                 KTM PREVIEW
            ================================================== -->

            <div class="row gx-lg-8 gy-6 mb-7">


               <div class="col-lg-7">


                  <div class="card shadow-sm border-0 h-100">

                     <div class="card-body p-5 p-md-6">


                        <span class="text-uppercase text-muted fs-13 fw-bold">
                           Preview
                        </span>

                        <h3 class="mt-2 mb-2">
                           Kartu Tanda Mahasiswa
                        </h3>

                        <p class="text-muted fs-14 mb-5">
                           KTM akan tersedia setelah proses aktivasi
                           dan validasi mahasiswa selesai.
                        </p>


                        <div class="ktm-card">


                           <div class="ktm-header">

                              <div class="d-flex align-items-center">

                                 <img
                                    src="./assets/img/logo.png"
                                    class="ktm-logo me-3"
                                    alt="Logo">

                                 <div>

                                    <div class="ktm-title">
                                       STIH GRAHA KIRANA
                                    </div>

                                    <div class="ktm-subtitle">
                                       KARTU TANDA MAHASISWA
                                    </div>

                                 </div>

                              </div>

                           </div>


                           <div class="ktm-body">

                              <div class="row align-items-center">


                                 <div class="col-auto">

                                    <div class="ktm-photo">

                                       <i class="uil uil-user text-muted fs-30"></i>

                                    </div>

                                 </div>


                                 <div class="col">

                                    <div class="ktm-info-row">

                                       <div class="ktm-label">
                                          Nama
                                       </div>

                                       <div class="ktm-value">
                                          Jaka Prayudha
                                       </div>

                                    </div>


                                    <div class="ktm-info-row">

                                       <div class="ktm-label">
                                          NIM
                                       </div>

                                       <div class="ktm-value">
                                          —
                                       </div>

                                    </div>


                                    <div class="ktm-info-row">

                                       <div class="ktm-label">
                                          Prodi
                                       </div>

                                       <div class="ktm-value">
                                          Ilmu Hukum
                                       </div>

                                    </div>


                                    <div class="ktm-info-row">

                                       <div class="ktm-label">
                                          Angkatan
                                       </div>

                                       <div class="ktm-value">
                                          2026
                                       </div>

                                    </div>


                                 </div>

                              </div>

                           </div>


                           <div class="ktm-footer">

                              KTM akan diterbitkan setelah data mahasiswa
                              dinyatakan aktif.

                           </div>


                        </div>


                     </div>

                  </div>


               </div>


               <!-- =================================================
                    KRS SUMMARY
               ================================================== -->

               <div class="col-lg-5">


                  <div class="card shadow-sm border-0 h-100">

                     <div class="card-body p-5 p-md-6">


                        <span class="text-uppercase text-muted fs-13 fw-bold">
                           Akademik
                        </span>

                        <h3 class="mt-2 mb-5">
                           KRS Semester 1
                        </h3>


                        <div class="row gx-3 mb-5">


                           <div class="col-6">

                              <div class="krs-summary">

                                 <div class="krs-summary-value text-primary">
                                    —
                                 </div>

                                 <div class="krs-summary-label">
                                    Mata Kuliah
                                 </div>

                              </div>

                           </div>


                           <div class="col-6">

                              <div class="krs-summary">

                                 <div class="krs-summary-value text-green">
                                    —
                                 </div>

                                 <div class="krs-summary-label">
                                    Total SKS
                                 </div>

                              </div>

                           </div>


                        </div>


                        <div class="alert alert-primary alert-icon mb-5">

                           <i class="uil uil-info-circle"></i>

                           <p class="mb-0 fs-14">

                              Pengisian KRS dapat dilakukan setelah
                              status mahasiswa aktif dan periode KRS
                              telah dibuka.

                           </p>

                        </div>


                        <div class="d-grid">

                           <button
                              type="button"
                              class="btn btn-primary rounded"
                              disabled>

                              <i class="uil uil-lock me-1"></i>

                              KRS Belum Dibuka

                           </button>

                        </div>


                     </div>

                  </div>

               </div>


            </div>


            <!-- =================================================
                 PROCESS
            ================================================== -->

            <div class="row">


               <div class="col-lg-8">


                  <div class="card shadow-sm border-0">

                     <div class="card-body p-5 p-md-6">


                        <span class="text-uppercase text-muted fs-13 fw-bold">
                           Alur SIAKAD
                        </span>

                        <h3 class="mt-2 mb-6">
                           Aktivasi → KTM → KRS
                        </h3>


                        <div class="siakad-process">


                           <!-- 01 -->

                           <div class="siakad-process-item">

                              <div class="siakad-process-number active">

                                 1

                              </div>

                              <div>

                                 <h5 class="mb-1">
                                    Aktivasi Akun SIAKAD
                                 </h5>

                                 <p class="text-muted fs-14 mb-0">

                                    Aktivasi akun mahasiswa dan buat
                                    password untuk mengakses sistem akademik.

                                 </p>

                              </div>

                           </div>


                           <!-- 02 -->

                           <div class="siakad-process-item">

                              <div class="siakad-process-number">

                                 2

                              </div>

                              <div>

                                 <h5 class="mb-1">
                                    Penerbitan KTM
                                 </h5>

                                 <p class="text-muted fs-14 mb-0">

                                    KTM diterbitkan setelah data mahasiswa
                                    tervalidasi dan status akademik aktif.

                                 </p>

                              </div>

                           </div>


                           <!-- 03 -->

                           <div class="siakad-process-item">

                              <div class="siakad-process-number">

                                 3

                              </div>

                              <div>

                                 <h5 class="mb-1">
                                    Pengisian KRS
                                 </h5>

                                 <p class="text-muted fs-14 mb-0">

                                    Mahasiswa memilih mata kuliah sesuai
                                    kurikulum dan periode akademik.

                                 </p>

                              </div>

                           </div>


                           <!-- 04 -->

                           <div class="siakad-process-item">

                              <div class="siakad-process-number">

                                 4

                              </div>

                              <div>

                                 <h5 class="mb-1">
                                    Perkuliahan
                                 </h5>

                                 <p class="text-muted fs-14 mb-0">

                                    Setelah KRS disetujui, mahasiswa
                                    dapat mengikuti kegiatan perkuliahan.

                                 </p>

                              </div>

                           </div>


                        </div>

                     </div>

                  </div>

               </div>


               <div class="col-lg-4 mt-6 mt-lg-0">


                  <div class="card bg-soft-primary border-0 h-100">

                     <div class="card-body p-5 p-md-6">

                        <div class="icon btn btn-circle btn-lg btn-primary mb-5">

                           <i class="uil uil-graduation-cap"></i>

                        </div>

                        <span class="text-uppercase text-muted fs-13 fw-bold">
                           Selamat Datang
                        </span>

                        <h3 class="mt-2 mb-3">
                           Mahasiswa Baru
                        </h3>

                        <p class="text-muted fs-14 mb-5">

                           Setelah seluruh proses onboarding selesai,
                           Anda dapat menggunakan SIAKAD untuk kebutuhan
                           akademik selama masa studi.

                        </p>


                        <div class="d-flex align-items-center mb-3">

                           <i class="uil uil-check-circle text-green me-2"></i>

                           <span class="fs-14">
                              Status mahasiswa aktif
                           </span>

                        </div>


                        <div class="d-flex align-items-center mb-3">

                           <i class="uil uil-check-circle text-green me-2"></i>

                           <span class="fs-14">
                              Akses layanan akademik
                           </span>

                        </div>


                        <div class="d-flex align-items-center">

                           <i class="uil uil-check-circle text-green me-2"></i>

                           <span class="fs-14">
                              Pengisian KRS
                           </span>

                        </div>

                     </div>

                  </div>

               </div>

            </div>


            <!-- =================================================
                 FINAL
            ================================================== -->

            <div class="row mt-8">

               <div class="col-lg-10 mx-auto">

                  <div class="card bg-soft-green border-0">

                     <div class="card-body p-5">

                        <div class="row align-items-center">


                           <div class="col-lg">

                              <div class="d-flex align-items-center">

                                 <div class="icon btn btn-circle btn-lg btn-green me-4">

                                    <i class="uil uil-graduation-cap"></i>

                                 </div>

                                 <div>

                                    <span class="text-uppercase text-muted fs-13 fw-bold">
                                       Akhir Proses PMB
                                    </span>

                                    <h4 class="mb-1">
                                       Selamat Datang di Dunia Akademik
                                    </h4>

                                    <p class="mb-0 text-muted">

                                       Setelah daftar ulang terverifikasi,
                                       mahasiswa melanjutkan proses akademik
                                       melalui SIAKAD.

                                    </p>

                                 </div>

                              </div>

                           </div>


                           <div class="col-lg-auto mt-4 mt-lg-0">

                              <span class="badge bg-soft-green text-green rounded-pill px-4 py-2">

                                 MAHASISWA

                                 <i class="uil uil-check ms-1"></i>

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
            d="M50,1 a49 49 0,1 0 0,98 a49,49 0,1 0 0,-98" />

      </svg>

   </div>


   <!-- =========================================================
        JS
   ========================================================== -->

   <script src="./assets/js/plugins.js"></script>

   <script src="./assets/js/theme.js"></script>

</body>

</html>