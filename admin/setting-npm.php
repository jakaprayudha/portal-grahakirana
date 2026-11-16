<?php

/**
 * =========================================================
 * SETTING NPM TERTINGGI PER PROGRAM STUDI
 * ADMIN PMB - STIH GRAHA KIRANA
 * =========================================================
 *
 * Admin dapat menentukan NPM tertinggi (terakhir terpakai)
 * untuk setiap program studi. Nilai ini dipakai oleh
 * generate-npm.php sebagai batas bawah nomor urut, sehingga
 * NPM baru akan melanjutkan dari NPM tertinggi tersebut.
 *
 * Format NPM (12 digit):
 *
 *   YY + KODE KAMPUS + KODE PRODI + KODE TIPE + URUT
 *   26     69            01           01        0050
 */

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
      (string) ($value ?? ''),
      ENT_QUOTES,
      'UTF-8'
   );
}


/**
 * Prefix nomor urut prodi: YY + college(2) + program(2)
 */
function npmPrefixProdi(
   string $tahunCode,
   ?string $collegeCode,
   ?string $programCode
): ?string {

   $collegeCode = trim((string) $collegeCode);
   $programCode = trim((string) $programCode);

   if ($collegeCode === '' || $programCode === '') {
      return null;
   }

   return $tahunCode
      . str_pad($collegeCode, 2, '0', STR_PAD_LEFT)
      . str_pad(substr($programCode, 0, 2), 2, '0', STR_PAD_LEFT);
}


/**
 * Panjang NPM: prefix (6) + tipe (2) + urut (4)
 */
const NPM_LENGTH = 12;


/**
 * =========================================================
 * CSRF
 * =========================================================
 */

if (empty($_SESSION['csrf_setting_npm'])) {
   $_SESSION['csrf_setting_npm'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_setting_npm'];


/**
 * =========================================================
 * TABEL setting_npm
 * =========================================================
 */

$successMessage = '';
$errorMessage = '';

try {

   $pdo->exec("

      CREATE TABLE IF NOT EXISTS setting_npm (

         id_program     INT          NOT NULL,
         npm_tertinggi  VARCHAR(20)  NOT NULL,
         keterangan     VARCHAR(255) NULL,
         updated_by     VARCHAR(100) NULL,
         updated_at     DATETIME     NOT NULL
                        DEFAULT CURRENT_TIMESTAMP
                        ON UPDATE CURRENT_TIMESTAMP,

         PRIMARY KEY (id_program)

      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4

   ");
} catch (Throwable $e) {

   $errorMessage =
      'Tabel setting_npm gagal disiapkan: '
      . $e->getMessage();
}


/**
 * =========================================================
 * TAHUN ANGKATAN (YY)
 * =========================================================
 */

$tahunSekarang = (int) date('Y');

$tahunPilihan = filter_input(
   INPUT_GET,
   'tahun',
   FILTER_VALIDATE_INT
) ?: $tahunSekarang;

if (
   $tahunPilihan < 2000 ||
   $tahunPilihan > $tahunSekarang + 1
) {
   $tahunPilihan = $tahunSekarang;
}

$tahunCode = substr((string) $tahunPilihan, -2);


/**
 * =========================================================
 * FLASH MESSAGE
 * =========================================================
 */

if (!empty($_SESSION['flash_setting_npm'])) {

   $flash = $_SESSION['flash_setting_npm'];

   unset($_SESSION['flash_setting_npm']);

   if (($flash['type'] ?? '') === 'success') {
      $successMessage = (string) $flash['message'];
   } else {
      $errorMessage = (string) $flash['message'];
   }
}


/**
 * =========================================================
 * POST: SIMPAN / RESET
 * =========================================================
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   $flashType = 'error';
   $flashMessage = '';

   try {

      if (
         !hash_equals(
            $csrfToken,
            (string) ($_POST['csrf_token'] ?? '')
         )
      ) {
         throw new Exception('Sesi formulir tidak valid. Silakan muat ulang halaman.');
      }

      $action = (string) ($_POST['action'] ?? '');

      $idProgram = filter_input(
         INPUT_POST,
         'id_program',
         FILTER_VALIDATE_INT
      );

      if (!$idProgram || $idProgram < 1) {
         throw new Exception('Program studi tidak valid.');
      }

      $stmtProdi = $pdo->prepare("

         SELECT
            ps.id_program,
            ps.program_name,
            ps.program_code,
            mc.college_code

         FROM ms_program_studi ps

         LEFT JOIN ms_collage mc
            ON mc.id_collage = CAST(ps.id_collage AS UNSIGNED)

         WHERE ps.id_program = :id

         LIMIT 1

      ");

      $stmtProdi->execute(['id' => $idProgram]);

      $prodi = $stmtProdi->fetch(PDO::FETCH_ASSOC);

      if (!$prodi) {
         throw new Exception('Program studi tidak ditemukan.');
      }


      if ($action === 'reset') {

         $pdo->prepare("
            DELETE FROM setting_npm
            WHERE id_program = :id
         ")->execute(['id' => $idProgram]);

         $flashType = 'success';
         $flashMessage =
            'Setting NPM untuk '
            . $prodi['program_name']
            . ' berhasil dihapus.';
      } elseif ($action === 'save') {

         $npm = preg_replace(
            '/\s+/',
            '',
            (string) ($_POST['npm_tertinggi'] ?? '')
         );

         $keterangan = trim((string) ($_POST['keterangan'] ?? ''));

         if (mb_strlen($keterangan) > 255) {
            $keterangan = mb_substr($keterangan, 0, 255);
         }

         if (!ctype_digit($npm) || strlen($npm) !== NPM_LENGTH) {
            throw new Exception(
               'NPM tertinggi harus berupa angka '
               . NPM_LENGTH
               . ' digit.'
            );
         }

         /**
          * Digit 3-6 (kode kampus + kode prodi)
          * harus sesuai dengan program studi.
          */
         $prefixProdi = npmPrefixProdi(
            substr($npm, 0, 2),
            $prodi['college_code'],
            $prodi['program_code']
         );

         if ($prefixProdi === null) {
            throw new Exception(
               'College code / program code untuk '
               . $prodi['program_name']
               . ' belum lengkap.'
            );
         }

         if (strpos($npm, $prefixProdi) !== 0) {
            throw new Exception(
               'NPM '
               . $npm
               . ' tidak sesuai dengan kode kampus & prodi '
               . $prodi['program_name']
               . ' (digit ke-3 s/d 6 harus '
               . substr($prefixProdi, 2)
               . ').'
            );
         }

         $kodeTipe = substr($npm, 6, 2);

         if (!in_array($kodeTipe, ['01', '02', '03'], true)) {
            throw new Exception(
               'Kode tipe (digit ke-7 s/d 8) harus 01, 02 atau 03.'
            );
         }

         if ((int) substr($npm, -4) < 1) {
            throw new Exception('Nomor urut (4 digit terakhir) minimal 0001.');
         }

         $pdo->prepare("

            INSERT INTO setting_npm
               (id_program, npm_tertinggi, keterangan, updated_by, updated_at)

            VALUES
               (:id_program, :npm, :keterangan, :updated_by, NOW())

            ON DUPLICATE KEY UPDATE
               npm_tertinggi = VALUES(npm_tertinggi),
               keterangan    = VALUES(keterangan),
               updated_by    = VALUES(updated_by),
               updated_at    = NOW()

         ")->execute([
            'id_program' => $idProgram,
            'npm'        => $npm,
            'keterangan' => $keterangan !== '' ? $keterangan : null,
            'updated_by' => mb_substr((string) $adminName, 0, 100),
         ]);

         $flashType = 'success';
         $flashMessage =
            'NPM tertinggi '
            . $prodi['program_name']
            . ' disimpan: '
            . $npm
            . '. NPM berikutnya mulai dari urut '
            . str_pad((string) ((int) substr($npm, -4) + 1), 4, '0', STR_PAD_LEFT)
            . '.';
      } else {
         throw new Exception('Aksi tidak dikenali.');
      }
   } catch (Throwable $e) {

      $flashType = 'error';
      $flashMessage = $e->getMessage();
   }

   $_SESSION['flash_setting_npm'] = [
      'type'    => $flashType,
      'message' => $flashMessage,
   ];

   header('Location: ./setting-npm?tahun=' . $tahunPilihan);
   exit;
}


/**
 * =========================================================
 * DATA PRODI + NPM TERTINGGI
 * =========================================================
 */

$prodiList = [];

try {

   $prodiList = $pdo->query("

      SELECT
         ps.id_program,
         ps.program_name,
         ps.program_degree,
         ps.program_code,
         mc.collage_name,
         mc.college_code,
         sn.npm_tertinggi,
         sn.keterangan,
         sn.updated_by,
         sn.updated_at

      FROM ms_program_studi ps

      LEFT JOIN ms_collage mc
         ON mc.id_collage = CAST(ps.id_collage AS UNSIGNED)

      LEFT JOIN setting_npm sn
         ON sn.id_program = ps.id_program

      ORDER BY ps.program_name ASC

   ")->fetchAll(PDO::FETCH_ASSOC);


   /**
    * NPM tertinggi yang sudah terpakai di database
    * (register_pmb & ms_student) untuk tahun terpilih.
    */

   $stmtMaxRegister = $pdo->prepare("

      SELECT TRIM(npm_sementara)

      FROM register_pmb

      WHERE npm_sementara IS NOT NULL
        AND CHAR_LENGTH(TRIM(npm_sementara)) = :len
        AND TRIM(npm_sementara) REGEXP '^[0-9]+$'
        AND LEFT(TRIM(npm_sementara), 6) = :prefix

      ORDER BY CAST(RIGHT(TRIM(npm_sementara), 4) AS UNSIGNED) DESC

      LIMIT 1

   ");

   $stmtMaxStudent = $pdo->prepare("

      SELECT TRIM(student_npm)

      FROM ms_student

      WHERE student_npm IS NOT NULL
        AND CHAR_LENGTH(TRIM(student_npm)) = :len
        AND TRIM(student_npm) REGEXP '^[0-9]+$'
        AND LEFT(TRIM(student_npm), 6) = :prefix

      ORDER BY CAST(RIGHT(TRIM(student_npm), 4) AS UNSIGNED) DESC

      LIMIT 1

   ");

   foreach ($prodiList as &$row) {

      $prefix = npmPrefixProdi(
         $tahunCode,
         $row['college_code'],
         $row['program_code']
      );

      $row['prefix'] = $prefix;
      $row['npm_db'] = '';
      $row['setting_berlaku'] = false;
      $row['next_urut'] = null;

      if ($prefix === null) {
         continue;
      }

      $params = ['len' => NPM_LENGTH, 'prefix' => $prefix];

      $stmtMaxRegister->execute($params);
      $npmRegister = (string) ($stmtMaxRegister->fetchColumn() ?: '');

      $stmtMaxStudent->execute($params);
      $npmStudent = (string) ($stmtMaxStudent->fetchColumn() ?: '');

      $urutRegister = $npmRegister !== '' ? (int) substr($npmRegister, -4) : 0;
      $urutStudent  = $npmStudent  !== '' ? (int) substr($npmStudent, -4) : 0;

      $row['npm_db'] = $urutRegister >= $urutStudent ? $npmRegister : $npmStudent;

      $urutSetting = 0;
      $npmSetting = trim((string) ($row['npm_tertinggi'] ?? ''));

      if (
         $npmSetting !== '' &&
         strlen($npmSetting) === NPM_LENGTH &&
         strpos($npmSetting, $prefix) === 0
      ) {
         $row['setting_berlaku'] = true;
         $urutSetting = (int) substr($npmSetting, -4);
      }

      $row['next_urut'] = str_pad(
         (string) (max($urutRegister, $urutStudent, $urutSetting) + 1),
         4,
         '0',
         STR_PAD_LEFT
      );
   }

   unset($row);
} catch (Throwable $e) {

   $errorMessage = $errorMessage !== ''
      ? $errorMessage
      : 'Gagal memuat data: ' . $e->getMessage();
}


$totalProdi = count($prodiList);

$totalTerseting = count(
   array_filter(
      $prodiList,
      fn($r) => trim((string) ($r['npm_tertinggi'] ?? '')) !== ''
   )
);


$pageTitle = 'Setting NPM';

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

      /* ================= SIDEBAR ================= */

      .admin-sidebar {
         width: 260px;
         min-height: 100vh;
         position: fixed;
         left: 0;
         top: 0;
         bottom: 0;
         background: #fff;
         border-right: 1px solid #e9edf2;
         z-index: 1000;
         display: flex;
         flex-direction: column;
      }

      .admin-brand {
         height: 82px;
         padding: 20px 24px;
         display: flex;
         align-items: center;
         border-bottom: 1px solid #edf0f3;
      }

      .admin-brand-icon {
         width: 42px;
         height: 42px;
         min-width: 42px;
         border-radius: 10px;
         background: linear-gradient(135deg, #173f75, #0d6efd);
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
         border-top: 1px solid #edf0f3;
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

      /* ================= MAIN ================= */

      .admin-main {
         margin-left: 260px;
         min-height: 100vh;
      }

      .admin-topbar {
         min-height: 82px;
         background: #fff;
         border-bottom: 1px solid #e9edf2;
         padding: 15px 35px;
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

      /* ================= STATS ================= */

      .stat-card {
         background: #fff;
         border: 1px solid #edf0f3;
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

      /* ================= CARD / TABLE ================= */

      .data-card {
         background: #fff;
         border: 1px solid #edf0f3;
         border-radius: 13px;
         overflow: hidden;
      }

      .data-card-header {
         padding: 22px;
         border-bottom: 1px solid #edf0f3;
      }

      .filter-select {
         height: 44px;
         border: 1px solid #e1e5ea;
         border-radius: 9px;
         font-size: 13px;
      }

      .data-table {
         margin: 0;
      }

      .data-table thead th {
         background: #fafbfc;
         border-bottom: 1px solid #edf0f3;
         color: #9299a3;
         font-size: 10px;
         font-weight: 800;
         text-transform: uppercase;
         letter-spacing: .4px;
         padding: 13px 15px;
         white-space: nowrap;
      }

      .data-table tbody td {
         padding: 15px;
         border-color: #f0f2f5;
         font-size: 12px;
         vertical-align: middle;
      }

      .prodi-name {
         font-weight: 700;
         color: #30363d;
      }

      .prodi-sub {
         color: #9299a3;
         font-size: 10px;
         margin-top: 3px;
      }

      .npm-code {
         font-family: monospace;
         font-size: 13px;
         font-weight: 700;
         color: #0d6efd;
         letter-spacing: .5px;
      }

      .npm-muted {
         color: #b3bac4;
      }

      .npm-input {
         font-family: monospace;
         letter-spacing: .5px;
         height: 38px;
         font-size: 13px;
         min-width: 150px;
      }

      .info-box {
         background: #eef4ff;
         border: 1px solid #dbe7ff;
         color: #3f5d88;
         border-radius: 13px;
         padding: 18px 20px;
         font-size: 12px;
      }

      .info-box code {
         font-size: 12px;
      }

      /* ================= RESPONSIVE ================= */

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

         .admin-nav,
         .admin-sidebar-footer {
            display: none;
         }

         .admin-topbar {
            padding: 18px 20px;
         }

         .admin-content {
            padding: 20px 15px;
         }
      }
   </style>

</head>

<body>

   <?php require 'sidebar.php'; ?>

   <main class="admin-main">

      <!-- TOPBAR -->

      <header class="admin-topbar">

         <div>

            <h1 class="admin-page-title">
               Setting NPM
            </h1>

            <div class="admin-page-subtitle">
               Pengaturan NPM tertinggi untuk setiap program studi
            </div>

         </div>

         <div class="d-flex align-items-center">

            <div class="admin-avatar">
               <?= h(strtoupper(substr($adminName, 0, 1))) ?>
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


      <!-- CONTENT -->

      <div class="admin-content">

         <?php if ($successMessage !== ''): ?>

            <div class="alert alert-success alert-icon mb-4">
               <i class="uil uil-check-circle"></i>
               <?= h($successMessage) ?>
            </div>

         <?php endif; ?>

         <?php if ($errorMessage !== ''): ?>

            <div class="alert alert-danger alert-icon mb-4">
               <i class="uil uil-times-circle"></i>
               <?= h($errorMessage) ?>
            </div>

         <?php endif; ?>


         <!-- STATS -->

         <div class="row g-4 mb-5">

            <div class="col-6 col-xl-3">
               <div class="stat-card">
                  <div class="stat-icon bg-soft-primary text-primary">
                     <i class="uil uil-books"></i>
                  </div>
                  <div class="stat-label">Program Studi</div>
                  <div class="stat-value"><?= number_format($totalProdi) ?></div>
               </div>
            </div>

            <div class="col-6 col-xl-3">
               <div class="stat-card">
                  <div class="stat-icon bg-soft-green text-green">
                     <i class="uil uil-check-circle"></i>
                  </div>
                  <div class="stat-label">Sudah Di-setting</div>
                  <div class="stat-value"><?= number_format($totalTerseting) ?></div>
               </div>
            </div>

         </div>


         <!-- INFO -->

         <div class="info-box mb-4">

            <div class="fw-bold mb-2">
               <i class="uil uil-info-circle me-1"></i>
               Cara kerja
            </div>

            Format NPM: <code>YY</code> tahun + <code>KK</code> kode kampus +
            <code>PP</code> kode prodi + <code>TT</code> tipe
            (01 Reguler, 02 Eksekutif, 03 Pindahan) + <code>NNNN</code> nomor urut.
            <br>
            Nomor urut berlanjut untuk semua tipe dalam tahun + prodi yang sama.
            Saat generate NPM, sistem mengambil nomor urut tertinggi dari data
            NPM yang sudah ada <strong>dan</strong> NPM tertinggi yang di-setting di sini,
            lalu menambah 1. Setting hanya berlaku jika tahun (YY) pada NPM
            setting sama dengan tahun angkatan peserta.

         </div>


         <!-- TABLE -->

         <div class="data-card">

            <div class="data-card-header">

               <form method="get" class="row g-3 align-items-center">

                  <div class="col-md-6">
                     <div class="fw-bold">Daftar Program Studi</div>
                     <div class="text-muted fs-12">
                        Data NPM terpakai &amp; nomor urut berikutnya untuk angkatan
                        <?= h($tahunPilihan) ?>
                     </div>
                  </div>

                  <div class="col-md-3 ms-auto">
                     <select
                        name="tahun"
                        class="form-select filter-select"
                        onchange="this.form.submit()">

                        <?php for ($y = $tahunSekarang + 1; $y >= $tahunSekarang - 5; $y--): ?>

                           <option
                              value="<?= $y ?>"
                              <?= $y === $tahunPilihan ? 'selected' : '' ?>>
                              Angkatan <?= $y ?>
                           </option>

                        <?php endfor; ?>

                     </select>
                  </div>

               </form>

            </div>


            <div class="table-responsive">

               <table class="table data-table">

                  <thead>
                     <tr>
                        <th>Program Studi</th>
                        <th>Prefix</th>
                        <th>NPM Tertinggi (Data)</th>
                        <th>NPM Tertinggi (Setting)</th>
                        <th>Urut Berikutnya</th>
                        <th style="min-width: 380px;">Ubah Setting</th>
                     </tr>
                  </thead>

                  <tbody>

                     <?php if (empty($prodiList)): ?>

                        <tr>
                           <td colspan="6" class="text-center text-muted py-5">
                              Belum ada data program studi.
                           </td>
                        </tr>

                     <?php else: ?>

                        <?php foreach ($prodiList as $row): ?>

                           <?php
                           $npmSetting = trim((string) ($row['npm_tertinggi'] ?? ''));
                           ?>

                           <tr>

                              <!-- PRODI -->

                              <td>
                                 <div class="prodi-name">
                                    <?= h(trim(($row['program_degree'] ?? '') . ' ' . $row['program_name'])) ?>
                                 </div>
                                 <div class="prodi-sub">
                                    <?= h($row['collage_name'] ?? '-') ?>
                                 </div>
                              </td>

                              <!-- PREFIX -->

                              <td>
                                 <?php if ($row['prefix'] === null): ?>
                                    <span class="badge bg-soft-red text-red">
                                       Kode belum lengkap
                                    </span>
                                 <?php else: ?>
                                    <span class="npm-code"><?= h($row['prefix']) ?></span><span class="npm-muted">TTNNNN</span>
                                 <?php endif; ?>
                              </td>

                              <!-- NPM DB -->

                              <td>
                                 <?php if ($row['npm_db'] !== ''): ?>
                                    <span class="npm-code"><?= h($row['npm_db']) ?></span>
                                 <?php else: ?>
                                    <span class="text-muted">-</span>
                                 <?php endif; ?>
                              </td>

                              <!-- NPM SETTING -->

                              <td>
                                 <?php if ($npmSetting !== ''): ?>

                                    <span class="npm-code"><?= h($npmSetting) ?></span>

                                    <?php if (!$row['setting_berlaku']): ?>
                                       <div>
                                          <span class="badge bg-soft-yellow text-yellow mt-1">
                                             Beda angkatan
                                          </span>
                                       </div>
                                    <?php endif; ?>

                                    <div class="prodi-sub">
                                       <?= h($row['updated_by'] ?? '') ?>
                                       <?= !empty($row['updated_at'])
                                          ? '· ' . h(date('d/m/Y H:i', strtotime($row['updated_at'])))
                                          : '' ?>
                                    </div>

                                    <?php if (!empty($row['keterangan'])): ?>
                                       <div class="prodi-sub">
                                          <?= h($row['keterangan']) ?>
                                       </div>
                                    <?php endif; ?>

                                 <?php else: ?>
                                    <span class="text-muted">Belum di-setting</span>
                                 <?php endif; ?>
                              </td>

                              <!-- NEXT -->

                              <td>
                                 <?php if ($row['next_urut'] !== null): ?>
                                    <span class="badge bg-soft-primary text-primary fs-12">
                                       <?= h($row['next_urut']) ?>
                                    </span>
                                 <?php else: ?>
                                    <span class="text-muted">-</span>
                                 <?php endif; ?>
                              </td>

                              <!-- FORM -->

                              <td>

                                 <form
                                    method="post"
                                    action="./setting-npm?tahun=<?= h($tahunPilihan) ?>"
                                    class="d-flex flex-wrap gap-2 align-items-center">

                                    <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">
                                    <input type="hidden" name="id_program" value="<?= h($row['id_program']) ?>">

                                    <input
                                       type="text"
                                       name="npm_tertinggi"
                                       class="form-control npm-input"
                                       style="width: 160px;"
                                       inputmode="numeric"
                                       pattern="[0-9]{12}"
                                       maxlength="12"
                                       placeholder="<?= h(($row['prefix'] ?? $tahunCode . 'KKPP') . '01NNNN') ?>"
                                       value="<?= h($npmSetting) ?>"
                                       title="NPM 12 digit angka"
                                       required>

                                    <input
                                       type="text"
                                       name="keterangan"
                                       class="form-control npm-input"
                                       style="width: 120px; font-family: inherit;"
                                       maxlength="255"
                                       placeholder="Keterangan"
                                       value="<?= h($row['keterangan'] ?? '') ?>">

                                    <button
                                       type="submit"
                                       name="action"
                                       value="save"
                                       class="btn btn-sm btn-primary rounded"
                                       onclick="return confirm('Simpan NPM tertinggi untuk prodi ini?');">
                                       <i class="uil uil-save"></i>
                                    </button>

                                    <?php if ($npmSetting !== ''): ?>

                                       <button
                                          type="submit"
                                          name="action"
                                          value="reset"
                                          formnovalidate
                                          class="btn btn-sm btn-outline-danger rounded"
                                          title="Hapus setting"
                                          onclick="return confirm('Hapus setting NPM untuk prodi ini?');">
                                          <i class="uil uil-trash-alt"></i>
                                       </button>

                                    <?php endif; ?>

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

</body>

</html>
