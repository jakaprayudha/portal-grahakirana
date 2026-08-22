<?php

session_start();

require_once '../../config/connect.php';

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
 * GET PESERTA
 * =========================================================
 */

$stmt = $pdo->prepare("
    SELECT
        id,
        fullname,
        gender,
        email_register,
        phone_number,
        register_uid,
        register_type,
        id_program,
        id_provider,
        tahap_aktif,
        status_pendaftaran,
        account_status
    FROM register_pmb
    WHERE id = :id
    LIMIT 1
");

$stmt->execute([
   'id' => $userId
]);

$pmbUser = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$pmbUser) {

   session_destroy();

   header('Location: ./login-pmb.php');
   exit;
}


/**
 * =========================================================
 * GUARD TAHAP 04
 * =========================================================
 */

if ((int) $pmbUser['tahap_aktif'] < 2) {

   header('Location: ./welcome.php');
   exit;
}


/**
 * =========================================================
 * DATA PESERTA
 * =========================================================
 */

$namaPeserta =
   $pmbUser['fullname'] ?: '-';

$idPendaftaran =
   $pmbUser['register_uid'] ?: '-';

$jalur =
   $pmbUser['register_type'] ?: '-';

$tahunPmb =
   '2026/2027';


/**
 * =========================================================
 * JADWAL STATIS
 * =========================================================
 *
 * Sementara mengikuti data pada halaman
 * register-schedule.php.
 *
 * Nanti bisa dipindahkan ke database.
 * =========================================================
 */

$jadwalSeleksi = [

   [
      'no' => 1,

      'jenis' => 'Tes Potensi Akademik',

      'kategori' => 'SELEKSI AKADEMIK',

      'tanggal' => 'Selasa, 15 September 2026',

      'hari' => 'Selasa',

      'tanggal_short' => '15 September 2026',

      'waktu' => '09.00 – 11.00 WIB',

      'lokasi' => 'Kampus STIH Graha Kirana',

      'ruangan' => 'Ruang Ujian 01',

      'metode' => 'Offline',

      'keterangan' =>
      'Harap hadir 30 menit sebelum ujian.'
   ],

   [
      'no' => 2,

      'jenis' => 'Wawancara',

      'kategori' => 'SELEKSI LANJUTAN',

      'tanggal' => 'Rabu, 16 September 2026',

      'hari' => 'Rabu',

      'tanggal_short' => '16 September 2026',

      'waktu' => '13.00 – 15.00 WIB',

      'lokasi' => 'Kampus STIH Graha Kirana',

      'ruangan' => 'Ruang Wawancara 02',

      'metode' => 'Offline / Tatap Muka',

      'keterangan' =>
      'Siapkan dokumen pendukung.'
   ]

];

?>
<!DOCTYPE html>

<html lang="id">

<head>

   <meta charset="UTF-8">

   <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0">

   <title>
      Jadwal Seleksi PMB -
      <?= htmlspecialchars($namaPeserta) ?>
   </title>


   <style>
      * {
         box-sizing: border-box;
      }


      html,
      body {

         margin: 0;
         padding: 0;

         background: #e5e7eb;

         font-family:
            Arial,
            Helvetica,
            sans-serif;

         color: #20242a;

      }


      /*
        =====================================================
        TOOLBAR
        =====================================================
        */

      .print-toolbar {

         width: 210mm;

         margin: 18px auto;

         display: flex;

         justify-content: flex-end;

         gap: 10px;

      }


      .btn-print {

         border: 0;

         padding: 11px 20px;

         border-radius: 6px;

         background: #3f78e0;

         color: #fff;

         font-size: 13px;

         font-weight: 600;

         cursor: pointer;

      }


      .btn-print:hover {

         background: #285fc4;

      }


      /*
        =====================================================
        A4 PAGE
        =====================================================
        */

      .a4-page {

         width: 210mm;

         min-height: 297mm;

         margin: 0 auto;

         padding: 16mm 17mm;

         background: #fff;

      }


      /*
        =====================================================
        DOCUMENT HEADER
        =====================================================
        */

      .document-header {

         border-bottom: 2px solid #3f78e0;

         padding-bottom: 7mm;

         margin-bottom: 8mm;

      }


      .header-table {

         width: 100%;

         border-collapse: collapse;

      }


      .logo-cell {

         width: 25mm;

      }


      .logo {

         width: 20mm;

         height: 20mm;

         object-fit: contain;

      }


      .institution-name {

         font-size: 17pt;

         font-weight: 700;

         line-height: 1.2;

         margin-bottom: 1.5mm;

      }


      .institution-subtitle {

         font-size: 9pt;

         color: #666;

         line-height: 1.5;

      }


      .year-box {

         text-align: right;

      }


      .year-label {

         font-size: 7pt;

         text-transform: uppercase;

         color: #888;

         letter-spacing: .8px;

         margin-bottom: 1mm;

      }


      .year-value {

         font-size: 11pt;

         font-weight: 700;

         color: #3f78e0;

      }


      /*
        =====================================================
        TITLE
        =====================================================
        */

      .document-title {

         text-align: center;

         margin-bottom: 8mm;

      }


      .document-title h1 {

         margin: 0 0 2mm;

         font-size: 17pt;

         font-weight: 700;

         letter-spacing: .3px;

      }


      .document-title p {

         margin: 0;

         font-size: 9pt;

         color: #777;

      }


      /*
        =====================================================
        PARTICIPANT BOX
        =====================================================
        */

      .participant-box {

         border: 1px solid #dfe4ea;

         border-radius: 3mm;

         background: #f8fafc;

         padding: 5mm;

         margin-bottom: 8mm;

      }


      .participant-table {

         width: 100%;

         border-collapse: collapse;

      }


      .participant-table td {

         padding: 1.8mm 0;

         font-size: 9pt;

         vertical-align: top;

      }


      .participant-label {

         width: 35mm;

         color: #777;

      }


      .participant-value {

         font-weight: 600;

      }


      .participant-id {

         color: #3f78e0;

         font-weight: 700;

      }


      /*
        =====================================================
        SCHEDULE TABLE
        =====================================================
        */

      .section-label {

         font-size: 8pt;

         font-weight: 700;

         color: #777;

         text-transform: uppercase;

         letter-spacing: .7px;

         margin-bottom: 3mm;

      }


      .schedule-table {

         width: 100%;

         border-collapse: collapse;

         border: 1px solid #d8dde4;

      }


      .schedule-table th {

         padding: 3.5mm 3mm;

         background: #f1f4f8;

         border: 1px solid #d8dde4;

         font-size: 7.5pt;

         text-align: left;

         text-transform: uppercase;

         letter-spacing: .3px;

         color: #555;

      }


      .schedule-table td {

         padding: 4mm 3mm;

         border: 1px solid #d8dde4;

         font-size: 8.5pt;

         vertical-align: top;

         line-height: 1.5;

      }


      .schedule-number {

         width: 9mm;

         text-align: center;

         font-weight: 700;

         color: #3f78e0;

      }


      .schedule-name {

         font-weight: 700;

         font-size: 9pt;

         color: #20242a;

         margin-bottom: 1mm;

      }


      .schedule-category {

         display: inline-block;

         font-size: 6.5pt;

         font-weight: 700;

         color: #3f78e0;

         background: #edf3ff;

         padding: 1mm 2mm;

         border-radius: 10px;

      }


      .schedule-date {

         font-weight: 600;

      }


      .schedule-time {

         font-weight: 700;

         color: #3f78e0;

      }


      .schedule-location {

         font-weight: 600;

      }


      .schedule-room {

         color: #666;

      }


      .schedule-method {

         font-size: 7.5pt;

         color: #666;

      }


      /*
        =====================================================
        IMPORTANT INFORMATION
        =====================================================
        */

      .information-box {

         margin-top: 7mm;

         border: 1px solid #d8e4f8;

         border-left: 4px solid #3f78e0;

         background: #f5f8fd;

         padding: 4mm 5mm;

      }


      .information-title {

         font-size: 9pt;

         font-weight: 700;

         color: #285fc4;

         margin-bottom: 2mm;

      }


      .information-list {

         margin: 0;

         padding-left: 5mm;

      }


      .information-list li {

         font-size: 8pt;

         margin-bottom: 1.5mm;

         line-height: 1.5;

      }


      .information-list li:last-child {

         margin-bottom: 0;

      }


      /*
        =====================================================
        FOOTER
        =====================================================
        */

      .document-footer {

         margin-top: 12mm;

         padding-top: 5mm;

         border-top: 1px solid #dfe3e8;

      }


      .footer-table {

         width: 100%;

         border-collapse: collapse;

      }


      .footer-table td {

         font-size: 7pt;

         color: #888;

         line-height: 1.5;

      }


      .footer-right {

         text-align: right;

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

            min-height: 297mm;

            margin: 0;

            padding: 0;

            background: #fff;

         }


         .print-toolbar {

            display: none !important;

         }


         .a4-page {

            width: 210mm;

            min-height: 297mm;

            margin: 0;

            padding: 16mm 17mm;

         }


         .schedule-table {

            break-inside: avoid;

            page-break-inside: avoid;

         }


         .participant-box,
         .information-box {

            break-inside: avoid;

            page-break-inside: avoid;

         }

      }


      /*
        =====================================================
        SCREEN PREVIEW
        =====================================================
        */

      @media screen and (max-width: 800px) {

         .print-toolbar {

            width: 100%;

            padding: 0 15px;

         }


         .a4-page {

            width: 100%;

            min-height: auto;

            padding: 25px 20px;

         }

      }
   </style>

</head>


<body>


   <!-- =====================================================
     PRINT TOOLBAR
====================================================== -->

   <div class="print-toolbar">

      <button
         type="button"
         class="btn-print"
         onclick="window.print()">

         🖨 Cetak Jadwal

      </button>

   </div>


   <!-- =====================================================
     A4 DOCUMENT
====================================================== -->

   <main class="a4-page">


      <!-- =================================================
         HEADER
    ================================================== -->

      <header class="document-header">

         <table class="header-table">

            <tr>

               <td class="logo-cell">

                  <img
                     src="./assets/img/logo-stih.png"
                     class="logo"
                     alt="Logo STIH Graha Kirana">

               </td>


               <td>

                  <div class="institution-name">

                     STIH GRAHA KIRANA

                  </div>

                  <div class="institution-subtitle">

                     Penerimaan Mahasiswa Baru

                  </div>

               </td>


               <td class="year-box">

                  <div class="year-label">

                     Tahun Akademik

                  </div>

                  <div class="year-value">

                     <?= htmlspecialchars($tahunPmb) ?>

                  </div>

               </td>

            </tr>

         </table>

      </header>


      <!-- =================================================
         TITLE
    ================================================== -->

      <div class="document-title">

         <h1>

            JADWAL SELEKSI PMB

         </h1>

         <p>

            Jadwal pelaksanaan seleksi
            Penerimaan Mahasiswa Baru

         </p>

      </div>


      <!-- =================================================
         PARTICIPANT
    ================================================== -->

      <section class="participant-box">

         <table class="participant-table">

            <tr>

               <td class="participant-label">

                  Nama Peserta

               </td>

               <td class="participant-value">

                  <?= htmlspecialchars($namaPeserta) ?>

               </td>


               <td class="participant-label">

                  ID Pendaftaran

               </td>

               <td class="participant-value participant-id">

                  <?= htmlspecialchars($idPendaftaran) ?>

               </td>

            </tr>


            <tr>

               <td class="participant-label">

                  Jalur Pendaftaran

               </td>

               <td class="participant-value">

                  <?= htmlspecialchars($jalur) ?>

               </td>


               <td class="participant-label">

                  Status

               </td>

               <td class="participant-value">

                  Peserta PMB

               </td>

            </tr>

         </table>

      </section>


      <!-- =================================================
         SCHEDULE
    ================================================== -->

      <div class="section-label">

         Rincian Jadwal Seleksi

      </div>


      <table class="schedule-table">

         <thead>

            <tr>

               <th class="schedule-number">
                  No.
               </th>

               <th>
                  Kegiatan
               </th>

               <th>
                  Tanggal
               </th>

               <th>
                  Waktu
               </th>

               <th>
                  Lokasi / Ruangan
               </th>

               <th>
                  Metode
               </th>

            </tr>

         </thead>


         <tbody>

            <?php foreach ($jadwalSeleksi as $jadwal): ?>

               <tr>

                  <td class="schedule-number">

                     <?= $jadwal['no'] ?>

                  </td>


                  <td>

                     <div class="schedule-name">

                        <?= htmlspecialchars(
                           $jadwal['jenis']
                        ) ?>

                     </div>

                     <span class="schedule-category">

                        <?= htmlspecialchars(
                           $jadwal['kategori']
                        ) ?>

                     </span>

                  </td>


                  <td>

                     <div class="schedule-date">

                        <?= htmlspecialchars(
                           $jadwal['tanggal']
                        ) ?>

                     </div>

                  </td>


                  <td>

                     <div class="schedule-time">

                        <?= htmlspecialchars(
                           $jadwal['waktu']
                        ) ?>

                     </div>

                  </td>


                  <td>

                     <div class="schedule-location">

                        <?= htmlspecialchars(
                           $jadwal['lokasi']
                        ) ?>

                     </div>

                     <div class="schedule-room">

                        <?= htmlspecialchars(
                           $jadwal['ruangan']
                        ) ?>

                     </div>

                  </td>


                  <td>

                     <div class="schedule-method">

                        <?= htmlspecialchars(
                           $jadwal['metode']
                        ) ?>

                     </div>

                  </td>

               </tr>

            <?php endforeach; ?>

         </tbody>

      </table>


      <!-- =================================================
         INFORMATION
    ================================================== -->

      <div class="information-box">

         <div class="information-title">

            Informasi Penting

         </div>


         <ul class="information-list">

            <li>

               Peserta wajib hadir minimal
               <strong>30 menit sebelum jadwal</strong>
               seleksi dimulai.

            </li>

            <li>

               Peserta wajib membawa
               <strong>Kartu Peserta PMB</strong>
               dan identitas diri yang digunakan
               saat pendaftaran.

            </li>

            <li>

               Untuk Tes Potensi Akademik,
               peserta wajib membawa alat tulis
               yang diperlukan.

            </li>

            <li>

               Untuk wawancara, peserta diharapkan
               membawa dokumen pendukung apabila
               diperlukan oleh panitia.

            </li>

            <li>

               Jadwal dapat berubah berdasarkan
               kebijakan panitia PMB. Peserta disarankan
               memeriksa Portal PMB secara berkala.

            </li>

         </ul>

      </div>


      <!-- =================================================
         FOOTER
    ================================================== -->

      <footer class="document-footer">

         <table class="footer-table">

            <tr>

               <td>

                  Dokumen Jadwal Seleksi PMB<br>

                  STIH Graha Kirana

               </td>


               <td class="footer-right">

                  ID:
                  <?= htmlspecialchars($idPendaftaran) ?><br>

                  Dicetak melalui Portal PMB

               </td>

            </tr>

         </table>

      </footer>


   </main>


   <script>
      /*
       * Otomatis membuka print dialog
       * ketika halaman selesai dimuat.
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