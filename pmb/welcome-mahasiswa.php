<?php

/**
 * =========================================================
 * WELCOME MAHASISWA
 * =========================================================
 */

ob_start();

session_start();

require_once __DIR__ . '/../config/connect.php';


/**
 * =========================================================
 * HELPER
 * =========================================================
 */

function h($value): string
{
   return htmlspecialchars(
      (string) ($value ?? '-'),
      ENT_QUOTES,
      'UTF-8'
   );
}


/**
 * =========================================================
 * AUTHENTICATION
 * =========================================================
 */

if (
   empty($_SESSION['pmb_logged_in']) ||
   empty($_SESSION['pmb_user_id'])
) {

   header(
      'Location: ./login-pmb.php'
   );

   exit;
}


$userId =
   (int) $_SESSION['pmb_user_id'];


/**
 * =========================================================
 * GET DATA MAHASISWA
 * =========================================================
 */

try {

   $stmt = $pdo->prepare("
        SELECT
            id,
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
            register_uid,
            status_pendaftaran,
            tahap_aktif,
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

            nim,
            siakad_status,

            created_at,
            updated_at

        FROM register_pmb

        WHERE id = :id

        LIMIT 1
    ");


   $stmt->execute([
      'id' => $userId
   ]);


   $mahasiswa =
      $stmt->fetch(
         PDO::FETCH_ASSOC
      );


   if (!$mahasiswa) {

      session_unset();

      session_destroy();

      header(
         'Location: ./login-pmb.php'
      );

      exit;
   }
} catch (PDOException $e) {

   die('Gagal mengambil data mahasiswa.');
}


/**
 * =========================================================
 * CEK STATUS SIAKAD
 * =========================================================
 */

$siakadStatus =
   strtoupper(
      trim(
         $mahasiswa['siakad_status']
            ?? ''
      )
   );


if (
   $siakadStatus !== 'AKTIF'
) {

   header(
      'Location: ./aktivasi-siakad.php'
   );

   exit;
}


/**
 * =========================================================
 * DATA DISPLAY
 * =========================================================
 */

$nama =
   $mahasiswa['fullname']
   ?: '-';


$npm =
   $mahasiswa['nim']
   ?: '-';


$email =
   $mahasiswa['email_register']
   ?: '-';


$phone =
   $mahasiswa['phone_number']
   ?: '-';


$prodi =
   'Ilmu Hukum';


$kampus =
   'STIH Graha Kirana';


$jalur =
   $mahasiswa['register_type']
   ?: '-';


$statusMahasiswa =
   strtoupper(
      trim(
         $mahasiswa['status_pendaftaran']
            ?? ''
      )
   );


$tanggalLahir = '-';


if (
   !empty($mahasiswa['datebirth'])
) {

   $tanggalLahir =
      date(
         'd F Y',
         strtotime(
            $mahasiswa['datebirth']
         )
      );
}


/**
 * =========================================================
 * TAHUN MASUK
 * =========================================================
 */

$tahunMasuk = '-';


if (
   !empty($mahasiswa['created_at'])
) {

   $tahunMasuk =
      date(
         'Y',
         strtotime(
            $mahasiswa['created_at']
         )
      );
}


/**
 * =========================================================
 * INITIAL
 * =========================================================
 */

$initial =
   strtoupper(
      substr(
         $nama,
         0,
         1
      )
   );


?>
<!DOCTYPE html>

<html
   lang="id">

<head>

   <meta
      charset="UTF-8">

   <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0">

   <title>
      SIAKAD - <?= h($nama) ?>
   </title>


   <!-- =====================================================
         BOOTSTRAP
    ====================================================== -->

   <link
      rel="stylesheet"
      href="../assets/css/plugins.css">

   <link
      rel="stylesheet"
      href="../assets/css/style.css">


   <!-- =====================================================
         ICON
    ====================================================== -->

   <link
      rel="stylesheet"
      href="../assets/css/icons.css">


   <style>
      body {
         background: #f6f8fb;
      }


      .student-navbar {
         background: #ffffff;
         border-bottom: 1px solid #e9ecef;
      }


      .student-brand {
         font-weight: 700;
         color: #343f52;
         letter-spacing: .2px;
      }


      .student-brand small {
         display: block;
         font-size: 11px;
         color: #8a94a6;
         font-weight: 500;
      }


      .student-avatar {
         width: 48px;
         height: 48px;
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         background: #eaf2ff;
         color: #3f78e0;
         font-size: 18px;
         font-weight: 700;
      }


      .student-hero {
         background: linear-gradient(135deg,
               #3f78e0,
               #5d8fea);
         border-radius: 16px;
         overflow: hidden;
      }


      .student-hero .avatar {
         width: 72px;
         height: 72px;
         border-radius: 50%;
         background: rgba(255,
               255,
               255,
               .18);
         display: flex;
         align-items: center;
         justify-content: center;
         color: #fff;
         font-size: 28px;
         font-weight: 700;
      }


      .student-npm {
         background: rgba(255,
               255,
               255,
               .14);
         border: 1px solid rgba(255,
               255,
               255,
               .22);
         border-radius: 10px;
         padding: 12px 18px;
         display: inline-flex;
         align-items: center;
         gap: 10px;
      }


      .student-npm strong {
         letter-spacing: 1px;
         font-size: 17px;
      }


      .info-card {
         border: 0;
         border-radius: 14px;
         box-shadow:
            0 4px 20px rgba(30, 34, 40, .05);
      }


      .info-title {
         font-size: 13px;
         text-transform: uppercase;
         letter-spacing: .5px;
         font-weight: 700;
         color: #8490a3;
      }


      .info-item {
         padding: 14px 0;
         border-bottom: 1px solid #eef0f3;
      }


      .info-item:last-child {
         border-bottom: 0;
      }


      .info-label {
         color: #8490a3;
         font-size: 13px;
         margin-bottom: 3px;
      }


      .info-value {
         color: #343f52;
         font-weight: 600;
         font-size: 14px;
      }


      .quick-card {
         border-radius: 14px;
         border: 0;
         box-shadow:
            0 4px 20px rgba(30, 34, 40, .05);
      }


      .quick-action {
         display: flex;
         align-items: center;
         padding: 14px;
         border: 1px solid #edf0f4;
         border-radius: 10px;
         color: #343f52;
         text-decoration: none;
         transition: .2s ease;
      }


      .quick-action:hover {
         border-color: #3f78e0;
         transform: translateY(-2px);
         color: #3f78e0;
      }


      .quick-icon {
         width: 42px;
         height: 42px;
         border-radius: 10px;
         background: #edf4ff;
         color: #3f78e0;
         display: flex;
         align-items: center;
         justify-content: center;
         font-size: 20px;
         margin-right: 12px;
      }


      .status-active {
         background: #e8f8f0;
         color: #25a56a;
      }


      @media (max-width: 767px) {

         .student-hero {
            border-radius: 12px;
         }

         .student-hero .avatar {
            width: 58px;
            height: 58px;
         }

      }
   </style>

</head>


<body>


   <!-- =========================================================
     NAVBAR
========================================================== -->

   <nav
      class="navbar navbar-expand-lg student-navbar">

      <div
         class="container py-3">


         <!-- BRAND -->

         <a
            href="./welcome-mahasiswa.php"
            class="text-decoration-none">

            <div
               class="student-brand">

               SIAKAD

               <small>
                  Sistem Informasi Akademik
               </small>

            </div>

         </a>


         <!-- USER -->

         <div
            class="d-flex align-items-center gap-3">

            <div
               class="text-end d-none d-md-block">

               <div
                  class="fw-bold fs-14">

                  <?= h($nama) ?>

               </div>

               <small
                  class="text-muted">

                  <?= h($npm) ?>

               </small>

            </div>


            <div
               class="student-avatar">

               <?= h($initial) ?>

            </div>

         </div>

      </div>

   </nav>


   <!-- =========================================================
     MAIN
========================================================== -->

   <main>

      <div
         class="container py-6 py-md-8">


         <!-- =================================================
             HERO
        ================================================== -->

         <div
            class="student-hero text-white shadow-lg mb-6">

            <div
               class="p-5 p-md-6">


               <div
                  class="row align-items-center">


                  <!-- LEFT -->

                  <div
                     class="col-lg">

                     <div
                        class="d-flex align-items-center">


                        <div
                           class="avatar me-4">

                           <?= h($initial) ?>

                        </div>


                        <div>

                           <div
                              class="text-white opacity-75 text-uppercase fs-13 fw-bold">

                              Selamat Datang

                           </div>


                           <h2
                              class="text-white mb-2">

                              <?= h($nama) ?>

                           </h2>


                           <div
                              class="opacity-75">

                              Mahasiswa
                              <?= h($kampus) ?>

                           </div>

                        </div>

                     </div>

                  </div>


                  <!-- RIGHT -->

                  <div
                     class="col-lg-auto mt-4 mt-lg-0">


                     <div
                        class="text-lg-end">


                        <div
                           class="mb-2">

                           <span
                              class="badge bg-white text-primary rounded-pill px-4 py-2">

                              <i
                                 class="uil uil-check-circle me-1">
                              </i>

                              SIAKAD AKTIF

                           </span>

                        </div>


                        <div
                           class="student-npm text-white">

                           <i
                              class="uil uil-card-atm fs-20">
                           </i>

                           <div>

                              <small
                                 class="d-block opacity-75">

                                 NPM

                              </small>

                              <strong>

                                 <?= h($npm) ?>

                              </strong>

                           </div>

                        </div>

                     </div>

                  </div>

               </div>

            </div>

         </div>


         <!-- =================================================
             QUICK ACTION
        ================================================== -->

         <div
            class="row g-4 mb-6">


            <div
               class="col-md-4">

               <a
                  href="./cetak-ktm.php"
                  class="quick-action bg-white">

                  <div
                     class="quick-icon">

                     <i
                        class="uil uil-card-atm">
                     </i>

                  </div>

                  <div>

                     <strong>
                        Kartu Tanda Mahasiswa
                     </strong>

                     <small
                        class="d-block text-muted">

                        Cetak KTM

                     </small>

                  </div>

               </a>

            </div>


            <div
               class="col-md-4">

               <a
                  href="./krs.php"
                  class="quick-action bg-white">

                  <div
                     class="quick-icon">

                     <i
                        class="uil uil-book-open">
                     </i>

                  </div>

                  <div>

                     <strong>
                        Kartu Rencana Studi
                     </strong>

                     <small
                        class="d-block text-muted">

                        Kelola KRS

                     </small>

                  </div>

               </a>

            </div>


            <div
               class="col-md-4">

               <a
                  href="./jadwal.php"
                  class="quick-action bg-white">

                  <div
                     class="quick-icon">

                     <i
                        class="uil uil-calendar-alt">
                     </i>

                  </div>

                  <div>

                     <strong>
                        Jadwal Kuliah
                     </strong>

                     <small
                        class="d-block text-muted">

                        Lihat jadwal

                     </small>

                  </div>

               </a>

            </div>


         </div>


         <!-- =================================================
             DATA UTAMA
        ================================================== -->

         <div
            class="row g-5">


            <!-- =================================================
                 DATA DIRI
            ================================================== -->

            <div
               class="col-lg-8">

               <div
                  class="card info-card">

                  <div
                     class="card-body p-5">


                     <div
                        class="d-flex align-items-center justify-content-between mb-4">

                        <div>

                           <div
                              class="info-title">

                              Data Mahasiswa

                           </div>

                           <h4
                              class="mb-0 mt-1">

                              Data Diri

                           </h4>

                        </div>


                        <span
                           class="badge status-active rounded-pill px-3 py-2">

                           <i
                              class="uil uil-check-circle me-1">
                           </i>

                           Aktif

                        </span>

                     </div>


                     <div
                        class="row">


                        <!-- NPM -->

                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 NPM

                              </div>

                              <div
                                 class="info-value text-primary">

                                 <?= h($npm) ?>

                              </div>

                           </div>

                        </div>


                        <!-- NAMA -->

                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 Nama Lengkap

                              </div>

                              <div
                                 class="info-value">

                                 <?= h($nama) ?>

                              </div>

                           </div>

                        </div>


                        <!-- NIK -->

                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 NIK

                              </div>

                              <div
                                 class="info-value">

                                 <?= h(
                                    $mahasiswa['number_id']
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <!-- GENDER -->

                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 Jenis Kelamin

                              </div>

                              <div
                                 class="info-value">

                                 <?= h(
                                    $mahasiswa['gender']
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <!-- TEMPAT LAHIR -->

                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 Tempat Lahir

                              </div>

                              <div
                                 class="info-value">

                                 <?= h(
                                    $mahasiswa['place']
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <!-- TANGGAL LAHIR -->

                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 Tanggal Lahir

                              </div>

                              <div
                                 class="info-value">

                                 <?= h(
                                    $tanggalLahir
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <!-- AGAMA -->

                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 Agama

                              </div>

                              <div
                                 class="info-value">

                                 <?= h(
                                    $mahasiswa['agama']
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <!-- EMAIL -->

                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 Email

                              </div>

                              <div
                                 class="info-value">

                                 <?= h($email) ?>

                              </div>

                           </div>

                        </div>


                        <!-- PHONE -->

                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 Nomor HP

                              </div>

                              <div
                                 class="info-value">

                                 <?= h($phone) ?>

                              </div>

                           </div>

                        </div>


                        <!-- JALUR -->

                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 Jalur Pendaftaran

                              </div>

                              <div
                                 class="info-value">

                                 <?= h($jalur) ?>

                              </div>

                           </div>

                        </div>


                        <!-- TAHUN MASUK -->

                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 Tahun Masuk

                              </div>

                              <div
                                 class="info-value">

                                 <?= h($tahunMasuk) ?>

                              </div>

                           </div>

                        </div>


                        <!-- PROGRAM STUDI -->

                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 Program Studi

                              </div>

                              <div
                                 class="info-value">

                                 <?= h($prodi) ?>

                              </div>

                           </div>

                        </div>


                        <!-- STATUS -->

                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 Status Mahasiswa

                              </div>

                              <div
                                 class="info-value text-success">

                                 <?= h(
                                    $statusMahasiswa
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <!-- ALAMAT -->

                        <div
                           class="col-12">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 Alamat

                              </div>

                              <div
                                 class="info-value">

                                 <?= h(
                                    $mahasiswa['addrees_point']
                                       ?: $mahasiswa['address_card']
                                 ) ?>

                              </div>

                           </div>

                        </div>


                     </div>

                  </div>

               </div>


               <!-- =================================================
                     DATA KELUARGA
                ================================================== -->

               <div
                  class="card info-card mt-5">

                  <div
                     class="card-body p-5">

                     <div
                        class="info-title">

                        Data Keluarga

                     </div>

                     <h4
                        class="mb-4 mt-1">

                        Orang Tua & Kontak Darurat

                     </h4>


                     <div
                        class="row">


                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 Nama Ayah

                              </div>

                              <div
                                 class="info-value">

                                 <?= h(
                                    $mahasiswa['name_father']
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 Nama Ibu

                              </div>

                              <div
                                 class="info-value">

                                 <?= h(
                                    $mahasiswa['name_mother']
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 Kontak Darurat

                              </div>

                              <div
                                 class="info-value">

                                 <?= h(
                                    $mahasiswa['emergency_name']
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <div
                           class="col-md-6">

                           <div
                              class="info-item">

                              <div
                                 class="info-label">

                                 Nomor Kontak

                              </div>

                              <div
                                 class="info-value">

                                 <?= h(
                                    $mahasiswa['emergency_phone']
                                 ) ?>

                              </div>

                           </div>

                        </div>


                     </div>

                  </div>

               </div>

            </div>


            <!-- =================================================
                 SIDEBAR
            ================================================== -->

            <div
               class="col-lg-4">


               <!-- AKADEMIK -->

               <div
                  class="card info-card mb-5">

                  <div
                     class="card-body p-5">

                     <div
                        class="info-title">

                        Akademik

                     </div>

                     <h4
                        class="mb-4 mt-1">

                        Informasi Akademik

                     </h4>


                     <div
                        class="info-item">

                        <div
                           class="info-label">

                           NPM

                        </div>

                        <div
                           class="info-value text-primary fs-18">

                           <?= h($npm) ?>

                        </div>

                     </div>


                     <div
                        class="info-item">

                        <div
                           class="info-label">

                           Program Studi

                        </div>

                        <div
                           class="info-value">

                           <?= h($prodi) ?>

                        </div>

                     </div>


                     <div
                        class="info-item">

                        <div
                           class="info-label">

                           Institusi

                        </div>

                        <div
                           class="info-value">

                           <?= h($kampus) ?>

                        </div>

                     </div>


                     <div
                        class="info-item">

                        <div
                           class="info-label">

                           Tahun Masuk

                        </div>

                        <div
                           class="info-value">

                           <?= h($tahunMasuk) ?>

                        </div>

                     </div>


                     <div
                        class="info-item">

                        <div
                           class="info-label">

                           Status SIAKAD

                        </div>

                        <div
                           class="info-value text-success">

                           <i
                              class="uil uil-check-circle me-1">
                           </i>

                           Aktif

                        </div>

                     </div>


                  </div>

               </div>


               <!-- AKSI -->

               <div
                  class="card quick-card mb-5">

                  <div
                     class="card-body p-5">

                     <div
                        class="info-title">

                        Akses Cepat

                     </div>

                     <h4
                        class="mb-4 mt-1">

                        Layanan Akademik

                     </h4>


                     <div
                        class="d-grid gap-3">


                        <a
                           href="./cetak-ktm.php"
                           class="quick-action">

                           <div
                              class="quick-icon">

                              <i
                                 class="uil uil-card-atm">
                              </i>

                           </div>

                           <div>

                              <strong>
                                 Cetak KTM
                              </strong>

                              <small
                                 class="d-block text-muted">

                                 Kartu Tanda Mahasiswa

                              </small>

                           </div>

                        </a>


                        <a
                           href="./krs.php"
                           class="quick-action">

                           <div
                              class="quick-icon">

                              <i
                                 class="uil uil-book-open">
                              </i>

                           </div>

                           <div>

                              <strong>
                                 KRS
                              </strong>

                              <small
                                 class="d-block text-muted">

                                 Kartu Rencana Studi

                              </small>

                           </div>

                        </a>


                        <a
                           href="./jadwal.php"
                           class="quick-action">

                           <div
                              class="quick-icon">

                              <i
                                 class="uil uil-calendar-alt">
                              </i>

                           </div>

                           <div>

                              <strong>
                                 Jadwal Kuliah
                              </strong>

                              <small
                                 class="d-block text-muted">

                                 Jadwal perkuliahan

                              </small>

                           </div>

                        </a>


                     </div>

                  </div>

               </div>


               <!-- LOGOUT -->

               <div
                  class="card border-0 bg-soft-danger">

                  <div
                     class="card-body p-5">

                     <h5
                        class="mb-2">

                        Keluar dari SIAKAD

                     </h5>

                     <p
                        class="text-muted fs-14 mb-4">

                        Pastikan Anda menyimpan pekerjaan sebelum keluar dari sistem.

                     </p>


                     <a
                        href="../controllers/logout-pmb.php"
                        class="btn btn-outline-danger rounded-pill w-100"
                        onclick="
                                return confirm(
                                    'Apakah Anda yakin ingin keluar dari SIAKAD?'
                                );
                            ">

                        <i
                           class="uil uil-sign-out-alt me-1">
                        </i>

                        Keluar

                     </a>

                  </div>

               </div>


            </div>

         </div>


         <!-- =================================================
             FOOTER
        ================================================== -->

         <div
            class="text-center mt-7">

            <p
               class="text-muted fs-13 mb-0">

               © <?= date('Y') ?>
               <?= h($kampus) ?>.
               Sistem Informasi Akademik.

            </p>

         </div>


      </div>

   </main>


</body>

</html>