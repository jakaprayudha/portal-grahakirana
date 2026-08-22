<!DOCTYPE html>
<html lang="en">

<head>
   <base href="../">

   <?php
   $page = 'Pelaksanaan & Hasil Seleksi PMB';
   require '../head.php';
   ?>

   <style>
      /* =========================================================
         PMB - TAHAP 05
         PELAKSANAAN & HASIL SELEKSI
      ========================================================= */

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

      /* Participant */
      .pmb-participant-card {
         border: 0;
      }

      .pmb-participant-id {
         font-size: 13px;
         font-weight: 700;
         letter-spacing: .4px;
      }

      /* Status */
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

      /* Examination */
      .pmb-exam-card {
         border: 0;
         transition: all .2s ease;
      }

      .pmb-exam-card:hover {
         transform: translateY(-2px);
         box-shadow: 0 15px 40px rgba(0, 0, 0, .07);
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

      .pmb-exam-info:last-child {
         margin-bottom: 0;
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

      /* Result */
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

      /* Timeline */
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

      .pmb-result-timeline-item:last-child {
         margin-bottom: 0;
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

      /* Next step */
      .pmb-next-card {
         border: 0;
      }

      /* Mobile */
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

         .pmb-participant-card .card-body {
            padding: 20px !important;
         }

         .pmb-status-icon {
            width: 58px;
            height: 58px;
            min-width: 58px;
         }

         .pmb-exam-card .card-body {
            padding: 20px !important;
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
           SECTION : TAHAP 05
      ====================================================== -->

      <section class="wrapper bg-light pmb-result-section">

         <div class="container">


            <!-- =================================================
                 HEADER
            ================================================== -->

            <div class="row pmb-page-header">

               <div class="col-lg-9">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
                     TAHAP 05
                  </span>

                  <h2 class="display-4 mb-3">
                     Pelaksanaan & Hasil Seleksi
                  </h2>

                  <p class="lead fs-18 mb-0">
                     Pantau pelaksanaan seleksi dan lihat hasil seleksi
                     penerimaan mahasiswa baru melalui Portal PMB.
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


                     <div class="col-lg-auto mt-4 mt-lg-0">

                        <span class="badge bg-soft-primary text-primary rounded-pill px-4 py-2">

                           Jalur Reguler

                        </span>

                     </div>

                  </div>

               </div>

            </div>


            <!-- =================================================
                 STATUS SELEKSI
            ================================================== -->

            <div class="card bg-primary text-white shadow-lg pmb-status-card mb-7">

               <div class="card-body p-5 p-md-6">

                  <div class="row align-items-center">


                     <div class="col-lg">

                        <div class="d-flex align-items-center">

                           <div class="pmb-status-icon bg-white text-primary me-4">

                              <i class="uil uil-clipboard-alt fs-28"></i>

                           </div>

                           <div>

                              <span class="text-white opacity-75 text-uppercase fs-13 fw-bold">
                                 Status Seleksi
                              </span>

                              <h3 class="text-white mt-1 mb-2">
                                 Seleksi Sedang Berlangsung
                              </h3>

                              <p class="text-white opacity-75 mb-0">

                                 Pastikan seluruh tahapan seleksi yang
                                 dijadwalkan telah Anda ikuti.

                              </p>

                           </div>

                        </div>

                     </div>


                     <div class="col-lg-auto mt-4 mt-lg-0">

                        <span class="badge bg-white text-primary rounded-pill px-4 py-2">

                           PROSES

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
                       PELAKSANAAN SELEKSI
                  ================================================== -->

                  <div class="card shadow-sm border-0 mb-6">

                     <div class="card-body p-5 p-md-6">


                        <div class="mb-6">

                           <span class="text-uppercase text-muted fs-13 fw-bold">
                              Pelaksanaan
                           </span>

                           <h3 class="mt-2 mb-2">
                              Riwayat Seleksi
                           </h3>

                           <p class="text-muted mb-0">
                              Status kehadiran dan pelaksanaan setiap
                              tahapan seleksi.
                           </p>

                        </div>


                        <!-- =================================================
                             TPA
                        ================================================== -->

                        <div class="card pmb-exam-card mb-4">

                           <div class="card-body p-5">

                              <div class="d-flex align-items-start">


                                 <div class="pmb-exam-icon bg-soft-primary text-primary me-4">

                                    <i class="uil uil-file-alt fs-24"></i>

                                 </div>


                                 <div class="flex-grow-1">

                                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">

                                       <div>

                                          <span class="badge bg-soft-primary text-primary rounded-pill mb-2">
                                             SELEKSI 01
                                          </span>

                                          <h4 class="mb-1">
                                             Tes Potensi Akademik
                                          </h4>

                                       </div>

                                       <span class="badge bg-soft-green text-green rounded-pill">

                                          <i class="uil uil-check me-1"></i>

                                          Selesai

                                       </span>

                                    </div>


                                    <hr class="my-4">


                                    <div class="row">


                                       <div class="col-md-6">

                                          <div class="pmb-exam-info">

                                             <i class="uil uil-calendar-alt"></i>

                                             <div>

                                                <div class="pmb-exam-label">
                                                   Tanggal
                                                </div>

                                                <div class="pmb-exam-value">
                                                   15 September 2026
                                                </div>

                                             </div>

                                          </div>

                                       </div>


                                       <div class="col-md-6">

                                          <div class="pmb-exam-info">

                                             <i class="uil uil-clock"></i>

                                             <div>

                                                <div class="pmb-exam-label">
                                                   Waktu
                                                </div>

                                                <div class="pmb-exam-value">
                                                   09.00 – 11.00 WIB
                                                </div>

                                             </div>

                                          </div>

                                       </div>


                                       <div class="col-md-6">

                                          <div class="pmb-exam-info">

                                             <i class="uil uil-location-point"></i>

                                             <div>

                                                <div class="pmb-exam-label">
                                                   Lokasi
                                                </div>

                                                <div class="pmb-exam-value">
                                                   Kampus STIH Graha Kirana
                                                </div>

                                             </div>

                                          </div>

                                       </div>


                                       <div class="col-md-6">

                                          <div class="pmb-exam-info">

                                             <i class="uil uil-user-check"></i>

                                             <div>

                                                <div class="pmb-exam-label">
                                                   Kehadiran
                                                </div>

                                                <div class="pmb-exam-value text-green">
                                                   Hadir
                                                </div>

                                             </div>

                                          </div>

                                       </div>


                                    </div>


                                 </div>

                              </div>

                           </div>

                        </div>


                        <!-- =================================================
                             WAWANCARA
                        ================================================== -->

                        <div class="card pmb-exam-card">

                           <div class="card-body p-5">

                              <div class="d-flex align-items-start">


                                 <div class="pmb-exam-icon bg-soft-green text-green me-4">

                                    <i class="uil uil-comments fs-24"></i>

                                 </div>


                                 <div class="flex-grow-1">

                                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">

                                       <div>

                                          <span class="badge bg-soft-green text-green rounded-pill mb-2">
                                             SELEKSI 02
                                          </span>

                                          <h4 class="mb-1">
                                             Wawancara
                                          </h4>

                                       </div>

                                       <span class="badge bg-soft-yellow text-yellow rounded-pill">

                                          <i class="uil uil-clock me-1"></i>

                                          Terjadwal

                                       </span>

                                    </div>


                                    <hr class="my-4">


                                    <div class="row">


                                       <div class="col-md-6">

                                          <div class="pmb-exam-info">

                                             <i class="uil uil-calendar-alt"></i>

                                             <div>

                                                <div class="pmb-exam-label">
                                                   Tanggal
                                                </div>

                                                <div class="pmb-exam-value">
                                                   16 September 2026
                                                </div>

                                             </div>

                                          </div>

                                       </div>


                                       <div class="col-md-6">

                                          <div class="pmb-exam-info">

                                             <i class="uil uil-clock"></i>

                                             <div>

                                                <div class="pmb-exam-label">
                                                   Waktu
                                                </div>

                                                <div class="pmb-exam-value">
                                                   13.00 – 15.00 WIB
                                                </div>

                                             </div>

                                          </div>

                                       </div>


                                       <div class="col-md-6">

                                          <div class="pmb-exam-info">

                                             <i class="uil uil-location-point"></i>

                                             <div>

                                                <div class="pmb-exam-label">
                                                   Lokasi
                                                </div>

                                                <div class="pmb-exam-value">
                                                   Kampus STIH Graha Kirana
                                                </div>

                                             </div>

                                          </div>

                                       </div>


                                       <div class="col-md-6">

                                          <div class="pmb-exam-info">

                                             <i class="uil uil-user"></i>

                                             <div>

                                                <div class="pmb-exam-label">
                                                   Status
                                                </div>

                                                <div class="pmb-exam-value text-yellow">
                                                   Menunggu Pelaksanaan
                                                </div>

                                             </div>

                                          </div>

                                       </div>


                                    </div>


                                 </div>

                              </div>

                           </div>

                        </div>


                     </div>

                  </div>


                  <!-- =================================================
                       HASIL SELEKSI
                  ================================================== -->

                  <div class="card shadow-sm border-0 mb-6">

                     <div class="card-body p-5 p-md-6">


                        <div class="mb-6">

                           <span class="text-uppercase text-muted fs-13 fw-bold">
                              Hasil
                           </span>

                           <h3 class="mt-2 mb-2">
                              Hasil Seleksi
                           </h3>

                           <p class="text-muted mb-0">
                              Hasil akhir akan ditampilkan setelah seluruh
                              proses seleksi selesai dan diverifikasi.
                           </p>

                        </div>


                        <!-- =================================================
                             RESULT
                        ================================================== -->

                        <div class="pmb-result-box">


                           <div class="pmb-result-icon pmb-result-pending">

                              <i class="uil uil-clock fs-35"></i>

                           </div>


                           <span class="badge bg-soft-yellow text-yellow rounded-pill mb-3">
                              MENUNGGU HASIL
                           </span>


                           <h3 class="mb-3">
                              Hasil Belum Diumumkan
                           </h3>


                           <p class="text-muted mb-0">

                              Hasil seleksi akan tersedia setelah seluruh
                              tahapan seleksi selesai dilaksanakan dan
                              proses penilaian telah diselesaikan oleh
                              panitia PMB.

                           </p>


                        </div>


                        <!-- =================================================
                             SCORE PLACEHOLDER
                        ================================================== -->

                        <div class="row gx-3 mt-5">


                           <div class="col-md-4 mb-3 mb-md-0">

                              <div class="pmb-score-card">

                                 <div class="pmb-score text-muted">
                                    —
                                 </div>

                                 <div class="pmb-score-label">
                                    Nilai TPA
                                 </div>

                              </div>

                           </div>


                           <div class="col-md-4 mb-3 mb-md-0">

                              <div class="pmb-score-card">

                                 <div class="pmb-score text-muted">
                                    —
                                 </div>

                                 <div class="pmb-score-label">
                                    Nilai Wawancara
                                 </div>

                              </div>

                           </div>


                           <div class="col-md-4">

                              <div class="pmb-score-card">

                                 <div class="pmb-score text-muted">
                                    —
                                 </div>

                                 <div class="pmb-score-label">
                                    Nilai Akhir
                                 </div>

                              </div>

                           </div>


                        </div>


                     </div>

                  </div>


                  <!-- =================================================
                       PROCESS TIMELINE
                  ================================================== -->

                  <div class="card shadow-sm border-0">

                     <div class="card-body p-5 p-md-6">


                        <span class="text-uppercase text-muted fs-13 fw-bold">
                           Proses PMB
                        </span>

                        <h3 class="mt-2 mb-6">
                           Perjalanan Pendaftaran Anda
                        </h3>


                        <div class="pmb-result-timeline">


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

                              <div class="pmb-result-number complete">
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

                              <div class="pmb-result-number complete">
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

                              <div class="pmb-result-number active">
                                 5
                              </div>

                              <div>

                                 <h5 class="mb-1">
                                    Pelaksanaan & Hasil Seleksi
                                 </h5>

                                 <p class="text-muted fs-14 mb-0">
                                    Menunggu seluruh proses seleksi selesai.
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
                       NEXT ACTION
                  ================================================== -->

                  <div class="card bg-primary text-white border-0 shadow-lg mb-6">

                     <div class="card-body p-6">

                        <span class="text-white opacity-75 text-uppercase fs-13 fw-bold">
                           Tindakan Anda
                        </span>

                        <h3 class="text-white mt-2 mb-4">
                           Pastikan Seleksi Selesai
                        </h3>

                        <p class="text-white opacity-75 mb-5">

                           Pastikan Anda telah mengikuti seluruh tahapan
                           seleksi yang dijadwalkan.

                        </p>


                        <div class="d-grid">

                           <a
                              href="#"
                              class="btn btn-white text-primary rounded">

                              Lihat Jadwal Seleksi

                              <i class="uil uil-arrow-right ms-1"></i>

                           </a>

                        </div>

                     </div>

                  </div>


                  <!-- =================================================
                       RESULT INFORMATION
                  ================================================== -->

                  <div class="card shadow-sm border-0 mb-6">

                     <div class="card-body p-6">

                        <span class="text-uppercase text-muted fs-13 fw-bold">
                           Informasi Hasil
                        </span>

                        <h4 class="mt-2 mb-5">
                           Bagaimana hasil ditentukan?
                        </h4>


                        <div class="d-flex mb-4">

                           <div class="icon btn btn-circle btn-sm btn-soft-primary me-3 flex-shrink-0">

                              <i class="uil uil-file-alt"></i>

                           </div>

                           <div>

                              <h6 class="mb-1">
                                 Tes Potensi Akademik
                              </h6>

                              <p class="text-muted fs-13 mb-0">
                                 Nilai dari pelaksanaan tes akademik.
                              </p>

                           </div>

                        </div>


                        <div class="d-flex mb-4">

                           <div class="icon btn btn-circle btn-sm btn-soft-green me-3 flex-shrink-0">

                              <i class="uil uil-comments"></i>

                           </div>

                           <div>

                              <h6 class="mb-1">
                                 Wawancara
                              </h6>

                              <p class="text-muted fs-13 mb-0">
                                 Penilaian dari proses wawancara.
                              </p>

                           </div>

                        </div>


                        <div class="d-flex">

                           <div class="icon btn btn-circle btn-sm btn-soft-yellow me-3 flex-shrink-0">

                              <i class="uil uil-clipboard-alt"></i>

                           </div>

                           <div>

                              <h6 class="mb-1">
                                 Verifikasi Panitia
                              </h6>

                              <p class="text-muted fs-13 mb-0">
                                 Hasil diverifikasi sebelum diumumkan.
                              </p>

                           </div>

                        </div>

                     </div>

                  </div>


                  <!-- =================================================
                       HELP
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

                           Jika status seleksi belum diperbarui atau terdapat
                           kendala, silakan hubungi panitia PMB.

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

                  <div class="card bg-soft-primary border-0 pmb-next-card">

                     <div class="card-body p-5">

                        <div class="row align-items-center">

                           <div class="col-lg">

                              <div class="d-flex align-items-center">

                                 <div class="icon btn btn-circle btn-lg btn-primary me-4">

                                    <i class="uil uil-award"></i>

                                 </div>

                                 <div>

                                    <span class="text-uppercase text-muted fs-13 fw-bold">
                                       Tahap Berikutnya
                                    </span>

                                    <h4 class="mb-1">
                                       Pengumuman Kelulusan
                                    </h4>

                                    <p class="mb-0 text-muted">
                                       Setelah hasil seleksi ditetapkan,
                                       status kelulusan akan tersedia di Portal PMB.
                                    </p>

                                 </div>

                              </div>

                           </div>

                           <div class="col-lg-auto mt-4 mt-lg-0">

                              <span class="badge bg-soft-primary text-primary rounded-pill px-4 py-2">

                                 TAHAP 06

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

</body>

</html>