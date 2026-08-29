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

$errorMessage = '';


/**
 * =========================================================
 * FILTER
 * =========================================================
 */

$search =
   trim(
      $_GET['search'] ?? ''
   );


/**
 * =========================================================
 * WHERE
 * =========================================================
 */

$where = [];

$params = [];


/**
 * =========================================================
 * HANYA MAHASISWA
 * =========================================================
 */

$where[] = "

   status_pendaftaran = 'MAHASISWA'

";


/**
 * =========================================================
 * SEARCH
 * =========================================================
 */

if (
   $search !== ''
) {

   $where[] = "

      (

         fullname LIKE :search

         OR register_uid LIKE :search

         OR nim LIKE :search

         OR number_id LIKE :search

         OR email_register LIKE :search

         OR phone_number LIKE :search

      )

   ";


   $params['search'] =
      '%'
      .
      $search
      .
      '%';
}


$whereSql =
   'WHERE '
   .
   implode(
      ' AND ',
      $where
   );


/**
 * =========================================================
 * GET DATA MAHASISWA
 * =========================================================
 */

$mahasiswa = [];


try {

   $stmt =
      $pdo->prepare("

         SELECT

            id,

            register_uid,

            fullname,

            number_id,

            nim,

            phone_number,

            email_register,

            register_type,

            id_program,

            jenis_pembiayaan,

            tahap_aktif,

            status_pendaftaran,

            status_kelulusan,

            status_daftar_ulang,

            siakad_status,

            created_at,

            updated_at

         FROM register_pmb

         $whereSql

         ORDER BY

            fullname ASC

      ");


   $stmt->execute(
      $params
   );


   $mahasiswa =
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
 * STATISTICS
 * =========================================================
 */

$totalMahasiswa = 0;

$totalSiakadAktif = 0;

$totalSiakadBelumAktif = 0;


try {


   /**
    * =====================================================
    * TOTAL MAHASISWA
    * =====================================================
    */

   $totalMahasiswa =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE
               status_pendaftaran = 'MAHASISWA'

         ")
         ->fetchColumn();



   /**
    * =====================================================
    * SIAKAD AKTIF
    * =====================================================
    */

   $totalSiakadAktif =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE

               status_pendaftaran = 'MAHASISWA'

               AND

               UPPER(
                  COALESCE(
                     siakad_status,
                     ''
                  )
               ) = 'AKTIF'

         ")
         ->fetchColumn();



   /**
    * =====================================================
    * BELUM AKTIF
    * =====================================================
    */

   $totalSiakadBelumAktif =
      (int) $pdo
         ->query("

            SELECT COUNT(*)

            FROM register_pmb

            WHERE

               status_pendaftaran = 'MAHASISWA'

               AND

               (
                  siakad_status IS NULL

                  OR

                  UPPER(
                     siakad_status
                  ) <> 'AKTIF'

               )

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
   'KTM Mahasiswa';

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


   <!-- =====================================================
        CSS
   ====================================================== -->

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
      /* =====================================================
         BODY
      ===================================================== */

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



      /* =====================================================
         MAIN
      ===================================================== */

      .admin-main {

         margin-left: 260px;

         min-height: 100vh;

      }



      /* =====================================================
         TOPBAR
      ===================================================== */

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



      /* =====================================================
         CONTENT
      ===================================================== */

      .admin-content {

         padding: 35px;

      }



      /* =====================================================
         AVATAR
      ===================================================== */

      .admin-avatar {

         width: 40px;

         height: 40px;

         border-radius: 50%;

         background: #eaf2ff;

         color: #0d6efd;

         display: flex;

         align-items: center;

         justify-content: center;

         font-weight: 800;

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
         SEARCH
      ===================================================== */

      .search-wrapper {

         position: relative;

      }


      .search-wrapper i {

         position: absolute;

         left: 14px;

         top: 50%;

         transform:
            translateY(-50%);

         color: #9299a3;

         z-index: 2;

      }


      .search-input {

         height: 44px;

         border:
            1px solid #e1e5ea;

         border-radius: 9px;

         padding-left: 40px;

         font-size: 13px;

      }



      /* =====================================================
         TABLE
      ===================================================== */

      .data-table {

         margin: 0;

      }


      .data-table thead th {

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


      .data-table tbody td {

         padding:
            15px;

         border-color: #f0f2f5;

         font-size: 12px;

         vertical-align: middle;

      }


      .student-name {

         font-weight: 700;

         color: #30363d;

      }


      .student-meta {

         color: #9299a3;

         font-size: 10px;

         margin-top: 3px;

      }


      .npm-value {

         color: #0d6efd;

         font-size: 14px;

         font-weight: 800;

         letter-spacing: .3px;

      }



      /* =====================================================
         ACTION
      ===================================================== */

      .action-group {

         display: flex;

         align-items: center;

         justify-content: center;

         gap: 6px;

      }


      .btn-action {

         width: 34px;

         height: 34px;

         display: inline-flex;

         align-items: center;

         justify-content: center;

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


   <!-- =====================================================
        SIDEBAR
   ====================================================== -->

   <?php

   require 'sidebar.php';

   ?>


   <!-- =====================================================
        MAIN
   ====================================================== -->

   <main class="admin-main">


      <!-- ==================================================
           TOPBAR
      =================================================== -->

      <header class="admin-topbar">


         <div>


            <h1 class="admin-page-title">

               KTM Mahasiswa

            </h1>


            <div class="admin-page-subtitle">

               Daftar mahasiswa dan pengelolaan Kartu Tanda Mahasiswa

            </div>


         </div>


         <div
            class="d-flex align-items-center gap-3">


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



      <!-- ==================================================
           CONTENT
      =================================================== -->

      <div class="admin-content">


         <!-- ================================================
              ERROR
         ================================================= -->

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



         <!-- ================================================
              STATISTICS
         ================================================= -->

         <div
            class="row g-4 mb-5">


            <!-- TOTAL MAHASISWA -->

            <div
               class="col-6 col-xl-4">


               <div
                  class="stat-card">


                  <div
                     class="
                        stat-icon
                        bg-soft-primary
                        text-primary
                     ">


                     <i
                        class="uil uil-users-alt">
                     </i>


                  </div>


                  <div class="stat-label">

                     Total Mahasiswa

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalMahasiswa
                     ) ?>

                  </div>


               </div>


            </div>



            <!-- SIAKAD AKTIF -->

            <div
               class="col-6 col-xl-4">


               <div
                  class="stat-card">


                  <div
                     class="
                        stat-icon
                        bg-soft-green
                        text-green
                     ">


                     <i
                        class="uil uil-check-circle">
                     </i>


                  </div>


                  <div class="stat-label">

                     SIAKAD Aktif

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalSiakadAktif
                     ) ?>

                  </div>


               </div>


            </div>



            <!-- BELUM AKTIF -->

            <div
               class="col-6 col-xl-4">


               <div
                  class="stat-card">


                  <div
                     class="
                        stat-icon
                        bg-soft-yellow
                        text-yellow
                     ">


                     <i
                        class="uil uil-clock">
                     </i>


                  </div>


                  <div class="stat-label">

                     Belum Aktivasi SIAKAD

                  </div>


                  <div class="stat-value">

                     <?= number_format(
                        $totalSiakadBelumAktif
                     ) ?>

                  </div>


               </div>


            </div>


         </div>



         <!-- ================================================
              INFO
         ================================================= -->

         <div
            class="alert alert-primary alert-icon mb-5">


            <i
               class="uil uil-info-circle">
            </i>


            <div>


               <strong>

                  Kartu Tanda Mahasiswa

               </strong>


               <div
                  class="mt-1 fs-13">


                  Halaman ini menampilkan seluruh peserta PMB
                  yang telah resmi berstatus
                  <strong>MAHASISWA</strong>.

                  Data mahasiswa dapat digunakan untuk melihat
                  informasi akademik dan mencetak
                  <strong>Kartu Tanda Mahasiswa (KTM)</strong>.


               </div>


            </div>


         </div>



         <!-- ================================================
              DATA CARD
         ================================================= -->

         <div
            class="data-card">


            <!-- =============================================
                 HEADER
            ============================================== -->

            <div
               class="data-card-header">


               <div
                  class="
                     d-flex
                     justify-content-between
                     align-items-center
                     mb-4
                  ">


                  <div>


                     <h4
                        class="mb-1"
                        style="
                           font-size:17px;
                           font-weight:800;
                        ">


                        Daftar Mahasiswa


                     </h4>


                     <p
                        class="
                           text-muted
                           mb-0
                           fs-12
                        ">


                        Kelola data dan Kartu Tanda Mahasiswa.


                     </p>


                  </div>


                  <a
                     href="./ktm-mahasiswa.php"
                     class="
                        btn
                        btn-sm
                        btn-outline-secondary
                        rounded
                     ">


                     <i
                        class="
                           uil
                           uil-refresh
                           me-1
                        ">
                     </i>


                     Refresh


                  </a>


               </div>



               <!-- ==========================================
                    SEARCH
               =========================================== -->

               <form
                  method="GET"
                  action="./ktm-mahasiswa.php">


                  <div
                     class="row g-3">


                     <div
                        class="col-lg-10">


                        <div
                           class="search-wrapper">


                           <i
                              class="uil uil-search">
                           </i>


                           <input
                              type="text"
                              name="search"
                              value="<?= h(
                                          $search
                                       ) ?>"
                              class="
                                 form-control
                                 search-input
                              "
                              placeholder="
                                 Cari nama, NPM, UID, NIK, email atau nomor HP...
                              ">


                        </div>


                     </div>



                     <div
                        class="col-lg-2">


                        <button
                           type="submit"
                           class="
                              btn
                              btn-primary
                              rounded
                              w-100
                           "
                           style="
                              height:44px;
                           ">


                           <i
                              class="
                                 uil
                                 uil-search
                                 me-1
                              ">
                           </i>


                           Cari


                        </button>


                     </div>


                  </div>


               </form>


            </div>



            <!-- =============================================
                 TABLE
            ============================================== -->

            <div
               class="table-responsive">


               <table
                  class="
                     table
                     data-table
                  ">


                  <thead>


                     <tr>


                        <th>

                           #

                        </th>


                        <th>

                           Mahasiswa

                        </th>


                        <th>

                           NPM

                        </th>


                        <th>

                           Program

                        </th>


                        <th>

                           Kontak

                        </th>


                        <th>

                           Status SIAKAD

                        </th>


                        <th
                           class="text-center">

                           KTM

                        </th>


                        <th
                           class="text-center">

                           Aksi

                        </th>


                     </tr>


                  </thead>



                  <tbody>


                     <?php if (
                        empty($mahasiswa)
                     ): ?>


                        <tr>


                           <td
                              colspan="8"
                              class="
                                 text-center
                                 py-6
                              ">


                              <div
                                 class="text-muted">


                                 <i
                                    class="
                                       uil
                                       uil-graduation-cap
                                    "
                                    style="
                                       font-size:42px;
                                       opacity:.35;
                                    ">
                                 </i>


                                 <div
                                    class="mt-2">


                                    Belum ada data mahasiswa.


                                 </div>


                              </div>


                           </td>


                        </tr>


                     <?php else: ?>


                        <?php

                        $no = 1;

                        ?>


                        <?php foreach (
                           $mahasiswa
                           as $row
                        ): ?>


                           <?php


                           /**
                            * ==================================
                            * STATUS SIAKAD
                            * ==================================
                            */

                           $siakadStatus =
                              strtoupper(
                                 trim(
                                    $row['siakad_status']
                                       ?? ''
                                 )
                              );


                           if (
                              $siakadStatus === 'AKTIF'
                           ) {

                              $siakadColor =
                                 'success';

                              $siakadLabel =
                                 'Aktif';
                           } else {

                              $siakadColor =
                                 'warning';

                              $siakadLabel =
                                 'Belum Aktif';
                           }


                           ?>


                           <tr>


                              <!-- NO -->

                              <td>

                                 <?= $no++ ?>

                              </td>



                              <!-- MAHASISWA -->

                              <td>


                                 <div
                                    class="student-name">


                                    <?= h(
                                       $row['fullname']
                                    ) ?>


                                 </div>


                                 <div
                                    class="student-meta">


                                    UID:

                                    <?= h(

                                       $row['register_uid']
                                          ?: '-'

                                    ) ?>


                                 </div>


                                 <div
                                    class="student-meta">


                                    NIK:

                                    <?= h(

                                       $row['number_id']
                                          ?: '-'

                                    ) ?>


                                 </div>


                              </td>



                              <!-- NPM -->

                              <td>


                                 <div
                                    class="npm-value">


                                    <?= h(

                                       $row['nim']
                                          ?: '-'

                                    ) ?>


                                 </div>


                                 <div
                                    class="student-meta">


                                    Tahap

                                    <?= (int)

                                    $row['tahap_aktif']

                                    ?>


                                 </div>


                              </td>



                              <!-- PROGRAM -->

                              <td>


                                 <div
                                    class="student-name">


                                    Program

                                    #<?= (int)

                                       $row['id_program']

                                       ?>


                                 </div>


                                 <div
                                    class="student-meta">


                                    <?= h(

                                       $row['register_type']
                                          ?: '-'

                                    ) ?>


                                 </div>


                              </td>



                              <!-- KONTAK -->

                              <td>


                                 <div
                                    class="student-name"
                                    style="
                                       font-size:12px;
                                    ">


                                    <?= h(

                                       $row['phone_number']
                                          ?: '-'

                                    ) ?>


                                 </div>


                                 <div
                                    class="student-meta">


                                    <?= h(

                                       $row['email_register']
                                          ?: '-'

                                    ) ?>


                                 </div>


                              </td>



                              <!-- SIAKAD -->

                              <td>


                                 <span
                                    class="
                                       badge
                                       bg-soft-<?= h(
                                                   $siakadColor
                                                ) ?>
                                       text-<?= h(
                                                $siakadColor
                                             ) ?>
                                    ">


                                    <i
                                       class="
                                          uil
                                          <?= $siakadStatus === 'AKTIF'

                                             ? 'uil-check-circle'

                                             : 'uil-clock'

                                          ?>
                                          me-1
                                       ">
                                    </i>


                                    <?= h(
                                       $siakadLabel
                                    ) ?>


                                 </span>


                              </td>



                              <!-- KTM -->

                              <td
                                 class="text-center">


                                 <span
                                    class="
                                       badge
                                       bg-soft-success
                                       text-success
                                    ">


                                    <i
                                       class="
                                          uil
                                          uil-credit-card
                                          me-1
                                       ">
                                    </i>


                                    Tersedia


                                 </span>


                              </td>



                              <!-- ACTION -->

                              <td
                                 class="text-center">


                                 <div
                                    class="
                                       action-group
                                    ">


                                    <!-- DETAIL -->

                                    <a
                                       href="./peserta-detail.php?id=<?= (int)

                                                                     $row['id']

                                                                     ?>"
                                       class="
                                          btn
                                          btn-sm
                                          btn-soft-primary
                                          rounded
                                          btn-action
                                       "
                                       title="
                                          Lihat Detail Mahasiswa
                                       ">


                                       <i
                                          class="
                                             uil
                                             uil-eye
                                          ">
                                       </i>


                                    </a>



                                    <!-- KTM -->

                                    <a
                                       href="./ktm-cetak.php?id=<?= (int)

                                                                  $row['id']

                                                                  ?>"
                                       class="
                                          btn
                                          btn-sm
                                          btn-primary
                                          rounded
                                          btn-action
                                       "
                                       title="
                                          Lihat / Cetak KTM
                                       ">


                                       <i
                                          class="
                                             uil
                                             uil-credit-card
                                          ">
                                       </i>


                                    </a>


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


</body>

</html>