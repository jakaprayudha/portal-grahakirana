<!DOCTYPE html>
<html lang="en">

<head>
   <base href="../">

   <?php
   $page = 'Data & Dokumen PMB';
   require '../head.php';
   ?>

   <style>
      /* =========================================================
         PMB - TAHAP 02
         DATA & DOKUMEN
      ========================================================= */

      .pmb-data-section {
         padding-top: 60px;
         padding-bottom: 80px;
      }

      /* Header */
      .pmb-page-header {
         margin-bottom: 40px;
      }

      .pmb-page-header h2 {
         font-size: 2.5rem;
      }

      /* Progress */
      .pmb-progress-card {
         border: 0;
      }

      .pmb-progress {
         height: 8px;
         border-radius: 10px;
         overflow: hidden;
      }

      /* Sidebar */
      .pmb-sidebar-card {
         position: sticky;
         top: 100px;
      }

      .pmb-profile-box {
         background: rgba(255, 255, 255, .1);
         border-radius: 10px;
         padding: 15px;
      }

      .pmb-avatar {
         width: 60px;
         height: 60px;
         border-radius: 50%;
         object-fit: cover;
         background: #fff;
      }

      /* Menu */
      .pmb-step-menu .nav-link {
         border-radius: 8px;
         padding: 12px 15px;
         color: #555;
         margin-bottom: 5px;
      }

      .pmb-step-menu .nav-link.active {
         background: #3f78e0;
         color: #fff;
      }

      .pmb-step-menu .nav-link i {
         width: 24px;
         margin-right: 8px;
      }

      /* Form */
      .pmb-form-card {
         border: 0;
      }

      .pmb-form-card .card-body {
         padding: 35px;
      }

      .pmb-section-title {
         display: flex;
         align-items: center;
         margin-bottom: 25px;
      }

      .pmb-section-title .icon {
         margin-right: 15px;
      }

      /* Required */
      .required {
         color: #e64949;
      }

      /* Document */
      .pmb-document-card {
         border: 1px solid rgba(0, 0, 0, .08);
         transition: all .2s ease;
      }

      .pmb-document-card:hover {
         transform: translateY(-2px);
         box-shadow: 0 8px 25px rgba(0, 0, 0, .06);
      }

      .pmb-document-icon {
         width: 48px;
         height: 48px;
         display: flex;
         align-items: center;
         justify-content: center;
         border-radius: 10px;
      }

      .pmb-upload {
         border: 1px dashed #d5d9df;
         border-radius: 8px;
         padding: 15px;
         background: #fafafa;
      }

      .pmb-upload input[type="file"] {
         font-size: 14px;
      }

      /* Status */
      .pmb-status {
         font-size: 12px;
         font-weight: 600;
         padding: 5px 10px;
         border-radius: 30px;
      }

      .pmb-status-required {
         background: #fff0f0;
         color: #d63939;
      }

      .pmb-status-complete {
         background: #e9f8ef;
         color: #2b9a59;
      }

      /* Financing */
      .pmb-financing-option {
         position: relative;
      }

      .pmb-financing-option input {
         position: absolute;
         opacity: 0;
      }

      .pmb-financing-label {
         display: block;
         cursor: pointer;
         border: 1px solid #e0e0e0;
         border-radius: 10px;
         padding: 20px;
         transition: all .2s ease;
      }

      .pmb-financing-option input:checked+.pmb-financing-label {
         border-color: #3f78e0;
         background: #f2f6ff;
         box-shadow: 0 0 0 2px rgba(63, 120, 224, .08);
      }

      /* Mobile */
      @media (max-width: 991.98px) {

         .pmb-sidebar-card {
            position: static;
         }

         .pmb-page-header h2 {
            font-size: 2.2rem;
         }

      }

      @media (max-width: 767.98px) {

         .pmb-data-section {
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

         .pmb-form-card .card-body {
            padding: 20px;
         }

         .pmb-section-title h3 {
            font-size: 1.25rem;
         }

         .pmb-document-card .card-body {
            padding: 18px;
         }

      }

      @media (max-width: 575.98px) {

         .pmb-page-header h2 {
            font-size: 1.6rem;
         }

         .pmb-form-card .card-body {
            padding: 16px;
         }

         .pmb-financing-label {
            padding: 15px;
         }

         .pmb-document-card .row {
            display: block;
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
           SECTION : TAHAP 02
      ====================================================== -->

      <section class="wrapper bg-light pmb-data-section">

         <div class="container">


            <!-- =================================================
                 PAGE HEADER
            ================================================== -->

            <div class="row pmb-page-header">

               <div class="col-lg-9">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
                     TAHAP 02
                  </span>

                  <h2 class="display-4 mb-3">
                     Data & Dokumen Pendaftaran
                  </h2>

                  <p class="lead fs-18 mb-0">
                     Lengkapi biodata diri dan unggah dokumen persyaratan
                     untuk melanjutkan ke tahap berikutnya.
                  </p>

               </div>

            </div>


            <!-- =================================================
                 PROGRESS
            ================================================== -->

            <div class="card shadow-sm mb-7 pmb-progress-card">

               <div class="card-body p-5">

                  <div class="row align-items-center">

                     <div class="col-lg-8">

                        <div class="d-flex justify-content-between mb-2">

                           <strong>
                              Kelengkapan Pendaftaran
                           </strong>

                           <span class="text-primary fw-bold">
                              25%
                           </span>

                        </div>

                        <div class="progress pmb-progress">

                           <div
                              class="progress-bar bg-primary"
                              role="progressbar"
                              style="width:25%;"
                              aria-valuenow="25"
                              aria-valuemin="0"
                              aria-valuemax="100">
                           </div>

                        </div>

                     </div>


                     <div class="col-lg-4 mt-4 mt-lg-0 text-lg-end">

                        <span class="badge bg-soft-yellow text-yellow rounded-pill">
                           Data belum lengkap
                        </span>

                     </div>

                  </div>

               </div>

            </div>


            <!-- =================================================
                 MAIN
            ================================================== -->

            <div class="row gx-lg-8 gy-6">


               <!-- =================================================
                    SIDEBAR
               ================================================== -->

               <div class="col-lg-3">

                  <div class="card shadow-sm pmb-sidebar-card">

                     <div class="card-body p-5">


                        <!-- Profile -->

                        <div class="text-center mb-5">

                           <div class="pmb-profile-box bg-soft-primary">

                              <div
                                 class="avatar bg-white rounded-circle mb-3"
                                 style="width:70px;height:70px;margin:auto;">

                                 <i class="uil uil-user fs-40 text-primary"
                                    style="line-height:70px;">
                                 </i>

                              </div>

                              <h5 class="mb-1">
                                 Calon Mahasiswa
                              </h5>

                              <p class="text-muted fs-13 mb-1">
                                 ID Pendaftaran
                              </p>

                              <strong class="text-primary">
                                 99-26-69-74-01-001
                              </strong>

                           </div>

                        </div>


                        <!-- Menu -->

                        <ul class="nav flex-column pmb-step-menu">

                           <li class="nav-item">

                              <a class="nav-link active" href="#biodata">

                                 <i class="uil uil-user">
                                 </i>

                                 Biodata Diri

                              </a>

                           </li>


                           <li class="nav-item">

                              <a class="nav-link" href="#pembiayaan">

                                 <i class="uil uil-wallet">
                                 </i>

                                 Pembiayaan

                              </a>

                           </li>


                           <li class="nav-item">

                              <a class="nav-link" href="#dokumen">

                                 <i class="uil uil-file-check-alt">
                                 </i>

                                 Dokumen

                              </a>

                           </li>


                           <li class="nav-item">

                              <a class="nav-link disabled">

                                 <i class="uil uil-ticket">
                                 </i>

                                 Kartu PMB

                                 <span class="badge bg-soft-gray text-muted ms-auto">
                                    Tahap 03
                                 </span>

                              </a>

                           </li>

                        </ul>


                     </div>

                  </div>

               </div>


               <!-- =================================================
                    CONTENT
               ================================================== -->

               <div class="col-lg-9">


                  <!-- =================================================
                       BIODATA
                  ================================================== -->

                  <div
                     class="card shadow-sm pmb-form-card mb-6"
                     id="biodata">

                     <div class="card-body">


                        <div class="pmb-section-title">

                           <div class="icon btn btn-circle btn-lg btn-soft-primary">

                              <i class="uil uil-user"></i>

                           </div>

                           <div>

                              <span class="text-uppercase text-muted fs-13 fw-bold">
                                 Bagian 01
                              </span>

                              <h3 class="mb-0">
                                 Biodata Diri
                              </h3>

                           </div>

                        </div>


                        <div class="alert alert-primary alert-icon mb-6">

                           <i class="uil uil-info-circle"></i>

                           <p class="mb-0">
                              Isi data sesuai dengan identitas resmi.
                              Pastikan nama dan NIK sesuai KTP.
                           </p>

                        </div>


                        <div class="row gx-4">


                           <!-- Nama -->

                           <div class="col-md-6">

                              <div class="form-floating mb-4">

                                 <input
                                    type="text"
                                    class="form-control"
                                    id="nama"
                                    name="nama"
                                    value=""
                                    placeholder="Nama Lengkap"
                                    required>

                                 <label for="nama">
                                    Nama Lengkap <span class="required">*</span>
                                 </label>

                              </div>

                           </div>


                           <!-- NIK -->

                           <div class="col-md-6">

                              <div class="form-floating mb-4">

                                 <input
                                    type="text"
                                    class="form-control"
                                    id="nik"
                                    name="nik"
                                    maxlength="16"
                                    placeholder="NIK"
                                    required>

                                 <label for="nik">
                                    NIK <span class="required">*</span>
                                 </label>

                              </div>

                           </div>


                           <!-- Gender -->

                           <div class="col-md-6">

                              <div class="form-select-wrapper mb-4">

                                 <select
                                    class="form-select"
                                    name="jenis_kelamin"
                                    id="jenis_kelamin"
                                    required>

                                    <option value="">
                                       -- Pilih Jenis Kelamin --
                                    </option>

                                    <option value="L">
                                       Laki-laki
                                    </option>

                                    <option value="P">
                                       Perempuan
                                    </option>

                                 </select>

                              </div>

                           </div>


                           <!-- Agama -->

                           <div class="col-md-6">

                              <div class="form-select-wrapper mb-4">

                                 <select
                                    class="form-select"
                                    name="agama"
                                    id="agama"
                                    required>

                                    <option value="">
                                       -- Pilih Agama --
                                    </option>

                                    <option value="Islam">
                                       Islam
                                    </option>

                                    <option value="Kristen">
                                       Kristen
                                    </option>

                                    <option value="Katolik">
                                       Katolik
                                    </option>

                                    <option value="Hindu">
                                       Hindu
                                    </option>

                                    <option value="Buddha">
                                       Buddha
                                    </option>

                                    <option value="Konghucu">
                                       Konghucu
                                    </option>

                                 </select>

                              </div>

                           </div>


                           <!-- Tempat Lahir -->

                           <div class="col-md-6">

                              <div class="form-floating mb-4">

                                 <input
                                    type="text"
                                    class="form-control"
                                    id="tempat_lahir"
                                    name="tempat_lahir"
                                    placeholder="Tempat Lahir"
                                    required>

                                 <label for="tempat_lahir">
                                    Tempat Lahir <span class="required">*</span>
                                 </label>

                              </div>

                           </div>


                           <!-- Tanggal Lahir -->

                           <div class="col-md-6">

                              <div class="form-floating mb-4">

                                 <input
                                    type="date"
                                    class="form-control"
                                    id="tanggal_lahir"
                                    name="tanggal_lahir"
                                    required>

                                 <label for="tanggal_lahir">
                                    Tanggal Lahir <span class="required">*</span>
                                 </label>

                              </div>

                           </div>


                           <!-- Nama Ibu -->

                           <div class="col-md-6">

                              <div class="form-floating mb-4">

                                 <input
                                    type="text"
                                    class="form-control"
                                    id="nama_ibu"
                                    name="nama_ibu"
                                    placeholder="Nama Ibu Kandung"
                                    required>

                                 <label for="nama_ibu">
                                    Nama Ibu Kandung <span class="required">*</span>
                                 </label>

                              </div>

                           </div>


                           <!-- Tahun Lulus -->

                           <div class="col-md-6">

                              <div class="form-floating mb-4">

                                 <input
                                    type="number"
                                    class="form-control"
                                    id="tahun_lulus"
                                    name="tahun_lulus"
                                    min="1900"
                                    max="2100"
                                    placeholder="Tahun Lulus"
                                    required>

                                 <label for="tahun_lulus">
                                    Tahun Lulus SMA/Sederajat <span class="required">*</span>
                                 </label>

                              </div>

                           </div>


                           <!-- Nomor HP -->

                           <div class="col-md-6">

                              <div class="form-floating mb-4">

                                 <input
                                    type="tel"
                                    class="form-control"
                                    id="no_hp"
                                    name="no_hp"
                                    placeholder="Nomor HP"
                                    required>

                                 <label for="no_hp">
                                    Nomor HP Aktif <span class="required">*</span>
                                 </label>

                              </div>

                           </div>


                           <!-- Email -->

                           <div class="col-md-6">

                              <div class="form-floating mb-4">

                                 <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Email"
                                    required>

                                 <label for="email">
                                    Email Aktif <span class="required">*</span>
                                 </label>

                              </div>

                           </div>


                           <!-- Ukuran Baju -->

                           <div class="col-md-6">

                              <div class="form-select-wrapper mb-4">

                                 <select
                                    class="form-select"
                                    name="ukuran_baju"
                                    id="ukuran_baju"
                                    required>

                                    <option value="">
                                       -- Pilih Ukuran Baju --
                                    </option>

                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                    <option value="XXL">XXL</option>

                                 </select>

                              </div>

                           </div>


                        </div>


                        <!-- =================================================
                             ALAMAT
                        ================================================== -->

                        <hr class="my-6">


                        <h4 class="mb-5">
                           Alamat Domisili
                        </h4>


                        <div class="row gx-4">


                           <!-- Jalan -->

                           <div class="col-12">

                              <div class="form-floating mb-4">

                                 <textarea
                                    class="form-control"
                                    id="alamat"
                                    name="alamat"
                                    placeholder="Alamat"
                                    style="height:100px"
                                    required></textarea>

                                 <label for="alamat">
                                    Jalan / Gang, Nomor Rumah
                                    <span class="required">*</span>
                                 </label>

                              </div>

                           </div>


                           <!-- Kelurahan -->

                           <div class="col-md-6">

                              <div class="form-floating mb-4">

                                 <input
                                    type="text"
                                    class="form-control"
                                    id="kelurahan"
                                    name="kelurahan"
                                    placeholder="Kelurahan"
                                    required>

                                 <label for="kelurahan">
                                    Kelurahan <span class="required">*</span>
                                 </label>

                              </div>

                           </div>


                           <!-- Kecamatan -->

                           <div class="col-md-6">

                              <div class="form-floating mb-4">

                                 <input
                                    type="text"
                                    class="form-control"
                                    id="kecamatan"
                                    name="kecamatan"
                                    placeholder="Kecamatan"
                                    required>

                                 <label for="kecamatan">
                                    Kecamatan <span class="required">*</span>
                                 </label>

                              </div>

                           </div>


                           <!-- Kabupaten -->

                           <div class="col-md-6">

                              <div class="form-floating mb-4">

                                 <input
                                    type="text"
                                    class="form-control"
                                    id="kabupaten"
                                    name="kabupaten"
                                    placeholder="Kabupaten/Kota"
                                    required>

                                 <label for="kabupaten">
                                    Kabupaten / Kota <span class="required">*</span>
                                 </label>

                              </div>

                           </div>


                           <!-- Provinsi -->

                           <div class="col-md-6">

                              <div class="form-floating mb-4">

                                 <input
                                    type="text"
                                    class="form-control"
                                    id="provinsi"
                                    name="provinsi"
                                    placeholder="Provinsi"
                                    required>

                                 <label for="provinsi">
                                    Provinsi <span class="required">*</span>
                                 </label>

                              </div>

                           </div>

                        </div>


                        <!-- Save -->

                        <div class="text-end mt-3">

                           <button
                              type="button"
                              class="btn btn-primary rounded btn-icon btn-icon-end">

                              Simpan Biodata

                              <i class="uil uil-check"></i>

                           </button>

                        </div>

                     </div>

                  </div>


                  <!-- =================================================
                       PEMBIAYAAN
                  ================================================== -->

                  <div
                     class="card shadow-sm pmb-form-card mb-6"
                     id="pembiayaan">

                     <div class="card-body">


                        <div class="pmb-section-title">

                           <div class="icon btn btn-circle btn-lg btn-soft-green">

                              <i class="uil uil-wallet"></i>

                           </div>

                           <div>

                              <span class="text-uppercase text-muted fs-13 fw-bold">
                                 Bagian 02
                              </span>

                              <h3 class="mb-0">
                                 Jenis Pembiayaan
                              </h3>

                           </div>

                        </div>


                        <p class="text-muted mb-5">
                           Pilih jenis pembiayaan yang akan digunakan selama
                           proses pendidikan.
                        </p>


                        <div class="row gx-4">


                           <!-- Mandiri -->

                           <div class="col-md-6 mb-4 mb-md-0">

                              <div class="pmb-financing-option">

                                 <input
                                    type="radio"
                                    name="jenis_pembiayaan"
                                    id="mandiri"
                                    value="mandiri"
                                    checked>

                                 <label
                                    class="pmb-financing-label"
                                    for="mandiri">

                                    <div class="d-flex">

                                       <div class="icon btn btn-circle btn-sm btn-soft-primary me-3">

                                          <i class="uil uil-wallet"></i>

                                       </div>

                                       <div>

                                          <h4 class="mb-1">
                                             Mandiri
                                          </h4>

                                          <p class="text-muted mb-0 fs-14">
                                             Pembiayaan secara mandiri sesuai
                                             ketentuan biaya pendidikan.
                                          </p>

                                       </div>

                                    </div>

                                 </label>

                              </div>

                           </div>


                           <!-- Beasiswa -->

                           <div class="col-md-6">

                              <div class="pmb-financing-option">

                                 <input
                                    type="radio"
                                    name="jenis_pembiayaan"
                                    id="beasiswa"
                                    value="beasiswa">

                                 <label
                                    class="pmb-financing-label"
                                    for="beasiswa">

                                    <div class="d-flex">

                                       <div class="icon btn btn-circle btn-sm btn-soft-green me-3">

                                          <i class="uil uil-award"></i>

                                       </div>

                                       <div>

                                          <h4 class="mb-1">
                                             Beasiswa
                                          </h4>

                                          <p class="text-muted mb-0 fs-14">
                                             Mengajukan pembiayaan melalui
                                             program beasiswa.
                                          </p>

                                       </div>

                                    </div>

                                 </label>

                              </div>

                           </div>

                        </div>

                     </div>

                  </div>


                  <!-- =================================================
                       DOKUMEN UMUM
                  ================================================== -->

                  <div
                     class="card shadow-sm pmb-form-card mb-6"
                     id="dokumen">

                     <div class="card-body">


                        <div class="pmb-section-title">

                           <div class="icon btn btn-circle btn-lg btn-soft-yellow">

                              <i class="uil uil-file-check-alt"></i>

                           </div>

                           <div>

                              <span class="text-uppercase text-muted fs-13 fw-bold">
                                 Bagian 03
                              </span>

                              <h3 class="mb-0">
                                 Dokumen Prasyarat
                              </h3>

                           </div>

                        </div>


                        <div class="alert alert-warning alert-icon mb-6">

                           <i class="uil uil-exclamation-triangle"></i>

                           <p class="mb-0">
                              Dokumen yang bertanda <strong>Wajib</strong>
                              harus diunggah sebelum dapat melanjutkan ke
                              tahap berikutnya.
                           </p>

                        </div>


                        <div class="row gx-4 gy-4">


                           <!-- =================================================
                                KTP
                           ================================================== -->

                           <div class="col-md-6">

                              <div class="card pmb-document-card h-100">

                                 <div class="card-body">

                                    <div class="d-flex align-items-start mb-4">

                                       <div class="pmb-document-icon bg-soft-primary text-primary me-3">

                                          <i class="uil uil-card-atm fs-24"></i>

                                       </div>

                                       <div>

                                          <h5 class="mb-1">
                                             KTP
                                          </h5>

                                          <span class="pmb-status pmb-status-required">
                                             Wajib
                                          </span>

                                       </div>

                                    </div>


                                    <p class="text-muted fs-14 mb-4">
                                       Kartu Tanda Penduduk dalam format PDF.
                                    </p>


                                    <div class="pmb-upload">

                                       <input
                                          type="file"
                                          name="ktp"
                                          class="form-control"
                                          accept=".pdf"
                                          required>

                                       <small class="text-muted">
                                          Format PDF
                                       </small>

                                    </div>

                                 </div>

                              </div>

                           </div>


                           <!-- =================================================
                                KK
                           ================================================== -->

                           <div class="col-md-6">

                              <div class="card pmb-document-card h-100">

                                 <div class="card-body">

                                    <div class="d-flex align-items-start mb-4">

                                       <div class="pmb-document-icon bg-soft-info text-info me-3">

                                          <i class="uil uil-family fs-24"></i>

                                       </div>

                                       <div>

                                          <h5 class="mb-1">
                                             Kartu Keluarga
                                          </h5>

                                          <span class="pmb-status pmb-status-required">
                                             Wajib
                                          </span>

                                       </div>

                                    </div>


                                    <p class="text-muted fs-14 mb-4">
                                       Kartu Keluarga dalam format PDF.
                                    </p>


                                    <div class="pmb-upload">

                                       <input
                                          type="file"
                                          name="kk"
                                          class="form-control"
                                          accept=".pdf"
                                          required>

                                       <small class="text-muted">
                                          Format PDF
                                       </small>

                                    </div>

                                 </div>

                              </div>

                           </div>


                           <!-- =================================================
                                IJAZAH
                           ================================================== -->

                           <div class="col-md-6">

                              <div class="card pmb-document-card h-100">

                                 <div class="card-body">

                                    <div class="d-flex align-items-start mb-4">

                                       <div class="pmb-document-icon bg-soft-green text-green me-3">

                                          <i class="uil uil-graduation-cap fs-24"></i>

                                       </div>

                                       <div>

                                          <h5 class="mb-1">
                                             Ijazah / SKTL
                                          </h5>

                                          <span class="pmb-status pmb-status-required">
                                             Wajib
                                          </span>

                                       </div>

                                    </div>


                                    <p class="text-muted fs-14 mb-4">
                                       Ijazah SMA atau Surat Keterangan
                                       Tanda Lulus.
                                    </p>


                                    <div class="pmb-upload">

                                       <input
                                          type="file"
                                          name="ijazah"
                                          class="form-control"
                                          accept=".pdf"
                                          required>

                                       <small class="text-muted">
                                          Format PDF
                                       </small>

                                    </div>

                                 </div>

                              </div>

                           </div>


                           <!-- =================================================
                                PAS FOTO
                           ================================================== -->

                           <div class="col-md-6">

                              <div class="card pmb-document-card h-100">

                                 <div class="card-body">

                                    <div class="d-flex align-items-start mb-4">

                                       <div class="pmb-document-icon bg-soft-red text-red me-3">

                                          <i class="uil uil-camera fs-24"></i>

                                       </div>

                                       <div>

                                          <h5 class="mb-1">
                                             Pasfoto
                                          </h5>

                                          <span class="pmb-status pmb-status-required">
                                             Wajib
                                          </span>

                                       </div>

                                    </div>


                                    <p class="text-muted fs-14 mb-4">
                                       Pasfoto resmi berwarna dengan
                                       latar belakang merah.
                                    </p>


                                    <div class="pmb-upload">

                                       <input
                                          type="file"
                                          name="pasfoto"
                                          class="form-control"
                                          accept="image/jpeg,image/png"
                                          required>

                                       <small class="text-muted">
                                          JPG / PNG
                                       </small>

                                    </div>

                                 </div>

                              </div>

                           </div>

                        </div>


                        <!-- =================================================
                             BEASISWA DOCUMENT
                        ================================================== -->

                        <div
                           id="dokumenBeasiswa"
                           class="mt-8"
                           style="display:none;">


                           <hr class="mb-7">


                           <div class="d-flex align-items-center mb-5">

                              <div class="icon btn btn-circle btn-lg btn-soft-green me-3">

                                 <i class="uil uil-award"></i>

                              </div>

                              <div>

                                 <span class="text-uppercase text-muted fs-13 fw-bold">
                                    Dokumen Tambahan
                                 </span>

                                 <h4 class="mb-0">
                                    Persyaratan Beasiswa
                                 </h4>

                              </div>

                           </div>


                           <div class="alert alert-success alert-icon">

                              <i class="uil uil-info-circle"></i>

                              <p class="mb-0">
                                 Dokumen tambahan ditampilkan berdasarkan
                                 jalur pendaftaran dan jenis pembiayaan.
                              </p>

                           </div>


                           <!-- Surat Permohonan -->

                           <div class="card pmb-document-card mb-4">

                              <div class="card-body">

                                 <div class="row align-items-center">

                                    <div class="col-lg-6">

                                       <h5 class="mb-1">
                                          Surat Permohonan Beasiswa
                                       </h5>

                                       <p class="text-muted fs-14 mb-lg-0">
                                          Dokumen permohonan beasiswa.
                                       </p>

                                    </div>

                                    <div class="col-lg-6">

                                       <input
                                          type="file"
                                          name="surat_beasiswa"
                                          class="form-control"
                                          accept=".pdf">

                                    </div>

                                 </div>

                              </div>

                           </div>


                           <!-- SKTM -->

                           <div
                              class="card pmb-document-card mb-4"
                              id="dokumenSktm">

                              <div class="card-body">

                                 <div class="row align-items-center">

                                    <div class="col-lg-6">

                                       <h5 class="mb-1">
                                          Surat Keterangan Tidak Mampu
                                       </h5>

                                       <p class="text-muted fs-14 mb-lg-0">
                                          SKTM untuk pengajuan beasiswa reguler.
                                       </p>

                                    </div>

                                    <div class="col-lg-6">

                                       <input
                                          type="file"
                                          name="sktm"
                                          class="form-control"
                                          accept=".pdf">

                                    </div>

                                 </div>

                              </div>

                           </div>


                           <!-- KIP -->

                           <div
                              class="card pmb-document-card mb-4"
                              id="dokumenKip">

                              <div class="card-body">

                                 <div class="row align-items-center">

                                    <div class="col-lg-6">

                                       <h5 class="mb-1">
                                          Nomor Pendaftaran KIP
                                       </h5>

                                       <p class="text-muted fs-14 mb-lg-0">
                                          Nomor pendaftaran KIP.
                                       </p>

                                    </div>

                                    <div class="col-lg-6">

                                       <input
                                          type="text"
                                          name="nomor_kip"
                                          class="form-control"
                                          placeholder="Nomor Pendaftaran KIP">

                                    </div>

                                 </div>

                              </div>

                           </div>


                           <!-- Prestasi -->

                           <div
                              class="card pmb-document-card"
                              id="dokumenPrestasi">

                              <div class="card-body">

                                 <div class="row align-items-center">

                                    <div class="col-lg-6">

                                       <h5 class="mb-1">

                                          Bukti Prestasi

                                          <span class="badge bg-soft-gray text-muted ms-1">
                                             Opsional
                                          </span>

                                       </h5>

                                       <p class="text-muted fs-14 mb-lg-0">
                                          Bukti prestasi akademik/non-akademik.
                                       </p>

                                    </div>

                                    <div class="col-lg-6">

                                       <input
                                          type="file"
                                          name="bukti_prestasi"
                                          class="form-control"
                                          accept=".pdf,image/jpeg,image/png">

                                    </div>

                                 </div>

                              </div>

                           </div>


                        </div>


                        <!-- =================================================
                             SAVE DOCUMENT
                        ================================================== -->

                        <div class="mt-7 pt-5 border-top">

                           <div class="row align-items-center">

                              <div class="col-lg">

                                 <p class="text-muted fs-14 mb-0">

                                    <i class="uil uil-lock me-1"></i>

                                    Data dan dokumen Anda akan disimpan
                                    secara aman pada sistem PMB.

                                 </p>

                              </div>


                              <div class="col-lg-auto mt-4 mt-lg-0">

                                 <button
                                    type="button"
                                    class="btn btn-primary rounded btn-icon btn-icon-end">

                                    Simpan Data & Dokumen

                                    <i class="uil uil-check"></i>

                                 </button>

                              </div>

                           </div>

                        </div>


                     </div>

                  </div>


                  <!-- =================================================
                       NEXT STEP
                  ================================================== -->

                  <div class="card bg-soft-primary border-0">

                     <div class="card-body p-5">

                        <div class="row align-items-center">

                           <div class="col-lg">

                              <div class="d-flex align-items-center">

                                 <div class="icon btn btn-circle btn-lg btn-primary me-4">

                                    <i class="uil uil-ticket"></i>

                                 </div>

                                 <div>

                                    <span class="text-uppercase text-muted fs-13 fw-bold">
                                       Tahap Berikutnya
                                    </span>

                                    <h4 class="mb-1">
                                       Kartu Peserta PMB
                                    </h4>

                                    <p class="mb-0 text-muted">
                                       Kartu peserta dapat dicetak setelah
                                       seluruh data dan dokumen dinyatakan lengkap.
                                    </p>

                                 </div>

                              </div>

                           </div>

                           <div class="col-lg-auto mt-4 mt-lg-0">

                              <span class="badge bg-soft-primary text-primary rounded-pill px-4 py-2">

                                 Tahap 03

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


   <script>
      /* =========================================================
         PEMBIAYAAN BEASISWA
      ========================================================= */

      const pembiayaan = document.querySelectorAll(
         'input[name="jenis_pembiayaan"]'
      );

      const dokumenBeasiswa =
         document.getElementById('dokumenBeasiswa');

      pembiayaan.forEach(function(input) {

         input.addEventListener('change', function() {

            if (this.value === 'beasiswa') {

               dokumenBeasiswa.style.display = 'block';

            } else {

               dokumenBeasiswa.style.display = 'none';

            }

         });

      });
   </script>

</body>

</html>