<?php

session_start();

require_once '../config/connect.php';

if (
   empty($_SESSION['admin_logged_in']) ||
   $_SESSION['admin_logged_in'] !== true ||
   empty($_SESSION['admin_user_id'])
) {
   header('Location: ./index.php');
   exit;
}

function h($value): string
{
   return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function normalizePhone(string $value): string
{
   $value = preg_replace('/[^0-9+]/', '', trim($value));

   if ($value === '') {
      return '';
   }

   if (str_starts_with($value, '+62')) {
      $value = '0' . substr($value, 3);
   } elseif (str_starts_with($value, '62')) {
      $value = '0' . substr($value, 2);
   }

   return preg_replace('/[^0-9]/', '', $value);
}

function uploadDocument(string $fieldName, string $prefix, string $uploadDir, array $allowedExtensions): ?string
{
   if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
      return null;
   }

   if ($_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
      throw new RuntimeException("Upload gagal pada {$fieldName}.");
   }

   $file = $_FILES[$fieldName];
   $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

   if (!in_array($extension, $allowedExtensions, true)) {
      throw new RuntimeException("Format file {$fieldName} tidak didukung.");
   }

   if ($file['size'] > 5 * 1024 * 1024) {
      throw new RuntimeException("Ukuran file {$fieldName} maksimal 5 MB.");
   }

   $filename = $prefix . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
   $destination = $uploadDir . $filename;

   if (!move_uploaded_file($file['tmp_name'], $destination)) {
      throw new RuntimeException("Gagal menyimpan file {$fieldName}.");
   }

   return $filename;
}

$adminName = $_SESSION['admin_fullname'] ?? $_SESSION['admin_username'] ?? 'Administrator';
$adminRole = $_SESSION['admin_roles'] ?? 'admin';

$successMessage = '';
$errorMessage = '';
$errorField = '';
$formData = [
   'fullname' => '',
   'gender' => '',
   'agama' => '',
   'ukuran_baju' => '',
   'place' => '',
   'datebirth' => '',
   'region' => '',
   'address_card' => '',
   'addrees_point' => '',
   'number_id' => '',
   'phone_number' => '',
   'email_register' => '',
   'password' => '',
   'account_status' => 'ACTIVE',
   'tahap_aktif' => '1',
   'status_pendaftaran' => 'REGISTRASI',
   'status_daftar_ulang' => 'BELUM_DIAJUKAN',
   'provinsi' => '',
   'kabupaten' => '',
   'kecamatan' => '',
   'kelurahan' => '',
   'school_name' => '',
   'school_npsn' => '',
   'school_address' => '',
   'number_nisn' => '',
   'year_graduation' => '',
   'number_kip' => '',
   'name_father' => '',
   'name_mother' => '',
   'number_kk' => '',
   'number_nik_kk' => '',
   'parent_address' => '',
   'emergency_name' => '',
   'emergency_phone' => '',
   'emergency_relasi' => '',
   'id_program' => '',
   'id_provider' => '',
   'register_type' => '',
   'nilai_tpa' => '',
   'nilai_wawancara' => '',
   'nilai_akhir' => '',
   'status_kelulusan' => 'BELUM_DIUMUMKAN',
   'catatan_hasil' => '',
   'hasil_diumumkan_at' => '',
   'jenis_pembiayaan' => '',
   'nim' => '',
   'siakad_status' => 'BELUM_AKTIVASI',
   'ktm_status' => 'BELUM_TERBIT',
   'krs_status' => 'BELUM_DIBUKA',
   'deadline_daftar_ulang' => '',
];

foreach ($formData as $key => $value) {
   if (isset($_POST[$key])) {
      $formData[$key] = trim((string) $_POST[$key]);
   }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $data = $formData;
   $data['phone_number'] = normalizePhone($data['phone_number']);
   $data['number_id'] = preg_replace('/[^0-9]/', '', $data['number_id']);
   $data['email_register'] = strtolower(trim($data['email_register']));
   $data['fullname'] = trim($data['fullname']);
   $data['account_status'] = in_array($data['account_status'], ['PENDING', 'ACTIVE', 'BLOCKED'], true)
      ? $data['account_status']
      : 'PENDING';
   $data['status_pendaftaran'] = in_array($data['status_pendaftaran'], ['REGISTRASI', 'DATA_DOKUMEN', 'MENUNGGU_SELEKSI', 'SELEKSI', 'LULUS', 'TIDAK_LULUS', 'DAFTAR_ULANG', 'MAHASISWA'], true)
      ? $data['status_pendaftaran']
      : 'REGISTRASI';
   $data['status_daftar_ulang'] = in_array($data['status_daftar_ulang'], ['BELUM_DIAJUKAN', 'DIAJUKAN', 'DIVERIFIKASI', 'DITERIMA', 'DITOLAK'], true)
      ? $data['status_daftar_ulang']
      : 'BELUM_DIAJUKAN';
   $data['status_kelulusan'] = in_array($data['status_kelulusan'], ['BELUM_DIUMUMKAN', 'LULUS', 'TIDAK_LULUS'], true)
      ? $data['status_kelulusan']
      : 'BELUM_DIUMUMKAN';
   $data['siakad_status'] = in_array($data['siakad_status'], ['BELUM_AKTIVASI', 'AKTIF'], true)
      ? $data['siakad_status']
      : 'BELUM_AKTIVASI';
   $data['ktm_status'] = in_array($data['ktm_status'], ['BELUM_TERBIT', 'TERBIT'], true)
      ? $data['ktm_status']
      : 'BELUM_TERBIT';
   $data['krs_status'] = in_array($data['krs_status'], ['BELUM_DIBUKA', 'DIBUKA', 'SUDAH_DIISI'], true)
      ? $data['krs_status']
      : 'BELUM_DIBUKA';

   $requiredFields = [
      'fullname' => 'Nama lengkap',
      'gender' => 'Jenis kelamin',
      'place' => 'Tempat lahir',
      'datebirth' => 'Tanggal lahir',
      'number_id' => 'NIK',
      'phone_number' => 'Nomor HP',
      'email_register' => 'Email',
      'password' => 'Password',
      'account_status' => 'Status akun',
      'status_pendaftaran' => 'Status pendaftaran',
      'provinsi' => 'Provinsi',
      'kabupaten' => 'Kabupaten',
      'kecamatan' => 'Kecamatan',
      'kelurahan' => 'Kelurahan',
      'school_name' => 'Nama sekolah',
      'name_mother' => 'Nama ibu kandung',
      'id_program' => 'Program studi',
      'register_type' => 'Jenis pendaftaran',
   ];

   foreach ($requiredFields as $field => $label) {
      if ($data[$field] === '') {
         $errorMessage = "Kolom {$label} wajib diisi.";
         $errorField = $field;
         break;
      }
   }

   if ($errorMessage === '') {
      if (!filter_var($data['email_register'], FILTER_VALIDATE_EMAIL)) {
         $errorMessage = 'Format email tidak valid.';
         $errorField = 'email_register';
      }
   }

   if ($errorMessage === '') {
      if (strlen($data['number_id']) !== 16) {
         $errorMessage = 'NIK harus terdiri dari 16 digit.';
         $errorField = 'number_id';
      }
   }

   if ($errorMessage === '') {
      if (strlen($data['phone_number']) < 10 || strlen($data['phone_number']) > 15) {
         $errorMessage = 'Nomor HP tidak valid.';
         $errorField = 'phone_number';
      }
   }

   if ($errorMessage === '') {
      if (empty($data['password']) || strlen($data['password']) < 8) {
         $errorMessage = 'Password minimal 8 karakter.';
         $errorField = 'password';
      }
   }

   if ($errorMessage === '') {
      if ($data['datebirth'] !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['datebirth'])) {
         $errorMessage = 'Format tanggal lahir tidak valid.';
         $errorField = 'datebirth';
      }
   }

   if ($errorMessage === '') {
      $uploadDir = __DIR__ . '/../uploads/pmb/';
      if (!is_dir($uploadDir)) {
         @mkdir($uploadDir, 0755, true);
      }

      try {
         $fileKtp = uploadDocument('file_ktp', 'ktp', $uploadDir, ['pdf']);
         $fileKk = uploadDocument('file_kk', 'kk', $uploadDir, ['pdf']);
         $fileIjazah = uploadDocument('file_ijazah', 'ijazah', $uploadDir, ['pdf']);
         $fileDokumen = uploadDocument('file_dokumen', 'dokumen', $uploadDir, ['jpg', 'jpeg', 'png', 'pdf']);

         $registerUid = bin2hex(random_bytes(12));
         $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

         $sql = "
            INSERT INTO register_pmb (
               fullname,
               gender,
               agama,
               ukuran_baju,
               place,
               datebirth,
               region,
               address_card,
               addrees_point,
               number_id,
               phone_number,
               email_register,
               password_hash,
               account_status,
               tahap_aktif,
               status_pendaftaran,
               status_daftar_ulang,
               deadline_daftar_ulang,
               register_uid,
               nim,
               siakad_status,
               ktm_status,
               krs_status,
               provinsi,
               kabupaten,
               kecamatan,
               kelurahan,
               school_name,
               school_npsn,
               school_address,
               number_nisn,
               year_graduation,
               number_kip,
               name_father,
               name_mother,
               number_kk,
               number_nik_kk,
               parent_address,
               emergency_name,
               emergency_phone,
               emergency_relasi,
               id_program,
               id_provider,
               register_type,
               nilai_tpa,
               nilai_wawancara,
               nilai_akhir,
               status_kelulusan,
               catatan_hasil,
               hasil_diumumkan_at,
               jenis_pembiayaan,
               file_ktp,
               file_kk,
               file_ijazah,
               file_dokumen,
               created_at
            ) VALUES (
               :fullname,
               :gender,
               :agama,
               :ukuran_baju,
               :place,
               :datebirth,
               :region,
               :address_card,
               :addrees_point,
               :number_id,
               :phone_number,
               :email_register,
               :password_hash,
               :account_status,
               :tahap_aktif,
               :status_pendaftaran,
               :status_daftar_ulang,
               :deadline_daftar_ulang,
               :register_uid,
               :nim,
               :siakad_status,
               :ktm_status,
               :krs_status,
               :provinsi,
               :kabupaten,
               :kecamatan,
               :kelurahan,
               :school_name,
               :school_npsn,
               :school_address,
               :number_nisn,
               :year_graduation,
               :number_kip,
               :name_father,
               :name_mother,
               :number_kk,
               :number_nik_kk,
               :parent_address,
               :emergency_name,
               :emergency_phone,
               :emergency_relasi,
               :id_program,
               :id_provider,
               :register_type,
               :nilai_tpa,
               :nilai_wawancara,
               :nilai_akhir,
               :status_kelulusan,
               :catatan_hasil,
               :hasil_diumumkan_at,
               :jenis_pembiayaan,
               :file_ktp,
               :file_kk,
               :file_ijazah,
               :file_dokumen,
               NOW()
            )
         ";

         $stmt = $pdo->prepare($sql);

         $params = [
            ':fullname' => $data['fullname'],
            ':gender' => $data['gender'],
            ':agama' => $data['agama'],
            ':ukuran_baju' => $data['ukuran_baju'],
            ':place' => $data['place'],
            ':datebirth' => $data['datebirth'],
            ':region' => $data['region'] !== '' ? $data['region'] : null,
            ':address_card' => $data['address_card'] !== '' ? $data['address_card'] : null,
            ':addrees_point' => $data['addrees_point'] !== '' ? $data['addrees_point'] : null,
            ':number_id' => $data['number_id'],
            ':phone_number' => $data['phone_number'],
            ':email_register' => $data['email_register'],
            ':password_hash' => $passwordHash,
            ':account_status' => $data['account_status'],
            ':tahap_aktif' => (int) $data['tahap_aktif'],
            ':status_pendaftaran' => $data['status_pendaftaran'],
            ':status_daftar_ulang' => $data['status_daftar_ulang'],
            ':deadline_daftar_ulang' => $data['deadline_daftar_ulang'] !== '' ? $data['deadline_daftar_ulang'] : null,
            ':register_uid' => $registerUid,
            ':nim' => $data['nim'] !== '' ? $data['nim'] : null,
            ':siakad_status' => $data['siakad_status'],
            ':ktm_status' => $data['ktm_status'],
            ':krs_status' => $data['krs_status'],
            ':provinsi' => $data['provinsi'] !== '' ? $data['provinsi'] : null,
            ':kabupaten' => $data['kabupaten'] !== '' ? $data['kabupaten'] : null,
            ':kecamatan' => $data['kecamatan'] !== '' ? $data['kecamatan'] : null,
            ':kelurahan' => $data['kelurahan'] !== '' ? $data['kelurahan'] : null,
            ':school_name' => $data['school_name'] !== '' ? $data['school_name'] : null,
            ':school_npsn' => $data['school_npsn'] !== '' ? $data['school_npsn'] : null,
            ':school_address' => $data['school_address'] !== '' ? $data['school_address'] : null,
            ':number_nisn' => $data['number_nisn'] !== '' ? $data['number_nisn'] : null,
            ':year_graduation' => $data['year_graduation'] !== '' ? $data['year_graduation'] : null,
            ':number_kip' => $data['number_kip'] !== '' ? $data['number_kip'] : null,
            ':name_father' => $data['name_father'] !== '' ? $data['name_father'] : null,
            ':name_mother' => $data['name_mother'],
            ':number_kk' => $data['number_kk'] !== '' ? $data['number_kk'] : null,
            ':number_nik_kk' => $data['number_nik_kk'] !== '' ? $data['number_nik_kk'] : null,
            ':parent_address' => $data['parent_address'] !== '' ? $data['parent_address'] : null,
            ':emergency_name' => $data['emergency_name'] !== '' ? $data['emergency_name'] : null,
            ':emergency_phone' => $data['emergency_phone'] !== '' ? $data['emergency_phone'] : null,
            ':emergency_relasi' => $data['emergency_relasi'] !== '' ? $data['emergency_relasi'] : null,
            ':id_program' => $data['id_program'] !== '' ? (int) $data['id_program'] : null,
            ':id_provider' => $data['id_provider'] !== '' ? (int) $data['id_provider'] : null,
            ':register_type' => $data['register_type'] !== '' ? $data['register_type'] : null,
            ':nilai_tpa' => $data['nilai_tpa'] !== '' ? (float) $data['nilai_tpa'] : null,
            ':nilai_wawancara' => $data['nilai_wawancara'] !== '' ? (float) $data['nilai_wawancara'] : null,
            ':nilai_akhir' => $data['nilai_akhir'] !== '' ? (float) $data['nilai_akhir'] : null,
            ':status_kelulusan' => $data['status_kelulusan'],
            ':catatan_hasil' => $data['catatan_hasil'] !== '' ? $data['catatan_hasil'] : null,
            ':hasil_diumumkan_at' => $data['hasil_diumumkan_at'] !== '' ? $data['hasil_diumumkan_at'] : null,
            ':jenis_pembiayaan' => $data['jenis_pembiayaan'] !== '' ? $data['jenis_pembiayaan'] : null,
            ':file_ktp' => $fileKtp,
            ':file_kk' => $fileKk,
            ':file_ijazah' => $fileIjazah,
            ':file_dokumen' => $fileDokumen,
         ];

         $stmt->execute($params);
         $successMessage = 'Data peserta berhasil ditambahkan.';
         foreach ($formData as $key => $value) {
            $formData[$key] = '';
         }
         $formData['account_status'] = 'ACTIVE';
         $formData['tahap_aktif'] = '1';
         $formData['status_pendaftaran'] = 'REGISTRASI';
         $formData['status_daftar_ulang'] = 'BELUM_DIAJUKAN';
         $formData['status_kelulusan'] = 'BELUM_DIUMUMKAN';
         $formData['siakad_status'] = 'BELUM_AKTIVASI';
         $formData['ktm_status'] = 'BELUM_TERBIT';
         $formData['krs_status'] = 'BELUM_DIBUKA';
      } catch (Throwable $e) {
         $errorMessage = 'Gagal menyimpan data peserta: ' . $e->getMessage();
      }
   }
}

$pageTitle = 'Tambah Peserta';
?>
<!DOCTYPE html>
<html lang="id">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?= h($pageTitle) ?> - Admin PMB</title>
   <link rel="stylesheet" href="../assets/css/plugins.css">
   <link rel="stylesheet" href="../assets/css/style.css">
   <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
   <style>
      body {
         background: #f6f8fb;
      }

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

      .admin-main {
         margin-left: 260px;
         min-height: 100vh;
      }

      .admin-topbar {
         height: 82px;
         background: #fff;
         border-bottom: 1px solid #e9edf2;
         padding: 0 35px;
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

      .form-section {
         padding: 22px;
      }

      .section-title {
         font-size: 14px;
         font-weight: 800;
         margin-bottom: 18px;
         color: #1f2937;
      }

      .form-control,
      .form-select,
      textarea {
         border: 1px solid #e2e8f0;
         border-radius: 10px;
         box-shadow: none;
         font-size: 13px;
         color: #1f2937;
      }

      .form-control:focus,
      .form-select:focus,
      textarea:focus {
         border-color: #86b7fe;
         box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.12);
      }

      .field-label {
         display: block;
         margin-bottom: 8px;
         font-size: 12px;
         font-weight: 700;
         color: #475467;
      }

      .required-dot {
         color: #dc2626;
      }

      .alert {
         border-radius: 12px;
         font-size: 13px;
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

         .admin-topbar {
            height: auto;
            padding: 18px 20px;
         }

         .admin-content {
            padding: 20px 15px;
         }
      }
   </style>
</head>

<body>
   <div class="admin-layout">
      <?php require 'sidebar.php'; ?>
      <main class="admin-main">
         <header class="admin-topbar">
            <div>
               <h1 class="admin-page-title">Tambah Peserta</h1>
               <div class="admin-page-subtitle">Input data registrasi berdasarkan struktur tabel register_pmb</div>
            </div>
            <div class="d-flex align-items-center">
               <div class="admin-avatar"><?= h(strtoupper(substr($adminName, 0, 1))) ?></div>
               <div class="d-none d-md-block">
                  <div class="fw-bold fs-13"><?= h($adminName) ?></div>
                  <div class="text-muted fs-11"><?= h($adminRole) ?></div>
               </div>
            </div>
         </header>

         <div class="admin-content">
            <div class="data-card">
               <div class="data-card-header d-flex justify-content-between align-items-center">
                  <div>
                     <h4 class="mb-1" style="font-size:17px; font-weight:800;">Form Entri Peserta PMB</h4>
                     <p class="text-muted mb-0 fs-12">Data akan ditambahkan ke tabel register_pmb</p>
                  </div>
                  <a href="./peserta.php" class="btn btn-sm btn-outline-secondary rounded">
                     <i class="uil uil-arrow-left me-1"></i> Kembali
                  </a>
               </div>

               <?php if ($successMessage !== ''): ?>
                  <div class="form-section pb-0">
                     <div class="alert alert-success mb-0"><?= h($successMessage) ?></div>
                  </div>
               <?php endif; ?>

               <?php if ($errorMessage !== ''): ?>
                  <div class="form-section pb-0">
                     <div class="alert alert-danger mb-0"><?= h($errorMessage) ?></div>
                  </div>
               <?php endif; ?>

               <form method="POST" enctype="multipart/form-data" action="./peserta-add.php">
                  <div class="form-section">
                     <div class="section-title">Data Pribadi</div>
                     <div class="row g-3">
                        <div class="col-md-6">
                           <label class="field-label">Nama Lengkap <span class="required-dot">*</span></label>
                           <input type="text" name="fullname" class="form-control" value="<?= h($formData['fullname']) ?>" required>
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Jenis Kelamin <span class="required-dot">*</span></label>
                           <select name="gender" class="form-select" required>
                              <option value="">Pilih</option>
                              <option value="Laki-laki" <?= $formData['gender'] === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                              <option value="Perempuan" <?= $formData['gender'] === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                           </select>
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Agama</label>
                           <select name="agama" class="form-select">
                              <option value="">Pilih</option>
                              <option value="Islam" <?= $formData['agama'] === 'Islam' ? 'selected' : '' ?>>Islam</option>
                              <option value="Kristen" <?= $formData['agama'] === 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                              <option value="Katolik" <?= $formData['agama'] === 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                              <option value="Hindu" <?= $formData['agama'] === 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                              <option value="Buddha" <?= $formData['agama'] === 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                              <option value="Konghucu" <?= $formData['agama'] === 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                           </select>
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Ukuran Baju</label>
                           <select name="ukuran_baju" class="form-select">
                              <option value="">Pilih</option>
                              <option value="S" <?= $formData['ukuran_baju'] === 'S' ? 'selected' : '' ?>>S</option>
                              <option value="M" <?= $formData['ukuran_baju'] === 'M' ? 'selected' : '' ?>>M</option>
                              <option value="L" <?= $formData['ukuran_baju'] === 'L' ? 'selected' : '' ?>>L</option>
                              <option value="XL" <?= $formData['ukuran_baju'] === 'XL' ? 'selected' : '' ?>>XL</option>
                              <option value="XXL" <?= $formData['ukuran_baju'] === 'XXL' ? 'selected' : '' ?>>XXL</option>
                           </select>
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Tempat Lahir <span class="required-dot">*</span></label>
                           <input type="text" name="place" class="form-control" value="<?= h($formData['place']) ?>" required>
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Tanggal Lahir <span class="required-dot">*</span></label>
                           <input type="date" name="datebirth" class="form-control" value="<?= h($formData['datebirth']) ?>" required>
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Nomor NIK <span class="required-dot">*</span></label>
                           <input type="text" name="number_id" maxlength="16" class="form-control" value="<?= h($formData['number_id']) ?>" required>
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Nomor HP <span class="required-dot">*</span></label>
                           <input type="text" name="phone_number" class="form-control" value="<?= h($formData['phone_number']) ?>" required>
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Email <span class="required-dot">*</span></label>
                           <input type="email" name="email_register" class="form-control" value="<?= h($formData['email_register']) ?>" required>
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Password <span class="required-dot">*</span></label>
                           <input type="password" name="password" class="form-control" value="<?= h($formData['password']) ?>" required>
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Status Akun</label>
                           <select name="account_status" class="form-select">
                              <option value="PENDING" <?= $formData['account_status'] === 'PENDING' ? 'selected' : '' ?>>PENDING</option>
                              <option value="ACTIVE" <?= $formData['account_status'] === 'ACTIVE' ? 'selected' : '' ?>>ACTIVE</option>
                              <option value="BLOCKED" <?= $formData['account_status'] === 'BLOCKED' ? 'selected' : '' ?>>BLOCKED</option>
                           </select>
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Tahap Aktif</label>
                           <input type="number" name="tahap_aktif" min="1" max="5" class="form-control" value="<?= h($formData['tahap_aktif']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Status Pendaftaran</label>
                           <select name="status_pendaftaran" class="form-select">
                              <option value="REGISTRASI" <?= $formData['status_pendaftaran'] === 'REGISTRASI' ? 'selected' : '' ?>>REGISTRASI</option>
                              <option value="DATA_DOKUMEN" <?= $formData['status_pendaftaran'] === 'DATA_DOKUMEN' ? 'selected' : '' ?>>DATA_DOKUMEN</option>
                              <option value="MENUNGGU_SELEKSI" <?= $formData['status_pendaftaran'] === 'MENUNGGU_SELEKSI' ? 'selected' : '' ?>>MENUNGGU_SELEKSI</option>
                              <option value="SELEKSI" <?= $formData['status_pendaftaran'] === 'SELEKSI' ? 'selected' : '' ?>>SELEKSI</option>
                              <option value="LULUS" <?= $formData['status_pendaftaran'] === 'LULUS' ? 'selected' : '' ?>>LULUS</option>
                              <option value="TIDAK_LULUS" <?= $formData['status_pendaftaran'] === 'TIDAK_LULUS' ? 'selected' : '' ?>>TIDAK_LULUS</option>
                              <option value="DAFTAR_ULANG" <?= $formData['status_pendaftaran'] === 'DAFTAR_ULANG' ? 'selected' : '' ?>>DAFTAR_ULANG</option>
                              <option value="MAHASISWA" <?= $formData['status_pendaftaran'] === 'MAHASISWA' ? 'selected' : '' ?>>MAHASISWA</option>
                           </select>
                        </div>
                     </div>
                  </div>

                  <div class="form-section border-top">
                     <div class="section-title">Alamat & Identitas</div>
                     <div class="row g-3">
                        <div class="col-md-6">
                           <label class="field-label">Alamat KTP</label>
                           <textarea name="address_card" rows="3" class="form-control"><?= h($formData['address_card']) ?></textarea>
                        </div>
                        <div class="col-md-6">
                           <label class="field-label">Alamat Domisili / Titik Lokasi</label>
                           <textarea name="addrees_point" rows="3" class="form-control"><?= h($formData['addrees_point']) ?></textarea>
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Provinsi</label>
                           <input type="text" name="provinsi" class="form-control" value="<?= h($formData['provinsi']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Kabupaten</label>
                           <input type="text" name="kabupaten" class="form-control" value="<?= h($formData['kabupaten']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Kecamatan</label>
                           <input type="text" name="kecamatan" class="form-control" value="<?= h($formData['kecamatan']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Kelurahan</label>
                           <input type="text" name="kelurahan" class="form-control" value="<?= h($formData['kelurahan']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Region</label>
                           <input type="text" name="region" class="form-control" value="<?= h($formData['region']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">No. KK</label>
                           <input type="text" name="number_kk" class="form-control" value="<?= h($formData['number_kk']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">No. NIK KK</label>
                           <input type="text" name="number_nik_kk" class="form-control" value="<?= h($formData['number_nik_kk']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">No. KIP</label>
                           <input type="text" name="number_kip" class="form-control" value="<?= h($formData['number_kip']) ?>">
                        </div>
                     </div>
                  </div>

                  <div class="form-section border-top">
                     <div class="section-title">Sekolah & Pendidikan</div>
                     <div class="row g-3">
                        <div class="col-md-4">
                           <label class="field-label">Nama Sekolah</label>
                           <input type="text" name="school_name" class="form-control" value="<?= h($formData['school_name']) ?>">
                        </div>
                        <div class="col-md-4">
                           <label class="field-label">NPSN</label>
                           <input type="text" name="school_npsn" class="form-control" value="<?= h($formData['school_npsn']) ?>">
                        </div>
                        <div class="col-md-4">
                           <label class="field-label">Alamat Sekolah</label>
                           <input type="text" name="school_address" class="form-control" value="<?= h($formData['school_address']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">NISN</label>
                           <input type="text" name="number_nisn" class="form-control" value="<?= h($formData['number_nisn']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Tahun Lulus</label>
                           <input type="text" name="year_graduation" class="form-control" value="<?= h($formData['year_graduation']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">NIM</label>
                           <input type="text" name="nim" class="form-control" value="<?= h($formData['nim']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Status Siakad</label>
                           <select name="siakad_status" class="form-select">
                              <option value="BELUM_AKTIVASI" <?= $formData['siakad_status'] === 'BELUM_AKTIVASI' ? 'selected' : '' ?>>BELUM_AKTIVASI</option>
                              <option value="AKTIF" <?= $formData['siakad_status'] === 'AKTIF' ? 'selected' : '' ?>>AKTIF</option>
                           </select>
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Status KTM</label>
                           <select name="ktm_status" class="form-select">
                              <option value="BELUM_TERBIT" <?= $formData['ktm_status'] === 'BELUM_TERBIT' ? 'selected' : '' ?>>BELUM_TERBIT</option>
                              <option value="TERBIT" <?= $formData['ktm_status'] === 'TERBIT' ? 'selected' : '' ?>>TERBIT</option>
                           </select>
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Status KRS</label>
                           <select name="krs_status" class="form-select">
                              <option value="BELUM_DIBUKA" <?= $formData['krs_status'] === 'BELUM_DIBUKA' ? 'selected' : '' ?>>BELUM_DIBUKA</option>
                              <option value="DIBUKA" <?= $formData['krs_status'] === 'DIBUKA' ? 'selected' : '' ?>>DIBUKA</option>
                              <option value="SUDAH_DIISI" <?= $formData['krs_status'] === 'SUDAH_DIISI' ? 'selected' : '' ?>>SUDAH_DIISI</option>
                           </select>
                        </div>
                     </div>
                  </div>

                  <div class="form-section border-top">
                     <div class="section-title">Orang Tua & Kontak Darurat</div>
                     <div class="row g-3">
                        <div class="col-md-4">
                           <label class="field-label">Nama Ayah</label>
                           <input type="text" name="name_father" class="form-control" value="<?= h($formData['name_father']) ?>">
                        </div>
                        <div class="col-md-4">
                           <label class="field-label">Nama Ibu <span class="required-dot">*</span></label>
                           <input type="text" name="name_mother" class="form-control" value="<?= h($formData['name_mother']) ?>" required>
                        </div>
                        <div class="col-md-4">
                           <label class="field-label">Alamat Orang Tua</label>
                           <input type="text" name="parent_address" class="form-control" value="<?= h($formData['parent_address']) ?>">
                        </div>
                        <div class="col-md-4">
                           <label class="field-label">Nama Kontak Darurat</label>
                           <input type="text" name="emergency_name" class="form-control" value="<?= h($formData['emergency_name']) ?>">
                        </div>
                        <div class="col-md-4">
                           <label class="field-label">No HP Kontak Darurat</label>
                           <input type="text" name="emergency_phone" class="form-control" value="<?= h($formData['emergency_phone']) ?>">
                        </div>
                        <div class="col-md-4">
                           <label class="field-label">Hubungan Darurat</label>
                           <input type="text" name="emergency_relasi" class="form-control" value="<?= h($formData['emergency_relasi']) ?>">
                        </div>
                     </div>
                  </div>

                  <div class="form-section border-top">
                     <div class="section-title">Program & Seleksi</div>
                     <div class="row g-3">
                        <div class="col-md-3">
                           <label class="field-label">ID Program</label>
                           <input type="number" name="id_program" min="1" class="form-control" value="<?= h($formData['id_program']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">ID Provider</label>
                           <input type="number" name="id_provider" min="1" class="form-control" value="<?= h($formData['id_provider']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Jenis Pendaftaran</label>
                           <input type="text" name="register_type" class="form-control" value="<?= h($formData['register_type']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Jenis Pembiayaan</label>
                           <input type="text" name="jenis_pembiayaan" class="form-control" value="<?= h($formData['jenis_pembiayaan']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Status Daftar Ulang</label>
                           <select name="status_daftar_ulang" class="form-select">
                              <option value="BELUM_DIAJUKAN" <?= $formData['status_daftar_ulang'] === 'BELUM_DIAJUKAN' ? 'selected' : '' ?>>BELUM_DIAJUKAN</option>
                              <option value="DIAJUKAN" <?= $formData['status_daftar_ulang'] === 'DIAJUKAN' ? 'selected' : '' ?>>DIAJUKAN</option>
                              <option value="DIVERIFIKASI" <?= $formData['status_daftar_ulang'] === 'DIVERIFIKASI' ? 'selected' : '' ?>>DIVERIFIKASI</option>
                              <option value="DITERIMA" <?= $formData['status_daftar_ulang'] === 'DITERIMA' ? 'selected' : '' ?>>DITERIMA</option>
                              <option value="DITOLAK" <?= $formData['status_daftar_ulang'] === 'DITOLAK' ? 'selected' : '' ?>>DITOLAK</option>
                           </select>
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Deadline Daftar Ulang</label>
                           <input type="datetime-local" name="deadline_daftar_ulang" class="form-control" value="<?= h($formData['deadline_daftar_ulang']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Nilai TPA</label>
                           <input type="number" step="0.01" name="nilai_tpa" class="form-control" value="<?= h($formData['nilai_tpa']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Nilai Wawancara</label>
                           <input type="number" step="0.01" name="nilai_wawancara" class="form-control" value="<?= h($formData['nilai_wawancara']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Nilai Akhir</label>
                           <input type="number" step="0.01" name="nilai_akhir" class="form-control" value="<?= h($formData['nilai_akhir']) ?>">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Status Kelulusan</label>
                           <select name="status_kelulusan" class="form-select">
                              <option value="BELUM_DIUMUMKAN" <?= $formData['status_kelulusan'] === 'BELUM_DIUMUMKAN' ? 'selected' : '' ?>>BELUM_DIUMUMKAN</option>
                              <option value="LULUS" <?= $formData['status_kelulusan'] === 'LULUS' ? 'selected' : '' ?>>LULUS</option>
                              <option value="TIDAK_LULUS" <?= $formData['status_kelulusan'] === 'TIDAK_LULUS' ? 'selected' : '' ?>>TIDAK_LULUS</option>
                           </select>
                        </div>
                        <div class="col-md-6">
                           <label class="field-label">Catatan Hasil</label>
                           <textarea name="catatan_hasil" rows="3" class="form-control"><?= h($formData['catatan_hasil']) ?></textarea>
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">Hasil Diumumkan At</label>
                           <input type="datetime-local" name="hasil_diumumkan_at" class="form-control" value="<?= h($formData['hasil_diumumkan_at']) ?>">
                        </div>
                     </div>
                  </div>

                  <div class="form-section border-top">
                     <div class="section-title">Dokumen</div>
                     <div class="row g-3">
                        <div class="col-md-3">
                           <label class="field-label">File KTP</label>
                           <input type="file" name="file_ktp" accept="application/pdf" class="form-control">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">File KK</label>
                           <input type="file" name="file_kk" accept="application/pdf" class="form-control">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">File Ijazah</label>
                           <input type="file" name="file_ijazah" accept="application/pdf" class="form-control">
                        </div>
                        <div class="col-md-3">
                           <label class="field-label">File Dokumen / Pasfoto</label>
                           <input type="file" name="file_dokumen" accept="image/*,.pdf" class="form-control">
                        </div>
                     </div>
                  </div>

                  <div class="form-section border-top">
                     <div class="d-flex justify-content-end gap-2">
                        <a href="./peserta.php" class="btn btn-outline-secondary rounded">Batal</a>
                        <button type="submit" class="btn btn-primary rounded">
                           <i class="uil uil-save me-1"></i> Simpan Peserta
                        </button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </main>
   </div>
</body>

</html>