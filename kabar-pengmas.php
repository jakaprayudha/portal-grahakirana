<!DOCTYPE html>
<html lang="en">

<?php
$page = "Home";
require 'head.php';
?>
<style>
  /* ==========================================
   FEATURED COMMUNITY SERVICE
========================================== */

  .featured-community {

    position: relative;

    height: 600px;

    overflow: hidden;

    border-radius: 24px;

    box-shadow: 0 20px 45px rgba(0, 0, 0, .12);

  }

  .featured-community img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    transition: .45s;

  }

  .featured-community:hover img {

    transform: scale(1.07);

  }


  .featured-community-overlay {

    position: absolute;

    left: 0;

    right: 0;

    bottom: 0;

    padding: 50px;

    color: #fff;

    background:
      linear-gradient(to top,
        rgba(0, 0, 0, .92),
        rgba(0, 0, 0, .55),
        transparent);

  }

  .featured-community-overlay h2 {

    color: #fff;

    margin: 20px 0 15px;

    line-height: 1.4;

  }

  .featured-community-overlay p {

    color: rgba(255, 255, 255, .9);

    max-width: 750px;

    line-height: 1.8;

    margin-bottom: 25px;

  }


  /* ==========================================
   COMMUNITY SIDEBAR
========================================== */

  .community-sidebar {

    background: #fff;

    padding: 35px;

    border-radius: 24px;

    height: 100%;

    border: 1px solid #EEF2F7;

    box-shadow: 0 15px 35px rgba(0, 0, 0, .06);

  }

  .community-popular {

    display: flex;

    align-items: flex-start;

    gap: 18px;

    padding: 18px 0;

    border-bottom: 1px dashed #ddd;

  }

  .community-popular:last-child {

    border-bottom: none;

  }

  .community-number {

    width: 42px;

    height: 42px;

    flex-shrink: 0;

    border-radius: 50%;

    background: #F0EAFB;

    color: #6A3DA8;

    display: flex;

    align-items: center;

    justify-content: center;

    font-weight: 700;

    font-size: 13px;

  }

  .community-popular small {

    display: block;

    color: #6A3DA8;

    font-weight: 600;

    margin-bottom: 5px;

  }

  .community-popular h6 {

    margin: 0;

    line-height: 1.5;

  }


  /* ==========================================
   RESPONSIVE
========================================== */

  @media(max-width:767px) {

    .featured-community {

      height: 520px;

    }

    .featured-community-overlay {

      padding: 30px;

    }

    .featured-community-overlay h2 {

      font-size: 25px;

    }

    .featured-community-overlay p {

      font-size: 14px;

    }

    .community-sidebar {

      padding: 25px;

    }

  }

  /* ==========================================
   COMMUNITY NEWS CARD
========================================== */

  .community-news-card {

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

  .community-news-card:hover {

    transform: translateY(-8px);

    box-shadow: 0 25px 50px rgba(106, 61, 168, .15);

  }


  /* IMAGE */

  .community-news-image {

    position: relative;

    height: 240px;

    overflow: hidden;

  }

  .community-news-image img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    transition: .45s;

  }

  .community-news-card:hover .community-news-image img {

    transform: scale(1.08);

  }


  /* CATEGORY */

  .community-news-image span {

    position: absolute;

    top: 18px;

    left: 18px;

    background: #6A3DA8;

    color: #fff;

    padding: 8px 16px;

    border-radius: 50px;

    font-size: 12px;

    font-weight: 600;

  }


  /* BODY */

  .community-news-body {

    padding: 28px;

    display: flex;

    flex-direction: column;

    flex: 1;

  }

  .community-news-body small {

    color: #888;

    margin-bottom: 12px;

  }

  .community-news-body h4 {

    font-size: 21px;

    line-height: 1.45;

    font-weight: 700;

    margin-bottom: 14px;

  }

  .community-news-body p {

    color: #666;

    line-height: 1.8;

    flex: 1;

    margin-bottom: 25px;

  }

  .community-news-body a {

    color: #6A3DA8;

    font-weight: 600;

    text-decoration: none;

  }

  .community-news-body a i {

    margin-left: 5px;

    transition: .3s;

  }

  .community-news-body a:hover i {

    transform: translateX(5px);

  }


  /* ==========================================
   FILTER
========================================== */

  .news-filter {

    display: flex;

    flex-wrap: wrap;

    gap: 10px;

  }

  .news-filter button {

    border: 0;

    background: #F3F4F8;

    color: #555;

    padding: 10px 20px;

    border-radius: 50px;

    font-weight: 600;

    cursor: pointer;

    transition: .3s;

  }

  .news-filter button:hover,
  .news-filter button.active {

    background: #6A3DA8;

    color: #fff;

  }


  /* ==========================================
   RESPONSIVE
========================================== */

  @media(max-width:767px) {

    .news-filter {

      justify-content: center;

    }

    .community-news-image {

      height: 220px;

    }

    .community-news-body {

      padding: 23px;

    }

    .community-news-body h4 {

      font-size: 19px;

    }

  }

  /* ==========================================
   COMMUNITY SERVICE AREAS
========================================== */

  .community-area-card {

    background: #fff;

    padding: 32px 25px;

    border-radius: 24px;

    height: 100%;

    border: 1px solid #EEF2F7;

    box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

    transition: .35s;

    display: flex;

    flex-direction: column;

  }

  .community-area-card:hover {

    transform: translateY(-8px);

    box-shadow: 0 25px 50px rgba(106, 61, 168, .14);

    border-color: #DCCCF2;

  }


  /* ICON */

  .community-area-icon {

    width: 75px;

    height: 75px;

    border-radius: 20px;

    background: #F0EAFB;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 34px;

    margin-bottom: 22px;

    transition: .35s;

  }

  .community-area-card:hover .community-area-icon {

    background: #6A3DA8;

    transform: scale(1.08) rotate(5deg);

  }


  /* TITLE */

  .community-area-card h4 {

    font-size: 20px;

    font-weight: 700;

    line-height: 1.4;

    margin-bottom: 12px;

  }


  /* DESCRIPTION */

  .community-area-card p {

    color: #666;

    line-height: 1.8;

    font-size: 14px;

    margin-bottom: 22px;

    flex: 1;

  }


  /* LINK */

  .community-area-card a {

    color: #6A3DA8;

    font-weight: 600;

    text-decoration: none;

  }

  .community-area-card a i {

    margin-left: 5px;

    transition: .3s;

  }

  .community-area-card a:hover i {

    transform: translateX(5px);

  }


  /* ==========================================
   RESPONSIVE
========================================== */

  @media(max-width:767px) {

    .community-area-card {

      padding: 28px 22px;

    }

  }

  /* ==========================================
   COMMUNITY PROGRAMS
========================================== */

  .community-programs {

    display: flex;

    flex-direction: column;

    gap: 18px;

  }

  .community-program {

    display: flex;

    gap: 20px;

    padding: 25px;

    background: #fff;

    border: 1px solid #EEF2F7;

    border-radius: 22px;

    transition: .35s;

  }

  .community-program:hover {

    transform: translateX(7px);

    border-color: #DCCCF2;

    box-shadow: 0 15px 35px rgba(106, 61, 168, .10);

  }


  /* ICON */

  .community-program-icon {

    width: 65px;

    height: 65px;

    flex-shrink: 0;

    border-radius: 18px;

    background: #F0EAFB;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 28px;

    transition: .35s;

  }

  .community-program:hover .community-program-icon {

    background: #6A3DA8;

    transform: scale(1.05);

  }


  /* CONTENT */

  .community-program-content {

    flex: 1;

  }

  .community-program-content span {

    display: block;

    color: #6A3DA8;

    font-size: 12px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .5px;

    margin-bottom: 5px;

  }

  .community-program-content h4 {

    font-size: 19px;

    font-weight: 700;

    margin-bottom: 8px;

  }

  .community-program-content p {

    color: #666;

    font-size: 14px;

    line-height: 1.7;

    margin: 0;

  }


  /* ==========================================
   PARTNER CARD
========================================== */

  .community-partner-card {

    background: #F8F6FC;

    border: 1px solid #E9E0F5;

    border-radius: 28px;

    padding: 35px;

    box-shadow: 0 18px 40px rgba(0, 0, 0, .06);

  }

  .community-partner-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 20px;

  }

  .community-partner-header>i {

    font-size: 32px;

    color: #6A3DA8;

  }

  .community-partner-card h3 {

    font-weight: 700;

    margin-bottom: 10px;

  }

  .community-partner-card>p {

    color: #666;

    line-height: 1.7;

    margin-bottom: 25px;

  }


  /* PARTNERS */

  .partner-list {

    display: flex;

    flex-direction: column;

    gap: 10px;

  }

  .partner-item {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 14px;

    background: #fff;

    border-radius: 16px;

    border: 1px solid #EEF2F7;

    transition: .3s;

  }

  .partner-item:hover {

    transform: translateX(5px);

  }

  .partner-icon {

    width: 42px;

    height: 42px;

    border-radius: 12px;

    background: #F0EAFB;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 20px;

    flex-shrink: 0;

  }

  .partner-item strong {

    display: block;

    font-size: 14px;

  }

  .partner-item small {

    display: block;

    color: #888;

    font-size: 12px;

    margin-top: 3px;

  }


  /* ==========================================
   RESPONSIVE
========================================== */

  @media(max-width:767px) {

    .community-program {

      padding: 20px;

    }

    .community-program-icon {

      width: 55px;

      height: 55px;

      font-size: 24px;

    }

    .community-partner-card {

      padding: 25px;

    }

  }

  /* ==========================================
   COMMUNITY IMPACT
========================================== */

  .impact-stat-card {

    background: #fff;

    padding: 30px 25px;

    border-radius: 24px;

    border: 1px solid #EEF2F7;

    box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

    height: 100%;

    transition: .35s;

  }

  .impact-stat-card:hover {

    transform: translateY(-7px);

    box-shadow: 0 25px 45px rgba(106, 61, 168, .13);

    border-color: #DCCCF2;

  }


  /* ICON */

  .impact-stat-icon {

    width: 60px;

    height: 60px;

    border-radius: 18px;

    background: #F0EAFB;

    color: #6A3DA8;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 27px;

    margin-bottom: 20px;

  }


  /* NUMBER */

  .impact-stat-card strong {

    display: block;

    font-size: 32px;

    line-height: 1.2;

    color: #6A3DA8;

    margin-bottom: 5px;

  }


  /* LABEL */

  .impact-stat-card>span {

    display: block;

    font-weight: 700;

    margin-bottom: 12px;

  }


  /* DESCRIPTION */

  .impact-stat-card p {

    color: #777;

    font-size: 13px;

    line-height: 1.7;

    margin: 0;

  }


  /* ==========================================
   IMPACT CONTENT
========================================== */

  .impact-content {

    padding-right: 30px;

  }

  .impact-content h3 {

    font-weight: 700;

  }

  .impact-content p {

    color: #666;

    line-height: 1.9;

  }


  /* ==========================================
   IMPACT LIST
========================================== */

  .impact-list {

    display: flex;

    flex-direction: column;

    gap: 15px;

  }

  .impact-list-item {

    display: flex;

    gap: 18px;

    padding: 20px;

    background: #F8F6FC;

    border: 1px solid #E9E0F5;

    border-radius: 20px;

    transition: .3s;

  }

  .impact-list-item:hover {

    transform: translateX(6px);

    background: #F4EFFA;

  }

  .impact-check {

    width: 45px;

    height: 45px;

    flex-shrink: 0;

    border-radius: 14px;

    background: #6A3DA8;

    color: #fff;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 20px;

  }

  .impact-list-item h5 {

    margin-bottom: 5px;

    font-weight: 700;

  }

  .impact-list-item p {

    margin: 0;

    color: #666;

    font-size: 14px;

    line-height: 1.7;

  }


  /* ==========================================
   RESPONSIVE
========================================== */

  @media(max-width:767px) {

    .impact-stat-card {

      padding: 25px 20px;

    }

    .impact-stat-card strong {

      font-size: 27px;

    }

    .impact-content {

      padding-right: 0;

    }

    .impact-list-item {

      padding: 17px;

    }

  }

  /* ==========================================
   COMMUNITY GALLERY
========================================== */

  .community-gallery {

    display: grid;

    grid-template-columns: 2fr 1fr 1fr;

    grid-template-rows: 260px 260px 220px;

    gap: 18px;

  }


  /* ITEM */

  .community-gallery-item {

    position: relative;

    overflow: hidden;

    border-radius: 24px;

    background: #ddd;

    cursor: pointer;

  }

  .community-gallery-item img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    transition: .5s;

  }

  .community-gallery-item:hover img {

    transform: scale(1.08);

  }


  /* LARGE */

  .community-gallery-item.gallery-large {

    grid-row: span 2;

  }


  /* OVERLAY */

  .community-gallery-overlay {

    position: absolute;

    left: 0;

    right: 0;

    bottom: 0;

    padding: 28px;

    color: #fff;

    background:
      linear-gradient(to top,
        rgba(0, 0, 0, .88),
        rgba(0, 0, 0, .40),
        transparent);

    transform: translateY(8px);

    transition: .35s;

  }

  .community-gallery-item:hover .community-gallery-overlay {

    transform: translateY(0);

  }

  .community-gallery-overlay span {

    display: inline-block;

    padding: 6px 13px;

    border-radius: 50px;

    background: #6A3DA8;

    color: #fff;

    font-size: 12px;

    font-weight: 600;

    margin-bottom: 8px;

  }

  .community-gallery-overlay h3,
  .community-gallery-overlay h5 {

    color: #fff;

    margin: 4px 0;

  }

  .community-gallery-overlay small {

    color: rgba(255, 255, 255, .85);

  }


  /* ==========================================
   RESPONSIVE
========================================== */

  @media(max-width:991px) {

    .community-gallery {

      grid-template-columns: 1fr 1fr;

      grid-template-rows: 300px 220px 220px 220px;

    }

    .community-gallery-item.gallery-large {

      grid-column: span 2;

      grid-row: auto;

    }

  }


  @media(max-width:575px) {

    .community-gallery {

      display: flex;

      flex-direction: column;

      gap: 15px;

    }

    .community-gallery-item {

      height: 250px;

    }

    .community-gallery-item.gallery-large {

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

              Community Service

            </span>

            <h1 class="display-4 mb-4">

              Kabar Pengabdian
              <br>
              Masyarakat

            </h1>

            <p class="lead mb-5">

              Informasi kegiatan pengabdian masyarakat STIH Graha Kirana
              dalam memberikan edukasi, penyuluhan, pendampingan,
              dan solusi hukum yang memberikan manfaat nyata
              bagi masyarakat.

            </p>


            <div class="row g-4">

              <!-- ITEM 1 -->

              <div class="col-md-6">

                <div class="facility-highlight">

                  <div class="facility-icon">

                    ⚖️

                  </div>

                  <div>

                    <h5 class="mb-1">

                      Penyuluhan Hukum

                    </h5>

                    <small>

                      Meningkatkan pemahaman dan kesadaran hukum masyarakat.

                    </small>

                  </div>

                </div>

              </div>


              <!-- ITEM 2 -->

              <div class="col-md-6">

                <div class="facility-highlight">

                  <div class="facility-icon">

                    👥

                  </div>

                  <div>

                    <h5 class="mb-1">

                      Pendampingan

                    </h5>

                    <small>

                      Memberikan pendampingan dan edukasi kepada masyarakat.

                    </small>

                  </div>

                </div>

              </div>


              <!-- ITEM 3 -->

              <div class="col-md-6">

                <div class="facility-highlight">

                  <div class="facility-icon">

                    🏘️

                  </div>

                  <div>

                    <h5 class="mb-1">

                      Desa Binaan

                    </h5>

                    <small>

                      Membangun kolaborasi hukum bersama masyarakat.

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

                      Kolaborasi

                    </h5>

                    <small>

                      Bersinergi dengan pemerintah dan berbagai mitra.

                    </small>

                  </div>

                </div>

              </div>

            </div>


            <!-- ACTION -->

            <div class="mt-5">

              <a href="#community-news"
                class="btn btn-primary rounded-pill me-3">

                Lihat Kegiatan

              </a>

              <a href="#impact"
                class="btn btn-outline-primary rounded-pill">

                Dampak Pengabdian

              </a>

            </div>

          </div>


          <!-- RIGHT -->

          <div class="col-lg-6">

            <img src="./assets/img/community/community.png"
              class="img-fluid rounded-4 shadow-lg"
              alt="Kegiatan Pengabdian Masyarakat STIH Graha Kirana">

          </div>

        </div>

      </div>

    </section>
    <section class="wrapper bg-white" id="community-news">

      <div class="container py-15 py-md-17">

        <!-- HEADING -->

        <div class="row mb-10">

          <div class="col-lg-8">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

              Featured Community Service

            </span>

            <h2 class="display-5 mb-3">

              Pengabdian Unggulan

            </h2>

            <p class="lead mb-0">

              Berbagai kegiatan pengabdian masyarakat yang dilakukan
              oleh sivitas akademika STIH Graha Kirana untuk meningkatkan
              kesadaran hukum dan memberikan manfaat nyata bagi masyarakat.

            </p>

          </div>

        </div>


        <div class="row gy-5">

          <!-- FEATURED -->

          <div class="col-lg-8">

            <div class="featured-community">

              <img
                src="./assets/img/community/featured-community.png"
                alt="Penyuluhan Hukum kepada Masyarakat">

              <div class="featured-community-overlay">

                <span class="badge bg-primary rounded-pill">

                  Penyuluhan Hukum

                </span>

                <h2>

                  Meningkatkan Kesadaran Hukum
                  di Tengah Masyarakat

                </h2>

                <p>

                  Kegiatan penyuluhan hukum menjadi salah satu bentuk
                  kontribusi STIH Graha Kirana dalam memberikan edukasi
                  mengenai hak, kewajiban, dan pemahaman hukum kepada
                  masyarakat.

                </p>

                <div class="d-flex flex-wrap gap-2">

                  <a href="#"
                    class="btn btn-white rounded-pill">

                    Baca Selengkapnya

                    <i class="uil uil-arrow-right ms-1"></i>

                  </a>

                </div>

              </div>

            </div>

          </div>


          <!-- POPULAR -->

          <div class="col-lg-4">

            <div class="community-sidebar">

              <h4 class="mb-4">

                🤝 Kegiatan Pengabdian

              </h4>


              <div class="community-popular">

                <div class="community-number">

                  01

                </div>

                <div>

                  <small>

                    Penyuluhan

                  </small>

                  <h6>

                    Edukasi Kesadaran Hukum Masyarakat

                  </h6>

                </div>

              </div>


              <div class="community-popular">

                <div class="community-number">

                  02

                </div>

                <div>

                  <small>

                    Bantuan Hukum

                  </small>

                  <h6>

                    Pendampingan dan Konsultasi Hukum

                  </h6>

                </div>

              </div>


              <div class="community-popular">

                <div class="community-number">

                  03

                </div>

                <div>

                  <small>

                    Desa Binaan

                  </small>

                  <h6>

                    Pemberdayaan Masyarakat Sadar Hukum

                  </h6>

                </div>

              </div>


              <div class="community-popular">

                <div class="community-number">

                  04

                </div>

                <div>

                  <small>

                    Edukasi

                  </small>

                  <h6>

                    Literasi Hukum bagi Generasi Muda

                  </h6>

                </div>

              </div>


              <div class="community-popular">

                <div class="community-number">

                  05

                </div>

                <div>

                  <small>

                    UMKM

                  </small>

                  <h6>

                    Pendampingan Legalitas dan Perlindungan Usaha

                  </h6>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </section>
    <section class="wrapper bg-light" id="community-news">

      <div class="container py-15 py-md-17">

        <!-- HEADING -->

        <div class="row mb-8 align-items-end">

          <div class="col-lg-7">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

              Latest Community Service

            </span>

            <h2 class="display-5 mb-3">

              Kabar Pengabdian Terbaru

            </h2>

            <p class="lead mb-0">

              Informasi terbaru mengenai kegiatan pengabdian,
              penyuluhan hukum, pendampingan, dan pemberdayaan
              masyarakat yang dilakukan oleh sivitas akademika.

            </p>

          </div>

          <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">

            <a href="#"
              class="btn btn-outline-primary rounded-pill">

              Lihat Semua Kegiatan

              <i class="uil uil-arrow-right ms-1"></i>

            </a>

          </div>

        </div>


        <!-- FILTER -->

        <div class="news-filter mb-6">

          <button class="active">
            Semua
          </button>

          <button>
            Penyuluhan Hukum
          </button>

          <button>
            Bantuan Hukum
          </button>

          <button>
            Desa Binaan
          </button>

          <button>
            UMKM
          </button>

          <button>
            Literasi Hukum
          </button>

        </div>


        <!-- NEWS GRID -->

        <div class="row g-4">

          <!-- ITEM 1 -->

          <div class="col-md-6 col-xl-4">

            <div class="community-news-card">

              <div class="community-news-image">

                <img
                  src="./assets/img/community/news/penyuluhan-hukum.png"
                  alt="Penyuluhan Hukum">

                <span>

                  Penyuluhan Hukum

                </span>

              </div>

              <div class="community-news-body">

                <small>

                  <i class="uil uil-calendar-alt me-1"></i>

                  08 Agustus 2026

                </small>

                <h4>

                  Penyuluhan Hukum
                  kepada Masyarakat

                </h4>

                <p>

                  Edukasi mengenai kesadaran hukum,
                  hak, dan kewajiban masyarakat dalam
                  kehidupan sehari-hari.

                </p>

                <a href="#">

                  Baca Selengkapnya

                  <i class="uil uil-arrow-right"></i>

                </a>

              </div>

            </div>

          </div>


          <!-- ITEM 2 -->

          <div class="col-md-6 col-xl-4">

            <div class="community-news-card">

              <div class="community-news-image">

                <img
                  src="./assets/img/community/news/bantuan-hukum.png"
                  alt="Bantuan Hukum">

                <span>

                  Bantuan Hukum

                </span>

              </div>

              <div class="community-news-body">

                <small>

                  <i class="uil uil-calendar-alt me-1"></i>

                  04 Agustus 2026

                </small>

                <h4>

                  Konsultasi dan
                  Pendampingan Hukum

                </h4>

                <p>

                  Memberikan pemahaman dan pendampingan
                  hukum bagi masyarakat yang membutuhkan.

                </p>

                <a href="#">

                  Baca Selengkapnya

                  <i class="uil uil-arrow-right"></i>

                </a>

              </div>

            </div>

          </div>


          <!-- ITEM 3 -->

          <div class="col-md-6 col-xl-4">

            <div class="community-news-card">

              <div class="community-news-image">

                <img
                  src="./assets/img/community/news/desa-binaan.png"
                  alt="Desa Binaan">

                <span>

                  Desa Binaan

                </span>

              </div>

              <div class="community-news-body">

                <small>

                  <i class="uil uil-calendar-alt me-1"></i>

                  01 Agustus 2026

                </small>

                <h4>

                  Program Desa
                  Sadar Hukum

                </h4>

                <p>

                  Pendampingan masyarakat dalam membangun
                  budaya sadar hukum di lingkungan desa.

                </p>

                <a href="#">

                  Baca Selengkapnya

                  <i class="uil uil-arrow-right"></i>

                </a>

              </div>

            </div>

          </div>


          <!-- ITEM 4 -->

          <div class="col-md-6 col-xl-4">

            <div class="community-news-card">

              <div class="community-news-image">

                <img
                  src="./assets/img/community/news/umkm.png"
                  alt="Pendampingan UMKM">

                <span>

                  UMKM

                </span>

              </div>

              <div class="community-news-body">

                <small>

                  <i class="uil uil-calendar-alt me-1"></i>

                  28 Juli 2026

                </small>

                <h4>

                  Pendampingan Legalitas
                  dan Perlindungan UMKM

                </h4>

                <p>

                  Edukasi hukum bagi pelaku UMKM mengenai
                  legalitas usaha dan perlindungan hukum.

                </p>

                <a href="#">

                  Baca Selengkapnya

                  <i class="uil uil-arrow-right"></i>

                </a>

              </div>

            </div>

          </div>


          <!-- ITEM 5 -->

          <div class="col-md-6 col-xl-4">

            <div class="community-news-card">

              <div class="community-news-image">

                <img
                  src="./assets/img/community/news/literasi-hukum.png"
                  alt="Literasi Hukum">

                <span>

                  Literasi Hukum

                </span>

              </div>

              <div class="community-news-body">

                <small>

                  <i class="uil uil-calendar-alt me-1"></i>

                  24 Juli 2026

                </small>

                <h4>

                  Literasi Hukum
                  bagi Generasi Muda

                </h4>

                <p>

                  Membekali generasi muda dengan pemahaman
                  hukum dan kesadaran terhadap hak serta kewajiban.

                </p>

                <a href="#">

                  Baca Selengkapnya

                  <i class="uil uil-arrow-right"></i>

                </a>

              </div>

            </div>

          </div>


          <!-- ITEM 6 -->

          <div class="col-md-6 col-xl-4">

            <div class="community-news-card">

              <div class="community-news-image">

                <img
                  src="./assets/img/community/news/kegiatan-sosial.png"
                  alt="Kegiatan Sosial">

                <span>

                  Sosial

                </span>

              </div>

              <div class="community-news-body">

                <small>

                  <i class="uil uil-calendar-alt me-1"></i>

                  20 Juli 2026

                </small>

                <h4>

                  Kegiatan Sosial
                  Sivitas Akademika

                </h4>

                <p>

                  Kegiatan sosial sebagai bentuk kepedulian
                  sivitas akademika terhadap masyarakat sekitar.

                </p>

                <a href="#">

                  Baca Selengkapnya

                  <i class="uil uil-arrow-right"></i>

                </a>

              </div>

            </div>

          </div>

        </div>

      </div>

    </section>
    <section class="wrapper bg-white">

      <div class="container py-15 py-md-17">

        <!-- HEADING -->

        <div class="row text-center mb-10">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

              Community Service Areas

            </span>

            <h2 class="display-5 mb-3">

              Bidang Pengabdian Masyarakat

            </h2>

            <p class="lead">

              Kegiatan pengabdian STIH Graha Kirana mencakup berbagai
              bidang yang berorientasi pada peningkatan literasi hukum,
              pemberdayaan masyarakat, serta penyelesaian persoalan
              hukum yang dihadapi masyarakat.

            </p>

          </div>

        </div>


        <!-- AREAS -->

        <div class="row g-4">

          <!-- 1 -->

          <div class="col-md-6 col-xl-3">

            <div class="community-area-card">

              <div class="community-area-icon">

                ⚖️

              </div>

              <h4>

                Penyuluhan Hukum

              </h4>

              <p>

                Memberikan edukasi mengenai hukum, hak,
                kewajiban, dan kesadaran hukum kepada masyarakat.

              </p>

              <a href="#">

                Lihat Program

                <i class="uil uil-arrow-right"></i>

              </a>

            </div>

          </div>


          <!-- 2 -->

          <div class="col-md-6 col-xl-3">

            <div class="community-area-card">

              <div class="community-area-icon">

                🏛️

              </div>

              <h4>

                Bantuan Hukum

              </h4>

              <p>

                Mendukung masyarakat melalui konsultasi,
                edukasi, dan pendampingan terhadap persoalan hukum.

              </p>

              <a href="#">

                Lihat Program

                <i class="uil uil-arrow-right"></i>

              </a>

            </div>

          </div>


          <!-- 3 -->

          <div class="col-md-6 col-xl-3">

            <div class="community-area-card">

              <div class="community-area-icon">

                🏘️

              </div>

              <h4>

                Desa Sadar Hukum

              </h4>

              <p>

                Mendorong terbentuknya masyarakat desa
                yang memahami dan menerapkan kesadaran hukum.

              </p>

              <a href="#">

                Lihat Program

                <i class="uil uil-arrow-right"></i>

              </a>

            </div>

          </div>


          <!-- 4 -->

          <div class="col-md-6 col-xl-3">

            <div class="community-area-card">

              <div class="community-area-icon">

                💼

              </div>

              <h4>

                Pendampingan UMKM

              </h4>

              <p>

                Membantu pelaku UMKM memahami aspek legalitas,
                perjanjian, dan perlindungan hukum usaha.

              </p>

              <a href="#">

                Lihat Program

                <i class="uil uil-arrow-right"></i>

              </a>

            </div>

          </div>


          <!-- 5 -->

          <div class="col-md-6 col-xl-3">

            <div class="community-area-card">

              <div class="community-area-icon">

                🎓

              </div>

              <h4>

                Literasi Hukum

              </h4>

              <p>

                Meningkatkan pemahaman hukum bagi pelajar,
                mahasiswa, pemuda, dan masyarakat umum.

              </p>

              <a href="#">

                Lihat Program

                <i class="uil uil-arrow-right"></i>

              </a>

            </div>

          </div>


          <!-- 6 -->

          <div class="col-md-6 col-xl-3">

            <div class="community-area-card">

              <div class="community-area-icon">

                👨‍👩‍👧‍👦

              </div>

              <h4>

                Perlindungan Keluarga

              </h4>

              <p>

                Edukasi mengenai perlindungan hukum keluarga,
                anak, perempuan, dan kelompok rentan.

              </p>

              <a href="#">

                Lihat Program

                <i class="uil uil-arrow-right"></i>

              </a>

            </div>

          </div>


          <!-- 7 -->

          <div class="col-md-6 col-xl-3">

            <div class="community-area-card">

              <div class="community-area-icon">

                💻

              </div>

              <h4>

                Hukum Digital

              </h4>

              <p>

                Edukasi mengenai keamanan digital,
                perlindungan data pribadi, dan hukum siber.

              </p>

              <a href="#">

                Lihat Program

                <i class="uil uil-arrow-right"></i>

              </a>

            </div>

          </div>


          <!-- 8 -->

          <div class="col-md-6 col-xl-3">

            <div class="community-area-card">

              <div class="community-area-icon">

                🤝

              </div>

              <h4>

                Pemberdayaan Masyarakat

              </h4>

              <p>

                Mendorong masyarakat menjadi lebih mandiri
                melalui edukasi, pendampingan, dan kolaborasi.

              </p>

              <a href="#">

                Lihat Program

                <i class="uil uil-arrow-right"></i>

              </a>

            </div>

          </div>

        </div>

      </div>

    </section>
    <section class="wrapper bg-light">

      <div class="container py-15 py-md-17">

        <!-- HEADING -->

        <div class="row text-center mb-10">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

              Community Partnership

            </span>

            <h2 class="display-5 mb-3">

              Program & Mitra Pengabdian

            </h2>

            <p class="lead">

              Pengabdian masyarakat dilaksanakan melalui kolaborasi
              antara sivitas akademika STIH Graha Kirana dengan
              pemerintah, lembaga hukum, komunitas, dunia usaha,
              dan masyarakat.

            </p>

          </div>

        </div>


        <div class="row align-items-center gy-6">


          <!-- LEFT : PROGRAM -->

          <div class="col-lg-7">

            <div class="community-programs">

              <!-- PROGRAM 1 -->

              <div class="community-program">

                <div class="community-program-icon">

                  ⚖️

                </div>

                <div class="community-program-content">

                  <span>

                    Legal Education

                  </span>

                  <h4>

                    Penyuluhan & Edukasi Hukum

                  </h4>

                  <p>

                    Program edukasi hukum bagi masyarakat,
                    pelajar, komunitas, dan kelompok masyarakat
                    untuk meningkatkan kesadaran terhadap hak
                    dan kewajiban hukum.

                  </p>

                </div>

              </div>


              <!-- PROGRAM 2 -->

              <div class="community-program">

                <div class="community-program-icon">

                  🤝

                </div>

                <div class="community-program-content">

                  <span>

                    Legal Assistance

                  </span>

                  <h4>

                    Konsultasi & Pendampingan Hukum

                  </h4>

                  <p>

                    Memberikan informasi, konsultasi, dan
                    pendampingan hukum sesuai dengan kebutuhan
                    masyarakat dan mitra pengabdian.

                  </p>

                </div>

              </div>


              <!-- PROGRAM 3 -->

              <div class="community-program">

                <div class="community-program-icon">

                  🏘️

                </div>

                <div class="community-program-content">

                  <span>

                    Community Empowerment

                  </span>

                  <h4>

                    Desa Sadar Hukum

                  </h4>

                  <p>

                    Mendorong masyarakat desa memahami,
                    menerapkan, dan membangun budaya sadar hukum
                    dalam kehidupan bermasyarakat.

                  </p>

                </div>

              </div>


              <!-- PROGRAM 4 -->

              <div class="community-program">

                <div class="community-program-icon">

                  💼

                </div>

                <div class="community-program-content">

                  <span>

                    UMKM Legal Support

                  </span>

                  <h4>

                    Pendampingan Legalitas UMKM

                  </h4>

                  <p>

                    Membantu pelaku usaha memahami legalitas,
                    perjanjian, perlindungan usaha, dan aspek
                    hukum dalam menjalankan kegiatan bisnis.

                  </p>

                </div>

              </div>

            </div>

          </div>


          <!-- RIGHT : PARTNERS -->

          <div class="col-lg-5">

            <div class="community-partner-card">

              <div class="community-partner-header">

                <span class="badge bg-primary text-white rounded-pill">

                  Collaboration

                </span>

                <i class="uil uil-users-alt"></i>

              </div>

              <h3>

                Mitra Pengabdian

              </h3>

              <p>

                Pengabdian masyarakat dikembangkan bersama
                berbagai pihak untuk memperluas jangkauan
                dan manfaat program.

              </p>


              <div class="partner-list">

                <div class="partner-item">

                  <div class="partner-icon">

                    🏛️

                  </div>

                  <div>

                    <strong>

                      Pemerintah Daerah

                    </strong>

                    <small>

                      Kolaborasi program hukum masyarakat

                    </small>

                  </div>

                </div>


                <div class="partner-item">

                  <div class="partner-icon">

                    🏘️

                  </div>

                  <div>

                    <strong>

                      Pemerintah Desa

                    </strong>

                    <small>

                      Program desa sadar hukum

                    </small>

                  </div>

                </div>


                <div class="partner-item">

                  <div class="partner-icon">

                    ⚖️

                  </div>

                  <div>

                    <strong>

                      Lembaga Hukum

                    </strong>

                    <small>

                      Edukasi dan pendampingan hukum

                    </small>

                  </div>

                </div>


                <div class="partner-item">

                  <div class="partner-icon">

                    🏫

                  </div>

                  <div>

                    <strong>

                      Sekolah & Komunitas

                    </strong>

                    <small>

                      Literasi hukum dan edukasi masyarakat

                    </small>

                  </div>

                </div>


                <div class="partner-item">

                  <div class="partner-icon">

                    💼

                  </div>

                  <div>

                    <strong>

                      Dunia Usaha

                    </strong>

                    <small>

                      Pendampingan hukum bagi pelaku usaha

                    </small>

                  </div>

                </div>

              </div>


              <a href="#"
                class="btn btn-primary rounded-pill w-100 mt-4">

                <i class="uil uil-handshake me-2"></i>

                Menjadi Mitra Pengabdian

              </a>

            </div>

          </div>

        </div>

      </div>

    </section>
    <section class="wrapper bg-white" id="impact">

      <div class="container py-15 py-md-17">

        <!-- HEADING -->

        <div class="row text-center mb-10">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

              Community Impact

            </span>

            <h2 class="display-5 mb-3">

              Dampak Pengabdian Masyarakat

            </h2>

            <p class="lead">

              Pengabdian masyarakat STIH Graha Kirana diarahkan untuk
              memberikan manfaat yang terukur melalui peningkatan
              literasi hukum, pendampingan, edukasi, dan pemberdayaan
              masyarakat.

            </p>

          </div>

        </div>


        <!-- STATISTICS -->

        <div class="row g-4 mb-10">

          <!-- ITEM 1 -->

          <div class="col-6 col-lg-3">

            <div class="impact-stat-card">

              <div class="impact-stat-icon">

                <i class="uil uil-users-alt"></i>

              </div>

              <strong>

                1.250+

              </strong>

              <span>

                Masyarakat Terlibat

              </span>

              <p>

                Peserta yang mendapatkan edukasi
                dan pendampingan.

              </p>

            </div>

          </div>


          <!-- ITEM 2 -->

          <div class="col-6 col-lg-3">

            <div class="impact-stat-card">

              <div class="impact-stat-icon">

                <i class="uil uil-presentation"></i>

              </div>

              <strong>

                50+

              </strong>

              <span>

                Kegiatan

              </span>

              <p>

                Program penyuluhan, edukasi,
                dan pemberdayaan masyarakat.

              </p>

            </div>

          </div>


          <!-- ITEM 3 -->

          <div class="col-6 col-lg-3">

            <div class="impact-stat-card">

              <div class="impact-stat-icon">

                <i class="uil uil-map-marker"></i>

              </div>

              <strong>

                15+

              </strong>

              <span>

                Wilayah

              </span>

              <p>

                Wilayah yang menjadi lokasi
                kegiatan pengabdian.

              </p>

            </div>

          </div>


          <!-- ITEM 4 -->

          <div class="col-6 col-lg-3">

            <div class="impact-stat-card">

              <div class="impact-stat-icon">

                <i class="uil uil-handshake"></i>

              </div>

              <strong>

                25+

              </strong>

              <span>

                Mitra

              </span>

              <p>

                Institusi dan komunitas yang
                terlibat dalam program.

              </p>

            </div>

          </div>

        </div>


        <!-- IMPACT AREAS -->

        <div class="row align-items-center gy-6">

          <div class="col-lg-6">

            <div class="impact-content">

              <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

                Our Impact

              </span>

              <h3 class="display-6 mb-4">

                Dari Edukasi
                Menjadi Perubahan

              </h3>

              <p>

                Pengabdian masyarakat tidak hanya berorientasi
                pada pelaksanaan kegiatan, tetapi juga pada
                peningkatan pemahaman dan kemampuan masyarakat
                dalam menghadapi persoalan hukum.

              </p>

              <p>

                Melalui pendekatan edukatif dan kolaboratif,
                sivitas akademika berupaya menjadikan ilmu hukum
                lebih dekat, mudah dipahami, dan bermanfaat
                dalam kehidupan sehari-hari.

              </p>

            </div>

          </div>


          <div class="col-lg-6">

            <div class="impact-list">

              <div class="impact-list-item">

                <div class="impact-check">

                  <i class="uil uil-check"></i>

                </div>

                <div>

                  <h5>

                    Peningkatan Literasi Hukum

                  </h5>

                  <p>

                    Masyarakat memperoleh pemahaman yang lebih
                    baik mengenai hak dan kewajiban hukum.

                  </p>

                </div>

              </div>


              <div class="impact-list-item">

                <div class="impact-check">

                  <i class="uil uil-check"></i>

                </div>

                <div>

                  <h5>

                    Akses Informasi Hukum

                  </h5>

                  <p>

                    Informasi hukum disampaikan dengan bahasa
                    yang mudah dipahami masyarakat.

                  </p>

                </div>

              </div>


              <div class="impact-list-item">

                <div class="impact-check">

                  <i class="uil uil-check"></i>

                </div>

                <div>

                  <h5>

                    Pemberdayaan Masyarakat

                  </h5>

                  <p>

                    Mendorong masyarakat lebih mandiri dalam
                    mengenali dan menghadapi persoalan hukum.

                  </p>

                </div>

              </div>


              <div class="impact-list-item">

                <div class="impact-check">

                  <i class="uil uil-check"></i>

                </div>

                <div>

                  <h5>

                    Kolaborasi Berkelanjutan

                  </h5>

                  <p>

                    Membangun hubungan berkelanjutan antara
                    kampus, pemerintah, komunitas, dan masyarakat.

                  </p>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </section>
    <section class="wrapper bg-light">

      <div class="container py-15 py-md-17">

        <!-- HEADING -->

        <div class="row align-items-end mb-10">

          <div class="col-lg-7">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

              Community Gallery

            </span>

            <h2 class="display-5 mb-3">

              Galeri Kegiatan Pengabdian

            </h2>

            <p class="lead mb-0">

              Dokumentasi berbagai kegiatan pengabdian masyarakat,
              mulai dari penyuluhan hukum, pendampingan, literasi,
              hingga kolaborasi bersama masyarakat dan mitra.

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

        <div class="community-gallery">

          <!-- LARGE -->

          <div class="community-gallery-item gallery-large">

            <img
              src="./assets/img/community/gallery/penyuluhan.png"
              alt="Penyuluhan Hukum kepada Masyarakat">

            <div class="community-gallery-overlay">

              <span>

                Penyuluhan Hukum

              </span>

              <h3>

                Edukasi Hukum
                kepada Masyarakat

              </h3>

              <small>

                Kegiatan Pengabdian Masyarakat

              </small>

            </div>

          </div>


          <!-- ITEM 2 -->

          <div class="community-gallery-item">

            <img
              src="./assets/img/community/gallery/pendampingan.png"
              alt="Pendampingan Hukum">

            <div class="community-gallery-overlay">

              <span>

                Pendampingan

              </span>

              <h5>

                Konsultasi Hukum

              </h5>

            </div>

          </div>


          <!-- ITEM 3 -->

          <div class="community-gallery-item">

            <img
              src="./assets/img/community/gallery/desa.png"
              alt="Desa Sadar Hukum">

            <div class="community-gallery-overlay">

              <span>

                Desa Binaan

              </span>

              <h5>

                Desa Sadar Hukum

              </h5>

            </div>

          </div>


          <!-- ITEM 4 -->

          <div class="community-gallery-item">

            <img
              src="./assets/img/community/gallery/umkm.png"
              alt="Pendampingan UMKM">

            <div class="community-gallery-overlay">

              <span>

                UMKM

              </span>

              <h5>

                Pendampingan Legalitas Usaha

              </h5>

            </div>

          </div>


          <!-- ITEM 5 -->

          <div class="community-gallery-item">

            <img
              src="./assets/img/community/gallery/literasi.png"
              alt="Literasi Hukum">

            <div class="community-gallery-overlay">

              <span>

                Literasi Hukum

              </span>

              <h5>

                Edukasi Generasi Muda

              </h5>

            </div>

          </div>


          <!-- ITEM 6 -->

          <div class="community-gallery-item">

            <img
              src="./assets/img/community/gallery/kolaborasi.png"
              alt="Kolaborasi Pengabdian">

            <div class="community-gallery-overlay">

              <span>

                Collaboration

              </span>

              <h5>

                Kolaborasi Bersama Mitra

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