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


            <!-- =================================================
                 PARTICIPANT STATUS
            ================================================== -->

            <div class="card shadow-sm pmb-participant-card mb-7">

               <div class="card-body p-5">

                  <div class="row align-items-center">


                     <!-- Profile -->

                     <div class="col-lg">

                        <div class="d-flex align-items-center">

                           <div class="icon btn btn-circle btn-lg btn-soft-primary me-4">

                              <i class="uil uil-user"></i>

                           </div>

                           <div>

                              <span class="text-uppercase text-muted fs-13 fw-bold">
                                 Peserta
                              </span>

                              <h4 class="mb-1">
                                 Jaka Prayudha
                              </h4>

                              <p class="mb-0 text-muted pmb-participant-id">
                                 ID Pendaftaran:
                                 <span class="text-primary">
                                    99-26-69-74-01-001
                                 </span>
                              </p>

                           </div>

                        </div>

                     </div>


                     <!-- Status -->

                     <div class="col-lg-auto mt-4 mt-lg-0">

                        <span class="badge bg-soft-green text-green pmb-status-badge">

                           <i class="uil uil-check-circle me-1"></i>

                           Peserta Aktif

                        </span>

                     </div>


                  </div>

               </div>

            </div>


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


                        <div class="pmb-timeline">


                           <!-- =================================================
                                TPA
                           ================================================== -->

                           <div class="pmb-timeline-item">


                              <div class="pmb-timeline-number active">
                                 1
                              </div>


                              <div class="flex-grow-1">

                                 <div class="card pmb-schedule-card mb-0">

                                    <div class="pmb-schedule-header">

                                       <div class="d-flex align-items-center">

                                          <div class="pmb-schedule-icon bg-soft-primary text-primary me-4">

                                             <i class="uil uil-file-alt fs-24"></i>

                                          </div>

                                          <div class="flex-grow-1">

                                             <span class="badge bg-soft-primary text-primary rounded-pill mb-2">
                                                SELEKSI AKADEMIK
                                             </span>

                                             <h4 class="mb-0">
                                                Tes Potensi Akademik
                                             </h4>

                                          </div>

                                          <span class="badge bg-soft-green text-green rounded-pill">
                                             Terjadwal
                                          </span>

                                       </div>

                                    </div>


                                    <div class="pmb-schedule-body">


                                       <!-- Date -->

                                       <div class="d-flex align-items-center mb-5">

                                          <div class="text-center me-4">

                                             <div class="pmb-schedule-date text-primary">
                                                15
                                             </div>

                                             <div class="pmb-schedule-month">
                                                September
                                             </div>

                                          </div>

                                          <div>

                                             <h5 class="mb-1">
                                                Selasa, 15 September 2026
                                             </h5>

                                             <p class="text-muted mb-0 fs-14">
                                                Tahun Akademik 2026/2027
                                             </p>

                                          </div>

                                       </div>


                                       <!-- Time -->

                                       <div class="pmb-schedule-info">

                                          <i class="uil uil-clock"></i>

                                          <div>

                                             <div class="pmb-schedule-info-label">
                                                Waktu
                                             </div>

                                             <div class="pmb-schedule-info-value">
                                                09.00 – 11.00 WIB
                                             </div>

                                          </div>

                                       </div>


                                       <!-- Location -->

                                       <div class="pmb-schedule-info">

                                          <i class="uil uil-location-point"></i>

                                          <div>

                                             <div class="pmb-schedule-info-label">
                                                Lokasi
                                             </div>

                                             <div class="pmb-schedule-info-value">
                                                Kampus STIH Graha Kirana
                                             </div>

                                          </div>

                                       </div>


                                       <!-- Room -->

                                       <div class="pmb-schedule-info">

                                          <i class="uil uil-building"></i>

                                          <div>

                                             <div class="pmb-schedule-info-label">
                                                Ruangan
                                             </div>

                                             <div class="pmb-schedule-info-value">
                                                Ruang Ujian 01
                                             </div>

                                          </div>

                                       </div>


                                       <!-- Method -->

                                       <div class="pmb-schedule-info">

                                          <i class="uil uil-monitor"></i>

                                          <div>

                                             <div class="pmb-schedule-info-label">
                                                Metode
                                             </div>

                                             <div class="pmb-schedule-info-value">
                                                Offline
                                             </div>

                                          </div>

                                       </div>


                                       <hr class="my-5">


                                       <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                                          <span class="text-muted fs-13">

                                             <i class="uil uil-info-circle me-1"></i>

                                             Harap hadir 30 menit sebelum ujian.

                                          </span>

                                          <button
                                             type="button"
                                             class="btn btn-sm btn-outline-primary rounded">

                                             Lihat Detail

                                             <i class="uil uil-arrow-right ms-1"></i>

                                          </button>

                                       </div>


                                    </div>

                                 </div>

                              </div>

                           </div>


                           <!-- =================================================
                                INTERVIEW
                           ================================================== -->

                           <div class="pmb-timeline-item">


                              <div class="pmb-timeline-number">
                                 2
                              </div>


                              <div class="flex-grow-1">

                                 <div class="card pmb-schedule-card mb-0">

                                    <div class="pmb-schedule-header">

                                       <div class="d-flex align-items-center">

                                          <div class="pmb-schedule-icon bg-soft-green text-green me-4">

                                             <i class="uil uil-comments fs-24"></i>

                                          </div>

                                          <div class="flex-grow-1">

                                             <span class="badge bg-soft-green text-green rounded-pill mb-2">
                                                SELEKSI LANJUTAN
                                             </span>

                                             <h4 class="mb-0">
                                                Wawancara
                                             </h4>

                                          </div>

                                          <span class="badge bg-soft-yellow text-yellow rounded-pill">
                                             Terjadwal
                                          </span>

                                       </div>

                                    </div>


                                    <div class="pmb-schedule-body">


                                       <!-- Date -->

                                       <div class="d-flex align-items-center mb-5">

                                          <div class="text-center me-4">

                                             <div class="pmb-schedule-date text-green">
                                                16
                                             </div>

                                             <div class="pmb-schedule-month">
                                                September
                                             </div>

                                          </div>

                                          <div>

                                             <h5 class="mb-1">
                                                Rabu, 16 September 2026
                                             </h5>

                                             <p class="text-muted mb-0 fs-14">
                                                Setelah pelaksanaan TPA
                                             </p>

                                          </div>

                                       </div>


                                       <!-- Time -->

                                       <div class="pmb-schedule-info">

                                          <i class="uil uil-clock text-green"></i>

                                          <div>

                                             <div class="pmb-schedule-info-label">
                                                Waktu
                                             </div>

                                             <div class="pmb-schedule-info-value">
                                                13.00 – 15.00 WIB
                                             </div>

                                          </div>

                                       </div>


                                       <!-- Location -->

                                       <div class="pmb-schedule-info">

                                          <i class="uil uil-location-point text-green"></i>

                                          <div>

                                             <div class="pmb-schedule-info-label">
                                                Lokasi
                                             </div>

                                             <div class="pmb-schedule-info-value">
                                                Kampus STIH Graha Kirana
                                             </div>

                                          </div>

                                       </div>


                                       <!-- Room -->

                                       <div class="pmb-schedule-info">

                                          <i class="uil uil-building text-green"></i>

                                          <div>

                                             <div class="pmb-schedule-info-label">
                                                Ruangan
                                             </div>

                                             <div class="pmb-schedule-info-value">
                                                Ruang Wawancara 02
                                             </div>

                                          </div>

                                       </div>


                                       <!-- Method -->

                                       <div class="pmb-schedule-info">

                                          <i class="uil uil-video text-green"></i>

                                          <div>

                                             <div class="pmb-schedule-info-label">
                                                Metode
                                             </div>

                                             <div class="pmb-schedule-info-value">
                                                Offline / Tatap Muka
                                             </div>

                                          </div>

                                       </div>


                                       <hr class="my-5">


                                       <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                                          <span class="text-muted fs-13">

                                             <i class="uil uil-info-circle me-1"></i>

                                             Siapkan dokumen pendukung.

                                          </span>

                                          <button
                                             type="button"
                                             class="btn btn-sm btn-outline-primary rounded">

                                             Lihat Detail

                                             <i class="uil uil-arrow-right ms-1"></i>

                                          </button>

                                       </div>


                                    </div>

                                 </div>

                              </div>

                           </div>


                        </div>

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

                              <button
                                 type="button"
                                 class="btn btn-primary rounded btn-icon btn-icon-end">

                                 Cetak Jadwal

                                 <i class="uil uil-print"></i>

                              </button>

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

                  <div class="card bg-primary text-white border-0 shadow-lg mb-6">

                     <div class="card-body p-6">

                        <span class="text-uppercase text-white opacity-75 fs-13 fw-bold">
                           Seleksi Berikutnya
                        </span>

                        <h3 class="text-white mt-2 mb-5">
                           Tes Potensi Akademik
                        </h3>


                        <div class="row text-center gx-2">


                           <div class="col-3">

                              <div class="bg-white bg-opacity-10 rounded p-3">

                                 <div
                                    class="fs-24 fw-bold text-white"
                                    id="countDays">
                                    12
                                 </div>

                                 <small class="text-white opacity-75">
                                    Hari
                                 </small>

                              </div>

                           </div>


                           <div class="col-3">

                              <div class="bg-white bg-opacity-10 rounded p-3">

                                 <div
                                    class="fs-24 fw-bold text-white"
                                    id="countHours">
                                    08
                                 </div>

                                 <small class="text-white opacity-75">
                                    Jam
                                 </small>

                              </div>

                           </div>


                           <div class="col-3">

                              <div class="bg-white bg-opacity-10 rounded p-3">

                                 <div
                                    class="fs-24 fw-bold text-white"
                                    id="countMinutes">
                                    25
                                 </div>

                                 <small class="text-white opacity-75">
                                    Menit
                                 </small>

                              </div>

                           </div>


                           <div class="col-3">

                              <div class="bg-white bg-opacity-10 rounded p-3">

                                 <div
                                    class="fs-24 fw-bold text-white"
                                    id="countSeconds">
                                    40
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
                           href="#"
                           class="btn btn-sm btn-outline-primary rounded">

                           Hubungi Panitia

                           <i class="uil uil-arrow-right ms-1"></i>

                        </a>

                     </div>

                  </div>


               </div>

            </div>


            <!-- =================================================
                 NEXT STEP
            ================================================== -->

            <div class="row mt-8">

               <div class="col-lg-10 mx-auto">

                  <div class="card bg-soft-primary border-0">

                     <div class="card-body p-5">

                        <div class="row align-items-center">

                           <div class="col-lg">

                              <div class="d-flex align-items-center">

                                 <div class="icon btn btn-circle btn-lg btn-primary me-4">

                                    <i class="uil uil-clipboard-alt"></i>

                                 </div>

                                 <div>

                                    <span class="text-uppercase text-muted fs-13 fw-bold">
                                       Tahap Berikutnya
                                    </span>

                                    <h4 class="mb-1">
                                       Pelaksanaan & Hasil Seleksi
                                    </h4>

                                    <p class="mb-0 text-muted">
                                       Setelah seleksi selesai, hasil akan diproses
                                       oleh tim seleksi dan diumumkan melalui Portal PMB.
                                    </p>

                                 </div>

                              </div>

                           </div>

                           <div class="col-lg-auto mt-4 mt-lg-0">

                              <span class="badge bg-soft-primary text-primary rounded-pill px-4 py-2">

                                 Tahap 05

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


   <!-- =========================================================
        JS
   ========================================================== -->

   <script src="./assets/js/plugins.js"></script>

   <script src="./assets/js/theme.js"></script>


   <script>
      /* =========================================================
         COUNTDOWN SELEKSI
      ========================================================= */

      const targetDate = new Date(
         "September 15, 2026 09:00:00"
      ).getTime();


      function updateCountdown() {

         const now = new Date().getTime();

         const distance = targetDate - now;


         if (distance <= 0) {

            document.getElementById("countDays").innerText = "00";
            document.getElementById("countHours").innerText = "00";
            document.getElementById("countMinutes").innerText = "00";
            document.getElementById("countSeconds").innerText = "00";

            return;

         }


         const days = Math.floor(
            distance / (1000 * 60 * 60 * 24)
         );


         const hours = Math.floor(
            (distance % (1000 * 60 * 60 * 24)) /
            (1000 * 60 * 60)
         );


         const minutes = Math.floor(
            (distance % (1000 * 60 * 60)) /
            (1000 * 60)
         );


         const seconds = Math.floor(
            (distance % (1000 * 60)) /
            1000
         );


         document.getElementById("countDays").innerText =
            String(days).padStart(2, "0");

         document.getElementById("countHours").innerText =
            String(hours).padStart(2, "0");

         document.getElementById("countMinutes").innerText =
            String(minutes).padStart(2, "0");

         document.getElementById("countSeconds").innerText =
            String(seconds).padStart(2, "0");

      }


      updateCountdown();

      setInterval(updateCountdown, 1000);
   </script>

</body>

</html>