<?php

session_start();

require_once '../config/connect.php';


/**
 * =========================================================
 * AUTHENTICATION
 * =========================================================
 */

if (
   empty($_SESSION['admin_logged_in']) ||
   $_SESSION['admin_logged_in'] !== true ||
   empty($_SESSION['admin_user_id'])
) {
   header('Location: ./index.php');
   exit;
}


/**
 * =========================================================
 * ADMIN DATA
 * =========================================================
 */

$adminName =
   $_SESSION['admin_fullname']
   ?? $_SESSION['admin_username']
   ?? 'Administrator';

$adminRole =
   $_SESSION['admin_roles']
   ?? 'admin';


/**
 * =========================================================
 * HELPER
 * =========================================================
 */

function h($value): string
{
   return htmlspecialchars(
      (string) $value,
      ENT_QUOTES,
      'UTF-8'
   );
}


/**
 * =========================================================
 * MESSAGE
 * =========================================================
 */

$successMessage = '';
$errorMessage = '';


/**
 * =========================================================
 * FILTER
 * =========================================================
 */

$search =
   trim(
      $_GET['search'] ?? ''
   );


$siakadStatus =
   trim(
      $_GET['siakad_status'] ?? ''
   );


$ktmStatus =
   trim(
      $_GET['ktm_status'] ?? ''
   );


$krsStatus =
   trim(
      $_GET['krs_status'] ?? ''
   );


/**
 * =========================================================
 * WHERE
 * =========================================================
 */

$where = [];

$params = [];


/**
 * =========================================================
 * HANYA MAHASISWA
 * =========================================================
 */

$where[] = "

   status_pendaftaran = 'MAHASISWA'

";


/**
 * =========================================================
 * SEARCH
 * =========================================================
 */

if (
   $search !== ''
) {

   $where[] = "

      (

         fullname LIKE :search

         OR register_uid LIKE :search

         OR nim LIKE :search

         OR number_id LIKE :search

         OR phone_number LIKE :search

         OR email_register LIKE :search

      )

   ";


   $params['search'] =
      '%' .
      $search .
      '%';
}


/**
 * =========================================================
 * FILTER SIAKAD
 * =========================================================
 */

if (
   $siakadStatus !== ''
) {

   $where[] =
      "siakad_status = :siakad_status";


   $params['siakad_status'] =
      $siakadStatus;
}


/**
 * =========================================================
 * FILTER KTM
 * =========================================================
 */

if (
   $ktmStatus !== ''
) {

   $where[] =
      "ktm_status = :ktm_status";


   $params['ktm_status'] =
      $ktmStatus;
}


/**
 * =========================================================
 * FILTER KRS
 * =========================================================
 */

if (
   $krsStatus !== ''
) {

   $where[] =
      "krs_status = :krs_status";


   $params['krs_status'] =
      $krsStatus;
}


/**
 * =========================================================
 * BUILD WHERE
 * =========================================================
 */

$whereSql =
   'WHERE '
   .
   implode(
      ' AND ',
      $where
   );


/**
 * =========================================================
 * GET DATA
 * =========================================================
 */

$mahasiswa = [];


try {

   $stmt =
      $pdo->prepare("

         SELECT

            id,

            register_uid,

            fullname,

            gender,

            number_id,

            phone_number,

            email_register,

            register_type,

            id_program,

            jenis_pembiayaan,

            tahap_aktif,

            status_pendaftaran,

            status_daftar_ulang,

            nim,

            siakad_status,

            ktm_status,

            krs_status,

            account_status,

            school_name,

            year_graduation,

            created_at,

            updated_at

         FROM register_pmb

         $whereSql

         ORDER BY

            CASE

               WHEN
                  siakad_status =
                  'BELUM_AKTIVASI'

               THEN 1


               WHEN
                  siakad_status =
                  'AKTIF'

               THEN 2


               ELSE 3

            END,

            id DESC

      ");


   $stmt->execute(
      $params
   );


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

$totalSiakadBelum = 0;

$totalSiakadAktif = 0;

$totalKtmTerbit = 0;

$totalKrsSudahDiisi = 0;


try {


   /**
    * =====================================================
    * TOTAL MAHASISWA
    * =====================================================
    */

   $totalMahasiswa =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE
               status_pendaftaran = 'MAHASISWA'

         ")
         ->fetchColumn();


   /**
    * =====================================================
    * BELUM AKTIVASI SIAKAD
    * =====================================================
    */

   $totalSiakadBelum =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE

               status_pendaftaran = 'MAHASISWA'

               AND

               siakad_status =
               'BELUM_AKTIVASI'

         ")
         ->fetchColumn();


   /**
    * =====================================================
    * SIAKAD AKTIF
    * =====================================================
    */

   $totalSiakadAktif =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE

               status_pendaftaran = 'MAHASISWA'

               AND

               siakad_status =
               'AKTIF'

         ")
         ->fetchColumn();


   /**
    * =====================================================
    * KTM TERBIT
    * =====================================================
    */

   $totalKtmTerbit =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE

               status_pendaftaran = 'MAHASISWA'

               AND

               ktm_status =
               'TERBIT'

         ")
         ->fetchColumn();


   /**
    * =====================================================
    * KRS SUDAH DIISI
    * =====================================================
    */

   $totalKrsSudahDiisi =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE

               status_pendaftaran = 'MAHASISWA'

               AND

               krs_status =
               'SUDAH_DIISI'

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
   'Mahasiswa Diterima';

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
      body {
         background: #f6f8fb;
      }


      /* =====================================================
         SIDEBAR
      ===================================================== */

      .admin-sidebar {

         width: 260px;

         min-height: 100vh;

         position: fixed;

         left: 0;

         top: 0;

         bottom: 0;

         background: #fff;

         border-right:
            1px solid #e9edf2;

         z-index: 1000;

         display: flex;

         flex-direction: column;

      }


      .admin-brand {

         height: 82px;

         padding: 20px 24px;

         display: flex;

         align-items: center;

         border-bottom:
            1px solid #edf0f3;

      }


      .admin-brand-icon {

         width: 42px;

         height: 42px;

         min-width: 42px;

         border-radius: 10px;

         background:
            linear-gradient(135deg,
               #173f75,
               #0d6efd);

         color: #fff;

         display: flex;

         align-items: center;

         justify-content: center;

         margin-right: 12px;

      }


      .admin-brand-icon i {
         font-size: 21px;
      }


      .admin-brand-name {

         font-weight: 800;

         font-size: 14px;

         color: #20252b;

      }


      .admin-brand-sub {

         color: #9299a3;

         font-size: 10px;

      }


      .admin-nav {

         padding: 24px 15px;

         flex: 1;

      }


      .admin-nav-label {

         font-size: 10px;

         font-weight: 800;

         color: #9aa1aa;

         letter-spacing: 1px;

         text-transform: uppercase;

         padding: 0 12px;

         margin-bottom: 10px;

      }


      .admin-nav-link {

         display: flex;

         align-items: center;

         gap: 12px;

         padding: 11px 13px;

         margin-bottom: 4px;

         border-radius: 9px;

         color: #68717c;

         text-decoration: none;

         font-size: 13px;

         font-weight: 600;

      }


      .admin-nav-link i {
         font-size: 19px;
      }


      .admin-nav-link:hover {

         background: #f1f6ff;

         color: #0d6efd;

      }


      .admin-nav-link.active {

         background: #eaf2ff;

         color: #0d6efd;

      }


      .admin-sidebar-footer {

         padding: 18px;

         border-top:
            1px solid #edf0f3;

      }


      .admin-user-mini {

         display: flex;

         align-items: center;

         margin-bottom: 12px;

      }


      .admin-avatar {

         width: 38px;

         height: 38px;

         border-radius: 50%;

         background: #eaf2ff;

         color: #0d6efd;

         display: flex;

         align-items: center;

         justify-content: center;

         margin-right: 10px;

         font-weight: 800;

      }


      /* =====================================================
         MAIN
      ===================================================== */

      .admin-main {

         margin-left: 260px;

         min-height: 100vh;

      }


      .admin-topbar {

         min-height: 82px;

         background: #fff;

         border-bottom:
            1px solid #e9edf2;

         padding:
            15px 35px;

         display: flex;

         align-items: center;

         justify-content: space-between;

         gap: 20px;

      }


      .admin-page-title {

         font-size: 20px;

         font-weight: 800;

         margin: 0;

      }


      .admin-page-subtitle {

         color: #9299a3;

         font-size: 12px;

         margin-top: 3px;

      }


      .admin-content {

         padding: 35px;

      }


      /* =====================================================
         STATS
      ===================================================== */

      .stat-card {

         background: #fff;

         border:
            1px solid #edf0f3;

         border-radius: 13px;

         padding: 20px;

         height: 100%;

      }


      .stat-icon {

         width: 45px;

         height: 45px;

         border-radius: 10px;

         display: flex;

         align-items: center;

         justify-content: center;

         margin-bottom: 15px;

      }


      .stat-icon i {
         font-size: 21px;
      }


      .stat-label {

         font-size: 10px;

         color: #9299a3;

         text-transform: uppercase;

         font-weight: 800;

      }


      .stat-value {

         font-size: 26px;

         font-weight: 800;

         margin-top: 3px;

      }


      /* =====================================================
         DATA CARD
      ===================================================== */

      .data-card {

         background: #fff;

         border:
            1px solid #edf0f3;

         border-radius: 13px;

         overflow: hidden;

      }


      .data-card-header {

         padding: 22px;

         border-bottom:
            1px solid #edf0f3;

      }


      /* =====================================================
         FILTER
      ===================================================== */

      .search-wrapper {
         position: relative;
      }


      .search-wrapper i {

         position: absolute;

         left: 14px;

         top: 50%;

         transform:
            translateY(-50%);

         color: #9299a3;

         z-index: 2;

      }


      .search-input {

         height: 44px;

         border:
            1px solid #e1e5ea;

         border-radius: 9px;

         padding-left: 40px;

         font-size: 13px;

      }


      .filter-select {

         height: 44px;

         border:
            1px solid #e1e5ea;

         border-radius: 9px;

         font-size: 13px;

      }


      /* =====================================================
         TABLE
      ===================================================== */

      .data-table {
         margin: 0;
      }


      .data-table thead th {

         background: #fafbfc;

         border-bottom:
            1px solid #edf0f3;

         color: #9299a3;

         font-size: 10px;

         font-weight: 800;

         text-transform: uppercase;

         letter-spacing: .4px;

         padding:
            13px 15px;

         white-space: nowrap;

      }


      .data-table tbody td {

         padding:
            15px;

         border-color: #f0f2f5;

         font-size: 12px;

         vertical-align: middle;

      }


      .participant-name {

         font-weight: 700;

         color: #30363d;

      }


      .participant-id {

         color: #9299a3;

         font-size: 10px;

         margin-top: 3px;

      }


      .nim-code {

         font-family:
            monospace;

         color: #0d6efd;

         font-size: 13px;

         font-weight: 800;

      }


      .action-group {

         display: flex;

         align-items: center;

         justify-content: center;

         gap: 5px;

      }


      /* =====================================================
         RESPONSIVE
      ===================================================== */

      @media (max-width: 991.98px) {

         .admin-sidebar {
            width: 220px;
         }


         .admin-main {
            margin-left: 220px;
         }


         .admin-content {
            padding: 25px;
         }

      }


      @media (max-width: 767.98px) {

         .admin-sidebar {

            position: relative;

            width: 100%;

            min-height: auto;

         }


         .admin-main {
            margin-left: 0;
         }


         .admin-nav {
            display: none;
         }


         .admin-sidebar-footer {
            display: none;
         }


         .admin-topbar {

            padding:
               18px 20px;

         }


         .admin-content {

            padding:
               20px 15px;

         }

      }
   </style>

</head>


<body>


   <!-- =========================================================
      SIDEBAR
   ========================================================== -->

   <?php
   require 'sidebar.php';
   ?>


   <!-- =========================================================
      MAIN
   ========================================================== -->

   <main class="admin-main">


      <!-- =====================================================
         TOPBAR
      ====================================================== -->

      <header class="admin-topbar">


         <div>


            <h1 class="admin-page-title">

               Mahasiswa Diterima

            </h1>


            <div class="admin-page-subtitle">

               Data mahasiswa baru yang telah menyelesaikan proses penerimaan PMB

            </div>


         </div>


         <div class="d-flex align-items-center">


            <div class="admin-avatar">


               <?= h(
                  strtoupper(
                     substr(
                        $adminName,
                        0,
                        1
                     )
                  )
               ) ?>


            </div>


            <div class="d-none d-md-block">


               <div class="fw-bold fs-13">

                  <?= h($adminName) ?>

               </div>


               <div class="text-muted fs-11">

                  Administrator

               </div>


            </div>


         </div>


      </header>



      <!-- =====================================================
         CONTENT
      ====================================================== -->

      <div class="admin-content">


         <!-- =================================================
            ALERT
         ================================================== -->

         <?php if (
            $successMessage !== ''
         ): ?>


            <div class="alert alert-success alert-icon mb-4">


               <i class="uil uil-check-circle"></i>


               <?= h($successMessage) ?>


            </div>


         <?php endif; ?>


         <?php if (
            $errorMessage !== ''
         ): ?>


            <div class="alert alert-danger alert-icon mb-4">


               <i class="uil uil-times-circle"></i>


               <?= h($errorMessage) ?>


            </div>


         <?php endif; ?>



         <!-- =================================================
            STATS
         ================================================== -->

         <div class="row g-4 mb-5">


            <!-- TOTAL MAHASISWA -->

            <div class="col-6 col-xl">


               <div class="stat-card">


                  <div
                     class="
                        stat-icon
                        bg-soft-primary
                        text-primary
                     ">


                     <i class="uil uil-graduation-cap"></i>


                  </div>


                  <div class="stat-label">

                     Total Mahasiswa

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalMahasiswa
                     ) ?>

                  </div>


               </div>


            </div>



            <!-- BELUM AKTIVASI -->

            <div class="col-6 col-xl">


               <div class="stat-card">


                  <div
                     class="
                        stat-icon
                        bg-soft-yellow
                        text-yellow
                     ">


                     <i class="uil uil-lock-alt"></i>


                  </div>


                  <div class="stat-label">

                     Belum Aktivasi

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalSiakadBelum
                     ) ?>

                  </div>


               </div>


            </div>



            <!-- SIAKAD AKTIF -->

            <div class="col-6 col-xl">


               <div class="stat-card">


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

                     <?= number_format(
                        $totalSiakadAktif
                     ) ?>

                  </div>


               </div>


            </div>



            <!-- KTM -->

            <div class="col-6 col-xl">


               <div class="stat-card">


                  <div
                     class="
                        stat-icon
                        bg-soft-primary
                        text-primary
                     ">


                     <i class="uil uil-id-card"></i>


                  </div>


                  <div class="stat-label">

                     KTM Terbit

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalKtmTerbit
                     ) ?>

                  </div>


               </div>


            </div>



            <!-- KRS -->

            <div class="col-6 col-xl">


               <div class="stat-card">


                  <div
                     class="
                        stat-icon
                        bg-soft-green
                        text-green
                     ">


                     <i class="uil uil-book-open"></i>


                  </div>


                  <div class="stat-label">

                     KRS Terisi

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalKrsSudahDiisi
                     ) ?>

                  </div>


               </div>


            </div>


         </div>



         <!-- =================================================
            INFO
         ================================================== -->

         <div class="alert alert-primary alert-icon mb-5">


            <i class="uil uil-info-circle"></i>


            <div>


               <strong>

                  Status Mahasiswa Baru

               </strong>


               <div class="mt-1 fs-13">


                  Halaman ini menampilkan peserta PMB yang telah
                  resmi berstatus <strong>MAHASISWA</strong>.
                  Proses selanjutnya dapat dipantau melalui
                  status aktivasi <strong>SIAKAD</strong>,
                  penerbitan <strong>KTM</strong>,
                  dan pengisian <strong>KRS</strong>.


               </div>


            </div>


         </div>



         <!-- =================================================
            DATA CARD
         ================================================== -->

         <div class="data-card">


            <!-- =================================================
               HEADER
            ================================================== -->

            <div class="data-card-header">


               <div
                  class="
                     d-flex
                     justify-content-between
                     align-items-center
                     mb-4
                  ">


                  <div>


                     <h4
                        class="mb-1"
                        style="
                           font-size:17px;
                           font-weight:800;
                        ">


                        Daftar Mahasiswa Diterima


                     </h4>


                     <p
                        class="text-muted mb-0 fs-12">


                        Monitoring status mahasiswa baru setelah proses PMB.


                     </p>


                  </div>


                  <a
                     href="./mahasiswa-diterima.php"
                     class="
                        btn
                        btn-sm
                        btn-outline-secondary
                        rounded
                     ">


                     <i class="uil uil-refresh me-1"></i>


                     Refresh


                  </a>


               </div>



               <!-- =================================================
                  FILTER
               ================================================== -->

               <form
                  method="GET"
                  action="./mahasiswa-diterima.php">


                  <div class="row g-3">


                     <!-- SEARCH -->

                     <div class="col-lg-4">


                        <div class="search-wrapper">


                           <i class="uil uil-search"></i>


                           <input
                              type="text"
                              name="search"
                              value="<?= h($search) ?>"
                              class="
                                 form-control
                                 search-input
                              "
                              placeholder="
                                 Cari nama, NIM, ID, NIK atau email...
                              ">


                        </div>


                     </div>



                     <!-- SIAKAD -->

                     <div class="col-lg-2">


                        <select
                           name="siakad_status"
                           class="
                              form-select
                              filter-select
                           ">


                           <option value="">

                              Semua SIAKAD

                           </option>


                           <option
                              value="BELUM_AKTIVASI"
                              <?= $siakadStatus === 'BELUM_AKTIVASI'
                                 ? 'selected'
                                 : '' ?>>


                              Belum Aktivasi


                           </option>


                           <option
                              value="AKTIF"
                              <?= $siakadStatus === 'AKTIF'
                                 ? 'selected'
                                 : '' ?>>


                              Aktif


                           </option>


                        </select>


                     </div>



                     <!-- KTM -->

                     <div class="col-lg-2">


                        <select
                           name="ktm_status"
                           class="
                              form-select
                              filter-select
                           ">


                           <option value="">

                              Semua KTM

                           </option>


                           <option
                              value="BELUM_TERBIT"
                              <?= $ktmStatus === 'BELUM_TERBIT'
                                 ? 'selected'
                                 : '' ?>>


                              Belum Terbit


                           </option>


                           <option
                              value="TERBIT"
                              <?= $ktmStatus === 'TERBIT'
                                 ? 'selected'
                                 : '' ?>>


                              Terbit


                           </option>


                        </select>


                     </div>



                     <!-- KRS -->

                     <div class="col-lg-2">


                        <select
                           name="krs_status"
                           class="
                              form-select
                              filter-select
                           ">


                           <option value="">

                              Semua KRS

                           </option>


                           <option
                              value="BELUM_DIBUKA"
                              <?= $krsStatus === 'BELUM_DIBUKA'
                                 ? 'selected'
                                 : '' ?>>


                              Belum Dibuka


                           </option>


                           <option
                              value="DIBUKA"
                              <?= $krsStatus === 'DIBUKA'
                                 ? 'selected'
                                 : '' ?>>


                              Dibuka


                           </option>


                           <option
                              value="SUDAH_DIISI"
                              <?= $krsStatus === 'SUDAH_DIISI'
                                 ? 'selected'
                                 : '' ?>>


                              Sudah Diisi


                           </option>


                        </select>


                     </div>



                     <!-- BUTTON -->

                     <div class="col-lg-2">


                        <button
                           type="submit"
                           class="
                              btn
                              btn-primary
                              rounded
                              w-100
                           "
                           style="
                              height:44px;
                           ">


                           <i class="uil uil-search me-1"></i>


                           Cari


                        </button>


                     </div>


                  </div>


               </form>


            </div>



            <!-- =================================================
               TABLE
            ================================================== -->

            <div class="table-responsive">


               <table class="table data-table">


                  <thead>


                     <tr>


                        <th>#</th>


                        <th>Mahasiswa</th>


                        <th>NIM</th>


                        <th>Program</th>


                        <th>SIAKAD</th>


                        <th>KTM</th>


                        <th>KRS</th>


                        <th>Status</th>


                        <th class="text-center">

                           Aksi

                        </th>


                     </tr>


                  </thead>



                  <tbody>


                     <?php if (
                        empty($mahasiswa)
                     ): ?>


                        <tr>


                           <td
                              colspan="9"
                              class="text-center py-6">


                              <div class="text-muted">


                                 <i
                                    class="uil uil-graduation-cap"
                                    style="
                                       font-size:42px;
                                       opacity:.35;
                                    ">
                                 </i>


                                 <div class="mt-2">


                                    Belum ada data mahasiswa diterima.


                                 </div>


                              </div>


                           </td>


                        </tr>


                     <?php else: ?>


                        <?php

                        $no = 1;

                        ?>


                        <?php foreach (
                           $mahasiswa
                           as $row
                        ): ?>


                           <tr>


                              <!-- =================================================
                                 NO
                              ================================================== -->

                              <td>

                                 <?= $no++ ?>

                              </td>



                              <!-- =================================================
                                 MAHASISWA
                              ================================================== -->

                              <td>


                                 <div class="participant-name">


                                    <?= h(
                                       $row['fullname']
                                    ) ?>


                                 </div>


                                 <div class="participant-id">


                                    <?= h(
                                       $row['register_uid']
                                          ?: '-'
                                    ) ?>


                                 </div>


                                 <div class="participant-id">


                                    <i class="uil uil-phone me-1"></i>


                                    <?= h(
                                       $row['phone_number']
                                          ?: '-'
                                    ) ?>


                                 </div>


                              </td>



                              <!-- =================================================
                                 NIM
                              ================================================== -->

                              <td>


                                 <?php if (
                                    !empty($row['nim'])
                                 ): ?>


                                    <span class="nim-code">


                                       <?= h(
                                          $row['nim']
                                       ) ?>


                                    </span>


                                 <?php else: ?>


                                    <span class="text-muted">


                                       Belum Ada


                                    </span>


                                 <?php endif; ?>


                              </td>



                              <!-- =================================================
                                 PROGRAM
                              ================================================== -->

                              <td>


                                 <div class="participant-name">


                                    Program #<?= (int)
                                             $row['id_program'] ?>


                                 </div>


                                 <div class="participant-id">


                                    <?= h(
                                       $row['register_type']
                                          ?: '-'
                                    ) ?>


                                 </div>


                              </td>



                              <!-- =================================================
                                 SIAKAD
                              ================================================== -->

                              <td>


                                 <?php if (
                                    $row['siakad_status']
                                    === 'AKTIF'
                                 ): ?>


                                    <span
                                       class="
                                          badge
                                          bg-soft-green
                                          text-green
                                       ">


                                       <i class="
                                          uil
                                          uil-check-circle
                                          me-1
                                       "></i>


                                       Aktif


                                    </span>


                                 <?php else: ?>


                                    <span
                                       class="
                                          badge
                                          bg-soft-yellow
                                          text-yellow
                                       ">


                                       <i class="
                                          uil
                                          uil-clock
                                          me-1
                                       "></i>


                                       Belum Aktif


                                    </span>


                                 <?php endif; ?>


                              </td>



                              <!-- =================================================
                                 KTM
                              ================================================== -->

                              <td>


                                 <?php if (
                                    $row['ktm_status']
                                    === 'TERBIT'
                                 ): ?>


                                    <span
                                       class="
                                          badge
                                          bg-soft-green
                                          text-green
                                       ">


                                       <i class="
                                          uil
                                          uil-id-card
                                          me-1
                                       "></i>


                                       Terbit


                                    </span>


                                 <?php else: ?>


                                    <span
                                       class="
                                          badge
                                          bg-soft-secondary
                                          text-secondary
                                       ">


                                       Belum Terbit


                                    </span>


                                 <?php endif; ?>


                              </td>



                              <!-- =================================================
                                 KRS
                              ================================================== -->

                              <td>


                                 <?php

                                 $krs =
                                    $row['krs_status'];

                                 ?>


                                 <?php if (
                                    $krs === 'SUDAH_DIISI'
                                 ): ?>


                                    <span
                                       class="
                                          badge
                                          bg-soft-green
                                          text-green
                                       ">


                                       Sudah Diisi


                                    </span>


                                 <?php elseif (
                                    $krs === 'DIBUKA'
                                 ): ?>


                                    <span
                                       class="
                                          badge
                                          bg-soft-primary
                                          text-primary
                                       ">


                                       Dibuka


                                    </span>


                                 <?php else: ?>


                                    <span
                                       class="
                                          badge
                                          bg-soft-secondary
                                          text-secondary
                                       ">


                                       Belum Dibuka


                                    </span>


                                 <?php endif; ?>


                              </td>



                              <!-- =================================================
                                 STATUS
                              ================================================== -->

                              <td>


                                 <span
                                    class="
                                       badge
                                       bg-soft-green
                                       text-green
                                    ">


                                    <i
                                       class="
                                          uil
                                          uil-graduation-cap
                                          me-1
                                       ">
                                    </i>


                                    Mahasiswa


                                 </span>


                              </td>



                              <!-- =================================================
                                 ACTION
                              ================================================== -->

                              <td class="text-center">


                                 <div class="action-group">


                                    <a
                                       href="./peserta-detail.php?id=<?= (int)
                                                                     $row['id'] ?>"
                                       class="
                                          btn
                                          btn-sm
                                          btn-soft-primary
                                          rounded
                                       "
                                       title="Lihat Detail">


                                       <i class="uil uil-eye"></i>


                                    </a>


                                 </div>


                              </td>


                           </tr>


                        <?php endforeach; ?>


                     <?php endif; ?>


                  </tbody>


               </table>


            </div>


         </div>


      </div>


   </main>


</body>

</html>