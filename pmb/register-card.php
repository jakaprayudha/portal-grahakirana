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
   header('Location: ./login-pmb');
   exit;
}

$userId = (int) $_SESSION['pmb_user_id'];


/**
 * =========================================================
 * AMBIL DATA PESERTA
 * =========================================================
 */

$stmt = $pdo->prepare("
    SELECT
        id,
        fullname,
        gender,
        agama,
        place,
        datebirth,
        number_id,
        phone_number,
        email_register,
        address_card,
        provinsi,
        kabupaten,
        kecamatan,
        kelurahan,

        school_name,
        school_npsn,
        school_address,
        number_nisn,
        year_graduation,

        name_father,
        name_mother,

        number_kk,
        number_nik_kk,

        register_uid,
        register_type,

        ms_program_studi.id_program,
        id_provider,

        file_ktp,
        file_kk,
        file_ijazah,
        file_dokumen,

        tahap_aktif,
        status_pendaftaran,
        account_status,

        created_at,
        ms_program_studi.program_name,
        ms_program_studi.program_degree

    FROM register_pmb
    LEFT JOIN ms_program_studi ON ms_program_studi.id_program = register_pmb.id_program
    WHERE id = :id
    LIMIT 1
");

$stmt->execute([
   'id' => $userId
]);

$pmbUser = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$pmbUser) {

   session_destroy();

   header('Location: ./login-pmb');
   exit;
}


/**
 * =========================================================
 * GUARD TAHAP 03
 * =========================================================
 */

if ((int) $pmbUser['tahap_aktif'] < 2) {

   header('Location: ./welcome.php');
   exit;
}


/**
 * =========================================================
 * DATA DISPLAY
 * =========================================================
 */

$namaPeserta =
   $pmbUser['fullname'] ?: '-';

$emailPeserta =
   $pmbUser['email_register'] ?: '-';

$idPendaftaran =
   $pmbUser['register_uid'] ?: '-';

$jalur =
   $pmbUser['register_type'] ?: '-';

$programname =
   $pmbUser['program_degree'] . " - " .  $pmbUser['program_name'] ?: '-';


/**
 * Tahun PMB
 *
 * Bisa nanti dipindahkan ke tabel setting.
 */

$tahunPmb = '2026/2027';


/**
 * =========================================================
 * FOTO PESERTA
 * =========================================================
 *
 * file_dokumen saat ini kita gunakan sebagai pasfoto.
 */

$fotoPeserta = null;

if (!empty($pmbUser['file_dokumen'])) {

   $fotoPath =
      '../uploads/pmb/' . $pmbUser['file_dokumen'];

   if (is_file($fotoPath)) {

      $fotoPeserta =
         'uploads/pmb/' . rawurlencode(
            $pmbUser['file_dokumen']
         );
   }
}


/**
 * =========================================================
 * QR DATA
 * =========================================================
 *
 * Jangan gunakan ID database sebagai QR utama.
 * Gunakan register_uid karena itu identifier peserta.
 */

$qrData =
   $idPendaftaran;

$page = 'Kartu Peserta PMB';


?>
<!DOCTYPE html>
<html lang="en">

<head>
   <base href="../">

   <?php
   $page = 'Kartu Peserta PMB';
   require '../head.php';
   ?>

   <style>
      /* =========================================================
         PMB - TAHAP 03
         KARTU PESERTA
      ========================================================= */

      .pmb-card-section {
         padding-top: 60px;
         padding-bottom: 80px;
      }

      .pmb-page-header {
         margin-bottom: 40px;
      }

      .pmb-page-header h2 {
         font-size: 2.5rem;
      }

      /* Status */
      .pmb-status-card {
         border: 0;
      }

      /* Participant Card */
      .participant-card-wrapper {
         max-width: 850px;
         margin: 0 auto;
      }

      .participant-card {
         position: relative;
         overflow: hidden;
         border-radius: 18px;
         background: #fff;
         border: 1px solid #e7eaf0;
         box-shadow: 0 20px 60px rgba(0, 0, 0, .12);
      }

      .participant-card-header {
         padding: 28px 35px;
         background: #3f78e0;
         color: #fff;
         position: relative;
         overflow: hidden;
      }

      .participant-card-header::after {
         content: "";
         position: absolute;
         width: 220px;
         height: 220px;
         border-radius: 50%;
         background: rgba(255, 255, 255, .08);
         right: -80px;
         top: -100px;
      }

      .participant-logo {
         width: 58px;
         height: 58px;
         object-fit: contain;
         background: #fff;
         border-radius: 10px;
         padding: 6px;
      }

      .participant-institution {
         font-size: 20px;
         font-weight: 700;
         line-height: 1.2;
      }

      .participant-subtitle {
         font-size: 13px;
         opacity: .8;
      }

      .participant-year {
         font-size: 13px;
         font-weight: 600;
         border: 1px solid rgba(255, 255, 255, .4);
         border-radius: 30px;
         padding: 7px 14px;
      }

      .participant-card-body {
         padding: 35px;
      }

      .participant-photo {
         width: 145px;
         height: 180px;
         object-fit: cover;
         border-radius: 8px;
         border: 1px solid #e5e7eb;
         background: #f5f6f8;
      }

      .participant-photo-placeholder {
         width: 145px;
         height: 180px;
         border-radius: 8px;
         background: #f1f4f8;
         display: flex;
         align-items: center;
         justify-content: center;
         border: 1px solid #e5e7eb;
      }

      .participant-id {
         display: inline-block;
         background: #f0f5ff;
         color: #3f78e0;
         padding: 7px 14px;
         border-radius: 30px;
         font-size: 13px;
         font-weight: 700;
         letter-spacing: .5px;
      }

      .participant-name {
         font-size: 28px;
         font-weight: 700;
         margin-bottom: 15px;
      }

      .participant-info-row {
         display: flex;
         border-bottom: 1px solid #edf0f3;
         padding: 12px 0;
      }

      .participant-info-label {
         width: 150px;
         color: #8a8f98;
         font-size: 13px;
      }

      .participant-info-value {
         flex: 1;
         font-size: 14px;
         font-weight: 600;
      }

      .participant-qr {
         width: 125px;
         height: 125px;
         border: 1px solid #e4e7eb;
         border-radius: 8px;
         padding: 8px;
         background: #fff;
      }

      .participant-card-footer {
         padding: 18px 35px;
         border-top: 1px dashed #dfe3e8;
         background: #fafbfc;
      }

      .participant-footer-note {
         font-size: 12px;
         color: #8a8f98;
      }

      /* Instruction */
      .pmb-instruction-card {
         border: 0;
      }

      .pmb-instruction-item {
         display: flex;
         align-items: flex-start;
         margin-bottom: 20px;
      }

      .pmb-instruction-item:last-child {
         margin-bottom: 0;
      }

      .pmb-instruction-number {
         width: 35px;
         height: 35px;
         min-width: 35px;
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         background: #edf3ff;
         color: #3f78e0;
         font-weight: 700;
         margin-right: 13px;
      }

      /* Mobile */
      @media (max-width: 991.98px) {

         .pmb-card-section {
            padding-top: 50px;
            padding-bottom: 60px;
         }

         .pmb-page-header h2 {
            font-size: 2.2rem;
         }

         .participant-card-body {
            padding: 25px;
         }

      }

      @media (max-width: 767.98px) {

         .pmb-card-section {
            padding-top: 35px;
            padding-bottom: 50px;
         }

         .pmb-page-header {
            margin-bottom: 30px;
         }

         .pmb-page-header h2 {
            font-size: 1.8rem;
         }

         .pmb-page-header p {
            font-size: 14px;
            line-height: 1.6;
         }

         .participant-card-header {
            padding: 20px;
         }

         .participant-logo {
            width: 48px;
            height: 48px;
         }

         .participant-institution {
            font-size: 15px;
         }

         .participant-subtitle {
            font-size: 11px;
         }

         .participant-year {
            font-size: 11px;
            padding: 5px 10px;
         }

         .participant-card-body {
            padding: 20px;
         }

         .participant-photo,
         .participant-photo-placeholder {
            width: 110px;
            height: 140px;
         }

         .participant-name {
            font-size: 21px;
         }

         .participant-info-label {
            width: 110px;
            font-size: 12px;
         }

         .participant-info-value {
            font-size: 13px;
         }

         .participant-qr {
            width: 100px;
            height: 100px;
         }

         .participant-card-footer {
            padding: 15px 20px;
         }

         .participant-card-footer .btn {
            width: 100%;
         }

      }

      @media (max-width: 575.98px) {

         .pmb-page-header h2 {
            font-size: 1.6rem;
         }

         .participant-card-header {
            padding: 16px;
         }

         .participant-card-body {
            padding: 16px;
         }

         .participant-photo,
         .participant-photo-placeholder {
            width: 90px;
            height: 115px;
         }

         .participant-name {
            font-size: 18px;
         }

         .participant-info-row {
            display: block;
         }

         .participant-info-label {
            display: block;
            width: 100%;
            margin-bottom: 3px;
         }

         .participant-qr {
            width: 90px;
            height: 90px;
         }

         .participant-card-footer {
            padding: 15px 16px;
         }

      }
   </style>

</head>


<body>

   <div class="content-wrapper">

      <?php
      require '../navbar.php';
      ?>


      <!-- =====================================================
           SECTION : TAHAP 03
      ====================================================== -->

      <section class="wrapper bg-light pmb-card-section">

         <div class="container">


            <!-- =================================================
                 PAGE HEADER
            ================================================== -->

            <div class="row pmb-page-header">

               <div class="col-lg-9">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
                     TAHAP 03
                  </span>

                  <h2 class="display-4 mb-3">
                     Kartu Peserta PMB
                  </h2>

                  <p class="lead fs-18 mb-0">
                     Kartu peserta merupakan bukti bahwa Anda telah menyelesaikan
                     proses pendaftaran dan dapat digunakan selama proses seleksi PMB.
                  </p>

               </div>

            </div>


            <!-- =================================================
                 STATUS
            ================================================== -->

            <div class="card shadow-sm mb-7 pmb-status-card">

               <div class="card-body p-5">

                  <div class="row align-items-center">


                     <div class="col-lg">

                        <div class="d-flex align-items-center">

                           <div class="icon btn btn-circle btn-lg btn-soft-green me-4">

                              <i class="uil uil-check-circle"></i>

                           </div>

                           <div>

                              <span class="text-uppercase text-muted fs-13 fw-bold">
                                 Status Pendaftaran
                              </span>
                              <h4 class="mb-1">

                                 <?= htmlspecialchars(
                                    $pmbUser['status_pendaftaran'] ?: 'DATA_DOKUMEN'
                                 ) ?>

                              </h4>

                              <p class="text-muted mb-0 fs-14">

                                 Kartu peserta telah tersedia
                                 untuk proses PMB.

                              </p>

                           </div>

                        </div>

                     </div>


                     <div class="col-lg-auto mt-4 mt-lg-0">

                        <span class="badge bg-soft-green text-green rounded-pill px-4 py-2">

                           <i class="uil uil-check me-1"></i>

                           DATA LENGKAP

                        </span>

                     </div>


                  </div>

               </div>

            </div>


            <!-- =================================================
                 PARTICIPANT CARD
            ================================================== -->

            <div class="participant-card-wrapper">

               <div class="participant-card">


                  <!-- =================================================
                       CARD HEADER
                  ================================================== -->

                  <div class="participant-card-header">

                     <div class="row align-items-center">


                        <div class="col">

                           <div class="d-flex align-items-center">

                              <!-- Logo -->

                              <div class="me-4">

                                 <div class="participant-logo">

                                    <img
                                       src="./assets/img/logo-card.png"
                                       alt="Logo STIH Graha Kirana"
                                       class="img-fluid">

                                 </div>

                              </div>


                              <!-- Institution -->

                              <div>

                                 <div class="participant-institution">

                                    STIH GRAHA KIRANA

                                 </div>

                                 <div class="participant-subtitle">

                                    Seleksi Penerimaan Mahasiswa Baru

                                 </div>

                              </div>

                           </div>

                        </div>


                        <div class="col-auto">

                           <span class="participant-year">

                              PMB 2026/2027

                           </span>

                        </div>


                     </div>

                  </div>


                  <!-- =================================================
                       CARD BODY
                  ================================================== -->

                  <div class="participant-card-body">

                     <div class="row align-items-center">


                        <!-- PHOTO -->

                        <div class="col-md-3 text-center mb-5 mb-md-0">

                           <?php if ($fotoPeserta): ?>

                              <img
                                 src="<?= htmlspecialchars($fotoPeserta) ?>"
                                 class="participant-photo mx-auto d-block"
                                 alt="Foto <?= htmlspecialchars($namaPeserta) ?>">

                           <?php else: ?>

                              <div class="participant-photo-placeholder mx-auto">

                                 <i class="uil uil-user text-muted fs-50"></i>

                              </div>

                           <?php endif; ?>

                        </div>


                        <!-- INFORMATION -->

                        <div class="col-md-6">


                           <span class="participant-id mb-3">

                              ID:

                              <?= htmlspecialchars($idPendaftaran) ?>

                           </span>

                           <h3 class="participant-name mt-4">

                              <?= htmlspecialchars($namaPeserta) ?>

                           </h3>


                           <div class="participant-info-row">

                              <div class="participant-info-label">
                                 Jalur
                              </div>

                              <div class="participant-info-value">

                                 <?= htmlspecialchars($jalur) ?>

                              </div>

                           </div>


                           <div class="participant-info-row">

                              <div class="participant-info-label">
                                 Program Studi
                              </div>

                              <div class="participant-info-value">

                                 <?= htmlspecialchars($programname) ?>

                              </div>

                           </div>


                           <div class="participant-info-row">

                              <div class="participant-info-label">
                                 Tahun Akademik
                              </div>

                              <div class="participant-info-value">

                                 <?= htmlspecialchars($tahunPmb) ?>

                              </div>

                           </div>


                           <div class="participant-info-row">

                              <div class="participant-info-label">
                                 Status
                              </div>

                              <div class="participant-info-value">

                                 <span class="text-green">
                                    <i class="uil uil-check-circle me-1"></i>
                                    Peserta PMB
                                 </span>

                              </div>

                           </div>


                        </div>


                        <!-- QR -->

                        <div class="col-md-3 text-center mt-5 mt-md-0">

                           <div class="mb-3">

                              <div class="participant-qr mx-auto">

                                 <!--
                                    Ganti dengan QR Code hasil generate server
                                 -->
                                 <?php
                                 $qrToken = $pmbUser['register_uid'];
                                 $verifyUrl =
                                    'https://grahakirana-stih.ac.id/pmb/verifikasi-pmb?token=' .
                                    urlencode($qrToken);
                                 ?>
                                 <img
                                    src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= urlencode($verifyUrl) ?>"
                                    class="img-fluid"
                                    alt="QR Code Verifikasi Peserta">

                              </div>

                           </div>


                           <span class="text-muted fs-12">

                              Scan untuk verifikasi peserta

                           </span>

                        </div>


                     </div>

                  </div>


                  <!-- =================================================
                       CARD FOOTER
                  ================================================== -->

                  <div class="participant-card-footer">

                     <div class="row align-items-center">


                        <div class="col-lg">

                           <p class="participant-footer-note mb-0">

                              Kartu ini merupakan bukti peserta Penerimaan
                              Mahasiswa Baru dan wajib dibawa pada saat
                              mengikuti proses seleksi.

                           </p>

                        </div>


                        <div class="col-lg-auto mt-4 mt-lg-0">

                           <a
                              href="./pmb/print/print-kartu-peserta"
                              target="_blank"
                              rel="noopener"
                              class="btn btn-primary rounded btn-icon btn-icon-end">

                              Cetak Kartu

                              <i class="uil uil-print"></i>

                           </a>

                        </div>


                     </div>

                  </div>


               </div>

            </div>


            <!-- =================================================
                 ACTIONS
            ================================================== -->

            <div class="row mt-7">

               <div class="col-lg-10 mx-auto">

                  <a
                     href="./pmb/register-schedule"
                     class="text-decoration-none d-block">

                     <div
                        class="card bg-soft-primary border-0 shadow-sm h-100 pmb-next-stage-card">

                        <div class="card-body p-5">

                           <div class="row align-items-center">


                              <!-- =========================================
                       INFO
                  ========================================== -->

                              <div class="col-lg">

                                 <div class="d-flex align-items-start">

                                    <div
                                       class="icon btn btn-circle btn-lg btn-primary me-4 flex-shrink-0">

                                       <i class="uil uil-calendar-alt"></i>

                                    </div>


                                    <div>

                                       <span
                                          class="text-uppercase text-primary fs-13 fw-bold">

                                          Tahap Berikutnya

                                       </span>


                                       <h4 class="mb-1 text-dark">

                                          Jadwal Seleksi PMB

                                       </h4>


                                       <p class="mb-0 text-muted">

                                          Lihat jadwal TPA dan wawancara
                                          setelah kartu peserta diterbitkan.

                                       </p>

                                    </div>

                                 </div>

                              </div>


                              <!-- =========================================
                       ACTION
                  ========================================== -->

                              <div class="col-lg-auto mt-4 mt-lg-0">

                                 <div class="text-lg-end">

                                    <span
                                       class="badge bg-soft-primary text-primary rounded-pill px-4 py-2 mb-2">

                                       Tahap 04

                                       <i class="uil uil-arrow-right ms-1"></i>

                                    </span>


                                    <div>

                                       <span
                                          class="btn btn-primary btn-sm rounded-pill px-4">

                                          Lihat Jadwal

                                          <i class="uil uil-arrow-right ms-1"></i>

                                       </span>

                                    </div>

                                 </div>

                              </div>


                           </div>

                        </div>

                     </div>

                  </a>

               </div>

            </div>


            <!-- =================================================
                 INSTRUCTIONS
            ================================================== -->

            <div class="row mt-8">

               <div class="col-lg-10 mx-auto">

                  <div class="card shadow-sm pmb-instruction-card">

                     <div class="card-body p-6 p-md-7">


                        <div class="text-center mb-6">

                           <span class="text-uppercase text-muted fs-13 fw-bold">
                              Informasi Penting
                           </span>

                           <h3 class="mt-2 mb-0">
                              Penggunaan Kartu Peserta
                           </h3>

                        </div>


                        <!-- Instruction 1 -->

                        <div class="pmb-instruction-item">

                           <div class="pmb-instruction-number">
                              1
                           </div>

                           <div>

                              <h5 class="mb-1">
                                 Simpan kartu dengan baik
                              </h5>

                              <p class="text-muted mb-0 fs-14">
                                 Download atau cetak kartu peserta untuk
                                 keperluan proses PMB.
                              </p>

                           </div>

                        </div>


                        <!-- Instruction 2 -->

                        <div class="pmb-instruction-item">

                           <div class="pmb-instruction-number">
                              2
                           </div>

                           <div>

                              <h5 class="mb-1">
                                 Bawa saat seleksi
                              </h5>

                              <p class="text-muted mb-0 fs-14">
                                 Kartu peserta digunakan sebagai identitas
                                 selama proses seleksi.
                              </p>

                           </div>

                        </div>


                        <!-- Instruction 3 -->

                        <div class="pmb-instruction-item">

                           <div class="pmb-instruction-number">
                              3
                           </div>

                           <div>

                              <h5 class="mb-1">
                                 QR Code
                              </h5>

                              <p class="text-muted mb-0 fs-14">
                                 QR Code pada kartu dapat digunakan untuk
                                 verifikasi data peserta.
                              </p>

                           </div>

                        </div>


                        <!-- Instruction 4 -->

                        <div class="pmb-instruction-item">

                           <div class="pmb-instruction-number">
                              4
                           </div>

                           <div>

                              <h5 class="mb-1">
                                 Data harus sesuai
                              </h5>

                              <p class="text-muted mb-0 fs-14">
                                 Jika terdapat kesalahan data, segera
                                 hubungi administrator PMB.
                              </p>

                           </div>

                        </div>


                     </div>

                  </div>

               </div>

            </div>


         </div>

      </section>


   </div>


   <!-- =========================================================
        FOOTER
   ========================================================== -->

   <?php
   require '../footer2.php';
   ?>


   <!-- =========================================================
        PROGRESS
   ========================================================== -->

   <div class="progress-wrap">

      <svg
         class="progress-circle svg-content"
         width="100%"
         height="100%"
         viewBox="-1 -1 102 102">

         <path
            d="M50,1 a49,49 0,0,1 0,98 a49,49 0,0,1 0,-98" />

      </svg>

   </div>


   <!-- =========================================================
        JS
   ========================================================== -->

   <script src="./assets/js/plugins.js"></script>

   <script src="./assets/js/theme.js"></script>

</body>

</html>