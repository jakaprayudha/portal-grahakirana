<?php

require_once '../config/connect.php';

$token = trim($_GET['token'] ?? '');

$peserta = null;
$error = null;


/**
 * =========================================================
 * VALIDASI TOKEN
 * =========================================================
 */

if ($token === '') {

   $error = 'QR Code tidak memiliki token verifikasi.';
} else {

   try {

      $stmt = $pdo->prepare("
            SELECT
                id,
                fullname,
                register_uid,
                register_type,
                id_program,
                tahap_aktif,
                gender,
                account_status,
                created_at
            FROM register_pmb
            WHERE register_uid = :token
            LIMIT 1
        ");

      $stmt->execute([
         'token' => $token
      ]);

      $peserta =
         $stmt->fetch(PDO::FETCH_ASSOC);


      if (!$peserta) {

         $error =
            'Data peserta tidak ditemukan atau QR Code tidak valid.';
      }
   } catch (PDOException $e) {

      $error =
         'Terjadi kesalahan saat melakukan verifikasi.';
   }
}


/**
 * =========================================================
 * STATUS
 * =========================================================
 */

$isValid =
   $peserta !== null;

?>
<!DOCTYPE html>

<html lang="id">

<head>

   <meta charset="UTF-8">

   <meta
      name="viewport"
      content="width=device-width, initial-scale=1">

   <title>
      Verifikasi Peserta PMB
   </title>


   <style>
      * {
         box-sizing: border-box;
      }

      body {

         margin: 0;

         min-height: 100vh;

         display: flex;

         align-items: center;

         justify-content: center;

         background: #f3f6fa;

         font-family:
            Arial,
            Helvetica,
            sans-serif;

      }


      .verification-card {

         width: 100%;

         max-width: 480px;

         margin: 20px;

         background: #fff;

         border-radius: 16px;

         box-shadow:
            0 15px 45px rgba(0, 0, 0, .08);

         overflow: hidden;

      }


      .verification-header {

         padding: 30px;

         text-align: center;

         background: #3f78e0;

         color: #fff;

      }


      .verification-icon {

         width: 70px;

         height: 70px;

         margin: 0 auto 15px;

         display: flex;

         align-items: center;

         justify-content: center;

         border-radius: 50%;

         background: rgba(255, 255, 255, .18);

         font-size: 32px;

      }


      .verification-header h1 {

         margin: 0 0 8px;

         font-size: 22px;

      }


      .verification-header p {

         margin: 0;

         opacity: .85;

         font-size: 13px;

      }


      .verification-body {

         padding: 30px;

      }


      .status-valid {

         padding: 15px;

         margin-bottom: 25px;

         border-radius: 10px;

         background: #e9f8ef;

         color: #198754;

         text-align: center;

         font-weight: 700;

      }


      .status-invalid {

         padding: 15px;

         margin-bottom: 25px;

         border-radius: 10px;

         background: #fdecec;

         color: #dc3545;

         text-align: center;

         font-weight: 700;

      }


      .data-row {

         display: flex;

         justify-content: space-between;

         gap: 20px;

         padding: 12px 0;

         border-bottom: 1px solid #edf0f3;

      }


      .data-label {

         color: #777;

         font-size: 13px;

      }


      .data-value {

         text-align: right;

         font-weight: 600;

         font-size: 14px;

      }


      .footer {

         padding: 18px 30px;

         background: #fafbfc;

         text-align: center;

         color: #888;

         font-size: 11px;

      }
   </style>

</head>


<body>


   <div class="verification-card">


      <div class="verification-header">

         <div class="verification-icon">

            <?= $isValid ? '✓' : '!' ?>

         </div>


         <h1>

            Verifikasi Peserta PMB

         </h1>


         <p>

            STIH Graha Kirana

         </p>

      </div>


      <div class="verification-body">


         <?php if ($isValid): ?>


            <div class="status-valid">

               ✓ PESERTA TERDAFTAR

            </div>


            <div class="data-row">

               <div class="data-label">

                  Nama Peserta

               </div>

               <div class="data-value">

                  <?= htmlspecialchars(
                     $peserta['fullname']
                  ) ?>

               </div>

            </div>


            <div class="data-row">

               <div class="data-label">

                  ID Pendaftaran

               </div>

               <div class="data-value">

                  <?= htmlspecialchars(
                     $peserta['register_uid']
                  ) ?>

               </div>

            </div>


            <div class="data-row">

               <div class="data-label">

                  Jalur

               </div>

               <div class="data-value">

                  <?= htmlspecialchars(
                     $peserta['register_type']
                  ) ?>

               </div>

            </div>


            <div class="data-row">

               <div class="data-label">

                  Jenis Kelamin

               </div>

               <div class="data-value">

                  <?= htmlspecialchars(
                     $peserta['gender']
                  ) ?>

               </div>

            </div>


            <div class="data-row">

               <div class="data-label">

                  Status Akun

               </div>

               <div class="data-value">

                  <?= htmlspecialchars(
                     $peserta['account_status']
                  ) ?>

               </div>

            </div>


         <?php else: ?>


            <div class="status-invalid">

               ✕ QR CODE TIDAK VALID

            </div>


            <p style="text-align:center;color:#777">

               <?= htmlspecialchars($error) ?>

            </p>


         <?php endif; ?>


      </div>


      <div class="footer">

         Sistem Verifikasi Peserta PMB<br>

         STIH Graha Kirana

      </div>


   </div>


</body>

</html>