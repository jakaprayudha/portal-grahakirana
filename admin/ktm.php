<?php

/**
 * =========================================================
 * KTM MAHASISWA
 * ADMIN PMB - STIH GRAHA KIRANA
 * =========================================================
 */

session_start();

require_once __DIR__ . '/../config/connect.php';


/**
 * =========================================================
 * AUTH ADMIN
 * =========================================================
 */

if (
   empty($_SESSION['admin_logged_in']) ||
   $_SESSION['admin_logged_in'] !== true ||
   empty($_SESSION['admin_user_id'])
) {

   header(
      'Location: ./login.php'
   );

   exit;
}


/**
 * =========================================================
 * HELPER
 * =========================================================
 */

function h(
   $value
): string {

   return htmlspecialchars(
      (string) ($value ?? ''),
      ENT_QUOTES,
      'UTF-8'
   );
}


/**
 * =========================================================
 * ADMIN SESSION
 * =========================================================
 */

$adminName =
   $_SESSION['admin_fullname']
   ??
   $_SESSION['admin_name']
   ??
   'Administrator';


/**
 * =========================================================
 * GET DATA MAHASISWA
 * =========================================================
 */

$mahasiswa = [];

$errorMessage = '';


try {

   $stmt =
      $pdo->prepare("

         SELECT

            id,

            register_uid,

            fullname,

            number_id,

            nim,

            phone_number,

            email_register,

            register_type,

            id_program,

            jenis_pembiayaan,

            tahap_aktif,

            status_pendaftaran,

            status_kelulusan,

            status_daftar_ulang,

            siakad_status,

            created_at,

            updated_at

         FROM register_pmb

         WHERE

            UPPER(
               COALESCE(
                  status_pendaftaran,
                  ''
               )
            ) = 'MAHASISWA'

         ORDER BY

            fullname ASC

      ");


   $stmt->execute();


   $mahasiswa =
      $stmt->fetchAll(
         PDO::FETCH_ASSOC
      );
} catch (
   Throwable $e
) {

   $errorMessage =
      $e->getMessage();
}


/**
 * =========================================================
 * STATISTICS
 * =========================================================
 */

$totalMahasiswa = 0;

$totalSiakadAktif = 0;

$totalSiakadBelumAktif = 0;


try {


   /**
    * TOTAL MAHASISWA
    */

   $totalMahasiswa =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE

               UPPER(
                  COALESCE(
                     status_pendaftaran,
                     ''
                  )
               ) = 'MAHASISWA'

         ")
         ->fetchColumn();


   /**
    * SIAKAD AKTIF
    */

   $totalSiakadAktif =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE

               UPPER(
                  COALESCE(
                     status_pendaftaran,
                     ''
                  )
               ) = 'MAHASISWA'

               AND

               UPPER(
                  COALESCE(
                     siakad_status,
                     ''
                  )
               ) = 'AKTIF'

         ")
         ->fetchColumn();


   /**
    * BELUM AKTIF
    */

   $totalSiakadBelumAktif =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE

               UPPER(
                  COALESCE(
                     status_pendaftaran,
                     ''
                  )
               ) = 'MAHASISWA'

               AND

               UPPER(
                  COALESCE(
                     siakad_status,
                     ''
                  )
               ) <> 'AKTIF'

         ")
         ->fetchColumn();
} catch (
   Throwable $e
) {
}


/**
 * =========================================================
 * PAGE
 * =========================================================
 */

$pageTitle =
   'KTM Mahasiswa';

?>

<!DOCTYPE html>

<html lang="id">

<head>

   <meta charset="UTF-8">

   <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0">

   <title>

      <?= h($pageTitle) ?>

      - Admin PMB

   </title>


   <!-- =====================================================
        CSS
   ====================================================== -->

   <link
      rel="stylesheet"
      href="../assets/css/plugins.css">

   <link
      rel="stylesheet"
      href="../assets/css/style.css">

   <link
      rel="stylesheet"
      href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">


   <style>
      /* =====================================================
         BODY
      ====================================================== */

      body {

         background:
            #f6f8fb;

         color:
            #343f52;

      }


      /* =====================================================
         LAYOUT
      ====================================================== */

      .admin-wrapper {

         min-height:
            100vh;

      }


      /* =====================================================
         SIDEBAR
      ====================================================== */

      .admin-sidebar {

         width:
            270px;

         min-height:
            100vh;

         position:
            fixed;

         top:
            0;

         left:
            0;

         bottom:
            0;

         background:
            #ffffff;

         border-right:
            1px solid #e9edf2;

         z-index:
            1050;

         display:
            flex;

         flex-direction:
            column;

         overflow-y:
            auto;

      }


      /* =====================================================
         BRAND
      ====================================================== */

      .admin-brand {

         padding:
            25px 25px 20px;

         border-bottom:
            1px solid #edf0f4;

      }


      .admin-brand-icon {

         width:
            45px;

         height:
            45px;

         border-radius:
            14px;

         background:
            rgba(63, 120, 224, .12);

         color:
            #3f78e0;

         display:
            flex;

         align-items:
            center;

         justify-content:
            center;

         font-size:
            24px;

      }


      .admin-brand-title {

         font-size:
            17px;

         font-weight:
            700;

         color:
            #343f52;

         line-height:
            1.3;

      }


      .admin-brand-subtitle {

         font-size:
            13px;

         color:
            #8492a6;

      }


      /* =====================================================
         SIDEBAR MENU
      ====================================================== */

      .sidebar-menu {

         padding:
            20px 15px;

         flex:
            1;

      }


      .sidebar-section-title {

         font-size:
            11px;

         text-transform:
            uppercase;

         letter-spacing:
            .8px;

         color:
            #aab3bf;

         font-weight:
            700;

         padding:
            15px 12px 8px;

      }


      .sidebar-link {

         display:
            flex;

         align-items:
            center;

         gap:
            12px;

         padding:
            12px 14px;

         border-radius:
            10px;

         color:
            #5b6472;

         text-decoration:
            none;

         font-size:
            15px;

         font-weight:
            500;

         margin-bottom:
            4px;

         transition:
            .2s ease;

      }


      .sidebar-link:hover {

         background:
            #f3f6fb;

         color:
            #3f78e0;

      }


      .sidebar-link.active {

         background:
            rgba(63, 120, 224, .12);

         color:
            #3f78e0;

         font-weight:
            700;

      }


      .sidebar-link i {

         width:
            20px;

         text-align:
            center;

         font-size:
            18px;

      }


      /* =====================================================
         SIDEBAR FOOTER
      ====================================================== */

      .sidebar-footer {

         padding:
            18px;

         border-top:
            1px solid #edf0f4;

      }


      .admin-profile {

         display:
            flex;

         align-items:
            center;

         gap:
            12px;

         margin-bottom:
            15px;

      }


      .admin-avatar {

         width:
            42px;

         height:
            42px;

         border-radius:
            50%;

         background:
            rgba(63, 120, 224, .12);

         color:
            #3f78e0;

         display:
            flex;

         align-items:
            center;

         justify-content:
            center;

         font-size:
            20px;

         flex-shrink:
            0;

      }


      .admin-profile-name {

         font-size:
            14px;

         font-weight:
            700;

         color:
            #343f52;

      }


      .admin-profile-role {

         font-size:
            12px;

         color:
            #8492a6;

      }


      .btn-logout {

         width:
            100%;

         border:
            1px solid #e2626b;

         color:
            #e2626b;

         background:
            transparent;

         border-radius:
            10px;

         padding:
            10px;

         font-weight:
            600;

         text-decoration:
            none;

         display:
            flex;

         align-items:
            center;

         justify-content:
            center;

         gap:
            8px;

      }


      .btn-logout:hover {

         background:
            #e2626b;

         color:
            #ffffff;

      }


      /* =====================================================
         MAIN
      ====================================================== */

      .admin-main {

         margin-left:
            270px;

         min-height:
            100vh;

      }


      /* =====================================================
         TOPBAR
      ====================================================== */

      .admin-topbar {

         min-height:
            105px;

         background:
            #ffffff;

         border-bottom:
            1px solid #e9edf2;

         padding:
            20px 45px;

         display:
            flex;

         align-items:
            center;

         justify-content:
            space-between;

      }


      .admin-page-title {

         margin:
            0;

         font-size:
            27px;

         font-weight:
            700;

         color:
            #343f52;

      }


      .admin-page-subtitle {

         margin-top:
            4px;

         color:
            #8492a6;

         font-size:
            15px;

      }


      /* =====================================================
         CONTENT
      ====================================================== */

      .admin-content {

         padding:
            45px;

      }


      /* =====================================================
         STAT CARD
      ====================================================== */

      .stat-card {

         border:
            0;

         border-radius:
            18px;

         box-shadow:
            0 5px 20px rgba(30, 34, 40, .04);

         height:
            100%;

      }


      .stat-icon {

         width:
            60px;

         height:
            60px;

         border-radius:
            16px;

         display:
            flex;

         align-items:
            center;

         justify-content:
            center;

         font-size:
            27px;

      }


      .stat-label {

         font-size:
            12px;

         font-weight:
            700;

         text-transform:
            uppercase;

         color:
            #8492a6;

         margin-top:
            20px;

      }


      .stat-value {

         font-size:
            32px;

         font-weight:
            700;

         color:
            #343f52;

         margin-top:
            5px;

      }


      /* =====================================================
         INFO BOX
      ====================================================== */

      .ktm-info-card {

         border:
            0;

         border-radius:
            16px;

         background:
            rgba(63, 120, 224, .08);

         color:
            #3f5d88;

      }


      /* =====================================================
         TABLE CARD
      ====================================================== */

      .table-card {

         border:
            0;

         border-radius:
            18px;

         box-shadow:
            0 5px 20px rgba(30, 34, 40, .04);

         overflow:
            hidden;

      }


      .table-card-header {

         padding:
            30px 30px 20px;

         border-bottom:
            1px solid #edf0f4;

      }


      /* =====================================================
         SEARCH
      ====================================================== */

      .search-wrapper {

         position:
            relative;

      }


      .search-wrapper i {

         position:
            absolute;

         left:
            18px;

         top:
            50%;

         transform:
            translateY(-50%);

         color:
            #8492a6;

         font-size:
            19px;

      }


      .search-input {

         width:
            100%;

         height:
            55px;

         border-radius:
            14px;

         border:
            1px solid #e1e6ed;

         padding:
            0 20px 0 50px;

         outline:
            none;

         transition:
            .2s;

      }


      .search-input:focus {

         border-color:
            #3f78e0;

         box-shadow:
            0 0 0 3px rgba(63, 120, 224, .08);

      }


      /* =====================================================
         TABLE
      ====================================================== */

      .ktm-table {

         margin:
            0;

      }


      .ktm-table thead th {

         background:
            #f8f9fb;

         color:
            #8492a6;

         font-size:
            11px;

         text-transform:
            uppercase;

         letter-spacing:
            .6px;

         font-weight:
            700;

         padding:
            18px 20px;

         border-bottom:
            1px solid #edf0f4;

      }


      .ktm-table tbody td {

         padding:
            18px 20px;

         vertical-align:
            middle;

         border-color:
            #edf0f4;

      }


      .student-avatar {

         width:
            45px;

         height:
            45px;

         border-radius:
            50%;

         background:
            rgba(63, 120, 224, .1);

         color:
            #3f78e0;

         display:
            flex;

         align-items:
            center;

         justify-content:
            center;

         font-size:
            20px;

         flex-shrink:
            0;

      }


      .student-name {

         font-weight:
            700;

         color:
            #343f52;

      }


      .student-uid {

         font-size:
            12px;

         color:
            #8492a6;

         margin-top:
            3px;

      }


      .nim-code {

         font-family:
            monospace;

         font-size:
            14px;

         font-weight:
            700;

         color:
            #3f78e0;

      }


      .status-badge {

         border-radius:
            30px;

         padding:
            7px 13px;

         font-size:
            11px;

         font-weight:
            700;

      }


      /* =====================================================
         EMPTY
      ====================================================== */

      .empty-state {

         padding:
            70px 20px;

         text-align:
            center;

         color:
            #8492a6;

      }


      .empty-state i {

         font-size:
            50px;

         color:
            #c7cfda;

      }


      /* =====================================================
         MOBILE
      ====================================================== */

      @media (max-width: 991.98px) {

         .admin-sidebar {

            position:
               relative;

            width:
               100%;

            min-height:
               auto;

         }


         .admin-main {

            margin-left:
               0;

         }


         .admin-topbar {

            padding:
               20px;

         }


         .admin-content {

            padding:
               20px;

         }

      }
   </style>

</head>


<body>


   <div class="admin-wrapper">


      <!-- =====================================================
        SIDEBAR
   ====================================================== -->

      <aside class="admin-sidebar">


         <!-- BRAND -->

         <div class="admin-brand">

            <div class="d-flex align-items-center gap-3">

               <div class="admin-brand-icon">

                  <i class="uil uil-shield-check"></i>

               </div>


               <div>

                  <div class="admin-brand-title">

                     ADMIN PMB

                  </div>


                  <div class="admin-brand-subtitle">

                     Portal Administrasi

                  </div>

               </div>

            </div>

         </div>


         <!-- MENU -->

         <nav class="sidebar-menu">


            <div class="sidebar-section-title">

               Menu Utama

            </div>


            <a
               href="./dashboard.php"
               class="sidebar-link">

               <i class="uil uil-estate"></i>

               Dashboard

            </a>


            <a
               href="./data-peserta.php"
               class="sidebar-link">

               <i class="uil uil-users-alt"></i>

               Data Peserta

            </a>


            <a
               href="./jadwal-seleksi.php"
               class="sidebar-link">

               <i class="uil uil-calendar-alt"></i>

               Jadwal Seleksi

            </a>


            <a
               href="./hasil-seleksi.php"
               class="sidebar-link">

               <i class="uil uil-award"></i>

               Hasil Seleksi

            </a>


            <a
               href="./daftar-ulang.php"
               class="sidebar-link">

               <i class="uil uil-file-check-alt"></i>

               Daftar Ulang

            </a>


            <div class="sidebar-section-title">

               Akademik

            </div>


            <a
               href="./jadwal-akademik.php"
               class="sidebar-link">

               <i class="uil uil-schedule"></i>

               Jadwal

            </a>


            <a
               href="./mahasiswa.php"
               class="sidebar-link">

               <i class="uil uil-graduation-cap"></i>

               Mahasiswa

            </a>


            <a
               href="./ktm-mahasiswa.php"
               class="sidebar-link active">

               <i class="uil uil-credit-card"></i>

               KTM

            </a>


            <a
               href="./krs.php"
               class="sidebar-link">

               <i class="uil uil-book-open"></i>

               KRS

            </a>


         </nav>


         <!-- FOOTER -->

         <div class="sidebar-footer">


            <div class="admin-profile">

               <div class="admin-avatar">

                  <i class="uil uil-user"></i>

               </div>


               <div>

                  <div class="admin-profile-name">

                     <?= h($adminName) ?>

                  </div>


                  <div class="admin-profile-role">

                     Administrator

                  </div>

               </div>

            </div>


            <a
               href="./logout.php"
               class="btn-logout"
               onclick="return confirm('Apakah Anda yakin ingin keluar?');">

               <i class="uil uil-signout"></i>

               Keluar

            </a>


         </div>


      </aside>


      <!-- =====================================================
        MAIN
   ====================================================== -->

      <main class="admin-main">


         <!-- ===================================================
           TOPBAR
      ==================================================== -->

         <div class="admin-topbar">


            <div>

               <h1 class="admin-page-title">

                  KTM Mahasiswa

               </h1>


               <div class="admin-page-subtitle">

                  Daftar mahasiswa dan pengelolaan Kartu Tanda Mahasiswa

               </div>

            </div>


            <div>

               <span
                  class="
                  badge
                  bg-soft-primary
                  text-primary
                  rounded-pill
                  px-4
                  py-2
               ">

                  <i class="uil uil-credit-card me-1"></i>

                  Kartu Tanda Mahasiswa

               </span>

            </div>


         </div>


         <!-- ===================================================
           CONTENT
      ==================================================== -->

         <div class="admin-content">


            <!-- ===============================================
              STATISTICS
         ================================================ -->

            <div class="row g-4 mb-5">


               <!-- TOTAL -->

               <div class="col-md-4">

                  <div class="card stat-card">

                     <div class="card-body p-4">


                        <div
                           class="
                           stat-icon
                           bg-soft-primary
                           text-primary
                        ">

                           <i class="uil uil-users-alt"></i>

                        </div>


                        <div class="stat-label">

                           Total Mahasiswa

                        </div>


                        <div class="stat-value">

                           <?= number_format($totalMahasiswa) ?>

                        </div>


                     </div>

                  </div>

               </div>


               <!-- SIAKAD AKTIF -->

               <div class="col-md-4">

                  <div class="card stat-card">

                     <div class="card-body p-4">


                        <div
                           class="
                           stat-icon
                           bg-soft-green
                           text-green
                        ">

                           <i class="uil uil-check-circle"></i>

                        </div>


                        <div class="stat-label">

                           SIAKAD Aktif

                        </div>


                        <div class="stat-value">

                           <?= number_format($totalSiakadAktif) ?>

                        </div>


                     </div>

                  </div>

               </div>


               <!-- BELUM AKTIF -->

               <div class="col-md-4">

                  <div class="card stat-card">

                     <div class="card-body p-4">


                        <div
                           class="
                           stat-icon
                           bg-soft-yellow
                           text-yellow
                        ">

                           <i class="uil uil-clock"></i>

                        </div>


                        <div class="stat-label">

                           Belum Aktivasi

                        </div>


                        <div class="stat-value">

                           <?= number_format($totalSiakadBelumAktif) ?>

                        </div>


                     </div>

                  </div>

               </div>


            </div>


            <!-- ===============================================
              INFORMATION
         ================================================ -->

            <div
               class="
               card
               ktm-info-card
               mb-5
            ">

               <div class="card-body p-4">


                  <div class="d-flex align-items-start">


                     <div class="me-3 fs-25">

                        <i class="uil uil-info-circle"></i>

                     </div>


                     <div>

                        <h5 class="mb-2">

                           Kartu Tanda Mahasiswa

                        </h5>


                        <p class="mb-0">

                           Halaman ini menampilkan seluruh peserta PMB
                           yang telah resmi berstatus
                           <strong>MAHASISWA</strong>.
                           Data dapat digunakan untuk melihat informasi
                           mahasiswa dan mencetak KTM.

                        </p>

                     </div>


                  </div>


               </div>

            </div>


            <!-- ===============================================
              ERROR
         ================================================ -->

            <?php if ($errorMessage !== ''): ?>

               <div class="alert alert-danger">

                  <strong>Database Error:</strong>

                  <?= h($errorMessage) ?>

               </div>

            <?php endif; ?>


            <!-- ===============================================
              TABLE
         ================================================ -->

            <div class="card table-card">


               <!-- HEADER -->

               <div class="table-card-header">


                  <div
                     class="
                     d-flex
                     justify-content-between
                     align-items-start
                     flex-wrap
                     gap-3
                     mb-4
                  ">


                     <div>

                        <h4 class="mb-1">

                           Daftar Mahasiswa

                        </h4>


                        <p class="text-muted mb-0">

                           Kelola data dan Kartu Tanda Mahasiswa.

                        </p>

                     </div>


                     <span
                        class="
                        badge
                        bg-soft-primary
                        text-primary
                        rounded-pill
                        px-3
                        py-2
                     ">

                        <?= number_format(count($mahasiswa)) ?>

                        Mahasiswa

                     </span>


                  </div>


                  <!-- SEARCH -->

                  <div class="search-wrapper">

                     <i class="uil uil-search"></i>

                     <input
                        type="text"
                        id="searchMahasiswa"
                        class="search-input"
                        placeholder="Cari nama, NPM, UID, NIK, email atau nomor HP...">

                  </div>


               </div>


               <!-- TABLE -->

               <div class="table-responsive">


                  <table
                     class="
                     table
                     ktm-table
                     align-middle
                  "
                     id="tableMahasiswa">


                     <thead>

                        <tr>

                           <th style="width:70px">

                              #

                           </th>


                           <th>

                              Mahasiswa

                           </th>


                           <th>

                              NPM

                           </th>


                           <th>

                              Jalur

                           </th>


                           <th>

                              Kontak

                           </th>


                           <th>

                              SIAKAD

                           </th>


                           <th
                              class="text-end">

                              Action

                           </th>

                        </tr>

                     </thead>


                     <tbody>


                        <?php if (!empty($mahasiswa)): ?>


                           <?php foreach ($mahasiswa as $index => $item): ?>


                              <?php


                              $siakadStatus =
                                 strtoupper(
                                    trim(
                                       $item['siakad_status']
                                          ?? ''
                                    )
                                 );


                              $nim =
                                 trim(
                                    $item['nim']
                                       ?? ''
                                 );


                              ?>


                              <tr>


                                 <!-- NUMBER -->

                                 <td>

                                    <?= $index + 1 ?>

                                 </td>


                                 <!-- MAHASISWA -->

                                 <td>


                                    <div class="d-flex align-items-center">


                                       <div class="student-avatar me-3">

                                          <i class="uil uil-user"></i>

                                       </div>


                                       <div>


                                          <div class="student-name">

                                             <?= h(
                                                $item['fullname']
                                                   ?? '-'
                                             ) ?>

                                          </div>


                                          <div class="student-uid">

                                             UID:

                                             <?= h(
                                                $item['register_uid']
                                                   ?? '-'
                                             ) ?>

                                          </div>


                                       </div>


                                    </div>


                                 </td>


                                 <!-- NPM -->

                                 <td>

                                    <?php if ($nim !== ''): ?>

                                       <span class="nim-code">

                                          <?= h($nim) ?>

                                       </span>

                                    <?php else: ?>

                                       <span class="text-muted">

                                          Belum diterbitkan

                                       </span>

                                    <?php endif; ?>


                                 </td>


                                 <!-- JALUR -->

                                 <td>

                                    <span
                                       class="
                                       badge
                                       bg-soft-secondary
                                       text-secondary
                                       rounded-pill
                                    ">

                                       <?= h(
                                          $item['register_type']
                                             ?? '-'
                                       ) ?>

                                    </span>

                                 </td>


                                 <!-- KONTAK -->

                                 <td>


                                    <div
                                       class="
                                       small
                                       text-muted
                                    ">


                                       <div>

                                          <i
                                             class="
                                             uil
                                             uil-envelope
                                             me-1
                                          ">
                                          </i>

                                          <?= h(
                                             $item['email_register']
                                                ?? '-'
                                          ) ?>

                                       </div>


                                       <div class="mt-1">

                                          <i
                                             class="
                                             uil
                                             uil-phone
                                             me-1
                                          ">
                                          </i>

                                          <?= h(
                                             $item['phone_number']
                                                ?? '-'
                                          ) ?>

                                       </div>


                                    </div>


                                 </td>


                                 <!-- SIAKAD -->

                                 <td>


                                    <?php if ($siakadStatus === 'AKTIF'): ?>


                                       <span
                                          class="
                                          badge
                                          bg-soft-green
                                          text-green
                                          status-badge
                                       ">

                                          <i
                                             class="
                                             uil
                                             uil-check-circle
                                             me-1
                                          ">
                                          </i>

                                          AKTIF

                                       </span>


                                    <?php else: ?>


                                       <span
                                          class="
                                          badge
                                          bg-soft-yellow
                                          text-yellow
                                          status-badge
                                       ">

                                          <i
                                             class="
                                             uil
                                             uil-clock
                                             me-1
                                          ">
                                          </i>

                                          BELUM AKTIF

                                       </span>


                                    <?php endif; ?>


                                 </td>


                                 <!-- ACTION -->

                                 <td class="text-end">


                                    <div
                                       class="
                                       d-flex
                                       justify-content-end
                                       gap-2
                                    ">


                                       <!-- DETAIL -->

                                       <a
                                          href="./detail-mahasiswa.php?id=<?= (int) $item['id'] ?>"
                                          class="
                                          btn
                                          btn-sm
                                          btn-outline-primary
                                          rounded-pill
                                       "
                                          title="Lihat Detail">

                                          <i class="uil uil-eye"></i>

                                       </a>


                                       <!-- CETAK KTM -->

                                       <a
                                          href="./cetak-ktm.php?id=<?= (int) $item['id'] ?>"
                                          target="_blank"
                                          class="
                                          btn
                                          btn-sm
                                          btn-primary
                                          rounded-pill
                                       "
                                          title="Cetak KTM">

                                          <i
                                             class="
                                             uil
                                             uil-print
                                             me-1
                                          ">
                                          </i>

                                          Cetak KTM

                                       </a>


                                    </div>


                                 </td>


                              </tr>


                           <?php endforeach; ?>


                        <?php else: ?>


                           <tr>

                              <td
                                 colspan="7"
                                 class="p-0">


                                 <div class="empty-state">

                                    <i class="uil uil-users-alt"></i>


                                    <h5 class="mt-3 mb-1">

                                       Belum Ada Mahasiswa

                                    </h5>


                                    <p class="mb-0">

                                       Data mahasiswa belum tersedia.

                                    </p>


                                 </div>


                              </td>

                           </tr>


                        <?php endif; ?>


                     </tbody>


                  </table>


               </div>


            </div>


         </div>


      </main>


   </div>


   <!-- =========================================================
     JAVASCRIPT
========================================================= -->

   <script>
      document.addEventListener(
         'DOMContentLoaded',
         function() {


            /**
             * =====================================================
             * SEARCH TABLE
             * =====================================================
             */

            const searchInput =
               document.getElementById(
                  'searchMahasiswa'
               );


            const table =
               document.getElementById(
                  'tableMahasiswa'
               );


            if (
               searchInput &&
               table
            ) {


               const rows =
                  table.querySelectorAll(
                     'tbody tr'
                  );


               searchInput.addEventListener(
                  'input',
                  function() {


                     const keyword =
                        this.value
                        .toLowerCase()
                        .trim();


                     rows.forEach(
                        function(row) {


                           const text =
                              row.textContent
                              .toLowerCase();


                           if (
                              text.includes(keyword)
                           ) {

                              row.style.display =
                                 '';

                           } else {

                              row.style.display =
                                 'none';

                           }


                        }
                     );


                  }
               );


            }


         }
      );
   </script>


</body>

</html>