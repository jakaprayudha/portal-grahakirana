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
 * FILTER
 * =========================================================
 */

$search =
   trim($_GET['search'] ?? '');

$status =
   trim($_GET['status'] ?? '');


/**
 * =========================================================
 * UPDATE NILAI / HASIL
 * =========================================================
 *
 * POST:
 *
 * action=simpan_hasil
 *
 */

$successMessage = '';
$errorMessage = '';


if (
   $_SERVER['REQUEST_METHOD'] === 'POST'
   &&
   ($_POST['action'] ?? '') === 'simpan_hasil'
) {

   $pesertaId =
      filter_input(
         INPUT_POST,
         'id',
         FILTER_VALIDATE_INT
      );


   $nilaiTpa =
      trim(
         $_POST['nilai_tpa'] ?? ''
      );


   $nilaiWawancara =
      trim(
         $_POST['nilai_wawancara'] ?? ''
      );


   $statusKelulusan =
      trim(
         $_POST['status_kelulusan'] ?? ''
      );


   $catatan =
      trim(
         $_POST['catatan_hasil'] ?? ''
      );


   /**
    * ---------------------------------------------------------
    * VALIDASI
    * ---------------------------------------------------------
    */

   if (
      !$pesertaId
      || $nilaiTpa === ''
      || $nilaiWawancara === ''
      || !is_numeric($nilaiTpa)
      || !is_numeric($nilaiWawancara)
   ) {

      $errorMessage =
         'Data nilai belum lengkap atau tidak valid.';
   } else {

      $nilaiTpa =
         (float) $nilaiTpa;

      $nilaiWawancara =
         (float) $nilaiWawancara;


      if (
         $nilaiTpa < 0
         || $nilaiTpa > 100
         || $nilaiWawancara < 0
         || $nilaiWawancara > 100
      ) {

         $errorMessage =
            'Nilai TPA dan wawancara harus berada antara 0 sampai 100.';
      }


      /**
       * -----------------------------------------------------
       * VALIDASI STATUS
       * -----------------------------------------------------
       */

      $allowedStatus = [
         'BELUM_DIUMUMKAN',
         'LULUS',
         'TIDAK_LULUS'
      ];


      if (
         $errorMessage === ''
         &&
         !in_array(
            $statusKelulusan,
            $allowedStatus,
            true
         )
      ) {

         $errorMessage =
            'Status kelulusan tidak valid.';
      }


      /**
       * -----------------------------------------------------
       * SIMPAN
       * -----------------------------------------------------
       */

      if ($errorMessage === '') {

         /**
          * Nilai akhir:
          *
          * TPA        = 50%
          * Wawancara  = 50%
          */

         $nilaiAkhir =
            (
               $nilaiTpa * 0.50
            )
            +
            (
               $nilaiWawancara * 0.50
            );


         /**
          * Status pendaftaran mengikuti hasil.
          */

         if (
            $statusKelulusan === 'LULUS'
         ) {

            $statusPendaftaran =
               'LULUS';
         } elseif (
            $statusKelulusan === 'TIDAK_LULUS'
         ) {

            $statusPendaftaran =
               'TIDAK_LULUS';
         } else {

            $statusPendaftaran =
               'SELEKSI';
         }


         try {

            $pdo->beginTransaction();


            /**
             * Pastikan peserta ada.
             */

            $check =
               $pdo->prepare("

                        SELECT
                            id,
                            fullname

                        FROM register_pmb

                        WHERE id = :id

                        LIMIT 1

                    ");


            $check->execute([
               'id' => $pesertaId
            ]);


            $pesertaCheck =
               $check->fetch(
                  PDO::FETCH_ASSOC
               );


            if (!$pesertaCheck) {

               throw new Exception(
                  'Peserta tidak ditemukan.'
               );
            }


            /**
             * Update hasil seleksi.
             */

            $stmt =
               $pdo->prepare("

                        UPDATE register_pmb

                        SET

                            nilai_tpa = :nilai_tpa,

                            nilai_wawancara =
                                :nilai_wawancara,

                            nilai_akhir =
                                :nilai_akhir,

                            status_kelulusan =
                                :status_kelulusan,

                            catatan_hasil =
                                :catatan_hasil,

                            hasil_diumumkan_at =
                                CASE

                                    WHEN
                                        :status_kelulusan_date
                                        IN (
                                            'LULUS',
                                            'TIDAK_LULUS'
                                        )

                                    THEN NOW()

                                    ELSE
                                        hasil_diumumkan_at

                                END,

                            status_pendaftaran =
                                :status_pendaftaran,

                            tahap_aktif =
                                CASE

                                    WHEN
                                        :status_pendaftaran_stage
                                        IN (
                                            'LULUS',
                                            'TIDAK_LULUS'
                                        )

                                    THEN 5

                                    ELSE tahap_aktif

                                END

                        WHERE id = :id

                        LIMIT 1

                    ");


            $stmt->execute([

               'nilai_tpa' =>
               number_format(
                  $nilaiTpa,
                  2,
                  '.',
                  ''
               ),

               'nilai_wawancara' =>
               number_format(
                  $nilaiWawancara,
                  2,
                  '.',
                  ''
               ),

               'nilai_akhir' =>
               number_format(
                  $nilaiAkhir,
                  2,
                  '.',
                  ''
               ),

               'status_kelulusan' =>
               $statusKelulusan,

               'catatan_hasil' =>
               $catatan !== ''
                  ? $catatan
                  : null,

               'status_kelulusan_date' =>
               $statusKelulusan,

               'status_pendaftaran' =>
               $statusPendaftaran,

               'status_pendaftaran_stage' =>
               $statusPendaftaran,

               'id' =>
               $pesertaId

            ]);


            $pdo->commit();


            $successMessage =
               'Hasil seleksi berhasil disimpan untuk '
               .
               $pesertaCheck['fullname']
               .
               '. Nilai akhir: '
               .
               number_format(
                  $nilaiAkhir,
                  2,
                  ',',
                  '.'
               );
         } catch (
            Throwable $e
         ) {

            if (
               $pdo->inTransaction()
            ) {

               $pdo->rollBack();
            }


            $errorMessage =
               $e->getMessage();
         }
      }
   }
}


/**
 * =========================================================
 * QUERY PESERTA
 * =========================================================
 */

$where = [];

$params = [];


/**
 * Hanya peserta yang sudah
 * berada di proses seleksi / hasil.
 *
 * Kita tidak membatasi tahap secara
 * keras supaya data lama tetap terlihat.
 */

$where[] = "

    status_pendaftaran IN (
        'MENUNGGU_SELEKSI',
        'SELEKSI',
        'LULUS',
        'TIDAK_LULUS'
    )

";


if ($search !== '') {

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


if ($status !== '') {

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
 * DATA
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

                    WHEN status_kelulusan =
                        'BELUM_DIUMUMKAN'

                    THEN 1

                    WHEN status_pendaftaran =
                        'SELEKSI'

                    THEN 2

                    ELSE 3

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

$totalSeleksi = 0;
$totalBelum = 0;
$totalLulus = 0;
$totalTidakLulus = 0;


try {

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


   $totalBelum =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE status_kelulusan =
                'BELUM_DIUMUMKAN'

            AND status_pendaftaran IN (
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

            WHERE status_kelulusan =
                'LULUS'

        ")
         ->fetchColumn();


   $totalTidakLulus =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE status_kelulusan =
                'TIDAK_LULUS'

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
   'Seleksi PMB';

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
           LAYOUT
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

      .selection-table {

         margin: 0;

      }


      .selection-table thead th {

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


      .selection-table tbody td {

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


      .score-input {

         width: 85px;

         height: 36px;

         text-align: center;

         font-weight: 700;

         font-size: 12px;

         border:
            1px solid #dfe4ea;

         border-radius: 7px;

      }


      .score-input:focus {

         border-color:
            #0d6efd;

         box-shadow:
            0 0 0 .15rem rgba(13,
               110,
               253,
               .10);

      }


      .final-score {

         font-size: 14px;

         font-weight: 800;

         color: #0d6efd;

      }


      .result-select {

         min-width: 135px;

         height: 36px;

         border-radius: 7px;

         font-size: 11px;

         font-weight: 700;

      }


      .note-input {

         width: 170px;

         height: 36px;

         font-size: 11px;

         border-radius: 7px;

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
            class="admin-nav-link active">

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

               Seleksi PMB

            </h1>


            <div class="admin-page-subtitle">

               Penilaian TPA, wawancara dan penetapan hasil seleksi

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
                        class="uil uil-clipboard-alt">
                     </i>

                  </div>


                  <div class="stat-label">

                     Peserta Seleksi

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
                  Mekanisme Penilaian
               </strong>


               <div
                  class="mt-1 fs-13">

                  Nilai akhir dihitung otomatis dengan bobot
                  <strong>50% TPA</strong> dan
                  <strong>50% Wawancara</strong>.

                  Setelah status ditetapkan sebagai
                  <strong>LULUS</strong> atau
                  <strong>TIDAK LULUS</strong>,
                  hasil dapat diproses pada tahap berikutnya.

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

                        Daftar Peserta Seleksi

                     </h4>


                     <p
                        class="text-muted
                            mb-0
                            fs-12">

                        Masukkan nilai TPA dan wawancara
                        untuk setiap peserta.

                     </p>


                  </div>


                  <a
                     href="./seleksi.php"
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
                  action="./seleksi.php">


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
                              value="BELUM_DIUMUMKAN"
                              <?= $status ===
                                 'BELUM_DIUMUMKAN'
                                 ? 'selected'
                                 : '' ?>>

                              Belum Diumumkan

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


                        </select>


                     </div>


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

            <div
               class="table-responsive">


               <table
                  class="table selection-table">


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
                           Catatan
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
                                    class="uil uil-clipboard-alt"
                                    style="
                                            font-size:40px;
                                            opacity:.35;
                                        ">
                                 </i>


                                 <div
                                    class="mt-2">

                                    Belum ada peserta
                                    yang masuk proses seleksi.

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

                           $nilaiTpa =
                              $row['nilai_tpa'] !== null
                              ? (float)
                              $row['nilai_tpa']
                              : '';

                           $nilaiWawancara =
                              $row['nilai_wawancara'] !== null
                              ? (float)
                              $row['nilai_wawancara']
                              : '';

                           $nilaiAkhir =
                              $row['nilai_akhir'] !== null
                              ? (float)
                              $row['nilai_akhir']
                              : null;


                           $hasil =
                              $row['status_kelulusan']
                              ?: 'BELUM_DIUMUMKAN';

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


                                 <input
                                    type="number"
                                    class="form-control score-input score-tpa"
                                    data-id="<?= (int)
                                             $row['id'] ?>"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    value="<?= h(
                                                $nilaiTpa
                                             ) ?>"
                                    placeholder="0-100">


                              </td>


                              <!-- WAWANCARA -->

                              <td>


                                 <input
                                    type="number"
                                    class="form-control score-input score-wawancara"
                                    data-id="<?= (int)
                                             $row['id'] ?>"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    value="<?= h(
                                                $nilaiWawancara
                                             ) ?>"
                                    placeholder="0-100">


                              </td>


                              <!-- NILAI AKHIR -->

                              <td>


                                 <span
                                    class="final-score"
                                    id="final-<?= (int)
                                                $row['id'] ?>">

                                    <?= $nilaiAkhir !== null
                                       ? number_format(
                                          $nilaiAkhir,
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


                                 <select
                                    class="form-select result-select"
                                    name="status_kelulusan"
                                    form="form-<?= (int)
                                                $row['id'] ?>">


                                    <option
                                       value="BELUM_DIUMUMKAN"
                                       <?= $hasil ===
                                          'BELUM_DIUMUMKAN'
                                          ? 'selected'
                                          : '' ?>>

                                       Belum Diumumkan

                                    </option>


                                    <option
                                       value="LULUS"
                                       <?= $hasil ===
                                          'LULUS'
                                          ? 'selected'
                                          : '' ?>>

                                       Lulus

                                    </option>


                                    <option
                                       value="TIDAK_LULUS"
                                       <?= $hasil ===
                                          'TIDAK_LULUS'
                                          ? 'selected'
                                          : '' ?>>

                                       Tidak Lulus

                                    </option>


                                 </select>


                              </td>


                              <!-- CATATAN -->

                              <td>


                                 <input
                                    type="text"
                                    class="form-control note-input"
                                    name="catatan_hasil"
                                    form="form-<?= (int)
                                                $row['id'] ?>"
                                    value="<?= h(
                                                $row['catatan_hasil']
                                                   ?: ''
                                             ) ?>"
                                    placeholder="Catatan...">


                              </td>


                              <!-- ACTION -->

                              <td
                                 class="text-center">


                                 <form
                                    method="POST"
                                    action="./seleksi.php"
                                    id="form-<?= (int)
                                             $row['id'] ?>">


                                    <input
                                       type="hidden"
                                       name="action"
                                       value="simpan_hasil">


                                    <input
                                       type="hidden"
                                       name="id"
                                       value="<?= (int)
                                                $row['id'] ?>">


                                    <input
                                       type="hidden"
                                       name="nilai_tpa"
                                       class="hidden-tpa"
                                       value="<?= h(
                                                   $nilaiTpa
                                                ) ?>">


                                    <input
                                       type="hidden"
                                       name="nilai_wawancara"
                                       class="hidden-wawancara"
                                       value="<?= h(
                                                   $nilaiWawancara
                                                ) ?>">


                                    <button
                                       type="submit"
                                       class="btn btn-sm btn-primary rounded"
                                       onclick="return confirm('Simpan hasil seleksi peserta ini?')">


                                       <i
                                          class="uil uil-save me-1">
                                       </i>


                                       Simpan


                                    </button>


                                 </form>


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


   <!-- =========================================================
     JAVASCRIPT
========================================================== -->

   <script>
      document.addEventListener(
         "DOMContentLoaded",
         function() {


            /**
             * =====================================================
             * HITUNG NILAI AKHIR
             * =====================================================
             *
             * TPA        = 50%
             * Wawancara  = 50%
             *
             */


            function calculateFinal(
               tpa,
               wawancara
            ) {

               tpa =
                  parseFloat(tpa);

               wawancara =
                  parseFloat(wawancara);


               if (
                  isNaN(tpa) ||
                  isNaN(wawancara)
               ) {

                  return null;

               }


               return (
                  (tpa * 0.50) +
                  (wawancara * 0.50)
               );

            }


            /**
             * =====================================================
             * UPDATE ROW
             * =====================================================
             */

            function updateRow(
               id
            ) {

               const tpaInput =
                  document.querySelector(
                     '.score-tpa[data-id="' +
                     id +
                     '"]'
                  );


               const wawancaraInput =
                  document.querySelector(
                     '.score-wawancara[data-id="' +
                     id +
                     '"]'
                  );


               const finalElement =
                  document.getElementById(
                     'final-' +
                     id
                  );


               const form =
                  document.getElementById(
                     'form-' +
                     id
                  );


               if (
                  !tpaInput ||
                  !wawancaraInput ||
                  !finalElement ||
                  !form
               ) {

                  return;

               }


               const final =
                  calculateFinal(
                     tpaInput.value,
                     wawancaraInput.value
                  );


               /**
                * Update tampilan.
                */

               if (
                  final === null
               ) {

                  finalElement.textContent =
                     '-';

               } else {

                  finalElement.textContent =
                     final.toFixed(2)
                     .replace(
                        '.',
                        ','
                     );

               }


               /**
                * Update hidden input.
                */

               const hiddenTpa =
                  form.querySelector(
                     '.hidden-tpa'
                  );


               const hiddenWawancara =
                  form.querySelector(
                     '.hidden-wawancara'
                  );


               if (hiddenTpa) {

                  hiddenTpa.value =
                     tpaInput.value;

               }


               if (hiddenWawancara) {

                  hiddenWawancara.value =
                     wawancaraInput.value;

               }

            }


            /**
             * =====================================================
             * LISTENER NILAI
             * =====================================================
             */

            document
               .querySelectorAll(
                  '.score-tpa, .score-wawancara'
               )
               .forEach(
                  function(input) {


                     input.addEventListener(
                        'input',
                        function() {

                           updateRow(
                              input.dataset.id
                           );

                        }
                     );


                     input.addEventListener(
                        'change',
                        function() {

                           updateRow(
                              input.dataset.id
                           );

                        }
                     );


                  }
               );


            /**
             * =====================================================
             * VALIDASI FORM
             * =====================================================
             */

            document
               .querySelectorAll(
                  'form[id^="form-"]'
               )
               .forEach(
                  function(form) {


                     form.addEventListener(
                        'submit',
                        function(event) {


                           const id =
                              form.id
                              .replace(
                                 'form-',
                                 ''
                              );


                           const tpaInput =
                              document.querySelector(
                                 '.score-tpa[data-id="' +
                                 id +
                                 '"]'
                              );


                           const wawancaraInput =
                              document.querySelector(
                                 '.score-wawancara[data-id="' +
                                 id +
                                 '"]'
                              );


                           if (
                              !tpaInput ||
                              !wawancaraInput
                           ) {

                              return;

                           }


                           const tpa =
                              parseFloat(
                                 tpaInput.value
                              );


                           const wawancara =
                              parseFloat(
                                 wawancaraInput.value
                              );


                           if (
                              isNaN(tpa) ||
                              isNaN(wawancara)
                           ) {

                              event.preventDefault();


                              alert(
                                 'Nilai TPA dan wawancara wajib diisi.'
                              );


                              return;

                           }


                           if (
                              tpa < 0 ||
                              tpa > 100 ||
                              wawancara < 0 ||
                              wawancara > 100
                           ) {

                              event.preventDefault();


                              alert(
                                 'Nilai harus berada antara 0 sampai 100.'
                              );


                              return;

                           }


                           /**
                            * Pastikan hidden
                            * input sudah benar.
                            */

                           const hiddenTpa =
                              form.querySelector(
                                 '.hidden-tpa'
                              );


                           const hiddenWawancara =
                              form.querySelector(
                                 '.hidden-wawancara'
                              );


                           if (hiddenTpa) {

                              hiddenTpa.value =
                                 tpa;

                           }


                           if (hiddenWawancara) {

                              hiddenWawancara.value =
                                 wawancara;

                           }


                        }
                     );


                  }
               );


         }
      );
   </script>


</body>

</html>