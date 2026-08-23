<!DOCTYPE html>
<html lang="en">

<head>
   <base href="../">

   <?php
   $page = 'Home PMB';
   require '../head.php';
   ?>

   <style>
      /* =========================================================
         PMB - TAHAP 1
         RESPONSIVE CSS
      ========================================================= */

      /* ---------------------------------------------------------
         Tablet
      --------------------------------------------------------- */
      @media (max-width: 991.98px) {

         .pmb-section {
            padding-top: 60px !important;
            padding-bottom: 60px !important;
         }

         .pmb-heading h2 {
            font-size: 2.3rem;
         }

         .pmb-info-card .card-body {
            padding: 2rem !important;
         }

         .pmb-form-card .card-body {
            padding: 2rem !important;
         }

      }

      /* ==================================================
   JALUR PENDAFTARAN
   ================================================== */

      .pmb-path-row {
         margin-left: -5px;
         margin-right: -5px;
      }

      .pmb-path-col {
         padding-left: 5px;
         padding-right: 5px;
      }


      /* ==================================================
   CARD
   ================================================== */

      .pmb-path-card {
         width: 100%;
         height: 100%;
         cursor: pointer;
         transition: all 0.2s ease;
      }

      .pmb-path-card .card-body {
         padding: 1rem 0.5rem !important;
         text-align: center;
      }

      .pmb-path-card .icon {
         margin-bottom: 0.7rem !important;
      }

      .pmb-path-card h5 {
         font-size: 14px;
         margin-bottom: 3px !important;
      }

      .pmb-path-card p {
         font-size: 11px !important;
         margin-bottom: 0 !important;
      }


      /* ==================================================
   RADIO BUTTON
   ================================================== */

      /* Tetap terlihat */
      .pmb-path-col .form-check-input {
         position: absolute;
         top: 10px;
         right: 10px;
         z-index: 20;

         width: 18px;
         height: 18px;

         margin: 0;
         cursor: pointer;
      }


      /* ==================================================
   HOVER
   ================================================== */

      .pmb-path-card:hover {
         transform: translateY(-2px);
         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      }


      /* ==================================================
   REGULER SELECTED
   ================================================== */

      #jalur_reguler:checked+.form-check-label .pmb-path-card {
         border: 2px solid var(--bs-primary) !important;
         background-color: rgba(var(--bs-primary-rgb), 0.06);

         box-shadow:
            0 0 0 3px rgba(var(--bs-primary-rgb), 0.12),
            0 6px 18px rgba(0, 0, 0, 0.08);
      }


      /* ==================================================
   EKSEKUTIF SELECTED
   ================================================== */

      #jalur_eksekutif:checked+.form-check-label .pmb-path-card {
         border: 2px solid var(--bs-info) !important;
         background-color: rgba(var(--bs-info-rgb), 0.06);

         box-shadow:
            0 0 0 3px rgba(var(--bs-info-rgb), 0.12),
            0 6px 18px rgba(0, 0, 0, 0.08);
      }


      /* ==================================================
   PINDAHAN SELECTED
   ================================================== */

      #jalur_pindahan:checked+.form-check-label .pmb-path-card {
         border: 2px solid #2fb344 !important;
         background-color: rgba(47, 179, 68, 0.06);

         box-shadow:
            0 0 0 3px rgba(47, 179, 68, 0.12),
            0 6px 18px rgba(0, 0, 0, 0.08);
      }


      /* ---------------------------------------------------------
         Mobile
      --------------------------------------------------------- */
      @media (max-width: 767.98px) {

         .pmb-section {
            padding-top: 40px !important;
            padding-bottom: 40px !important;
         }


         /* Heading */
         .pmb-heading {
            margin-bottom: 2.5rem !important;
         }

         .pmb-heading h2 {
            font-size: 1.8rem;
            line-height: 1.25;
            margin-bottom: 1rem !important;
         }

         .pmb-heading p {
            font-size: 15px !important;
            line-height: 1.6;
         }


         /* Information Card */
         .pmb-info-card {
            margin-bottom: 1rem;
         }

         .pmb-info-card .card-body {
            padding: 1.5rem !important;
         }

         .pmb-info-card h3 {
            font-size: 1.5rem;
         }

         .pmb-info-card p {
            font-size: 14px;
            line-height: 1.6;
         }


         /* Form Card */
         .pmb-form-card .card-body {
            padding: 1.5rem !important;
         }

         .pmb-form-title {
            font-size: 1.35rem;
         }




         /* Input */
         .pmb-form-card .form-control {
            min-height: 52px;
            font-size: 15px;
         }


         /* Checkbox */
         .pmb-agree {
            font-size: 13px;
            line-height: 1.5;
         }


         /* Submit */
         .pmb-submit {
            min-height: 52px;
            font-size: 14px;
         }


         /* Login */
         .pmb-login {
            margin-top: 1.5rem !important;
         }

         .pmb-login .btn {
            width: 100%;
         }


         /* Alert */
         .pmb-alert {
            font-size: 13px;
            line-height: 1.5;
         }

      }


      /* ---------------------------------------------------------
         Extra Small Mobile
      --------------------------------------------------------- */
      @media (max-width: 575.98px) {

         .pmb-heading h2 {
            font-size: 1.65rem;
         }

         .pmb-heading p {
            font-size: 14px !important;
         }


         .pmb-info-card .card-body,
         .pmb-form-card .card-body {
            padding: 1.25rem !important;
         }


         /*
            Jalur tetap 3 kolom.
            Dibuat compact agar tidak terlalu tinggi.
         */
         .pmb-path-card .card-body {
            padding: 0.8rem 0.25rem !important;
         }

         .pmb-path-card .icon {
            width: 38px !important;
            height: 38px !important;
         }

         .pmb-path-card .icon i {
            font-size: 16px;
         }

         .pmb-path-card h5 {
            font-size: 12px;
         }

         .pmb-path-card p {
            display: none;
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
           SECTION : TAHAP 1 - REGISTRASI AKUN PMB
      ====================================================== -->

      <section class="wrapper bg-light pmb-section">

         <div class="container py-10 py-md-14">


            <!-- =================================================
                 HEADING
            ================================================== -->

            <div class="row mb-10 pmb-heading">

               <div class="col-12 col-lg-9 col-xl-8 mx-auto text-center">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
                     TAHAP 01
                  </span>

                  <h2 class="display-4 mb-4">
                     Buat Akun Pendaftaran
                  </h2>

                  <p class="lead fs-18 mb-0">
                     Silakan buat akun PMB untuk memulai proses pendaftaran
                     sebagai calon mahasiswa STIH Graha Kirana.
                  </p>

               </div>

            </div>


            <!-- =================================================
                 MAIN CONTENT
            ================================================== -->

            <div class="row gx-lg-8 gy-8 align-items-start">


               <!-- =================================================
                    LEFT : INFORMATION
               ================================================== -->

               <div class="col-12 col-lg-5">

                  <div class="card bg-primary text-white border-0 shadow-lg pmb-info-card">

                     <div class="card-body p-8">


                        <!-- Icon -->

                        <div class="icon btn btn-circle btn-lg btn-white text-primary mb-5">

                           <img
                              src="./assets/img/icons/lineal/user.svg"
                              class="svg-inject icon-svg"
                              alt="Registrasi Akun">

                        </div>


                        <!-- Title -->

                        <h3 class="text-white mb-4">
                           Mulai Perjalanan Anda
                        </h3>


                        <p class="text-white opacity-75 mb-6">

                           Buat akun pendaftaran terlebih dahulu untuk mendapatkan
                           ID Pendaftaran dan mengakses seluruh proses PMB.

                        </p>


                        <!-- =================================================
                             PROCESS 01
                        ================================================== -->

                        <div class="d-flex mb-5">

                           <div class="icon btn btn-circle btn-sm btn-white text-primary me-3 flex-shrink-0">

                              <span class="fw-bold">
                                 1
                              </span>

                           </div>


                           <div>

                              <h5 class="text-white mb-1">
                                 Buat Akun
                              </h5>

                              <p class="text-white opacity-75 mb-0">
                                 Isi data akun dengan benar dan aktif.
                              </p>

                           </div>

                        </div>


                        <!-- =================================================
                             PROCESS 02
                        ================================================== -->

                        <div class="d-flex mb-5">

                           <div class="icon btn btn-circle btn-sm btn-white text-primary me-3 flex-shrink-0">

                              <span class="fw-bold">
                                 2
                              </span>

                           </div>


                           <div>

                              <h5 class="text-white mb-1">
                                 Dapatkan ID Pendaftaran
                              </h5>

                              <p class="text-white opacity-75 mb-0">
                                 Sistem akan membuat ID Pendaftaran secara otomatis.
                              </p>

                           </div>

                        </div>


                        <!-- =================================================
                             PROCESS 03
                        ================================================== -->

                        <div class="d-flex">

                           <div class="icon btn btn-circle btn-sm btn-white text-primary me-3 flex-shrink-0">

                              <span class="fw-bold">
                                 3
                              </span>

                           </div>


                           <div>

                              <h5 class="text-white mb-1">
                                 Login ke Portal PMB
                              </h5>

                              <p class="text-white opacity-75 mb-0">
                                 Gunakan ID Pendaftaran untuk melanjutkan proses PMB.
                              </p>

                           </div>

                        </div>


                     </div>

                  </div>


                  <!-- =================================================
                       IMPORTANT INFORMATION
                  ================================================== -->

                  <div
                     class="alert alert-primary alert-icon mt-5 pmb-alert"
                     role="alert">

                     <i class="uil uil-info-circle"></i>

                     <div>

                        <strong>
                           Perhatian
                        </strong>

                        <p class="mb-0 mt-1">

                           Pastikan email dan nomor HP yang digunakan aktif karena
                           akan digunakan untuk informasi proses PMB.

                        </p>

                     </div>

                  </div>

               </div>


               <!-- =================================================
                    RIGHT : REGISTRATION FORM
               ================================================== -->

               <div class="col-12 col-lg-7">


                  <div class="card shadow-lg border-0 pmb-form-card">


                     <div class="card-body p-6 p-md-8">


                        <!-- =================================================
                             FORM HEADER
                        ================================================== -->

                        <div class="d-flex align-items-center mb-6">

                           <div class="icon btn btn-circle btn-lg btn-soft-primary me-4 flex-shrink-0">

                              <i class="uil uil-user-plus fs-24"></i>

                           </div>


                           <div>

                              <span class="text-uppercase text-muted fs-13 fw-bold">

                                 Formulir Pendaftaran

                              </span>


                              <h3 class="mb-0 pmb-form-title">

                                 Registrasi Akun PMB

                              </h3>

                           </div>

                        </div>


                        <!-- =================================================
                             FORM
                        ================================================== -->

                        <form
                           action="../controllers/register-pmb.php"
                           method="POST"
                           id="formRegistrasiPMB"
                           novalidate>


                           <!-- =================================================
                                NAMA LENGKAP
                           ================================================== -->

                           <div class="form-floating mb-4">

                              <input
                                 type="text"
                                 name="nama_lengkap"
                                 id="nama_lengkap"
                                 class="form-control"
                                 placeholder="Nama Lengkap"
                                 autocomplete="name"
                                 required>

                              <label for="nama_lengkap">

                                 Nama Lengkap Sesuai KTP

                              </label>

                           </div>


                           <!-- =================================================
                                EMAIL
                           ================================================== -->

                           <div class="form-floating mb-4">

                              <input
                                 type="email"
                                 name="email"
                                 id="email"
                                 class="form-control"
                                 placeholder="Email Aktif"
                                 autocomplete="email"
                                 required>

                              <label for="email">

                                 Email Aktif

                              </label>

                           </div>


                           <!-- =================================================
                                NOMOR HP
                           ================================================== -->

                           <div class="form-floating mb-4">

                              <input
                                 type="tel"
                                 name="no_hp"
                                 id="no_hp"
                                 class="form-control"
                                 placeholder="Nomor HP"
                                 autocomplete="tel"
                                 required>

                              <label for="no_hp">

                                 Nomor HP Aktif

                              </label>

                           </div>


                           <!-- =================================================
                                JALUR PENDAFTARAN
                           ================================================== -->

                           <div class="mb-4">


                              <label class="form-label fw-bold">

                                 Pilih Jalur Pendaftaran

                              </label>


                              <div class="row gx-2 gy-3 pmb-path-row">


                                 <!-- =================================================
                                      REGULER
                                 ================================================== -->

                                 <div class="col-4 pmb-path-col">

                                    <div class="form-check custom-control custom-radio p-0">


                                       <input
                                          class="form-check-input"
                                          type="radio"
                                          name="jalur_pendaftaran"
                                          id="jalur_reguler"
                                          value="Reguler"
                                          required>


                                       <label
                                          class="form-check-label w-100"
                                          for="jalur_reguler">


                                          <div class="card card-border-start border-primary h-100 pmb-path-card">


                                             <div class="card-body p-4 text-center">


                                                <div class="icon btn btn-circle btn-sm btn-soft-primary mb-3">

                                                   <i class="uil uil-user"></i>

                                                </div>


                                                <h5 class="mb-1">

                                                   Reguler

                                                </h5>


                                                <p class="fs-14 mb-0 text-muted">

                                                   Jalur reguler

                                                </p>


                                             </div>

                                          </div>

                                       </label>

                                    </div>

                                 </div>


                                 <!-- =================================================
                                      EKSEKUTIF
                                 ================================================== -->

                                 <div class="col-4 pmb-path-col">

                                    <div class="form-check custom-control custom-radio p-0">


                                       <input
                                          class="form-check-input"
                                          type="radio"
                                          name="jalur_pendaftaran"
                                          id="jalur_eksekutif"
                                          value="Eksekutif"
                                          required>


                                       <label
                                          class="form-check-label w-100"
                                          for="jalur_eksekutif">


                                          <div class="card card-border-start border-info h-100 pmb-path-card">


                                             <div class="card-body p-4 text-center">


                                                <div class="icon btn btn-circle btn-sm btn-soft-info mb-3">

                                                   <i class="uil uil-briefcase"></i>

                                                </div>


                                                <h5 class="mb-1">

                                                   Eksekutif

                                                </h5>


                                                <p class="fs-14 mb-0 text-muted">

                                                   Jalur eksekutif

                                                </p>


                                             </div>

                                          </div>

                                       </label>

                                    </div>

                                 </div>


                                 <!-- =================================================
                                      PINDAHAN
                                 ================================================== -->

                                 <div class="col-4 pmb-path-col">

                                    <div class="form-check custom-control custom-radio p-0">


                                       <input
                                          class="form-check-input"
                                          type="radio"
                                          name="jalur_pendaftaran"
                                          id="jalur_pindahan"
                                          value="Pindahan"
                                          required>


                                       <label
                                          class="form-check-label w-100"
                                          for="jalur_pindahan">


                                          <div class="card card-border-start border-green h-100 pmb-path-card">


                                             <div class="card-body p-4 text-center">


                                                <div class="icon btn btn-circle btn-sm btn-soft-green mb-3">

                                                   <i class="uil uil-exchange"></i>

                                                </div>


                                                <h5 class="mb-1">

                                                   Pindahan

                                                </h5>


                                                <p class="fs-14 mb-0 text-muted">

                                                   Jalur pindahan

                                                </p>


                                             </div>

                                          </div>

                                       </label>

                                    </div>

                                 </div>


                              </div>

                           </div>


                           <!-- =================================================
                                PASSWORD
                           ================================================== -->

                           <div class="form-floating mb-4">

                              <input
                                 type="password"
                                 name="password"
                                 id="password"
                                 class="form-control"
                                 placeholder="Password"
                                 autocomplete="new-password"
                                 required>

                              <label for="password">

                                 Password

                              </label>

                           </div>


                           <!-- =================================================
                                CONFIRM PASSWORD
                           ================================================== -->

                           <div class="form-floating mb-5">

                              <input
                                 type="password"
                                 name="password_confirmation"
                                 id="password_confirmation"
                                 class="form-control"
                                 placeholder="Konfirmasi Password"
                                 autocomplete="new-password"
                                 required>

                              <label for="password_confirmation">

                                 Konfirmasi Password

                              </label>

                           </div>


                           <!-- =================================================
                                AGREEMENT
                           ================================================== -->

                           <div class="form-check mb-5 pmb-agree">

                              <input
                                 class="form-check-input"
                                 type="checkbox"
                                 value="1"
                                 id="agree"
                                 required>


                              <label
                                 class="form-check-label fs-14"
                                 for="agree">

                                 Saya memastikan data yang saya masukkan benar
                                 dan dapat dipertanggungjawabkan.

                              </label>

                           </div>


                           <!-- =================================================
                                SUBMIT
                           ================================================== -->

                           <button
                              type="submit"
                              class="btn btn-primary rounded w-100 btn-icon btn-icon-end pmb-submit">

                              Buat Akun Pendaftaran

                              <i class="uil uil-arrow-right"></i>

                           </button>


                        </form>

                     </div>

                  </div>


                  <!-- =================================================
                       EXISTING ACCOUNT
                  ================================================== -->

                  <div class="text-center mt-5 pmb-login">

                     <p class="mb-2 text-muted">

                        Sudah memiliki akun PMB?

                     </p>


                     <a
                        href="pmb/login-pmb"
                        class="btn btn-outline-primary rounded">

                        <i class="uil uil-sign-in-alt me-1"></i>

                        Login Portal PMB

                     </a>

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
      function copyToClipboard(text) {

         navigator.clipboard.writeText(text)

            .then(() => {

               alert('No.Rekening berhasil disalin ke clipboard!');

            })

            .catch(err => {

               console.error(
                  'Gagal menyalin teks: ',
                  err
               );

               alert(
                  'Gagal menyalin teks. Silakan coba lagi.'
               );

            });

      }
   </script>
   <script src="assets/js/register-pmb.js"></script>

</body>

</html>