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


function statusClass(string $status): string
{
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
 * GET ID
 * =========================================================
 */

$id = filter_input(
   INPUT_GET,
   'id',
   FILTER_VALIDATE_INT
);


if (!$id || $id < 1) {

   header(
      'Location: ./peserta.php'
   );

   exit;
}


/**
 * =========================================================
 * GET PESERTA
 * =========================================================
 */

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

        account_status,
        tahap_aktif,
        status_pendaftaran,

        last_login,
        created_at,
        updated_at,

        register_uid,
        register_type,

        register_pmb.id_program,
        ms_program_studi.program_degree,
        ms_program_studi.program_name,
        id_provider,

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
        file_dokumen

    FROM register_pmb
    LEFT JOIN ms_program_studi ON ms_program_studi.id_program = register_pmb.id_program

    WHERE id = :id

    LIMIT 1

");


$stmt->execute([
   'id' => $id
]);


$peserta =
   $stmt->fetch(
      PDO::FETCH_ASSOC
   );


/**
 * =========================================================
 * NOT FOUND
 * =========================================================
 */

if (!$peserta) {

   header(
      'Location: ./peserta.php'
   );

   exit;
}


/**
 * =========================================================
 * DATA
 * =========================================================
 */

$fullname =
   $peserta['fullname'] ?: '-';

$registerUid =
   $peserta['register_uid'] ?: '-';

$statusPendaftaran =
   $peserta['status_pendaftaran']
   ?: 'REGISTRASI';

$statusKelulusan =
   $peserta['status_kelulusan']
   ?: 'BELUM_DIUMUMKAN';


$statusColor =
   statusClass(
      $statusPendaftaran
   );


/**
 * =========================================================
 * PROGRAM STUDI
 * =========================================================
 *
 * Untuk sementara tampilkan id_program.
 * Bisa digabung dengan tabel program studi
 * setelah struktur tabelnya kita pastikan.
 *
 */

$programStudi =  $peserta['program_degree'] . ' - ' . $peserta['program_name'];


/**
 * =========================================================
 * DOKUMEN
 * =========================================================
 */

$documents = [

   'KTP' => $peserta['file_ktp'],

   'KK' => $peserta['file_kk'],

   'Ijazah' => $peserta['file_ijazah'],

   'Dokumen' => $peserta['file_dokumen']

];


$pageTitle =
   'Detail Peserta';


?>
<!DOCTYPE html>

<html lang="id">

<head>

   <meta charset="UTF-8">

   <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0">


   <title>

      <?= h($fullname) ?>

      -

      Detail Peserta

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
      body {

         background: #f6f8fb;

      }


      /**
         * =====================================================
         * SIDEBAR
         * =====================================================
         */

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


      /**
         * =====================================================
         * MAIN
         * =====================================================
         */

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


      /**
         * =====================================================
         * PROFILE HEADER
         * =====================================================
         */

      .profile-card {

         background:
            linear-gradient(135deg,
               #173f75,
               #0d6efd);

         border-radius: 15px;

         padding: 28px;

         color: #fff;

         position: relative;

         overflow: hidden;

         margin-bottom: 25px;

      }


      .profile-card::after {

         content: "";

         position: absolute;

         width: 300px;

         height: 300px;

         border-radius: 50%;

         background:
            rgba(255,
               255,
               255,
               .07);

         right: -130px;

         top: -160px;

      }


      .profile-content {

         position: relative;

         z-index: 2;

      }


      .profile-avatar {

         width: 72px;

         height: 72px;

         min-width: 72px;

         border-radius: 16px;

         background:
            rgba(255,
               255,
               255,
               .15);

         display: flex;

         align-items: center;

         justify-content: center;

         font-size: 28px;

         font-weight: 800;

         margin-right: 18px;

      }


      .profile-name {

         color: #fff;

         font-size: 23px;

         font-weight: 800;

         margin: 0 0 5px;

      }


      .profile-id {

         color:
            rgba(255,
               255,
               255,
               .75);

         font-size: 12px;

      }


      .profile-status {

         display: inline-flex;

         align-items: center;

         background:
            rgba(255,
               255,
               255,
               .13);

         color: #fff;

         padding:
            7px 12px;

         border-radius: 20px;

         font-size: 10px;

         font-weight: 700;

      }


      /**
         * =====================================================
         * SECTION CARD
         * =====================================================
         */

      .detail-card {

         background: #fff;

         border:
            1px solid #edf0f3;

         border-radius: 13px;

         overflow: hidden;

         margin-bottom: 25px;

      }


      .detail-header {

         padding:
            19px 22px;

         border-bottom:
            1px solid #edf0f3;

         display: flex;

         align-items: center;

         gap: 11px;

      }


      .detail-header-icon {

         width: 38px;

         height: 38px;

         border-radius: 9px;

         background: #eaf2ff;

         color: #0d6efd;

         display: flex;

         align-items: center;

         justify-content: center;

      }


      .detail-header-icon i {

         font-size: 18px;

      }


      .detail-header h5 {

         margin: 0;

         font-size: 14px;

         font-weight: 800;

      }


      .detail-header p {

         margin:
            3px 0 0;

         color: #9299a3;

         font-size: 10px;

      }


      .detail-body {

         padding: 22px;

      }


      /**
         * =====================================================
         * DATA ROW
         * =====================================================
         */

      .data-item {

         margin-bottom: 19px;

      }


      .data-item:last-child {

         margin-bottom: 0;

      }


      .data-label {

         font-size: 10px;

         font-weight: 700;

         color: #9299a3;

         text-transform: uppercase;

         letter-spacing: .3px;

         margin-bottom: 5px;

      }


      .data-value {

         font-size: 13px;

         color: #30363d;

         font-weight: 600;

         word-break: break-word;

      }


      .data-value.normal {

         font-weight: 400;

      }


      /**
         * =====================================================
         * RESULT
         * =====================================================
         */

      .score-card {

         text-align: center;

         padding: 18px;

         border:
            1px solid #edf0f3;

         border-radius: 10px;

         height: 100%;

      }


      .score-label {

         color: #9299a3;

         font-size: 10px;

         font-weight: 700;

         text-transform: uppercase;

      }


      .score-value {

         font-size: 26px;

         font-weight: 800;

         color: #20252b;

         margin-top: 5px;

      }


      .score-final {

         background: #eaf2ff;

         border-color: #d6e5ff;

      }


      .score-final .score-value {

         color: #0d6efd;

      }


      /**
         * =====================================================
         * DOCUMENT
         * =====================================================
         */

      .document-item {

         display: flex;

         align-items: center;

         justify-content: space-between;

         padding:
            13px 0;

         border-bottom:
            1px solid #edf0f3;

         gap: 15px;

      }


      .document-item:last-child {

         border-bottom: 0;

      }


      .document-icon {

         width: 38px;

         height: 38px;

         min-width: 38px;

         border-radius: 9px;

         background: #f1f6ff;

         color: #0d6efd;

         display: flex;

         align-items: center;

         justify-content: center;

      }


      .document-name {

         font-size: 12px;

         font-weight: 700;

      }


      .document-file {

         font-size: 10px;

         color: #9299a3;

         margin-top: 2px;

         word-break: break-all;

      }


      /**
         * =====================================================
         * TIMELINE
         * =====================================================
         */

      .timeline-item {

         display: flex;

         position: relative;

         padding-bottom: 22px;

      }


      .timeline-item:last-child {

         padding-bottom: 0;

      }


      .timeline-line {

         position: absolute;

         left: 15px;

         top: 30px;

         bottom: 0;

         width: 1px;

         background: #e8ecf1;

      }


      .timeline-item:last-child .timeline-line {

         display: none;

      }


      .timeline-dot {

         width: 30px;

         height: 30px;

         min-width: 30px;

         border-radius: 50%;

         background: #eaf2ff;

         color: #0d6efd;

         display: flex;

         align-items: center;

         justify-content: center;

         position: relative;

         z-index: 2;

      }


      .timeline-content {

         margin-left: 13px;

      }


      .timeline-title {

         font-size: 12px;

         font-weight: 700;

      }


      .timeline-date {

         color: #9299a3;

         font-size: 10px;

         margin-top: 3px;

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


         .admin-nav {

            display: none;

         }


         .admin-sidebar-footer {

            display: none;

         }


         .admin-main {

            margin-left: 0;

         }


         .admin-topbar {

            padding:
               18px 20px;

         }


         .admin-content {

            padding:
               20px 15px;

         }


         .profile-card {

            padding: 22px;

         }


         .profile-avatar {

            width: 58px;

            height: 58px;

            min-width: 58px;

            font-size: 22px;

         }


         .profile-name {

            font-size: 19px;

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

               Detail Peserta

            </h1>


            <div class="admin-page-subtitle">

               Informasi lengkap peserta PMB

            </div>

         </div>


         <div
            class="d-flex
            align-items-center">


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


      <!-- =====================================================
         CONTENT
    ====================================================== -->

      <div class="admin-content">


         <!-- =================================================
             BACK
        ================================================== -->

         <div class="mb-4">


            <a
               href="./peserta"
               class="btn btn-sm btn-outline-secondary rounded">

               <i
                  class="uil uil-arrow-left me-1">
               </i>

               Kembali ke Data Peserta

            </a>


         </div>


         <!-- =================================================
             PROFILE
        ================================================== -->

         <div class="profile-card">


            <div class="profile-content">


               <div
                  class="row
                    align-items-center
                    g-4">


                  <div
                     class="col-lg">


                     <div
                        class="d-flex
                            align-items-center">


                        <div
                           class="profile-avatar">

                           <?= h(
                              strtoupper(
                                 substr(
                                    $fullname,
                                    0,
                                    1
                                 )
                              )
                           ) ?>

                        </div>


                        <div>


                           <h2
                              class="profile-name">

                              <?= h(
                                 $fullname
                              ) ?>

                           </h2>


                           <div
                              class="profile-id">

                              ID Pendaftaran:

                              <strong>

                                 <?= h(
                                    $registerUid
                                 ) ?>

                              </strong>

                           </div>


                           <div
                              class="profile-id mt-1">

                              ID Database:

                              #<?= (int) $peserta['id'] ?>

                           </div>


                        </div>


                     </div>


                  </div>


                  <div
                     class="col-lg-auto">


                     <div
                        class="profile-status">


                        <i
                           class="uil uil-check-circle me-1">
                        </i>


                        <?= h(
                           $statusPendaftaran
                        ) ?>


                     </div>


                  </div>


               </div>


            </div>


         </div>


         <!-- =================================================
             MAIN GRID
        ================================================== -->

         <div class="row g-4">


            <!-- =================================================
                 LEFT
            ================================================== -->

            <div class="col-xl-8">


               <!-- =================================================
                     DATA PRIBADI
                ================================================== -->

               <div class="detail-card">


                  <div class="detail-header">


                     <div
                        class="detail-header-icon">

                        <i
                           class="uil uil-user">
                        </i>

                     </div>


                     <div>

                        <h5>

                           Data Pribadi

                        </h5>


                        <p>

                           Informasi identitas peserta

                        </p>

                     </div>


                  </div>


                  <div class="detail-body">


                     <div class="row g-4">


                        <div class="col-md-6">

                           <div class="data-item">

                              <div class="data-label">
                                 Nama Lengkap
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['fullname']
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-3">

                           <div class="data-item">

                              <div class="data-label">
                                 Jenis Kelamin
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['gender']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-3">

                           <div class="data-item">

                              <div class="data-label">
                                 Agama
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['agama']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-4">

                           <div class="data-item">

                              <div class="data-label">
                                 NIK
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['number_id']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-4">

                           <div class="data-item">

                              <div class="data-label">
                                 Tempat Lahir
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['place']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-4">

                           <div class="data-item">

                              <div class="data-label">
                                 Tanggal Lahir
                              </div>

                              <div class="data-value">

                                 <?php

                                 if (
                                    !empty($peserta['datebirth'])
                                 ) {

                                    echo h(
                                       date(
                                          'd F Y',
                                          strtotime(
                                             $peserta['datebirth']
                                          )
                                       )
                                    );
                                 } else {

                                    echo '-';
                                 }

                                 ?>

                              </div>

                           </div>

                        </div>


                        <div class="col-md-4">

                           <div class="data-item">

                              <div class="data-label">
                                 Ukuran Baju
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['ukuran_baju']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-8">

                           <div class="data-item">

                              <div class="data-label">
                                 Email
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['email_register']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-6">

                           <div class="data-item">

                              <div class="data-label">
                                 Nomor HP
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['phone_number']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                     </div>

                  </div>

               </div>


               <!-- =================================================
                     ALAMAT
                ================================================== -->

               <div class="detail-card">


                  <div class="detail-header">


                     <div
                        class="detail-header-icon">

                        <i
                           class="uil uil-map-marker">
                        </i>

                     </div>


                     <div>

                        <h5>
                           Alamat
                        </h5>

                        <p>
                           Informasi domisili peserta
                        </p>

                     </div>


                  </div>


                  <div class="detail-body">


                     <div class="row g-4">


                        <div class="col-md-3">

                           <div class="data-item">

                              <div class="data-label">
                                 Provinsi
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['provinsi']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-3">

                           <div class="data-item">

                              <div class="data-label">
                                 Kabupaten
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['kabupaten']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-3">

                           <div class="data-item">

                              <div class="data-label">
                                 Kecamatan
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['kecamatan']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-3">

                           <div class="data-item">

                              <div class="data-label">
                                 Kelurahan
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['kelurahan']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-12">

                           <div class="data-item">

                              <div class="data-label">
                                 Alamat
                              </div>

                              <div class="data-value normal">

                                 <?= nl2br(
                                    h(
                                       $peserta['address_card']
                                          ?: '-'
                                    )
                                 ) ?>

                              </div>

                           </div>

                        </div>


                        <div class="col-12">

                           <div class="data-item">

                              <div class="data-label">
                                 Detail Lokasi
                              </div>

                              <div class="data-value normal">

                                 <?= nl2br(
                                    h(
                                       $peserta['addrees_point']
                                          ?: '-'
                                    )
                                 ) ?>

                              </div>

                           </div>

                        </div>


                     </div>

                  </div>

               </div>


               <!-- =================================================
                     PENDIDIKAN
                ================================================== -->

               <div class="detail-card">


                  <div class="detail-header">


                     <div
                        class="detail-header-icon">

                        <i
                           class="uil uil-graduation-cap">
                        </i>

                     </div>


                     <div>

                        <h5>
                           Pendidikan
                        </h5>

                        <p>
                           Riwayat pendidikan terakhir
                        </p>

                     </div>


                  </div>


                  <div class="detail-body">


                     <div class="row g-4">


                        <div class="col-md-6">

                           <div class="data-item">

                              <div class="data-label">
                                 Nama Sekolah
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['school_name']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-3">

                           <div class="data-item">

                              <div class="data-label">
                                 NPSN
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['school_npsn']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-3">

                           <div class="data-item">

                              <div class="data-label">
                                 NISN
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['number_nisn']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-4">

                           <div class="data-item">

                              <div class="data-label">
                                 Tahun Lulus
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['year_graduation']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-8">

                           <div class="data-item">

                              <div class="data-label">
                                 Alamat Sekolah
                              </div>

                              <div class="data-value normal">
                                 <?= h(
                                    $peserta['school_address']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-6">

                           <div class="data-item">

                              <div class="data-label">
                                 Nomor KIP
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['number_kip']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                     </div>

                  </div>

               </div>


               <!-- =================================================
                     KELUARGA
                ================================================== -->

               <div class="detail-card">


                  <div class="detail-header">


                     <div
                        class="detail-header-icon">

                        <i
                           class="uil uil-users-alt">
                        </i>

                     </div>


                     <div>

                        <h5>
                           Data Keluarga
                        </h5>

                        <p>
                           Data orang tua dan kontak darurat
                        </p>

                     </div>


                  </div>


                  <div class="detail-body">


                     <div class="row g-4">


                        <div class="col-md-6">

                           <div class="data-item">

                              <div class="data-label">
                                 Nama Ayah
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['name_father']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-6">

                           <div class="data-item">

                              <div class="data-label">
                                 Nama Ibu
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['name_mother']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-6">

                           <div class="data-item">

                              <div class="data-label">
                                 Nomor KK
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['number_kk']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-6">

                           <div class="data-item">

                              <div class="data-label">
                                 NIK Kepala Keluarga
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['number_nik_kk']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-12">

                           <div class="data-item">

                              <div class="data-label">
                                 Alamat Orang Tua
                              </div>

                              <div class="data-value normal">
                                 <?= h(
                                    $peserta['parent_address']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-4">

                           <div class="data-item">

                              <div class="data-label">
                                 Kontak Darurat
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['emergency_name']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-4">

                           <div class="data-item">

                              <div class="data-label">
                                 Nomor Darurat
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['emergency_phone']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                        <div class="col-md-4">

                           <div class="data-item">

                              <div class="data-label">
                                 Relasi
                              </div>

                              <div class="data-value">
                                 <?= h(
                                    $peserta['emergency_relasi']
                                       ?: '-'
                                 ) ?>
                              </div>

                           </div>

                        </div>


                     </div>

                  </div>

               </div>


            </div>


            <!-- =================================================
                 RIGHT
            ================================================== -->

            <div class="col-xl-4">


               <!-- =================================================
                     PENDAFTARAN
                ================================================== -->

               <div class="detail-card">


                  <div class="detail-header">


                     <div
                        class="detail-header-icon">

                        <i
                           class="uil uil-clipboard-alt">
                        </i>

                     </div>


                     <div>

                        <h5>
                           Informasi Pendaftaran
                        </h5>

                        <p>
                           Status dan jalur PMB
                        </p>

                     </div>


                  </div>


                  <div class="detail-body">


                     <div class="data-item">

                        <div class="data-label">
                           ID Pendaftaran
                        </div>

                        <div class="data-value">
                           <?= h(
                              $registerUid
                           ) ?>
                        </div>

                     </div>


                     <div class="data-item">

                        <div class="data-label">
                           Jalur Pendaftaran
                        </div>

                        <div class="data-value">

                           <?= h(
                              $peserta['register_type']
                                 ?: '-'
                           ) ?>

                        </div>

                     </div>


                     <div class="data-item">

                        <div class="data-label">
                           Program Studi
                        </div>

                        <div class="data-value">

                           <?= h(
                              $programStudi
                           ) ?>

                        </div>

                     </div>


                     <div class="data-item">

                        <div class="data-label">
                           Pembiayaan
                        </div>

                        <div class="data-value">

                           <?= h(
                              $peserta['jenis_pembiayaan']
                                 ?: '-'
                           ) ?>

                        </div>

                     </div>


                     <div class="data-item">

                        <div class="data-label">
                           Tahap Aktif
                        </div>

                        <div class="data-value">

                           <span
                              class="badge bg-soft-primary text-primary">

                              Tahap
                              <?= (int)
                              $peserta['tahap_aktif'] ?>

                           </span>

                        </div>

                     </div>


                     <div class="data-item">

                        <div class="data-label">
                           Status Pendaftaran
                        </div>

                        <div class="data-value">

                           <span
                              class="
                                    badge
                                    bg-soft-<?= h(
                                                $statusColor
                                             ) ?>
                                    text-<?= h(
                                             $statusColor
                                          ) ?>">

                              <?= h(
                                 $statusPendaftaran
                              ) ?>

                           </span>

                        </div>

                     </div>


                     <div class="data-item">

                        <div class="data-label">
                           Status Akun
                        </div>

                        <div class="data-value">

                           <?= h(
                              $peserta['account_status']
                                 ?: '-'
                           ) ?>

                        </div>

                     </div>


                  </div>

               </div>

               <!-- =================================================
     HASIL SELEKSI
================================================== -->

               <div class="detail-card">


                  <div class="detail-header">


                     <div
                        class="detail-header-icon">

                        <i class="uil uil-award"></i>

                     </div>


                     <div>

                        <h5>
                           Hasil Seleksi
                        </h5>

                        <p>
                           Input dan pengelolaan hasil seleksi peserta
                        </p>

                     </div>


                  </div>


                  <div class="detail-body">


                     <form
                        id="formHasilSeleksi"
                        method="POST"
                        action="../controllers/update-hasil-seleksi.php"
                        novalidate>


                        <input
                           type="hidden"
                           name="id"
                           value="<?= (int) $peserta['id'] ?>">


                        <!-- =============================================
              NILAI
         ============================================== -->

                        <div class="row g-3">


                           <!-- TPA -->

                           <div class="col-md-6">


                              <div class="score-card">


                                 <div class="score-label">

                                    Nilai TPA

                                 </div>


                                 <input
                                    type="number"
                                    name="nilai_tpa"
                                    id="nilaiTpa"
                                    class="
                        form-control
                        text-center
                        mt-2
                     "
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    value="<?= $peserta['nilai_tpa'] !== null
                                                ? h($peserta['nilai_tpa'])
                                                : '' ?>"
                                    placeholder="0 - 100"
                                    required>


                              </div>


                           </div>



                           <!-- WAWANCARA -->

                           <div class="col-md-6">


                              <div class="score-card">


                                 <div class="score-label">

                                    Nilai Wawancara

                                 </div>


                                 <input
                                    type="number"
                                    name="nilai_wawancara"
                                    id="nilaiWawancara"
                                    class="
                        form-control
                        text-center
                        mt-2
                     "
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    value="<?= $peserta['nilai_wawancara'] !== null
                                                ? h($peserta['nilai_wawancara'])
                                                : '' ?>"
                                    placeholder="0 - 100"
                                    required>


                              </div>


                           </div>



                           <!-- NILAI AKHIR -->

                           <div class="col-12">


                              <div
                                 class="
                     score-card
                     score-final
                  ">


                                 <div class="score-label">

                                    Nilai Akhir

                                 </div>


                                 <div
                                    id="nilaiAkhirPreview"
                                    class="score-value">


                                    <?= $peserta['nilai_akhir'] !== null
                                       ? number_format(
                                          (float)
                                          $peserta['nilai_akhir'],
                                          2,
                                          ',',
                                          '.'
                                       )
                                       : '0,00'
                                    ?>


                                 </div>


                                 <small
                                    class="text-muted">


                                    TPA 50% + Wawancara 50%


                                 </small>


                                 <input
                                    type="hidden"
                                    name="nilai_akhir"
                                    id="nilaiAkhir">


                              </div>


                           </div>


                        </div>



                        <hr class="my-4">



                        <!-- =============================================
              STATUS KELULUSAN
         ============================================== -->

                        <div class="mb-4">


                           <label
                              class="
                  form-label
                  fw-bold
                  fs-13
               ">

                              Status Kelulusan

                           </label>


                           <select
                              name="status_kelulusan"
                              id="statusKelulusan"
                              class="form-select"
                              required>


                              <option
                                 value="">

                                 Pilih Status Kelulusan

                              </option>


                              <option
                                 value="LULUS"
                                 <?= $statusKelulusan === 'LULUS'
                                    ? 'selected'
                                    : '' ?>>

                                 LULUS

                              </option>


                              <option
                                 value="TIDAK_LULUS"
                                 <?= $statusKelulusan === 'TIDAK_LULUS'
                                    ? 'selected'
                                    : '' ?>>

                                 TIDAK LULUS

                              </option>


                           </select>


                        </div>



                        <!-- =============================================
              CATATAN
         ============================================== -->

                        <div class="mb-4">


                           <label
                              class="
                  form-label
                  fw-bold
                  fs-13
               ">

                              Catatan Hasil

                           </label>


                           <textarea
                              name="catatan_hasil"
                              id="catatanHasil"
                              class="form-control"
                              rows="4"
                              placeholder="
                  Masukkan catatan atau keterangan hasil seleksi...
               "><?= h(
                     $peserta['catatan_hasil']
                        ?? ''
                  ) ?></textarea>


                        </div>



                        <!-- =============================================
              INFO PENGUMUMAN
         ============================================== -->

                        <?php if (
                           !empty($peserta['hasil_diumumkan_at'])
                        ): ?>


                           <div
                              class="
                  alert
                  alert-info
                  alert-icon
                  mb-4">


                              <i
                                 class="uil uil-clock">
                              </i>


                              <div>


                                 <strong>

                                    Hasil terakhir disimpan

                                 </strong>


                                 <div
                                    class="fs-12 mt-1">


                                    <?= h(
                                       date(
                                          'd/m/Y H:i',
                                          strtotime(
                                             $peserta['hasil_diumumkan_at']
                                          )
                                       )
                                    ) ?>


                                 </div>


                              </div>


                           </div>


                        <?php endif; ?>



                        <!-- =============================================
              BUTTON
         ============================================== -->

                        <button
                           type="submit"
                           id="btnSimpanHasil"
                           class="
               btn
               btn-primary
               rounded
               btn-icon
               btn-icon-end
               w-100">


                           Simpan Hasil Seleksi


                           <i
                              class="uil uil-check-circle">
                           </i>


                        </button>


                     </form>


                  </div>


               </div>


               <!-- =================================================
                     HASIL SELEKSI
                ================================================== -->

               <!-- <div class="detail-card">


                  <div class="detail-header">


                     <div
                        class="detail-header-icon">

                        <i
                           class="uil uil-award">
                        </i>

                     </div>


                     <div>

                        <h5>
                           Hasil Seleksi
                        </h5>

                        <p>
                           Nilai TPA dan wawancara
                        </p>

                     </div>

                  </div>


                  <div class="detail-body">


                     <div class="row g-3">


                        <div class="col-6">


                           <div class="score-card">


                              <div
                                 class="score-label">

                                 TPA

                              </div>


                              <div
                                 class="score-value">

                                 <?= $peserta['nilai_tpa'] !== null
                                    ? number_format(
                                       (float)
                                       $peserta['nilai_tpa'],
                                       2,
                                       ',',
                                       '.'
                                    )
                                    : '-'
                                 ?>

                              </div>


                           </div>


                        </div>


                        <div class="col-6">


                           <div class="score-card">


                              <div
                                 class="score-label">

                                 Wawancara

                              </div>


                              <div
                                 class="score-value">

                                 <?= $peserta['nilai_wawancara'] !== null
                                    ? number_format(
                                       (float)
                                       $peserta['nilai_wawancara'],
                                       2,
                                       ',',
                                       '.'
                                    )
                                    : '-'
                                 ?>

                              </div>


                           </div>


                        </div>


                        <div class="col-12">


                           <div
                              class="score-card score-final">


                              <div
                                 class="score-label">

                                 Nilai Akhir

                              </div>


                              <div
                                 class="score-value">

                                 <?= $peserta['nilai_akhir'] !== null
                                    ? number_format(
                                       (float)
                                       $peserta['nilai_akhir'],
                                       2,
                                       ',',
                                       '.'
                                    )
                                    : '-'
                                 ?>

                              </div>


                           </div>


                        </div>


                     </div>


                     <hr
                        class="my-4">


                     <div class="data-item">


                        <div class="data-label">

                           Status Kelulusan

                        </div>


                        <div class="data-value">


                           <?php

                           $kelulusanColor =
                              $statusKelulusan ===
                              'LULUS'
                              ? 'success'
                              : (
                                 $statusKelulusan ===
                                 'TIDAK_LULUS'
                                 ? 'danger'
                                 : 'secondary'
                              );

                           ?>


                           <span
                              class="
                                    badge
                                    bg-soft-<?= $kelulusanColor ?>
                                    text-<?= $kelulusanColor ?>">

                              <?= h(
                                 $statusKelulusan
                              ) ?>

                           </span>


                        </div>


                     </div>


                     <?php if (
                        !empty($peserta['catatan_hasil'])
                     ): ?>


                        <div
                           class="data-item mt-4">


                           <div class="data-label">

                              Catatan Hasil

                           </div>


                           <div
                              class="data-value normal">

                              <?= nl2br(
                                 h(
                                    $peserta['catatan_hasil']
                                 )
                              ) ?>

                           </div>


                        </div>


                     <?php endif; ?>


                  </div>

               </div> -->


               <!-- =================================================
                     DOKUMEN
                ================================================== -->

               <div class="detail-card">


                  <div class="detail-header">


                     <div
                        class="detail-header-icon">

                        <i
                           class="uil uil-file-alt">
                        </i>

                     </div>


                     <div>

                        <h5>
                           Dokumen
                        </h5>

                        <p>
                           Dokumen yang diunggah peserta
                        </p>

                     </div>


                  </div>


                  <div class="detail-body">


                     <?php foreach (
                        $documents
                        as $documentName =>
                        $documentFile
                     ): ?>


                        <div
                           class="document-item">


                           <div
                              class="d-flex
                                    align-items-center
                                    min-w-0">


                              <div
                                 class="document-icon
                                        me-3">

                                 <i
                                    class="uil uil-file-check">
                                 </i>

                              </div>


                              <div
                                 class="min-w-0">


                                 <div
                                    class="document-name">

                                    <?= h(
                                       $documentName
                                    ) ?>

                                 </div>


                                 <div
                                    class="document-file">

                                    <?= !empty($documentFile)
                                       ? h(
                                          $documentFile
                                       )
                                       : 'Belum diunggah'
                                    ?>

                                 </div>


                              </div>


                           </div>


                           <?php if (
                              !empty($documentFile)
                           ): ?>


                              <a
                                 href="../uploads/pmb/<?= rawurlencode(
                                                         basename(
                                                            $documentFile
                                                         )
                                                      ) ?>"
                                 target="_blank"
                                 class="btn btn-sm btn-soft-primary rounded">

                                 <i
                                    class="uil uil-eye">
                                 </i>

                              </a>


                           <?php endif; ?>


                        </div>


                     <?php endforeach; ?>


                  </div>

               </div>


               <!-- =================================================
                     TIMELINE
                ================================================== -->

               <div class="detail-card">


                  <div class="detail-header">


                     <div
                        class="detail-header-icon">

                        <i
                           class="uil uil-history">
                        </i>

                     </div>


                     <div>

                        <h5>
                           Informasi Akun
                        </h5>

                        <p>
                           Riwayat aktivitas peserta
                        </p>

                     </div>

                  </div>


                  <div class="detail-body">


                     <div class="timeline-item">


                        <div
                           class="timeline-dot">

                           <i
                              class="uil uil-user-plus">
                           </i>

                        </div>


                        <div
                           class="timeline-line">
                        </div>


                        <div
                           class="timeline-content">


                           <div
                              class="timeline-title">

                              Pendaftaran dibuat

                           </div>


                           <div
                              class="timeline-date">

                              <?= !empty($peserta['created_at'])
                                 ? h(
                                    date(
                                       'd/m/Y H:i',
                                       strtotime(
                                          $peserta['created_at']
                                       )
                                    )
                                 )
                                 : '-'
                              ?>

                           </div>


                        </div>

                     </div>


                     <div class="timeline-item">


                        <div
                           class="timeline-dot">

                           <i
                              class="uil uil-sign-in-alt">
                           </i>

                        </div>


                        <div
                           class="timeline-line">
                        </div>


                        <div
                           class="timeline-content">


                           <div
                              class="timeline-title">

                              Login terakhir

                           </div>


                           <div
                              class="timeline-date">

                              <?= !empty($peserta['last_login'])
                                 ? h(
                                    $peserta['last_login']
                                 )
                                 : 'Belum tersedia'
                              ?>

                           </div>


                        </div>

                     </div>


                     <div class="timeline-item">


                        <div
                           class="timeline-dot">

                           <i
                              class="uil uil-edit">
                           </i>

                        </div>


                        <div
                           class="timeline-content">


                           <div
                              class="timeline-title">

                              Data terakhir diperbarui

                           </div>


                           <div
                              class="timeline-date">

                              <?= !empty($peserta['updated_at'])
                                 ? h(
                                    $peserta['updated_at']
                                 )
                                 : 'Belum tersedia'
                              ?>

                           </div>


                        </div>

                     </div>


                  </div>

               </div>


            </div>


         </div>


      </div>


   </main>
   <script>
      document.addEventListener("DOMContentLoaded", function() {

         const form =
            document.getElementById("formHasilSeleksi");

         const button =
            document.getElementById("btnSimpanHasil");

         const nilaiTpa =
            document.getElementById("nilaiTpa");

         const nilaiWawancara =
            document.getElementById("nilaiWawancara");

         const nilaiAkhir =
            document.getElementById("nilaiAkhir");

         const nilaiAkhirPreview =
            document.getElementById("nilaiAkhirPreview");


         /**
          * =====================================================
          * HITUNG NILAI AKHIR
          * =====================================================
          */

         function hitungNilaiAkhir() {

            const tpa =
               parseFloat(nilaiTpa.value) || 0;

            const wawancara =
               parseFloat(nilaiWawancara.value) || 0;

            const akhir =
               (tpa * 0.50) +
               (wawancara * 0.50);


            nilaiAkhir.value =
               akhir.toFixed(2);


            nilaiAkhirPreview.textContent =
               akhir.toLocaleString("id-ID", {
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2
               });

         }


         nilaiTpa.addEventListener(
            "input",
            hitungNilaiAkhir
         );


         nilaiWawancara.addEventListener(
            "input",
            hitungNilaiAkhir
         );


         /**
          * =====================================================
          * TOAST
          * =====================================================
          */

         function showToast(
            type,
            message
         ) {

            let container =
               document.getElementById(
                  "adminToastContainer"
               );


            if (!container) {

               container =
                  document.createElement("div");

               container.id =
                  "adminToastContainer";

               container.style.position =
                  "fixed";

               container.style.top =
                  "25px";

               container.style.right =
                  "25px";

               container.style.zIndex =
                  "999999";

               container.style.width =
                  "380px";

               container.style.maxWidth =
                  "calc(100% - 30px)";

               document.body.appendChild(
                  container
               );

            }


            const toast =
               document.createElement("div");


            let icon =
               "uil-info-circle";

            let alertClass =
               "alert-info";


            if (type === "success") {

               icon =
                  "uil-check-circle";

               alertClass =
                  "alert-success";

            }


            if (type === "danger") {

               icon =
                  "uil-times-circle";

               alertClass =
                  "alert-danger";

            }


            if (type === "warning") {

               icon =
                  "uil-exclamation-triangle";

               alertClass =
                  "alert-warning";

            }


            toast.className =
               `alert ${alertClass} shadow-lg border-0 mb-2`;


            toast.innerHTML = `

         <div class="d-flex align-items-start">

            <i
               class="uil ${icon} fs-20 me-2">
            </i>

            <div class="fw-semibold">
               ${escapeHtml(message)}
            </div>

         </div>

      `;


            container.appendChild(
               toast
            );


            setTimeout(function() {

               toast.style.transition =
                  "all .3s ease";

               toast.style.opacity =
                  "0";

               toast.style.transform =
                  "translateX(20px)";


               setTimeout(function() {

                  toast.remove();

               }, 300);

            }, 3500);

         }


         /**
          * =====================================================
          * ESCAPE HTML
          * =====================================================
          */

         function escapeHtml(text) {

            const div =
               document.createElement("div");

            div.textContent =
               text;

            return div.innerHTML;

         }


         /**
          * =====================================================
          * SUBMIT HASIL SELEKSI
          * =====================================================
          */

         if (!form || !button) {

            console.warn(
               "Form hasil seleksi tidak ditemukan."
            );

            return;

         }


         form.addEventListener(
            "submit",
            async function(e) {

               e.preventDefault();


               /**
                * ===============================================
                * VALIDASI
                * ===============================================
                */

               const tpa =
                  parseFloat(
                     nilaiTpa.value
                  );

               const wawancara =
                  parseFloat(
                     nilaiWawancara.value
                  );


               if (
                  isNaN(tpa) ||
                  tpa < 0 ||
                  tpa > 100
               ) {

                  showToast(
                     "warning",
                     "Nilai TPA harus berada antara 0 sampai 100."
                  );

                  nilaiTpa.focus();

                  return;

               }


               if (
                  isNaN(wawancara) ||
                  wawancara < 0 ||
                  wawancara > 100
               ) {

                  showToast(
                     "warning",
                     "Nilai wawancara harus berada antara 0 sampai 100."
                  );

                  nilaiWawancara.focus();

                  return;

               }


               /**
                * ===============================================
                * HITUNG NILAI
                * ===============================================
                */

               hitungNilaiAkhir();


               const nilaiFinal =
                  parseFloat(
                     nilaiAkhir.value
                  );


               const status =
                  nilaiFinal >= 75 ?
                  "LULUS" :
                  "TIDAK_LULUS";


               /**
                * ===============================================
                * KONFIRMASI
                * ===============================================
                */

               const confirmMessage =
                  `Simpan hasil seleksi?\n\n` +
                  `Nilai TPA       : ${tpa.toFixed(2)}\n` +
                  `Nilai Wawancara : ${wawancara.toFixed(2)}\n` +
                  `Nilai Akhir     : ${nilaiFinal.toFixed(2)}\n` +
                  `Status          : ${status === "LULUS" ? "LULUS" : "TIDAK LULUS"}\n\n` +
                  `Tahap peserta akan diperbarui menjadi Tahap 5.`;


               if (
                  !window.confirm(
                     confirmMessage
                  )
               ) {

                  return;

               }


               /**
                * ===============================================
                * LOADING
                * ===============================================
                */

               const originalHTML =
                  button.innerHTML;


               button.disabled =
                  true;


               button.innerHTML = `

            <span
               class="spinner-border
                      spinner-border-sm
                      me-2"
               role="status"
               aria-hidden="true">
            </span>

            Menyimpan...

         `;


               try {

                  /**
                   * ============================================
                   * FORM DATA
                   * ============================================
                   */

                  const formData =
                     new FormData(form);


                  /**
                   * Controller sekarang menentukan
                   * status berdasarkan nilai akhir.
                   */

                  formData.set(
                     "nilai_akhir",
                     nilaiFinal.toFixed(2)
                  );


                  /**
                   * ============================================
                   * REQUEST
                   * ============================================
                   */

                  const response =
                     await fetch(
                        form.action, {
                           method: "POST",
                           body: formData,
                           headers: {
                              "X-Requested-With": "XMLHttpRequest"
                           }
                        }
                     );


                  console.log(
                     "HTTP STATUS:",
                     response.status
                  );


                  const text =
                     await response.text();


                  console.log(
                     "CONTROLLER RESPONSE:",
                     text
                  );


                  /**
                   * ============================================
                   * PARSE JSON
                   * ============================================
                   */

                  let result;


                  try {

                     result =
                        JSON.parse(text);

                  } catch (jsonError) {

                     console.error(
                        "JSON ERROR:",
                        jsonError
                     );

                     throw new Error(
                        "Controller tidak mengembalikan JSON."
                     );

                  }


                  console.log(
                     "RESULT:",
                     result
                  );


                  /**
                   * ============================================
                   * SESSION EXPIRED
                   * ============================================
                   */

                  if (
                     response.status === 401
                  ) {

                     showToast(
                        "warning",
                        result.message ||
                        "Sesi admin telah berakhir."
                     );


                     setTimeout(
                        function() {

                           window.location.href =
                              "./index.php";

                        },
                        1500
                     );


                     return;

                  }


                  /**
                   * ============================================
                   * ERROR
                   * ============================================
                   */

                  if (
                     !response.ok ||
                     !result.success
                  ) {

                     showToast(
                        "danger",
                        result.message ||
                        "Gagal menyimpan hasil seleksi."
                     );

                     return;

                  }


                  /**
                   * ============================================
                   * SUCCESS
                   * ============================================
                   */

                  const data =
                     result.data || {};


                  const statusText =
                     data.status_kelulusan ===
                     "LULUS" ?
                     "LULUS" :
                     "TIDAK LULUS";


                  showToast(
                     "success",
                     `Berhasil! Hasil seleksi ${data.fullname || ""} telah diperbarui. Status: ${statusText}.`
                  );


                  /**
                   * ============================================
                   * UPDATE UI LANGSUNG
                   * ============================================
                   */

                  setTimeout(
                     function() {

                        window.location.reload();

                     },
                     1800
                  );


               } catch (error) {

                  console.error(
                     "UPDATE HASIL SELEKSI ERROR:",
                     error
                  );


                  showToast(
                     "danger",
                     error.message ||
                     "Terjadi kesalahan saat menyimpan hasil seleksi."
                  );


               } finally {

                  button.disabled =
                     false;

                  button.innerHTML =
                     originalHTML;

               }

            }
         );


         /**
          * =====================================================
          * INITIAL CALCULATION
          * =====================================================
          */

         hitungNilaiAkhir();

      });
   </script>

</body>

</html>