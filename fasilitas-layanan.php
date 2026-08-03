<!DOCTYPE html>
<html lang="en">

<?php
$page = "Home";
require 'head.php';
?>
<style>
   .facility-highlight {

      display: flex;

      align-items: center;

      gap: 18px;

      padding: 20px;

      background: #fff;

      border-radius: 20px;

      height: 100%;

      box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

      transition: .35s;

   }

   .facility-highlight:hover {

      transform: translateY(-6px);

      box-shadow: 0 20px 40px rgba(106, 61, 168, .15);

   }

   .facility-icon {

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

   .facility-highlight:hover .facility-icon {

      background: #6A3DA8;

      color: #fff;

      transform: rotate(8deg);

   }

   .facility-highlight h5 {

      margin-bottom: 6px;

   }

   .facility-highlight small {

      color: #666;

   }

   .facility-card {

      border-radius: 22px;

      overflow: hidden;

      background: #fff;

      box-shadow: 0 15px 35px rgba(0, 0, 0, .08);

      transition: .35s;

      height: 100%;

   }

   .facility-card:hover {

      transform: translateY(-10px);

      box-shadow: 0 25px 55px rgba(106, 61, 168, .18);

   }

   .facility-image {

      position: relative;

      overflow: hidden;

      height: 220px;

   }

   .facility-image img {

      width: 100%;

      height: 100%;

      object-fit: cover;

      transition: .5s;

   }

   .facility-card:hover img {

      transform: scale(1.08);

   }

   .facility-badge {

      position: absolute;

      left: 15px;

      top: 15px;

      width: 55px;

      height: 55px;

      border-radius: 16px;

      background: #fff;

      display: flex;

      align-items: center;

      justify-content: center;

      font-size: 28px;

      box-shadow: 0 10px 25px rgba(0, 0, 0, .15);

   }

   .facility-body {

      padding: 25px;

   }

   .facility-body h5 {

      margin-bottom: 15px;

   }

   .facility-body p {

      margin: 0;

      color: #666;

      font-size: 14px;

      line-height: 1.7;

   }

   .service-timeline {

      max-width: 1000px;

      margin: auto;

   }

   .service-item {

      display: flex;

      gap: 25px;

      align-items: flex-start;

      padding: 30px;

      background: #fff;

      border-radius: 24px;

      margin-bottom: 25px;

      box-shadow: 0 15px 35px rgba(0, 0, 0, .06);

      transition: .35s;

   }

   .service-item:hover {

      transform: translateX(10px);

      box-shadow: 0 20px 45px rgba(106, 61, 168, .15);

   }

   .service-icon {

      width: 80px;

      height: 80px;

      border-radius: 20px;

      display: flex;

      align-items: center;

      justify-content: center;

      font-size: 36px;

      color: #fff;

      flex-shrink: 0;

   }

   .service-content h4 {

      margin-bottom: 10px;

   }

   .service-content p {

      margin: 0;

      line-height: 1.8;

      color: #666;

   }

   @media(max-width:768px) {

      .service-item {

         flex-direction: column;

         text-align: center;

      }

      .service-icon {

         margin: auto;

      }

   }

   .digital-card {

      background: #fff;

      padding: 30px;

      border-radius: 24px;

      height: 100%;

      border: 1px solid #ECECEC;

      box-shadow: 0 15px 40px rgba(0, 0, 0, .06);

      transition: .35s;

   }

   .digital-card:hover {

      transform: translateY(-10px);

      box-shadow: 0 25px 55px rgba(106, 61, 168, .18);

      border-color: #6A3DA8;

   }

   .digital-header {

      display: flex;

      justify-content: space-between;

      align-items: center;

      margin-bottom: 20px;

   }

   .digital-icon {

      width: 75px;

      height: 75px;

      background: #F4EEFD;

      border-radius: 20px;

      display: flex;

      align-items: center;

      justify-content: center;

      font-size: 38px;

      transition: .35s;

   }

   .digital-card:hover .digital-icon {

      background: #6A3DA8;

      color: #fff;

      transform: rotate(8deg);

   }

   .digital-card h4 {

      margin-bottom: 20px;

   }

   .digital-card ul {

      list-style: none;

      padding: 0;

      margin: 0 0 25px;

   }

   .digital-card ul li {

      padding: 8px 0;

      color: #666;

      border-bottom: 1px dashed #EEE;

      font-size: 14px;

   }

   .digital-card ul li:last-child {

      border-bottom: none;

   }

   .office-card {

      background: #fff;

      padding: 40px;

      border-radius: 24px;

      box-shadow: 0 15px 40px rgba(0, 0, 0, .08);

      height: 100%;

   }

   .office-item {

      display: flex;

      justify-content: space-between;

      align-items: center;

      padding: 18px 0;

      border-bottom: 1px dashed #DDD;

   }

   .office-item h5 {

      margin-bottom: 5px;

   }

   .office-item small {

      color: #666;

   }

   .contact-info {

      display: flex;

      gap: 18px;

      align-items: flex-start;

      margin-bottom: 28px;

   }

   .contact-icon {

      width: 60px;

      height: 60px;

      background: #F4EEFD;

      border-radius: 18px;

      display: flex;

      align-items: center;

      justify-content: center;

      font-size: 26px;

      flex-shrink: 0;

      transition: .35s;

   }

   .contact-info:hover .contact-icon {

      background: #6A3DA8;

      color: #fff;

   }

   .contact-info h6 {

      margin-bottom: 5px;

   }

   .contact-info p {

      margin: 0;

      color: #666;

   }

   .gallery-card {

      position: relative;

      overflow: hidden;

      border-radius: 22px;

      cursor: pointer;

   }

   .gallery-card img {

      width: 100%;

      height: 280px;

      object-fit: cover;

      transition: .5s;

   }

   .gallery-card:hover img {

      transform: scale(1.08);

   }

   .gallery-overlay {

      position: absolute;

      left: 0;

      right: 0;

      bottom: 0;

      padding: 30px;

      background: linear-gradient(to top,
            rgba(0, 0, 0, .75),
            transparent);

      color: #fff;

      opacity: 0;

      transition: .35s;

   }

   .gallery-card:hover .gallery-overlay {

      opacity: 1;

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

                     Campus Facilities

                  </span>

                  <h2 class="display-4 mb-4">

                     Fasilitas & Layanan
                     STIH Graha Kirana

                  </h2>

                  <p class="lead mb-5">

                     STIH Graha Kirana menyediakan berbagai fasilitas modern
                     dan layanan akademik yang dirancang untuk mendukung
                     kegiatan belajar mengajar, penelitian, pengembangan
                     kompetensi, serta pelayanan terbaik bagi seluruh mahasiswa.

                  </p>

                  <div class="row g-4">

                     <div class="col-md-6">

                        <div class="facility-highlight">

                           <div class="facility-icon">

                              🏛️

                           </div>

                           <div>

                              <h5 class="mb-1">

                                 Fasilitas Modern

                              </h5>

                              <small>

                                 Ruang belajar yang nyaman dan representatif.

                              </small>

                           </div>

                        </div>

                     </div>

                     <div class="col-md-6">

                        <div class="facility-highlight">

                           <div class="facility-icon">

                              👨‍🎓

                           </div>

                           <div>

                              <h5 class="mb-1">

                                 Student Services

                              </h5>

                              <small>

                                 Pelayanan akademik yang cepat dan mudah.

                              </small>

                           </div>

                        </div>

                     </div>

                     <div class="col-md-6">

                        <div class="facility-highlight">

                           <div class="facility-icon">

                              💻

                           </div>

                           <div>

                              <h5 class="mb-1">

                                 Digital Campus

                              </h5>

                              <small>

                                 Sistem informasi akademik terintegrasi.

                              </small>

                           </div>

                        </div>

                     </div>

                     <div class="col-md-6">

                        <div class="facility-highlight">

                           <div class="facility-icon">

                              🌐

                           </div>

                           <div>

                              <h5 class="mb-1">

                                 Smart Learning

                              </h5>

                              <small>

                                 Pembelajaran berbasis teknologi digital.

                              </small>

                           </div>

                        </div>

                     </div>

                  </div>

                  <div class="mt-5">

                     <a href="#fasilitas"
                        class="btn btn-primary rounded-pill me-3">

                        Jelajahi Fasilitas

                     </a>

                     <a href="contact.php"
                        class="btn btn-outline-primary rounded-pill">

                        Hubungi Kami

                     </a>

                  </div>

               </div>

               <!-- RIGHT -->

               <div class="col-lg-6">

                  <img src="./assets/img/fasilitas-layanan.png"
                     class="img-fluid rounded-4 shadow-lg"
                     alt="Fasilitas Kampus">

               </div>

            </div>

         </div>
      </section>
      <section class="wrapper bg-white" id="fasilitas">
         <div class="container py-15 py-md-17">

            <!-- Heading -->

            <div class="row text-center mb-10">

               <div class="col-lg-8 mx-auto">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
                     Campus Facilities
                  </span>

                  <h2 class="display-5 mb-3">

                     Fasilitas Pendukung Pembelajaran

                  </h2>

                  <p class="lead">

                     Berbagai fasilitas modern disediakan untuk menciptakan
                     lingkungan belajar yang nyaman, interaktif, dan mendukung
                     pengembangan kompetensi mahasiswa.

                  </p>

               </div>

            </div>

            <div class="row g-4">

               <?php

               $facility = [

                  [
                     "library.png",
                     "📚",
                     "Perpustakaan",
                     "Koleksi buku hukum, jurnal ilmiah, repository digital, dan ruang baca yang nyaman."
                  ],

                  [
                     "moot-court.png",
                     "⚖️",
                     "Laboratorium Moot Court",
                     "Simulasi persidangan untuk melatih kemampuan praktik hukum mahasiswa."
                  ],

                  [
                     "computer-lab.png",
                     "💻",
                     "Laboratorium Komputer",
                     "Komputer modern dengan akses internet dan aplikasi pembelajaran."
                  ],

                  [
                     "smart-class.png",
                     "🎥",
                     "Smart Classroom",
                     "Ruang kuliah multimedia dengan LCD projector dan smart display."
                  ],

                  [
                     "hall.png",
                     "🏛️",
                     "Aula Serbaguna",
                     "Digunakan untuk seminar, kuliah umum, workshop, dan kegiatan akademik."
                  ],

                  [
                     "wifi.png",
                     "🌐",
                     "Area WiFi Kampus",
                     "Akses internet berkecepatan tinggi di seluruh area kampus."
                  ],

                  [
                     "lounge.png",
                     "☕",
                     "Student Lounge",
                     "Area diskusi mahasiswa yang nyaman untuk belajar bersama."
                  ],

                  [
                     "parking.png",
                     "🚗",
                     "Area Parkir",
                     "Area parkir yang luas dan aman bagi mahasiswa maupun dosen."
                  ]

               ];

               foreach ($facility as $f) {

               ?>

                  <div class="col-md-6 col-xl-3">

                     <div class="facility-card">

                        <div class="facility-image">

                           <img src="./assets/img/facilities/<?= $f[0] ?>"
                              class="img-fluid">

                           <span class="facility-badge">

                              <?= $f[1] ?>

                           </span>

                        </div>

                        <div class="facility-body">

                           <h5>

                              <?= $f[2] ?>

                           </h5>

                           <p>

                              <?= $f[3] ?>

                           </p>

                        </div>

                     </div>

                  </div>

               <?php } ?>

            </div>

         </div>
      </section>
      <section class="wrapper bg-soft-primary">
         <div class="container py-15 py-md-17">

            <!-- Heading -->

            <div class="row text-center mb-12">

               <div class="col-lg-8 mx-auto">

                  <span class="badge bg-primary text-white rounded-pill mb-3">

                     Student Services

                  </span>

                  <h2 class="display-5 mb-3">

                     Layanan Mahasiswa

                  </h2>

                  <p class="lead">

                     Berbagai layanan akademik dan kemahasiswaan disediakan
                     untuk mendukung kebutuhan mahasiswa selama menempuh
                     pendidikan di STIH Graha Kirana.

                  </p>

               </div>

            </div>

            <div class="service-timeline">

               <!-- Item -->

               <div class="service-item">

                  <div class="service-icon bg-primary">

                     📝

                  </div>

                  <div class="service-content">

                     <h4>

                        Administrasi Akademik

                     </h4>

                     <p>

                        Melayani pengurusan KRS, KHS, surat aktif kuliah,
                        cuti akademik, legalisasi ijazah, dan berbagai
                        administrasi akademik lainnya.

                     </p>

                  </div>

               </div>

               <div class="service-item">

                  <div class="service-icon bg-success">

                     🎓

                  </div>

                  <div class="service-content">

                     <h4>

                        Bimbingan Akademik

                     </h4>

                     <p>

                        Pendampingan oleh dosen pembimbing akademik untuk
                        membantu mahasiswa dalam merencanakan studi dan
                        menyelesaikan kendala akademik.

                     </p>

                  </div>

               </div>

               <div class="service-item">

                  <div class="service-icon bg-warning">

                     💰

                  </div>

                  <div class="service-content">

                     <h4>

                        Layanan Beasiswa

                     </h4>

                     <p>

                        Informasi, konsultasi, dan proses pengajuan berbagai
                        program beasiswa internal maupun eksternal.

                     </p>

                  </div>

               </div>

               <div class="service-item">

                  <div class="service-icon bg-info">

                     🤝

                  </div>

                  <div class="service-content">

                     <h4>

                        Organisasi Mahasiswa

                     </h4>

                     <p>

                        Pembinaan organisasi kemahasiswaan, Unit Kegiatan
                        Mahasiswa (UKM), serta pengembangan soft skills.

                     </p>

                  </div>

               </div>

               <div class="service-item">

                  <div class="service-icon bg-danger">

                     ❤️

                  </div>

                  <div class="service-content">

                     <h4>

                        Konseling Mahasiswa

                     </h4>

                     <p>

                        Layanan konsultasi akademik maupun non-akademik
                        untuk membantu mahasiswa menghadapi berbagai
                        tantangan selama perkuliahan.

                     </p>

                  </div>

               </div>

               <div class="service-item">

                  <div class="service-icon" style="background:#6A3DA8;">

                     📄

                  </div>

                  <div class="service-content">

                     <h4>

                        Layanan Surat & Dokumen

                     </h4>

                     <p>

                        Pengajuan surat aktif kuliah, surat rekomendasi,
                        surat penelitian, hingga legalisasi dokumen akademik.

                     </p>

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

                     Digital Campus

                  </span>

                  <h2 class="display-5 mb-3">

                     Layanan Digital Terintegrasi

                  </h2>

                  <p class="lead">

                     STIH Graha Kirana menghadirkan berbagai layanan digital
                     untuk mempermudah aktivitas akademik mahasiswa kapan saja
                     dan di mana saja.

                  </p>

               </div>

            </div>

            <div class="row g-4">

               <!-- Portal Akademik -->

               <div class="col-md-6 col-xl-3">

                  <div class="digital-card">

                     <div class="digital-header">

                        <div class="digital-icon">

                           💻

                        </div>

                        <span class="badge bg-soft-success text-success">

                           Online

                        </span>

                     </div>

                     <h4>

                        Portal Akademik

                     </h4>

                     <ul>

                        <li>✔ Pengisian KRS</li>

                        <li>✔ Kartu Hasil Studi</li>

                        <li>✔ Jadwal Kuliah</li>

                        <li>✔ Nilai Semester</li>

                     </ul>

                     <a href="#"
                        class="btn btn-primary rounded-pill btn-sm w-100">

                        Login Portal

                     </a>

                  </div>

               </div>

               <!-- LMS -->

               <div class="col-md-6 col-xl-3">

                  <div class="digital-card">

                     <div class="digital-header">

                        <div class="digital-icon">

                           ☁️

                        </div>

                        <span class="badge bg-soft-primary text-primary">

                           E-Learning

                        </span>

                     </div>

                     <h4>

                        Learning Management

                     </h4>

                     <ul>

                        <li>✔ Materi Kuliah</li>

                        <li>✔ Tugas Online</li>

                        <li>✔ Quiz Digital</li>

                        <li>✔ Forum Diskusi</li>

                     </ul>

                     <a href="#"
                        class="btn btn-primary rounded-pill btn-sm w-100">

                        Masuk LMS

                     </a>

                  </div>

               </div>

               <!-- Mobile -->

               <div class="col-md-6 col-xl-3">

                  <div class="digital-card">

                     <div class="digital-header">

                        <div class="digital-icon">

                           📱

                        </div>

                        <span class="badge bg-soft-warning text-warning">

                           Mobile

                        </span>

                     </div>

                     <h4>

                        Mobile Campus

                     </h4>

                     <ul>

                        <li>✔ Absensi</li>

                        <li>✔ Notifikasi</li>

                        <li>✔ Kalender</li>

                        <li>✔ Pengumuman</li>

                     </ul>

                     <a href="#"
                        class="btn btn-primary rounded-pill btn-sm w-100">

                        Download

                     </a>

                  </div>

               </div>

               <!-- Library -->

               <div class="col-md-6 col-xl-3">

                  <div class="digital-card">

                     <div class="digital-header">

                        <div class="digital-icon">

                           📚

                        </div>

                        <span class="badge bg-soft-danger text-danger">

                           Library

                        </span>

                     </div>

                     <h4>

                        Digital Library

                     </h4>

                     <ul>

                        <li>✔ E-Book</li>

                        <li>✔ Jurnal</li>

                        <li>✔ Repository</li>

                        <li>✔ Skripsi</li>

                     </ul>

                     <a href="#"
                        class="btn btn-primary rounded-pill btn-sm w-100">

                        Explore

                     </a>

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
                     Service Information
                  </span>

                  <h2 class="display-5 mb-3">
                     Jam Operasional & Informasi Layanan
                  </h2>

                  <p class="lead">
                     Seluruh layanan akademik dan administrasi tersedia pada jam
                     operasional kampus untuk memberikan pelayanan terbaik kepada
                     mahasiswa dan masyarakat.
                  </p>

               </div>

            </div>

            <div class="row g-5 align-items-stretch">

               <!-- Jam Operasional -->

               <div class="col-lg-6">

                  <div class="office-card">

                     <h3 class="mb-5">

                        🕒 Jam Operasional

                     </h3>

                     <div class="office-item">

                        <div>

                           <h5>Senin - Jumat</h5>

                           <small>Pelayanan Akademik & Administrasi</small>

                        </div>

                        <strong>08.00 - 16.00</strong>

                     </div>

                     <div class="office-item">

                        <div>

                           <h5>Sabtu</h5>

                           <small>Pelayanan Terbatas</small>

                        </div>

                        <strong>08.00 - 12.00</strong>

                     </div>

                     <div class="office-item">

                        <div>

                           <h5>Minggu</h5>

                           <small>Libur</small>

                        </div>

                        <strong>Tutup</strong>

                     </div>

                     <div class="office-item border-0">

                        <div>

                           <h5>Hari Libur Nasional</h5>

                           <small>Menyesuaikan Kalender Pemerintah</small>

                        </div>

                        <strong>Tutup</strong>

                     </div>

                  </div>

               </div>

               <!-- Informasi -->

               <div class="col-lg-6">

                  <div class="office-card">

                     <h3 class="mb-5">

                        📍 Informasi Kontak

                     </h3>

                     <div class="contact-info">

                        <div class="contact-icon">

                           📍

                        </div>

                        <div>

                           <h6>Alamat</h6>

                           <p>
                              JL. Tasbih 2, Medan
                           </p>

                        </div>

                     </div>

                     <div class="contact-info">

                        <div class="contact-icon">

                           ☎️

                        </div>

                        <div>

                           <h6>Telepon</h6>

                           <p>(061) 8888 9999</p>

                        </div>

                     </div>

                     <div class="contact-info">

                        <div class="contact-icon">

                           ✉️

                        </div>

                        <div>

                           <h6>Email</h6>

                           <p>info@grahakirana.ac.id</p>

                        </div>

                     </div>

                     <div class="contact-info">

                        <div class="contact-icon">

                           💬

                        </div>

                        <div>

                           <h6>WhatsApp</h6>

                           <p>+62 821-6652-4717</p>

                        </div>

                     </div>

                     <div class="d-flex gap-3 mt-4">

                        <a href="#"
                           class="btn btn-primary rounded-pill">

                           Hubungi Kami

                        </a>

                        <a href="#"
                           class="btn btn-outline-primary rounded-pill">

                           Lihat Lokasi

                        </a>

                     </div>

                  </div>

               </div>

            </div>

         </div>
      </section>
      <section class="wrapper image-wrapper bg-image bg-overlay"
         style="background-image:url('./assets/img/campus-tour-bg.jpg');">

         <div class="container py-18 text-center text-white">

            <span class="badge bg-white text-primary rounded-pill mb-4">

               Campus Experience

            </span>

            <h2 class="display-4 text-white mb-4">

               Jelajahi Kampus STIH Graha Kirana

            </h2>

            <p class="lead mb-5">

               Rasakan pengalaman belajar melalui fasilitas modern,
               ruang pembelajaran yang nyaman, serta lingkungan kampus
               yang mendukung pengembangan akademik dan karakter mahasiswa.

            </p>

            <a href="#"
               class="btn btn-lg btn-white rounded-pill">

               <i class="uil uil-play-circle me-2"></i>

               Mulai Virtual Tour

            </a>

         </div>

      </section>
      <section class="wrapper bg-white">
         <div class="container py-15 py-md-17">

            <div class="row text-center mb-10">

               <div class="col-lg-8 mx-auto">

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

                     Gallery

                  </span>

                  <h2 class="display-5 mb-3">

                     Galeri Fasilitas Kampus

                  </h2>

                  <p class="lead">

                     Lihat berbagai fasilitas unggulan yang menunjang
                     proses pembelajaran dan aktivitas mahasiswa.

                  </p>

               </div>

            </div>

            <div class="row g-4">

               <div class="col-md-6 col-lg-4">

                  <div class="gallery-card">

                     <img src="./assets/img/facilities/library.png"
                        class="img-fluid rounded-4">

                     <div class="gallery-overlay">

                        <h5>Perpustakaan</h5>

                     </div>

                  </div>

               </div>

               <div class="col-md-6 col-lg-4">

                  <div class="gallery-card">

                     <img src="./assets/img/facilities/moot-court.png"
                        class="img-fluid rounded-4">

                     <div class="gallery-overlay">

                        <h5>Moot Court</h5>

                     </div>

                  </div>

               </div>

               <div class="col-md-6 col-lg-4">

                  <div class="gallery-card">

                     <img src="./assets/img/facilities/smart-class.png"
                        class="img-fluid rounded-4">

                     <div class="gallery-overlay">

                        <h5>Smart Classroom</h5>

                     </div>

                  </div>

               </div>

               <div class="col-md-6 col-lg-4">

                  <div class="gallery-card">

                     <img src="./assets/img/facilities/computer-lab.png"
                        class="img-fluid rounded-4">

                     <div class="gallery-overlay">

                        <h5>Laboratorium Komputer</h5>

                     </div>

                  </div>

               </div>

               <div class="col-md-6 col-lg-4">

                  <div class="gallery-card">

                     <img src="./assets/img/facilities/lounge.png"
                        class="img-fluid rounded-4">

                     <div class="gallery-overlay">

                        <h5>Student Lounge</h5>

                     </div>

                  </div>

               </div>

               <div class="col-md-6 col-lg-4">

                  <div class="gallery-card">

                     <img src="./assets/img/facilities/hall.png"
                        class="img-fluid rounded-4">

                     <div class="gallery-overlay">

                        <h5>Aula Serbaguna</h5>

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