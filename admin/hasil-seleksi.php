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
 * POST ACTION
 * =========================================================
 */

$successMessage = '';
$errorMessage = '';


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


   /**
    * =====================================================
    * VALIDASI ID
    * =====================================================
    */

   if (
      !$id ||
      $id < 1
   ) {

      $errorMessage =
         'ID peserta tidak valid.';
   } else {


      try {


         /**
          * ===============================================
          * AMBIL PESERTA
          * ===============================================
          */

         $check =
            $pdo->prepare("

                    SELECT

                        id,
                        fullname,
                        status_kelulusan,
                        status_pendaftaran,
                        nilai_tpa,
                        nilai_wawancara,
                        nilai_akhir

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
               'Data peserta tidak ditemukan.'
            );
         }


         /**
          * ===============================================
          * PUBLISH
          * ===============================================
          */

         if (
            $action ===
            'publikasikan'
         ) {


            if (
               $peserta['status_kelulusan'] !== 'LULUS'
               &&
               $peserta['status_kelulusan'] !== 'TIDAK_LULUS'
            ) {

               throw new Exception(
                  'Status kelulusan belum ditentukan.'
               );
            }


            if (
               $peserta['nilai_tpa'] === null
               ||
               $peserta['nilai_wawancara'] === null
               ||
               $peserta['nilai_akhir'] === null
            ) {

               throw new Exception(
                  'Nilai seleksi belum lengkap.'
               );
            }


            $stmt =
               $pdo->prepare("

                        UPDATE register_pmb

                        SET

                            hasil_diumumkan_at =
                                NOW(),

                            updated_at =
                                NOW()

                        WHERE id = :id

                        LIMIT 1

                    ");


            $stmt->execute([
               'id' => $id
            ]);


            $successMessage =
               'Hasil seleksi '
               .
               $peserta['fullname']
               .
               ' berhasil dipublikasikan.';


            /**
             * ===============================================
             * BATAL PUBLIKASI
             * ===============================================
             */
         } elseif (
            $action ===
            'batalkan'
         ) {


            $stmt =
               $pdo->prepare("

                        UPDATE register_pmb

                        SET

                            status_kelulusan =
                                'BELUM_DIUMUMKAN',

                            hasil_diumumkan_at =
                                NULL,

                            status_pendaftaran =
                                'SELEKSI',

                            tahap_aktif =
                                CASE

                                    WHEN tahap_aktif >= 5
                                    THEN 4

                                    ELSE tahap_aktif

                                END,

                            updated_at =
                                NOW()

                        WHERE id = :id

                        LIMIT 1

                    ");


            $stmt->execute([
               'id' => $id
            ]);


            $successMessage =
               'Publikasi hasil '
               .
               $peserta['fullname']
               .
               ' berhasil dibatalkan.';
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
 * QUERY
 * =========================================================
 */

$where = [];

$params = [];


/**
 * Hanya peserta yang sudah mempunyai
 * nilai / proses seleksi.
 */

$where[] = "

    (

        nilai_tpa IS NOT NULL

        OR

        nilai_wawancara IS NOT NULL

        OR

        nilai_akhir IS NOT NULL

        OR

        status_kelulusan <> 'BELUM_DIUMUMKAN'

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
      "status_kelulusan = :status";


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

                tahap_aktif,

                status_pendaftaran,

                nilai_tpa,

                nilai_wawancara,

                nilai_akhir,

                status_kelulusan,

                catatan_hasil,

                hasil_diumumkan_at,

                created_at,

                updated_at

            FROM register_pmb

            $whereSql

            ORDER BY

                CASE

                    WHEN
                        status_kelulusan =
                        'LULUS'

                    THEN 1

                    WHEN
                        status_kelulusan =
                        'TIDAK_LULUS'

                    THEN 2

                    ELSE 3

                END,

                hasil_diumumkan_at DESC,

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

$totalHasil = 0;
$totalLulus = 0;
$totalTidakLulus = 0;
$totalBelum = 0;


try {


   $totalHasil =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE

                nilai_akhir IS NOT NULL

                OR

                status_kelulusan <>
                'BELUM_DIUMUMKAN'

        ")
         ->fetchColumn();


   $totalLulus =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE
                status_kelulusan =
                'LULUS'

        ")
         ->fetchColumn();


   $totalTidakLulus =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE
                status_kelulusan =
                'TIDAK_LULUS'

        ")
         ->fetchColumn();


   $totalBelum =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE

                status_kelulusan =
                'BELUM_DIUMUMKAN'

                AND

                (
                    nilai_tpa IS NOT NULL

                    OR

                    nilai_wawancara IS NOT NULL

                    OR

                    nilai_akhir IS NOT NULL
                )

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
   'Hasil Seleksi';

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
           STAT
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
           CARD
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
           SEARCH
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

      .result-table {

         margin: 0;

      }


      .result-table thead th {

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


      .result-table tbody td {

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


      .score-value {

         font-weight: 700;

      }


      .score-final {

         color: #0d6efd;

         font-size: 14px;

         font-weight: 800;

      }


      .note-cell {

         max-width: 190px;

         color: #68717c;

         font-size: 11px;

      }


      .published {

         font-size: 10px;

         color: #9299a3;

         margin-top: 4px;

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


      <!-- TOPBAR -->

      <header class="admin-topbar">


         <div>

            <h1 class="admin-page-title">

               Hasil Seleksi

            </h1>


            <div class="admin-page-subtitle">

               Monitoring dan publikasi hasil seleksi PMB

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
             STATISTICS
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

                     Total Hasil

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalHasil
                     ) ?>

                  </div>


               </div>


            </div>


            <div class="col-6 col-xl-3">


               <div class="stat-card">


                  <div
                     class="stat-icon bg-soft-green text-green">

                     <i
                        class="uil uil-check-circle">
                     </i>

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


            <div class="col-6 col-xl-3">


               <div class="stat-card">


                  <div
                     class="stat-icon bg-soft-red text-red">

                     <i
                        class="uil uil-times-circle">
                     </i>

                  </div>


                  <div class="stat-label">

                     Tidak Lulus

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalTidakLulus
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

                     Belum Diumumkan

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalBelum
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

                  Publikasi Hasil Seleksi

               </strong>


               <div
                  class="mt-1 fs-13">

                  Pastikan nilai TPA, wawancara dan nilai akhir
                  sudah benar sebelum hasil dipublikasikan kepada
                  peserta melalui Portal PMB.

               </div>


            </div>


         </div>


         <!-- =================================================
             DATA
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

                        Daftar Hasil Seleksi

                     </h4>


                     <p
                        class="text-muted
                            mb-0
                            fs-12">

                        Kelola hasil seleksi peserta PMB.

                     </p>


                  </div>


                  <a
                     href="./hasil-seleksi.php"
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
                  action="./hasil-seleksi.php">


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

                              Semua Hasil

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
                              value="TIDAK_LULUS"
                              <?= $status ===
                                 'TIDAK_LULUS'
                                 ? 'selected'
                                 : '' ?>>

                              Tidak Lulus

                           </option>


                           <option
                              value="BELUM_DIUMUMKAN"
                              <?= $status ===
                                 'BELUM_DIUMUMKAN'
                                 ? 'selected'
                                 : '' ?>>

                              Belum Diumumkan

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


            <!-- TABLE -->

            <div
               class="table-responsive">


               <table
                  class="table result-table">


                  <thead>


                     <tr>


                        <th>
                           #
                        </th>


                        <th>
                           Peserta
                        </th>


                        <th>
                           TPA
                        </th>


                        <th>
                           Wawancara
                        </th>


                        <th>
                           Nilai Akhir
                        </th>


                        <th>
                           Hasil
                        </th>


                        <th>
                           Publikasi
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
                                    class="uil uil-award"
                                    style="
                                            font-size:42px;
                                            opacity:.35;
                                        ">
                                 </i>


                                 <div
                                    class="mt-2">

                                    Belum ada hasil seleksi.

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

                           $hasil =
                              $row['status_kelulusan']
                              ?: 'BELUM_DIUMUMKAN';


                           $hasilColor =
                              'secondary';


                           if (
                              $hasil ===
                              'LULUS'
                           ) {

                              $hasilColor =
                                 'success';
                           } elseif (
                              $hasil ===
                              'TIDAK_LULUS'
                           ) {

                              $hasilColor =
                                 'danger';
                           } elseif (
                              $hasil ===
                              'BELUM_DIUMUMKAN'
                           ) {

                              $hasilColor =
                                 'warning';
                           }


                           $isPublished =
                              !empty($row['hasil_diumumkan_at']);


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
                                       $row['register_type']
                                          ?: '-'
                                    ) ?>

                                 </div>


                              </td>


                              <!-- TPA -->

                              <td>


                                 <span
                                    class="score-value">

                                    <?= $row['nilai_tpa'] !== null
                                       ? number_format(
                                          (float)
                                          $row['nilai_tpa'],
                                          2,
                                          ',',
                                          '.'
                                       )
                                       : '-'
                                    ?>

                                 </span>


                              </td>


                              <!-- WAWANCARA -->

                              <td>


                                 <span
                                    class="score-value">

                                    <?= $row['nilai_wawancara'] !== null
                                       ? number_format(
                                          (float)
                                          $row['nilai_wawancara'],
                                          2,
                                          ',',
                                          '.'
                                       )
                                       : '-'
                                    ?>

                                 </span>


                              </td>


                              <!-- AKHIR -->

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


                              <!-- HASIL -->

                              <td>


                                 <span
                                    class="
                                        badge
                                        bg-soft-<?= $hasilColor ?>
                                        text-<?= $hasilColor ?>">

                                    <?php

                                    if (
                                       $hasil ===
                                       'BELUM_DIUMUMKAN'
                                    ) {

                                       echo 'Belum Diumumkan';
                                    } else {

                                       echo h(
                                          $hasil
                                       );
                                    }

                                    ?>

                                 </span>


                                 <?php if (
                                    !empty($row['catatan_hasil'])
                                 ): ?>


                                    <div
                                       class="note-cell mt-2">

                                       <?= h(
                                          $row['catatan_hasil']
                                       ) ?>

                                    </div>


                                 <?php endif; ?>


                              </td>


                              <!-- PUBLIKASI -->

                              <td>


                                 <?php if (
                                    $isPublished
                                 ): ?>


                                    <span
                                       class="
                                            badge
                                            bg-soft-green
                                            text-green">

                                       <i
                                          class="uil uil-check-circle me-1">
                                       </i>

                                       Dipublikasikan

                                    </span>


                                    <div
                                       class="published">


                                       <?= h(
                                          date(
                                             'd/m/Y H:i',
                                             strtotime(
                                                $row['hasil_diumumkan_at']
                                             )
                                          )
                                       ) ?>


                                    </div>


                                 <?php else: ?>


                                    <span
                                       class="
                                            badge
                                            bg-soft-yellow
                                            text-yellow">

                                       <i
                                          class="uil uil-clock me-1">
                                       </i>

                                       Belum Publikasi

                                    </span>


                                 <?php endif; ?>


                              </td>


                              <!-- ACTION -->

                              <td
                                 class="text-center">


                                 <div
                                    class="
                                        d-flex
                                        justify-content-center
                                        gap-2">


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


                                    <?php if (
                                       !$isPublished
                                    ): ?>


                                       <form
                                          method="POST"
                                          action="./hasil-seleksi.php"
                                          onsubmit="
                                                    return confirm(
                                                        'Publikasikan hasil seleksi peserta ini?'
                                                    );
                                                ">


                                          <input
                                             type="hidden"
                                             name="action"
                                             value="publikasikan">


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
                                             title="Publikasikan">


                                             <i
                                                class="uil uil-megaphone">
                                             </i>


                                          </button>


                                       </form>


                                    <?php else: ?>


                                       <form
                                          method="POST"
                                          action="./hasil-seleksi.php"
                                          onsubmit="
                                                    return confirm(
                                                        'Batalkan publikasi hasil peserta ini?'
                                                    );
                                                ">


                                          <input
                                             type="hidden"
                                             name="action"
                                             value="batalkan">


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
                                                    btn-soft-danger
                                                    rounded"
                                             title="Batalkan Publikasi">


                                             <i
                                                class="uil uil-eye-slash">
                                             </i>


                                          </button>


                                       </form>


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