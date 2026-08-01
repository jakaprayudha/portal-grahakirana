<!DOCTYPE html>
<html lang="en">

<?php
$page = "Home";
require 'head.php';
?>
<style>
  .facility-card {
    position: relative;
    transition: .35s;
    border-top: 5px solid #6f42c1;
  }

  .facility-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(111, 66, 193, .15) !important;
  }

  .facility-icon {
    font-size: 60px;
    line-height: 1;
    margin-bottom: 20px;
  }

  .facility-number {
    position: absolute;
    top: 20px;
    right: 25px;
    font-size: 42px;
    font-weight: 700;
    color: #6f42c1;
    opacity: .08;
    user-select: none;
  }

  .facility-card h4 {
    margin-bottom: 15px;
  }

  .facility-card p {
    color: #6c757d;
    font-size: 15px;
    line-height: 1.7;
  }
</style>

<body>
  <div class="content-wrapper">
    <?php
    require 'navbar.php';
    ?>
    <section class="wrapper bg-light" id="profil">
      <div class="container py-15 py-md-17">

        <div class="row align-items-center gy-10">

          <!-- =========================
           IMAGE
      ========================== -->
          <div class="col-lg-6">

            <figure class="rounded-4 overflow-hidden shadow-lg mb-4">
              <img src="./assets/img/program-studi.png"
                class="img-fluid w-100"
                alt="Program Studi Ilmu Hukum">
            </figure>

            <!-- Informasi Program -->

            <div class="row g-3">

              <div class="col-6">

                <div class="card border-0 bg-soft-primary rounded-4 h-100">

                  <div class="card-body text-center py-4">

                    <div class="fs-30 mb-2">⚖️</div>

                    <h6 class="mb-1">
                      Akreditasi
                    </h6>

                    <strong class="text-primary">
                      Baik
                    </strong>

                  </div>

                </div>

              </div>

              <div class="col-6">

                <div class="card border-0 bg-soft-primary rounded-4 h-100">

                  <div class="card-body text-center py-4">

                    <div class="fs-30 mb-2">🎓</div>

                    <h6 class="mb-1">
                      Gelar
                    </h6>

                    <strong class="text-primary">
                      S.H.
                    </strong>

                  </div>

                </div>

              </div>

              <div class="col-6">

                <div class="card border-0 bg-soft-primary rounded-4 h-100">

                  <div class="card-body text-center py-4">

                    <div class="fs-30 mb-2">📅</div>

                    <h6 class="mb-1">
                      Lama Studi
                    </h6>

                    <strong class="text-primary">
                      8 Semester
                    </strong>

                  </div>

                </div>

              </div>

              <div class="col-6">

                <div class="card border-0 bg-soft-primary rounded-4 h-100">

                  <div class="card-body text-center py-4">

                    <div class="fs-30 mb-2">📚</div>

                    <h6 class="mb-1">
                      Total SKS
                    </h6>

                    <strong class="text-primary">
                      144 SKS
                    </strong>

                  </div>

                </div>

              </div>

            </div>

          </div>

          <!-- =========================
           CONTENT
      ========================== -->

          <div class="col-lg-6">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Program Studi
            </span>

            <h2 class="display-5 mb-4">
              Sarjana (S1) Ilmu Hukum
            </h2>

            <p class="lead mb-4">
              Program Studi S1 Ilmu Hukum STIH Graha Kirana dirancang untuk
              menghasilkan lulusan yang profesional, berintegritas, serta mampu
              menghadapi tantangan perkembangan hukum melalui pendidikan yang
              berkualitas, inovatif, dan berbasis praktik.
            </p>

            <div class="row gy-3">

              <div class="col-md-6">

                <ul class="icon-list bullet-bg bullet-soft-primary mb-0">

                  <li>
                    <span><i class="uil uil-check"></i></span>
                    <span>Kurikulum berbasis kompetensi.</span>
                  </li>

                  <li class="mt-3">
                    <span><i class="uil uil-check"></i></span>
                    <span>Dosen akademisi dan praktisi hukum.</span>
                  </li>

                  <li class="mt-3">
                    <span><i class="uil uil-check"></i></span>
                    <span>Pembelajaran berbasis studi kasus.</span>
                  </li>

                </ul>

              </div>

              <div class="col-md-6">

                <ul class="icon-list bullet-bg bullet-soft-primary mb-0">

                  <li>
                    <span><i class="uil uil-check"></i></span>
                    <span>Magang di instansi hukum.</span>
                  </li>

                  <li class="mt-3">
                    <span><i class="uil uil-check"></i></span>
                    <span>Penelitian dan pengabdian masyarakat.</span>
                  </li>

                  <li class="mt-3">
                    <span><i class="uil uil-check"></i></span>
                    <span>Pembinaan karakter dan etika profesi.</span>
                  </li>

                </ul>

              </div>

            </div>

            <!-- Statistik -->

            <div class="row text-center mt-5">

              <div class="col-6">

                <div class="border-end">

                  <h2 class="counter text-primary mb-1">
                    65+
                  </h2>

                  <p class="mb-0">
                    Dosen & Praktisi
                  </p>

                </div>

              </div>

              <div class="col-6">

                <h2 class="counter text-primary mb-1">
                  1800+
                </h2>

                <p class="mb-0">
                  Alumni
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
              Keunggulan Program Studi
            </span>

            <h2 class="display-5 mb-3">
              Mengapa Memilih Program Studi Ilmu Hukum?
            </h2>

            <p class="lead">
              Program Studi S1 Ilmu Hukum STIH Graha Kirana menghadirkan pendidikan
              hukum yang adaptif, berkualitas, dan relevan dengan kebutuhan dunia
              profesional serta perkembangan hukum nasional.
            </p>

          </div>
        </div>

        <!-- Card -->

        <div class="row gy-6">

          <div class="col-md-6 col-xl-3">

            <div class="card shadow-lg border-0 h-100">

              <div class="card-body text-center p-6">

                <div class="icon btn btn-circle btn-lg btn-soft-primary mb-4">
                  <i class="uil uil-balance-scale"></i>
                </div>

                <h4>Kurikulum Modern</h4>

                <p class="mb-0">
                  Kurikulum berbasis kompetensi yang disesuaikan dengan perkembangan
                  hukum, teknologi, dan kebutuhan dunia kerja.
                </p>

              </div>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="card shadow-lg border-0 h-100">

              <div class="card-body text-center p-6">

                <div class="icon btn btn-circle btn-lg btn-soft-primary mb-4">
                  <i class="uil uil-user-check"></i>
                </div>

                <h4>Dosen Profesional</h4>

                <p class="mb-0">
                  Didukung dosen akademisi dan praktisi hukum yang memiliki pengalaman
                  di bidang pendidikan, litigasi, maupun pemerintahan.
                </p>

              </div>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="card shadow-lg border-0 h-100">

              <div class="card-body text-center p-6">

                <div class="icon btn btn-circle btn-lg btn-soft-primary mb-4">
                  <i class="uil uil-building"></i>
                </div>

                <h4>Praktik & Magang</h4>

                <p class="mb-0">
                  Mahasiswa memperoleh pengalaman melalui magang di kantor hukum,
                  pengadilan, kejaksaan, maupun instansi pemerintah.
                </p>

              </div>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="card shadow-lg border-0 h-100">

              <div class="card-body text-center p-6">

                <div class="icon btn btn-circle btn-lg btn-soft-primary mb-4">
                  <i class="uil uil-globe"></i>
                </div>

                <h4>Berorientasi Masa Depan</h4>

                <p class="mb-0">
                  Membentuk lulusan yang berintegritas, adaptif terhadap transformasi
                  digital, dan mampu bersaing di tingkat nasional maupun global.
                </p>

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
              Profil Lulusan
            </span>

            <h2 class="display-5 mb-3">
              Peluang Karier Lulusan Ilmu Hukum
            </h2>

            <p class="lead">
              Lulusan Program Studi Ilmu Hukum STIH Graha Kirana dipersiapkan
              menjadi profesional yang kompeten, berintegritas, dan siap
              berkarier di berbagai sektor hukum maupun pemerintahan.
            </p>

          </div>
        </div>

        <!-- Career -->

        <div class="row gy-4">

          <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body text-center p-5">

                <div class="icon btn btn-circle btn-soft-primary btn-lg mb-4">
                  <i class="uil uil-balance-scale"></i>
                </div>

                <h5>Advokat</h5>

                <p class="mb-0">
                  Memberikan jasa konsultasi, pendampingan, serta pembelaan hukum kepada masyarakat.
                </p>

              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body text-center p-5">

                <div class="icon btn btn-circle btn-soft-primary btn-lg mb-4">
                  <i class="uil uil-university"></i>
                </div>

                <h5>Hakim</h5>

                <p class="mb-0">
                  Berkarier di lingkungan peradilan setelah memenuhi persyaratan profesi.
                </p>

              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body text-center p-5">

                <div class="icon btn btn-circle btn-soft-primary btn-lg mb-4">
                  <i class="uil uil-building"></i>
                </div>

                <h5>Jaksa</h5>

                <p class="mb-0">
                  Menjalankan tugas penuntutan dan penegakan hukum di lingkungan kejaksaan.
                </p>

              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body text-center p-5">

                <div class="icon btn btn-circle btn-soft-primary btn-lg mb-4">
                  <i class="uil uil-file-alt"></i>
                </div>

                <h5>Notaris / PPAT</h5>

                <p class="mb-0">
                  Menjadi pejabat umum yang berwenang membuat akta autentik sesuai ketentuan.
                </p>

              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body text-center p-5">

                <div class="icon btn btn-circle btn-soft-primary btn-lg mb-4">
                  <i class="uil uil-briefcase-alt"></i>
                </div>

                <h5>Legal Officer</h5>

                <p class="mb-0">
                  Menangani aspek hukum perusahaan, kontrak, dan kepatuhan terhadap regulasi.
                </p>

              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body text-center p-5">

                <div class="icon btn btn-circle btn-soft-primary btn-lg mb-4">
                  <i class="uil uil-book-open"></i>
                </div>

                <h5>Akademisi</h5>

                <p class="mb-0">
                  Berkarier sebagai dosen, peneliti, maupun pengembang ilmu hukum.
                </p>

              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body text-center p-5">

                <div class="icon btn btn-circle btn-soft-primary btn-lg mb-4">
                  <i class="uil uil-users-alt"></i>
                </div>

                <h5>Konsultan Hukum</h5>

                <p class="mb-0">
                  Memberikan pendampingan dan solusi hukum bagi individu maupun organisasi.
                </p>

              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
              <div class="card-body text-center p-5">

                <div class="icon btn btn-circle btn-soft-primary btn-lg mb-4">
                  <i class="uil uil-shield-check"></i>
                </div>

                <h5>ASN / Instansi Negara</h5>

                <p class="mb-0">
                  Berkontribusi di kementerian, lembaga negara, maupun pemerintah daerah.
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
              Fasilitas Pendukung
            </span>

            <h2 class="display-5 mb-3">
              Belajar dengan Fasilitas Modern
            </h2>

            <p class="lead">
              Berbagai fasilitas disediakan untuk mendukung proses pembelajaran,
              penelitian, praktik hukum, dan pengembangan kompetensi mahasiswa.
            </p>

          </div>
        </div>

        <div class="row g-4">

          <!-- Card 1 -->
          <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow rounded-4 h-100 facility-card">

              <div class="card-body text-center p-5">

                <div class="facility-number">01</div>

                <div class="facility-icon">
                  📚
                </div>

                <h4>Perpustakaan</h4>

                <p class="mb-0">
                  Koleksi buku hukum, jurnal ilmiah, e-book, dan referensi digital yang lengkap.
                </p>

              </div>

            </div>

          </div>

          <!-- Card 2 -->
          <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow rounded-4 h-100 facility-card">

              <div class="card-body text-center p-5">

                <div class="facility-number">02</div>

                <div class="facility-icon">
                  ⚖️
                </div>

                <h4>Moot Court</h4>

                <p class="mb-0">
                  Laboratorium simulasi persidangan untuk meningkatkan kemampuan praktik hukum.
                </p>

              </div>

            </div>

          </div>

          <!-- Card 3 -->
          <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow rounded-4 h-100 facility-card">

              <div class="card-body text-center p-5">

                <div class="facility-number">03</div>

                <div class="facility-icon">
                  💻
                </div>

                <h4>Laboratorium</h4>

                <p class="mb-0">
                  Laboratorium komputer modern untuk pembelajaran berbasis teknologi digital.
                </p>

              </div>

            </div>

          </div>

          <!-- Card 4 -->
          <div class="col-md-6 col-xl-3">

            <div class="card border-0 shadow rounded-4 h-100 facility-card">

              <div class="card-body text-center p-5">

                <div class="facility-number">04</div>

                <div class="facility-icon">
                  🏫
                </div>

                <h4>Smart Classroom</h4>

                <p class="mb-0">
                  Ruang kuliah modern dengan multimedia interaktif dan akses internet.
                </p>

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