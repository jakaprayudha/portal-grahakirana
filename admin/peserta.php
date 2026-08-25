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
   $_SESSION['admin_fullname'] ??
   $_SESSION['admin_username'] ??
   'Administrator';

$adminRole =
   $_SESSION['admin_roles'] ??
   'admin';


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


function statusClass(
   string $status
): string {

   switch ($status) {

      case 'LULUS':
      case 'MAHASISWA':
         return 'success';

      case 'TIDAK_LULUS':
         return 'danger';

      case 'SELEKSI':
      case 'MENUNGGU_SELEKSI':
         return 'warning';

      case 'DAFTAR_ULANG':
         return 'info';

      case 'DATA_DOKUMEN':
         return 'primary';

      default:
         return 'secondary';
   }
}


/**
 * =========================================================
 * FILTER
 * =========================================================
 */

$search =
   trim(
      $_GET['search'] ?? ''
   );


$status =
   trim(
      $_GET['status'] ?? ''
   );


$tahap =
   trim(
      $_GET['tahap'] ?? ''
   );


/**
 * =========================================================
 * PAGINATION
 * =========================================================
 */

$page =
   max(
      1,
      (int) ($_GET['page'] ?? 1)
   );


$perPage = 15;

$offset =
   ($page - 1) *
   $perPage;


/**
 * =========================================================
 * WHERE
 * =========================================================
 */

$where = [];

$params = [];


if ($search !== '') {

   $where[] = "

        (
            fullname LIKE :search
            OR number_id LIKE :search
            OR register_uid LIKE :search
            OR email_register LIKE :search
            OR phone_number LIKE :search
        )

    ";

   $params['search'] =
      '%' . $search . '%';
}


if ($status !== '') {

   $where[] =
      "status_pendaftaran = :status";

   $params['status'] =
      $status;
}


if ($tahap !== '') {

   $where[] =
      "tahap_aktif = :tahap";

   $params['tahap'] =
      (int) $tahap;
}


$whereSql = '';


if (!empty($where)) {

   $whereSql =
      'WHERE ' .
      implode(
         ' AND ',
         $where
      );
}


/**
 * =========================================================
 * TOTAL DATA
 * =========================================================
 */

$totalData = 0;


try {

   $stmt =
      $pdo->prepare("

            SELECT COUNT(*)

            FROM register_pmb

            $whereSql

        ");


   $stmt->execute(
      $params
   );


   $totalData =
      (int) $stmt->fetchColumn();
} catch (Throwable $e) {

   $totalData = 0;
}


$totalPages =
   max(
      1,
      (int) ceil(
         $totalData / $perPage
      )
   );


/**
 * =========================================================
 * DATA PESERTA
 * =========================================================
 */

$peserta = [];


try {

   $stmt =
      $pdo->prepare("

            SELECT

                id,
                register_uid,
                fullname,
                gender,
                agama,
                ukuran_baju,
                number_id,
                phone_number,
                email_register,

                register_type,
                id_program,
                id_provider,

                tahap_aktif,
                status_pendaftaran,

                status_kelulusan,

                nilai_tpa,
                nilai_wawancara,
                nilai_akhir,

                jenis_pembiayaan,

                account_status,
                created_at,
                updated_at

            FROM register_pmb

            $whereSql

            ORDER BY id DESC

            LIMIT :offset, :limit

        ");


   foreach ($params as $key => $value) {

      $stmt->bindValue(
         ':' . $key,
         $value
      );
   }


   $stmt->bindValue(
      ':offset',
      $offset,
      PDO::PARAM_INT
   );


   $stmt->bindValue(
      ':limit',
      $perPage,
      PDO::PARAM_INT
   );


   $stmt->execute();


   $peserta =
      $stmt->fetchAll(
         PDO::FETCH_ASSOC
      );
} catch (Throwable $e) {

   $peserta = [];
}


/**
 * =========================================================
 * STATISTICS
 * =========================================================
 */

$totalPeserta = 0;
$totalAktif = 0;
$totalSeleksi = 0;
$totalLulus = 0;


try {

   $totalPeserta =
      (int) $pdo
         ->query("
            SELECT COUNT(*)
            FROM register_pmb
        ")
         ->fetchColumn();


   $totalAktif =
      (int) $pdo
         ->query("
            SELECT COUNT(*)
            FROM register_pmb
            WHERE account_status = 'ACTIVE'
        ")
         ->fetchColumn();


   $totalSeleksi =
      (int) $pdo
         ->query("
            SELECT COUNT(*)
            FROM register_pmb
            WHERE status_pendaftaran IN (
                'MENUNGGU_SELEKSI',
                'SELEKSI'
            )
        ")
         ->fetchColumn();


   $totalLulus =
      (int) $pdo
         ->query("
            SELECT COUNT(*)
            FROM register_pmb
            WHERE status_pendaftaran = 'LULUS'
        ")
         ->fetchColumn();
} catch (Throwable $e) {
}


/**
 * =========================================================
 * PAGE
 * =========================================================
 */

$pageTitle =
   'Data Peserta PMB';


?>
<!DOCTYPE html>

<html lang="id">


<head>

   <meta charset="UTF-8">

   <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0">


   <title>
      <?= h($pageTitle) ?> - Admin PMB
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


      /**
         * =====================================================
         * LAYOUT
         * =====================================================
         */

      .admin-layout {

         min-height: 100vh;

      }


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

         padding:
            11px 13px;

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


      .admin-main {

         margin-left: 260px;

         min-height: 100vh;

      }


      .admin-topbar {

         height: 82px;

         background: #fff;

         border-bottom:
            1px solid #e9edf2;

         padding:
            0 35px;

         display: flex;

         align-items: center;

         justify-content: space-between;

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


      /**
         * =====================================================
         * STAT
         * =====================================================
         */

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


      /**
         * =====================================================
         * MAIN CARD
         * =====================================================
         */

      .data-card {

         background: #fff;

         border:
            1px solid #edf0f3;

         border-radius: 13px;

         overflow: hidden;

      }


      .data-card-header {

         padding:
            22px;

         border-bottom:
            1px solid #edf0f3;

      }


      /**
         * =====================================================
         * SEARCH
         * =====================================================
         */

      .search-input {

         height: 44px;

         border:
            1px solid #e1e5ea;

         border-radius: 9px;

         padding-left: 40px;

         font-size: 13px;

      }


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


      .filter-select {

         height: 44px;

         border:
            1px solid #e1e5ea;

         border-radius: 9px;

         font-size: 13px;

      }


      /**
         * =====================================================
         * TABLE
         * =====================================================
         */

      .participant-table {

         margin: 0;

      }


      .participant-table thead th {

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


      .participant-table tbody td {

         padding:
            14px 15px;

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


      .participant-contact {

         font-size: 11px;

      }


      .participant-contact div {

         margin-bottom: 2px;

      }


      .participant-contact i {

         width: 15px;

         color: #9299a3;

      }


      .status-badge {

         font-size: 9px;

         border-radius: 20px;

         padding:
            5px 9px;

         font-weight: 700;

         white-space: nowrap;

      }


      .action-button {

         width: 34px;

         height: 34px;

         display: inline-flex;

         align-items: center;

         justify-content: center;

      }


      /**
         * =====================================================
         * PAGINATION
         * =====================================================
         */

      .pagination-wrapper {

         padding:
            18px 22px;

         border-top:
            1px solid #edf0f3;

         display: flex;

         align-items: center;

         justify-content: space-between;

         gap: 15px;

      }


      .pagination-info {

         color: #9299a3;

         font-size: 11px;

      }


      .page-link {

         font-size: 12px;

         border-radius: 7px !important;

         margin: 0 2px;

      }


      /**
         * =====================================================
         * RESPONSIVE
         * =====================================================
         */

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


         .admin-layout {

            display: block;

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

            height: auto;

            padding:
               18px 20px;

         }


         .admin-content {

            padding: 20px 15px;

         }


         .pagination-wrapper {

            flex-direction: column;

            align-items: flex-start;

         }

      }
   </style>

</head>


<body>


   <div class="admin-layout">


      <!-- =====================================================
         SIDEBAR
    ====================================================== -->

      <?php
      require 'sidebar.php';
      ?>


      <!-- =====================================================
         MAIN
    ====================================================== -->

      <main class="admin-main">


         <!-- TOPBAR -->

         <header class="admin-topbar">


            <div>

               <h1 class="admin-page-title">

                  Data Peserta

               </h1>


               <div class="admin-page-subtitle">

                  Kelola seluruh peserta Penerimaan
                  Mahasiswa Baru

               </div>

            </div>


            <div
               class="d-flex align-items-center">


               <div
                  class="admin-avatar">

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


               <div
                  class="d-none d-md-block">

                  <div
                     class="fw-bold fs-13">

                     <?= h($adminName) ?>

                  </div>


                  <div
                     class="text-muted fs-11">

                     Administrator

                  </div>

               </div>

            </div>


         </header>


         <!-- CONTENT -->

         <div class="admin-content">


            <!-- =================================================
                 STATISTICS
            ================================================== -->

            <div class="row g-4 mb-5">


               <div class="col-6 col-xl-3">


                  <div class="stat-card">


                     <div
                        class="stat-icon bg-soft-primary text-primary">

                        <i class="uil uil-users-alt"></i>

                     </div>


                     <div class="stat-label">

                        Total Peserta

                     </div>


                     <div class="stat-value">

                        <?= number_format(
                           $totalPeserta
                        ) ?>

                     </div>


                  </div>

               </div>


               <div class="col-6 col-xl-3">


                  <div class="stat-card">


                     <div
                        class="stat-icon bg-soft-green text-green">

                        <i class="uil uil-user-check"></i>

                     </div>


                     <div class="stat-label">

                        Akun Aktif

                     </div>


                     <div class="stat-value">

                        <?= number_format(
                           $totalAktif
                        ) ?>

                     </div>


                  </div>

               </div>


               <div class="col-6 col-xl-3">


                  <div class="stat-card">


                     <div
                        class="stat-icon bg-soft-yellow text-yellow">

                        <i class="uil uil-clipboard-alt"></i>

                     </div>


                     <div class="stat-label">

                        Sedang Seleksi

                     </div>


                     <div class="stat-value">

                        <?= number_format(
                           $totalSeleksi
                        ) ?>

                     </div>


                  </div>

               </div>


               <div class="col-6 col-xl-3">


                  <div class="stat-card">


                     <div
                        class="stat-icon bg-soft-green text-green">

                        <i class="uil uil-award"></i>

                     </div>


                     <div class="stat-label">

                        Lulus

                     </div>


                     <div class="stat-value">

                        <?= number_format(
                           $totalLulus
                        ) ?>

                     </div>


                  </div>

               </div>


            </div>


            <!-- =================================================
                 DATA CARD
            ================================================== -->

            <div class="data-card">


               <!-- HEADER -->

               <div class="data-card-header">


                  <div
                     class="d-flex
                        justify-content-between
                        align-items-center
                        mb-4">


                     <div>


                        <h4
                           class="mb-1"
                           style="
                                    font-size:17px;
                                    font-weight:800;
                                ">

                           Daftar Peserta PMB

                        </h4>


                        <p
                           class="text-muted
                                mb-0
                                fs-12">

                           Menampilkan
                           <?= number_format(
                              $totalData
                           ) ?>
                           peserta

                        </p>


                     </div>


                     <a
                        href="./peserta.php"
                        class="btn btn-sm btn-outline-secondary rounded">

                        <i
                           class="uil uil-refresh me-1">
                        </i>

                        Refresh

                     </a>


                  </div>


                  <!-- =================================================
                         FILTER
                    ================================================== -->

                  <form
                     method="GET"
                     action="./peserta.php">


                     <div
                        class="row g-3">


                        <!-- SEARCH -->

                        <div
                           class="col-lg-5">


                           <div
                              class="search-wrapper">


                              <i
                                 class="uil uil-search">
                              </i>


                              <input
                                 type="text"
                                 name="search"
                                 value="<?= h($search) ?>"
                                 class="form-control search-input"
                                 placeholder="Cari nama, NIK, ID pendaftaran, email...">


                           </div>

                        </div>


                        <!-- STATUS -->

                        <div
                           class="col-lg-3">


                           <select
                              name="status"
                              class="form-select filter-select">


                              <option
                                 value="">

                                 Semua Status

                              </option>


                              <option
                                 value="REGISTRASI"
                                 <?= $status === 'REGISTRASI'
                                    ? 'selected'
                                    : '' ?>>

                                 Registrasi

                              </option>


                              <option
                                 value="DATA_DOKUMEN"
                                 <?= $status === 'DATA_DOKUMEN'
                                    ? 'selected'
                                    : '' ?>>

                                 Data & Dokumen

                              </option>


                              <option
                                 value="MENUNGGU_SELEKSI"
                                 <?= $status === 'MENUNGGU_SELEKSI'
                                    ? 'selected'
                                    : '' ?>>

                                 Menunggu Seleksi

                              </option>


                              <option
                                 value="SELEKSI"
                                 <?= $status === 'SELEKSI'
                                    ? 'selected'
                                    : '' ?>>

                                 Seleksi

                              </option>


                              <option
                                 value="LULUS"
                                 <?= $status === 'LULUS'
                                    ? 'selected'
                                    : '' ?>>

                                 Lulus

                              </option>


                              <option
                                 value="TIDAK_LULUS"
                                 <?= $status === 'TIDAK_LULUS'
                                    ? 'selected'
                                    : '' ?>>

                                 Tidak Lulus

                              </option>


                              <option
                                 value="DAFTAR_ULANG"
                                 <?= $status === 'DAFTAR_ULANG'
                                    ? 'selected'
                                    : '' ?>>

                                 Daftar Ulang

                              </option>


                              <option
                                 value="MAHASISWA"
                                 <?= $status === 'MAHASISWA'
                                    ? 'selected'
                                    : '' ?>>

                                 Mahasiswa

                              </option>


                           </select>

                        </div>


                        <!-- TAHAP -->

                        <div
                           class="col-lg-2">


                           <select
                              name="tahap"
                              class="form-select filter-select">


                              <option
                                 value="">

                                 Semua Tahap

                              </option>


                              <option
                                 value="1"
                                 <?= $tahap === '1'
                                    ? 'selected'
                                    : '' ?>>

                                 Tahap 01

                              </option>


                              <option
                                 value="2"
                                 <?= $tahap === '2'
                                    ? 'selected'
                                    : '' ?>>

                                 Tahap 02

                              </option>


                              <option
                                 value="3"
                                 <?= $tahap === '3'
                                    ? 'selected'
                                    : '' ?>>

                                 Tahap 03

                              </option>


                              <option
                                 value="4"
                                 <?= $tahap === '4'
                                    ? 'selected'
                                    : '' ?>>

                                 Tahap 04

                              </option>


                              <option
                                 value="5"
                                 <?= $tahap === '5'
                                    ? 'selected'
                                    : '' ?>>

                                 Tahap 05

                              </option>


                              <option
                                 value="6"
                                 <?= $tahap === '6'
                                    ? 'selected'
                                    : '' ?>>

                                 Tahap 06

                              </option>


                              <option
                                 value="7"
                                 <?= $tahap === '7'
                                    ? 'selected'
                                    : '' ?>>

                                 Tahap 07

                              </option>


                              <option
                                 value="8"
                                 <?= $tahap === '8'
                                    ? 'selected'
                                    : '' ?>>

                                 Tahap 08

                              </option>


                           </select>

                        </div>


                        <!-- BUTTON -->

                        <div
                           class="col-lg-2">


                           <button
                              type="submit"
                              class="btn btn-primary rounded w-100"
                              style="height:44px;">

                              <i
                                 class="uil uil-search me-1">
                              </i>

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


                  <table
                     class="table participant-table">


                     <thead>

                        <tr>

                           <th>
                              #
                           </th>

                           <th>
                              Peserta
                           </th>

                           <th>
                              Identitas
                           </th>

                           <th>
                              Kontak
                           </th>

                           <th>
                              Jalur
                           </th>

                           <th>
                              Tahap
                           </th>

                           <th>
                              Status
                           </th>

                           <th
                              class="text-center">

                              Aksi

                           </th>

                        </tr>

                     </thead>


                     <tbody>


                        <?php if (
                           empty($peserta)
                        ): ?>


                           <tr>

                              <td
                                 colspan="8"
                                 class="text-center py-6">

                                 <div
                                    class="text-muted">

                                    <i
                                       class="uil uil-users-alt"
                                       style="
                                                    font-size:40px;
                                                    opacity:.35;
                                                ">
                                    </i>


                                    <div
                                       class="mt-2">

                                       Data peserta
                                       tidak ditemukan.

                                    </div>

                                 </div>

                              </td>

                           </tr>


                        <?php else: ?>


                           <?php

                           $no =
                              $offset + 1;

                           ?>


                           <?php foreach (
                              $peserta
                              as $row
                           ): ?>


                              <?php

                              $statusPeserta =
                                 $row['status_pendaftaran'] ?: 'REGISTRASI';


                              $statusColor =
                                 statusClass(
                                    $statusPeserta
                                 );

                              ?>


                              <tr>


                                 <!-- NO -->

                                 <td>

                                    <?= $no++ ?>

                                 </td>


                                 <!-- PESERTA -->

                                 <td>


                                    <div
                                       class="participant-name">

                                       <?= h(
                                          $row['fullname']
                                       ) ?>

                                    </div>


                                    <div
                                       class="participant-id">

                                       <?= h(
                                          $row['register_uid'] ?: '-'
                                       ) ?>

                                    </div>

                                 </td>


                                 <!-- IDENTITAS -->

                                 <td>


                                    <div
                                       class="participant-contact">


                                       <div>

                                          <i
                                             class="uil uil-card-atm">
                                          </i>

                                          <?= h(
                                             $row['number_id'] ?: '-'
                                          ) ?>

                                       </div>


                                       <div>

                                          <i
                                             class="uil uil-user">
                                          </i>

                                          <?= h(
                                             $row['gender'] ?: '-'
                                          ) ?>

                                       </div>


                                    </div>


                                 </td>


                                 <!-- KONTAK -->

                                 <td>


                                    <div
                                       class="participant-contact">


                                       <div>

                                          <i
                                             class="uil uil-phone">
                                          </i>

                                          <?= h(
                                             $row['phone_number'] ?: '-'
                                          ) ?>

                                       </div>


                                       <div>

                                          <i
                                             class="uil uil-envelope">
                                          </i>

                                          <?= h(
                                             $row['email_register'] ?: '-'
                                          ) ?>

                                       </div>


                                    </div>


                                 </td>


                                 <!-- JALUR -->

                                 <td>

                                    <span
                                       class="badge bg-soft-secondary text-secondary">

                                       <?= h(
                                          $row['register_type'] ?: '-'
                                       ) ?>

                                    </span>

                                 </td>


                                 <!-- TAHAP -->

                                 <td>


                                    <span
                                       class="badge bg-soft-primary text-primary">

                                       Tahap
                                       <?= (int)
                                       $row['tahap_aktif'] ?>

                                    </span>


                                 </td>


                                 <!-- STATUS -->

                                 <td>


                                    <span
                                       class="
                                                badge
                                                bg-soft-<?= h(
                                                            $statusColor
                                                         ) ?>
                                                text-<?= h(
                                                         $statusColor
                                                      ) ?>
                                                status-badge">

                                       <?= h(
                                          $statusPeserta
                                       ) ?>

                                    </span>


                                 </td>


                                 <!-- ACTION -->

                                 <td
                                    class="text-center">


                                    <a
                                       href="./peserta-detail?id=<?= (int) $row['id'] ?>"
                                       class="btn btn-sm btn-soft-primary rounded action-button"
                                       title="Lihat detail">

                                       <i
                                          class="uil uil-eye">
                                       </i>

                                    </a>


                                 </td>


                              </tr>


                           <?php endforeach; ?>


                        <?php endif; ?>


                     </tbody>

                  </table>

               </div>


               <!-- =================================================
                     PAGINATION
                ================================================== -->

               <?php if (
                  $totalData > 0
               ): ?>


                  <div
                     class="pagination-wrapper">


                     <div
                        class="pagination-info">

                        Menampilkan

                        <?= number_format(
                           $offset + 1
                        ) ?>

                        -

                        <?= number_format(
                           min(
                              $offset + $perPage,
                              $totalData
                           )
                        ) ?>

                        dari

                        <?= number_format(
                           $totalData
                        ) ?>

                        peserta

                     </div>


                     <?php if (
                        $totalPages > 1
                     ): ?>


                        <nav>


                           <ul
                              class="pagination pagination-sm mb-0">


                              <!-- PREVIOUS -->

                              <li
                                 class="page-item
                                        <?= $page <= 1
                                             ? 'disabled'
                                             : '' ?>">


                                 <?php if (
                                    $page > 1
                                 ): ?>


                                    <a
                                       class="page-link"
                                       href="?<?= http_build_query([
                                                   'search' => $search,
                                                   'status' => $status,
                                                   'tahap' => $tahap,
                                                   'page' => $page - 1
                                                ]) ?>">

                                       <i
                                          class="uil uil-angle-left">
                                       </i>

                                    </a>


                                 <?php else: ?>


                                    <span
                                       class="page-link">

                                       <i
                                          class="uil uil-angle-left">
                                       </i>

                                    </span>


                                 <?php endif; ?>


                              </li>


                              <!-- PAGE NUMBERS -->

                              <?php

                              $startPage =
                                 max(
                                    1,
                                    $page - 2
                                 );


                              $endPage =
                                 min(
                                    $totalPages,
                                    $page + 2
                                 );

                              ?>


                              <?php for (
                                 $i = $startPage;
                                 $i <= $endPage;
                                 $i++
                              ): ?>


                                 <li
                                    class="page-item
                                            <?= $i === $page
                                                ? 'active'
                                                : '' ?>">


                                    <a
                                       class="page-link"
                                       href="?<?= http_build_query([
                                                   'search' => $search,
                                                   'status' => $status,
                                                   'tahap' => $tahap,
                                                   'page' => $i
                                                ]) ?>">

                                       <?= $i ?>

                                    </a>


                                 </li>


                              <?php endfor; ?>


                              <!-- NEXT -->

                              <li
                                 class="page-item
                                        <?= $page >= $totalPages
                                             ? 'disabled'
                                             : '' ?>">


                                 <?php if (
                                    $page <
                                    $totalPages
                                 ): ?>


                                    <a
                                       class="page-link"
                                       href="?<?= http_build_query([
                                                   'search' => $search,
                                                   'status' => $status,
                                                   'tahap' => $tahap,
                                                   'page' => $page + 1
                                                ]) ?>">

                                       <i
                                          class="uil uil-angle-right">
                                       </i>

                                    </a>


                                 <?php else: ?>


                                    <span
                                       class="page-link">

                                       <i
                                          class="uil uil-angle-right">
                                       </i>

                                    </span>


                                 <?php endif; ?>


                              </li>


                           </ul>

                        </nav>


                     <?php endif; ?>


                  </div>


               <?php endif; ?>


            </div>


         </div>


      </main>


   </div>


</body>

</html>