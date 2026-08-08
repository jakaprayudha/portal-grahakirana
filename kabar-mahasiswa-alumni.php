<!DOCTYPE html>
<html lang="en">

<?php
$page = "Home";
require 'head.php';
?>
<style>
   .news-filter {

      display: flex;

      gap: 12px;

      flex-wrap: wrap;

   }

   .news-filter button {

      border: none;

      padding: 10px 22px;

      border-radius: 50px;

      background: #F3F4F7;

      font-weight: 600;

      transition: .3s;

   }

   .news-filter button.active,
   .news-filter button:hover {

      background: #6A3DA8;

      color: #fff;

   }

   .news-card {

      background: #fff;

      border-radius: 24px;

      overflow: hidden;

      height: 100%;

      box-shadow: 0 15px 35px rgba(0, 0, 0, .06);

      transition: .35s;

   }

   .news-card:hover {

      transform: translateY(-10px);

      box-shadow: 0 25px 50px rgba(106, 61, 168, .18);

   }

   .news-image {

      position: relative;

      overflow: hidden;

      height: 240px;

   }

   .news-image img {

      width: 100%;

      height: 100%;

      object-fit: cover;

      transition: .4s;

   }

   .news-card:hover img {

      transform: scale(1.08);

   }

   .news-category {

      position: absolute;

      left: 20px;

      top: 20px;

      background: #6A3DA8;

      color: #fff;

      padding: 8px 18px;

      border-radius: 50px;

      font-size: 13px;

      font-weight: 600;

   }

   .news-body {

      padding: 25px;

   }

   .news-body small {

      display: block;

      margin-bottom: 15px;

      color: #777;

   }

   .news-body h4 {

      margin-bottom: 15px;

      line-height: 1.5;

   }

   .news-body p {

      color: #666;

      margin-bottom: 20px;

   }

   .news-body a {

      font-weight: 600;

      color: #6A3DA8;

      text-decoration: none;

   }

   .career-card {

      background: #fff;

      border-radius: 24px;

      overflow: hidden;

      height: 100%;

      box-shadow: 0 15px 35px rgba(0, 0, 0, .06);

      transition: .35s;

   }

   .career-card:hover {

      transform: translateY(-10px);

      box-shadow: 0 25px 55px rgba(106, 61, 168, .18);

   }

   .career-image {

      position: relative;

      height: 260px;

      overflow: hidden;

   }

   .career-image img {

      width: 100%;

      height: 100%;

      object-fit: cover;

      transition: .4s;

   }

   .career-card:hover img {

      transform: scale(1.08);

   }

   .career-badge {

      position: absolute;

      top: 20px;

      right: 20px;

      background: #6A3DA8;

      color: #fff;

      padding: 8px 16px;

      border-radius: 50px;

      font-size: 13px;

      font-weight: 600;

   }

   .career-body {

      padding: 30px;

      text-align: center;

   }

   .career-icon {

      width: 75px;

      height: 75px;

      margin: auto;

      margin-top: -68px;

      margin-bottom: 20px;

      background: #fff;

      border-radius: 50%;

      display: flex;

      align-items: center;

      justify-content: center;

      font-size: 36px;

      box-shadow: 0 10px 30px rgba(0, 0, 0, .15);

      position: relative;

      z-index: 2;

   }

   .career-body h4 {

      margin-bottom: 8px;

   }

   .career-body h6 {

      color: #6A3DA8;

      margin-bottom: 10px;

   }

   .career-body p {

      color: #666;

      margin-bottom: 20px;

   }

   .career-stat {

      background: #fff;

      border-radius: 22px;

      padding: 30px 20px;

      text-align: center;

      box-shadow: 0 15px 35px rgba(0, 0, 0, .06);

      transition: .35s;

      height: 100%;

   }

   .career-stat:hover {

      transform: translateY(-8px);

      box-shadow: 0 25px 50px rgba(106, 61, 168, .18);

   }

   .career-stat-icon {

      width: 75px;

      height: 75px;

      margin: auto;

      margin-bottom: 20px;

      background: #F3EEFD;

      border-radius: 18px;

      display: flex;

      align-items: center;

      justify-content: center;

      font-size: 36px;

      transition: .35s;

   }

   .career-stat:hover .career-stat-icon {

      background: #6A3DA8;

      color: #fff;

      transform: rotate(10deg);

   }

   .career-progress {

      margin-bottom: 30px;

   }

   .career-progress .progress {

      height: 10px;

      margin-top: 8px;

      border-radius: 50px;

      overflow: hidden;

      background: #E9ECEF;

   }

   .calendar-card {

      background: #fff;

      padding: 35px;

      border-radius: 24px;

      box-shadow: 0 15px 35px rgba(0, 0, 0, .08);

      height: 100%;

   }

   .calendar-item {

      display: flex;

      gap: 20px;

      align-items: center;

      padding: 18px 0;

      border-bottom: 1px dashed #ddd;

   }

   .calendar-item:last-child {

      border-bottom: none;

   }

   .calendar-date {

      width: 75px;

      height: 75px;

      background: #6A3DA8;

      border-radius: 18px;

      color: #fff;

      display: flex;

      flex-direction: column;

      align-items: center;

      justify-content: center;

      flex-shrink: 0;

   }

   .calendar-date strong {

      font-size: 24px;

      line-height: 1;

   }

   .calendar-date span {

      font-size: 12px;

      letter-spacing: 1px;

      margin-top: 4px;

   }

   .event-feature {

      position: relative;

      overflow: hidden;

      border-radius: 24px;

      height: 100%;

      min-height: 580px;

   }

   .event-feature img {

      width: 100%;

      height: 100%;

      object-fit: cover;

      transition: .5s;

   }

   .event-feature:hover img {

      transform: scale(1.08);

   }

   .event-overlay {

      position: absolute;

      inset: 0;

      padding: 45px;

      display: flex;

      flex-direction: column;

      justify-content: flex-end;

      background: linear-gradient(to top,
            rgba(0, 0, 0, .9),
            rgba(0, 0, 0, .35),
            transparent);

      color: #fff;

   }

   .event-overlay h2 {

      color: #fff;

      margin: 15px 0;

   }

   .event-overlay p {

      color: rgba(255, 255, 255, .9);

   }

   .media-wall {

      position: relative;

      overflow: hidden;

      border-radius: 24px;

      cursor: pointer;

      box-shadow: 0 18px 40px rgba(0, 0, 0, .08);

   }

   .media-wall.large {

      height: 520px;

   }

   .media-wall.small {

      height: 248px;

   }

   .media-wall.bottom {

      height: 240px;

   }

   .media-wall img {

      width: 100%;

      height: 100%;

      object-fit: cover;

      transition: .45s;

   }

   .media-wall:hover img {

      transform: scale(1.08);

   }

   .media-overlay {

      position: absolute;

      left: 0;

      right: 0;

      bottom: 0;

      padding: 30px;

      background: linear-gradient(to top,
            rgba(0, 0, 0, .85),
            rgba(0, 0, 0, .25),
            transparent);

      color: #fff;

      opacity: 0;

      transition: .35s;

   }

   .media-wall:hover .media-overlay {

      opacity: 1;

   }

   .media-overlay h3,
   .media-overlay h5 {

      color: #fff;

      margin: 12px 0;

   }

   .media-meta {

      display: flex;

      gap: 20px;

      flex-wrap: wrap;

      font-size: 14px;

      opacity: .9;

   }

   .connect-item {

      display: flex;

      gap: 18px;

      align-items: center;

      background: #fff;

      padding: 22px;

      border-radius: 18px;

      box-shadow: 0 12px 30px rgba(0, 0, 0, .06);

      height: 100%;

      transition: .35s;

   }

   .connect-item:hover {

      transform: translateY(-6px);

      box-shadow: 0 20px 40px rgba(106, 61, 168, .15);

   }

   .connect-icon {

      width: 65px;

      height: 65px;

      background: #F4EEFD;

      border-radius: 18px;

      display: flex;

      align-items: center;

      justify-content: center;

      font-size: 28px;

      transition: .35s;

   }

   .connect-item:hover .connect-icon {

      background: #6A3DA8;

      color: #fff;

   }

   .subscribe-card {

      background: #fff;

      padding: 40px;

      border-radius: 24px;

      box-shadow: 0 20px 45px rgba(0, 0, 0, .08);

   }

   .subscribe-card input {

      border-radius: 14px;

      padding: 16px;

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
                     Campus News
                  </span>

                  <h2 class="display-4 mb-4">
                     Kabar Mahasiswa
                     <br>
                     & Alumni
                  </h2>

                  <p class="lead mb-5">
                     Temukan informasi terbaru seputar prestasi mahasiswa,
                     kegiatan organisasi, seminar nasional, kompetisi,
                     pengabdian kepada masyarakat, hingga kisah sukses alumni
                     STIH Graha Kirana.
                  </p>

                  <div class="row g-4">

                     <div class="col-6">

                        <div class="calendar-info">

                           <h5>📰 Berita Kampus</h5>

                           <small>
                              Update kegiatan akademik dan kemahasiswaan.
                           </small>

                        </div>

                     </div>

                     <div class="col-6">

                        <div class="calendar-info">

                           <h5>🏆 Prestasi</h5>

                           <small>
                              Capaian mahasiswa dan alumni di berbagai kompetisi.
                           </small>

                        </div>

                     </div>

                  </div>

                  <div class="mt-5">

                     <a href="#berita"
                        class="btn btn-primary rounded-pill me-3">

                        <i class="uil uil-newspaper me-2"></i>
                        Berita Terbaru

                     </a>

                     <a href="#alumni"
                        class="btn btn-outline-primary rounded-pill">

                        <i class="uil uil-user-circle me-2"></i>
                        Kisah Alumni

                     </a>

                  </div>

               </div>

               <!-- RIGHT -->

               <div class="col-lg-6">

                  <img src="./assets/img/hero-news.png"
                     class="img-fluid rounded-4 shadow-lg"
                     alt="Kabar Mahasiswa dan Alumni">

               </div>

            </div>

         </div>
      </section>
      <section class="wrapper bg-light" id="berita">
         <div class="container py-15 py-md-17">

            <div class="row align-items-center mb-10">

               <div class="col-lg-8">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
                     Campus News
                  </span>

                  <h2 class="display-5 mb-3">
                     Berita & Informasi Terbaru
                  </h2>

                  <p class="lead mb-0">
                     Ikuti berbagai kegiatan akademik, prestasi mahasiswa,
                     seminar, organisasi, hingga kabar alumni STIH Graha Kirana.
                  </p>

               </div>

               <div class="col-lg-4 text-lg-end">

                  <a href="#" class="btn btn-primary rounded-pill">
                     Semua Berita
                  </a>

               </div>

            </div>


            <div class="row gy-5">

               <!-- Berita Besar -->

               <div class="col-lg-6">

                  <div class="card shadow-lg border-0">

                     <img src="./assets/img/news/featured.jpg"
                        class="card-img-top"
                        alt="">

                     <div class="card-body p-5">

                        <span class="badge bg-primary mb-3">
                           Alumni
                        </span>

                        <h3>
                           Alumni STIH Graha Kirana Menjadi Hakim Termuda
                        </h3>

                        <p>
                           Kisah inspiratif alumni yang berhasil membangun
                           karier di dunia peradilan setelah lulus dari
                           STIH Graha Kirana.
                        </p>

                        <a href="#">
                           Baca Selengkapnya →
                        </a>

                     </div>

                  </div>

               </div>

               <!-- 4 Card -->

               <div class="col-lg-6">

                  <div class="row gy-4">

                     <div class="col-md-6">

                        <div class="card shadow-sm border-0 h-100">

                           <img src="./assets/img/news/news1.png"
                              class="card-img-top">

                           <div class="card-body">

                              <small class="text-primary">
                                 Seminar
                              </small>

                              <h5>
                                 Seminar Nasional Hukum Digital
                              </h5>

                           </div>

                        </div>

                     </div>

                     <div class="col-md-6">

                        <div class="card shadow-sm border-0 h-100">

                           <img src="./assets/img/news/news2.png"
                              class="card-img-top">

                           <div class="card-body">

                              <small class="text-primary">
                                 Prestasi
                              </small>

                              <h5>
                                 Juara Moot Court Competition
                              </h5>

                           </div>

                        </div>

                     </div>

                     <div class="col-md-6">

                        <div class="card shadow-sm border-0 h-100">

                           <img src="./assets/img/news/news3.png"
                              class="card-img-top">

                           <div class="card-body">

                              <small class="text-primary">
                                 Mahasiswa
                              </small>

                              <h5>
                                 PKKMB Tahun Akademik 2026
                              </h5>

                           </div>

                        </div>

                     </div>

                     <div class="col-md-6">

                        <div class="card shadow-sm border-0 h-100">

                           <img src="./assets/img/news/news5.png"
                              class="card-img-top">

                           <div class="card-body">

                              <small class="text-primary">
                                 Pengabdian
                              </small>

                              <h5>
                                 Penyuluhan Hukum Masyarakat
                              </h5>

                           </div>

                        </div>

                     </div>

                  </div>

               </div>

            </div>

         </div>
      </section>
      <section class="wrapper bg-white">
         <div class="container py-15 py-md-17">

            <!-- Heading -->

            <div class="row mb-8">

               <div class="col-lg-6">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

                     Latest News

                  </span>

                  <h2 class="display-5">

                     Berita Terbaru

                  </h2>

               </div>

               <div class="col-lg-6 text-lg-end">

                  <a href="#"
                     class="btn btn-outline-primary rounded-pill">

                     Lihat Semua Berita

                  </a>

               </div>

            </div>

            <!-- FILTER -->

            <div class="news-filter mb-5">

               <button class="active">Semua</button>

               <button>Mahasiswa</button>

               <button>Alumni</button>

               <button>Prestasi</button>

               <button>Seminar</button>

               <button>Kompetisi</button>

               <button>Organisasi</button>

               <button>Wisuda</button>

            </div>

            <!-- NEWS -->

            <div class="row g-4">

               <?php

               $news = [

                  [
                     "seminar.png",
                     "Seminar",
                     "Seminar Nasional Hukum Digital 2026",
                     "Ratusan mahasiswa mengikuti seminar nasional bersama praktisi hukum dan akademisi."
                  ],

                  [
                     "mootcourt.png",
                     "Prestasi",
                     "Tim Moot Court Raih Juara Nasional",
                     "Mahasiswa STIH Graha Kirana berhasil meraih juara pada kompetisi tingkat nasional."
                  ],

                  [
                     "pkkmb.png",
                     "Mahasiswa",
                     "PKKMB Tahun Akademik 2026",
                     "Mahasiswa baru mengikuti kegiatan pengenalan kehidupan kampus."
                  ],

                  [
                     "legalid.png",
                     "Pengabdian",
                     "Penyuluhan Hukum kepada Masyarakat",
                     "Mahasiswa memberikan edukasi hukum kepada masyarakat sekitar."
                  ],

                  [
                     "wisuda.png",
                     "Wisuda",
                     "Wisuda Periode Genap",
                     "Ratusan mahasiswa resmi menyandang gelar Sarjana Hukum."
                  ],

                  [
                     "alumni.png",
                     "Alumni",
                     "Alumni Menjadi Legal Manager",
                     "Alumni STIH berhasil berkarier sebagai Legal Manager di perusahaan nasional."
                  ]

               ];

               foreach ($news as $n) {

               ?>

                  <div class="col-md-6 col-xl-4">

                     <div class="news-card">

                        <div class="news-image">

                           <img src="./assets/img/gallery/<?= $n[0] ?>">

                           <span class="news-category">

                              <?= $n[1] ?>

                           </span>

                        </div>

                        <div class="news-body">

                           <small>

                              <i class="uil uil-calendar-alt"></i>

                              06 Agustus 2026

                           </small>

                           <h4>

                              <?= $n[2] ?>

                           </h4>

                           <p>

                              <?= $n[3] ?>

                           </p>

                           <a href="#">

                              Baca Selengkapnya

                              <i class="uil uil-arrow-right"></i>

                           </a>

                        </div>

                     </div>

                  </div>

               <?php } ?>

            </div>

         </div>
      </section>
      <section class="wrapper bg-soft-primary" id="alumni">
         <div class="container py-15 py-md-17">

            <!-- Heading -->

            <div class="row text-center mb-10">

               <div class="col-lg-8 mx-auto">

                  <span class="badge bg-primary text-white rounded-pill mb-3">

                     Alumni Success Story

                  </span>

                  <h2 class="display-5 mb-3">

                     Jejak Karier Alumni

                  </h2>

                  <p class="lead">

                     Alumni STIH Graha Kirana telah berkiprah di berbagai
                     profesi hukum maupun sektor pemerintahan dan swasta,
                     menjadi bukti nyata kualitas lulusan kampus.

                  </p>

               </div>

            </div>

            <div class="row g-4">

               <?php

               $career = [

                  [
                     "judge.png",
                     "👨‍⚖️",
                     "Hakim",
                     "Ahmad Fauzi, S.H.",
                     "Pengadilan Negeri Medan",
                     "Peradilan"
                  ],

                  [
                     "lawyer.png",
                     "⚖️",
                     "Advokat",
                     "Siti Rahma, S.H.",
                     "Law Firm Indonesia",
                     "Profesi"
                  ],

                  [
                     "notary.png",
                     "📜",
                     "Notaris",
                     "Rudi Hartono, S.H., M.Kn.",
                     "Kantor Notaris Medan",
                     "Kenotariatan"
                  ],

                  [
                     "legal.png",
                     "🏢",
                     "Legal Manager",
                     "Andi Saputra, S.H.",
                     "PT Nusantara Group",
                     "Corporate"
                  ],

                  [
                     "lecturer.png",
                     "🎓",
                     "Dosen",
                     "Nur Aisyah, S.H., M.H.",
                     "Perguruan Tinggi",
                     "Akademisi"
                  ],

                  [
                     "asn.png",
                     "🏛️",
                     "ASN",
                     "Budi Santoso, S.H.",
                     "Kementerian Hukum",
                     "Pemerintahan"
                  ]

               ];

               foreach ($career as $c) {

               ?>

                  <div class="col-md-6 col-xl-4">

                     <div class="career-card">

                        <div class="career-image">

                           <img src="./assets/img/alumni/<?= $c[0] ?>">

                           <span class="career-badge">

                              <?= $c[5] ?>

                           </span>

                        </div>

                        <div class="career-body">

                           <div class="career-icon">

                              <?= $c[1] ?>

                           </div>

                           <h4>

                              <?= $c[2] ?>

                           </h4>

                           <h6>

                              <?= $c[3] ?>

                           </h6>

                           <p>

                              <?= $c[4] ?>

                           </p>

                           <a href="#"
                              class="btn btn-outline-primary rounded-pill btn-sm">

                              Lihat Profil

                           </a>

                        </div>

                     </div>

                  </div>

               <?php } ?>

            </div>

         </div>

      </section>
      <section class="wrapper bg-white">
         <div class="container py-15 py-md-17">

            <!-- Heading -->

            <div class="row text-center mb-10">

               <div class="col-lg-8 mx-auto">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

                     Alumni Statistics

                  </span>

                  <h2 class="display-5 mb-3">

                     Sebaran Karier Alumni

                  </h2>

                  <p class="lead">

                     Lulusan STIH Graha Kirana telah berkarier di berbagai
                     sektor profesi hukum, pemerintahan, akademisi,
                     hingga dunia industri.

                  </p>

               </div>

            </div>

            <!-- COUNTER -->

            <div class="row g-4 mb-12">

               <div class="col-6 col-lg-2">

                  <div class="career-stat">

                     <div class="career-stat-icon">👨‍⚖️</div>

                     <h2>45</h2>

                     <small>Hakim</small>

                  </div>

               </div>

               <div class="col-6 col-lg-2">

                  <div class="career-stat">

                     <div class="career-stat-icon">⚖️</div>

                     <h2>120</h2>

                     <small>Advokat</small>

                  </div>

               </div>

               <div class="col-6 col-lg-2">

                  <div class="career-stat">

                     <div class="career-stat-icon">📜</div>

                     <h2>30</h2>

                     <small>Notaris</small>

                  </div>

               </div>

               <div class="col-6 col-lg-2">

                  <div class="career-stat">

                     <div class="career-stat-icon">🏢</div>

                     <h2>150</h2>

                     <small>Legal Officer</small>

                  </div>

               </div>

               <div class="col-6 col-lg-2">

                  <div class="career-stat">

                     <div class="career-stat-icon">🏛️</div>

                     <h2>80</h2>

                     <small>ASN</small>

                  </div>

               </div>

               <div class="col-6 col-lg-2">

                  <div class="career-stat">

                     <div class="career-stat-icon">🎓</div>

                     <h2>35</h2>

                     <small>Dosen</small>

                  </div>

               </div>

            </div>

            <!-- DISTRIBUTION -->

            <div class="row align-items-center gy-5">

               <div class="col-lg-6">

                  <img src="./assets/img/alumni-career.png"
                     class="img-fluid rounded-4 shadow-lg"
                     alt="Career">

               </div>

               <div class="col-lg-6">

                  <h3 class="mb-4">

                     Distribusi Profesi Alumni

                  </h3>

                  <div class="career-progress">

                     <div class="d-flex justify-content-between">

                        <span>Pemerintahan</span>

                        <strong>35%</strong>

                     </div>

                     <div class="progress">

                        <div class="progress-bar bg-primary"
                           style="width:35%"></div>

                     </div>

                  </div>

                  <div class="career-progress">

                     <div class="d-flex justify-content-between">

                        <span>Law Firm</span>

                        <strong>25%</strong>

                     </div>

                     <div class="progress">

                        <div class="progress-bar bg-success"
                           style="width:25%"></div>

                     </div>

                  </div>

                  <div class="career-progress">

                     <div class="d-flex justify-content-between">

                        <span>Perusahaan</span>

                        <strong>20%</strong>

                     </div>

                     <div class="progress">

                        <div class="progress-bar bg-warning"
                           style="width:20%"></div>

                     </div>

                  </div>

                  <div class="career-progress">

                     <div class="d-flex justify-content-between">

                        <span>Akademisi</span>

                        <strong>12%</strong>

                     </div>

                     <div class="progress">

                        <div class="progress-bar bg-info"
                           style="width:12%"></div>

                     </div>

                  </div>

                  <div class="career-progress">

                     <div class="d-flex justify-content-between">

                        <span>Wirausaha Hukum</span>

                        <strong>8%</strong>

                     </div>

                     <div class="progress">

                        <div class="progress-bar bg-danger"
                           style="width:8%"></div>

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

                     Campus Events

                  </span>

                  <h2 class="display-5 mb-3">

                     Agenda & Event Kampus

                  </h2>

                  <p class="lead">

                     Berbagai kegiatan akademik, seminar, kompetisi,
                     organisasi mahasiswa, hingga kegiatan alumni
                     yang diselenggarakan sepanjang tahun.

                  </p>

               </div>

            </div>

            <div class="row g-5">

               <!-- Calendar -->

               <div class="col-lg-5">

                  <div class="calendar-card">

                     <h3 class="mb-4">

                        📅 Agenda Bulan Ini

                     </h3>

                     <div class="calendar-item">

                        <div class="calendar-date">

                           <strong>15</strong>

                           <span>AGU</span>

                        </div>

                        <div>

                           <h5>Seminar Nasional Hukum</h5>

                           <small>Auditorium STIH Graha Kirana</small>

                        </div>

                     </div>

                     <div class="calendar-item">

                        <div class="calendar-date">

                           <strong>18</strong>

                           <span>AGU</span>

                        </div>

                        <div>

                           <h5>PKKMB Mahasiswa Baru</h5>

                           <small>Gedung Utama</small>

                        </div>

                     </div>

                     <div class="calendar-item">

                        <div class="calendar-date">

                           <strong>24</strong>

                           <span>AGU</span>

                        </div>

                        <div>

                           <h5>Moot Court Competition</h5>

                           <small>Laboratorium Moot Court</small>

                        </div>

                     </div>

                     <div class="calendar-item">

                        <div class="calendar-date">

                           <strong>30</strong>

                           <span>AGU</span>

                        </div>

                        <div>

                           <h5>Legal Festival 2026</h5>

                           <small>Lapangan Kampus</small>

                        </div>

                     </div>

                  </div>

               </div>

               <!-- Featured Event -->

               <div class="col-lg-7">

                  <div class="event-feature">

                     <img src="./assets/img/event-feature.png"
                        class="img-fluid">

                     <div class="event-overlay">

                        <span class="badge bg-warning text-dark mb-3">

                           EVENT UNGGULAN

                        </span>

                        <h2>

                           Seminar Nasional
                           Transformasi Hukum Digital

                        </h2>

                        <p>

                           Menghadirkan akademisi, praktisi hukum,
                           dan narasumber nasional untuk membahas
                           perkembangan hukum di era digital.

                        </p>

                        <div class="row mt-4">

                           <div class="col-4">

                              <h3>

                                 15

                              </h3>

                              <small>Agustus</small>

                           </div>

                           <div class="col-4">

                              <h3>

                                 09.00

                              </h3>

                              <small>WIB</small>

                           </div>

                           <div class="col-4">

                              <h3>

                                 Aula

                              </h3>

                              <small>Utama</small>

                           </div>

                        </div>

                        <div class="mt-4">

                           <a href="#"
                              class="btn btn-white rounded-pill me-2">

                              Daftar Event

                           </a>

                           <a href="#"
                              class="btn btn-outline-white rounded-pill">

                              Detail Event

                           </a>

                        </div>

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

                     Media Gallery

                  </span>

                  <h2 class="display-5 mb-3">

                     Galeri Kegiatan Kampus

                  </h2>

                  <p class="lead">

                     Dokumentasi berbagai kegiatan mahasiswa, alumni,
                     seminar, kompetisi, pengabdian masyarakat,
                     dan aktivitas akademik di STIH Graha Kirana.

                  </p>

               </div>

            </div>

            <div class="row g-4">

               <!-- Large -->

               <div class="col-lg-8">

                  <div class="media-wall large">

                     <img src="./assets/img/gallery/seminar.png">

                     <div class="media-overlay">

                        <span class="badge bg-primary">

                           Seminar Nasional

                        </span>

                        <h3>

                           Seminar Nasional Transformasi Hukum Digital

                        </h3>

                        <div class="media-meta">

                           <span>

                              📅 15 Agustus 2026

                           </span>

                           <span>

                              👥 500 Peserta

                           </span>

                        </div>

                     </div>

                  </div>

               </div>

               <!-- Right -->

               <div class="col-lg-4">

                  <div class="media-wall small mb-4">

                     <img src="./assets/img/gallery/mootcourt.png">

                     <div class="media-overlay">

                        <h5>Moot Court</h5>

                     </div>

                  </div>

                  <div class="media-wall small">

                     <img src="./assets/img/gallery/wisuda.png">

                     <div class="media-overlay">

                        <h5>Wisuda</h5>

                     </div>

                  </div>

               </div>

               <!-- Bottom -->

               <div class="col-md-4">

                  <div class="media-wall bottom">

                     <img src="./assets/img/gallery/pkkmb.png">

                     <div class="media-overlay">

                        <h5>PKKMB</h5>

                     </div>

                  </div>

               </div>

               <div class="col-md-4">

                  <div class="media-wall bottom">

                     <img src="./assets/img/gallery/festival.png">

                     <div class="media-overlay">

                        <h5>Festival Mahasiswa</h5>

                     </div>

                  </div>

               </div>

               <div class="col-md-4">

                  <div class="media-wall bottom">

                     <img src="./assets/img/gallery/baksos.png">

                     <div class="media-overlay">

                        <h5>Bakti Sosial</h5>

                     </div>

                  </div>

               </div>

            </div>

            <div class="text-center mt-10">

               <a href="#"
                  class="btn btn-primary rounded-pill me-3">

                  <i class="uil uil-images me-2"></i>

                  Lihat Semua Galeri

               </a>

               <a href="#"
                  class="btn btn-outline-primary rounded-pill">

                  <i class="uil uil-play-circle me-2"></i>

                  Video Kegiatan

               </a>

            </div>

         </div>
      </section>
      <section class="wrapper bg-soft-primary">
         <div class="container py-15 py-md-17">

            <div class="row align-items-center gy-5">

               <!-- Left -->

               <div class="col-lg-6">

                  <span class="badge bg-primary text-white rounded-pill mb-3">

                     Stay Connected

                  </span>

                  <h2 class="display-5 mb-4">

                     Tetap Terhubung
                     Dengan Kampus

                  </h2>

                  <p class="lead mb-5">

                     Dapatkan informasi terbaru mengenai berita kampus,
                     agenda akademik, kegiatan mahasiswa, alumni,
                     serta berbagai layanan digital STIH Graha Kirana.

                  </p>

                  <div class="row g-4">

                     <div class="col-sm-6">

                        <div class="connect-item">

                           <div class="connect-icon">

                              📱

                           </div>

                           <div>

                              <h5>Portal Akademik</h5>

                              <small>Akses informasi akademik secara online.</small>

                           </div>

                        </div>

                     </div>

                     <div class="col-sm-6">

                        <div class="connect-item">

                           <div class="connect-icon">

                              📰

                           </div>

                           <div>

                              <h5>Berita Kampus</h5>

                              <small>Informasi terbaru setiap hari.</small>

                           </div>

                        </div>

                     </div>

                     <div class="col-sm-6">

                        <div class="connect-item">

                           <div class="connect-icon">

                              📅

                           </div>

                           <div>

                              <h5>Kalender Event</h5>

                              <small>Agenda seminar dan kegiatan kampus.</small>

                           </div>

                        </div>

                     </div>

                     <div class="col-sm-6">

                        <div class="connect-item">

                           <div class="connect-icon">

                              🔔

                           </div>

                           <div>

                              <h5>Notifikasi</h5>

                              <small>Dapatkan update langsung dari kampus.</small>

                           </div>

                        </div>

                     </div>

                  </div>

               </div>

               <!-- Right -->

               <div class="col-lg-6">

                  <div class="subscribe-card">

                     <h3 class="mb-3">

                        Berlangganan Informasi Kampus

                     </h3>

                     <p class="mb-4">

                        Masukkan alamat email Anda untuk menerima informasi
                        terbaru mengenai kegiatan mahasiswa, alumni,
                        seminar, dan berita kampus.

                     </p>

                     <form>

                        <div class="mb-3">

                           <input
                              type="text"
                              class="form-control form-control-lg"
                              placeholder="Nama Lengkap">

                        </div>

                        <div class="mb-3">

                           <input
                              type="email"
                              class="form-control form-control-lg"
                              placeholder="Alamat Email">

                        </div>

                        <button class="btn btn-primary rounded-pill btn-lg w-100">

                           <i class="uil uil-envelope"></i>

                           Berlangganan Sekarang

                        </button>

                     </form>

                     <hr>

                     <div class="row text-center">

                        <div class="col-4">

                           <h3 class="text-primary">

                              8K+

                           </h3>

                           <small>Subscribers</small>

                        </div>

                        <div class="col-4">

                           <h3 class="text-primary">

                              350+

                           </h3>

                           <small>Artikel</small>

                        </div>

                        <div class="col-4">

                           <h3 class="text-primary">

                              40+

                           </h3>

                           <small>Event</small>

                        </div>

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