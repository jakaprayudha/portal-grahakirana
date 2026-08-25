<?php

session_start();

require_once '../config/connect.php';


/**
 * =========================================================
 * AUTHENTICATION
 * =========================================================
 */

if (
   empty($_SESSION['pmb_logged_in']) ||
   empty($_SESSION['pmb_user_id'])
) {

   header('Location: ./login-pmb.php');
   exit;
}


$userId = (int) $_SESSION['pmb_user_id'];


/**
 * =========================================================
 * GET DATA MAHASISWA
 * =========================================================
 */

$stmt = $pdo->prepare("

    SELECT *

    FROM register_pmb

    WHERE id = :id

    LIMIT 1

");

$stmt->execute([
   'id' => $userId
]);


$pmbUser = $stmt->fetch(
   PDO::FETCH_ASSOC
);


/**
 * =========================================================
 * USER NOT FOUND
 * =========================================================
 */

if (!$pmbUser) {

   session_destroy();

   header('Location: ./login-pmb.php');

   exit;
}


/**
 * =========================================================
 * HELPER
 * =========================================================
 */

function ktmValue(
   array $data,
   string $key,
   string $default = '-'
): string {

   if (
      isset($data[$key]) &&
      trim((string) $data[$key]) !== ''
   ) {

      return trim(
         (string) $data[$key]
      );
   }

   return $default;
}


function h(
   $value
): string {

   return htmlspecialchars(
      (string) $value,
      ENT_QUOTES,
      'UTF-8'
   );
}


/**
 * =========================================================
 * STATUS
 * =========================================================
 */

$statusPendaftaran =
   strtoupper(
      ktmValue(
         $pmbUser,
         'status_pendaftaran',
         ''
      )
   );


if (
   $statusPendaftaran !== 'MAHASISWA'
) {

   header('Location: ./welcome');

   exit;
}


/**
 * =========================================================
 * SIAKAD STATUS
 * =========================================================
 */

$siakadStatus =
   strtoupper(
      ktmValue(
         $pmbUser,
         'siakad_status',
         'BELUM_AKTIVASI'
      )
   );


/**
 * =========================================================
 * DATA MAHASISWA
 * =========================================================
 */

$nama =
   ktmValue(
      $pmbUser,
      'fullname'
   );


$nim =
   ktmValue(
      $pmbUser,
      'nim'
   );


$idPendaftaran =
   ktmValue(
      $pmbUser,
      'register_uid'
   );


$jenisKelamin =
   ktmValue(
      $pmbUser,
      'gender'
   );


$agama =
   ktmValue(
      $pmbUser,
      'agama'
   );


$tempatLahir =
   ktmValue(
      $pmbUser,
      'place'
   );


$tanggalLahir =
   ktmValue(
      $pmbUser,
      'datebirth'
   );


$email =
   ktmValue(
      $pmbUser,
      'email_register'
   );


$phone =
   ktmValue(
      $pmbUser,
      'phone_number'
   );


$alamat =
   ktmValue(
      $pmbUser,
      'address_card'
   );


$programId =
   ktmValue(
      $pmbUser,
      'id_program'
   );


$jalur =
   ktmValue(
      $pmbUser,
      'register_type'
   );


/**
 * =========================================================
 * FORMAT TANGGAL LAHIR
 * =========================================================
 */

$tanggalLahirDisplay = '-';

if (
   $tanggalLahir !== '-' &&
   strtotime($tanggalLahir)
) {

   $tanggalLahirDisplay =
      date(
         'd-m-Y',
         strtotime($tanggalLahir)
      );
}


/**
 * =========================================================
 * FOTO
 * =========================================================
 *
 * Menggunakan file_dokumen sebagai foto peserta
 * jika file tersebut tersedia.
 *
 */

$fotoUrl =
   null;


$fotoFile =
   ktmValue(
      $pmbUser,
      'file_dokumen',
      ''
   );


if ($fotoFile !== '') {

   $fotoPath =
      __DIR__ .
      '/../uploads/pmb/' .
      $fotoFile;


   if (
      is_file($fotoPath)
   ) {

      $fotoUrl =
         '../../uploads/pmb/' .
         rawurlencode(
            $fotoFile
         );
   }
}


/**
 * =========================================================
 * QR CODE
 * =========================================================
 */

$qrData =
   $idPendaftaran;


$qrUrl =
   'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=' .
   urlencode($qrData);


/**
 * =========================================================
 * TANGGAL CETAK
 * =========================================================
 */

$tanggalCetak =
   date(
      'd-m-Y H:i:s'
   );


/**
 * =========================================================
 * TAHUN AKADEMIK
 * =========================================================
 */

$tahunAkademik =
   '2026/2027';


$page =
   'Kartu Tanda Mahasiswa';

?>
<!DOCTYPE html>

<html lang="id">

<head>

   <base href="../">

   <meta charset="UTF-8">

   <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0">


   <title>
      Cetak KTM - <?= h($nama) ?>
   </title>


   <link
      rel="stylesheet"
      href="./assets/css/plugins.css">

   <link
      rel="stylesheet"
      href="./assets/css/style.css">


   <style>
      /**
         * =====================================================
         * SCREEN
         * =====================================================
         */

      body {

         background: #f5f7fa;

      }


      .ktm-page {

         padding-top: 50px;
         padding-bottom: 80px;

      }


      .ktm-wrapper {

         max-width: 1000px;

         margin: 0 auto;

      }


      /**
         * =====================================================
         * HEADER
         * =====================================================
         */

      .ktm-page-header {

         margin-bottom: 30px;

      }


      .ktm-page-header h2 {

         font-weight: 700;

      }


      /**
         * =====================================================
         * KTM CARD
         * =====================================================
         */

      .ktm-card {

         width: 860px;

         max-width: 100%;

         min-height: 540px;

         margin: 0 auto;

         background: #ffffff;

         border-radius: 18px;

         overflow: hidden;

         position: relative;

         box-shadow:
            0 20px 50px rgba(0,
               0,
               0,
               .12);

      }


      /**
         * =====================================================
         * KTM TOP
         * =====================================================
         */

      .ktm-top {

         background:
            linear-gradient(135deg,
               #1b4d8c,
               #0d6efd);

         color: #ffffff;

         padding: 25px 30px;

         position: relative;

         overflow: hidden;

      }


      .ktm-top::after {

         content: "";

         position: absolute;

         width: 300px;

         height: 300px;

         border-radius: 50%;

         right: -130px;

         top: -190px;

         background:
            rgba(255,
               255,
               255,
               .08);

      }


      .ktm-institution {

         position: relative;

         z-index: 2;

         display: flex;

         align-items: center;

      }


      .ktm-logo {

         width: 62px;

         height: 62px;

         background: #ffffff;

         border-radius: 12px;

         display: flex;

         align-items: center;

         justify-content: center;

         margin-right: 16px;

         overflow: hidden;

      }


      .ktm-logo img {

         max-width: 48px;

         max-height: 48px;

      }


      .ktm-logo-placeholder {

         font-size: 26px;

         font-weight: 800;

         color: #0d6efd;

      }


      .ktm-institution-name {

         font-size: 19px;

         font-weight: 800;

         line-height: 1.2;

      }


      .ktm-institution-sub {

         font-size: 12px;

         opacity: .8;

         margin-top: 4px;

      }


      .ktm-title {

         position: relative;

         z-index: 2;

         margin-top: 25px;

      }


      .ktm-title small {

         display: block;

         font-size: 11px;

         letter-spacing: 1.5px;

         opacity: .75;

         font-weight: 700;

      }


      .ktm-title h2 {

         color: #ffffff;

         margin: 5px 0 0;

         font-size: 25px;

         font-weight: 800;

      }


      /**
         * =====================================================
         * KTM BODY
         * =====================================================
         */

      .ktm-body {

         padding: 30px;

      }


      .ktm-body-grid {

         display: grid;

         grid-template-columns:
            150px 1fr 150px;

         gap: 28px;

         align-items: start;

      }


      /**
         * =====================================================
         * FOTO
         * =====================================================
         */

      .ktm-photo {

         width: 130px;

         height: 165px;

         border-radius: 8px;

         overflow: hidden;

         border:
            1px solid #dfe3e8;

         background: #f2f4f7;

         display: flex;

         align-items: center;

         justify-content: center;

      }


      .ktm-photo img {

         width: 100%;

         height: 100%;

         object-fit: cover;

      }


      .ktm-photo-placeholder {

         text-align: center;

         color: #98a0aa;

         font-size: 12px;

      }


      .ktm-photo-placeholder i {

         display: block;

         font-size: 42px;

         margin-bottom: 5px;

      }


      /**
         * =====================================================
         * DATA
         * =====================================================
         */

      .ktm-data {

         min-width: 0;

      }


      .ktm-name {

         font-size: 23px;

         font-weight: 800;

         color: #20252b;

         margin-bottom: 5px;

      }


      .ktm-nim {

         display: inline-block;

         background: #e9f2ff;

         color: #0d6efd;

         font-size: 14px;

         font-weight: 800;

         padding: 5px 12px;

         border-radius: 20px;

         margin-bottom: 18px;

      }


      .ktm-data-row {

         display: grid;

         grid-template-columns:
            135px 1fr;

         gap: 8px;

         padding: 7px 0;

         border-bottom:
            1px dashed #e4e7eb;

      }


      .ktm-data-label {

         font-size: 11px;

         color: #8a919a;

         text-transform: uppercase;

         font-weight: 700;

      }


      .ktm-data-value {

         font-size: 13px;

         font-weight: 600;

         color: #30363d;

         word-break: break-word;

      }


      /**
         * =====================================================
         * QR
         * =====================================================
         */

      .ktm-qr {

         text-align: center;

      }


      .ktm-qr-box {

         width: 135px;

         height: 135px;

         border:
            1px solid #e1e5e9;

         border-radius: 10px;

         padding: 8px;

         background: #ffffff;

         margin: 0 auto 10px;

      }


      .ktm-qr-box img {

         width: 100%;

         height: 100%;

      }


      .ktm-qr-label {

         font-size: 10px;

         color: #8a919a;

         line-height: 1.4;

      }


      /**
         * =====================================================
         * FOOTER KTM
         * =====================================================
         */

      .ktm-footer {

         border-top:
            1px solid #edf0f3;

         margin-top: 25px;

         padding-top: 18px;

         display: flex;

         justify-content: space-between;

         gap: 20px;

         font-size: 10px;

         color: #8a919a;

      }


      .ktm-status {

         color: #198754;

         font-weight: 800;

      }


      /**
         * =====================================================
         * BUTTON
         * =====================================================
         */

      .ktm-actions {

         margin-top: 30px;

         text-align: center;

      }


      /**
         * =====================================================
         * RESPONSIVE
         * =====================================================
         */

      @media (max-width: 767.98px) {

         .ktm-page {

            padding-top: 25px;

         }


         .ktm-card {

            width: 100%;

         }


         .ktm-body-grid {

            grid-template-columns: 1fr;

            text-align: center;

         }


         .ktm-photo {

            margin: 0 auto;

         }


         .ktm-data {

            text-align: left;

         }


         .ktm-qr {

            margin-top: 10px;

         }


         .ktm-footer {

            flex-direction: column;

            text-align: center;

         }

      }


      /**
         * =====================================================
         * PRINT
         * =====================================================
         */

      @page {

         size: A4 portrait;

         margin: 0;

      }


      @media print {

         html,
         body {

            width: 210mm;

            min-height: 297mm;

            background: #ffffff !important;

         }


         body {

            margin: 0;

            padding: 0;

         }


         body * {

            visibility: hidden;

         }


         .ktm-print-area,
         .ktm-print-area * {

            visibility: visible;

         }


         .ktm-print-area {

            position: absolute;

            left: 0;

            top: 0;

            width: 210mm;

            min-height: 297mm;

            padding-top: 45mm;

            background: #ffffff;

         }


         .ktm-card {

            width: 180mm;

            min-height: auto;

            margin: 0 auto;

            border-radius: 0;

            box-shadow: none;

            border:
               1px solid #dfe3e8;

         }


         .ktm-actions {

            display: none !important;

         }


         .no-print {

            display: none !important;

         }

      }
   </style>

</head>


<body>


   <div class="content-wrapper">


      <!-- =====================================================
         PAGE
    ====================================================== -->

      <section class="wrapper bg-light ktm-page">


         <div class="container">


            <!-- =================================================
                 HEADER
            ================================================== -->

            <div class="ktm-wrapper">


               <div class="ktm-page-header no-print">

                  <a
                     href="./pmb/register-siakad"
                     class="btn btn-sm btn-outline-primary rounded mb-4">

                     <i class="uil uil-arrow-left me-1"></i>

                     Kembali

                  </a>


                  <span class="d-block text-uppercase text-muted fs-13 fw-bold">

                     Dokumen Akademik

                  </span>


                  <h2 class="mt-2 mb-2">

                     Kartu Tanda Mahasiswa

                  </h2>


                  <p class="text-muted mb-0">

                     Periksa data KTM sebelum mencetak.

                  </p>

               </div>


               <!-- =================================================
                     PRINT AREA
                ================================================== -->

               <div class="ktm-print-area">


                  <!-- =================================================
                         KTM
                    ================================================== -->

                  <div class="ktm-card">


                     <!-- =================================================
                             HEADER KTM
                        ================================================== -->

                     <div class="ktm-top">


                        <div class="ktm-institution">


                           <div class="ktm-logo">

                              <div class="ktm-logo-placeholder">

                                 GK

                              </div>

                           </div>


                           <div>

                              <div class="ktm-institution-name">

                                 STIH GRAHA KIRANA

                              </div>


                              <div class="ktm-institution-sub">

                                 KARTU TANDA MAHASISWA

                              </div>

                           </div>


                        </div>


                        <div class="ktm-title">

                           <small>

                              TAHUN AKADEMIK
                              <?= h($tahunAkademik) ?>

                           </small>


                           <h2>

                              KARTU TANDA MAHASISWA

                           </h2>

                        </div>


                     </div>


                     <!-- =================================================
                             BODY KTM
                        ================================================== -->

                     <div class="ktm-body">


                        <div class="ktm-body-grid">


                           <!-- =================================================
                                     FOTO
                                ================================================== -->

                           <div>


                              <div class="ktm-photo">


                                 <?php if ($fotoUrl): ?>


                                    <img
                                       src="<?= h($fotoUrl) ?>"
                                       alt="Foto <?= h($nama) ?>">


                                 <?php else: ?>


                                    <div class="ktm-photo-placeholder">

                                       <i class="uil uil-user"></i>

                                       Foto

                                    </div>


                                 <?php endif; ?>


                              </div>


                           </div>


                           <!-- =================================================
                                     DATA
                                ================================================== -->

                           <div class="ktm-data">


                              <div class="ktm-name">

                                 <?= h($nama) ?>

                              </div>


                              <div class="ktm-nim">

                                 NIM:
                                 <?= h($nim) ?>

                              </div>


                              <!-- NAMA -->

                              <div class="ktm-data-row">

                                 <div class="ktm-data-label">

                                    Nama

                                 </div>


                                 <div class="ktm-data-value">

                                    <?= h($nama) ?>

                                 </div>

                              </div>


                              <!-- JENIS KELAMIN -->

                              <div class="ktm-data-row">

                                 <div class="ktm-data-label">

                                    Jenis Kelamin

                                 </div>


                                 <div class="ktm-data-value">

                                    <?= h($jenisKelamin) ?>

                                 </div>

                              </div>


                              <!-- TEMPAT LAHIR -->

                              <div class="ktm-data-row">

                                 <div class="ktm-data-label">

                                    Tempat / Tgl Lahir

                                 </div>


                                 <div class="ktm-data-value">

                                    <?= h($tempatLahir) ?>

                                    /

                                    <?= h($tanggalLahirDisplay) ?>

                                 </div>

                              </div>


                              <!-- AGAMA -->

                              <div class="ktm-data-row">

                                 <div class="ktm-data-label">

                                    Agama

                                 </div>


                                 <div class="ktm-data-value">

                                    <?= h($agama) ?>

                                 </div>

                              </div>


                              <!-- PROGRAM -->

                              <div class="ktm-data-row">

                                 <div class="ktm-data-label">

                                    Program Studi

                                 </div>


                                 <div class="ktm-data-value">

                                    ID Program:

                                    <?= h($programId) ?>

                                 </div>

                              </div>


                              <!-- ID PMB -->

                              <div class="ktm-data-row">

                                 <div class="ktm-data-label">

                                    ID Pendaftaran

                                 </div>


                                 <div class="ktm-data-value">

                                    <?= h($idPendaftaran) ?>

                                 </div>

                              </div>


                              <!-- EMAIL -->

                              <div class="ktm-data-row">

                                 <div class="ktm-data-label">

                                    Email

                                 </div>


                                 <div class="ktm-data-value">

                                    <?= h($email) ?>

                                 </div>

                              </div>


                           </div>


                           <!-- =================================================
                                     QR
                                ================================================== -->

                           <div class="ktm-qr">


                              <div class="ktm-qr-box">

                                 <img
                                    src="<?= h($qrUrl) ?>"
                                    alt="QR KTM">

                              </div>


                              <div class="ktm-qr-label">

                                 Scan untuk verifikasi<br>

                                 <?= h($idPendaftaran) ?>

                              </div>


                           </div>


                        </div>


                        <!-- =================================================
                                 FOOTER
                            ================================================== -->

                        <div class="ktm-footer">


                           <div>

                              Status Mahasiswa:

                              <span class="ktm-status">

                                 AKTIF

                              </span>

                              <br>

                              Status SIAKAD:

                              <span class="ktm-status">

                                 <?= h($siakadStatus) ?>

                              </span>

                           </div>


                           <div style="text-align:right;">

                              Dicetak melalui Portal PMB

                              <br>

                              <?= h($tanggalCetak) ?>

                           </div>


                        </div>


                     </div>


                  </div>


               </div>


               <!-- =================================================
                     ACTION
                ================================================== -->

               <div class="ktm-actions no-print">


                  <button
                     type="button"
                     onclick="window.print()"
                     class="btn btn-primary rounded btn-icon btn-icon-end me-2">

                     Cetak KTM

                     <i class="uil uil-print"></i>

                  </button>


                  <a
                     href="./pmb/register-siakad"
                     class="btn btn-outline-primary rounded">

                     <i class="uil uil-arrow-left me-1"></i>

                     Kembali

                  </a>


               </div>


            </div>

         </div>

      </section>


   </div>


</body>

</html>