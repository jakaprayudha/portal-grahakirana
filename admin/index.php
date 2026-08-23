<?php

session_start();


/**
 * =========================================================
 * JIKA ADMIN SUDAH LOGIN
 * =========================================================
 */

if (
   !empty($_SESSION['admin_logged_in']) &&
   $_SESSION['admin_logged_in'] === true
) {

   header('Location: dashboard.php');

   exit;
}

?>
<!DOCTYPE html>

<html lang="id">

<head>

   <meta charset="UTF-8">

   <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0">


   <title>
      Login Admin - Portal PMB
   </title>


   <!-- Bootstrap -->

   <link
      rel="stylesheet"
      href="../assets/css/plugins.css">


   <link
      rel="stylesheet"
      href="../assets/css/style.css">


   <!-- Unicons -->

   <link
      rel="stylesheet"
      href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">


   <style>
      html,
      body {

         min-height: 100%;

      }


      body {

         background:
            linear-gradient(135deg,
               #f4f7fb 0%,
               #eef3f9 100%);

      }


      .admin-login-page {

         min-height: 100vh;

         display: flex;

         align-items: center;

         justify-content: center;

         padding: 30px 15px;

      }


      .admin-login-wrapper {

         width: 100%;

         max-width: 1050px;

      }


      .admin-login-card {

         background: #ffffff;

         border: 0;

         border-radius: 20px;

         overflow: hidden;

         box-shadow:
            0 25px 70px rgba(20,
               40,
               80,
               .12);

      }


      /**
         * =====================================================
         * LEFT PANEL
         * =====================================================
         */

      .admin-login-info {

         height: 100%;

         min-height: 620px;

         padding: 55px;

         color: #ffffff;

         background:
            linear-gradient(145deg,
               #173f75 0%,
               #0d6efd 100%);

         position: relative;

         overflow: hidden;

      }


      .admin-login-info::before {

         content: "";

         position: absolute;

         width: 400px;

         height: 400px;

         border-radius: 50%;

         background:
            rgba(255,
               255,
               255,
               .06);

         right: -180px;

         top: -160px;

      }


      .admin-login-info::after {

         content: "";

         position: absolute;

         width: 280px;

         height: 280px;

         border-radius: 50%;

         background:
            rgba(255,
               255,
               255,
               .04);

         left: -150px;

         bottom: -130px;

      }


      .admin-login-content {

         position: relative;

         z-index: 2;

      }


      .admin-logo {

         width: 72px;

         height: 72px;

         background: #ffffff;

         border-radius: 16px;

         display: flex;

         align-items: center;

         justify-content: center;

         margin-bottom: 35px;

      }


      .admin-logo i {

         font-size: 36px;

         color: #0d6efd;

      }


      .admin-login-info h1 {

         color: #ffffff;

         font-size: 38px;

         font-weight: 800;

         line-height: 1.15;

      }


      .admin-login-info p {

         color: rgba(255,
               255,
               255,
               .78);

      }


      .admin-feature {

         display: flex;

         align-items: flex-start;

         margin-top: 32px;

      }


      .admin-feature-icon {

         width: 42px;

         height: 42px;

         min-width: 42px;

         border-radius: 10px;

         background:
            rgba(255,
               255,
               255,
               .12);

         display: flex;

         align-items: center;

         justify-content: center;

         margin-right: 15px;

      }


      .admin-feature-icon i {

         font-size: 20px;

      }


      .admin-feature h6 {

         color: #ffffff;

         margin-bottom: 4px;

      }


      .admin-feature p {

         margin: 0;

         font-size: 13px;

      }


      /**
         * =====================================================
         * RIGHT PANEL
         * =====================================================
         */

      .admin-login-form {

         padding: 55px;

      }


      .admin-login-label {

         font-size: 12px;

         font-weight: 700;

         letter-spacing: .8px;

         text-transform: uppercase;

         color: #8b929c;

      }


      .admin-login-form h2 {

         font-size: 30px;

         font-weight: 800;

         margin-top: 8px;

      }


      .admin-form-group {

         margin-bottom: 22px;

      }


      .admin-form-group label {

         display: block;

         font-size: 13px;

         font-weight: 600;

         margin-bottom: 8px;

      }


      .admin-input-wrapper {

         position: relative;

      }


      .admin-input-wrapper>i {

         position: absolute;

         left: 15px;

         top: 50%;

         transform:
            translateY(-50%);

         color: #9299a3;

         font-size: 19px;

         z-index: 2;

      }


      .admin-input {

         width: 100%;

         height: 52px;

         border: 1px solid #e2e6eb;

         border-radius: 10px;

         padding:
            0 45px;

         font-size: 14px;

         outline: none;

         transition: all .2s ease;

      }


      .admin-input:focus {

         border-color: #0d6efd;

         box-shadow:
            0 0 0 3px rgba(13,
               110,
               253,
               .08);

      }


      .admin-password-toggle {

         position: absolute;

         right: 14px;

         top: 50%;

         transform:
            translateY(-50%);

         border: 0;

         background: transparent;

         color: #9299a3;

         cursor: pointer;

         padding: 5px;

      }


      .admin-login-button {

         height: 54px;

         width: 100%;

         border: 0;

         border-radius: 10px;

         font-weight: 700;

         font-size: 14px;

         margin-top: 10px;

      }


      .admin-security {

         margin-top: 30px;

         padding: 15px;

         border-radius: 10px;

         background: #f5f8fc;

         color: #68717c;

         font-size: 12px;

      }


      .admin-security i {

         color: #0d6efd;

         font-size: 18px;

         margin-right: 8px;

      }


      .admin-footer {

         text-align: center;

         color: #9299a3;

         font-size: 12px;

         margin-top: 25px;

      }


      /**
         * =====================================================
         * RESPONSIVE
         * =====================================================
         */

      @media (max-width: 991.98px) {

         .admin-login-info {

            min-height: auto;

            padding: 40px;

         }


         .admin-login-info h1 {

            font-size: 32px;

         }


         .admin-login-form {

            padding: 40px;

         }

      }


      @media (max-width: 575.98px) {

         .admin-login-page {

            padding: 15px;

         }


         .admin-login-info {

            padding: 30px 25px;

         }


         .admin-login-form {

            padding: 30px 25px;

         }


         .admin-login-info h1 {

            font-size: 28px;

         }


         .admin-feature {

            margin-top: 22px;

         }

      }
   </style>

</head>


<body>


   <div class="admin-login-page">


      <div class="admin-login-wrapper">


         <div class="admin-login-card">


            <div class="row g-0">


               <!-- =================================================
                     LEFT
                ================================================== -->

               <div class="col-lg-6">


                  <div class="admin-login-info">


                     <div class="admin-login-content">


                        <div class="admin-logo">

                           <i class="uil uil-shield-check"></i>

                        </div>


                        <span class="text-uppercase fs-13 fw-bold opacity-75">

                           Portal Administrasi

                        </span>


                        <h1 class="mt-3 mb-4">

                           Admin Portal PMB

                        </h1>


                        <p class="lead fs-16">

                           Kelola proses Penerimaan Mahasiswa Baru
                           secara terintegrasi melalui panel
                           administrasi.

                        </p>


                        <!-- FEATURE -->

                        <div class="admin-feature">


                           <div class="admin-feature-icon">

                              <i class="uil uil-users-alt"></i>

                           </div>


                           <div>

                              <h6>

                                 Manajemen Peserta

                              </h6>


                              <p>

                                 Kelola data peserta PMB
                                 secara terpusat.

                              </p>

                           </div>


                        </div>


                        <!-- FEATURE -->

                        <div class="admin-feature">


                           <div class="admin-feature-icon">

                              <i class="uil uil-chart-line"></i>

                           </div>


                           <div>

                              <h6>

                                 Monitoring PMB

                              </h6>


                              <p>

                                 Pantau status dan tahapan
                                 pendaftaran peserta.

                              </p>

                           </div>


                        </div>


                        <!-- FEATURE -->

                        <div class="admin-feature">


                           <div class="admin-feature-icon">

                              <i class="uil uil-shield-check"></i>

                           </div>


                           <div>

                              <h6>

                                 Akses Terproteksi

                              </h6>


                              <p>

                                 Panel hanya dapat diakses
                                 oleh administrator.

                              </p>

                           </div>


                        </div>


                     </div>

                  </div>

               </div>


               <!-- =================================================
                     RIGHT
                ================================================== -->

               <div class="col-lg-6">


                  <div class="admin-login-form">


                     <span class="admin-login-label">

                        Administrator

                     </span>


                     <h2>

                        Selamat Datang

                     </h2>


                     <p class="text-muted mb-6">

                        Silakan masuk menggunakan akun
                        administrator Anda.

                     </p>


                     <!-- =================================================
                             FORM
                        ================================================== -->

                     <form
                        action="../controllers/admin/login.php"
                        method="POST"
                        id="formAdminLogin"
                        novalidate>


                        <!-- USERNAME -->

                        <div class="admin-form-group">


                           <label
                              for="username">

                              Username

                           </label>


                           <div class="admin-input-wrapper">


                              <i class="uil uil-user"></i>


                              <input
                                 type="text"
                                 name="username"
                                 id="username"
                                 class="admin-input"
                                 placeholder="Masukkan username"
                                 autocomplete="username"
                                 required>


                           </div>

                        </div>


                        <!-- PASSWORD -->

                        <div class="admin-form-group">


                           <label
                              for="password">

                              Password

                           </label>


                           <div class="admin-input-wrapper">


                              <i class="uil uil-lock"></i>


                              <input
                                 type="password"
                                 name="password"
                                 id="password"
                                 class="admin-input"
                                 placeholder="Masukkan password"
                                 autocomplete="current-password"
                                 required>


                              <button
                                 type="button"
                                 class="admin-password-toggle"
                                 id="togglePassword"
                                 aria-label="Tampilkan password">

                                 <i
                                    class="uil uil-eye"
                                    id="passwordIcon">
                                 </i>

                              </button>


                           </div>

                        </div>


                        <!-- REMEMBER -->

                        <div class="d-flex justify-content-between align-items-center mb-4">


                           <div class="form-check">


                              <input
                                 type="checkbox"
                                 class="form-check-input"
                                 id="remember"
                                 name="remember"
                                 value="1">


                              <label
                                 class="form-check-label fs-13"
                                 for="remember">

                                 Ingat saya

                              </label>


                           </div>


                           <a
                              href="#"
                              class="fs-13">

                              Lupa password?

                           </a>


                        </div>


                        <!-- BUTTON -->

                        <button
                           type="submit"
                           id="btnAdminLogin"
                           class="btn btn-primary admin-login-button">

                           <span
                              id="btnAdminLoginText">

                              Masuk ke Admin Portal

                           </span>


                           <i
                              class="uil uil-arrow-right ms-1">
                           </i>

                        </button>


                     </form>


                     <!-- SECURITY -->

                     <div class="admin-security">


                        <div class="d-flex align-items-start">


                           <i class="uil uil-shield-check"></i>


                           <div>

                              <strong>

                                 Area Terbatas

                              </strong>


                              <div class="mt-1">

                                 Halaman ini khusus untuk
                                 administrator Portal PMB.

                              </div>

                           </div>


                        </div>


                     </div>


                     <div class="admin-footer">

                        © <?= date('Y') ?>

                        Portal PMB

                        ·

                        Admin Panel

                     </div>


                  </div>

               </div>


            </div>

         </div>


      </div>

   </div>

   <script src="../assets/js/admin-login.js"></script>


</body>

</html>