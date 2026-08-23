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
 * ADMIN
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
 * DEFAULT TAHUN AKADEMIK
 * =========================================================
 */

$defaultTahun =
   '2026/2027';


/**
 * =========================================================
 * POST CRUD
 * =========================================================
 */

if (
   $_SERVER['REQUEST_METHOD'] === 'POST'
) {

   $action =
      $_POST['action'] ?? '';


   try {


      /**
       * =====================================================
       * TAMBAH
       * =====================================================
       */

      if (
         $action === 'create'
      ) {


         $namaSeleksi =
            trim(
               $_POST['nama_seleksi'] ?? ''
            );

         $kategori =
            trim(
               $_POST['kategori'] ?? ''
            );

         $tanggal =
            trim(
               $_POST['tanggal'] ?? ''
            );

         $jamMulai =
            trim(
               $_POST['jam_mulai'] ?? ''
            );

         $jamSelesai =
            trim(
               $_POST['jam_selesai'] ?? ''
            );

         $lokasi =
            trim(
               $_POST['lokasi'] ?? ''
            );

         $ruangan =
            trim(
               $_POST['ruangan'] ?? ''
            );

         $metode =
            trim(
               $_POST['metode'] ?? ''
            );

         $keterangan =
            trim(
               $_POST['keterangan'] ?? ''
            );

         $urutan =
            (int) (
               $_POST['urutan'] ?? 1
            );

         $status =
            trim(
               $_POST['status'] ?? 'DRAFT'
            );

         $tahunAkademik =
            trim(
               $_POST['tahun_akademik']
                  ?? $defaultTahun
            );


         /**
          * VALIDASI
          */

         if (
            $namaSeleksi === '' ||
            $kategori === '' ||
            $tanggal === '' ||
            $jamMulai === '' ||
            $jamSelesai === '' ||
            $lokasi === '' ||
            $metode === ''
         ) {

            throw new Exception(
               'Data wajib belum lengkap.'
            );
         }


         $allowedStatus = [
            'DRAFT',
            'TERJADWAL',
            'SELESAI',
            'DIBATALKAN'
         ];


         if (
            !in_array(
               $status,
               $allowedStatus,
               true
            )
         ) {

            throw new Exception(
               'Status jadwal tidak valid.'
            );
         }


         if (
            $urutan < 1
         ) {

            $urutan = 1;
         }


         /**
          * INSERT
          */

         $stmt =
            $pdo->prepare("

                    INSERT INTO pmb_jadwal_seleksi (

                        nama_seleksi,
                        kategori,
                        tanggal,
                        jam_mulai,
                        jam_selesai,
                        lokasi,
                        ruangan,
                        metode,
                        keterangan,
                        urutan,
                        status,
                        tahun_akademik,
                        created_at

                    ) VALUES (

                        :nama_seleksi,
                        :kategori,
                        :tanggal,
                        :jam_mulai,
                        :jam_selesai,
                        :lokasi,
                        :ruangan,
                        :metode,
                        :keterangan,
                        :urutan,
                        :status,
                        :tahun_akademik,
                        NOW()

                    )

                ");


         $stmt->execute([

            'nama_seleksi' =>
            $namaSeleksi,

            'kategori' =>
            $kategori,

            'tanggal' =>
            $tanggal,

            'jam_mulai' =>
            $jamMulai,

            'jam_selesai' =>
            $jamSelesai,

            'lokasi' =>
            $lokasi,

            'ruangan' =>
            $ruangan !== ''
               ? $ruangan
               : null,

            'metode' =>
            $metode,

            'keterangan' =>
            $keterangan !== ''
               ? $keterangan
               : null,

            'urutan' =>
            $urutan,

            'status' =>
            $status,

            'tahun_akademik' =>
            $tahunAkademik

         ]);


         $successMessage =
            'Jadwal seleksi berhasil ditambahkan.';


         /**
          * =====================================================
          * EDIT
          * =====================================================
          */
      } elseif (
         $action === 'update'
      ) {


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

            throw new Exception(
               'ID jadwal tidak valid.'
            );
         }


         $namaSeleksi =
            trim(
               $_POST['nama_seleksi'] ?? ''
            );

         $kategori =
            trim(
               $_POST['kategori'] ?? ''
            );

         $tanggal =
            trim(
               $_POST['tanggal'] ?? ''
            );

         $jamMulai =
            trim(
               $_POST['jam_mulai'] ?? ''
            );

         $jamSelesai =
            trim(
               $_POST['jam_selesai'] ?? ''
            );

         $lokasi =
            trim(
               $_POST['lokasi'] ?? ''
            );

         $ruangan =
            trim(
               $_POST['ruangan'] ?? ''
            );

         $metode =
            trim(
               $_POST['metode'] ?? ''
            );

         $keterangan =
            trim(
               $_POST['keterangan'] ?? ''
            );

         $urutan =
            (int) (
               $_POST['urutan'] ?? 1
            );

         $status =
            trim(
               $_POST['status'] ?? 'DRAFT'
            );

         $tahunAkademik =
            trim(
               $_POST['tahun_akademik']
                  ?? $defaultTahun
            );


         if (
            $namaSeleksi === '' ||
            $kategori === '' ||
            $tanggal === '' ||
            $jamMulai === '' ||
            $jamSelesai === '' ||
            $lokasi === '' ||
            $metode === ''
         ) {

            throw new Exception(
               'Data wajib belum lengkap.'
            );
         }


         $allowedStatus = [
            'DRAFT',
            'TERJADWAL',
            'SELESAI',
            'DIBATALKAN'
         ];


         if (
            !in_array(
               $status,
               $allowedStatus,
               true
            )
         ) {

            throw new Exception(
               'Status jadwal tidak valid.'
            );
         }


         if (
            $urutan < 1
         ) {

            $urutan = 1;
         }


         /**
          * UPDATE
          */

         $stmt =
            $pdo->prepare("

                    UPDATE pmb_jadwal_seleksi

                    SET

                        nama_seleksi =
                            :nama_seleksi,

                        kategori =
                            :kategori,

                        tanggal =
                            :tanggal,

                        jam_mulai =
                            :jam_mulai,

                        jam_selesai =
                            :jam_selesai,

                        lokasi =
                            :lokasi,

                        ruangan =
                            :ruangan,

                        metode =
                            :metode,

                        keterangan =
                            :keterangan,

                        urutan =
                            :urutan,

                        status =
                            :status,

                        tahun_akademik =
                            :tahun_akademik,

                        updated_at =
                            NOW()

                    WHERE id = :id

                    LIMIT 1

                ");


         $stmt->execute([

            'nama_seleksi' =>
            $namaSeleksi,

            'kategori' =>
            $kategori,

            'tanggal' =>
            $tanggal,

            'jam_mulai' =>
            $jamMulai,

            'jam_selesai' =>
            $jamSelesai,

            'lokasi' =>
            $lokasi,

            'ruangan' =>
            $ruangan !== ''
               ? $ruangan
               : null,

            'metode' =>
            $metode,

            'keterangan' =>
            $keterangan !== ''
               ? $keterangan
               : null,

            'urutan' =>
            $urutan,

            'status' =>
            $status,

            'tahun_akademik' =>
            $tahunAkademik,

            'id' =>
            $id

         ]);


         $successMessage =
            'Jadwal seleksi berhasil diperbarui.';


         /**
          * =====================================================
          * DELETE
          * =====================================================
          */
      } elseif (
         $action === 'delete'
      ) {


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

            throw new Exception(
               'ID jadwal tidak valid.'
            );
         }


         $stmt =
            $pdo->prepare("

                    DELETE FROM pmb_jadwal_seleksi

                    WHERE id = :id

                    LIMIT 1

                ");


         $stmt->execute([
            'id' => $id
         ]);


         if (
            $stmt->rowCount() < 1
         ) {

            throw new Exception(
               'Jadwal tidak ditemukan.'
            );
         }


         $successMessage =
            'Jadwal seleksi berhasil dihapus.';


         /**
          * =====================================================
          * STATUS
          * =====================================================
          */
      } elseif (
         $action === 'change_status'
      ) {


         $id =
            filter_input(
               INPUT_POST,
               'id',
               FILTER_VALIDATE_INT
            );


         $newStatus =
            trim(
               $_POST['status'] ?? ''
            );


         $allowedStatus = [
            'DRAFT',
            'TERJADWAL',
            'SELESAI',
            'DIBATALKAN'
         ];


         if (
            !$id ||
            $id < 1
         ) {

            throw new Exception(
               'ID jadwal tidak valid.'
            );
         }


         if (
            !in_array(
               $newStatus,
               $allowedStatus,
               true
            )
         ) {

            throw new Exception(
               'Status tidak valid.'
            );
         }


         $stmt =
            $pdo->prepare("

                    UPDATE pmb_jadwal_seleksi

                    SET

                        status = :status,

                        updated_at = NOW()

                    WHERE id = :id

                    LIMIT 1

                ");


         $stmt->execute([

            'status' =>
            $newStatus,

            'id' =>
            $id

         ]);


         $successMessage =
            'Status jadwal berhasil diperbarui.';
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


/**
 * =========================================================
 * FILTER
 * =========================================================
 */

$search =
   trim(
      $_GET['search'] ?? ''
   );

$filterStatus =
   trim(
      $_GET['status'] ?? ''
   );

$filterTahun =
   trim(
      $_GET['tahun_akademik'] ?? ''
   );


/**
 * =========================================================
 * WHERE
 * =========================================================
 */

$where = [];

$params = [];


if (
   $search !== ''
) {

   $where[] = "

        (

            nama_seleksi LIKE :search

            OR kategori LIKE :search

            OR lokasi LIKE :search

            OR ruangan LIKE :search

            OR metode LIKE :search

            OR keterangan LIKE :search

        )

    ";


   $params['search'] =
      '%' .
      $search .
      '%';
}


if (
   $filterStatus !== ''
) {

   $where[] =
      "status = :status";


   $params['status'] =
      $filterStatus;
}


if (
   $filterTahun !== ''
) {

   $where[] =
      "tahun_akademik = :tahun_akademik";


   $params['tahun_akademik'] =
      $filterTahun;
}


$whereSql = '';

if (
   !empty($where)
) {

   $whereSql =
      'WHERE '
      .
      implode(
         ' AND ',
         $where
      );
}


/**
 * =========================================================
 * GET JADWAL
 * =========================================================
 */

$jadwal = [];


try {

   $stmt =
      $pdo->prepare("

            SELECT

                id,
                nama_seleksi,
                kategori,
                tanggal,
                jam_mulai,
                jam_selesai,
                lokasi,
                ruangan,
                metode,
                keterangan,
                urutan,
                status,
                tahun_akademik,
                created_at,
                updated_at

            FROM pmb_jadwal_seleksi

            $whereSql

            ORDER BY

                tahun_akademik DESC,

                urutan ASC,

                tanggal ASC,

                jam_mulai ASC,

                id ASC

        ");


   $stmt->execute(
      $params
   );


   $jadwal =
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
 * TAHUN AKADEMIK FILTER
 * =========================================================
 */

$tahunList = [];


try {

   $stmt =
      $pdo->query("

            SELECT DISTINCT

                tahun_akademik

            FROM pmb_jadwal_seleksi

            ORDER BY
                tahun_akademik DESC

        ");


   $tahunList =
      $stmt->fetchAll(
         PDO::FETCH_COLUMN
      );
} catch (
   Throwable $e
) {
}


/**
 * =========================================================
 * STATISTICS
 * =========================================================
 */

$totalJadwal = 0;
$totalTerjadwal = 0;
$totalSelesai = 0;
$totalDraft = 0;
$totalBatal = 0;


try {

   $totalJadwal =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM pmb_jadwal_seleksi

        ")
         ->fetchColumn();


   $totalTerjadwal =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM pmb_jadwal_seleksi

            WHERE status =
                'TERJADWAL'

        ")
         ->fetchColumn();


   $totalSelesai =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM pmb_jadwal_seleksi

            WHERE status =
                'SELESAI'

        ")
         ->fetchColumn();


   $totalDraft =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM pmb_jadwal_seleksi

            WHERE status =
                'DRAFT'

        ")
         ->fetchColumn();


   $totalBatal =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM pmb_jadwal_seleksi

            WHERE status =
                'DIBATALKAN'

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
   'Jadwal Seleksi PMB';

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
           TABLE
        ===================================================== */

      .schedule-table {

         margin: 0;

      }


      .schedule-table thead th {

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


      .schedule-table tbody td {

         padding:
            15px;

         border-color: #f0f2f5;

         font-size: 12px;

         vertical-align: middle;

      }


      .schedule-title {

         font-weight: 700;

         color: #30363d;

      }


      .schedule-sub {

         color: #9299a3;

         font-size: 10px;

         margin-top: 3px;

      }


      .date-box {

         font-weight: 700;

         color: #30363d;

         white-space: nowrap;

      }


      .time-box {

         white-space: nowrap;

      }


      .location-box {

         color: #68717c;

      }


      .action-group {

         display: flex;

         justify-content: center;

         gap: 5px;

      }


      /* =====================================================
           MODAL
        ===================================================== */

      .modal-label {

         font-size: 11px;

         font-weight: 700;

         color: #68717c;

         margin-bottom: 6px;

      }


      .form-control,
      .form-select {

         border-radius: 8px;

         min-height: 42px;

         font-size: 13px;

      }


      textarea.form-control {

         min-height: 100px;

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
            class="admin-nav-link">

            <i class="uil uil-user-check"></i>

            Daftar Ulang

         </a>


         <div class="admin-nav-label mt-5">

            Jadwal & Akademik

         </div>


         <a
            href="./pmb-jadwal-seleksi.php"
            class="admin-nav-link active">

            <i class="uil uil-calendar-alt"></i>

            Jadwal Seleksi

         </a>


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

               Jadwal Seleksi PMB

            </h1>


            <div class="admin-page-subtitle">

               Kelola jadwal TPA, wawancara dan tahapan seleksi PMB

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


         <!-- ALERT -->

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
                        class="uil uil-calendar-alt">
                     </i>

                  </div>


                  <div class="stat-label">

                     Total Jadwal

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalJadwal
                     ) ?>

                  </div>


               </div>


            </div>


            <div class="col-6 col-xl-3">


               <div class="stat-card">


                  <div
                     class="stat-icon bg-soft-primary text-primary">

                     <i
                        class="uil uil-clock">
                     </i>

                  </div>


                  <div class="stat-label">

                     Terjadwal

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalTerjadwal
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

                     Selesai

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalSelesai
                     ) ?>

                  </div>


               </div>


            </div>


            <div class="col-6 col-xl-3">


               <div class="stat-card">


                  <div
                     class="stat-icon bg-soft-yellow text-yellow">

                     <i
                        class="uil uil-edit">
                     </i>

                  </div>


                  <div class="stat-label">

                     Draft

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalDraft
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

                        Jadwal Seleksi

                     </h4>


                     <p
                        class="text-muted mb-0 fs-12">

                        Jadwal yang ditampilkan pada Portal PMB.

                     </p>


                  </div>


                  <button
                     type="button"
                     class="btn btn-primary rounded"
                     data-bs-toggle="modal"
                     data-bs-target="#modalJadwal"
                     onclick="prepareCreate()">


                     <i
                        class="uil uil-plus me-1">
                     </i>


                     Tambah Jadwal


                  </button>


               </div>


               <!-- FILTER -->

               <form
                  method="GET"
                  action="./pmb-jadwal-seleksi.php">


                  <div class="row g-3">


                     <div class="col-lg-5">


                        <div
                           class="input-group">


                           <span
                              class="input-group-text bg-white">


                              <i
                                 class="uil uil-search">
                              </i>


                           </span>


                           <input
                              type="text"
                              name="search"
                              value="<?= h(
                                          $search
                                       ) ?>"
                              class="form-control"
                              placeholder="Cari jadwal, kategori, lokasi...">


                        </div>


                     </div>


                     <div class="col-lg-2">


                        <select
                           name="status"
                           class="form-select">


                           <option
                              value="">

                              Semua Status

                           </option>


                           <option
                              value="DRAFT"
                              <?= $filterStatus ===
                                 'DRAFT'
                                 ? 'selected'
                                 : '' ?>>

                              Draft

                           </option>


                           <option
                              value="TERJADWAL"
                              <?= $filterStatus ===
                                 'TERJADWAL'
                                 ? 'selected'
                                 : '' ?>>

                              Terjadwal

                           </option>


                           <option
                              value="SELESAI"
                              <?= $filterStatus ===
                                 'SELESAI'
                                 ? 'selected'
                                 : '' ?>>

                              Selesai

                           </option>


                           <option
                              value="DIBATALKAN"
                              <?= $filterStatus ===
                                 'DIBATALKAN'
                                 ? 'selected'
                                 : '' ?>>

                              Dibatalkan

                           </option>


                        </select>


                     </div>


                     <div class="col-lg-3">


                        <select
                           name="tahun_akademik"
                           class="form-select">


                           <option
                              value="">

                              Semua Tahun Akademik

                           </option>


                           <?php foreach (
                              $tahunList
                              as $tahun
                           ): ?>


                              <option
                                 value="<?= h(
                                             $tahun
                                          ) ?>"
                                 <?= $filterTahun ===
                                    $tahun
                                    ? 'selected'
                                    : '' ?>>

                                 <?= h(
                                    $tahun
                                 ) ?>

                              </option>


                           <?php endforeach; ?>


                        </select>


                     </div>


                     <div class="col-lg-2">


                        <button
                           type="submit"
                           class="btn btn-outline-primary rounded w-100"
                           style="
                                    min-height:42px;
                                ">


                           <i
                              class="uil uil-filter me-1">
                           </i>


                           Filter


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
                  class="table schedule-table">


                  <thead>


                     <tr>


                        <th>
                           Urutan
                        </th>


                        <th>
                           Seleksi
                        </th>


                        <th>
                           Tanggal
                        </th>


                        <th>
                           Waktu
                        </th>


                        <th>
                           Lokasi
                        </th>


                        <th>
                           Metode
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
                        empty($jadwal)
                     ): ?>


                        <tr>


                           <td
                              colspan="8"
                              class="text-center py-6">


                              <div
                                 class="text-muted">


                                 <i
                                    class="uil uil-calendar-slash"
                                    style="
                                            font-size:42px;
                                            opacity:.35;
                                        ">
                                 </i>


                                 <div
                                    class="mt-2">

                                    Belum ada jadwal seleksi.

                                 </div>


                              </div>


                           </td>


                        </tr>


                     <?php else: ?>


                        <?php foreach (
                           $jadwal
                           as $row
                        ): ?>


                           <?php


                           $statusRow =
                              $row['status'];


                           $statusColor =
                              'secondary';


                           if (
                              $statusRow ===
                              'TERJADWAL'
                           ) {

                              $statusColor =
                                 'primary';
                           } elseif (
                              $statusRow ===
                              'SELESAI'
                           ) {

                              $statusColor =
                                 'success';
                           } elseif (
                              $statusRow ===
                              'DRAFT'
                           ) {

                              $statusColor =
                                 'warning';
                           } elseif (
                              $statusRow ===
                              'DIBATALKAN'
                           ) {

                              $statusColor =
                                 'danger';
                           }


                           ?>


                           <tr>


                              <!-- URUTAN -->

                              <td>

                                 <span
                                    class="
                                        badge
                                        bg-soft-primary
                                        text-primary">

                                    <?= (int)
                                    $row['urutan'] ?>

                                 </span>

                              </td>


                              <!-- SELEKSI -->

                              <td>


                                 <div
                                    class="schedule-title">

                                    <?= h(
                                       $row['nama_seleksi']
                                    ) ?>

                                 </div>


                                 <div
                                    class="schedule-sub">

                                    <?= h(
                                       $row['kategori']
                                    ) ?>

                                    ·

                                    <?= h(
                                       $row['tahun_akademik']
                                    ) ?>

                                 </div>


                                 <?php if (
                                    !empty($row['keterangan'])
                                 ): ?>


                                    <div
                                       class="schedule-sub mt-1">

                                       <?= h(
                                          $row['keterangan']
                                       ) ?>

                                    </div>


                                 <?php endif; ?>


                              </td>


                              <!-- TANGGAL -->

                              <td>


                                 <div
                                    class="date-box">


                                    <?= date(
                                       'd/m/Y',
                                       strtotime(
                                          $row['tanggal']
                                       )
                                    ) ?>


                                 </div>


                              </td>


                              <!-- WAKTU -->

                              <td>


                                 <div
                                    class="time-box">


                                    <?= date(
                                       'H:i',
                                       strtotime(
                                          $row['jam_mulai']
                                       )
                                    ) ?>


                                    -

                                    <?= date(
                                       'H:i',
                                       strtotime(
                                          $row['jam_selesai']
                                       )
                                    ) ?>


                                 </div>


                              </td>


                              <!-- LOKASI -->

                              <td>


                                 <div
                                    class="location-box">


                                    <i
                                       class="uil uil-location-point me-1">
                                    </i>


                                    <?= h(
                                       $row['lokasi']
                                    ) ?>


                                 </div>


                                 <?php if (
                                    !empty($row['ruangan'])
                                 ): ?>


                                    <div
                                       class="schedule-sub">


                                       Ruang:

                                       <?= h(
                                          $row['ruangan']
                                       ) ?>


                                    </div>


                                 <?php endif; ?>


                              </td>


                              <!-- METODE -->

                              <td>


                                 <span
                                    class="
                                        badge
                                        bg-soft-primary
                                        text-primary">

                                    <?= h(
                                       $row['metode']
                                    ) ?>

                                 </span>


                              </td>


                              <!-- STATUS -->

                              <td>


                                 <form
                                    method="POST"
                                    action="./pmb-jadwal-seleksi.php"
                                    class="m-0">


                                    <input
                                       type="hidden"
                                       name="action"
                                       value="change_status">


                                    <input
                                       type="hidden"
                                       name="id"
                                       value="<?= (int)
                                                $row['id'] ?>">


                                    <select
                                       name="status"
                                       class="
                                            form-select
                                            form-select-sm
                                            border-0
                                            bg-soft-<?= $statusColor ?>"
                                       style="
                                                width:125px;
                                                font-size:11px;
                                                font-weight:700;
                                            "
                                       onchange="
                                                this.form.submit();
                                            ">


                                       <option
                                          value="DRAFT"
                                          <?= $statusRow ===
                                             'DRAFT'
                                             ? 'selected'
                                             : '' ?>>

                                          DRAFT

                                       </option>


                                       <option
                                          value="TERJADWAL"
                                          <?= $statusRow ===
                                             'TERJADWAL'
                                             ? 'selected'
                                             : '' ?>>

                                          TERJADWAL

                                       </option>


                                       <option
                                          value="SELESAI"
                                          <?= $statusRow ===
                                             'SELESAI'
                                             ? 'selected'
                                             : '' ?>>

                                          SELESAI

                                       </option>


                                       <option
                                          value="DIBATALKAN"
                                          <?= $statusRow ===
                                             'DIBATALKAN'
                                             ? 'selected'
                                             : '' ?>>

                                          DIBATALKAN

                                       </option>


                                    </select>


                                 </form>


                              </td>


                              <!-- ACTION -->

                              <td>


                                 <div
                                    class="action-group">


                                    <!-- EDIT -->

                                    <button
                                       type="button"
                                       class="
                                            btn
                                            btn-sm
                                            btn-soft-primary
                                            rounded"
                                       title="Edit"
                                       data-bs-toggle="modal"
                                       data-bs-target="#modalJadwal"
                                       onclick='prepareEdit(
                                                <?= json_encode(
                                                   $row,
                                                   JSON_HEX_TAG |
                                                      JSON_HEX_APOS |
                                                      JSON_HEX_AMP |
                                                      JSON_HEX_QUOT
                                                ) ?>
                                            )'>


                                       <i
                                          class="uil uil-edit">
                                       </i>


                                    </button>


                                    <!-- DELETE -->

                                    <form
                                       method="POST"
                                       action="./pmb-jadwal-seleksi.php"
                                       class="m-0"
                                       onsubmit="
                                                return confirm(
                                                    'Yakin ingin menghapus jadwal ini?'
                                                );
                                            ">


                                       <input
                                          type="hidden"
                                          name="action"
                                          value="delete">


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
                                          title="Hapus">


                                          <i
                                             class="uil uil-trash-alt">
                                          </i>


                                       </button>


                                    </form>


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


   <!-- =========================================================
     MODAL TAMBAH / EDIT
========================================================== -->

   <div
      class="modal fade"
      id="modalJadwal"
      tabindex="-1"
      aria-hidden="true">


      <div
         class="modal-dialog modal-lg modal-dialog-centered">


         <div
            class="modal-content"
            style="
                border:0;
                border-radius:14px;
                overflow:hidden;
            ">


            <form
               method="POST"
               action="./pmb-jadwal-seleksi.php">


               <input
                  type="hidden"
                  name="action"
                  id="formAction"
                  value="create">


               <input
                  type="hidden"
                  name="id"
                  id="formId"
                  value="">


               <!-- HEADER -->

               <div
                  class="modal-header"
                  style="
                        border-bottom:
                            1px solid #edf0f3;
                        padding:22px 25px;
                    ">


                  <div>


                     <h5
                        class="modal-title mb-1"
                        id="modalTitle"
                        style="
                                font-weight:800;
                            ">

                        Tambah Jadwal Seleksi

                     </h5>


                     <div
                        class="text-muted fs-11">

                        Isi informasi jadwal seleksi PMB.

                     </div>


                  </div>


                  <button
                     type="button"
                     class="btn-close"
                     data-bs-dismiss="modal">
                  </button>


               </div>


               <!-- BODY -->

               <div
                  class="modal-body"
                  style="
                        padding:25px;
                    ">


                  <div class="row g-4">


                     <!-- NAMA -->

                     <div class="col-md-8">


                        <label
                           class="modal-label">

                           Nama Seleksi
                           <span class="text-danger">*</span>

                        </label>


                        <input
                           type="text"
                           name="nama_seleksi"
                           id="namaSeleksi"
                           class="form-control"
                           placeholder="Contoh: Tes Potensi Akademik"
                           required>


                     </div>


                     <!-- KATEGORI -->

                     <div class="col-md-4">


                        <label
                           class="modal-label">

                           Kategori
                           <span class="text-danger">*</span>

                        </label>


                        <input
                           type="text"
                           name="kategori"
                           id="kategori"
                           class="form-control"
                           placeholder="TPA / Wawancara"
                           required>


                     </div>


                     <!-- TANGGAL -->

                     <div class="col-md-4">


                        <label
                           class="modal-label">

                           Tanggal
                           <span class="text-danger">*</span>

                        </label>


                        <input
                           type="date"
                           name="tanggal"
                           id="tanggal"
                           class="form-control"
                           required>


                     </div>


                     <!-- JAM MULAI -->

                     <div class="col-md-4">


                        <label
                           class="modal-label">

                           Jam Mulai
                           <span class="text-danger">*</span>

                        </label>


                        <input
                           type="time"
                           name="jam_mulai"
                           id="jamMulai"
                           class="form-control"
                           required>


                     </div>


                     <!-- JAM SELESAI -->

                     <div class="col-md-4">


                        <label
                           class="modal-label">

                           Jam Selesai
                           <span class="text-danger">*</span>

                        </label>


                        <input
                           type="time"
                           name="jam_selesai"
                           id="jamSelesai"
                           class="form-control"
                           required>


                     </div>


                     <!-- LOKASI -->

                     <div class="col-md-7">


                        <label
                           class="modal-label">

                           Lokasi
                           <span class="text-danger">*</span>

                        </label>


                        <input
                           type="text"
                           name="lokasi"
                           id="lokasi"
                           class="form-control"
                           placeholder="Contoh: Kampus STIH Graha Kirana"
                           required>


                     </div>


                     <!-- RUANGAN -->

                     <div class="col-md-5">


                        <label
                           class="modal-label">

                           Ruangan

                        </label>


                        <input
                           type="text"
                           name="ruangan"
                           id="ruangan"
                           class="form-control"
                           placeholder="Contoh: Ruang 01">


                     </div>


                     <!-- METODE -->

                     <div class="col-md-5">


                        <label
                           class="modal-label">

                           Metode
                           <span class="text-danger">*</span>

                        </label>


                        <select
                           name="metode"
                           id="metode"
                           class="form-select"
                           required>


                           <option
                              value="Offline">

                              Offline

                           </option>


                           <option
                              value="Online">

                              Online

                           </option>


                           <option
                              value="Hybrid">

                              Hybrid

                           </option>


                        </select>


                     </div>


                     <!-- URUTAN -->

                     <div class="col-md-3">


                        <label
                           class="modal-label">

                           Urutan
                           <span class="text-danger">*</span>

                        </label>


                        <input
                           type="number"
                           name="urutan"
                           id="urutan"
                           class="form-control"
                           min="1"
                           value="1"
                           required>


                     </div>


                     <!-- STATUS -->

                     <div class="col-md-4">


                        <label
                           class="modal-label">

                           Status
                           <span class="text-danger">*</span>

                        </label>


                        <select
                           name="status"
                           id="formStatus"
                           class="form-select"
                           required>


                           <option
                              value="DRAFT">

                              Draft

                           </option>


                           <option
                              value="TERJADWAL">

                              Terjadwal

                           </option>


                           <option
                              value="SELESAI">

                              Selesai

                           </option>


                           <option
                              value="DIBATALKAN">

                              Dibatalkan

                           </option>


                        </select>


                     </div>


                     <!-- TAHUN -->

                     <div class="col-md-4">


                        <label
                           class="modal-label">

                           Tahun Akademik
                           <span class="text-danger">*</span>

                        </label>


                        <input
                           type="text"
                           name="tahun_akademik"
                           id="tahunAkademik"
                           class="form-control"
                           value="<?= h(
                                       $defaultTahun
                                    ) ?>"
                           placeholder="2026/2027"
                           required>


                     </div>


                     <!-- KETERANGAN -->

                     <div class="col-md-8">


                        <label
                           class="modal-label">

                           Keterangan

                        </label>


                        <textarea
                           name="keterangan"
                           id="keterangan"
                           class="form-control"
                           placeholder="Informasi tambahan jadwal..."></textarea>


                     </div>


                  </div>


               </div>


               <!-- FOOTER -->

               <div
                  class="modal-footer"
                  style="
                        border-top:
                            1px solid #edf0f3;
                        padding:18px 25px;
                    ">


                  <button
                     type="button"
                     class="btn btn-outline-secondary rounded"
                     data-bs-dismiss="modal">

                     Batal

                  </button>


                  <button
                     type="submit"
                     class="btn btn-primary rounded">


                     <i
                        class="uil uil-save me-1">
                     </i>


                     <span
                        id="submitText">

                        Simpan Jadwal

                     </span>


                  </button>


               </div>


            </form>


         </div>


      </div>

   </div>


   <!-- =========================================================
     JAVASCRIPT
========================================================== -->

   <script
      src="../assets/js/plugins.js">
   </script>


   <script
      src="../assets/js/theme.js">
   </script>


   <script>
      /**
       * =====================================================
       * CREATE
       * =====================================================
       */

      function prepareCreate() {

         document.getElementById(
               'modalTitle'
            ).innerText =
            'Tambah Jadwal Seleksi';


         document.getElementById(
               'formAction'
            ).value =
            'create';


         document.getElementById(
               'formId'
            ).value =
            '';


         document.getElementById(
               'namaSeleksi'
            ).value =
            '';


         document.getElementById(
               'kategori'
            ).value =
            '';


         document.getElementById(
               'tanggal'
            ).value =
            '';


         document.getElementById(
               'jamMulai'
            ).value =
            '';


         document.getElementById(
               'jamSelesai'
            ).value =
            '';


         document.getElementById(
               'lokasi'
            ).value =
            '';


         document.getElementById(
               'ruangan'
            ).value =
            '';


         document.getElementById(
               'metode'
            ).value =
            'Offline';


         document.getElementById(
               'keterangan'
            ).value =
            '';


         document.getElementById(
               'urutan'
            ).value =
            '1';


         document.getElementById(
               'formStatus'
            ).value =
            'DRAFT';


         document.getElementById(
               'tahunAkademik'
            ).value =
            '<?= h(
                  $defaultTahun
               ) ?>';


         document.getElementById(
               'submitText'
            ).innerText =
            'Simpan Jadwal';

      }


      /**
       * =====================================================
       * EDIT
       * =====================================================
       */

      function prepareEdit(data) {

         document.getElementById(
               'modalTitle'
            ).innerText =
            'Edit Jadwal Seleksi';


         document.getElementById(
               'formAction'
            ).value =
            'update';


         document.getElementById(
               'formId'
            ).value =
            data.id;


         document.getElementById(
               'namaSeleksi'
            ).value =
            data.nama_seleksi || '';


         document.getElementById(
               'kategori'
            ).value =
            data.kategori || '';


         document.getElementById(
               'tanggal'
            ).value =
            data.tanggal || '';


         document.getElementById(
               'jamMulai'
            ).value =
            data.jam_mulai ?
            data.jam_mulai.substring(
               0,
               5
            ) :
            '';


         document.getElementById(
               'jamSelesai'
            ).value =
            data.jam_selesai ?
            data.jam_selesai.substring(
               0,
               5
            ) :
            '';


         document.getElementById(
               'lokasi'
            ).value =
            data.lokasi || '';


         document.getElementById(
               'ruangan'
            ).value =
            data.ruangan || '';


         document.getElementById(
               'metode'
            ).value =
            data.metode || 'Offline';


         document.getElementById(
               'keterangan'
            ).value =
            data.keterangan || '';


         document.getElementById(
               'urutan'
            ).value =
            data.urutan || 1;


         document.getElementById(
               'formStatus'
            ).value =
            data.status || 'DRAFT';


         document.getElementById(
               'tahunAkademik'
            ).value =
            data.tahun_akademik ||
            '<?= h(
                  $defaultTahun
               ) ?>';


         document.getElementById(
               'submitText'
            ).innerText =
            'Simpan Perubahan';

      }
   </script>


</body>

</html>