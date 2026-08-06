<!DOCTYPE html>
<html lang="en">

<?php
$page = "Home";
require 'head.php';
?>
<style>
   .org-highlight {

      display: flex;

      align-items: center;

      gap: 18px;

      background: #fff;

      padding: 20px;

      border-radius: 20px;

      height: 100%;

      box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

      transition: .35s;

   }

   .org-highlight:hover {

      transform: translateY(-6px);

      box-shadow: 0 20px 40px rgba(106, 61, 168, .15);

   }

   .org-icon {

      width: 68px;

      height: 68px;

      border-radius: 18px;

      background: #F4EEFD;

      display: flex;

      align-items: center;

      justify-content: center;

      font-size: 30px;

      transition: .35s;

      flex-shrink: 0;

   }

   .org-highlight:hover .org-icon {

      background: #6A3DA8;

      color: #fff;

      transform: rotate(8deg);

   }

   .org-highlight h5 {

      margin-bottom: 5px;

   }

   .org-highlight small {

      color: #666;

   }

   .organization-card {

      background: #fff;

      padding: 35px 25px;

      border-radius: 24px;

      height: 100%;

      text-align: center;

      border: 1px solid #ECECEC;

      box-shadow: 0 15px 35px rgba(0, 0, 0, .05);

      transition: .35s;

      position: relative;

      overflow: hidden;

   }

   .organization-card::before {

      content: "";

      position: absolute;

      left: 0;

      top: 0;

      width: 100%;

      height: 5px;

      background: #6A3DA8;

      transform: scaleX(0);

      transition: .35s;

   }

   .organization-card:hover::before {

      transform: scaleX(1);

   }

   .organization-card:hover {

      transform: translateY(-10px);

      box-shadow: 0 25px 50px rgba(106, 61, 168, .18);

   }

   .organization-icon {

      width: 90px;

      height: 90px;

      margin: auto;

      margin-bottom: 25px;

      background: #F4EEFD;

      border-radius: 24px;

      display: flex;

      align-items: center;

      justify-content: center;

      font-size: 42px;

      transition: .35s;

   }

   .organization-card:hover .organization-icon {

      background: #6A3DA8;

      color: #fff;

      transform: rotate(10deg);

   }

   .organization-card h4 {

      margin-bottom: 10px;

      color: #222;

   }

   .organization-card p {

      color: #666;

      min-height: 48px;

      margin-bottom: 25px;

   }

   .organization-link {

      font-weight: 600;

      color: #6A3DA8;

      display: flex;

      justify-content: center;

      align-items: center;

      gap: 8px;

   }

   .organization-card:hover .organization-link {

      gap: 14px;

   }

   .program-timeline {

      display: flex;

      align-items: flex-start;

      overflow-x: auto;

      gap: 0;

      padding: 20px 0;

   }

   .program-item {

      min-width: 220px;

      text-align: center;

      position: relative;

   }

   .program-month {

      display: inline-block;

      padding: 8px 18px;

      background: #fff;

      color: #6A3DA8;

      border-radius: 50px;

      font-weight: 700;

      margin-bottom: 20px;

   }

   .program-circle {

      width: 90px;

      height: 90px;

      margin: auto;

      margin-bottom: 20px;

      border-radius: 50%;

      background: #fff;

      display: flex;

      align-items: center;

      justify-content: center;

      font-size: 40px;

      box-shadow: 0 15px 35px rgba(0, 0, 0, .15);

      transition: .35s;

   }

   .program-item:hover .program-circle {

      transform: translateY(-10px) rotate(8deg);

   }

   .program-item h5 {

      color: #fff;

      margin-bottom: 10px;

   }

   .program-item p {

      color: rgba(255, 255, 255, .8);

      font-size: 14px;

      padding: 0 10px;

   }

   .program-line {

      width: 100px;

      height: 5px;

      background: rgba(255, 255, 255, .4);

      margin-top: 95px;

      border-radius: 50px;

      flex-shrink: 0;

   }

   @media(max-width:992px) {

      .program-timeline {

         justify-content: flex-start;

      }

   }

   .achievement-card {

      background: #fff;

      padding: 35px;

      border-radius: 24px;

      text-align: center;

      height: 100%;

      box-shadow: 0 15px 35px rgba(0, 0, 0, .06);

      transition: .35s;

   }

   .achievement-card:hover {

      transform: translateY(-8px);

      box-shadow: 0 25px 50px rgba(106, 61, 168, .18);

   }

   .achievement-icon {

      width: 85px;

      height: 85px;

      margin: auto;

      margin-bottom: 20px;

      background: #F4EEFD;

      border-radius: 22px;

      display: flex;

      align-items: center;

      justify-content: center;

      font-size: 42px;

      transition: .35s;

   }

   .achievement-card:hover .achievement-icon {

      background: #6A3DA8;

      color: #fff;

      transform: rotate(10deg);

   }

   .achievement-card p {

      margin: 0;

      color: #666;

   }

   .highlight-card {

      background: #fff;

      border-radius: 22px;

      overflow: hidden;

      box-shadow: 0 15px 35px rgba(0, 0, 0, .06);

      transition: .35s;

      height: 100%;

   }

   .highlight-card:hover {

      transform: translateY(-8px);

   }

   .highlight-card img {

      width: 100%;

      height: 240px;

      object-fit: cover;

   }

   .highlight-body {

      padding: 25px;

   }

   .highlight-body h4 {

      margin: 12px 0;

   }

   .highlight-body p {

      color: #666;

      margin: 0;

   }

   .activity-gallery {

      position: relative;

      overflow: hidden;

      border-radius: 22px;

      cursor: pointer;

      box-shadow: 0 15px 35px rgba(0, 0, 0, .08);

   }

   .activity-gallery img {

      width: 100%;

      height: 300px;

      object-fit: cover;

      transition: .5s;

   }

   .activity-gallery:hover img {

      transform: scale(1.08);

   }

   .activity-overlay {

      position: absolute;

      left: 0;

      right: 0;

      bottom: 0;

      padding: 30px;

      background: linear-gradient(to top,
            rgba(0, 0, 0, .85),
            rgba(0, 0, 0, .2),
            transparent);

      color: #fff;

      opacity: 0;

      transition: .35s;

   }

   .activity-gallery:hover .activity-overlay {

      opacity: 1;

   }

   .activity-overlay h4 {

      margin: 15px 0 8px;

      color: #fff;

   }

   .activity-overlay small {

      opacity: .85;

   }

   .testimonial-org {

      background: #fff;

      padding: 35px;

      border-radius: 24px;

      height: 100%;

      box-shadow: 0 15px 35px rgba(0, 0, 0, .08);

      transition: .35s;

      position: relative;

   }

   .testimonial-org:hover {

      transform: translateY(-10px);

      box-shadow: 0 25px 50px rgba(106, 61, 168, .18);

   }

   .quote-icon {

      width: 70px;

      height: 70px;

      border-radius: 18px;

      background: #F4EEFD;

      display: flex;

      align-items: center;

      justify-content: center;

      font-size: 32px;

      color: #6A3DA8;

      margin-bottom: 25px;

   }

   .testimonial-org p {

      font-style: italic;

      line-height: 1.8;

      color: #555;

      margin-bottom: 30px;

      min-height: 140px;

   }

   .testimonial-footer {

      display: flex;

      align-items: center;

      gap: 15px;

   }

   .testimonial-footer img {

      width: 60px;

      height: 60px;

      object-fit: cover;

   }

   .testimonial-footer h5 {

      margin-bottom: 3px;

   }

   .testimonial-footer small {

      color: #777;

   }

   .recruitment-card {

      background: #fff;

      padding: 35px;

      border-radius: 24px;

      box-shadow: 0 18px 40px rgba(0, 0, 0, .08);

      position: sticky;

      top: 110px;

   }

   .recruitment-icon {

      width: 90px;

      height: 90px;

      margin: auto;

      margin-bottom: 25px;

      border-radius: 50%;

      background: #F3EEFD;

      display: flex;

      align-items: center;

      justify-content: center;

      font-size: 42px;

   }

   .recruitment-card h3 {

      text-align: center;

      margin-bottom: 15px;

   }

   .recruitment-card p {

      text-align: center;

      color: #666;

   }

   .recruit-info {

      padding: 15px;

      background: #F8F8F8;

      border-radius: 15px;

      line-height: 1.7;

   }
</style>

<body>
   <div class="content-wrapper">
      <?php
      require 'navbar.php';
      ?>
      <section class="wrapper bg-light">
         <div class="container py-15 py-md-17">

            <div class="row align-items-center gy-8">

               <!-- LEFT -->

               <div class="col-lg-6">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

                     Student Organization

                  </span>

                  <h2 class="display-4 mb-4">

                     Organisasi Kemahasiswaan
                     STIH Graha Kirana

                  </h2>

                  <p class="lead mb-5">

                     Organisasi kemahasiswaan merupakan wadah bagi mahasiswa
                     untuk mengembangkan jiwa kepemimpinan, kemampuan
                     berorganisasi, komunikasi, serta membangun jejaring
                     profesional di luar kegiatan akademik.

                  </p>

                  <div class="row g-4">

                     <div class="col-md-6">

                        <div class="org-highlight">

                           <div class="org-icon">

                              👨‍💼

                           </div>

                           <div>

                              <h5 class="mb-1">

                                 Leadership

                              </h5>

                              <small>

                                 Membangun jiwa kepemimpinan.

                              </small>

                           </div>

                        </div>

                     </div>

                     <div class="col-md-6">

                        <div class="org-highlight">

                           <div class="org-icon">

                              🤝

                           </div>

                           <div>

                              <h5 class="mb-1">

                                 Teamwork

                              </h5>

                              <small>

                                 Kolaborasi dan kerja sama tim.

                              </small>

                           </div>

                        </div>

                     </div>

                     <div class="col-md-6">

                        <div class="org-highlight">

                           <div class="org-icon">

                              🎤

                           </div>

                           <div>

                              <h5 class="mb-1">

                                 Public Speaking

                              </h5>

                              <small>

                                 Melatih komunikasi yang efektif.

                              </small>

                           </div>

                        </div>

                     </div>

                     <div class="col-md-6">

                        <div class="org-highlight">

                           <div class="org-icon">

                              🌎

                           </div>

                           <div>

                              <h5 class="mb-1">

                                 Networking

                              </h5>

                              <small>

                                 Memperluas relasi profesional.

                              </small>

                           </div>

                        </div>

                     </div>

                  </div>

                  <div class="mt-5">

                     <a href="#organisasi"
                        class="btn btn-primary rounded-pill me-3">

                        Lihat Organisasi

                     </a>

                     <a href="contact.php"
                        class="btn btn-outline-primary rounded-pill">

                        Hubungi Kami

                     </a>

                  </div>

               </div>

               <!-- RIGHT -->

               <div class="col-lg-6">

                  <img src="./assets/img/organisasi-mahasiswa.png"
                     class="img-fluid rounded-4 shadow-lg"
                     alt="Organisasi Mahasiswa">

               </div>

            </div>

         </div>
      </section>
      <section class="wrapper bg-white" id="organisasi">
         <div class="container py-15 py-md-17">

            <!-- Heading -->

            <div class="row text-center mb-10">

               <div class="col-lg-8 mx-auto">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

                     Student Organizations

                  </span>

                  <h2 class="display-5 mb-3">

                     Organisasi Mahasiswa

                  </h2>

                  <p class="lead">

                     Berbagai organisasi mahasiswa menjadi wadah untuk
                     mengembangkan potensi, kreativitas, kepemimpinan,
                     dan semangat kolaborasi di lingkungan kampus.

                  </p>

               </div>

            </div>

            <div class="row g-4">

               <?php

               $organisasi = [

                  [
                     "🏛️",
                     "BEM",
                     "Badan Eksekutif Mahasiswa",
                     "#"
                  ],

                  [
                     "⚖️",
                     "HIMAHI",
                     "Himpunan Mahasiswa Hukum",
                     "#"
                  ],

                  [
                     "📚",
                     "Kelompok Studi",
                     "Forum Kajian & Diskusi Hukum",
                     "#"
                  ],

                  [
                     "🎭",
                     "UKM Seni",
                     "Seni Musik, Tari & Teater",
                     "#"
                  ],

                  [
                     "🏸",
                     "UKM Olahraga",
                     "Futsal, Badminton & Voli",
                     "#"
                  ],

                  [
                     "🌱",
                     "Mapala",
                     "Pecinta Alam & Lingkungan",
                     "#"
                  ],

                  [
                     "❤️",
                     "PMR",
                     "Palang Merah Remaja",
                     "#"
                  ],

                  [
                     "💻",
                     "Komunitas Digital",
                     "Teknologi & Multimedia",
                     "#"
                  ]

               ];

               foreach ($organisasi as $o) {

               ?>

                  <div class="col-md-6 col-xl-3">

                     <a href="<?= $o[3] ?>" class="text-decoration-none">

                        <div class="organization-card">

                           <div class="organization-icon">

                              <?= $o[0] ?>

                           </div>

                           <h4>

                              <?= $o[1] ?>

                           </h4>

                           <p>

                              <?= $o[2] ?>

                           </p>

                           <div class="organization-link">

                              Selengkapnya
                              <i class="uil uil-arrow-right"></i>

                           </div>

                        </div>

                     </a>

                  </div>

               <?php } ?>

            </div>

         </div>
      </section>
      <section class="wrapper bg-light">
         <div class="container py-15 py-md-17">

            <!-- Heading -->

            <div class="row text-center mb-12">

               <div class="col-lg-8 mx-auto">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
                     Organization Profile
                  </span>

                  <h2 class="display-5 mb-3">
                     Organisasi Unggulan Mahasiswa
                  </h2>

                  <p class="lead">
                     Setiap organisasi memiliki fokus kegiatan yang berbeda untuk
                     mendukung pengembangan akademik, kepemimpinan, kreativitas,
                     dan pengabdian kepada masyarakat.
                  </p>

               </div>

            </div>

            <!-- BEM -->

            <div class="row align-items-center gy-6 mb-15">

               <div class="col-lg-5">

                  <img src="./assets/img/bem.png"
                     class="img-fluid rounded-4 shadow-lg"
                     alt="BEM">

               </div>

               <div class="col-lg-7">

                  <span class="badge bg-soft-primary text-primary mb-3">
                     Badan Eksekutif Mahasiswa
                  </span>

                  <h3 class="mb-3">
                     🏛️ BEM STIH Graha Kirana
                  </h3>

                  <p class="mb-4">
                     Badan Eksekutif Mahasiswa merupakan organisasi yang
                     menjadi representasi mahasiswa dalam menjalankan
                     berbagai program akademik, sosial, kepemimpinan,
                     dan pengabdian kepada masyarakat.
                  </p>

                  <div class="row">

                     <div class="col-md-6">

                        <ul class="icon-list bullet-bg bullet-soft-primary">

                           <li><span><i class="uil uil-check"></i></span>Leadership Training</li>
                           <li><span><i class="uil uil-check"></i></span>Seminar Nasional</li>
                           <li><span><i class="uil uil-check"></i></span>Bakti Sosial</li>

                        </ul>

                     </div>

                     <div class="col-md-6">

                        <ul class="icon-list bullet-bg bullet-soft-primary">

                           <li><span><i class="uil uil-check"></i></span>Legal Campaign</li>
                           <li><span><i class="uil uil-check"></i></span>Student Advocacy</li>
                           <li><span><i class="uil uil-check"></i></span>Campus Event</li>

                        </ul>

                     </div>

                  </div>

               </div>

            </div>

            <!-- HIMAHI -->

            <div class="row align-items-center gy-6 flex-lg-row-reverse mb-15">

               <div class="col-lg-5">

                  <img src="./assets/img/himahi.png"
                     class="img-fluid rounded-4 shadow-lg"
                     alt="HIMAHI">

               </div>

               <div class="col-lg-7">

                  <span class="badge bg-soft-success text-success mb-3">
                     Himpunan Mahasiswa Hukum
                  </span>

                  <h3 class="mb-3">
                     ⚖️ HIMAHI
                  </h3>

                  <p class="mb-4">
                     HIMAHI menjadi wadah pengembangan keilmuan hukum melalui
                     diskusi ilmiah, seminar, kompetisi peradilan semu,
                     penelitian, dan pengabdian kepada masyarakat.
                  </p>

                  <div class="row">

                     <div class="col-md-6">

                        <ul class="icon-list bullet-bg bullet-soft-success">

                           <li><span><i class="uil uil-check"></i></span>Moot Court</li>
                           <li><span><i class="uil uil-check"></i></span>Legal Research</li>
                           <li><span><i class="uil uil-check"></i></span>Seminar Hukum</li>

                        </ul>

                     </div>

                     <div class="col-md-6">

                        <ul class="icon-list bullet-bg bullet-soft-success">

                           <li><span><i class="uil uil-check"></i></span>Debat Hukum</li>
                           <li><span><i class="uil uil-check"></i></span>Legal Drafting</li>
                           <li><span><i class="uil uil-check"></i></span>Pengabdian Masyarakat</li>

                        </ul>

                     </div>

                  </div>

               </div>

            </div>

            <!-- UKM -->

            <div class="row align-items-center gy-6">

               <div class="col-lg-5">

                  <img src="./assets/img/ukm.png"
                     class="img-fluid rounded-4 shadow-lg"
                     alt="UKM">

               </div>

               <div class="col-lg-7">

                  <span class="badge bg-soft-warning text-warning mb-3">
                     Unit Kegiatan Mahasiswa
                  </span>

                  <h3 class="mb-3">
                     🎭 UKM Seni, Olahraga & Minat Bakat
                  </h3>

                  <p class="mb-4">
                     Berbagai Unit Kegiatan Mahasiswa menjadi wadah
                     pengembangan kreativitas, olahraga, seni, budaya,
                     serta minat dan bakat mahasiswa di luar kegiatan akademik.
                  </p>

                  <div class="row text-center g-3">

                     <div class="col-4">
                        <div class="card bg-soft-warning border-0">
                           <div class="card-body">
                              <h3>15+</h3>
                              <small>Kegiatan</small>
                           </div>
                        </div>
                     </div>

                     <div class="col-4">
                        <div class="card bg-soft-warning border-0">
                           <div class="card-body">
                              <h3>8</h3>
                              <small>Komunitas</small>
                           </div>
                        </div>
                     </div>

                     <div class="col-4">
                        <div class="card bg-soft-warning border-0">
                           <div class="card-body">
                              <h3>300+</h3>
                              <small>Anggota</small>
                           </div>
                        </div>
                     </div>

                  </div>

               </div>

            </div>

         </div>
      </section>
      <section class="wrapper bg-primary">
         <div class="container py-15 py-md-17">

            <!-- Heading -->

            <div class="row text-center mb-12">

               <div class="col-lg-8 mx-auto">

                  <span class="badge bg-white text-primary rounded-pill mb-3">
                     Annual Programs
                  </span>

                  <h2 class="display-4 text-white mb-3">
                     Program Kerja Organisasi Mahasiswa
                  </h2>

                  <p class="lead text-white">
                     Sepanjang tahun, organisasi mahasiswa menyelenggarakan
                     berbagai kegiatan akademik, kepemimpinan, kompetisi,
                     dan pengabdian kepada masyarakat.
                  </p>

               </div>

            </div>

            <!-- Timeline -->

            <div class="program-timeline">

               <!-- Item -->

               <div class="program-item">

                  <div class="program-month">

                     JAN

                  </div>

                  <div class="program-circle">

                     🎓

                  </div>

                  <h5>

                     PKKMB

                  </h5>

                  <p>

                     Pengenalan Kehidupan Kampus bagi Mahasiswa Baru.

                  </p>

               </div>

               <div class="program-line"></div>

               <div class="program-item">

                  <div class="program-month">

                     MAR

                  </div>

                  <div class="program-circle">

                     👨‍💼

                  </div>

                  <h5>

                     Leadership Camp

                  </h5>

                  <p>

                     Pelatihan kepemimpinan dan manajemen organisasi.

                  </p>

               </div>

               <div class="program-line"></div>

               <div class="program-item">

                  <div class="program-month">

                     JUN

                  </div>

                  <div class="program-circle">

                     ⚖️

                  </div>

                  <h5>

                     Seminar Nasional

                  </h5>

                  <p>

                     Seminar bersama akademisi dan praktisi hukum.

                  </p>

               </div>

               <div class="program-line"></div>

               <div class="program-item">

                  <div class="program-month">

                     AGU

                  </div>

                  <div class="program-circle">

                     🏆

                  </div>

                  <h5>

                     Legal Competition

                  </h5>

                  <p>

                     Lomba debat hukum dan Moot Court Competition.

                  </p>

               </div>

               <div class="program-line"></div>

               <div class="program-item">

                  <div class="program-month">

                     OKT

                  </div>

                  <div class="program-circle">

                     🎭

                  </div>

                  <h5>

                     Legal Festival

                  </h5>

                  <p>

                     Festival seni, olahraga, dan kreativitas mahasiswa.

                  </p>

               </div>

               <div class="program-line"></div>

               <div class="program-item">

                  <div class="program-month">

                     DES

                  </div>

                  <div class="program-circle">

                     ❤️

                  </div>

                  <h5>

                     Bakti Sosial

                  </h5>

                  <p>

                     Pengabdian masyarakat dan kegiatan sosial kemahasiswaan.

                  </p>

               </div>

            </div>

         </div>
      </section>
      <section class="wrapper bg-light">
         <div class="container py-15 py-md-17">

            <!-- Heading -->

            <div class="row text-center mb-10">

               <div class="col-lg-8 mx-auto">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

                     Student Achievements

                  </span>

                  <h2 class="display-5 mb-3">

                     Prestasi Organisasi Mahasiswa

                  </h2>

                  <p class="lead">

                     Organisasi mahasiswa aktif berkontribusi melalui berbagai
                     kompetisi, kegiatan ilmiah, pengabdian masyarakat,
                     serta kolaborasi dengan berbagai institusi.

                  </p>

               </div>

            </div>

            <!-- Counter -->

            <div class="row g-4 mb-12">

               <div class="col-6 col-lg-3">

                  <div class="achievement-card">

                     <div class="achievement-icon">
                        🏆
                     </div>

                     <h2 class="counter text-primary">
                        35+
                     </h2>

                     <p>
                        Prestasi Tingkat Nasional & Regional
                     </p>

                  </div>

               </div>

               <div class="col-6 col-lg-3">

                  <div class="achievement-card">

                     <div class="achievement-icon">
                        🥇
                     </div>

                     <h2 class="counter text-primary">
                        18
                     </h2>

                     <p>
                        Juara Kompetisi Mahasiswa
                     </p>

                  </div>

               </div>

               <div class="col-6 col-lg-3">

                  <div class="achievement-card">

                     <div class="achievement-icon">
                        👨‍🎓
                     </div>

                     <h2 class="counter text-primary">
                        8
                     </h2>

                     <p>
                        Organisasi Aktif
                     </p>

                  </div>

               </div>

               <div class="col-6 col-lg-3">

                  <div class="achievement-card">

                     <div class="achievement-icon">
                        🤝
                     </div>

                     <h2 class="counter text-primary">
                        25+
                     </h2>

                     <p>
                        Mitra Kolaborasi
                     </p>

                  </div>

               </div>

            </div>

            <!-- Highlight Prestasi -->

            <div class="row g-4">

               <div class="col-lg-4">

                  <div class="highlight-card">

                     <img src="./assets/img/prestasi1.png"
                        class="img-fluid">

                     <div class="highlight-body">

                        <span class="badge bg-soft-success text-success mb-2">

                           Nasional

                        </span>

                        <h4>

                           Juara Moot Court Competition

                        </h4>

                        <p>

                           Tim mahasiswa berhasil meraih prestasi pada
                           kompetisi Peradilan Semu tingkat nasional.

                        </p>

                     </div>

                  </div>

               </div>

               <div class="col-lg-4">

                  <div class="highlight-card">

                     <img src="./assets/img/prestasi2.png"
                        class="img-fluid">

                     <div class="highlight-body">

                        <span class="badge bg-soft-primary text-primary mb-2">

                           Seminar

                        </span>

                        <h4>

                           Seminar Hukum Nasional

                        </h4>

                        <p>

                           Menjadi penyelenggara seminar nasional
                           bersama praktisi dan akademisi hukum.

                        </p>

                     </div>

                  </div>

               </div>

               <div class="col-lg-4">

                  <div class="highlight-card">

                     <img src="./assets/img/prestasi3.png"
                        class="img-fluid">

                     <div class="highlight-body">

                        <span class="badge bg-soft-warning text-warning mb-2">

                           Pengabdian

                        </span>

                        <h4>

                           Penyuluhan Hukum Masyarakat

                        </h4>

                        <p>

                           Organisasi mahasiswa aktif melaksanakan
                           kegiatan penyuluhan hukum di masyarakat.

                        </p>

                     </div>

                  </div>

               </div>

            </div>

         </div>
      </section>
      <section class="wrapper bg-white">
         <div class="container py-15 py-md-17">

            <!-- Heading -->

            <div class="row text-center mb-10">

               <div class="col-lg-8 mx-auto">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

                     Student Activities

                  </span>

                  <h2 class="display-5 mb-3">

                     Galeri Kegiatan Organisasi

                  </h2>

                  <p class="lead">

                     Berbagai kegiatan organisasi mahasiswa yang menjadi wadah
                     pengembangan kepemimpinan, akademik, kreativitas,
                     dan pengabdian kepada masyarakat.

                  </p>

               </div>

            </div>

            <!-- Gallery -->

            <div class="row g-4">

               <div class="col-md-6 col-lg-4">

                  <div class="activity-gallery">

                     <img src="./assets/img/gallery/pkkmb.png" class="img-fluid">

                     <div class="activity-overlay">

                        <span class="badge bg-primary">

                           PKKMB

                        </span>

                        <h4>

                           Pengenalan Kehidupan Kampus

                        </h4>

                        <small>

                           BEM • 2026

                        </small>

                     </div>

                  </div>

               </div>

               <div class="col-md-6 col-lg-4">

                  <div class="activity-gallery">

                     <img src="./assets/img/gallery/seminar.png" class="img-fluid">

                     <div class="activity-overlay">

                        <span class="badge bg-success">

                           Seminar

                        </span>

                        <h4>

                           Seminar Nasional Hukum

                        </h4>

                        <small>

                           HIMAHI • 2026

                        </small>

                     </div>

                  </div>

               </div>

               <div class="col-md-6 col-lg-4">

                  <div class="activity-gallery">

                     <img src="./assets/img/gallery/mootcourt.png" class="img-fluid">

                     <div class="activity-overlay">

                        <span class="badge bg-warning">

                           Competition

                        </span>

                        <h4>

                           Moot Court Competition

                        </h4>

                        <small>

                           HIMAHI • 2026

                        </small>

                     </div>

                  </div>

               </div>

               <div class="col-md-6 col-lg-4">

                  <div class="activity-gallery">

                     <img src="./assets/img/gallery/baksos.png" class="img-fluid">

                     <div class="activity-overlay">

                        <span class="badge bg-danger">

                           Sosial

                        </span>

                        <h4>

                           Bakti Sosial

                        </h4>

                        <small>

                           BEM • 2026

                        </small>

                     </div>

                  </div>

               </div>

               <div class="col-md-6 col-lg-4">

                  <div class="activity-gallery">

                     <img src="./assets/img/gallery/festival.png" class="img-fluid">

                     <div class="activity-overlay">

                        <span class="badge bg-info">

                           Festival

                        </span>

                        <h4>

                           Festival Seni Mahasiswa

                        </h4>

                        <small>

                           UKM Seni • 2026

                        </small>

                     </div>

                  </div>

               </div>

               <div class="col-md-6 col-lg-4">

                  <div class="activity-gallery">

                     <img src="./assets/img/gallery/olahraga.png" class="img-fluid">

                     <div class="activity-overlay">

                        <span class="badge bg-dark">

                           Sport

                        </span>

                        <h4>

                           Turnamen Olahraga

                        </h4>

                        <small>

                           UKM Olahraga • 2026

                        </small>

                     </div>

                  </div>

               </div>

            </div>

         </div>
      </section>
      <section class="wrapper bg-soft-primary">
         <div class="container py-15 py-md-17">

            <!-- Heading -->

            <div class="row text-center mb-10">

               <div class="col-lg-8 mx-auto">

                  <span class="badge bg-primary text-white rounded-pill mb-3">

                     Student Stories

                  </span>

                  <h2 class="display-5 mb-3">

                     Cerita Inspiratif Mahasiswa

                  </h2>

                  <p class="lead">

                     Organisasi kemahasiswaan bukan hanya tempat berkegiatan,
                     tetapi juga ruang untuk membangun karakter,
                     kepemimpinan, dan pengalaman berharga.

                  </p>

               </div>

            </div>

            <div class="row g-4">

               <!-- Testimoni -->

               <div class="col-lg-4">

                  <div class="testimonial-org">

                     <div class="quote-icon">

                        <i class="uil uil-comment-alt-dots"></i>

                     </div>

                     <p>

                        Bergabung di BEM membuat saya belajar memimpin tim,
                        mengelola program kerja, serta membangun komunikasi
                        dengan berbagai pihak di dalam maupun luar kampus.

                     </p>

                     <div class="testimonial-footer">

                        <img src="./assets/img/student/sample.png"
                           class="rounded-circle">

                        <div>

                           <h5>

                              Ahmad Fauzi

                           </h5>

                           <small>

                              Ketua BEM 2025

                           </small>

                        </div>

                     </div>

                  </div>

               </div>

               <!-- Testimoni -->

               <div class="col-lg-4">

                  <div class="testimonial-org">

                     <div class="quote-icon">

                        <i class="uil uil-comment-alt-dots"></i>

                     </div>

                     <p>

                        HIMAHI membuka kesempatan mengikuti seminar,
                        debat hukum, hingga kompetisi Moot Court yang
                        meningkatkan kemampuan berpikir kritis saya.

                     </p>

                     <div class="testimonial-footer">

                        <img src="./assets/img/student/sample2.png"
                           class="rounded-circle">

                        <div>

                           <h5>

                              Siti Rahma

                           </h5>

                           <small>

                              Ketua HIMAHI

                           </small>

                        </div>

                     </div>

                  </div>

               </div>

               <!-- Testimoni -->

               <div class="col-lg-4">

                  <div class="testimonial-org">

                     <div class="quote-icon">

                        <i class="uil uil-comment-alt-dots"></i>

                     </div>

                     <p>

                        Melalui UKM Seni saya tidak hanya mengembangkan
                        bakat, tetapi juga belajar bekerja sama,
                        mengatur event, dan tampil percaya diri.

                     </p>

                     <div class="testimonial-footer">

                        <img src="./assets/img/student/sample3.png"
                           class="rounded-circle">

                        <div>

                           <h5>

                              Dimas Saputra

                           </h5>

                           <small>

                              Ketua UKM Seni

                           </small>

                        </div>

                     </div>

                  </div>

               </div>

            </div>

         </div>
      </section>
      <section class="wrapper bg-light">
         <div class="container py-15 py-md-17">

            <!-- Heading -->

            <div class="row text-center mb-10">

               <div class="col-lg-8 mx-auto">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

                     FAQ

                  </span>

                  <h2 class="display-5 mb-3">

                     Pertanyaan yang Sering Diajukan

                  </h2>

                  <p class="lead">

                     Temukan jawaban mengenai organisasi kemahasiswaan,
                     proses pendaftaran, serta berbagai aktivitas mahasiswa
                     di STIH Graha Kirana.

                  </p>

               </div>

            </div>

            <div class="row gy-5">

               <!-- FAQ -->

               <div class="col-lg-8">

                  <div class="accordion accordion-wrapper" id="faqOrganization">

                     <div class="card plain accordion-item">

                        <div class="card-header">

                           <button class="accordion-button"
                              data-bs-toggle="collapse"
                              data-bs-target="#faq1">

                              Apakah mahasiswa baru boleh mengikuti organisasi?

                           </button>

                        </div>

                        <div id="faq1"
                           class="accordion-collapse collapse show"
                           data-bs-parent="#faqOrganization">

                           <div class="card-body">

                              Ya. Mahasiswa baru dapat bergabung dengan organisasi
                              setelah mengikuti proses pengenalan kampus dan
                              rekrutmen yang diselenggarakan masing-masing organisasi.

                           </div>

                        </div>

                     </div>

                     <div class="card plain accordion-item">

                        <div class="card-header">

                           <button class="accordion-button collapsed"
                              data-bs-toggle="collapse"
                              data-bs-target="#faq2">

                              Apakah mahasiswa boleh mengikuti lebih dari satu organisasi?

                           </button>

                        </div>

                        <div id="faq2"
                           class="accordion-collapse collapse"
                           data-bs-parent="#faqOrganization">

                           <div class="card-body">

                              Diperbolehkan, selama mampu membagi waktu dan tetap
                              memenuhi kewajiban akademik sesuai ketentuan kampus.

                           </div>

                        </div>

                     </div>

                     <div class="card plain accordion-item">

                        <div class="card-header">

                           <button class="accordion-button collapsed"
                              data-bs-toggle="collapse"
                              data-bs-target="#faq3">

                              Apakah ada biaya untuk bergabung?

                           </button>

                        </div>

                        <div id="faq3"
                           class="accordion-collapse collapse"
                           data-bs-parent="#faqOrganization">

                           <div class="card-body">

                              Sebagian besar organisasi tidak memungut biaya.
                              Jika terdapat iuran kegiatan, akan diinformasikan
                              secara transparan kepada seluruh anggota.

                           </div>

                        </div>

                     </div>

                     <div class="card plain accordion-item">

                        <div class="card-header">

                           <button class="accordion-button collapsed"
                              data-bs-toggle="collapse"
                              data-bs-target="#faq4">

                              Bagaimana cara menjadi pengurus organisasi?

                           </button>

                        </div>

                        <div id="faq4"
                           class="accordion-collapse collapse"
                           data-bs-parent="#faqOrganization">

                           <div class="card-body">

                              Mahasiswa dapat mengikuti proses kaderisasi,
                              memenuhi persyaratan organisasi, dan mengikuti
                              mekanisme pemilihan pengurus sesuai AD/ART organisasi.

                           </div>

                        </div>

                     </div>

                     <div class="card plain accordion-item">

                        <div class="card-header">

                           <button class="accordion-button collapsed"
                              data-bs-toggle="collapse"
                              data-bs-target="#faq5">

                              Apakah kegiatan organisasi mendapatkan sertifikat?

                           </button>

                        </div>

                        <div id="faq5"
                           class="accordion-collapse collapse"
                           data-bs-parent="#faqOrganization">

                           <div class="card-body">

                              Ya. Sertifikat diberikan untuk kegiatan tertentu
                              sebagai bentuk apresiasi atas partisipasi mahasiswa.

                           </div>

                        </div>

                     </div>

                  </div>

               </div>

               <!-- Recruitment -->

               <div class="col-lg-4">

                  <div class="recruitment-card">

                     <div class="recruitment-icon">

                        🚀

                     </div>

                     <h3>

                        Open Recruitment

                     </h3>

                     <p>

                        Bergabunglah bersama organisasi mahasiswa dan
                        kembangkan potensi kepemimpinan, kreativitas,
                        serta jejaring profesional Anda.

                     </p>

                     <hr>

                     <div class="recruit-info">

                        📅 <strong>Periode</strong><br>

                        Agustus – September

                     </div>

                     <div class="recruit-info mt-4">

                        👨‍🎓 <strong>Peserta</strong><br>

                        Seluruh Mahasiswa Aktif

                     </div>

                     <div class="recruit-info mt-4">

                        📍 <strong>Lokasi</strong><br>

                        Gedung Kemahasiswaan

                     </div>

                     <div class="d-grid mt-5">

                        <a href="#"
                           class="btn btn-primary rounded-pill">

                           Daftar Sekarang

                        </a>

                     </div>

                  </div>

               </div>

            </div>

         </div>

      </section>
   </div>
   <!-- /.content-wrapper -->
   <?php
   require 'footer.php';
   ?>
   <div class="progress-wrap">
      <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
         <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
      </svg>
   </div>
   <script src="./assets/js/plugins.js"></script>
   <script src="./assets/js/theme.js"></script>
</body>

</html>