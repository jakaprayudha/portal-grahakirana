<!DOCTYPE html>
<html lang="en">

<?php
$page = "Home";
require 'head.php';
?>
<style>
  .calendar-info {

    background: #fff;

    padding: 25px;

    border-radius: 20px;

    box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

    transition: .3s;

    height: 100%;

  }

  .calendar-info:hover {

    transform: translateY(-5px);

    box-shadow: 0 20px 40px rgba(106, 61, 168, .12);

  }

  .calendar-info h5 {

    margin-bottom: 8px;

  }

  .calendar-info small {

    color: #666;

  }

  .timeline-wrapper {

    display: flex;

    align-items: flex-start;

    justify-content: space-between;

    gap: 10px;

    overflow-x: auto;

    padding: 20px 0;

  }

  .timeline-step {

    min-width: 190px;

    text-align: center;

  }

  .timeline-circle {

    width: 90px;

    height: 90px;

    margin: auto;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 40px;

    color: #fff;

    box-shadow: 0 15px 35px rgba(0, 0, 0, .12);

    transition: .35s;

  }

  .timeline-circle:hover {

    transform: translateY(-8px);

  }

  .timeline-month {

    display: inline-block;

    margin-top: 18px;

    margin-bottom: 10px;

    padding: 5px 18px;

    background: #F3EEFD;

    border-radius: 30px;

    font-weight: 700;

    color: #6A3DA8;

  }

  .timeline-step h5 {

    margin-bottom: 10px;

  }

  .timeline-step p {

    font-size: 14px;

    color: #666;

    margin: 0;

  }

  .timeline-line {

    flex: 1;

    height: 5px;

    background: #D8CCF3;

    margin-top: 45px;

    min-width: 60px;

    border-radius: 50px;

  }

  .month-card {

    background: #fff;

    border-radius: 22px;

    padding: 25px;

    height: 100%;

    transition: .35s;

    border: 1px solid #ececec;

    box-shadow: 0 10px 25px rgba(0, 0, 0, .05);

  }

  .month-card:hover {

    transform: translateY(-8px);

    box-shadow: 0 20px 45px rgba(106, 61, 168, .15);

  }

  .month-header {

    background: #6A3DA8;

    color: #fff;

    padding: 12px 18px;

    border-radius: 14px;

    font-weight: 700;

    text-align: center;

    margin-bottom: 20px;

    font-size: 18px;

  }

  .month-list {

    list-style: none;

    padding: 0;

    margin: 0;

  }

  .month-list li {

    padding: 10px 0;

    border-bottom: 1px dashed #E5E5E5;

    font-size: 14px;

    color: #555;

    display: flex;

    align-items: center;

    gap: 10px;

  }

  .month-list li:last-child {

    border-bottom: none;

  }

  .month-list i {

    color: #6A3DA8;

    font-size: 18px;

  }

  .document-card {

    background: #fff;

    border-radius: 22px;

    padding: 35px;

    height: 100%;

    text-align: center;

    transition: .35s;

    border: 1px solid #ECECEC;

    box-shadow: 0 15px 35px rgba(0, 0, 0, .05);

  }

  .document-card:hover {

    transform: translateY(-8px);

    box-shadow: 0 20px 45px rgba(106, 61, 168, .15);

  }

  .document-icon {

    width: 90px;

    height: 90px;

    margin: auto;

    margin-bottom: 20px;

    border-radius: 24px;

    background: #F3EEFD;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 42px;

    transition: .3s;

  }

  .document-card:hover .document-icon {

    background: #6A3DA8;

    color: #fff;

    transform: rotate(8deg);

  }

  .document-card h4 {

    margin-bottom: 15px;

  }

  .document-card p {

    min-height: 75px;

    color: #666;

  }

  .announcement-card {

    display: flex;

    gap: 25px;

    background: #fff;

    padding: 28px;

    border-radius: 22px;

    box-shadow: 0 12px 35px rgba(0, 0, 0, .06);

    transition: .35s;

    height: 100%;

  }

  .announcement-card:hover {

    transform: translateY(-8px);

    box-shadow: 0 20px 45px rgba(106, 61, 168, .15);

  }

  .announcement-date {

    width: 90px;

    height: 90px;

    border-radius: 18px;

    background: #6A3DA8;

    display: flex;

    flex-direction: column;

    align-items: center;

    justify-content: center;

    color: #fff;

    flex-shrink: 0;

  }

  .announcement-date .day {

    font-size: 32px;

    font-weight: 700;

    line-height: 1;

  }

  .announcement-date .month {

    font-size: 14px;

    letter-spacing: 1px;

  }

  .announcement-content h4 {

    margin-bottom: 10px;

  }

  .announcement-content p {

    margin-bottom: 0;

    color: #666;

  }

  .guide-card {

    display: flex;

    gap: 20px;

    align-items: flex-start;

    background: #fff;

    padding: 28px;

    border-radius: 22px;

    height: 100%;

    transition: .35s;

    border: 1px solid #ECECEC;

    box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

  }

  .guide-card:hover {

    transform: translateY(-8px);

    box-shadow: 0 20px 45px rgba(106, 61, 168, .15);

  }

  .guide-color {

    width: 22px;

    height: 22px;

    border-radius: 50%;

    margin-top: 5px;

    flex-shrink: 0;

  }

  .guide-card h5 {

    margin-bottom: 10px;

  }

  .guide-card p {

    margin: 0;

    color: #666;

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
              Academic Calendar
            </span>

            <h2 class="display-4 mb-4">
              Kalender Akademik
              Tahun Akademik 2026 / 2027
            </h2>

            <p class="lead mb-5">
              Kalender akademik menjadi pedoman pelaksanaan seluruh kegiatan
              pendidikan mulai dari registrasi mahasiswa, perkuliahan,
              evaluasi pembelajaran, hingga wisuda.
            </p>

            <div class="row g-4">

              <div class="col-6">

                <div class="calendar-info">

                  <h5>📚 Semester Ganjil</h5>

                  <small>
                    Juli 2026 – Januari 2027
                  </small>

                </div>

              </div>

              <div class="col-6">

                <div class="calendar-info">

                  <h5>🎓 Semester Genap</h5>

                  <small>
                    Februari – Juli 2027
                  </small>

                </div>

              </div>

            </div>

            <div class="mt-5">

              <a href="#"
                class="btn btn-primary rounded-pill me-3">

                📄 Download PDF

              </a>

              <a href="#"
                class="btn btn-outline-primary rounded-pill">

                🗓️ Lihat Agenda

              </a>

            </div>

          </div>

          <!-- RIGHT -->

          <div class="col-lg-6">

            <img src="./assets/img/academic-calendar.png"
              class="img-fluid rounded-4 shadow-lg"
              alt="Kalender Akademik">

          </div>

        </div>

      </div>
    </section>
    <section class="wrapper bg-white">
      <div class="container py-15 py-md-17">

        <div class="row text-center mb-12">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Academic Timeline
            </span>

            <h2 class="display-5 mb-3">
              Alur Tahun Akademik
            </h2>

            <p class="lead">
              Kalender akademik dirancang untuk memastikan seluruh aktivitas
              pendidikan berjalan secara terstruktur mulai dari registrasi
              hingga wisuda.
            </p>

          </div>

        </div>

        <div class="timeline-wrapper">

          <!-- STEP 1 -->

          <div class="timeline-step">

            <div class="timeline-circle bg-success">
              📝
            </div>

            <span class="timeline-month">
              JUL
            </span>

            <h5>
              Registrasi
            </h5>

            <p>
              Registrasi mahasiswa baru dan daftar ulang mahasiswa aktif.
            </p>

          </div>

          <div class="timeline-line"></div>

          <!-- STEP 2 -->

          <div class="timeline-step">

            <div class="timeline-circle bg-info">
              🎓
            </div>

            <span class="timeline-month">
              AGU
            </span>

            <h5>
              PKKMB
            </h5>

            <p>
              Pengenalan kehidupan kampus dan orientasi mahasiswa baru.
            </p>

          </div>

          <div class="timeline-line"></div>

          <!-- STEP 3 -->

          <div class="timeline-step">

            <div class="timeline-circle bg-primary">
              📚
            </div>

            <span class="timeline-month">
              SEP
            </span>

            <h5>
              Perkuliahan
            </h5>

            <p>
              Pelaksanaan proses belajar mengajar semester berjalan.
            </p>

          </div>

          <div class="timeline-line"></div>

          <!-- STEP 4 -->

          <div class="timeline-step">

            <div class="timeline-circle bg-warning">
              📖
            </div>

            <span class="timeline-month">
              OKT
            </span>

            <h5>
              UTS
            </h5>

            <p>
              Evaluasi pembelajaran melalui Ujian Tengah Semester.
            </p>

          </div>

          <div class="timeline-line"></div>

          <!-- STEP 5 -->

          <div class="timeline-step">

            <div class="timeline-circle bg-danger">
              📝
            </div>

            <span class="timeline-month">
              DES
            </span>

            <h5>
              UAS
            </h5>

            <p>
              Ujian Akhir Semester dan penyelesaian seluruh perkuliahan.
            </p>

          </div>

          <div class="timeline-line"></div>

          <!-- STEP 6 -->

          <div class="timeline-step">

            <div class="timeline-circle" style="background:#6A3DA8;">
              🎉
            </div>

            <span class="timeline-month">
              JAN
            </span>

            <h5>
              Wisuda
            </h5>

            <p>
              Yudisium, pelantikan lulusan, dan prosesi wisuda.
            </p>

          </div>

        </div>

      </div>
    </section>
    <section class="wrapper bg-light">
      <div class="container py-15 py-md-17">

        <!-- Heading -->

        <div class="row text-center mb-12">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Monthly Calendar
            </span>

            <h2 class="display-5 mb-3">
              Agenda Akademik Bulanan
            </h2>

            <p class="lead">
              Setiap bulan memiliki agenda akademik yang telah disusun
              untuk mendukung kelancaran proses pendidikan di
              STIH Graha Kirana.
            </p>

          </div>

        </div>

        <div class="row g-4">

          <?php

          $bulan = [

            "Januari" => ["Yudisium", "Wisuda", "Libur Semester"],
            "Februari" => ["Registrasi", "Pengisian KRS", "Awal Kuliah"],
            "Maret" => ["Perkuliahan", "Seminar", "Praktikum"],
            "April" => ["UTS", "Evaluasi", "Bimbingan Akademik"],
            "Mei" => ["Perkuliahan", "Pengabdian", "Penelitian"],
            "Juni" => ["UAS", "Sidang Skripsi", "Yudisium"],
            "Juli" => ["Registrasi", "PKKMB", "Pembayaran UKT"],
            "Agustus" => ["Perkuliahan", "Seminar", "Organisasi"],
            "September" => ["Praktikum", "Kompetisi", "Penelitian"],
            "Oktober" => ["UTS", "Monitoring", "Evaluasi"],
            "November" => ["Perkuliahan", "Magang", "Publikasi"],
            "Desember" => ["UAS", "Yudisium", "Libur Semester"]

          ];

          foreach ($bulan as $nama => $agenda) {

          ?>

            <div class="col-md-6 col-lg-4 col-xl-3">

              <div class="month-card">

                <div class="month-header">

                  📅 <?= $nama ?>

                </div>

                <ul class="month-list">

                  <?php foreach ($agenda as $item) { ?>

                    <li>

                      <i class="uil uil-check-circle"></i>

                      <?= $item ?>

                    </li>

                  <?php } ?>

                </ul>

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
              Download Center
            </span>

            <h2 class="display-5 mb-3">
              Dokumen Kalender Akademik
            </h2>

            <p class="lead">
              Unduh kalender akademik dan berbagai dokumen pendukung
              untuk membantu Anda merencanakan seluruh kegiatan akademik.
            </p>

          </div>

        </div>

        <div class="row g-4">

          <!-- 1 -->

          <div class="col-md-6 col-xl-3">

            <div class="document-card">

              <div class="document-icon">
                📄
              </div>

              <span class="badge bg-soft-success text-success mb-3">
                PDF
              </span>

              <h4>Semester Ganjil</h4>

              <p>
                Kalender Akademik Semester Ganjil Tahun Akademik
                2026/2027.
              </p>

              <hr>

              <a href="#"
                class="btn btn-primary rounded-pill btn-sm w-100">

                Download PDF

              </a>

            </div>

          </div>

          <!-- 2 -->

          <div class="col-md-6 col-xl-3">

            <div class="document-card">

              <div class="document-icon">
                📘
              </div>

              <span class="badge bg-soft-info text-info mb-3">
                PDF
              </span>

              <h4>Semester Genap</h4>

              <p>
                Kalender Akademik Semester Genap Tahun Akademik
                2026/2027.
              </p>

              <hr>

              <a href="#"
                class="btn btn-primary rounded-pill btn-sm w-100">

                Download PDF

              </a>

            </div>

          </div>

          <!-- 3 -->

          <div class="col-md-6 col-xl-3">

            <div class="document-card">

              <div class="document-icon">
                🗓️
              </div>

              <span class="badge bg-soft-warning text-warning mb-3">
                XLS
              </span>

              <h4>Agenda Akademik</h4>

              <p>
                Jadwal lengkap seluruh kegiatan akademik selama satu tahun.
              </p>

              <hr>

              <a href="#"
                class="btn btn-primary rounded-pill btn-sm w-100">

                Download

              </a>

            </div>

          </div>

          <!-- 4 -->

          <div class="col-md-6 col-xl-3">

            <div class="document-card">

              <div class="document-icon">
                🎓
              </div>

              <span class="badge bg-soft-danger text-danger mb-3">
                PDF
              </span>

              <h4>Jadwal Wisuda</h4>

              <p>
                Informasi pelaksanaan yudisium dan wisuda mahasiswa.
              </p>

              <hr>

              <a href="#"
                class="btn btn-primary rounded-pill btn-sm w-100">

                Download

              </a>

            </div>

          </div>

        </div>

      </div>
    </section>
    <section class="wrapper bg-soft-primary">
      <div class="container py-15 py-md-17">

        <div class="row text-center mb-12">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-primary text-white rounded-pill mb-3">
              Academic Announcement
            </span>

            <h2 class="display-5 mb-3">
              Agenda & Pengumuman Akademik
            </h2>

            <p class="lead">
              Informasi terbaru mengenai jadwal kegiatan akademik,
              pengumuman penting, seminar, hingga pelaksanaan ujian.
            </p>

          </div>

        </div>

        <div class="row g-4">

          <!-- Item -->

          <div class="col-lg-6">

            <div class="announcement-card">

              <div class="announcement-date">

                <span class="day">15</span>

                <span class="month">JUL</span>

              </div>

              <div class="announcement-content">

                <span class="badge bg-soft-success text-success mb-2">

                  Registrasi

                </span>

                <h4>

                  Registrasi Mahasiswa Baru

                </h4>

                <p>

                  Registrasi dan daftar ulang mahasiswa
                  Tahun Akademik 2026/2027.

                </p>

              </div>

            </div>

          </div>

          <div class="col-lg-6">

            <div class="announcement-card">

              <div class="announcement-date">

                <span class="day">01</span>

                <span class="month">AGU</span>

              </div>

              <div class="announcement-content">

                <span class="badge bg-soft-primary text-primary mb-2">

                  Perkuliahan

                </span>

                <h4>

                  Awal Perkuliahan Semester Ganjil

                </h4>

                <p>

                  Seluruh mahasiswa mulai mengikuti
                  kegiatan pembelajaran semester baru.

                </p>

              </div>

            </div>

          </div>

          <div class="col-lg-6">

            <div class="announcement-card">

              <div class="announcement-date">

                <span class="day">10</span>

                <span class="month">OKT</span>

              </div>

              <div class="announcement-content">

                <span class="badge bg-soft-warning text-warning mb-2">

                  Ujian

                </span>

                <h4>

                  Ujian Tengah Semester

                </h4>

                <p>

                  Pelaksanaan UTS sesuai jadwal
                  masing-masing mata kuliah.

                </p>

              </div>

            </div>

          </div>

          <div class="col-lg-6">

            <div class="announcement-card">

              <div class="announcement-date">

                <span class="day">20</span>

                <span class="month">JAN</span>

              </div>

              <div class="announcement-content">

                <span class="badge bg-soft-danger text-danger mb-2">

                  Wisuda

                </span>

                <h4>

                  Wisuda Semester Ganjil

                </h4>

                <p>

                  Prosesi wisuda bagi mahasiswa
                  yang telah memenuhi seluruh persyaratan.

                </p>

              </div>

            </div>

          </div>

        </div>

      </div>
    </section>
    <section class="wrapper bg-white">
      <div class="container py-15 py-md-17">

        <div class="row mb-10">

          <div class="col-lg-8 mx-auto text-center">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Calendar Guide
            </span>

            <h2 class="display-5 mb-3">
              Panduan Kategori Agenda
            </h2>

            <p class="lead">
              Setiap kegiatan akademik memiliki kategori yang berbeda sehingga
              mahasiswa dapat dengan mudah mengenali jenis kegiatan yang akan
              dilaksanakan selama satu tahun akademik.
            </p>

          </div>

        </div>

        <div class="row g-4">

          <div class="col-md-6 col-xl-4">

            <div class="guide-card">

              <div class="guide-color bg-success"></div>

              <div>

                <h5>Registrasi & Administrasi</h5>

                <p>
                  Registrasi mahasiswa baru, daftar ulang, pembayaran UKT,
                  dan pengisian KRS.
                </p>

              </div>

            </div>

          </div>

          <div class="col-md-6 col-xl-4">

            <div class="guide-card">

              <div class="guide-color bg-primary"></div>

              <div>

                <h5>Perkuliahan</h5>

                <p>
                  Jadwal perkuliahan, praktikum, seminar,
                  dan aktivitas pembelajaran.
                </p>

              </div>

            </div>

          </div>

          <div class="col-md-6 col-xl-4">

            <div class="guide-card">

              <div class="guide-color bg-warning"></div>

              <div>

                <h5>Evaluasi Akademik</h5>

                <p>
                  Quiz, UTS, UAS,
                  sidang skripsi, dan seminar hasil.
                </p>

              </div>

            </div>

          </div>

          <div class="col-md-6 col-xl-4">

            <div class="guide-card">

              <div class="guide-color bg-info"></div>

              <div>

                <h5>Kegiatan Mahasiswa</h5>

                <p>
                  PKKMB, organisasi mahasiswa,
                  kompetisi, dan kegiatan kemahasiswaan.
                </p>

              </div>

            </div>

          </div>

          <div class="col-md-6 col-xl-4">

            <div class="guide-card">

              <div class="guide-color bg-danger"></div>

              <div>

                <h5>Kelulusan</h5>

                <p>
                  Yudisium, wisuda,
                  penerbitan ijazah, dan transkrip.
                </p>

              </div>

            </div>

          </div>

          <div class="col-md-6 col-xl-4">

            <div class="guide-card">

              <div class="guide-color" style="background:#6A3DA8;"></div>

              <div>

                <h5>Libur Akademik</h5>

                <p>
                  Libur nasional, cuti bersama,
                  dan libur semester.
                </p>

              </div>

            </div>

          </div>

        </div>

      </div>
    </section>
    <section class="wrapper bg-primary">

      <div class="container py-16 py-md-18">

        <div class="row">

          <div class="col-lg-8 mx-auto text-center">


            <h2 class="display-4 text-white mt-4 mb-4">

              Rencanakan Semester Anda
              Bersama Kalender Akademik

            </h2>

            <p class="lead text-white mb-5">

              Jangan lewatkan setiap agenda penting mulai dari registrasi,
              perkuliahan, ujian, hingga wisuda. Seluruh informasi akademik
              tersedia untuk membantu Anda merencanakan studi dengan lebih baik.

            </p>

            <div class="d-flex justify-content-center flex-wrap gap-3">

              <a href="#"
                class="btn btn-white rounded-pill btn-lg">

                📄 Download Kalender

              </a>

              <a href="#"
                class="btn btn-outline-white rounded-pill btn-lg">

                🎓 Portal Akademik

              </a>

            </div>

          </div>

        </div>

      </div>

    </section>
    <section class="wrapper bg-light">
      <div class="container py-15 py-md-17">

        <div class="row mb-10">

          <div class="col-lg-8 mx-auto text-center">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Frequently Asked Questions
            </span>

            <h2 class="display-5 mb-3">
              Pertanyaan yang Sering Diajukan
            </h2>

            <p class="lead">
              Berikut beberapa pertanyaan yang sering diajukan terkait
              kalender akademik STIH Graha Kirana.
            </p>

          </div>

        </div>

        <div class="row">

          <div class="col-lg-10 mx-auto">

            <div class="accordion accordion-wrapper" id="faqCalendar">

              <!-- FAQ 1 -->

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq1">

                    Bagaimana cara memperoleh Kalender Akademik terbaru?

                  </button>

                </div>

                <div id="faq1"
                  class="accordion-collapse collapse show"
                  data-bs-parent="#faqCalendar">

                  <div class="card-body">

                    Kalender Akademik dapat diunduh melalui halaman ini
                    atau melalui Portal Akademik STIH Graha Kirana.

                  </div>

                </div>

              </div>

              <!-- FAQ 2 -->

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq2">

                    Apakah jadwal akademik dapat berubah?

                  </button>

                </div>

                <div id="faq2"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqCalendar">

                  <div class="card-body">

                    Ya. Perubahan jadwal akan diumumkan secara resmi
                    melalui website dan Portal Akademik apabila
                    terdapat kebijakan baru.

                  </div>

                </div>

              </div>

              <!-- FAQ 3 -->

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq3">

                    Kapan pengisian KRS dilaksanakan?

                  </button>

                </div>

                <div id="faq3"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqCalendar">

                  <div class="card-body">

                    Jadwal pengisian KRS mengikuti Kalender Akademik
                    dan diumumkan sebelum awal semester dimulai.

                  </div>

                </div>

              </div>

              <!-- FAQ 4 -->

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq4">

                    Bagaimana mengetahui jadwal UTS dan UAS?

                  </button>

                </div>

                <div id="faq4"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqCalendar">

                  <div class="card-body">

                    Jadwal UTS dan UAS akan diumumkan melalui
                    Kalender Akademik serta Portal Akademik
                    sebelum pelaksanaan ujian.

                  </div>

                </div>

              </div>

              <!-- FAQ 5 -->

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq5">

                    Kapan pelaksanaan Wisuda?

                  </button>

                </div>

                <div id="faq5"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqCalendar">

                  <div class="card-body">

                    Jadwal wisuda ditetapkan setiap tahun akademik
                    dan diumumkan melalui Kalender Akademik
                    serta pengumuman resmi kampus.

                  </div>

                </div>

              </div>

              <!-- FAQ 6 -->

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq6">

                    Bagaimana jika saya melewatkan jadwal registrasi?

                  </button>

                </div>

                <div id="faq6"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqCalendar">

                  <div class="card-body">

                    Mahasiswa disarankan segera menghubungi Bagian
                    Akademik untuk memperoleh informasi mengenai
                    prosedur registrasi susulan apabila tersedia.

                  </div>

                </div>

              </div>

              <!-- FAQ 7 -->

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq7">

                    Siapa yang dapat dihubungi jika memiliki pertanyaan?

                  </button>

                </div>

                <div id="faq7"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqCalendar">

                  <div class="card-body">

                    Silakan menghubungi Bagian Akademik melalui
                    telepon, email, atau datang langsung ke kampus
                    pada jam kerja.

                  </div>

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