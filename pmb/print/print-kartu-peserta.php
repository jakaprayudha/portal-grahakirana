<?php

session_start();

require_once '../../config/connect.php';


/**
 * =========================================================
 * AUTH
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
        place,
        datebirth,
        number_id,
        email_register,
        phone_number,

        register_uid,
        register_type,

        register_pmb.id_program,
        id_provider,

        file_dokumen,

        tahap_aktif,
        status_pendaftaran,
        ms_program_studi.program_name,
        ms_program_studi.program_degree,
        created_at

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
 * DATA
 * =========================================================
 */

$nama =
   $pmbUser['fullname'] ?: '-';

$idPendaftaran =
   $pmbUser['register_uid'] ?: '-';

$jalur =
   $pmbUser['register_type'] ?: '-';

$programname =
   $pmbUser['program_degree'] . " - " .  $pmbUser['program_name'] ?: '-';

$tahunPmb =
   '2026/2027';


/**
 * =========================================================
 * FOTO
 * =========================================================
 */


$fotoPeserta = null;

if (!empty($pmbUser['file_dokumen'])) {

   $fotoPath =
      '../../uploads/pmb/' . $pmbUser['file_dokumen'];

   if (is_file($fotoPath)) {

      $fotoPeserta =
         '../../uploads/pmb/' . rawurlencode(
            $pmbUser['file_dokumen']
         );
   }
}

/**
 * =========================================================
 * QR
 * =========================================================
 */

$qrData =
   $idPendaftaran;

?>
<!DOCTYPE html>
<html lang="id">

<head>

   <meta charset="UTF-8">

   <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0">

   <title>
      Kartu Peserta PMB - <?= htmlspecialchars($nama) ?>
   </title>


   <style>
      * {
         box-sizing: border-box;
      }


      html,
      body {

         margin: 0;
         padding: 0;

         background: #e9ecef;

         font-family:
            Arial,
            Helvetica,
            sans-serif;

         color: #222;

      }


      /*
        =====================================================
        PRINT AREA
        =====================================================
        */

      .print-page {

         width: 210mm;

         min-height: 297mm;

         margin: 0 auto;

         background: #fff;

         padding: 20mm;

      }


      /*
        =====================================================
        CARD
        =====================================================
        */

      .participant-card {

         width: 100%;

         border: 1px solid #d9dfe7;

         border-radius: 6mm;

         overflow: hidden;

         background: #fff;

      }


      /*
        =====================================================
        HEADER
        =====================================================
        */

      .card-header {

         position: relative;

         padding: 10mm;

         background:
            linear-gradient(135deg,
               #3f78e0,
               #285fc4);

         color: #fff;

      }


      .header-table {

         width: 100%;

         border-collapse: collapse;

      }


      .header-logo {

         width: 22mm;

         height: 22mm;

         background: #fff;

         border-radius: 3mm;

         padding: 2mm;

         object-fit: contain;

      }


      .institution {

         font-size: 20pt;

         font-weight: 700;

         margin-bottom: 2mm;

      }


      .subtitle {

         font-size: 9pt;

         opacity: .9;

      }


      .year {

         display: inline-block;

         border: 1px solid rgba(255, 255, 255, .5);

         border-radius: 20px;

         padding: 2mm 4mm;

         font-size: 9pt;

         white-space: nowrap;

      }


      /*
        =====================================================
        BODY
        =====================================================
        */

      .card-body {

         padding: 10mm;

      }


      .body-table {

         width: 100%;

         border-collapse: collapse;

      }


      .photo-cell {

         width: 38mm;

         vertical-align: top;

      }


      .photo {

         width: 32mm;

         height: 42mm;

         object-fit: cover;

         border: 1px solid #dfe3e8;

         border-radius: 2mm;

      }


      .photo-placeholder {

         width: 32mm;

         height: 42mm;

         display: flex;

         align-items: center;

         justify-content: center;

         border: 1px solid #dfe3e8;

         border-radius: 2mm;

         background: #f4f6f8;

         color: #9aa0a6;

         font-size: 9pt;

         text-align: center;

      }


      .content-cell {

         vertical-align: top;

         padding-right: 8mm;

      }


      .participant-id {

         display: inline-block;

         padding: 2mm 4mm;

         background: #eef4ff;

         color: #3f78e0;

         border-radius: 20px;

         font-size: 8pt;

         font-weight: 700;

         letter-spacing: .3px;

         margin-bottom: 4mm;

      }


      .participant-name {

         font-size: 19pt;

         font-weight: 700;

         margin-bottom: 5mm;

      }


      .info-table {

         width: 100%;

         border-collapse: collapse;

      }


      .info-table td {

         padding: 2.5mm 0;

         border-bottom: 1px solid #edf0f3;

         font-size: 9pt;

      }


      .info-label {

         width: 38mm;

         color: #858b94;

      }


      .info-value {

         font-weight: 600;

      }


      /*
        =====================================================
        QR
        =====================================================
        */

      .qr-cell {

         width: 35mm;

         vertical-align: top;

         text-align: center;

      }


      .qr {

         width: 30mm;

         height: 30mm;

         padding: 2mm;

         border: 1px solid #e1e5ea;

         border-radius: 2mm;

         background: #fff;

      }


      .qr-note {

         margin-top: 2mm;

         font-size: 7pt;

         color: #858b94;

         line-height: 1.4;

      }


      /*
        =====================================================
        FOOTER
        =====================================================
        */

      .card-footer {

         padding: 5mm 10mm;

         border-top: 1px dashed #cfd5dc;

         background: #fafbfc;

         font-size: 7.5pt;

         color: #777;

         line-height: 1.5;

      }


      .footer-table {

         width: 100%;

         border-collapse: collapse;

      }


      .footer-right {

         text-align: right;

         white-space: nowrap;

      }


      .status {

         display: inline-block;

         padding: 2mm 4mm;

         border-radius: 20px;

         background: #e8f7ee;

         color: #198754;

         font-size: 7.5pt;

         font-weight: 700;

      }


      /*
        =====================================================
        PRINT BUTTON
        =====================================================
        */

      .print-toolbar {

         width: 210mm;

         margin: 20px auto;

         text-align: right;

      }


      .print-button {

         border: 0;

         background: #3f78e0;

         color: #fff;

         padding: 10px 18px;

         border-radius: 6px;

         cursor: pointer;

         font-size: 14px;

      }


      /*
        =====================================================
        PRINT
        =====================================================
        */

      @media print {

         @page {
            size: A4 portrait;
            margin: 0;
         }

         html,
         body {
            width: 210mm;
            height: 297mm;

            margin: 0;
            padding: 0;

            background: #fff;

            overflow: hidden;
         }

         .print-toolbar {
            display: none !important;
         }

         .print-page {
            width: 210mm;
            height: 297mm;

            min-width: 210mm;
            max-width: 210mm;

            min-height: 297mm;
            max-height: 297mm;

            margin: 0;
            padding: 15mm;

            background: #fff;

            overflow: hidden;

            page-break-after: avoid;
            page-break-before: avoid;
            break-after: avoid;
            break-before: avoid;
         }

         .participant-card {
            width: 100%;

            max-height: 267mm;

            overflow: hidden;

            page-break-inside: avoid;
            break-inside: avoid;

            page-break-before: avoid;
            page-break-after: avoid;

            break-before: avoid;
            break-after: avoid;
         }

         .card-header,
         .card-body,
         .card-footer {
            page-break-inside: avoid;
            break-inside: avoid;
         }

         .body-table {
            page-break-inside: avoid;
            break-inside: avoid;
         }

         img {
            page-break-inside: avoid;
            break-inside: avoid;
         }
      }


      /*
        =====================================================
        MOBILE PREVIEW
        =====================================================
        */

      @media screen and (max-width: 800px) {

         .print-page {
            width: 210mm;
            height: 297mm;

            margin: 0 auto;

            padding: 12mm 15mm;

            background: #fff;
         }

         .print-toolbar {

            width: 100%;

            padding: 0 20px;

         }

      }
   </style>

</head>


<body>


   <!-- =====================================================
         TOOLBAR
    ====================================================== -->

   <div class="print-toolbar">

      <button
         type="button"
         class="print-button"
         onclick="window.print()">

         🖨 Cetak Kartu

      </button>

   </div>


   <!-- =====================================================
         A4
    ====================================================== -->

   <main class="print-page">


      <!-- =================================================
             PARTICIPANT CARD
        ================================================== -->

      <div class="participant-card">


         <!-- HEADER -->

         <div class="card-header">

            <table class="header-table">

               <tr>

                  <td width="28mm">

                     <img
                        src="../../assets/img/logo-card.png"
                        class="header-logo"
                        alt="Logo STIH Graha Kirana">

                  </td>


                  <td>

                     <div class="institution">

                        STIH GRAHA KIRANA

                     </div>

                     <div class="subtitle">

                        Seleksi Penerimaan Mahasiswa Baru

                     </div>

                  </td>


                  <td
                     width="35mm"
                     align="right">

                     <span class="year">

                        PMB <?= htmlspecialchars($tahunPmb) ?>

                     </span>

                  </td>

               </tr>

            </table>

         </div>


         <!-- BODY -->

         <div class="card-body">

            <table class="body-table">

               <tr>


                  <!-- PHOTO -->

                  <td class="photo-cell">

                     <?php if ($fotoPeserta): ?>

                        <img
                           src="<?= htmlspecialchars($fotoPeserta) ?>"
                           class="photo"
                           alt="Foto Peserta">

                     <?php else: ?>

                        <div class="photo-placeholder">

                           FOTO<br>
                           PESERTA

                        </div>

                     <?php endif; ?>

                  </td>


                  <!-- INFORMATION -->

                  <td class="content-cell">

                     <div class="participant-id">

                        ID:
                        <?= htmlspecialchars($idPendaftaran) ?>

                     </div>


                     <div class="participant-name">

                        <?= htmlspecialchars($nama) ?>

                     </div>


                     <table class="info-table">

                        <tr>

                           <td class="info-label">
                              Jalur
                           </td>

                           <td class="info-value">

                              <?= htmlspecialchars($jalur) ?>

                           </td>

                        </tr>


                        <tr>

                           <td class="info-label">
                              Program Studi
                           </td>

                           <td class="info-value">

                              <?= htmlspecialchars($programname) ?>

                           </td>

                        </tr>


                        <tr>

                           <td class="info-label">
                              Tahun Akademik
                           </td>

                           <td class="info-value">

                              <?= htmlspecialchars($tahunPmb) ?>

                           </td>

                        </tr>


                        <tr>

                           <td class="info-label">
                              Status
                           </td>

                           <td class="info-value">

                              <span class="status">

                                 PESERTA PMB

                              </span>

                           </td>

                        </tr>

                     </table>

                  </td>


                  <!-- QR -->

                  <td class="qr-cell">

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
                     <div class="qr-note">

                        Scan untuk<br>
                        verifikasi peserta

                     </div>

                  </td>


               </tr>

            </table>

         </div>


         <!-- FOOTER -->

         <div class="card-footer">

            <table class="footer-table">

               <tr>

                  <td>

                     Kartu ini merupakan bukti peserta
                     Penerimaan Mahasiswa Baru dan wajib
                     dibawa pada saat mengikuti proses seleksi.

                  </td>


                  <td class="footer-right">

                     STIH Graha Kirana

                  </td>

               </tr>

            </table>

         </div>


      </div>


   </main>


   <script>
      /*
       * Otomatis buka dialog print
       * setelah tab selesai loading.
       */

      window.addEventListener(
         'load',
         function() {

            setTimeout(
               function() {

                  window.print();

               },
               500
            );

         }
      );
   </script>


</body>

</html>