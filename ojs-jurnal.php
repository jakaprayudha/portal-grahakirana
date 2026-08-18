<!DOCTYPE html>
<html lang="en">

<?php
$page = "Home";
require 'head.php';
?>
<style>
  .hero-ojs-card {

    background: rgba(255, 255, 255, .96);

    padding: 40px;

    border-radius: 28px;

    box-shadow: 0 20px 45px rgba(0, 0, 0, .15);

    color: #333;

  }

  .hero-ojs-icon {

    width: 95px;

    height: 95px;

    margin: auto;

    margin-bottom: 25px;

    background: #EEF3FF;

    border-radius: 24px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 46px;

  }

  .hero-ojs-card h3 {

    text-align: center;

    margin-bottom: 15px;

  }

  .hero-ojs-card p {

    text-align: center;

    color: #666;

    margin-bottom: 25px;

  }

  .ojs-feature {

    display: flex;

    align-items: flex-start;

    gap: 16px;

    padding: 18px;

    background: #fff;

    border-radius: 18px;

    box-shadow: 0 10px 30px rgba(0, 0, 0, .06);

    height: 100%;

    transition: .3s;

  }

  .ojs-feature:hover {

    transform: translateY(-5px);

    box-shadow: 0 20px 40px rgba(106, 61, 168, .12);

  }

  .ojs-feature i {

    width: 55px;

    height: 55px;

    border-radius: 16px;

    background: #EEF3FF;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 24px;

    color: #6A3DA8;

    flex-shrink: 0;

  }

  .ojs-feature h6 {

    margin-bottom: 5px;

    font-weight: 700;

  }

  .ojs-feature small {

    color: #666;

    line-height: 1.6;

  }

  .journal-card {

    background: #fff;

    padding: 35px;

    border-radius: 24px;

    height: 100%;

    text-align: center;

    box-shadow: 0 15px 35px rgba(0, 0, 0, .06);

    transition: .35s;

    border: 1px solid #EEF2F7;

  }

  .journal-card:hover {

    transform: translateY(-8px);

    box-shadow: 0 25px 50px rgba(106, 61, 168, .15);

    border-color: #6A3DA8;

  }

  .journal-icon {

    width: 85px;

    height: 85px;

    margin: auto;

    margin-bottom: 25px;

    border-radius: 22px;

    background: #EEF3FF;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 38px;

    color: #6A3DA8;

    transition: .35s;

  }

  .journal-card:hover .journal-icon {

    background: #6A3DA8;

    color: #fff;

  }

  .journal-card h4 {

    margin-bottom: 15px;

    font-weight: 700;

  }

  .journal-card p {

    margin: 0;

    color: #666;

    line-height: 1.8;

  }

  .publication-flow {

    display: flex;

    align-items: center;

    justify-content: center;

    overflow-x: auto;

    padding: 20px 0;

  }

  .flow-step {

    min-width: 170px;

    text-align: center;

    position: relative;

  }

  .flow-icon {

    width: 90px;

    height: 90px;

    margin: auto;

    margin-bottom: 20px;

    border-radius: 50%;

    background: #fff;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 38px;

    color: #6A3DA8;

    box-shadow: 0 15px 35px rgba(0, 0, 0, .08);

    transition: .35s;

  }

  .flow-step:hover .flow-icon {

    background: #6A3DA8;

    color: #fff;

    transform: translateY(-8px);

  }

  .flow-step h6 {

    font-weight: 700;

    margin: 0;

  }

  .flow-line {

    width: 90px;

    height: 5px;

    background: #D8C7F7;

    border-radius: 50px;

    margin-top: -25px;

    flex-shrink: 0;

  }

  @media(max-width:992px) {

    .publication-flow {

      justify-content: flex-start;

    }

  }

  .journal-list-card {

    background: #fff;

    padding: 35px;

    border-radius: 24px;

    height: 100%;

    box-shadow: 0 15px 35px rgba(0, 0, 0, .06);

    transition: .35s;

    border: 1px solid #EEF2F7;

    display: flex;

    flex-direction: column;

  }

  .journal-list-card:hover {

    transform: translateY(-8px);

    box-shadow: 0 25px 50px rgba(106, 61, 168, .15);

  }

  .journal-logo {

    width: 85px;

    height: 85px;

    margin: auto;

    margin-bottom: 25px;

    border-radius: 22px;

    background: #EEF3FF;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 40px;

    color: #6A3DA8;

  }

  .journal-list-card h4 {

    text-align: center;

    margin-bottom: 15px;

  }

  .journal-list-card p {

    color: #666;

    text-align: center;

    flex: 1;

  }

  .journal-actions {

    display: flex;

    gap: 10px;

    justify-content: center;

    flex-wrap: wrap;

  }

  .journal-actions .btn {

    min-width: 140px;

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

              Open Journal System (OJS)

            </span>

            <h1 class="display-4 mb-4">

              Portal Jurnal Ilmiah
              <br>
              STIH Graha Kirana

            </h1>

            <p class="lead mb-5">

              Media publikasi ilmiah berbasis Open Journal Systems (OJS)
              yang mendukung proses submit artikel, peer review,
              editorial, hingga publikasi secara profesional,
              transparan, dan mudah diakses.

            </p>


            <div class="row g-4">

              <!-- ITEM 1 -->

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

                      Media publikasi karya ilmiah dosen,
                      mahasiswa, peneliti, dan praktisi hukum.

                    </small>

                  </div>

                </div>

              </div>


              <!-- ITEM 2 -->

              <div class="col-md-6">

                <div class="facility-highlight">

                  <div class="facility-icon">

                    🔍

                  </div>

                  <div>

                    <h5 class="mb-1">

                      Peer Review

                    </h5>

                    <small>

                      Proses review artikel secara akademik
                      dan terstruktur.

                    </small>

                  </div>

                </div>

              </div>


              <!-- ITEM 3 -->

              <div class="col-md-6">

                <div class="facility-highlight">

                  <div class="facility-icon">

                    🌐

                  </div>

                  <div>

                    <h5 class="mb-1">

                      Open Access

                    </h5>

                    <small>

                      Publikasi dapat diakses secara mudah
                      melalui portal jurnal.

                    </small>

                  </div>

                </div>

              </div>


              <!-- ITEM 4 -->

              <div class="col-md-6">

                <div class="facility-highlight">

                  <div class="facility-icon">

                    🏷️

                  </div>

                  <div>

                    <h5 class="mb-1">

                      DOI

                    </h5>

                    <small>

                      Mendukung identifikasi dan pengelolaan
                      publikasi ilmiah secara digital.

                    </small>

                  </div>

                </div>

              </div>

            </div>


            <!-- ACTION -->

            <div class="mt-5">

              <a href="https://ojs.grahakirana.ac.id"
                target="_blank"
                rel="noopener noreferrer"
                class="btn btn-primary rounded-pill me-3">

                <i class="uil uil-book-open me-1"></i>

                Masuk Portal OJS

              </a>

              <a href="#tentang-ojs"
                class="btn btn-outline-primary rounded-pill">

                <i class="uil uil-info-circle me-1"></i>

                Pelajari Lebih Lanjut

              </a>

            </div>

          </div>


          <!-- RIGHT -->

          <div class="col-lg-6">

            <img
              src="./assets/img/ojs/hero.png"
              class="img-fluid rounded-4 shadow-lg"
              alt="Open Journal System STIH Graha Kirana">

          </div>

        </div>

      </div>

    </section>
    <section class="wrapper bg-light" id="tentang-ojs">

      <div class="container py-15 py-md-17">

        <div class="row align-items-center gy-5">

          <!-- IMAGE -->

          <div class="col-lg-6">

            <img src="./assets/img/about/ojs.png"
              class="img-fluid rounded-4 shadow-lg"
              alt="Open Journal System">

          </div>

          <!-- CONTENT -->

          <div class="col-lg-6">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

              Tentang OJS

            </span>

            <h2 class="display-5 mb-4">

              Platform Publikasi
              Jurnal Ilmiah Digital

            </h2>

            <p class="lead mb-4">

              Open Journal Systems (OJS) merupakan platform pengelolaan
              jurnal ilmiah berbasis web yang mendukung seluruh proses
              penerbitan artikel mulai dari pengiriman naskah,
              proses review, penyuntingan, hingga publikasi secara
              elektronik.

            </p>

            <p>

              Melalui sistem ini, dosen, mahasiswa, peneliti,
              maupun praktisi hukum dapat mengirimkan artikel
              ilmiah secara online dengan proses yang transparan,
              terdokumentasi, dan sesuai standar pengelolaan jurnal
              ilmiah modern.

            </p>

            <div class="row g-3 mt-4">

              <div class="col-md-6">

                <div class="ojs-feature">

                  <i class="uil uil-upload-alt"></i>

                  <div>

                    <h6>Online Submission</h6>

                    <small>Pengiriman artikel secara online.</small>

                  </div>

                </div>

              </div>

              <div class="col-md-6">

                <div class="ojs-feature">

                  <i class="uil uil-search"></i>

                  <div>

                    <h6>Peer Review</h6>

                    <small>Proses review yang objektif.</small>

                  </div>

                </div>

              </div>

              <div class="col-md-6">

                <div class="ojs-feature">

                  <i class="uil uil-edit"></i>

                  <div>

                    <h6>Editorial Process</h6>

                    <small>Penyuntingan artikel terintegrasi.</small>

                  </div>

                </div>

              </div>

              <div class="col-md-6">

                <div class="ojs-feature">

                  <i class="uil uil-globe"></i>

                  <div>

                    <h6>Open Access</h6>

                    <small>Akses publik terhadap artikel.</small>

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

        <div class="row text-center mb-10">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

              Why Publish With Us

            </span>

            <h2 class="display-5 mb-3">

              Mengapa Memilih
              Jurnal STIH Graha Kirana?

            </h2>

            <p class="lead">

              Kami berkomitmen menghadirkan proses publikasi ilmiah
              yang profesional, transparan, serta mendukung
              pengembangan ilmu hukum melalui karya ilmiah berkualitas.

            </p>

          </div>

        </div>

        <div class="row g-4">

          <?php

          $advantages = [

            [
              "uil-check-circle",
              "Proses Peer Review",
              "Setiap artikel melalui proses penelaahan oleh reviewer yang kompeten sesuai bidang keilmuan."
            ],

            [
              "uil-globe",
              "Open Access",
              "Seluruh artikel dapat diakses secara terbuka sehingga hasil penelitian lebih mudah disebarluaskan."
            ],

            [
              "uil-file-bookmark-alt",
              "DOI Artikel",
              "Publikasi didukung dengan identitas digital (DOI) untuk meningkatkan kemudahan sitasi."
            ],

            [
              "uil-books",
              "Arsip Digital",
              "Artikel tersimpan secara elektronik dan dapat diakses kembali kapan saja."
            ],

            [
              "uil-balance-scale",
              "Fokus Ilmu Hukum",
              "Menerbitkan artikel ilmiah yang berfokus pada perkembangan ilmu hukum dan praktik hukum."
            ],

            [
              "uil-graduation-cap",
              "Mendukung Publikasi Akademik",
              "Menjadi wadah publikasi bagi dosen, mahasiswa, peneliti, dan praktisi hukum."

            ]

          ];

          foreach ($advantages as $item) {

          ?>

            <div class="col-md-6 col-xl-4">

              <div class="journal-card">

                <div class="journal-icon">

                  <i class="uil <?= $item[0] ?>"></i>

                </div>

                <h4>

                  <?= $item[1] ?>

                </h4>

                <p>

                  <?= $item[2] ?>

                </p>

              </div>

            </div>

          <?php } ?>

        </div>

      </div>

    </section>
    <section class="wrapper bg-light">

      <div class="container py-15 py-md-17">

        <!-- Heading -->

        <div class="row text-center mb-10">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

              Publication Workflow

            </span>

            <h2 class="display-5 mb-3">

              Alur Publikasi Artikel Ilmiah

            </h2>

            <p class="lead">

              Proses publikasi dilakukan secara sistematis untuk
              menjamin kualitas artikel ilmiah sebelum diterbitkan
              melalui Open Journal System (OJS).

            </p>

          </div>

        </div>

        <div class="publication-flow">

          <?php

          $flow = [

            ["uil-upload", "Submit Artikel"],

            ["uil-search", "Editorial Check"],

            ["uil-file-check-alt", "Peer Review"],

            ["uil-edit", "Revisi Penulis"],

            ["uil-pen", "Copy Editing"],

            ["uil-file-alt", "Layout & Proof"],

            ["uil-check-circle", "Published"]

          ];

          foreach ($flow as $i => $item) {

          ?>

            <div class="flow-step">

              <div class="flow-icon">

                <i class="uil <?= $item[0] ?>"></i>

              </div>

              <h6>

                <?= $item[1] ?>

              </h6>

            </div>

            <?php if ($i < count($flow) - 1) { ?>

              <div class="flow-line"></div>

            <?php } ?>

          <?php } ?>

        </div>

      </div>

    </section>
    <section class="wrapper bg-white">

      <div class="container py-15 py-md-17">

        <div class="row text-center mb-10">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

              Scientific Journals

            </span>

            <h2 class="display-5 mb-3">

              Jurnal Ilmiah STIH Graha Kirana

            </h2>

            <p class="lead">

              STIH Graha Kirana mengelola beberapa jurnal ilmiah
              sebagai media publikasi hasil penelitian dosen,
              mahasiswa, peneliti, maupun praktisi hukum.

            </p>

          </div>

        </div>

        <div class="row g-4">

          <?php

          $journals = [

            [

              "Jurnal Ilmu Hukum Graha Kirana",

              "Publikasi hasil penelitian di bidang hukum pidana, hukum perdata, hukum tata negara, hukum administrasi negara, hukum bisnis, dan perkembangan ilmu hukum.",

              "Vol. 5 No. 2",

              "https://ojs.grahakirana.ac.id/index.php/jih"

            ],

            [

              "Jurnal Kenotariatan",

              "Media publikasi ilmiah yang berfokus pada hukum kenotariatan, pertanahan, perjanjian, dan praktik kenotariatan di Indonesia.",

              "Vol. 2 No. 1",

              "https://ojs.grahakirana.ac.id/index.php/notaris"

            ],

            [

              "Jurnal Hukum & Masyarakat",

              "Mempublikasikan artikel mengenai hukum, kebijakan publik, hak asasi manusia, penyelesaian sengketa, dan pengabdian masyarakat.",

              "Vol. 1 No. 1",

              "https://ojs.grahakirana.ac.id/index.php/jhm"

            ]

          ];

          foreach ($journals as $j) {

          ?>

            <div class="col-lg-4">

              <div class="journal-list-card">

                <div class="journal-logo">

                  <i class="uil uil-book-open"></i>

                </div>

                <span class="badge bg-soft-success text-success mb-3">

                  <?= $j[2] ?>

                </span>

                <h4>

                  <?= $j[0] ?>

                </h4>

                <p>

                  <?= $j[1] ?>

                </p>

                <hr>

                <div class="journal-actions">

                  <a href="<?= $j[3] ?>"
                    target="_blank"
                    class="btn btn-primary rounded-pill">

                    <i class="uil uil-eye me-1"></i>

                    Lihat Jurnal

                  </a>

                  <a href="<?= $j[3] ?>"
                    target="_blank"
                    class="btn btn-outline-primary rounded-pill">

                    <i class="uil uil-upload me-1"></i>

                    Submit

                  </a>

                </div>

              </div>

            </div>

          <?php } ?>

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