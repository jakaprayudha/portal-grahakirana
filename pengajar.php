<!DOCTYPE html>
<html lang="en">

<?php
$page = "Home";
require 'head.php';
?>
<style>
  .teacher-card {
    transition: .35s;
    overflow: hidden;
  }

  .teacher-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 18px 45px rgba(0, 0, 0, .12) !important;
  }

  .teacher-photo {
    width: 95px;
    height: 95px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #6A3DA8;
  }

  .teacher-card h5 {
    font-size: 16px;
    line-height: 1.45;
    min-height: 48px;
  }

  .teacher-card .badge {
    font-size: 12px;
    font-weight: 600;
  }

  .teacher-card .btn {
    font-size: 13px;
  }

  .skill-pill {

    background: #fff;

    border: 1px solid #ececec;

    padding: 12px 18px;

    border-radius: 50px;

    font-weight: 600;

    transition: .3s;

    box-shadow: 0 8px 20px rgba(0, 0, 0, .05);

  }

  .skill-pill:hover {

    background: #6A3DA8;

    color: #fff;

    transform: translateY(-3px);

  }

  .commit-card {

    background: #fff;

    border-radius: 20px;

    padding: 35px;

    height: 100%;

    box-shadow: 0 15px 35px rgba(0, 0, 0, .06);

    transition: .35s;

  }

  .commit-card:hover {

    transform: translateY(-8px);

  }

  .commit-icon {

    width: 70px;

    height: 70px;

    border-radius: 18px;

    background: #F3EEFD;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 36px;

    margin-bottom: 20px;

  }

  .commit-card h4 {

    margin-bottom: 10px;

  }

  .commit-card p {

    margin: 0;

    color: #777;

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

          <div class="col-lg-6">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Tenaga Pengajar
            </span>

            <h2 class="display-5 mb-4">
              Dosen Berkualitas,
              Pendidikan Berkualitas
            </h2>

            <p class="lead mb-4">
              STIH Graha Kirana didukung oleh tenaga pengajar profesional yang berasal
              dari kalangan akademisi maupun praktisi hukum, berpengalaman dalam
              pendidikan, penelitian, dan praktik hukum.
            </p>

            <ul class="icon-list bullet-bg bullet-soft-primary">

              <li><i class="uil uil-check"></i>Dosen tetap berkualifikasi Magister & Doktor.</li>

              <li><i class="uil uil-check"></i>Praktisi hukum berpengalaman.</li>

              <li><i class="uil uil-check"></i>Aktif dalam penelitian.</li>

              <li><i class="uil uil-check"></i>Berorientasi pada pembelajaran mahasiswa.</li>

            </ul>

          </div>

          <div class="col-lg-6">

            <img src="./assets/img/dosen.png"
              class="img-fluid rounded-4 shadow-lg">

          </div>

        </div>

      </div>
    </section>
    <section class="wrapper" style="background:#6A3DA8;">
      <div class="container py-15 py-md-17">

        <!-- Heading -->
        <div class="row text-center mb-10">
          <div class="col-lg-8 mx-auto">

            <span class="badge bg-white text-primary rounded-pill mb-3">
              SDM Berkualitas
            </span>

            <h2 class="display-5 mb-4" style="color:#fff;">
              Tenaga Pengajar Profesional
            </h2>

            <p class="lead mb-0" style="color:rgba(255,255,255,.9);">
              STIH Graha Kirana didukung oleh tenaga pengajar profesional yang
              memiliki kompetensi akademik, pengalaman praktis, dan komitmen
              dalam menghasilkan lulusan hukum yang unggul serta berintegritas.
            </p>

          </div>
        </div>

        <!-- Statistik -->
        <div class="row g-4">

          <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-lg rounded-4 h-100">
              <div class="card-body text-center py-5">
                <div style="font-size:55px;">👨‍🏫</div>
                <h2 class="counter text-primary mt-3 mb-2">65+</h2>
                <h6 class="mb-0">Dosen Tetap</h6>
              </div>
            </div>
          </div>

          <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-lg rounded-4 h-100">
              <div class="card-body text-center py-5">
                <div style="font-size:55px;">🎓</div>
                <h2 class="counter text-primary mt-3 mb-2">18</h2>
                <h6 class="mb-0">Doktor (S3)</h6>
              </div>
            </div>
          </div>

          <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-lg rounded-4 h-100">
              <div class="card-body text-center py-5">
                <div style="font-size:55px;">📚</div>
                <h2 class="counter text-primary mt-3 mb-2">47</h2>
                <h6 class="mb-0">Magister (S2)</h6>
              </div>
            </div>
          </div>

          <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-lg rounded-4 h-100">
              <div class="card-body text-center py-5">
                <div style="font-size:55px;">🏆</div>
                <h2 class="counter text-primary mt-3 mb-2">24+</h2>
                <h6 class="mb-0">Tahun Pengalaman</h6>
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
              Dosen Tetap
            </span>

            <h2 class="display-5 mb-3">
              Tenaga Pengajar Berpengalaman
            </h2>

            <p class="lead">
              Dosen STIH Graha Kirana berasal dari kalangan akademisi dan praktisi
              hukum yang memiliki kompetensi di berbagai bidang keilmuan.
            </p>

          </div>

        </div>

        <!-- List Dosen -->
        <div class="row g-4">

          <?php

          $dosen = [

            ["nama" => "Dr. Ahmad Pratama, S.H., M.H.", "jabatan" => "Lektor Kepala", "bidang" => "Hukum Perdata", "foto" => "https://randomuser.me/api/portraits/men/41.jpg"],

            ["nama" => "Dr. Maya Sari, S.H., M.H.", "jabatan" => "Lektor", "bidang" => "Hukum Pidana", "foto" => "https://randomuser.me/api/portraits/women/45.jpg"],

            ["nama" => "Dr. Budi Santoso, S.H., M.H.", "jabatan" => "Lektor", "bidang" => "Hukum Tata Negara", "foto" => "https://randomuser.me/api/portraits/men/46.jpg"],

            ["nama" => "Dr. Rina Lestari, S.H., M.H.", "jabatan" => "Asisten Ahli", "bidang" => "Hukum Bisnis", "foto" => "https://randomuser.me/api/portraits/women/48.jpg"],

            ["nama" => "Andi Saputra, S.H., M.H.", "jabatan" => "Lektor", "bidang" => "Hukum Administrasi", "foto" => "https://randomuser.me/api/portraits/men/32.jpg"],

            ["nama" => "Nabila Putri, S.H., M.H.", "jabatan" => "Asisten Ahli", "bidang" => "Hukum Internasional", "foto" => "https://randomuser.me/api/portraits/women/32.jpg"],

            ["nama" => "Dr. Rudi Hartono, S.H., M.H.", "jabatan" => "Lektor", "bidang" => "Hukum HAM", "foto" => "https://randomuser.me/api/portraits/men/56.jpg"],

            ["nama" => "Dr. Sinta Dewi, S.H., M.H.", "jabatan" => "Lektor", "bidang" => "Cyber Law", "foto" => "https://randomuser.me/api/portraits/women/60.jpg"]

          ];

          foreach ($dosen as $d) {

          ?>

            <div class="col-sm-6 col-lg-4 col-xl-3">

              <div class="card border-0 shadow rounded-4 teacher-card h-100">

                <div class="card-body text-center p-4">

                  <img src="<?= $d['foto']; ?>" class="teacher-photo mb-3">

                  <h5 class="mb-1">
                    <?= $d['nama']; ?>
                  </h5>

                  <small class="text-primary fw-bold d-block mb-2">
                    <?= $d['jabatan']; ?>
                  </small>

                  <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
                    <?= $d['bidang']; ?>
                  </span>

                  <div>

                    <a href="#" class="btn btn-sm btn-primary rounded-pill px-3">
                      Profil
                    </a>

                  </div>

                </div>

              </div>

            </div>

          <?php } ?>

        </div>

      </div>
    </section>
    <section class="wrapper bg-light">
      <div class="container py-15 py-md-17">

        <div class="row align-items-center gy-10">

          <!-- LEFT -->

          <div class="col-lg-6">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Keunggulan Akademik
            </span>

            <h2 class="display-5 mb-4">
              Dosen Profesional dengan Beragam Bidang Keahlian
            </h2>

            <p class="lead mb-5">
              STIH Graha Kirana didukung oleh tenaga pengajar yang memiliki
              kompetensi di berbagai bidang ilmu hukum serta berkomitmen
              mengembangkan pendidikan melalui pengajaran, penelitian,
              pengabdian, dan kolaborasi akademik.
            </p>

            <!-- Badge -->

            <div class="d-flex flex-wrap gap-2">

              <span class="skill-pill">⚖️ Hukum Perdata</span>
              <span class="skill-pill">👮 Hukum Pidana</span>
              <span class="skill-pill">🏛️ Tata Negara</span>
              <span class="skill-pill">🏦 Hukum Bisnis</span>
              <span class="skill-pill">🌍 Internasional</span>
              <span class="skill-pill">📜 Administrasi Negara</span>
              <span class="skill-pill">💻 Cyber Law</span>
              <span class="skill-pill">🤝 Mediasi</span>
              <span class="skill-pill">📚 Legal Drafting</span>
              <span class="skill-pill">🏠 Agraria</span>
              <span class="skill-pill">🛡️ HAM</span>
              <span class="skill-pill">🌱 Lingkungan</span>

            </div>

          </div>

          <!-- RIGHT -->

          <div class="col-lg-6">

            <div class="row g-4">

              <div class="col-6">

                <div class="commit-card">

                  <div class="commit-icon">
                    📖
                  </div>

                  <h4>Pendidikan</h4>

                  <p>
                    Pembelajaran inovatif yang berpusat pada mahasiswa.
                  </p>

                </div>

              </div>

              <div class="col-6">

                <div class="commit-card">

                  <div class="commit-icon">
                    🔬
                  </div>

                  <h4>Penelitian</h4>

                  <p>
                    Menghasilkan publikasi ilmiah dan riset berkualitas.
                  </p>

                </div>

              </div>

              <div class="col-6">

                <div class="commit-card">

                  <div class="commit-icon">
                    🤝
                  </div>

                  <h4>Pengabdian</h4>

                  <p>
                    Memberikan kontribusi nyata kepada masyarakat.
                  </p>

                </div>

              </div>

              <div class="col-6">

                <div class="commit-card">

                  <div class="commit-icon">
                    🌏
                  </div>

                  <h4>Kolaborasi</h4>

                  <p>
                    Menjalin kerja sama akademik nasional maupun internasional.
                  </p>

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