<?php

session_start();

require_once '../config/connect.php';


/**
 * =========================================================
 * AUTHENTICATION
 * =========================================================
 */

if (
   empty($_SESSION['pmb_logged_in']) ||
   empty($_SESSION['pmb_user_id'])
) {

   header('Location: ./login-pmb.php');
   exit;
}


$userId = (int) $_SESSION['pmb_user_id'];


/**
 * =========================================================
 * GET DATA MAHASISWA
 * =========================================================
 */

$stmt = $pdo->prepare("

    SELECT

        id,
        fullname,
        register_uid,
        register_type,
        id_program,

        tahap_aktif,
        status_pendaftaran,

        nim,
        siakad_status,

        email_register,
        phone_number,

        created_at,
        updated_at

    FROM register_pmb

    WHERE id = :id

    LIMIT 1

");


$stmt->execute([
   'id' => $userId
]);


$pmbUser = $stmt->fetch(
   PDO::FETCH_ASSOC
);


/**
 * =========================================================
 * USER NOT FOUND
 * =========================================================
 */

if (!$pmbUser) {

   session_destroy();

   header('Location: ./login-pmb.php');

   exit;
}


/**
 * =========================================================
 * GUARD MAHASISWA
 * =========================================================
 */

$statusPendaftaran =
   strtoupper(
      trim(
         $pmbUser['status_pendaftaran'] ?? ''
      )
   );


if (
   $statusPendaftaran !== 'MAHASISWA'
) {

   header('Location: ./welcome.php');

   exit;
}


/**
 * =========================================================
 * DATA
 * =========================================================
 */

$namaMahasiswa =
   trim(
      $pmbUser['fullname'] ?? ''
   );


if ($namaMahasiswa === '') {

   $namaMahasiswa = '-';
}


$nim =
   trim(
      $pmbUser['nim'] ?? ''
   );


if ($nim === '') {

   $nim = '-';
}


$idPendaftaran =
   trim(
      $pmbUser['register_uid'] ?? ''
   );


if ($idPendaftaran === '') {

   $idPendaftaran = '-';
}


$email =
   trim(
      $pmbUser['email_register'] ?? ''
   );


if ($email === '') {

   $email = '-';
}


$phone =
   trim(
      $pmbUser['phone_number'] ?? ''
   );


if ($phone === '') {

   $phone = '-';
}


/**
 * =========================================================
 * SIAKAD STATUS
 * =========================================================
 */

$siakadStatus =
   strtoupper(
      trim(
         $pmbUser['siakad_status']
            ?? 'BELUM_AKTIVASI'
      )
   );


$isAktif =
   $siakadStatus === 'AKTIF';


/**
 * =========================================================
 * PAGE
 * =========================================================
 */

$page =
   'Aktivasi SIAKAD';

?>
<!DOCTYPE html>

<html lang="id">

<head>

   <base href="../">

   <?php
   require '../head.php';
   ?>


   <style>
      /* =====================================================
           AKTIVASI SIAKAD
        ===================================================== */

      .activation-section {

         padding-top: 70px;
         padding-bottom: 90px;

      }


      .activation-card {

         border: 0;

         overflow: hidden;

      }


      .activation-header {

         position: relative;

         overflow: hidden;

      }


      .activation-header::before {

         content: "";

         position: absolute;

         width: 300px;
         height: 300px;

         border-radius: 50%;

         background:
            rgba(255,
               255,
               255,
               .06);

         right: -100px;
         top: -150px;

      }


      .activation-header::after {

         content: "";

         position: absolute;

         width: 180px;
         height: 180px;

         border-radius: 50%;

         background:
            rgba(255,
               255,
               255,
               .04);

         left: -80px;
         bottom: -100px;

      }


      .activation-header-content {

         position: relative;

         z-index: 2;

      }


      .activation-icon {

         width: 82px;
         height: 82px;

         border-radius: 50%;

         background: #fff;

         display: flex;

         align-items: center;

         justify-content: center;

         margin-bottom: 25px;

      }


      .activation-icon i {

         font-size: 38px;

      }


      .activation-info {

         border: 1px solid #edf0f3;

         border-radius: 12px;

         padding: 20px;

      }


      .activation-info-row {

         display: flex;

         align-items: center;

         padding: 13px 0;

         border-bottom: 1px solid #edf0f3;

      }


      .activation-info-row:last-child {

         border-bottom: 0;

      }


      .activation-info-icon {

         width: 42px;
         height: 42px;

         min-width: 42px;

         border-radius: 10px;

         display: flex;

         align-items: center;

         justify-content: center;

         margin-right: 14px;

      }


      .activation-info-label {

         font-size: 12px;

         color: #8a8f98;

         margin-bottom: 2px;

      }


      .activation-info-value {

         font-size: 14px;

         font-weight: 600;

      }


      .activation-check {

         border: 1px solid #edf0f3;

         border-radius: 12px;

         padding: 18px;

      }


      .activation-check .form-check-input {

         margin-top: 4px;

      }


      .activation-security {

         border-radius: 12px;

      }


      .activation-success {

         border: 0;

      }


      .activation-success-icon {

         width: 80px;
         height: 80px;

         border-radius: 50%;

         display: flex;

         align-items: center;

         justify-content: center;

         margin: 0 auto 25px;

      }


      .activation-success-icon i {

         font-size: 40px;

      }


      @media (max-width: 767.98px) {

         .activation-section {

            padding-top: 40px;
            padding-bottom: 60px;

         }


         .activation-header .card-body {

            padding: 35px 20px !important;

         }


         .activation-header h2 {

            font-size: 28px;

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
         ACTIVATION
    ====================================================== -->

      <section class="wrapper bg-light activation-section">

         <div class="container">


            <!-- =================================================
                 BREADCRUMB / BACK
            ================================================== -->

            <div class="mb-5">

               <a
                  href="./pmb/register-siakad"
                  class="btn btn-sm btn-outline-primary rounded">

                  <i class="uil uil-arrow-left me-1"></i>

                  Kembali ke SIAKAD

               </a>

            </div>


            <!-- =================================================
                 ALREADY ACTIVE
            ================================================== -->

            <?php if ($isAktif): ?>


               <div class="row">

                  <div class="col-lg-8 mx-auto">


                     <div class="card shadow-sm activation-success">

                        <div class="card-body p-6 p-md-8 text-center">


                           <div class="activation-success-icon bg-soft-green text-green">

                              <i class="uil uil-check-circle"></i>

                           </div>


                           <span class="badge bg-soft-green text-green rounded-pill px-4 py-2 mb-4">

                              AKUN AKTIF

                           </span>


                           <h2 class="mb-3">

                              SIAKAD Anda Sudah Aktif

                           </h2>


                           <p class="text-muted fs-17 mb-6">

                              Akun SIAKAD untuk

                              <strong>

                                 <?= htmlspecialchars(
                                    $namaMahasiswa,
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </strong>

                              telah berhasil diaktifkan.

                           </p>


                           <div class="row justify-content-center mb-6">

                              <div class="col-md-8">

                                 <div class="activation-info text-start">


                                    <!-- NIM -->

                                    <div class="activation-info-row">

                                       <div class="activation-info-icon bg-soft-primary text-primary">

                                          <i class="uil uil-user-square"></i>

                                       </div>


                                       <div>

                                          <div class="activation-info-label">

                                             NIM

                                          </div>


                                          <div class="activation-info-value">

                                             <?= htmlspecialchars(
                                                $nim,
                                                ENT_QUOTES,
                                                'UTF-8'
                                             ) ?>

                                          </div>

                                       </div>

                                    </div>


                                    <!-- EMAIL -->

                                    <div class="activation-info-row">

                                       <div class="activation-info-icon bg-soft-green text-green">

                                          <i class="uil uil-envelope"></i>

                                       </div>


                                       <div>

                                          <div class="activation-info-label">

                                             Email

                                          </div>


                                          <div class="activation-info-value">

                                             <?= htmlspecialchars(
                                                $email,
                                                ENT_QUOTES,
                                                'UTF-8'
                                             ) ?>

                                          </div>

                                       </div>

                                    </div>


                                    <!-- STATUS -->

                                    <div class="activation-info-row">

                                       <div class="activation-info-icon bg-soft-yellow text-yellow">

                                          <i class="uil uil-check-circle"></i>

                                       </div>


                                       <div>

                                          <div class="activation-info-label">

                                             Status SIAKAD

                                          </div>


                                          <div class="activation-info-value text-green">

                                             Aktif

                                          </div>

                                       </div>

                                    </div>


                                 </div>

                              </div>

                           </div>


                           <a
                              href="./pmb/welcome-mahasiswa.php"
                              class="btn btn-primary rounded btn-icon btn-icon-end">

                              Masuk ke SIAKAD

                              <i class="uil uil-arrow-right"></i>

                           </a>


                        </div>

                     </div>


                  </div>

               </div>


            <?php else: ?>


               <!-- =================================================
                     PAGE HEADER
                ================================================== -->

               <div class="row mb-7">

                  <div class="col-lg-9">


                     <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

                        AKTIVASI SIAKAD

                     </span>


                     <h2 class="display-4 mb-3">

                        Aktivasi Akun SIAKAD

                     </h2>


                     <p class="lead fs-18 mb-0">

                        Aktifkan akun SIAKAD Anda untuk mulai
                        menggunakan layanan akademik mahasiswa.

                     </p>


                  </div>

               </div>


               <!-- =================================================
                     MAIN
                ================================================== -->

               <div class="row gx-lg-8 gy-6">


                  <!-- =================================================
                         LEFT
                    ================================================== -->

                  <div class="col-lg-7">


                     <div class="card shadow-sm activation-card">

                        <!-- HEADER -->

                        <div class="card bg-primary text-white border-0 activation-header">

                           <div class="card-body p-6">


                              <div class="activation-header-content">


                                 <div class="activation-icon text-primary">

                                    <i class="uil uil-key-skeleton"></i>

                                 </div>


                                 <span class="text-uppercase text-white opacity-75 fs-13 fw-bold">

                                    Portal SIAKAD

                                 </span>


                                 <h2 class="text-white mt-2 mb-3">

                                    Selamat Datang di SIAKAD

                                 </h2>


                                 <p class="text-white opacity-75 mb-0">

                                    Satu langkah lagi untuk mengaktifkan
                                    akun akademik Anda.

                                 </p>


                              </div>


                           </div>

                        </div>


                        <!-- BODY -->

                        <div class="card-body p-5 p-md-6">


                           <!-- DATA -->

                           <div class="mb-6">

                              <span class="text-uppercase text-muted fs-13 fw-bold">

                                 Data Mahasiswa

                              </span>


                              <h4 class="mt-2 mb-4">

                                 Pastikan data Anda benar

                              </h4>


                              <div class="activation-info">


                                 <!-- NAMA -->

                                 <div class="activation-info-row">

                                    <div class="activation-info-icon bg-soft-primary text-primary">

                                       <i class="uil uil-user"></i>

                                    </div>


                                    <div>

                                       <div class="activation-info-label">

                                          Nama Mahasiswa

                                       </div>


                                       <div class="activation-info-value">

                                          <?= htmlspecialchars(
                                             $namaMahasiswa,
                                             ENT_QUOTES,
                                             'UTF-8'
                                          ) ?>

                                       </div>

                                    </div>

                                 </div>


                                 <!-- NIM -->

                                 <div class="activation-info-row">

                                    <div class="activation-info-icon bg-soft-green text-green">

                                       <i class="uil uil-user-square"></i>

                                    </div>


                                    <div>

                                       <div class="activation-info-label">

                                          NIM

                                       </div>


                                       <div class="activation-info-value">

                                          <?= htmlspecialchars(
                                             $nim,
                                             ENT_QUOTES,
                                             'UTF-8'
                                          ) ?>

                                       </div>

                                    </div>

                                 </div>


                                 <!-- EMAIL -->

                                 <div class="activation-info-row">

                                    <div class="activation-info-icon bg-soft-yellow text-yellow">

                                       <i class="uil uil-envelope"></i>

                                    </div>


                                    <div>

                                       <div class="activation-info-label">

                                          Email

                                       </div>


                                       <div class="activation-info-value">

                                          <?= htmlspecialchars(
                                             $email,
                                             ENT_QUOTES,
                                             'UTF-8'
                                          ) ?>

                                       </div>

                                    </div>

                                 </div>


                                 <!-- PHONE -->

                                 <div class="activation-info-row">

                                    <div class="activation-info-icon bg-soft-primary text-primary">

                                       <i class="uil uil-phone"></i>

                                    </div>


                                    <div>

                                       <div class="activation-info-label">

                                          Nomor HP

                                       </div>


                                       <div class="activation-info-value">

                                          <?= htmlspecialchars(
                                             $phone,
                                             ENT_QUOTES,
                                             'UTF-8'
                                          ) ?>

                                       </div>

                                    </div>

                                 </div>


                              </div>

                           </div>


                           <!-- AGREEMENT -->

                           <form
                              action="controllers/aktivasi-siakad.php"
                              method="POST"
                              id="formAktivasiSiakad">


                              <input
                                 type="hidden"
                                 name="action"
                                 value="aktivasi">


                              <div class="activation-check mb-5">

                                 <div class="form-check">


                                    <input
                                       class="form-check-input"
                                       type="checkbox"
                                       id="agreement"
                                       name="agreement"
                                       value="1"
                                       required>


                                    <label
                                       class="form-check-label fs-14"
                                       for="agreement">

                                       Saya menyatakan bahwa data
                                       mahasiswa yang ditampilkan
                                       di atas sudah benar dan saya
                                       menyetujui aktivasi akun SIAKAD.

                                    </label>


                                 </div>

                              </div>


                              <!-- SECURITY -->

                              <div class="alert alert-primary alert-icon activation-security mb-5">

                                 <i class="uil uil-shield-check"></i>


                                 <div>

                                    <strong>

                                       Keamanan Akun

                                    </strong>


                                    <p class="mb-0 mt-1 fs-14">

                                       Setelah akun diaktifkan,
                                       gunakan kredensial SIAKAD
                                       Anda untuk mengakses layanan
                                       akademik.

                                    </p>

                                 </div>

                              </div>


                              <!-- BUTTON -->

                              <button
                                 type="submit"
                                 id="btnAktivasiSiakad"
                                 class="btn btn-primary rounded btn-icon btn-icon-end w-100">

                                 Aktifkan Akun SIAKAD

                                 <i class="uil uil-arrow-right"></i>

                              </button>


                           </form>


                        </div>

                     </div>


                  </div>


                  <!-- =================================================
                         RIGHT
                    ================================================== -->

                  <div class="col-lg-5">


                     <!-- STATUS -->

                     <div class="card shadow-sm border-0 mb-6">

                        <div class="card-body p-6">


                           <span class="text-uppercase text-muted fs-13 fw-bold">

                              Status Aktivasi

                           </span>


                           <h4 class="mt-2 mb-5">

                              Tahapan Anda

                           </h4>


                           <!-- STEP 01 -->

                           <div class="d-flex align-items-center mb-5">

                              <div class="icon btn btn-circle btn-sm btn-primary text-white me-3">

                                 <i class="uil uil-check"></i>

                              </div>


                              <div>

                                 <h6 class="mb-1">

                                    Mahasiswa Baru

                                 </h6>


                                 <span class="badge bg-soft-green text-green rounded-pill">

                                    Selesai

                                 </span>

                              </div>

                           </div>


                           <!-- STEP 02 -->

                           <div class="d-flex align-items-center mb-5">

                              <div class="icon btn btn-circle btn-sm btn-primary text-white me-3">

                                 <i class="uil uil-key-skeleton"></i>

                              </div>


                              <div>

                                 <h6 class="mb-1">

                                    Aktivasi SIAKAD

                                 </h6>


                                 <span class="badge bg-soft-primary text-primary rounded-pill">

                                    Sedang Diproses

                                 </span>

                              </div>

                           </div>


                           <!-- STEP 03 -->

                           <div class="d-flex align-items-center">

                              <div class="icon btn btn-circle btn-sm btn-soft-yellow text-yellow me-3">

                                 <i class="uil uil-card-atm"></i>

                              </div>


                              <div>

                                 <h6 class="mb-1">

                                    Kartu Tanda Mahasiswa

                                 </h6>


                                 <span class="badge bg-soft-yellow text-yellow rounded-pill">

                                    Berikutnya

                                 </span>

                              </div>

                           </div>


                        </div>

                     </div>


                     <!-- INFO -->

                     <div class="card bg-soft-primary border-0">

                        <div class="card-body p-6">


                           <div class="icon btn btn-circle btn-sm btn-soft-primary mb-4">

                              <i class="uil uil-info-circle"></i>

                           </div>


                           <h4 class="mb-3">

                              Informasi

                           </h4>


                           <p class="text-muted fs-14 mb-0">

                              Aktivasi SIAKAD merupakan langkah awal
                              sebelum Anda dapat menggunakan layanan
                              akademik seperti KTM dan KRS.

                           </p>


                        </div>

                     </div>


                  </div>


               </div>


            <?php endif; ?>


         </div>

      </section>


   </div>


   <?php
   require '../footer2.php';
   ?>


   <!-- =========================================================
     TOAST
========================================================== -->

   <div
      id="pmbToastContainer"
      style="
        position:fixed;
        top:25px;
        right:25px;
        z-index:999999;
        max-width:380px;
    ">
   </div>


   <!-- =========================================================
     JS
========================================================== -->

   <script src="./assets/js/plugins.js"></script>

   <script src="./assets/js/theme.js"></script>

   <script src="./assets/js/aktivasi-siakad.js"></script>


</body>

</html>