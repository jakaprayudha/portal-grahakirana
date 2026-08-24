<?php

/**
 * =========================================================
 * ADMIN SIDEBAR
 * Active menu otomatis berdasarkan halaman saat ini
 * =========================================================
 */


/**
 * =========================================================
 * CURRENT PAGE
 * =========================================================
 */

$currentPath = parse_url(
   $_SERVER['REQUEST_URI'] ?? '',
   PHP_URL_PATH
);


/**
 * Ambil nama file / route terakhir
 *
 * Contoh:
 *
 * /admin/dashboard
 *      -> dashboard
 *
 * /admin/peserta
 *      -> peserta
 *
 * /admin/pmb-jadwal-seleksi.php
 *      -> pmb-jadwal-seleksi
 */

$currentPage = basename(
   $currentPath
);

$currentPage = preg_replace(
   '/\.php$/',
   '',
   $currentPage
);


/**
 * =========================================================
 * HELPER ACTIVE
 * =========================================================
 */

function isAdminActive(
   string $page,
   string $currentPage
): string {

   return $page === $currentPage
      ? 'active'
      : '';
}


/**
 * =========================================================
 * ADMIN DATA
 * =========================================================
 */

$adminName =
   $adminName
   ?? $_SESSION['admin_fullname']
   ?? $_SESSION['admin_username']
   ?? 'Administrator';


$adminRole =
   $adminRole
   ?? $_SESSION['admin_roles']
   ?? 'admin';

?>



<aside class="admin-sidebar">


   <!-- =====================================================
        BRAND
   ====================================================== -->

   <div class="admin-brand">


      <div class="admin-brand-icon">

         <i class="uil uil-shield-check"></i>

      </div>


      <div>

         <div class="admin-brand-name">

            ADMIN PMB

         </div>


         <div class="admin-brand-sub">

            Portal Administrasi

         </div>

      </div>


   </div>



   <!-- =====================================================
        NAVIGATION
   ====================================================== -->

   <nav class="admin-nav">


      <!-- MENU UTAMA -->

      <div class="admin-nav-label">

         Menu Utama

      </div>



      <!-- DASHBOARD -->

      <a
         href="./dashboard"
         class="admin-nav-link <?= isAdminActive(
                                    'dashboard',
                                    $currentPage
                                 ) ?>">

         <i class="uil uil-dashboard"></i>

         Dashboard

      </a>



      <!-- PESERTA -->

      <a
         href="./peserta"
         class="admin-nav-link <?= isAdminActive(
                                    'peserta',
                                    $currentPage
                                 ) ?>">

         <i class="uil uil-users-alt"></i>

         Data Peserta

      </a>



      <!-- SELEKSI -->

      <a
         href="./seleksi"
         class="admin-nav-link <?= isAdminActive(
                                    'seleksi',
                                    $currentPage
                                 ) ?>">

         <i class="uil uil-clipboard-alt"></i>

         Seleksi

      </a>



      <!-- HASIL SELEKSI -->

      <a
         href="./hasil-seleksi"
         class="admin-nav-link <?= isAdminActive(
                                    'hasil-seleksi',
                                    $currentPage
                                 ) ?>">

         <i class="uil uil-award"></i>

         Hasil Seleksi

      </a>



      <!-- DAFTAR ULANG -->

      <a
         href="./daftar-ulang"
         class="admin-nav-link <?= isAdminActive(
                                    'daftar-ulang',
                                    $currentPage
                                 ) ?>">

         <i class="uil uil-user-check"></i>

         Daftar Ulang

      </a>



      <!-- =================================================
           AKADEMIK
      ================================================== -->

      <div class="admin-nav-label mt-5">

         Akademik

      </div>



      <!-- JADWAL SELEKSI -->

      <a
         href="./pmb-jadwal-seleksi"
         class="admin-nav-link <?= isAdminActive(
                                    'pmb-jadwal-seleksi',
                                    $currentPage
                                 ) ?>">

         <i class="uil uil-calendar-alt"></i>

         Jadwal Seleksi

      </a>



      <!-- MAHASISWA -->

      <a
         href="./mahasiswa"
         class="admin-nav-link <?= isAdminActive(
                                    'mahasiswa',
                                    $currentPage
                                 ) ?>">

         <i class="uil uil-graduation-cap"></i>

         Mahasiswa

      </a>



      <!-- KTM -->

      <a
         href="./ktm"
         class="admin-nav-link <?= isAdminActive(
                                    'ktm',
                                    $currentPage
                                 ) ?>">

         <i class="uil uil-card-atm"></i>

         KTM

      </a>



      <!-- KRS -->

      <a
         href="./krs"
         class="admin-nav-link <?= isAdminActive(
                                    'krs',
                                    $currentPage
                                 ) ?>">

         <i class="uil uil-book-open"></i>

         KRS

      </a>



   </nav>



   <!-- =====================================================
        USER
   ====================================================== -->

   <div class="admin-sidebar-footer">


      <div class="admin-user-mini">


         <!-- AVATAR -->

         <div class="admin-avatar">

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



         <!-- USER INFO -->

         <div>

            <div class="admin-user-name">

               <?= h(
                  $adminName
               ) ?>

            </div>


            <div class="admin-user-role">

               <?= h(
                  $adminRole
               ) ?>

            </div>

         </div>


      </div>



      <!-- LOGOUT -->

      <a
         href="../controllers/admin/logout.php"
         class="btn btn-outline-danger btn-sm rounded admin-logout">

         <i class="uil uil-sign-out-alt"></i>

         Keluar

      </a>


   </div>



</aside>