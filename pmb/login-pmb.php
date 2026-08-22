<!DOCTYPE html>
<html lang="en">

<head>
   <base href="../">

   <?php
   $page = 'Login PMB';
   require '../head.php';
   ?>

   <style>
      /* =========================================================
         LOGIN PMB - RESPONSIVE
      ========================================================= */

      .pmb-login-section {
         min-height: calc(100vh - 120px);
         display: flex;
         align-items: center;
      }

      .pmb-login-wrapper {
         max-width: 1100px;
         margin: 0 auto;
      }

      .pmb-login-info {
         min-height: 520px;
      }

      .pmb-login-form-card {
         max-width: 520px;
         margin: 0 auto;
      }

      .pmb-login-form-card .card-body {
         padding: 3rem !important;
      }

      .pmb-login-input {
         min-height: 56px;
      }

      .pmb-login-button {
         min-height: 54px;
      }

      .pmb-login-help {
         font-size: 14px;
         line-height: 1.6;
      }


      /* =========================================================
         TABLET
      ========================================================= */

      @media (max-width: 991.98px) {

         .pmb-login-section {
            min-height: auto;
            padding-top: 60px !important;
            padding-bottom: 60px !important;
         }

         .pmb-login-info {
            min-height: auto;
         }

         .pmb-login-form-card {
            max-width: 100%;
         }

         .pmb-login-form-card .card-body {
            padding: 2.5rem !important;
         }

      }


      /* =========================================================
         MOBILE
      ========================================================= */

      @media (max-width: 767.98px) {

         .pmb-login-section {
            padding-top: 40px !important;
            padding-bottom: 40px !important;
         }

         .pmb-login-info {
            margin-bottom: 1rem;
         }

         .pmb-login-info .card-body {
            padding: 1.5rem !important;
         }

         .pmb-login-info h2 {
            font-size: 1.6rem;
         }

         .pmb-login-info p {
            font-size: 14px;
            line-height: 1.6;
         }

         .pmb-login-form-card .card-body {
            padding: 1.5rem !important;
         }

         .pmb-login-form-title {
            font-size: 1.35rem;
         }

         .pmb-login-input {
            min-height: 52px;
         }

         .pmb-login-button {
            min-height: 52px;
         }

         .pmb-login-help {
            font-size: 13px;
         }

      }


      /* =========================================================
         EXTRA SMALL MOBILE
      ========================================================= */

      @media (max-width: 575.98px) {

         .pmb-login-section {
            padding-top: 30px !important;
            padding-bottom: 30px !important;
         }

         .pmb-login-info .card-body,
         .pmb-login-form-card .card-body {
            padding: 1.25rem !important;
         }

         .pmb-login-info h2 {
            font-size: 1.45rem;
         }

         .pmb-login-form-title {
            font-size: 1.25rem;
         }

         .pmb-login-button {
            font-size: 14px;
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
           SECTION : LOGIN PORTAL PMB
      ====================================================== -->

      <section class="wrapper bg-light pmb-login-section">

         <div class="container">


            <div class="row gx-lg-8 gy-8 align-items-center pmb-login-wrapper">


               <!-- =================================================
                    LEFT : INFORMATION
               ================================================== -->

               <div class="col-12 col-lg-5">

                  <div class="card bg-primary text-white border-0 shadow-lg pmb-login-info">

                     <div class="card-body p-8 d-flex flex-column">


                        <!-- Icon -->

                        <div class="icon btn btn-circle btn-lg btn-white text-primary mb-5">

                           <i class="uil uil-lock-alt fs-24"></i>

                        </div>


                        <!-- Heading -->

                        <span class="text-uppercase text-white opacity-75 fs-13 fw-bold mb-2">

                           PORTAL PMB

                        </span>


                        <h2 class="text-white mb-4">

                           Selamat Datang Kembali

                        </h2>


                        <p class="text-white opacity-75 mb-6">

                           Silakan masuk ke Portal PMB menggunakan
                           <strong class="text-white">
                              Email
                           </strong>
                           dan password yang telah Anda buat saat melakukan
                           registrasi akun.

                        </p>


                        <!-- =================================================
                             LOGIN INFORMATION
                        ================================================== -->

                        <div class="border-top border-white border-opacity-25 pt-5 mt-auto">


                           <!-- ID Pendaftaran -->

                           <div class="d-flex mb-5">

                              <div class="icon btn btn-circle btn-sm btn-white text-primary me-3 flex-shrink-0">

                                 <i class="uil uil-user"></i>

                              </div>


                              <div>

                                 <h5 class="text-white mb-1">
                                    Email Pendaftaran
                                 </h5>

                                 <p class="text-white opacity-75 mb-0">
                                    Digunakan sebagai username Portal PMB.
                                 </p>

                              </div>

                           </div>


                           <!-- Password -->

                           <div class="d-flex">

                              <div class="icon btn btn-circle btn-sm btn-white text-primary me-3 flex-shrink-0">

                                 <i class="uil uil-key-skeleton"></i>

                              </div>


                              <div>

                                 <h5 class="text-white mb-1">
                                    Password
                                 </h5>

                                 <p class="text-white opacity-75 mb-0">
                                    Gunakan password saat membuat akun.
                                 </p>

                              </div>

                           </div>

                        </div>


                     </div>

                  </div>


                  <!-- =================================================
                       REGISTER INFO
                  ================================================== -->

                  <div class="alert alert-primary alert-icon mt-5 pmb-login-help" role="alert">

                     <i class="uil uil-info-circle"></i>

                     <div>

                        <strong>
                           Belum memiliki akun PMB?
                        </strong>

                        <p class="mb-0 mt-1">

                           Silakan melakukan registrasi akun terlebih dahulu
                           sebelum login ke Portal PMB.

                        </p>

                     </div>

                  </div>

               </div>


               <!-- =================================================
                    RIGHT : LOGIN FORM
               ================================================== -->

               <div class="col-12 col-lg-7">


                  <div class="card shadow-lg border-0 pmb-login-form-card">


                     <div class="card-body">


                        <!-- =================================================
                             FORM HEADER
                        ================================================== -->

                        <div class="text-center mb-7">

                           <div class="icon btn btn-circle btn-lg btn-soft-primary mb-4">

                              <i class="uil uil-sign-in-alt fs-24"></i>

                           </div>


                           <span class="text-uppercase text-muted fs-13 fw-bold d-block mb-2">

                              Portal Pendaftaran

                           </span>


                           <h3 class="mb-2 pmb-login-form-title">

                              Login Portal PMB

                           </h3>


                           <p class="text-muted mb-0">

                              Masuk untuk melanjutkan proses pendaftaran Anda.

                           </p>

                        </div>


                        <!-- =================================================
                             FORM
                        ================================================== -->

                        <form
                           action="controllers/login-pmb"
                           method="POST"
                           id="formLoginPMB"
                           novalidate>

                           <!-- =================================================
         EMAIL
    ================================================== -->

                           <div class="form-floating mb-4">

                              <input
                                 type="email"
                                 name="email"
                                 id="email"
                                 class="form-control pmb-login-input"
                                 placeholder="Email"
                                 autocomplete="username"
                                 required>

                              <label for="email">
                                 Email
                              </label>

                           </div>


                           <!-- =================================================
         PASSWORD
    ================================================== -->

                           <div class="form-floating mb-3">

                              <input
                                 type="password"
                                 name="password"
                                 id="password"
                                 class="form-control pmb-login-input"
                                 placeholder="Password"
                                 autocomplete="current-password"
                                 required>

                              <label for="password">
                                 Password
                              </label>

                           </div>


                           <!-- =================================================
         SHOW PASSWORD
    ================================================== -->

                           <div class="d-flex justify-content-between align-items-center mb-5">

                              <div class="form-check">

                                 <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="showPassword">

                                 <label
                                    class="form-check-label fs-14"
                                    for="showPassword">

                                    Tampilkan password

                                 </label>

                              </div>


                              <a
                                 href="#"
                                 class="fs-14">

                                 Lupa password?

                              </a>

                           </div>


                           <!-- =================================================
         LOGIN BUTTON
    ================================================== -->

                           <button
                              type="submit"
                              class="btn btn-primary rounded w-100 btn-icon btn-icon-end pmb-login-button">

                              Masuk ke Portal PMB

                              <i class="uil uil-arrow-right"></i>

                           </button>

                        </form>
                        <!-- =================================================
                             REGISTER BUTTON
                        ================================================== -->

                        <div class="text-center mt-3">

                           <p class="text-muted mb-3">

                              Belum memiliki akun?

                           </p>


                           <a
                              href="pmb/register"
                              class="btn btn-outline-primary rounded btn-icon btn-icon-start">

                              <i class="uil uil-user-plus"></i>

                              Buat Akun Pendaftaran

                           </a>

                        </div>


                     </div>

                  </div>


                  <!-- =================================================
                       SECURITY INFO
                  ================================================== -->

                  <div class="text-center mt-5">

                     <p class="text-muted fs-13 mb-0">

                        <i class="uil uil-shield-check me-1"></i>

                        Gunakan perangkat pribadi dan jangan membagikan
                        password kepada orang lain.

                     </p>

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
         SHOW / HIDE PASSWORD
      ========================================================= */

      const showPassword = document.getElementById('showPassword');
      const passwordInput = document.getElementById('password');

      if (showPassword && passwordInput) {

         showPassword.addEventListener('change', function() {

            passwordInput.type = this.checked ? 'text' : 'password';

         });

      }
   </script>
   <script src="assets/js/login-pmb.js"></script>

</body>

</html>