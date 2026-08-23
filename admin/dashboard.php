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

$adminId =
   (int) $_SESSION['admin_user_id'];

$adminName =
   $_SESSION['admin_fullname'] ??
   $_SESSION['admin_username'] ??
   'Administrator';

$adminUsername =
   $_SESSION['admin_username'] ??
   '-';

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


/**
 * =========================================================
 * STATISTIK PMB
 * =========================================================
 */

$totalPeserta = 0;
$totalRegistrasi = 0;
$totalDokumen = 0;
$totalSeleksi = 0;
$totalLulus = 0;
$totalTidakLulus = 0;
$totalDaftarUlang = 0;
$totalMahasiswa = 0;


try {

   /**
    * TOTAL PESERTA
    */

   $stmt =
      $pdo->query("
            SELECT COUNT(*) 
            FROM register_pmb
        ");

   $totalPeserta =
      (int) $stmt->fetchColumn();


   /**
    * REGISTRASI
    */

   $stmt =
      $pdo->query("
            SELECT COUNT(*)
            FROM register_pmb
            WHERE status_pendaftaran = 'REGISTRASI'
        ");

   $totalRegistrasi =
      (int) $stmt->fetchColumn();


   /**
    * DATA DOKUMEN
    */

   $stmt =
      $pdo->query("
            SELECT COUNT(*)
            FROM register_pmb
            WHERE status_pendaftaran = 'DATA_DOKUMEN'
        ");

   $totalDokumen =
      (int) $stmt->fetchColumn();


   /**
    * SELEKSI
    *
    * Termasuk MENUNGGU_SELEKSI dan SELEKSI
    */

   $stmt =
      $pdo->query("
            SELECT COUNT(*)
            FROM register_pmb
            WHERE status_pendaftaran IN (
                'MENUNGGU_SELEKSI',
                'SELEKSI'
            )
        ");

   $totalSeleksi =
      (int) $stmt->fetchColumn();


   /**
    * LULUS
    */

   $stmt =
      $pdo->query("
            SELECT COUNT(*)
            FROM register_pmb
            WHERE status_pendaftaran = 'LULUS'
        ");

   $totalLulus =
      (int) $stmt->fetchColumn();


   /**
    * TIDAK LULUS
    */

   $stmt =
      $pdo->query("
            SELECT COUNT(*)
            FROM register_pmb
            WHERE status_pendaftaran = 'TIDAK_LULUS'
        ");

   $totalTidakLulus =
      (int) $stmt->fetchColumn();


   /**
    * DAFTAR ULANG
    */

   $stmt =
      $pdo->query("
            SELECT COUNT(*)
            FROM register_pmb
            WHERE status_pendaftaran = 'DAFTAR_ULANG'
        ");

   $totalDaftarUlang =
      (int) $stmt->fetchColumn();


   /**
    * MAHASISWA
    */

   $stmt =
      $pdo->query("
            SELECT COUNT(*)
            FROM register_pmb
            WHERE status_pendaftaran = 'MAHASISWA'
        ");

   $totalMahasiswa =
      (int) $stmt->fetchColumn();
} catch (Throwable $e) {

   /**
    * Jangan tampilkan error database
    * ke dashboard production.
    */
}


/**
 * =========================================================
 * RECENT PARTICIPANTS
 * =========================================================
 */

$recentParticipants = [];


try {

   $stmt =
      $pdo->query("

            SELECT
                id,
                register_uid,
                fullname,
                email_register,
                register_type,
                tahap_aktif,
                status_pendaftaran,
                created_at

            FROM register_pmb

            ORDER BY id DESC

            LIMIT 8

        ");


   $recentParticipants =
      $stmt->fetchAll(
         PDO::FETCH_ASSOC
      );
} catch (Throwable $e) {

   $recentParticipants = [];
}


/**
 * =========================================================
 * STATUS BADGE
 * =========================================================
 */

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
 * PAGE
 * =========================================================
 */

$pageTitle =
   'Dashboard Admin';

?>
<!DOCTYPE html>

<html lang="id">

<head>

   <meta charset="UTF-8">

   <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0">


   <title>
      <?= h($pageTitle) ?> - Portal PMB
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


   <!-- Unicons -->

   <link
      rel="stylesheet"
      href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">


   <style>
      /**
         * =====================================================
         * GLOBAL
         * =====================================================
         */

      body {

         background: #f6f8fb;

      }


      .admin-layout {

         min-height: 100vh;

         display: flex;

      }


      /**
         * =====================================================
         * SIDEBAR
         * =====================================================
         */

      .admin-sidebar {

         width: 260px;

         min-width: 260px;

         min-height: 100vh;

         background: #ffffff;

         border-right:
            1px solid #e9edf2;

         position: fixed;

         left: 0;

         top: 0;

         bottom: 0;

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

         color: #ffffff;

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

         color: #20252b;

         font-size: 14px;

         line-height: 1.2;

      }


      .admin-brand-sub {

         color: #8c949e;

         font-size: 10px;

         margin-top: 3px;

      }


      .admin-nav {

         padding: 24px 15px;

         flex: 1;

      }


      .admin-nav-label {

         font-size: 10px;

         font-weight: 800;

         letter-spacing: 1px;

         color: #9aa1aa;

         text-transform: uppercase;

         padding:
            0 12px;

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

         transition: all .2s ease;

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

         min-width: 38px;

         border-radius: 50%;

         background: #eaf2ff;

         color: #0d6efd;

         display: flex;

         align-items: center;

         justify-content: center;

         margin-right: 10px;

         font-weight: 800;

         font-size: 13px;

      }


      .admin-user-name {

         font-size: 12px;

         font-weight: 700;

         color: #30363d;

      }


      .admin-user-role {

         font-size: 10px;

         color: #9299a3;

         text-transform: uppercase;

      }


      .admin-logout {

         width: 100%;

         display: flex;

         align-items: center;

         justify-content: center;

         gap: 7px;

      }


      /**
         * =====================================================
         * MAIN
         * =====================================================
         */

      .admin-main {

         margin-left: 260px;

         width:
            calc(100% - 260px);

         min-height: 100vh;

      }


      /**
         * =====================================================
         * TOPBAR
         * =====================================================
         */

      .admin-topbar {

         height: 82px;

         background: #ffffff;

         border-bottom:
            1px solid #e9edf2;

         display: flex;

         align-items: center;

         justify-content: space-between;

         padding:
            0 35px;

      }


      .admin-page-title {

         font-size: 20px;

         font-weight: 800;

         margin: 0;

         color: #20252b;

      }


      .admin-page-subtitle {

         font-size: 12px;

         color: #8c949e;

         margin-top: 3px;

      }


      .admin-top-user {

         display: flex;

         align-items: center;

      }


      .admin-top-avatar {

         width: 38px;

         height: 38px;

         border-radius: 50%;

         background: #eaf2ff;

         color: #0d6efd;

         display: flex;

         align-items: center;

         justify-content: center;

         font-weight: 800;

         margin-right: 10px;

      }


      /**
         * =====================================================
         * CONTENT
         * =====================================================
         */

      .admin-content {

         padding: 35px;

      }


      /**
         * =====================================================
         * WELCOME
         * =====================================================
         */

      .admin-welcome {

         background:
            linear-gradient(135deg,
               #173f75,
               #0d6efd);

         border-radius: 15px;

         padding:
            28px 30px;

         color: #ffffff;

         margin-bottom: 28px;

         position: relative;

         overflow: hidden;

      }


      .admin-welcome::after {

         content: "";

         position: absolute;

         width: 280px;

         height: 280px;

         border-radius: 50%;

         background:
            rgba(255,
               255,
               255,
               .07);

         right: -110px;

         top: -150px;

      }


      .admin-welcome-content {

         position: relative;

         z-index: 2;

      }


      .admin-welcome h3 {

         color: #ffffff;

         font-size: 23px;

         font-weight: 800;

         margin-bottom: 7px;

      }


      .admin-welcome p {

         color:
            rgba(255,
               255,
               255,
               .78);

         margin: 0;

         font-size: 13px;

      }


      /**
         * =====================================================
         * STAT CARDS
         * =====================================================
         */

      .admin-stat-card {

         background: #ffffff;

         border:
            1px solid #edf0f3;

         border-radius: 13px;

         padding: 20px;

         height: 100%;

         transition:
            transform .2s ease,
            box-shadow .2s ease;

      }


      .admin-stat-card:hover {

         transform:
            translateY(-3px);

         box-shadow:
            0 12px 30px rgba(20,
               40,
               80,
               .08);

      }


      .admin-stat-icon {

         width: 46px;

         height: 46px;

         border-radius: 11px;

         display: flex;

         align-items: center;

         justify-content: center;

         margin-bottom: 17px;

      }


      .admin-stat-icon i {

         font-size: 22px;

      }


      .admin-stat-label {

         font-size: 11px;

         color: #8d959e;

         text-transform: uppercase;

         font-weight: 700;

         letter-spacing: .4px;

      }


      .admin-stat-value {

         font-size: 28px;

         font-weight: 800;

         color: #20252b;

         margin-top: 4px;

      }


      /**
         * =====================================================
         * SECTION
         * =====================================================
         */

      .admin-section-card {

         background: #ffffff;

         border:
            1px solid #edf0f3;

         border-radius: 13px;

         overflow: hidden;

      }


      .admin-section-header {

         padding:
            20px 22px;

         border-bottom:
            1px solid #edf0f3;

         display: flex;

         align-items: center;

         justify-content: space-between;

      }


      .admin-section-header h5 {

         margin: 0;

         font-size: 15px;

         font-weight: 800;

      }


      .admin-section-header p {

         margin:
            4px 0 0;

         color: #9299a3;

         font-size: 11px;

      }


      /**
         * =====================================================
         * TABLE
         * =====================================================
         */

      .admin-table {

         margin: 0;

      }


      .admin-table thead th {

         background: #fafbfc;

         border-bottom:
            1px solid #edf0f3;

         color: #9299a3;

         font-size: 10px;

         text-transform: uppercase;

         letter-spacing: .5px;

         font-weight: 800;

         padding:
            13px 15px;

         white-space: nowrap;

      }


      .admin-table tbody td {

         padding:
            14px 15px;

         border-color: #f0f2f5;

         font-size: 12px;

         vertical-align: middle;

      }


      .admin-participant-name {

         font-weight: 700;

         color: #30363d;

      }


      .admin-participant-id {

         color: #9299a3;

         font-size: 10px;

         margin-top: 3px;

      }


      .admin-status {

         font-size: 10px;

         font-weight: 700;

         border-radius: 20px;

         padding:
            5px 9px;

      }


      /**
         * =====================================================
         * QUICK MENU
         * =====================================================
         */

      .admin-quick-link {

         display: flex;

         align-items: center;

         text-decoration: none;

         padding:
            15px;

         border:
            1px solid #edf0f3;

         border-radius: 10px;

         margin-bottom: 10px;

         transition: all .2s ease;

      }


      .admin-quick-link:hover {

         border-color: #cfe0ff;

         background: #f8fbff;

      }


      .admin-quick-icon {

         width: 40px;

         height: 40px;

         min-width: 40px;

         border-radius: 9px;

         background: #eaf2ff;

         color: #0d6efd;

         display: flex;

         align-items: center;

         justify-content: center;

         margin-right: 11px;

      }


      .admin-quick-icon i {

         font-size: 18px;

      }


      .admin-quick-title {

         color: #30363d;

         font-size: 12px;

         font-weight: 700;

      }


      .admin-quick-description {

         color: #9299a3;

         font-size: 10px;

         margin-top: 2px;

      }


      /**
         * =====================================================
         * RESPONSIVE
         * =====================================================
         */

      @media (max-width: 991.98px) {

         .admin-sidebar {

            width: 220px;

            min-width: 220px;

         }


         .admin-main {

            margin-left: 220px;

            width:
               calc(100% - 220px);

         }


         .admin-content {

            padding: 25px;

         }

      }


      @media (max-width: 767.98px) {

         .admin-sidebar {

            position: relative;

            width: 100%;

            min-width: 100%;

            min-height: auto;

         }


         .admin-layout {

            display: block;

         }


         .admin-main {

            margin-left: 0;

            width: 100%;

         }


         .admin-nav {

            display: none;

         }


         .admin-sidebar-footer {

            display: none;

         }


         .admin-brand {

            height: 65px;

         }


         .admin-topbar {

            height: auto;

            padding:
               18px 20px;

         }


         .admin-content {

            padding: 20px 15px;

         }


         .admin-top-user-info {

            display: none;

         }

      }
   </style>

</head>


<body>


   <div class="admin-layout">


      <!-- =====================================================
         SIDEBAR
    ====================================================== -->

      <aside class="admin-sidebar">


         <!-- BRAND -->

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


         <!-- NAVIGATION -->

         <nav class="admin-nav">


            <div class="admin-nav-label">

               Menu Utama

            </div>


            <a
               href="./dashboard.php"
               class="admin-nav-link active">

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
               class="admin-nav-link">

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


         <!-- USER -->

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

                  <div class="admin-user-name">

                     <?= h($adminName) ?>

                  </div>


                  <div class="admin-user-role">

                     <?= h($adminRole) ?>

                  </div>

               </div>


            </div>


            <a
               href="../controllers/admin/logout.php"
               class="btn btn-outline-danger btn-sm rounded admin-logout">

               <i class="uil uil-sign-out-alt"></i>

               Keluar

            </a>


         </div>


      </aside>


      <!-- =====================================================
         MAIN
    ====================================================== -->

      <main class="admin-main">


         <!-- =================================================
             TOPBAR
        ================================================== -->

         <header class="admin-topbar">


            <div>

               <h1 class="admin-page-title">

                  Dashboard

               </h1>


               <div class="admin-page-subtitle">

                  Monitoring Penerimaan Mahasiswa Baru

               </div>

            </div>


            <div class="admin-top-user">


               <div class="admin-top-avatar">

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


               <div class="admin-top-user-info">

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


         <!-- =================================================
             CONTENT
        ================================================== -->

         <div class="admin-content">


            <!-- =================================================
                 WELCOME
            ================================================== -->

            <div class="admin-welcome">


               <div class="admin-welcome-content">


                  <h3>

                     Selamat datang,
                     <?= h($adminName) ?> 👋

                  </h3>


                  <p>

                     Pantau seluruh proses PMB,
                     mulai dari registrasi sampai
                     mahasiswa.

                  </p>


               </div>


            </div>


            <!-- =================================================
                 STATISTICS
            ================================================== -->

            <div class="row g-4 mb-5">


               <!-- TOTAL -->

               <div class="col-6 col-xl-3">


                  <div class="admin-stat-card">


                     <div
                        class="admin-stat-icon bg-soft-primary text-primary">

                        <i class="uil uil-users-alt"></i>

                     </div>


                     <div class="admin-stat-label">

                        Total Peserta

                     </div>


                     <div class="admin-stat-value">

                        <?= number_format(
                           $totalPeserta
                        ) ?>

                     </div>


                  </div>

               </div>


               <!-- REGISTRASI -->

               <div class="col-6 col-xl-3">


                  <div class="admin-stat-card">


                     <div
                        class="admin-stat-icon bg-soft-secondary text-secondary">

                        <i class="uil uil-user-plus"></i>

                     </div>


                     <div class="admin-stat-label">

                        Registrasi

                     </div>


                     <div class="admin-stat-value">

                        <?= number_format(
                           $totalRegistrasi
                        ) ?>

                     </div>


                  </div>

               </div>


               <!-- SELEKSI -->

               <div class="col-6 col-xl-3">


                  <div class="admin-stat-card">


                     <div
                        class="admin-stat-icon bg-soft-yellow text-yellow">

                        <i class="uil uil-clipboard-alt"></i>

                     </div>


                     <div class="admin-stat-label">

                        Seleksi

                     </div>


                     <div class="admin-stat-value">

                        <?= number_format(
                           $totalSeleksi
                        ) ?>

                     </div>


                  </div>

               </div>


               <!-- MAHASISWA -->

               <div class="col-6 col-xl-3">


                  <div class="admin-stat-card">


                     <div
                        class="admin-stat-icon bg-soft-green text-green">

                        <i class="uil uil-graduation-cap"></i>

                     </div>


                     <div class="admin-stat-label">

                        Mahasiswa

                     </div>


                     <div class="admin-stat-value">

                        <?= number_format(
                           $totalMahasiswa
                        ) ?>

                     </div>


                  </div>

               </div>


            </div>


            <!-- =================================================
                 SECOND STATISTICS
            ================================================== -->

            <div class="row g-4 mb-5">


               <div class="col-md-4">


                  <div class="admin-stat-card">


                     <div
                        class="d-flex justify-content-between align-items-start">


                        <div>

                           <div class="admin-stat-label">

                              Lulus

                           </div>


                           <div class="admin-stat-value">

                              <?= number_format(
                                 $totalLulus
                              ) ?>

                           </div>

                        </div>


                        <div
                           class="admin-stat-icon bg-soft-green text-green mb-0">

                           <i class="uil uil-check-circle"></i>

                        </div>


                     </div>

                  </div>

               </div>


               <div class="col-md-4">


                  <div class="admin-stat-card">


                     <div
                        class="d-flex justify-content-between align-items-start">


                        <div>

                           <div class="admin-stat-label">

                              Tidak Lulus

                           </div>


                           <div class="admin-stat-value">

                              <?= number_format(
                                 $totalTidakLulus
                              ) ?>

                           </div>

                        </div>


                        <div
                           class="admin-stat-icon bg-soft-red text-red mb-0">

                           <i class="uil uil-times-circle"></i>

                        </div>


                     </div>

                  </div>

               </div>


               <div class="col-md-4">


                  <div class="admin-stat-card">


                     <div
                        class="d-flex justify-content-between align-items-start">


                        <div>

                           <div class="admin-stat-label">

                              Daftar Ulang

                           </div>


                           <div class="admin-stat-value">

                              <?= number_format(
                                 $totalDaftarUlang
                              ) ?>

                           </div>

                        </div>


                        <div
                           class="admin-stat-icon bg-soft-primary text-primary mb-0">

                           <i class="uil uil-user-check"></i>

                        </div>


                     </div>

                  </div>

               </div>


            </div>


            <!-- =================================================
                 TABLE + QUICK MENU
            ================================================== -->

            <div class="row g-4">


               <!-- =================================================
                     RECENT PARTICIPANTS
                ================================================== -->

               <div class="col-xl-8">


                  <div class="admin-section-card">


                     <div class="admin-section-header">


                        <div>

                           <h5>

                              Peserta Terbaru

                           </h5>


                           <p>

                              Pendaftaran terbaru
                              di Portal PMB.

                           </p>

                        </div>


                        <a
                           href="./peserta.php"
                           class="btn btn-sm btn-outline-primary rounded">

                           Lihat Semua

                           <i
                              class="uil uil-arrow-right ms-1">
                           </i>

                        </a>


                     </div>


                     <div class="table-responsive">


                        <table
                           class="table admin-table">


                           <thead>

                              <tr>

                                 <th>
                                    Peserta
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

                                 <th>
                                    Tanggal
                                 </th>

                              </tr>

                           </thead>


                           <tbody>


                              <?php if (
                                 empty($recentParticipants)
                              ): ?>


                                 <tr>

                                    <td
                                       colspan="5"
                                       class="text-center text-muted py-5">

                                       Belum ada
                                       data peserta.

                                    </td>

                                 </tr>


                              <?php else: ?>


                                 <?php foreach (
                                    $recentParticipants
                                    as $participant
                                 ): ?>


                                    <tr>


                                       <td>


                                          <div
                                             class="admin-participant-name">

                                             <?= h(
                                                $participant['fullname']
                                             ) ?>

                                          </div>


                                          <div
                                             class="admin-participant-id">

                                             <?= h(
                                                $participant['register_uid']
                                             ) ?>

                                          </div>


                                       </td>


                                       <td>

                                          <?= h(
                                             $participant['register_type'] ?: '-'
                                          ) ?>

                                       </td>


                                       <td>

                                          <span
                                             class="badge bg-soft-primary text-primary">

                                             Tahap
                                             <?= (int)
                                             $participant['tahap_aktif'] ?>

                                          </span>

                                       </td>


                                       <td>


                                          <span
                                             class="
                                                        badge
                                                        bg-soft-<?= h(
                                                                     statusClass(
                                                                        $participant['status_pendaftaran']
                                                                     )
                                                                  )
                                                                  ?>
                                                        text-<?= h(
                                                                  statusClass(
                                                                     $participant['status_pendaftaran']
                                                                  )
                                                               )
                                                               ?>
                                                        admin-status">

                                             <?= h(
                                                $participant['status_pendaftaran']
                                             ) ?>

                                          </span>


                                       </td>


                                       <td>

                                          <span
                                             class="text-muted">

                                             <?= !empty($participant['created_at'])
                                                ? date(
                                                   'd/m/Y',
                                                   strtotime(
                                                      $participant['created_at']
                                                   )
                                                )
                                                : '-'
                                             ?>

                                          </span>

                                       </td>


                                    </tr>


                                 <?php endforeach; ?>


                              <?php endif; ?>


                           </tbody>

                        </table>

                     </div>


                  </div>

               </div>


               <!-- =================================================
                     QUICK MENU
                ================================================== -->

               <div class="col-xl-4">


                  <div class="admin-section-card">


                     <div class="admin-section-header">


                        <div>

                           <h5>

                              Akses Cepat

                           </h5>


                           <p>

                              Menu administrasi PMB.

                           </p>

                        </div>


                     </div>


                     <div class="p-4">


                        <a
                           href="./peserta.php"
                           class="admin-quick-link">


                           <div
                              class="admin-quick-icon">

                              <i class="uil uil-users-alt"></i>

                           </div>


                           <div>

                              <div
                                 class="admin-quick-title">

                                 Data Peserta

                              </div>


                              <div
                                 class="admin-quick-description">

                                 Kelola seluruh peserta PMB.

                              </div>

                           </div>


                        </a>


                        <a
                           href="./seleksi.php"
                           class="admin-quick-link">


                           <div
                              class="admin-quick-icon">

                              <i class="uil uil-clipboard-alt"></i>

                           </div>


                           <div>

                              <div
                                 class="admin-quick-title">

                                 Seleksi PMB

                              </div>


                              <div
                                 class="admin-quick-description">

                                 Kelola TPA dan wawancara.

                              </div>

                           </div>


                        </a>


                        <a
                           href="./hasil-seleksi.php"
                           class="admin-quick-link">


                           <div
                              class="admin-quick-icon">

                              <i class="uil uil-award"></i>

                           </div>


                           <div>

                              <div
                                 class="admin-quick-title">

                                 Hasil Seleksi

                              </div>


                              <div
                                 class="admin-quick-description">

                                 Kelola nilai dan kelulusan.

                              </div>

                           </div>


                        </a>


                        <a
                           href="./daftar-ulang.php"
                           class="admin-quick-link mb-0">


                           <div
                              class="admin-quick-icon">

                              <i class="uil uil-user-check"></i>

                           </div>


                           <div>

                              <div
                                 class="admin-quick-title">

                                 Daftar Ulang

                              </div>


                              <div
                                 class="admin-quick-description">

                                 Verifikasi mahasiswa baru.

                              </div>

                           </div>


                        </a>


                     </div>

                  </div>


               </div>


            </div>


         </div>


      </main>

   </div>


</body>

</html>