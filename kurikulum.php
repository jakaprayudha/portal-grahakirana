<!DOCTYPE html>
<html lang="en">

<?php
$page = "Home";
require 'head.php';
?>
<style>
  #prodiTab {

    gap: 15px;

  }

  #prodiTab .nav-link {

    padding: 14px 26px;

    font-weight: 600;

    border: 2px solid #ECEAF6;

    color: #555;

    transition: .3s;

  }

  #prodiTab .nav-link.active {

    background: #6A3DA8;

    border-color: #6A3DA8;

    color: #fff;

  }

  #prodiTab .nav-link:hover {

    border-color: #6A3DA8;

  }

  .tab-pane {

    animation: fadeIn .35s;

  }

  @keyframes fadeIn {

    from {

      opacity: 0;

      transform: translateY(15px);

    }

    to {

      opacity: 1;

      transform: none;

    }

  }

  .semester-box {

    background: #fafafa;

    border-radius: 18px;

    padding: 20px;

    height: 100%;

    border: 1px solid #ECECEC;

    transition: .3s;

  }

  .semester-box:hover {

    background: #fff;

    transform: translateY(-5px);

    box-shadow: 0 15px 35px rgba(0, 0, 0, .08);

  }

  .semester-title {

    display: inline-block;

    background: #6A3DA8;

    color: #fff;

    padding: 8px 18px;

    border-radius: 30px;

    font-weight: 600;

    margin-bottom: 20px;

  }

  .semester-box ul {

    margin: 0;

    padding-left: 18px;

  }

  .semester-box li {

    margin-bottom: 10px;

    font-size: 14px;

  }
</style>

<body>
  <div class="content-wrapper">
    <?php
    require 'navbar.php';
    ?>
    <section class="wrapper bg-light">
      <div class="container py-15 py-md-17">

        <!-- Heading -->

        <div class="row mb-10">

          <div class="col-lg-8 mx-auto text-center">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Program Studi
            </span>

            <h2 class="display-5 mb-3">
              Pilih Program Studi
            </h2>

            <p class="lead">
              STIH Graha Kirana menghadirkan program studi yang dirancang
              untuk menghasilkan lulusan yang kompeten, profesional,
              dan siap menghadapi tantangan dunia hukum.
            </p>

          </div>

        </div>

        <!-- Nav -->

        <ul class="nav nav-pills nav-fill justify-content-center mb-5" id="prodiTab" role="tablist">

          <li class="nav-item">

            <button class="nav-link active rounded-pill"
              data-bs-toggle="pill"
              data-bs-target="#s1">

              ⚖️ S1 Ilmu Hukum

            </button>

          </li>

          <li class="nav-item">

            <button class="nav-link rounded-pill"
              data-bs-toggle="pill"
              data-bs-target="#s2">

              🎓 S2 Ilmu Hukum

            </button>

          </li>

          <li class="nav-item">

            <button class="nav-link rounded-pill"
              data-bs-toggle="pill"
              data-bs-target="#s3">

              👨‍⚖️ S3 Ilmu Hukum

            </button>

          </li>

          <li class="nav-item">

            <button class="nav-link rounded-pill"
              data-bs-toggle="pill"
              data-bs-target="#notaris">

              📜 Kenotariatan

            </button>

          </li>

        </ul>

        <!-- Content -->

        <div class="tab-content">

          <!-- ========================= -->
          <div class="tab-pane fade show active" id="s1">

            <div class="card border-0 shadow-lg rounded-4">

              <div class="card-body p-5">

                <div class="row align-items-center mb-5">

                  <div class="col-lg-7">

                    <span class="badge bg-soft-primary text-primary mb-3">
                      Program Sarjana
                    </span>

                    <h3 class="mb-3">
                      ⚖️ S1 Ilmu Hukum
                    </h3>

                    <p class="mb-4">
                      Program Sarjana Ilmu Hukum dirancang untuk menghasilkan lulusan yang
                      memiliki kemampuan analisis hukum, keterampilan profesional,
                      serta menjunjung tinggi etika dan keadilan.
                    </p>

                  </div>

                  <div class="col-lg-5">

                    <div class="row text-center">

                      <div class="col-4">

                        <h3 class="text-primary">
                          144
                        </h3>

                        <small>SKS</small>

                      </div>

                      <div class="col-4">

                        <h3 class="text-primary">
                          8
                        </h3>

                        <small>Semester</small>

                      </div>

                      <div class="col-4">

                        <h3 class="text-primary">
                          Baik
                        </h3>

                        <small>Akreditasi</small>

                      </div>

                    </div>

                  </div>

                </div>

                <hr>

                <div class="row g-4">

                  <?php

                  $semester = [

                    1 => ["Pengantar Ilmu Hukum", "Pancasila", "Bahasa Indonesia", "PKN"],

                    2 => ["Hukum Perdata", "Hukum Pidana", "HTN", "Bahasa Inggris"],

                    3 => ["HAN", "Hukum Dagang", "HI", "Etika Profesi"],

                    4 => ["Acara Perdata", "Acara Pidana", "Hukum Pajak", "Agraria"],

                    5 => ["Hukum Bisnis", "HAM", "Cyber Law", "Legal Drafting"],

                    6 => ["Moot Court", "Magang", "Mediasi", "Seminar"],

                    7 => ["KKN", "Proposal Skripsi", "Publikasi", "Seminar Hasil"],

                    8 => ["Skripsi", "Sidang", "Yudisium", "Wisuda"]

                  ];

                  foreach ($semester as $no => $mk) {

                  ?>

                    <div class="col-md-6 col-xl-3">

                      <div class="semester-box">

                        <div class="semester-title">

                          Semester <?= $no ?>

                        </div>

                        <ul>

                          <?php foreach ($mk as $m) { ?>

                            <li><?= $m ?></li>

                          <?php } ?>

                        </ul>

                      </div>

                    </div>

                  <?php } ?>

                </div>

              </div>

            </div>

          </div>

          <div class="tab-pane fade" id="s2">

            <div class="card border-0 shadow-lg rounded-4">

              <div class="card-body p-5">

                <div class="row align-items-center mb-5">

                  <div class="col-lg-7">

                    <span class="badge bg-soft-success text-success mb-3">
                      Program Magister
                    </span>

                    <h3 class="mb-3">
                      🎓 S2 Ilmu Hukum
                    </h3>

                    <p class="mb-4">
                      Program Magister Ilmu Hukum dirancang untuk menghasilkan lulusan
                      yang memiliki kemampuan analisis, penelitian, dan pengembangan
                      ilmu hukum secara mendalam serta mampu memberikan solusi terhadap
                      berbagai persoalan hukum nasional maupun internasional.
                    </p>

                  </div>

                  <div class="col-lg-5">

                    <div class="row text-center">

                      <div class="col-4">

                        <h3 class="text-success">
                          42
                        </h3>

                        <small>SKS</small>

                      </div>

                      <div class="col-4">

                        <h3 class="text-success">
                          4
                        </h3>

                        <small>Semester</small>

                      </div>

                      <div class="col-4">

                        <h3 class="text-success">
                          Baik
                        </h3>

                        <small>Akreditasi</small>

                      </div>

                    </div>

                  </div>

                </div>

                <hr>

                <div class="row g-4">

                  <?php

                  $semester = [

                    1 => [
                      "Filsafat Hukum",
                      "Teori Hukum",
                      "Metodologi Penelitian Hukum",
                      "Hukum Perbandingan"
                    ],

                    2 => [
                      "Hukum Bisnis Internasional",
                      "Hukum HAM",
                      "Kebijakan Publik",
                      "Seminar Proposal"
                    ],

                    3 => [
                      "Konsentrasi Hukum",
                      "Publikasi Ilmiah",
                      "Penelitian Tesis",
                      "Seminar Hasil"
                    ],

                    4 => [
                      "Tesis",
                      "Ujian Tesis",
                      "Publikasi Nasional",
                      "Yudisium"
                    ]

                  ];

                  foreach ($semester as $no => $mk) {

                  ?>

                    <div class="col-md-6 col-xl-3">

                      <div class="semester-box">

                        <div class="semester-title bg-success">

                          Semester <?= $no ?>

                        </div>

                        <ul>

                          <?php foreach ($mk as $m) { ?>

                            <li><?= $m ?></li>

                          <?php } ?>

                        </ul>

                      </div>

                    </div>

                  <?php } ?>

                </div>

              </div>

            </div>

          </div>

          <div class="tab-pane fade" id="s3">

            <div class="card border-0 shadow-lg rounded-4">

              <div class="card-body p-5">

                <div class="row align-items-center mb-5">

                  <div class="col-lg-7">

                    <span class="badge bg-soft-info text-info mb-3">
                      Program Doktor
                    </span>

                    <h3 class="mb-3">
                      👨‍⚖️ S3 Ilmu Hukum
                    </h3>

                    <p class="mb-4">
                      Program Doktor Ilmu Hukum bertujuan menghasilkan akademisi,
                      peneliti, serta pemimpin di bidang hukum yang mampu mengembangkan
                      ilmu pengetahuan melalui riset inovatif dan publikasi ilmiah
                      bereputasi nasional maupun internasional.
                    </p>

                  </div>

                  <div class="col-lg-5">

                    <div class="row text-center">

                      <div class="col-4">

                        <h3 class="text-info">
                          48
                        </h3>

                        <small>SKS</small>

                      </div>

                      <div class="col-4">

                        <h3 class="text-info">
                          6
                        </h3>

                        <small>Semester</small>

                      </div>

                      <div class="col-4">

                        <h3 class="text-info">
                          Unggul
                        </h3>

                        <small>Target Akreditasi</small>

                      </div>

                    </div>

                  </div>

                </div>

                <hr>

                <div class="row g-4">

                  <?php

                  $semester = [

                    1 => [
                      "Filsafat Ilmu Hukum",
                      "Teori Negara Modern",
                      "Metodologi Penelitian Lanjut",
                      "Kajian Hukum Kontemporer"
                    ],

                    2 => [
                      "Analisis Putusan Pengadilan",
                      "Comparative Legal System",
                      "Seminar Disertasi",
                      "Publikasi Ilmiah"
                    ],

                    3 => [
                      "Konsentrasi Keilmuan",
                      "Riset Disertasi I",
                      "Kolokium",
                      "Artikel Internasional"
                    ],

                    4 => [
                      "Riset Disertasi II",
                      "Seminar Hasil",
                      "Publikasi Scopus",
                      "Ujian Kelayakan"
                    ],

                    5 => [
                      "Penulisan Disertasi",
                      "Review Disertasi",
                      "Ujian Tertutup",
                      "Publikasi Nasional"
                    ],

                    6 => [
                      "Ujian Terbuka",
                      "Disertasi",
                      "Promosi Doktor",
                      "Yudisium"
                    ]

                  ];

                  foreach ($semester as $no => $mk) {

                  ?>

                    <div class="col-md-6 col-xl-4">

                      <div class="semester-box">

                        <div class="semester-title bg-info">

                          Semester <?= $no ?>

                        </div>

                        <ul>

                          <?php foreach ($mk as $m) { ?>

                            <li><?= $m ?></li>

                          <?php } ?>

                        </ul>

                      </div>

                    </div>

                  <?php } ?>

                </div>

              </div>

            </div>

          </div>

          <div class="tab-pane fade" id="notaris">

            <div class="card border-0 shadow-lg rounded-4">

              <div class="card-body p-5">

                <div class="row align-items-center mb-5">

                  <div class="col-lg-7">

                    <span class="badge bg-soft-warning text-warning mb-3">
                      Program Magister Kenotariatan
                    </span>

                    <h3 class="mb-3">
                      📜 Magister Kenotariatan (M.Kn.)
                    </h3>

                    <p class="mb-4">
                      Program Magister Kenotariatan mempersiapkan lulusan menjadi
                      profesional di bidang kenotariatan dan Pejabat Pembuat Akta Tanah (PPAT)
                      dengan kompetensi dalam penyusunan akta autentik, hukum perdata,
                      hukum bisnis, serta etika profesi notaris sesuai perkembangan
                      regulasi nasional.
                    </p>

                  </div>

                  <div class="col-lg-5">

                    <div class="row text-center">

                      <div class="col-4">

                        <h3 class="text-warning">
                          42
                        </h3>

                        <small>SKS</small>

                      </div>

                      <div class="col-4">

                        <h3 class="text-warning">
                          4
                        </h3>

                        <small>Semester</small>

                      </div>

                      <div class="col-4">

                        <h3 class="text-warning">
                          Baik
                        </h3>

                        <small>Akreditasi</small>

                      </div>

                    </div>

                  </div>

                </div>

                <hr>

                <div class="row g-4">

                  <?php

                  $semester = [

                    1 => [
                      "Hukum Perikatan",
                      "Hukum Kenotariatan",
                      "Teknik Pembuatan Akta",
                      "Etika Profesi Notaris"
                    ],

                    2 => [
                      "Hukum Pertanahan",
                      "Hukum Waris",
                      "Hukum Perusahaan",
                      "Hukum Perbankan"
                    ],

                    3 => [
                      "Praktik Kenotariatan",
                      "Hukum Pajak",
                      "Seminar Proposal",
                      "Magang Notaris"
                    ],

                    4 => [
                      "Tesis",
                      "Ujian Tesis",
                      "Publikasi Ilmiah",
                      "Yudisium"
                    ]

                  ];

                  foreach ($semester as $no => $mk) {

                  ?>

                    <div class="col-md-6 col-xl-3">

                      <div class="semester-box">

                        <div class="semester-title bg-warning text-dark">

                          Semester <?= $no ?>

                        </div>

                        <ul>

                          <?php foreach ($mk as $m) { ?>

                            <li><?= $m ?></li>

                          <?php } ?>

                        </ul>

                      </div>

                    </div>

                  <?php } ?>

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