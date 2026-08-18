<!DOCTYPE html>
<html lang="en">

<?php
$page = "Home";
require 'head.php';
?>
<style>
  .research-summary {

    background: rgba(255, 255, 255, .96);

    padding: 40px;

    border-radius: 28px;

    box-shadow: 0 20px 45px rgba(0, 0, 0, .15);

    color: #333;

  }

  .research-icon {

    width: 95px;

    height: 95px;

    margin: auto;

    margin-bottom: 25px;

    border-radius: 24px;

    background: #EEF3FF;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 46px;

  }

  .research-summary h3 {

    text-align: center;

    margin-bottom: 15px;

  }

  .research-summary p {

    text-align: center;

    color: #666;

    margin-bottom: 25px;

    line-height: 1.8;

  }

  .featured-research {

    position: relative;

    overflow: hidden;

    border-radius: 24px;

    height: 600px;

    box-shadow: 0 20px 45px rgba(0, 0, 0, .12);

  }

  .featured-research img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    transition: .45s;

  }

  .featured-research:hover img {

    transform: scale(1.08);

  }

  .featured-overlay {

    position: absolute;

    left: 0;

    right: 0;

    bottom: 0;

    padding: 50px;

    background: linear-gradient(to top,
        rgba(0, 0, 0, .92),
        rgba(0, 0, 0, .5),
        transparent);

    color: #fff;

  }

  .featured-overlay h2 {

    color: #fff;

    margin: 20px 0;

    line-height: 1.4;

  }

  .featured-overlay p {

    color: rgba(255, 255, 255, .9);

    margin-bottom: 25px;

  }

  .research-sidebar {

    background: #fff;

    padding: 35px;

    border-radius: 24px;

    box-shadow: 0 15px 35px rgba(0, 0, 0, .06);

    height: 100%;

  }

  .popular-research {

    display: flex;

    gap: 18px;

    padding: 18px 0;

    border-bottom: 1px dashed #ddd;

    align-items: flex-start;

  }

  .popular-research:last-child {

    border-bottom: none;

  }

  .popular-number {

    width: 42px;

    height: 42px;

    border-radius: 50%;

    background: #6A3DA8;

    color: #fff;

    display: flex;

    align-items: center;

    justify-content: center;

    font-weight: 700;

    flex-shrink: 0;

  }

  .popular-research small {

    display: block;

    color: #6A3DA8;

    font-weight: 600;

    margin-bottom: 4px;

  }

  .popular-research h6 {

    margin: 0;

    line-height: 1.5;

  }

  /* ===========================================
   RESEARCH NEWS FILTER
=========================================== */

  .news-filter {

    display: flex;

    flex-wrap: wrap;

    gap: 12px;

  }

  .news-filter button {

    border: none;

    background: #F3F4F8;

    padding: 10px 22px;

    border-radius: 50px;

    font-weight: 600;

    transition: .3s;

    cursor: pointer;

  }

  .news-filter button.active,
  .news-filter button:hover {

    background: #6A3DA8;

    color: #fff;

  }


  /* ===========================================
   RESEARCH NEWS CARD
=========================================== */

  .news-card {

    background: #fff;

    border-radius: 24px;

    overflow: hidden;

    height: 100%;

    border: 1px solid #EEF2F7;

    box-shadow: 0 15px 35px rgba(0, 0, 0, .06);

    transition: .35s;

    display: flex;

    flex-direction: column;

  }

  .news-card:hover {

    transform: translateY(-8px);

    box-shadow: 0 25px 50px rgba(106, 61, 168, .15);

  }


  /* ===========================================
   IMAGE
=========================================== */

  .news-image {

    position: relative;

    height: 240px;

    overflow: hidden;

  }

  .news-image img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    transition: .4s;

  }

  .news-card:hover .news-image img {

    transform: scale(1.08);

  }


  /* ===========================================
   CATEGORY
=========================================== */

  .news-category {

    position: absolute;

    top: 18px;

    left: 18px;

    background: #6A3DA8;

    color: #fff;

    padding: 8px 18px;

    border-radius: 50px;

    font-size: 13px;

    font-weight: 600;

  }


  /* ===========================================
   BODY
=========================================== */

  .news-body {

    padding: 28px;

    display: flex;

    flex-direction: column;

    flex: 1;

  }

  .news-body small {

    display: block;

    color: #888;

    margin-bottom: 14px;

    font-size: 14px;

  }

  .news-body h4 {

    font-size: 22px;

    line-height: 1.5;

    margin-bottom: 15px;

  }

  .news-body p {

    color: #666;

    line-height: 1.8;

    margin-bottom: 25px;

    flex: 1;

  }

  .news-body a {

    font-weight: 600;

    color: #6A3DA8;

    text-decoration: none;

    transition: .3s;

  }

  .news-body a:hover {

    color: #4B2C82;

  }

  .news-body a i {

    margin-left: 6px;

    transition: .3s;

  }

  .news-body a:hover i {

    transform: translateX(5px);

  }


  /* ===========================================
   RESPONSIVE
=========================================== */

  @media(max-width:768px) {

    .news-filter {

      justify-content: center;

    }

    .news-body {

      padding: 22px;

    }

    .news-body h4 {

      font-size: 20px;

    }

    .news-image {

      height: 220px;

    }

  }

  /* ==========================================
   RESEARCH FUNDING
========================================== */

  .funding-timeline {

    position: relative;

    padding-left: 20px;

  }


  /* Vertical line */

  .funding-timeline::before {

    content: "";

    position: absolute;

    left: 54px;

    top: 35px;

    bottom: 35px;

    width: 2px;

    background: #E4D9F7;

  }


  /* Item */

  .funding-item {

    position: relative;

    display: flex;

    gap: 25px;

    margin-bottom: 35px;

  }

  .funding-item:last-child {

    margin-bottom: 0;

  }


  /* Icon */

  .funding-icon {

    width: 70px;

    height: 70px;

    border-radius: 20px;

    background: #F0EAFB;

    color: #6A3DA8;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 28px;

    flex-shrink: 0;

    position: relative;

    z-index: 2;

    transition: .35s;

  }

  .funding-item:hover .funding-icon {

    background: #6A3DA8;

    color: #fff;

    transform: scale(1.08);

  }


  /* Content */

  .funding-content {

    padding-top: 3px;

  }

  .funding-content span {

    font-size: 13px;

    font-weight: 700;

    color: #6A3DA8;

    text-transform: uppercase;

    letter-spacing: .5px;

  }

  .funding-content h4 {

    margin: 6px 0 8px;

    font-weight: 700;

  }

  .funding-content p {

    margin: 0;

    color: #666;

    line-height: 1.7;

  }


  /* ==========================================
   STATISTIC CARD
========================================== */

  .funding-stat-card {

    background: #F8F6FC;

    border: 1px solid #ECE6F6;

    border-radius: 28px;

    padding: 35px;

    box-shadow: 0 18px 40px rgba(0, 0, 0, .06);

  }

  .funding-stat-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

  }

  .funding-stat-header>i {

    font-size: 32px;

    color: #6A3DA8;

  }


  .funding-stat-card h3 {

    font-weight: 700;

  }

  .funding-stat-card>p {

    color: #666;

    line-height: 1.7;

    margin-bottom: 25px;

  }


  /* Stats */

  .funding-stat {

    display: flex;

    align-items: center;

    justify-content: space-between;

    background: #fff;

    padding: 18px 20px;

    border-radius: 18px;

    margin-bottom: 12px;

    border: 1px solid #EEF2F7;

    transition: .3s;

  }

  .funding-stat:hover {

    transform: translateX(5px);

    box-shadow: 0 10px 25px rgba(106, 61, 168, .08);

  }

  .funding-stat div {

    display: flex;

    flex-direction: column;

  }

  .funding-stat strong {

    font-size: 25px;

    color: #6A3DA8;

    line-height: 1.2;

  }

  .funding-stat span {

    font-size: 13px;

    color: #777;

    margin-top: 3px;

  }

  .funding-stat>i {

    font-size: 24px;

    color: #6A3DA8;

  }


  /* ==========================================
   RESPONSIVE
========================================== */

  @media(max-width:767px) {

    .funding-timeline {

      padding-left: 0;

    }

    .funding-timeline::before {

      left: 35px;

    }

    .funding-item {

      gap: 18px;

    }

    .funding-icon {

      width: 55px;

      height: 55px;

      border-radius: 16px;

      font-size: 23px;

    }

    .funding-content h4 {

      font-size: 18px;

    }

    .funding-content p {

      font-size: 14px;

    }

    .funding-stat-card {

      padding: 25px;

    }

  }

  /* ==========================================
   RESEARCH OUTPUT
========================================== */

  .research-output-card {

    background: #fff;

    padding: 30px;

    border-radius: 24px;

    height: 100%;

    border: 1px solid #EEF2F7;

    box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

    transition: .35s;

    display: flex;

    flex-direction: column;

  }

  .research-output-card:hover {

    transform: translateY(-8px);

    box-shadow: 0 25px 50px rgba(106, 61, 168, .14);

    border-color: #DCCCF2;

  }


  /* Top */

  .research-output-top {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 25px;

  }


  /* Icon */

  .research-output-icon {

    width: 70px;

    height: 70px;

    border-radius: 20px;

    background: #F0EAFB;

    color: #6A3DA8;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 30px;

    transition: .35s;

  }

  .research-output-card:hover .research-output-icon {

    background: #6A3DA8;

    color: #fff;

    transform: scale(1.08);

  }


  /* Counter */

  .research-output-top strong {

    font-size: 28px;

    color: #6A3DA8;

  }


  /* Content */

  .research-output-card h4 {

    font-weight: 700;

    margin-bottom: 12px;

  }

  .research-output-card p {

    color: #666;

    line-height: 1.8;

    margin-bottom: 25px;

    flex: 1;

  }


  /* Link */

  .research-output-link {

    font-weight: 600;

    color: #6A3DA8;

    text-decoration: none;

  }

  .research-output-link i {

    margin-left: 5px;

    transition: .3s;

  }

  .research-output-link:hover i {

    transform: translateX(5px);

  }


  /* ==========================================
   PUBLICATION CTA
========================================== */

  .publication-cta {

    background: #F8F6FC;

    border: 1px solid #E9E0F5;

    border-radius: 28px;

    padding: 35px 40px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 30px;

  }

  .publication-cta h3 {

    margin-bottom: 8px;

    font-weight: 700;

  }

  .publication-cta p {

    margin: 0;

    color: #666;

  }


  /* ==========================================
   RESPONSIVE
========================================== */

  @media(max-width:767px) {

    .publication-cta {

      flex-direction: column;

      align-items: flex-start;

      padding: 30px;

    }

    .research-output-card {

      padding: 25px;

    }

  }

  /* ==========================================
   RESEARCH EVENTS
========================================== */

  .research-event-card {

    background: #fff;

    border: 1px solid #EEF2F7;

    border-radius: 24px;

    overflow: hidden;

    height: 100%;

    box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

    transition: .35s;

    display: flex;

    flex-direction: column;

  }

  .research-event-card:hover {

    transform: translateY(-8px);

    box-shadow: 0 25px 50px rgba(106, 61, 168, .14);

  }


  /* Image */

  .research-event-image {

    height: 210px;

    position: relative;

    overflow: hidden;

  }

  .research-event-image img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    transition: .45s;

  }

  .research-event-card:hover .research-event-image img {

    transform: scale(1.08);

  }

  .research-event-image span {

    position: absolute;

    top: 16px;

    left: 16px;

    background: #6A3DA8;

    color: #fff;

    padding: 7px 15px;

    border-radius: 50px;

    font-size: 12px;

    font-weight: 600;

  }


  /* Body */

  .research-event-body {

    padding: 25px;

    display: flex;

    flex-direction: column;

    flex: 1;

  }

  .research-event-body small {

    color: #888;

    margin-bottom: 12px;

  }

  .research-event-body h4 {

    font-size: 20px;

    font-weight: 700;

    line-height: 1.4;

    margin-bottom: 8px;

  }

  .research-event-body h6 {

    color: #6A3DA8;

    line-height: 1.5;

    margin-bottom: 12px;

  }

  .research-event-body p {

    color: #666;

    font-size: 14px;

    line-height: 1.7;

    flex: 1;

  }

  .research-event-link {

    color: #6A3DA8;

    font-weight: 600;

    text-decoration: none;

    margin-top: 15px;

  }

  .research-event-link i {

    margin-left: 5px;

    transition: .3s;

  }

  .research-event-link:hover i {

    transform: translateX(5px);

  }


  /* ==========================================
   BOTTOM CTA
========================================== */

  .research-event-bottom {

    display: flex;

    align-items: center;

    gap: 25px;

    padding: 30px 35px;

    background: #F8F6FC;

    border: 1px solid #E9E0F5;

    border-radius: 25px;

  }

  .research-event-bottom-icon {

    width: 70px;

    height: 70px;

    border-radius: 20px;

    background: #6A3DA8;

    color: #fff;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 30px;

  }

  .research-event-bottom span {

    font-size: 13px;

    font-weight: 700;

    color: #6A3DA8;

    text-transform: uppercase;

    letter-spacing: .5px;

  }

  .research-event-bottom h3 {

    margin: 5px 0 8px;

    font-weight: 700;

  }

  .research-event-bottom p {

    margin: 0;

    color: #666;

  }


  /* ==========================================
   RESPONSIVE
========================================== */

  @media(max-width:767px) {

    .research-event-bottom {

      flex-direction: column;

      align-items: flex-start;

      padding: 25px;

    }

    .research-event-bottom .btn {

      width: 100%;

      text-align: center;

    }

  }

  /* ==========================================
   RESEARCH GALLERY
========================================== */

  .research-gallery {

    display: grid;

    grid-template-columns: 2fr 1fr 1fr;

    grid-template-rows: 260px 260px 220px;

    gap: 18px;

  }


  /* Gallery item */

  .research-gallery-item {

    position: relative;

    overflow: hidden;

    border-radius: 24px;

    cursor: pointer;

    background: #ddd;

  }

  .research-gallery-item img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    transition: .5s;

  }

  .research-gallery-item:hover img {

    transform: scale(1.08);

  }


  /* Large */

  .gallery-large {

    grid-row: span 2;

  }


  /* Overlay */

  .research-gallery-overlay {

    position: absolute;

    left: 0;

    right: 0;

    bottom: 0;

    padding: 28px;

    color: #fff;

    background: linear-gradient(to top,
        rgba(0, 0, 0, .85),
        rgba(0, 0, 0, .15),
        transparent);

    transform: translateY(10px);

    transition: .35s;

  }

  .research-gallery-item:hover .research-gallery-overlay {

    transform: translateY(0);

  }

  .research-gallery-overlay span {

    display: inline-block;

    font-size: 12px;

    font-weight: 600;

    background: #6A3DA8;

    padding: 6px 13px;

    border-radius: 50px;

    margin-bottom: 8px;

  }

  .research-gallery-overlay h4,
  .research-gallery-overlay h5 {

    color: #fff;

    margin: 5px 0;

  }

  .research-gallery-overlay small {

    opacity: .9;

  }


  /* ==========================================
   RESPONSIVE
========================================== */

  @media(max-width:991px) {

    .research-gallery {

      grid-template-columns: 1fr 1fr;

      grid-template-rows: 300px 220px 220px 220px;

    }

    .gallery-large {

      grid-column: span 2;

      grid-row: auto;

    }

    .gallery-top {

      grid-column: span 1;

    }

    .gallery-middle {

      grid-column: span 1;

    }

    .gallery-bottom-1,
    .gallery-bottom-2,
    .gallery-bottom-3 {

      grid-column: span 1;

    }

  }


  @media(max-width:575px) {

    .research-gallery {

      display: flex;

      flex-direction: column;

      gap: 15px;

    }

    .research-gallery-item {

      height: 250px;

    }

    .gallery-large {

      height: 320px;

    }

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

              Research News

            </span>

            <h1 class="display-4 mb-4">

              Kabar Penelitian
              <br>
              STIH Graha Kirana

            </h1>

            <p class="lead mb-5">

              Pusat informasi mengenai penelitian dosen,
              publikasi ilmiah, hibah penelitian,
              inovasi akademik, seminar ilmiah,
              dan kolaborasi riset yang mendukung
              pengembangan ilmu hukum.

            </p>


            <div class="row g-4">

              <!-- ITEM 1 -->

              <div class="col-md-6">

                <div class="facility-highlight">

                  <div class="facility-icon">

                    🔬

                  </div>

                  <div>

                    <h5 class="mb-1">

                      Penelitian

                    </h5>

                    <small>

                      Mengembangkan kajian hukum melalui penelitian ilmiah.

                    </small>

                  </div>

                </div>

              </div>


              <!-- ITEM 2 -->

              <div class="col-md-6">

                <div class="facility-highlight">

                  <div class="facility-icon">

                    📚

                  </div>

                  <div>

                    <h5 class="mb-1">

                      Publikasi Ilmiah

                    </h5>

                    <small>

                      Menyebarluaskan hasil penelitian melalui publikasi ilmiah.

                    </small>

                  </div>

                </div>

              </div>


              <!-- ITEM 3 -->

              <div class="col-md-6">

                <div class="facility-highlight">

                  <div class="facility-icon">

                    🏆

                  </div>

                  <div>

                    <h5 class="mb-1">

                      Hibah Penelitian

                    </h5>

                    <small>

                      Mendukung penelitian melalui berbagai skema pendanaan.

                    </small>

                  </div>

                </div>

              </div>


              <!-- ITEM 4 -->

              <div class="col-md-6">

                <div class="facility-highlight">

                  <div class="facility-icon">

                    🤝

                  </div>

                  <div>

                    <h5 class="mb-1">

                      Kolaborasi Riset

                    </h5>

                    <small>

                      Membangun kolaborasi penelitian dengan berbagai mitra.

                    </small>

                  </div>

                </div>

              </div>

            </div>


            <!-- ACTION -->

            <div class="mt-5">

              <a href="#research"
                class="btn btn-primary rounded-pill me-3">

                <i class="uil uil-flask me-1"></i>

                Penelitian Terbaru

              </a>

              <a href="#publication"
                class="btn btn-outline-primary rounded-pill">

                <i class="uil uil-book-open me-1"></i>

                Publikasi Ilmiah

              </a>

            </div>

          </div>


          <!-- RIGHT -->

          <div class="col-lg-6">

            <img
              src="./assets/img/research/research-hero.png"
              class="img-fluid rounded-4 shadow-lg"
              alt="Kegiatan Penelitian STIH Graha Kirana">

          </div>

        </div>

      </div>

    </section>
    <section class="wrapper bg-light" id="research">

      <div class="container py-15 py-md-17">

        <!-- Heading -->

        <div class="row mb-10">

          <div class="col-lg-8">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

              Featured Research

            </span>

            <h2 class="display-5">

              Penelitian Unggulan

            </h2>

          </div>

        </div>

        <div class="row gy-5">

          <!-- Featured -->

          <div class="col-lg-8">

            <div class="featured-research">

              <img src="./assets/img/gallery/seminar.png"
                class="img-fluid">

              <div class="featured-overlay">

                <span class="badge bg-primary">

                  Artificial Intelligence & Law

                </span>

                <h2>

                  Pemanfaatan Artificial Intelligence
                  Dalam Transformasi Penegakan Hukum
                  di Indonesia

                </h2>

                <p>

                  Penelitian ini membahas penerapan Artificial
                  Intelligence dalam sistem hukum modern,
                  termasuk analisis dokumen hukum,
                  legal research, dan pengambilan keputusan.

                </p>

                <a href="#"
                  class="btn btn-white rounded-pill">

                  Baca Selengkapnya

                </a>

              </div>

            </div>

          </div>

          <!-- Popular -->

          <div class="col-lg-4">

            <div class="research-sidebar">

              <h4 class="mb-4">

                🔥 Penelitian Populer

              </h4>

              <?php

              $popular = [

                ["AI & Hukum", "Artificial Intelligence Dalam Dunia Peradilan"],

                ["Cyber Law", "Perlindungan Data Pribadi di Indonesia"],

                ["Kenotariatan", "Transformasi Digital Kenotariatan"],

                ["Hukum Bisnis", "Regulasi Startup Digital"],

                ["HAM", "Hak Asasi Manusia di Era Digital"]

              ];

              foreach ($popular as $item) {

              ?>

                <div class="popular-research">

                  <div class="popular-number">

                    <?= array_search($item, $popular) + 1 ?>

                  </div>

                  <div>

                    <small>

                      <?= $item[0] ?>

                    </small>

                    <h6>

                      <?= $item[1] ?>

                    </h6>

                  </div>

                </div>

              <?php } ?>

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

              Latest Research

            </span>

            <h2 class="display-5">

              Berita Penelitian Terbaru

            </h2>

          </div>

          <div class="col-lg-6 text-lg-end">

            <a href="#"
              class="btn btn-outline-primary rounded-pill">

              Lihat Semua Penelitian

            </a>

          </div>

        </div>

        <!-- Filter -->

        <div class="news-filter mb-5">

          <button class="active">Semua</button>

          <button>Artificial Intelligence</button>

          <button>Hukum Pidana</button>

          <button>Hukum Perdata</button>

          <button>Kenotariatan</button>

          <button>Hibah</button>

          <button>Seminar</button>

        </div>

        <div class="row g-4">

          <?php

          $research = [

            [
              "ai-law.png",
              "Artificial Intelligence",
              "Artificial Intelligence Sebagai Pendukung Analisis Dokumen Hukum",
              "Penelitian mengenai pemanfaatan AI untuk meningkatkan efisiensi analisis dokumen hukum.",
              "04 Agustus 2026"
            ],

            [
              "cyber-law.png",
              "Cyber Law",
              "Perlindungan Data Pribadi Dalam Era Digital",
              "Kajian terhadap implementasi regulasi perlindungan data pribadi di Indonesia.",
              "02 Agustus 2026"
            ],

            [
              "notary.png",
              "Kenotariatan",
              "Digitalisasi Layanan Kenotariatan",
              "Penelitian mengenai transformasi digital pada praktik kenotariatan.",
              "30 Juli 2026"
            ],

            [
              "criminal-law.png",
              "Hukum Pidana",
              "Reformasi Sistem Peradilan Pidana",
              "Kajian mengenai efektivitas sistem peradilan pidana modern.",
              "28 Juli 2026"
            ],

            [
              "grant.png",
              "Hibah",
              "Dosen STIH Raih Hibah Penelitian Nasional",
              "Tim peneliti memperoleh pendanaan penelitian kompetitif nasional.",
              "25 Juli 2026"
            ],

            [
              "seminar.png",
              "Seminar",
              "Seminar Nasional Metodologi Penelitian Hukum",
              "Seminar membahas metode penelitian hukum berbasis perkembangan teknologi.",
              "22 Juli 2026"
            ]

          ];

          foreach ($research as $r) {

          ?>

            <div class="col-md-6 col-xl-4">

              <div class="news-card">

                <div class="news-image">

                  <img src="./assets/img/research/<?= $r[0] ?>">

                  <span class="news-category">

                    <?= $r[1] ?>

                  </span>

                </div>

                <div class="news-body">

                  <small>

                    <i class="uil uil-calendar-alt me-1"></i>

                    <?= $r[4] ?>

                  </small>

                  <h4>

                    <?= $r[2] ?>

                  </h4>

                  <p>

                    <?= $r[3] ?>

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
    <section class="wrapper bg-white">

      <div class="container py-15 py-md-17">

        <!-- Heading -->

        <div class="row text-center mb-10">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

              Research Funding

            </span>

            <h2 class="display-5 mb-3">

              Hibah & Pendanaan Penelitian

            </h2>

            <p class="lead">

              Dukungan pendanaan penelitian membantu dosen dan peneliti
              mengembangkan kajian ilmiah yang relevan serta memberikan
              kontribusi nyata bagi perkembangan ilmu hukum dan masyarakat.

            </p>

          </div>

        </div>


        <div class="row align-items-center gy-5">

          <!-- TIMELINE -->

          <div class="col-lg-7">

            <div class="funding-timeline">

              <!-- ITEM -->

              <div class="funding-item">

                <div class="funding-icon">

                  <i class="uil uil-university"></i>

                </div>

                <div class="funding-content">

                  <span>

                    Hibah Internal

                  </span>

                  <h4>

                    Pendanaan Penelitian Institusi

                  </h4>

                  <p>

                    Program pendanaan internal untuk mendukung
                    penelitian dosen dan pengembangan kajian
                    ilmiah di lingkungan STIH Graha Kirana.

                  </p>

                </div>

              </div>


              <!-- ITEM -->

              <div class="funding-item">

                <div class="funding-icon">

                  <i class="uil uil-flask"></i>

                </div>

                <div class="funding-content">

                  <span>

                    Pemerintah

                  </span>

                  <h4>

                    Hibah Penelitian Nasional

                  </h4>

                  <p>

                    Kesempatan memperoleh pendanaan kompetitif
                    melalui program hibah penelitian pemerintah
                    sesuai bidang dan skema yang tersedia.

                  </p>

                </div>

              </div>


              <!-- ITEM -->

              <div class="funding-item">

                <div class="funding-icon">

                  <i class="uil uil-atom"></i>

                </div>

                <div class="funding-content">

                  <span>

                    Lembaga Riset

                  </span>

                  <h4>

                    Kolaborasi Riset

                  </h4>

                  <p>

                    Kolaborasi penelitian dengan lembaga riset,
                    perguruan tinggi, dan institusi akademik
                    lainnya.

                  </p>

                </div>

              </div>


              <!-- ITEM -->

              <div class="funding-item">

                <div class="funding-icon">

                  <i class="uil uil-building"></i>

                </div>

                <div class="funding-content">

                  <span>

                    Mitra

                  </span>

                  <h4>

                    Research Partnership

                  </h4>

                  <p>

                    Pengembangan penelitian bersama mitra
                    industri, pemerintah, lembaga hukum,
                    dan organisasi masyarakat.

                  </p>

                </div>

              </div>

            </div>

          </div>


          <!-- STATISTIC CARD -->

          <div class="col-lg-5">

            <div class="funding-stat-card">

              <div class="funding-stat-header">

                <span class="badge bg-primary text-white rounded-pill">

                  Research Funding

                </span>

                <i class="uil uil-chart-growth"></i>

              </div>

              <h3 class="mt-4">

                Dukungan Pendanaan

              </h3>

              <p>

                Ringkasan capaian pendanaan dan kolaborasi
                penelitian STIH Graha Kirana.

              </p>


              <div class="funding-stat">

                <div>

                  <strong>42+</strong>

                  <span>Penelitian Didanai</span>

                </div>

                <i class="uil uil-flask"></i>

              </div>


              <div class="funding-stat">

                <div>

                  <strong>18+</strong>

                  <span>Mitra Penelitian</span>

                </div>

                <i class="uil uil-users-alt"></i>

              </div>


              <div class="funding-stat">

                <div>

                  <strong>12+</strong>

                  <span>Skema Pendanaan</span>

                </div>

                <i class="uil uil-wallet"></i>

              </div>


              <div class="funding-stat">

                <div>

                  <strong>75+</strong>

                  <span>Publikasi</span>

                </div>

                <i class="uil uil-book-open"></i>

              </div>


              <a href="#"
                class="btn btn-primary rounded-pill w-100 mt-3">

                <i class="uil uil-arrow-right me-2"></i>

                Lihat Program Penelitian

              </a>

            </div>

          </div>

        </div>

      </div>

    </section>
    <section class="wrapper bg-light" id="publication">

      <div class="container py-15 py-md-17">

        <!-- Heading -->

        <div class="row text-center mb-10">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

              Research Outputs

            </span>

            <h2 class="display-5 mb-3">

              Publikasi & Luaran Penelitian

            </h2>

            <p class="lead">

              Hasil penelitian dosen dan mahasiswa dikembangkan menjadi
              berbagai luaran ilmiah yang dapat memberikan kontribusi
              bagi pengembangan ilmu hukum dan masyarakat.

            </p>

          </div>

        </div>


        <div class="row g-4">

          <?php

          $outputs = [

            [
              "uil-book-open",
              "Artikel Jurnal",
              "Publikasi hasil penelitian melalui jurnal ilmiah nasional maupun internasional.",
              "75+"
            ],

            [
              "uil-file-alt",
              "Prosiding",
              "Hasil penelitian yang dipresentasikan dalam seminar dan konferensi ilmiah.",
              "35+"
            ],

            [
              "uil-books",
              "Buku & Book Chapter",
              "Pengembangan hasil penelitian menjadi buku referensi dan book chapter.",
              "20+"
            ],

            [
              "uil-award",
              "Hak Kekayaan Intelektual",
              "Perlindungan dan dokumentasi hasil inovasi serta karya intelektual peneliti.",
              "15+"
            ],

            [
              "uil-presentation",
              "Konferensi Ilmiah",
              "Diseminasi hasil penelitian melalui forum ilmiah nasional dan internasional.",
              "30+"
            ],

            [
              "uil-database",
              "Repository Penelitian",
              "Dokumentasi dan arsip digital hasil penelitian untuk mendukung akses pengetahuan.",
              "100+"
            ]

          ];

          foreach ($outputs as $output) {

          ?>

            <div class="col-md-6 col-xl-4">

              <div class="research-output-card">

                <div class="research-output-top">

                  <div class="research-output-icon">

                    <i class="uil <?= $output[0] ?>"></i>

                  </div>

                  <strong>

                    <?= $output[3] ?>

                  </strong>

                </div>

                <h4>

                  <?= $output[1] ?>

                </h4>

                <p>

                  <?= $output[2] ?>

                </p>

                <a href="#"
                  class="research-output-link">

                  Lihat Publikasi

                  <i class="uil uil-arrow-right"></i>

                </a>

              </div>

            </div>

          <?php } ?>

        </div>


        <!-- Bottom CTA -->

        <div class="row mt-10">

          <div class="col-lg-10 mx-auto">

            <div class="publication-cta">

              <div>

                <span class="badge bg-primary text-white rounded-pill mb-3">

                  Research Repository

                </span>

                <h3>

                  Temukan Hasil Penelitian STIH Graha Kirana

                </h3>

                <p>

                  Akses berbagai publikasi dan luaran penelitian
                  melalui repository dan portal publikasi ilmiah.

                </p>

              </div>

              <a href="#"
                class="btn btn-primary rounded-pill">

                <i class="uil uil-arrow-up-right me-2"></i>

                Jelajahi Publikasi

              </a>

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

              Scientific Events

            </span>

            <h2 class="display-5 mb-3">

              Seminar, Conference & Call for Paper

            </h2>

            <p class="lead">

              Ikuti berbagai forum ilmiah, seminar, konferensi,
              workshop, dan kesempatan publikasi yang menjadi ruang
              berbagi pengetahuan serta hasil penelitian.

            </p>

          </div>

        </div>


        <div class="row g-4">

          <?php

          $events = [

            [
              "seminar.png",
              "Seminar Nasional",
              "Transformasi Hukum di Era Digital",
              "15 Agustus 2026",
              "Seminar",
              "Membahas perkembangan hukum dan teknologi digital."
            ],

            [
              "conference.png",
              "International Conference",
              "Contemporary Issues in Legal Studies",
              "20 September 2026",
              "Conference",
              "Forum akademik untuk peneliti dan praktisi hukum."
            ],

            [
              "call-paper.png",
              "Call for Paper",
              "Jurnal Ilmu Hukum STIH Graha Kirana",
              "30 September 2026",
              "Call for Paper",
              "Kesempatan publikasi bagi akademisi dan peneliti."
            ],

            [
              "workshop.png",
              "Research Workshop",
              "Metodologi Penelitian Hukum",
              "12 Oktober 2026",
              "Workshop",
              "Pelatihan pengembangan metodologi penelitian hukum."
            ]

          ];

          foreach ($events as $event) {

          ?>

            <div class="col-md-6 col-xl-3">

              <div class="research-event-card">

                <div class="research-event-image">

                  <img
                    src="./assets/img/events/<?= $event[0] ?>"
                    alt="<?= $event[1] ?>">

                  <span>

                    <?= $event[4] ?>

                  </span>

                </div>

                <div class="research-event-body">

                  <small>

                    <i class="uil uil-calendar-alt me-1"></i>

                    <?= $event[3] ?>

                  </small>

                  <h4>

                    <?= $event[1] ?>

                  </h4>

                  <h6>

                    <?= $event[2] ?>

                  </h6>

                  <p>

                    <?= $event[5] ?>

                  </p>

                  <a href="#"
                    class="research-event-link">

                    Lihat Detail

                    <i class="uil uil-arrow-right"></i>

                  </a>

                </div>

              </div>

            </div>

          <?php } ?>

        </div>


        <!-- Bottom -->

        <div class="row mt-10">

          <div class="col-lg-10 mx-auto">

            <div class="research-event-bottom">

              <div>

                <div class="research-event-bottom-icon">

                  <i class="uil uil-megaphone"></i>

                </div>

              </div>

              <div class="flex-grow-1">

                <span>

                  Call for Paper

                </span>

                <h3>

                  Terbuka Kesempatan Publikasi Ilmiah

                </h3>

                <p>

                  Temukan informasi mengenai agenda konferensi,
                  seminar, dan call for paper yang diselenggarakan
                  oleh STIH Graha Kirana.

                </p>

              </div>

              <a href="#"
                class="btn btn-primary rounded-pill">

                Lihat Semua Event

                <i class="uil uil-arrow-right ms-1"></i>

              </a>

            </div>

          </div>

        </div>

      </div>

    </section>
    <section class="wrapper bg-light">

      <div class="container py-15 py-md-17">

        <!-- Heading -->

        <div class="row align-items-end mb-10">

          <div class="col-lg-7">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

              Research Gallery

            </span>

            <h2 class="display-5 mb-3">

              Galeri Kegiatan Penelitian

            </h2>

            <p class="lead mb-0">

              Dokumentasi kegiatan penelitian, seminar ilmiah,
              diskusi akademik, konferensi, dan kolaborasi
              penelitian STIH Graha Kirana.

            </p>

          </div>

          <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">

            <a href="#"
              class="btn btn-outline-primary rounded-pill">

              <i class="uil uil-images me-2"></i>

              Lihat Semua Galeri

            </a>

          </div>

        </div>


        <!-- GALLERY -->

        <div class="research-gallery">

          <!-- Large -->

          <div class="research-gallery-item gallery-large">

            <img
              src="./assets/img/research/gallery/seminar.png"
              alt="Seminar Penelitian">

            <div class="research-gallery-overlay">

              <span>

                Seminar

              </span>

              <h4>

                Seminar Penelitian Hukum

              </h4>

              <small>

                📅 Agustus 2026

              </small>

            </div>

          </div>


          <!-- Top Right -->

          <div class="research-gallery-item gallery-top">

            <img
              src="./assets/img/research/gallery/legalid.png"
              alt="Diskusi Penelitian">

            <div class="research-gallery-overlay">

              <span>

                Research Discussion

              </span>

              <h5>

                Diskusi Akademik

              </h5>

            </div>

          </div>


          <!-- Middle Right -->

          <div class="research-gallery-item gallery-middle">

            <img
              src="./assets/img/research/gallery/mootcourt.png"
              alt="Conference">

            <div class="research-gallery-overlay">

              <span>

                Conference

              </span>

              <h5>

                Konferensi Ilmiah

              </h5>

            </div>

          </div>


          <!-- Bottom -->

          <div class="research-gallery-item gallery-bottom-1">

            <img
              src="./assets/img/research/gallery/gallery.png"
              alt="Research Workshop">

            <div class="research-gallery-overlay">

              <span>

                Workshop

              </span>

              <h5>

                Research Workshop

              </h5>

            </div>

          </div>


          <div class="research-gallery-item gallery-bottom-2">

            <img
              src="./assets/img/research/gallery/baksos.png"
              alt="Research Collaboration">

            <div class="research-gallery-overlay">

              <span>

                Collaboration

              </span>

              <h5>

                Kolaborasi Penelitian

              </h5>

            </div>

          </div>


          <div class="research-gallery-item gallery-bottom-3">

            <img
              src="./assets/img/research/gallery/alumni.png"
              alt="Research Presentation">

            <div class="research-gallery-overlay">

              <span>

                Presentation

              </span>

              <h5>

                Presentasi Hasil Riset

              </h5>

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