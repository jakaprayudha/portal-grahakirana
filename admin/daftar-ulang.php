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
 * POST ACTION
 * =========================================================
 */

if (
   $_SERVER['REQUEST_METHOD'] === 'POST'
) {

   $action =
      $_POST['action'] ?? '';

   $id =
      filter_input(
         INPUT_POST,
         'id',
         FILTER_VALIDATE_INT
      );


   if (
      !$id ||
      $id < 1
   ) {

      $errorMessage =
         'ID peserta tidak valid.';
   } else {

      try {

         /**
          * =================================================
          * AMBIL PESERTA
          * =================================================
          */

         $check =
            $pdo->prepare("

                    SELECT

                        id,
                        fullname,
                        register_uid,
                        status_pendaftaran,
                        status_kelulusan,
                        tahap_aktif

                    FROM register_pmb

                    WHERE id = :id

                    LIMIT 1

                ");


         $check->execute([
            'id' => $id
         ]);


         $peserta =
            $check->fetch(
               PDO::FETCH_ASSOC
            );


         if (!$peserta) {

            throw new Exception(
               'Peserta tidak ditemukan.'
            );
         }


         /**
          * =================================================
          * LULUS → DAFTAR ULANG
          * =================================================
          */

         if (
            $action ===
            'proses_daftar_ulang'
         ) {


            if (
               $peserta['status_kelulusan'] !== 'LULUS'
            ) {

               throw new Exception(
                  'Peserta belum berstatus LULUS.'
               );
            }


            $stmt =
               $pdo->prepare("

                        UPDATE register_pmb

                        SET

                            status_pendaftaran =
                                'DAFTAR_ULANG',

                            tahap_aktif =
                                6,

                            updated_at =
                                NOW()

                        WHERE id = :id

                        LIMIT 1

                    ");


            $stmt->execute([
               'id' => $id
            ]);


            $successMessage =
               'Peserta '
               .
               $peserta['fullname']
               .
               ' berhasil dipindahkan ke tahap daftar ulang.';


            /**
             * =================================================
             * DAFTAR ULANG → MAHASISWA
             * =================================================
             */
         } elseif (
            $action ===
            'konfirmasi_mahasiswa'
         ) {


            if (
               $peserta['status_pendaftaran'] !== 'DAFTAR_ULANG'
            ) {

               throw new Exception(
                  'Peserta belum berada pada tahap daftar ulang.'
               );
            }


            $stmt =
               $pdo->prepare("

                        UPDATE register_pmb

                        SET

                            status_pendaftaran =
                                'MAHASISWA',

                            tahap_aktif =
                                7,

                            updated_at =
                                NOW()

                        WHERE id = :id

                        LIMIT 1

                    ");


            $stmt->execute([
               'id' => $id
            ]);


            $successMessage =
               'Peserta '
               .
               $peserta['fullname']
               .
               ' berhasil dikonfirmasi sebagai mahasiswa.';


            /**
             * =================================================
             * DAFTAR ULANG → LULUS
             * =================================================
             */
         } elseif (
            $action ===
            'kembalikan_lulus'
         ) {


            if (
               $peserta['status_pendaftaran'] !== 'DAFTAR_ULANG'
            ) {

               throw new Exception(
                  'Peserta bukan berada pada status daftar ulang.'
               );
            }


            $stmt =
               $pdo->prepare("

                        UPDATE register_pmb

                        SET

                            status_pendaftaran =
                                'LULUS',

                            tahap_aktif =
                                5,

                            updated_at =
                                NOW()

                        WHERE id = :id

                        LIMIT 1

                    ");


            $stmt->execute([
               'id' => $id
            ]);


            $successMessage =
               'Status peserta '
               .
               $peserta['fullname']
               .
               ' dikembalikan menjadi LULUS.';
         } else {

            throw new Exception(
               'Aksi tidak dikenali.'
            );
         }
      } catch (
         Throwable $e
      ) {

         $errorMessage =
            $e->getMessage();
      }
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


/**
 * =========================================================
 * WHERE
 * =========================================================
 */

$where = [];

$params = [];


/**
 * Hanya peserta yang sudah
 * lulus dan proses setelahnya.
 */

$where[] = "

    (

        status_kelulusan = 'LULUS'

        OR

        status_pendaftaran IN (
            'DAFTAR_ULANG',
            'MAHASISWA'
        )

    )

";


if (
   $search !== ''
) {

   $where[] = "

        (

            fullname LIKE :search

            OR register_uid LIKE :search

            OR number_id LIKE :search

            OR email_register LIKE :search

        )

    ";


   $params['search'] =
      '%' .
      $search .
      '%';
}


if (
   $status !== ''
) {

   $where[] =
      "status_pendaftaran = :status";


   $params['status'] =
      $status;
}


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

$peserta = [];


try {

   $stmt =
      $pdo->prepare("

            SELECT

                id,

                register_uid,

                fullname,

                number_id,

                phone_number,

                email_register,

                register_type,

                id_program,

                jenis_pembiayaan,

                tahap_aktif,

                status_pendaftaran,

                status_kelulusan,

                nilai_tpa,

                nilai_wawancara,

                nilai_akhir,

                catatan_hasil,

                hasil_diumumkan_at,

                created_at,

                updated_at

            FROM register_pmb

            $whereSql

            ORDER BY

                CASE

                    WHEN
                        status_pendaftaran =
                        'DAFTAR_ULANG'

                    THEN 1

                    WHEN
                        status_pendaftaran =
                        'LULUS'

                    THEN 2

                    WHEN
                        status_pendaftaran =
                        'MAHASISWA'

                    THEN 3

                    ELSE 4

                END,

                id DESC

        ");


   $stmt->execute(
      $params
   );


   $peserta =
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

$totalLulus = 0;
$totalDaftarUlang = 0;
$totalMahasiswa = 0;


try {

   $totalLulus =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE
                status_pendaftaran =
                'LULUS'

        ")
         ->fetchColumn();


   $totalDaftarUlang =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE
                status_pendaftaran =
                'DAFTAR_ULANG'

        ")
         ->fetchColumn();


   $totalMahasiswa =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE
                status_pendaftaran =
                'MAHASISWA'

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
   'Daftar Ulang';

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


      .score-final {

         color: #0d6efd;

         font-size: 14px;

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

   <aside class="admin-sidebar">


      <div class="admin-brand">

         <div class="admin-brand-icon">

            <i class="uil uil-shield-check"></i>

         </div>


         <div>

            <div class="admin-brand-name">

               ADMIN PMB

            </div>


            <div class="admin-brand-sub">

               Portal Administrasi

            </div>

         </div>

      </div>


      <nav class="admin-nav">


         <div class="admin-nav-label">

            Menu Utama

         </div>


         <a
            href="./dashboard.php"
            class="admin-nav-link">

            <i class="uil uil-dashboard"></i>

            Dashboard

         </a>


         <a
            href="./peserta.php"
            class="admin-nav-link">

            <i class="uil uil-users-alt"></i>

            Data Peserta

         </a>


         <a
            href="./seleksi.php"
            class="admin-nav-link">

            <i class="uil uil-clipboard-alt"></i>

            Seleksi

         </a>


         <a
            href="./hasil-seleksi.php"
            class="admin-nav-link">

            <i class="uil uil-award"></i>

            Hasil Seleksi

         </a>


         <a
            href="./daftar-ulang.php"
            class="admin-nav-link active">

            <i class="uil uil-user-check"></i>

            Daftar Ulang

         </a>


         <div class="admin-nav-label mt-5">

            Akademik

         </div>


         <a
            href="./mahasiswa.php"
            class="admin-nav-link">

            <i class="uil uil-graduation-cap"></i>

            Mahasiswa

         </a>


         <a
            href="./ktm.php"
            class="admin-nav-link">

            <i class="uil uil-card-atm"></i>

            KTM

         </a>


         <a
            href="./krs.php"
            class="admin-nav-link">

            <i class="uil uil-book-open"></i>

            KRS

         </a>


      </nav>


      <div class="admin-sidebar-footer">


         <div class="admin-user-mini">


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


            <div>

               <div
                  style="
                        font-size:12px;
                        font-weight:700;
                        color:#30363d;
                    ">

                  <?= h(
                     $adminName
                  ) ?>

               </div>


               <div
                  style="
                        font-size:10px;
                        color:#9299a3;
                        text-transform:uppercase;
                    ">

                  <?= h(
                     $adminRole
                  ) ?>

               </div>

            </div>

         </div>


         <a
            href="../controllers/admin/logout.php"
            class="btn btn-outline-danger btn-sm rounded w-100">

            <i
               class="uil uil-sign-out-alt me-1">
            </i>

            Keluar

         </a>


      </div>


   </aside>


   <!-- =========================================================
     MAIN
========================================================== -->

   <main class="admin-main">


      <!-- TOPBAR -->

      <header class="admin-topbar">


         <div>

            <h1 class="admin-page-title">

               Daftar Ulang

            </h1>


            <div class="admin-page-subtitle">

               Pengelolaan peserta lulus menuju mahasiswa

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

                  <?= h(
                     $adminName
                  ) ?>

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
             ALERT
        ================================================== -->

         <?php if (
            $successMessage !== ''
         ): ?>


            <div
               class="alert alert-success alert-icon mb-4">

               <i
                  class="uil uil-check-circle">
               </i>

               <?= h(
                  $successMessage
               ) ?>

            </div>


         <?php endif; ?>


         <?php if (
            $errorMessage !== ''
         ): ?>


            <div
               class="alert alert-danger alert-icon mb-4">

               <i
                  class="uil uil-times-circle">
               </i>

               <?= h(
                  $errorMessage
               ) ?>

            </div>


         <?php endif; ?>


         <!-- =================================================
             STATS
        ================================================== -->

         <div class="row g-4 mb-5">


            <div class="col-6 col-xl-3">


               <div class="stat-card">


                  <div
                     class="stat-icon bg-soft-primary text-primary">

                     <i
                        class="uil uil-award">
                     </i>

                  </div>


                  <div class="stat-label">

                     Peserta Lulus

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalLulus
                     ) ?>

                  </div>


               </div>


            </div>


            <div class="col-6 col-xl-3">


               <div class="stat-card">


                  <div
                     class="stat-icon bg-soft-yellow text-yellow">

                     <i
                        class="uil uil-clock">
                     </i>

                  </div>


                  <div class="stat-label">

                     Proses Daftar Ulang

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalDaftarUlang
                     ) ?>

                  </div>


               </div>


            </div>


            <div class="col-6 col-xl-3">


               <div class="stat-card">


                  <div
                     class="stat-icon bg-soft-green text-green">

                     <i
                        class="uil uil-graduation-cap">
                     </i>

                  </div>


                  <div class="stat-label">

                     Mahasiswa

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalMahasiswa
                     ) ?>

                  </div>


               </div>


            </div>


            <div class="col-6 col-xl-3">


               <div class="stat-card">


                  <div
                     class="stat-icon bg-soft-primary text-primary">

                     <i
                        class="uil uil-user-check">
                     </i>

                  </div>


                  <div class="stat-label">

                     Total Proses

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalDaftarUlang
                           +
                           $totalMahasiswa
                     ) ?>

                  </div>


               </div>


            </div>


         </div>


         <!-- =================================================
             INFO
        ================================================== -->

         <div
            class="alert alert-primary alert-icon mb-5">


            <i
               class="uil uil-info-circle">
            </i>


            <div>


               <strong>

                  Alur Daftar Ulang

               </strong>


               <div
                  class="mt-1 fs-13">

                  Peserta dengan hasil
                  <strong>LULUS</strong>
                  dipindahkan ke tahap
                  <strong>DAFTAR ULANG</strong>.

                  Setelah proses daftar ulang dinyatakan lengkap,
                  admin dapat mengonfirmasi peserta menjadi
                  <strong>MAHASISWA</strong>.

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
                  class="
                    d-flex
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

                        Peserta Daftar Ulang

                     </h4>


                     <p
                        class="text-muted mb-0 fs-12">

                        Kelola status peserta setelah dinyatakan lulus.

                     </p>


                  </div>


                  <a
                     href="./daftar-ulang.php"
                     class="btn btn-sm btn-outline-secondary rounded">


                     <i
                        class="uil uil-refresh me-1">
                     </i>


                     Refresh


                  </a>


               </div>


               <!-- FILTER -->

               <form
                  method="GET"
                  action="./daftar-ulang.php">


                  <div
                     class="row g-3">


                     <div
                        class="col-lg-7">


                        <div
                           class="search-wrapper">


                           <i
                              class="uil uil-search">
                           </i>


                           <input
                              type="text"
                              name="search"
                              value="<?= h(
                                          $search
                                       ) ?>"
                              class="form-control search-input"
                              placeholder="Cari nama, ID pendaftaran, NIK atau email...">


                        </div>


                     </div>


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
                              value="LULUS"
                              <?= $status ===
                                 'LULUS'
                                 ? 'selected'
                                 : '' ?>>

                              Lulus

                           </option>


                           <option
                              value="DAFTAR_ULANG"
                              <?= $status ===
                                 'DAFTAR_ULANG'
                                 ? 'selected'
                                 : '' ?>>

                              Daftar Ulang

                           </option>


                           <option
                              value="MAHASISWA"
                              <?= $status ===
                                 'MAHASISWA'
                                 ? 'selected'
                                 : '' ?>>

                              Mahasiswa

                           </option>


                        </select>


                     </div>


                     <div
                        class="col-lg-2">


                        <button
                           type="submit"
                           class="btn btn-primary rounded w-100"
                           style="
                                    height:44px;
                                ">


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

            <div
               class="table-responsive">


               <table
                  class="table data-table">


                  <thead>


                     <tr>


                        <th>
                           #
                        </th>


                        <th>
                           Peserta
                        </th>


                        <th>
                           Program
                        </th>


                        <th>
                           Nilai Akhir
                        </th>


                        <th>
                           Status
                        </th>


                        <th>
                           Tahap
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
                              colspan="7"
                              class="text-center py-6">


                              <div
                                 class="text-muted">


                                 <i
                                    class="uil uil-user-check"
                                    style="
                                            font-size:42px;
                                            opacity:.35;
                                        ">
                                 </i>


                                 <div
                                    class="mt-2">

                                    Belum ada peserta
                                    pada proses daftar ulang.

                                 </div>


                              </div>


                           </td>


                        </tr>


                     <?php else: ?>


                        <?php

                        $no = 1;

                        ?>


                        <?php foreach (
                           $peserta
                           as $row
                        ): ?>


                           <?php

                           $statusRow =
                              $row['status_pendaftaran']
                              ?: 'LULUS';


                           $statusColor =
                              'secondary';


                           if (
                              $statusRow ===
                              'LULUS'
                           ) {

                              $statusColor =
                                 'primary';
                           } elseif (
                              $statusRow ===
                              'DAFTAR_ULANG'
                           ) {

                              $statusColor =
                                 'warning';
                           } elseif (
                              $statusRow ===
                              'MAHASISWA'
                           ) {

                              $statusColor =
                                 'success';
                           }


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
                                       $row['register_uid']
                                          ?: '-'
                                    ) ?>

                                 </div>


                                 <div
                                    class="participant-id">

                                    <?= h(
                                       $row['phone_number']
                                          ?: '-'
                                    ) ?>

                                 </div>


                              </td>


                              <!-- PROGRAM -->

                              <td>


                                 <div
                                    class="participant-name">

                                    Program #<?= (int)
                                             $row['id_program'] ?>

                                 </div>


                                 <div
                                    class="participant-id">

                                    <?= h(
                                       $row['register_type']
                                          ?: '-'
                                    ) ?>

                                 </div>


                              </td>


                              <!-- NILAI -->

                              <td>


                                 <span
                                    class="score-final">


                                    <?= $row['nilai_akhir'] !== null

                                       ? number_format(
                                          (float)
                                          $row['nilai_akhir'],
                                          2,
                                          ',',
                                          '.'
                                       )

                                       : '-'
                                    ?>


                                 </span>


                              </td>


                              <!-- STATUS -->

                              <td>


                                 <span
                                    class="
                                        badge
                                        bg-soft-<?= $statusColor ?>
                                        text-<?= $statusColor ?>">

                                    <?php

                                    if (
                                       $statusRow ===
                                       'DAFTAR_ULANG'
                                    ) {

                                       echo 'Daftar Ulang';
                                    } elseif (
                                       $statusRow ===
                                       'MAHASISWA'
                                    ) {

                                       echo 'Mahasiswa';
                                    } else {

                                       echo 'Lulus';
                                    }

                                    ?>

                                 </span>


                              </td>


                              <!-- TAHAP -->

                              <td>


                                 <span
                                    class="
                                        badge
                                        bg-soft-primary
                                        text-primary">

                                    Tahap
                                    <?= (int)
                                    $row['tahap_aktif'] ?>

                                 </span>


                              </td>


                              <!-- ACTION -->

                              <td
                                 class="text-center">


                                 <div
                                    class="action-group">


                                    <!-- DETAIL -->

                                    <a
                                       href="./peserta-detail.php?id=<?= (int)
                                                                     $row['id'] ?>"
                                       class="
                                            btn
                                            btn-sm
                                            btn-soft-primary
                                            rounded"
                                       title="Lihat Detail">


                                       <i
                                          class="uil uil-eye">
                                       </i>


                                    </a>


                                    <!-- LULUS → DAFTAR ULANG -->

                                    <?php if (
                                       $statusRow ===
                                       'LULUS'
                                    ): ?>


                                       <form
                                          method="POST"
                                          action="./daftar-ulang.php"
                                          onsubmit="
                                                    return confirm(
                                                        'Pindahkan peserta ini ke tahap daftar ulang?'
                                                    );
                                                ">


                                          <input
                                             type="hidden"
                                             name="action"
                                             value="proses_daftar_ulang">


                                          <input
                                             type="hidden"
                                             name="id"
                                             value="<?= (int)
                                                      $row['id'] ?>">


                                          <button
                                             type="submit"
                                             class="
                                                    btn
                                                    btn-sm
                                                    btn-primary
                                                    rounded"
                                             title="Proses Daftar Ulang">


                                             <i
                                                class="uil uil-arrow-right">
                                             </i>


                                          </button>


                                       </form>


                                       <!-- DAFTAR ULANG → MAHASISWA -->

                                    <?php elseif (
                                       $statusRow ===
                                       'DAFTAR_ULANG'
                                    ): ?>


                                       <form
                                          method="POST"
                                          action="./daftar-ulang.php"
                                          onsubmit="
                                                    return confirm(
                                                        'Konfirmasi peserta ini menjadi mahasiswa?'
                                                    );
                                                ">


                                          <input
                                             type="hidden"
                                             name="action"
                                             value="konfirmasi_mahasiswa">


                                          <input
                                             type="hidden"
                                             name="id"
                                             value="<?= (int)
                                                      $row['id'] ?>">


                                          <button
                                             type="submit"
                                             class="
                                                    btn
                                                    btn-sm
                                                    btn-success
                                                    rounded"
                                             title="Konfirmasi Mahasiswa">


                                             <i
                                                class="uil uil-graduation-cap">
                                             </i>


                                          </button>


                                       </form>


                                       <!-- KEMBALIKAN -->

                                       <form
                                          method="POST"
                                          action="./daftar-ulang.php"
                                          onsubmit="
                                                    return confirm(
                                                        'Kembalikan status peserta menjadi LULUS?'
                                                    );
                                                ">


                                          <input
                                             type="hidden"
                                             name="action"
                                             value="kembalikan_lulus">


                                          <input
                                             type="hidden"
                                             name="id"
                                             value="<?= (int)
                                                      $row['id'] ?>">


                                          <button
                                             type="submit"
                                             class="
                                                    btn
                                                    btn-sm
                                                    btn-soft-secondary
                                                    rounded"
                                             title="Kembalikan ke Lulus">


                                             <i
                                                class="uil uil-arrow-left">
                                             </i>


                                          </button>


                                       </form>


                                    <?php else: ?>


                                       <span
                                          class="
                                                badge
                                                bg-soft-green
                                                text-green">


                                          <i
                                             class="uil uil-check-circle me-1">
                                          </i>


                                          Selesai


                                       </span>


                                    <?php endif; ?>


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