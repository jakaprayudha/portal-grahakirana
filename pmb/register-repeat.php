<!DOCTYPE html>
<html lang="en">

<head>
   <base href="../">

   <?php
   $page = 'Daftar Ulang PMB';
   require '../head.php';
   ?>

   <style>
      /* =========================================================
         PMB - TAHAP 07
         DAFTAR ULANG
      ========================================================= */

      .pmb-rereg-section {
         padding-top: 60px;
         padding-bottom: 80px;
      }

      .pmb-page-header {
         margin-bottom: 40px;
      }

      .pmb-page-header h2 {
         font-size: 2.5rem;
      }

      /* =========================================================
         PARTICIPANT
      ========================================================= */

      .pmb-participant-card {
         border: 0;
      }

      .pmb-participant-id {
         font-size: 13px;
         font-weight: 700;
         letter-spacing: .4px;
      }

      /* =========================================================
         STATUS HERO
      ========================================================= */

      .pmb-rereg-hero {
         border: 0;
         overflow: hidden;
         position: relative;
      }

      .pmb-rereg-hero::after {
         content: "";
         position: absolute;
         width: 250px;
         height: 250px;
         border-radius: 50%;
         background: rgba(255, 255, 255, .07);
         right: -90px;
         top: -130px;
      }

      .pmb-rereg-hero-content {
         position: relative;
         z-index: 2;
      }

      .pmb-rereg-icon {
         width: 75px;
         height: 75px;
         min-width: 75px;
         border-radius: 50%;
         background: #fff;
         display: flex;
         align-items: center;
         justify-content: center;
      }

      /* =========================================================
         CHECKLIST
      ========================================================= */

      .pmb-checklist-card {
         border: 0;
      }

      .pmb-check-item {
         display: flex;
         align-items: flex-start;
         padding: 18px 0;
         border-bottom: 1px solid #edf0f3;
      }

      .pmb-check-item:first-child {
         padding-top: 0;
      }

      .pmb-check-item:last-child {
         border-bottom: 0;
         padding-bottom: 0;
      }

      .pmb-check-icon {
         width: 42px;
         height: 42px;
         min-width: 42px;
         border-radius: 10px;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-right: 14px;
      }

      .pmb-check-status {
         margin-left: auto;
         padding-left: 15px;
      }

      /* =========================================================
         FORM
      ========================================================= */

      .pmb-form-card {
         border: 0;
      }

      .pmb-form-section-title {
         display: flex;
         align-items: center;
         margin-bottom: 25px;
      }

      .pmb-form-section-number {
         width: 38px;
         height: 38px;
         min-width: 38px;
         border-radius: 50%;
         background: #edf3ff;
         color: #3f78e0;
         display: flex;
         align-items: center;
         justify-content: center;
         font-weight: 700;
         margin-right: 13px;
      }

      .pmb-form-label {
         font-size: 13px;
         font-weight: 600;
         margin-bottom: 8px;
      }

      .pmb-required {
         color: #d63939;
      }

      .pmb-upload {
         border: 1.5px dashed #d8dee7;
         border-radius: 10px;
         padding: 22px;
         background: #fafbfc;
         transition: all .2s ease;
      }

      .pmb-upload:hover {
         border-color: #3f78e0;
         background: #f8faff;
      }

      .pmb-upload-icon {
         width: 45px;
         height: 45px;
         border-radius: 10px;
         background: #edf3ff;
         color: #3f78e0;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-bottom: 12px;
      }

      .pmb-file-info {
         font-size: 12px;
         color: #8a8f98;
      }

      /* =========================================================
         PAYMENT
      ========================================================= */

      .pmb-payment-card {
         border: 1px solid #e8ecf1;
         border-radius: 12px;
         overflow: hidden;
      }

      .pmb-payment-header {
         padding: 18px 20px;
         background: #fafbfc;
         border-bottom: 1px solid #e8ecf1;
      }

      .pmb-payment-body {
         padding: 22px 20px;
      }

      .pmb-payment-row {
         display: flex;
         justify-content: space-between;
         padding: 9px 0;
         font-size: 14px;
      }

      .pmb-payment-total {
         border-top: 1px dashed #dfe4ea;
         margin-top: 10px;
         padding-top: 15px;
         font-size: 17px;
         font-weight: 700;
      }

      /* =========================================================
         SIDE PROCESS
      ========================================================= */

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

      /* =========================================================
         INFO
      ========================================================= */

      .pmb-info-item {
         display: flex;
         align-items: flex-start;
         margin-bottom: 18px;
      }

      .pmb-info-item:last-child {
         margin-bottom: 0;
      }

      .pmb-info-icon {
         width: 38px;
         height: 38px;
         min-width: 38px;
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

         .pmb-rereg-section {
            padding-top: 50px;
            padding-bottom: 60px;
         }

         .pmb-page-header h2 {
            font-size: 2.2rem;
         }

         .pmb-process::before {
            display: none;
         }

      }

      @media (max-width: 767.98px) {

         .pmb-rereg-section {
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

         .pmb-rereg-hero .card-body {
            padding: 30px 20px !important;
         }

         .pmb-rereg-icon {
            width: 60px;
            height: 60px;
            min-width: 60px;
         }

         .pmb-check-item {
            flex-wrap: wrap;
         }

         .pmb-check-status {
            margin-left: 56px;
            margin-top: 8px;
            padding-left: 0;
         }

         .pmb-form-card .card-body {
            padding: 20px !important;
         }

      }

      @media (max-width: 575.98px) {

         .pmb-page-header h2 {
            font-size: 1.6rem;
         }

         .pmb-rereg-hero .d-flex {
            align-items: flex-start !important;
         }

         .pmb-rereg-icon {
            width: 52px;
            height: 52px;
            min-width: 52px;
            margin-right: 13px !important;
         }

         .pmb-check-icon {
            width: 38px;
            height: 38px;
            min-width: 38px;
         }

         .pmb-upload {
            padding: 18px;
         }

         .pmb-payment-row {
            font-size: 13px;
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
           SECTION : TAHAP 07
      ====================================================== -->

      <section class="wrapper bg-light pmb-rereg-section">

         <div class="container">


            <!-- =================================================
                 HEADER
            ================================================== -->

            <div class="row pmb-page-header">

               <div class="col-lg-9">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
                     TAHAP 07
                  </span>

                  <h2 class="display-4 mb-3">
                     Daftar Ulang
                  </h2>

                  <p class="lead fs-18 mb-0">
                     Lengkapi proses daftar ulang untuk mengonfirmasi
                     penerimaan Anda sebagai mahasiswa baru.
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
                                 Calon Mahasiswa
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

                        <span class="badge bg-soft-green text-green rounded-pill px-4 py-2">

                           <i class="uil uil-check me-1"></i>

                           LULUS SELEKSI

                        </span>

                     </div>


                  </div>

               </div>

            </div>


            <!-- =================================================
                 HERO
            ================================================== -->

            <div class="card bg-green text-white shadow-lg pmb-rereg-hero mb-7">

               <div class="card-body p-5 p-md-6">

                  <div class="pmb-rereg-hero-content">

                     <div class="d-flex align-items-center">


                        <div class="pmb-rereg-icon text-green me-4">

                           <i class="uil uil-file-check-alt fs-30"></i>

                        </div>


                        <div>

                           <span class="text-white opacity-75 text-uppercase fs-13 fw-bold">
                              Status Penerimaan
                           </span>

                           <h3 class="text-white mt-1 mb-2">
                              Selamat! Anda Berhak Daftar Ulang
                           </h3>

                           <p class="text-white opacity-75 mb-0">

                              Lengkapi persyaratan daftar ulang sesuai
                              batas waktu yang ditentukan oleh panitia PMB.

                           </p>

                        </div>


                     </div>

                  </div>

               </div>

            </div>


            <!-- =================================================
                 MAIN
            ================================================== -->

            <div class="row gx-lg-8 gy-6">


               <!-- =================================================
                    LEFT
               ================================================== -->

               <div class="col-lg-8">


                  <!-- =================================================
                       CHECKLIST
                  ================================================== -->

                  <div class="card shadow-sm pmb-checklist-card mb-6">

                     <div class="card-body p-5 p-md-6">


                        <div class="mb-6">

                           <span class="text-uppercase text-muted fs-13 fw-bold">
                              Persyaratan
                           </span>

                           <h3 class="mt-2 mb-2">
                              Checklist Daftar Ulang
                           </h3>

                           <p class="text-muted mb-0">
                              Pastikan seluruh persyaratan berikut telah
                              disiapkan sebelum mengajukan daftar ulang.
                           </p>

                        </div>


                        <!-- Item 1 -->

                        <div class="pmb-check-item">

                           <div class="pmb-check-icon bg-soft-green text-green">

                              <i class="uil uil-check-circle fs-20"></i>

                           </div>

                           <div class="flex-grow-1">

                              <h5 class="mb-1">
                                 Kartu Peserta PMB
                              </h5>

                              <p class="text-muted fs-13 mb-0">
                                 Kartu peserta yang telah diterbitkan
                                 pada tahap pendaftaran.
                              </p>

                           </div>

                           <div class="pmb-check-status">

                              <span class="badge bg-soft-green text-green rounded-pill">
                                 Siap
                              </span>

                           </div>

                        </div>


                        <!-- Item 2 -->

                        <div class="pmb-check-item">

                           <div class="pmb-check-icon bg-soft-green text-green">

                              <i class="uil uil-check-circle fs-20"></i>

                           </div>

                           <div class="flex-grow-1">

                              <h5 class="mb-1">
                                 Identitas Diri
                              </h5>

                              <p class="text-muted fs-13 mb-0">
                                 KTP atau dokumen identitas yang berlaku.
                              </p>

                           </div>

                           <div class="pmb-check-status">

                              <span class="badge bg-soft-green text-green rounded-pill">
                                 Siap
                              </span>

                           </div>

                        </div>


                        <!-- Item 3 -->

                        <div class="pmb-check-item">

                           <div class="pmb-check-icon bg-soft-green text-green">

                              <i class="uil uil-check-circle fs-20"></i>

                           </div>

                           <div class="flex-grow-1">

                              <h5 class="mb-1">
                                 Dokumen Persyaratan
                              </h5>

                              <p class="text-muted fs-13 mb-0">
                                 Dokumen pendukung sesuai ketentuan
                                 daftar ulang.
                              </p>

                           </div>

                           <div class="pmb-check-status">

                              <span class="badge bg-soft-green text-green rounded-pill">
                                 Siap
                              </span>

                           </div>

                        </div>


                        <!-- Item 4 -->

                        <div class="pmb-check-item">

                           <div class="pmb-check-icon bg-soft-yellow text-yellow">

                              <i class="uil uil-clock fs-20"></i>

                           </div>

                           <div class="flex-grow-1">

                              <h5 class="mb-1">
                                 Pembayaran
                              </h5>

                              <p class="text-muted fs-13 mb-0">
                                 Selesaikan pembayaran sesuai tagihan
                                 daftar ulang.
                              </p>

                           </div>

                           <div class="pmb-check-status">

                              <span class="badge bg-soft-yellow text-yellow rounded-pill">
                                 Belum

                              </span>

                           </div>

                        </div>


                     </div>

                  </div>


                  <!-- =================================================
                       FORM DAFTAR ULANG
                  ================================================== -->

                  <div class="card shadow-sm pmb-form-card">

                     <div class="card-body p-5 p-md-6">


                        <div class="mb-7">

                           <span class="text-uppercase text-muted fs-13 fw-bold">
                              Formulir
                           </span>

                           <h3 class="mt-2 mb-2">
                              Form Daftar Ulang
                           </h3>

                           <p class="text-muted mb-0">
                              Lengkapi data berikut untuk mengajukan
                              proses daftar ulang.
                           </p>

                        </div>


                        <!-- =================================================
                             SECTION 01
                        ================================================== -->

                        <div class="pmb-form-section-title">

                           <div class="pmb-form-section-number">
                              01
                           </div>

                           <div>

                              <h4 class="mb-0">
                                 Konfirmasi Data
                              </h4>

                              <small class="text-muted">
                                 Periksa kembali data penerimaan Anda.
                              </small>

                           </div>

                        </div>


                        <div class="row gx-4">


                           <div class="col-md-6 mb-4">

                              <label class="pmb-form-label">
                                 Nama Lengkap
                              </label>

                              <input
                                 type="text"
                                 class="form-control"
                                 value="Jaka Prayudha"
                                 readonly>

                           </div>


                           <div class="col-md-6 mb-4">

                              <label class="pmb-form-label">
                                 ID Pendaftaran
                              </label>

                              <input
                                 type="text"
                                 class="form-control"
                                 value="99-26-69-74-01-001"
                                 readonly>

                           </div>


                           <div class="col-md-6 mb-4">

                              <label class="pmb-form-label">
                                 Program Studi
                              </label>

                              <input
                                 type="text"
                                 class="form-control"
                                 value="Ilmu Hukum"
                                 readonly>

                           </div>


                           <div class="col-md-6 mb-4">

                              <label class="pmb-form-label">
                                 Jalur Pendaftaran
                              </label>

                              <input
                                 type="text"
                                 class="form-control"
                                 value="Reguler"
                                 readonly>

                           </div>


                        </div>


                        <hr class="my-6">


                        <!-- =================================================
                             SECTION 02
                        ================================================== -->

                        <div class="pmb-form-section-title">

                           <div class="pmb-form-section-number">
                              02
                           </div>

                           <div>

                              <h4 class="mb-0">
                                 Data Tambahan
                              </h4>

                              <small class="text-muted">
                                 Lengkapi informasi yang diperlukan.
                              </small>

                           </div>

                        </div>


                        <div class="row gx-4">


                           <!-- NIK -->

                           <div class="col-md-6 mb-4">

                              <label class="pmb-form-label">

                                 NIK

                                 <span class="pmb-required">
                                    *
                                 </span>

                              </label>

                              <input
                                 type="text"
                                 class="form-control"
                                 placeholder="Masukkan NIK">

                           </div>


                           <!-- No HP -->

                           <div class="col-md-6 mb-4">

                              <label class="pmb-form-label">

                                 Nomor WhatsApp

                                 <span class="pmb-required">
                                    *
                                 </span>

                              </label>

                              <input
                                 type="tel"
                                 class="form-control"
                                 placeholder="08xxxxxxxxxx">

                           </div>


                           <!-- Email -->

                           <div class="col-md-6 mb-4">

                              <label class="pmb-form-label">
                                 Email
                              </label>

                              <input
                                 type="email"
                                 class="form-control"
                                 value="jaka@example.com">

                           </div>


                           <!-- Address -->

                           <div class="col-12 mb-4">

                              <label class="pmb-form-label">

                                 Alamat Domisili

                                 <span class="pmb-required">
                                    *
                                 </span>

                              </label>

                              <textarea
                                 class="form-control"
                                 rows="3"
                                 placeholder="Masukkan alamat domisili"></textarea>

                           </div>


                        </div>


                        <hr class="my-6">


                        <!-- =================================================
                             SECTION 03
                        ================================================== -->

                        <div class="pmb-form-section-title">

                           <div class="pmb-form-section-number">
                              03
                           </div>

                           <div>

                              <h4 class="mb-0">
                                 Upload Dokumen
                              </h4>

                              <small class="text-muted">
                                 Upload dokumen yang dipersyaratkan.
                              </small>

                           </div>

                        </div>


                        <div class="row gx-4">


                           <!-- Dokumen Identitas -->

                           <div class="col-md-6 mb-4">

                              <div class="pmb-upload">

                                 <div class="pmb-upload-icon">

                                    <i class="uil uil-id-card fs-20"></i>

                                 </div>

                                 <h5 class="mb-1">
                                    KTP / Identitas
                                 </h5>

                                 <p class="text-muted fs-13 mb-3">
                                    PDF, JPG, PNG — maksimal 2 MB
                                 </p>

                                 <input
                                    type="file"
                                    class="form-control form-control-sm"
                                    accept=".pdf,.jpg,.jpeg,.png">

                              </div>

                           </div>


                           <!-- Ijazah -->

                           <div class="col-md-6 mb-4">

                              <div class="pmb-upload">

                                 <div class="pmb-upload-icon">

                                    <i class="uil uil-file-alt fs-20"></i>

                                 </div>

                                 <h5 class="mb-1">
                                    Ijazah / Surat Keterangan
                                 </h5>

                                 <p class="text-muted fs-13 mb-3">
                                    PDF, JPG, PNG — maksimal 2 MB
                                 </p>

                                 <input
                                    type="file"
                                    class="form-control form-control-sm"
                                    accept=".pdf,.jpg,.jpeg,.png">

                              </div>

                           </div>


                           <!-- KK -->

                           <div class="col-md-6 mb-4">

                              <div class="pmb-upload">

                                 <div class="pmb-upload-icon">

                                    <i class="uil uil-users-alt fs-20"></i>

                                 </div>

                                 <h5 class="mb-1">
                                    Kartu Keluarga
                                 </h5>

                                 <p class="text-muted fs-13 mb-3">
                                    PDF, JPG, PNG — maksimal 2 MB
                                 </p>

                                 <input
                                    type="file"
                                    class="form-control form-control-sm"
                                    accept=".pdf,.jpg,.jpeg,.png">

                              </div>

                           </div>


                           <!-- Pas Foto -->

                           <div class="col-md-6 mb-4">

                              <div class="pmb-upload">

                                 <div class="pmb-upload-icon">

                                    <i class="uil uil-camera"></i>

                                 </div>

                                 <h5 class="mb-1">
                                    Pas Foto
                                 </h5>

                                 <p class="text-muted fs-13 mb-3">
                                    JPG, PNG — maksimal 2 MB
                                 </p>

                                 <input
                                    type="file"
                                    class="form-control form-control-sm"
                                    accept=".jpg,.jpeg,.png">

                              </div>

                           </div>


                        </div>


                        <hr class="my-6">


                        <!-- =================================================
                             SECTION 04
                        ================================================== -->

                        <div class="pmb-form-section-title">

                           <div class="pmb-form-section-number">
                              04
                           </div>

                           <div>

                              <h4 class="mb-0">
                                 Konfirmasi Pembayaran
                              </h4>

                              <small class="text-muted">
                                 Upload bukti pembayaran jika diperlukan.
                              </small>

                           </div>

                        </div>


                        <div class="pmb-payment-card mb-5">


                           <div class="pmb-payment-header">

                              <div class="d-flex align-items-center">

                                 <div class="icon btn btn-circle btn-sm btn-soft-primary me-3">

                                    <i class="uil uil-receipt"></i>

                                 </div>

                                 <div>

                                    <h5 class="mb-0">
                                       Tagihan Daftar Ulang
                                    </h5>

                                    <small class="text-muted">
                                       Informasi biaya
                                    </small>

                                 </div>

                              </div>

                           </div>


                           <div class="pmb-payment-body">


                              <div class="pmb-payment-row">

                                 <span class="text-muted">
                                    Biaya Daftar Ulang
                                 </span>

                                 <strong>
                                    Rp —
                                 </strong>

                              </div>


                              <div class="pmb-payment-row">

                                 <span class="text-muted">
                                    Biaya Administrasi
                                 </span>

                                 <strong>
                                    Rp —
                                 </strong>

                              </div>


                              <div class="pmb-payment-row pmb-payment-total">

                                 <span>
                                    Total
                                 </span>

                                 <span class="text-primary">
                                    Rp —
                                 </span>

                              </div>


                           </div>

                        </div>


                        <div class="pmb-upload mb-5">

                           <div class="pmb-upload-icon">

                              <i class="uil uil-receipt"></i>

                           </div>

                           <h5 class="mb-1">
                              Bukti Pembayaran
                           </h5>

                           <p class="text-muted fs-13 mb-3">

                              Upload bukti pembayaran yang valid.

                           </p>

                           <input
                              type="file"
                              class="form-control"
                              accept=".pdf,.jpg,.jpeg,.png">

                        </div>


                        <hr class="my-6">


                        <!-- =================================================
                             SECTION 05
                        ================================================== -->

                        <div class="pmb-form-section-title">

                           <div class="pmb-form-section-number">
                              05
                           </div>

                           <div>

                              <h4 class="mb-0">
                                 Pernyataan
                              </h4>

                              <small class="text-muted">
                                 Konfirmasi sebelum mengirim daftar ulang.
                              </small>

                           </div>

                        </div>


                        <div class="form-check mb-4">

                           <input
                              class="form-check-input"
                              type="checkbox"
                              id="agreement">

                           <label
                              class="form-check-label fs-14"
                              for="agreement">

                              Saya menyatakan bahwa data dan dokumen yang
                              saya berikan dalam proses daftar ulang adalah
                              benar dan dapat dipertanggungjawabkan.

                           </label>

                        </div>


                        <div class="form-check mb-6">

                           <input
                              class="form-check-input"
                              type="checkbox"
                              id="agreement2">

                           <label
                              class="form-check-label fs-14"
                              for="agreement2">

                              Saya bersedia mengikuti ketentuan akademik
                              dan administrasi yang berlaku di STIH Graha Kirana.

                           </label>

                        </div>


                        <!-- Submit -->

                        <div class="alert alert-primary alert-icon mb-5">

                           <i class="uil uil-info-circle"></i>

                           <p class="mb-0 fs-14">

                              Setelah dikirim, data daftar ulang akan
                              diverifikasi oleh panitia. Pastikan seluruh
                              informasi telah benar sebelum mengajukan.

                           </p>

                        </div>


                        <div class="d-flex justify-content-end">

                           <button
                              type="button"
                              class="btn btn-primary btn-lg rounded btn-icon btn-icon-end">

                              Ajukan Daftar Ulang

                              <i class="uil uil-arrow-right"></i>

                           </button>

                        </div>


                     </div>

                  </div>


               </div>


               <!-- =================================================
                    RIGHT
               ================================================== -->

               <div class="col-lg-4">


                  <!-- =================================================
                       PROCESS
                  ================================================== -->

                  <div class="card shadow-sm border-0 mb-6">

                     <div class="card-body p-6">

                        <span class="text-uppercase text-muted fs-13 fw-bold">
                           Proses PMB
                        </span>

                        <h4 class="mt-2 mb-5">
                           Status Tahapan
                        </h4>


                        <div class="pmb-process">


                           <!-- 01 -->

                           <div class="pmb-process-item">

                              <div class="pmb-process-number complete">

                                 <i class="uil uil-check"></i>

                              </div>

                              <div>

                                 <h6 class="mb-1">
                                    Registrasi
                                 </h6>

                                 <p class="text-muted fs-13 mb-0">
                                    Selesai
                                 </p>

                              </div>

                           </div>


                           <!-- 02 -->

                           <div class="pmb-process-item">

                              <div class="pmb-process-number complete">

                                 <i class="uil uil-check"></i>

                              </div>

                              <div>

                                 <h6 class="mb-1">
                                    Data & Dokumen
                                 </h6>

                                 <p class="text-muted fs-13 mb-0">
                                    Lengkap
                                 </p>

                              </div>

                           </div>


                           <!-- 03 -->

                           <div class="pmb-process-item">

                              <div class="pmb-process-number complete">

                                 <i class="uil uil-check"></i>

                              </div>

                              <div>

                                 <h6 class="mb-1">
                                    Kartu Peserta
                                 </h6>

                                 <p class="text-muted fs-13 mb-0">
                                    Diterbitkan
                                 </p>

                              </div>

                           </div>


                           <!-- 04 -->

                           <div class="pmb-process-item">

                              <div class="pmb-process-number complete">

                                 <i class="uil uil-check"></i>

                              </div>

                              <div>

                                 <h6 class="mb-1">
                                    Jadwal Seleksi
                                 </h6>

                                 <p class="text-muted fs-13 mb-0">
                                    Selesai
                                 </p>

                              </div>

                           </div>


                           <!-- 05 -->

                           <div class="pmb-process-item">

                              <div class="pmb-process-number complete">

                                 <i class="uil uil-check"></i>

                              </div>

                              <div>

                                 <h6 class="mb-1">
                                    Seleksi
                                 </h6>

                                 <p class="text-muted fs-13 mb-0">
                                    Selesai
                                 </p>

                              </div>

                           </div>


                           <!-- 06 -->

                           <div class="pmb-process-item">

                              <div class="pmb-process-number complete">

                                 <i class="uil uil-check"></i>

                              </div>

                              <div>

                                 <h6 class="mb-1">
                                    Pengumuman
                                 </h6>

                                 <p class="text-muted fs-13 mb-0">
                                    Lulus
                                 </p>

                              </div>

                           </div>


                           <!-- 07 -->

                           <div class="pmb-process-item">

                              <div class="pmb-process-number active">

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


                        </div>

                     </div>

                  </div>


                  <!-- =================================================
                       DEADLINE
                  ================================================== -->

                  <div class="card bg-soft-yellow border-0 mb-6">

                     <div class="card-body p-6">

                        <div class="icon btn btn-circle btn-sm btn-soft-yellow mb-4">

                           <i class="uil uil-calendar-alt"></i>

                        </div>

                        <span class="text-uppercase text-muted fs-13 fw-bold">
                           Batas Waktu
                        </span>

                        <h4 class="mt-2 mb-2">
                           Daftar Ulang
                        </h4>

                        <p class="text-muted fs-14 mb-0">

                           Batas waktu daftar ulang akan ditampilkan
                           setelah ditetapkan oleh panitia.

                        </p>

                     </div>

                  </div>


                  <!-- =================================================
                       INFORMATION
                  ================================================== -->

                  <div class="card shadow-sm border-0">

                     <div class="card-body p-6">

                        <span class="text-uppercase text-muted fs-13 fw-bold">
                           Informasi
                        </span>

                        <h4 class="mt-2 mb-5">
                           Yang Perlu Diperhatikan
                        </h4>


                        <div class="pmb-info-item">

                           <div class="pmb-info-icon bg-soft-primary text-primary">

                              <i class="uil uil-file-check-alt"></i>

                           </div>

                           <div>

                              <h6 class="mb-1">
                                 Dokumen
                              </h6>

                              <p class="text-muted fs-13 mb-0">

                                 Pastikan dokumen yang diupload
                                 dapat dibaca dengan jelas.

                              </p>

                           </div>

                        </div>


                        <div class="pmb-info-item">

                           <div class="pmb-info-icon bg-soft-green text-green">

                              <i class="uil uil-check-circle"></i>

                           </div>

                           <div>

                              <h6 class="mb-1">
                                 Data Benar
                              </h6>

                              <p class="text-muted fs-13 mb-0">

                                 Periksa kembali seluruh data
                                 sebelum dikirim.

                              </p>

                           </div>

                        </div>


                        <div class="pmb-info-item">

                           <div class="pmb-info-icon bg-soft-yellow text-yellow">

                              <i class="uil uil-clock"></i>

                           </div>

                           <div>

                              <h6 class="mb-1">
                                 Verifikasi
                              </h6>

                              <p class="text-muted fs-13 mb-0">

                                 Proses daftar ulang akan diverifikasi
                                 oleh panitia.

                              </p>

                           </div>

                        </div>


                     </div>

                  </div>


               </div>

            </div>


            <!-- =================================================
                 FINAL STATUS
            ================================================== -->

            <div class="row mt-8">

               <div class="col-lg-10 mx-auto">

                  <div class="card bg-soft-primary border-0">

                     <div class="card-body p-5">

                        <div class="row align-items-center">


                           <div class="col-lg">

                              <div class="d-flex align-items-center">

                                 <div class="icon btn btn-circle btn-lg btn-primary me-4">

                                    <i class="uil uil-graduation-cap"></i>

                                 </div>

                                 <div>

                                    <span class="text-uppercase text-muted fs-13 fw-bold">
                                       Setelah Daftar Ulang
                                    </span>

                                    <h4 class="mb-1">
                                       Menjadi Mahasiswa Resmi
                                    </h4>

                                    <p class="mb-0 text-muted">

                                       Setelah daftar ulang diverifikasi,
                                       status penerimaan akan berubah menjadi
                                       mahasiswa baru terdaftar.

                                    </p>

                                 </div>

                              </div>

                           </div>


                           <div class="col-lg-auto mt-4 mt-lg-0">

                              <span class="badge bg-soft-primary text-primary rounded-pill px-4 py-2">

                                 SELESAI

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