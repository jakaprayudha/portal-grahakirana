<!DOCTYPE html>
<html lang="en">

<?php
$page = "Home";
require 'head.php';
?>
<style>
  /* =========================================
   ORGANIZATION CHART
========================================= */

  .organization-chart {
    width: 100%;
    text-align: center;
  }

  .org-level {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
  }

  .org-row {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 35px;
    position: relative;
  }

  /* garis vertikal */

  .org-line {
    width: 2px;
    height: 40px;
    background: #6A3DA8;
    margin: 0 auto;
  }

  /* garis horizontal */

  .org-row::before {

    content: "";

    position: absolute;

    top: -22px;

    left: 50%;

    transform: translateX(-50%);

    width: 75%;

    height: 2px;

    background: #6A3DA8;

  }

  /* garis turun tiap card */

  .org-card {

    position: relative;

  }

  .org-card::before {

    content: "";

    position: absolute;

    top: -22px;

    left: 50%;

    transform: translateX(-50%);

    width: 2px;

    height: 22px;

    background: #6A3DA8;

  }

  /* card */

  .org-card {

    width: 180px;

    background: #fff;

    border-radius: 18px;

    padding: 18px 15px;

    box-shadow: 0 10px 30px rgba(0, 0, 0, .08);

    transition: .3s;

  }

  .org-card:hover {

    transform: translateY(-8px);

    box-shadow: 0 18px 45px rgba(0, 0, 0, .12);

  }

  /* foto */

  .org-card img {

    width: 72px;

    height: 72px;

    border-radius: 50%;

    object-fit: cover;

    border: 4px solid #6A3DA8;

    margin-bottom: 12px;

  }

  /* nama */

  .org-card h5 {

    font-size: 16px;

    font-weight: 700;

    margin-bottom: 4px;

    line-height: 1.4;

  }

  /* jabatan */

  .org-card p {

    font-size: 13px;

    color: #777;

    margin: 0;

  }

  /* card ketua */

  .org-card.primary {

    width: 220px;

    border-top: 4px solid #6A3DA8;

  }

  .org-card.primary img {

    width: 90px;

    height: 90px;

  }

  /* responsive */

  @media(max-width:991px) {

    .org-row {

      gap: 20px;

    }

    .org-row::before {

      display: none;

    }

    .org-card::before {

      display: none;

    }

    .org-line {

      display: none;

    }

  }

  @media(max-width:575px) {

    .org-card {

      width: 160px;

      padding: 15px;

    }

    .org-card img {

      width: 65px;

      height: 65px;

    }

    .org-card.primary {

      width: 180px;

    }

    .org-card.primary img {

      width: 80px;

      height: 80px;

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

        <div class="row text-center mb-12">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Pengurus STIH Graha Kirana
            </span>

            <h2 class="display-5 mb-3">
              Kepengurusan Sekolah Tinggi
            </h2>

            <p class="lead">
              Didukung oleh jajaran pengurus yang profesional, berintegritas,
              dan berkomitmen dalam memajukan STIH Graha Kirana.
            </p>

          </div>

        </div>

        <div class="row gy-8">

          <!-- Ketua -->
          <div class="col-lg-4">

            <div class="card shadow-lg border-0 rounded-4 h-100">

              <img src="./assets/img/ketua.jpeg"
                class="card-img-top"
                alt="Ketua">

              <div class="card-body text-center">

                <h4>
                  M.Y.F. Hafidz Nasution, S.H., LL.M.
                </h4>

                <span class="badge bg-primary mt-2">
                  Ketua STIH
                </span>

              </div>

            </div>

          </div>

          <!-- Wakil -->

          <div class="col-lg-4">

            <div class="card shadow-lg border-0 rounded-4 h-100">

              <img src="./assets/img/sample-wakil.png"
                class="card-img-top"
                alt="Wakil Ketua">

              <div class="card-body text-center">

                <h4>
                  Jaka Prayudha, S.Kom, M.Kom
                </h4>

                <span class="badge bg-primary mt-2">
                  Wakil Ketua
                </span>

              </div>

            </div>

          </div>

          <!-- Sekretaris -->

          <div class="col-lg-4">

            <div class="card shadow-lg border-0 rounded-4 h-100">

              <img src="./assets/img/sample-sekretaris.png"
                class="card-img-top"
                alt="Sekretaris">

              <div class="card-body text-center">

                <h4>
                  Meidiana Adhika, S.H.
                </h4>

                <span class="badge bg-primary mt-2">
                  Sekretaris
                </span>

              </div>

            </div>

          </div>

        </div>

      </div>
    </section>
    <section class="wrapper bg-light">
      <div class="container py-15">

        <div class="row mb-10">
          <div class="col-lg-8 mx-auto text-center">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Struktur Organisasi
            </span>

            <h2 class="display-5 mb-3">
              Struktur Kepengurusan STIH Graha Kirana
            </h2>

            <p class="lead">
              Struktur organisasi yang mendukung tata kelola perguruan tinggi
              secara profesional, transparan, dan akuntabel.
            </p>

          </div>
        </div>

        <div class="organization-chart">

          <!-- Yayasan -->
          <div class="org-level">

            <div class="org-card primary">
              <h5>Yayasan Graha Kirana</h5>
            </div>

          </div>

          <div class="org-line"></div>

          <!-- Ketua -->

          <div class="org-level">

            <div class="org-card">

              <img src="./assets/img/ketua.jpeg">

              <h5>M.Y.F. Hafidz Nasution</h5>

              <small>Ketua STIH</small>

            </div>

          </div>

          <div class="org-line"></div>

          <!-- Wakil -->

          <div class="org-row">

            <div class="org-card">
              <img src="./assets/img/sample-wakil.png">
              <h6>Wakil Ketua I</h6>
            </div>

            <div class="org-card">
              <img src="./assets/img/sample-wakil2.png">
              <h6>Wakil Ketua II</h6>
            </div>

            <div class="org-card">
              <img src="./assets/img/sample-wakil3.png">
              <h6>Wakil Ketua III</h6>
            </div>

          </div>

        </div>

      </div>
    </section>

    <section class="wrapper bg-primary">

      <div class="container py-16">

        <div class="row">

          <div class="col-lg-8 mx-auto text-center text-white">

            <i class="uil uil-users-alt fs-60 mb-4"></i>

            <h2 class="display-6 text-white">

              "Kami berkomitmen membangun tata kelola perguruan tinggi
              yang profesional, transparan, inovatif, dan berorientasi
              pada peningkatan mutu pendidikan."

            </h2>

            <p class="mt-4">

              Pengurus STIH Graha Kirana

            </p>

          </div>

        </div>

      </div>

    </section>

    <section class="wrapper bg-light">

      <div class="container py-15">

        <div class="row">

          <div class="col-lg-6">

            <h3 class="mb-4">

              Tugas dan Tanggung Jawab

            </h3>

            <ul class="icon-list bullet-bg bullet-soft-primary">

              <li><span><i class="uil uil-check"></i></span>
                <span>Menetapkan kebijakan akademik dan kelembagaan.</span>
              </li>

              <li class="mt-3"><span><i class="uil uil-check"></i></span>
                <span>Mengembangkan mutu pendidikan dan tata kelola kampus.</span>
              </li>

              <li class="mt-3"><span><i class="uil uil-check"></i></span>
                <span>Mendorong penelitian serta pengabdian kepada masyarakat.</span>
              </li>

              <li class="mt-3"><span><i class="uil uil-check"></i></span>
                <span>Membangun kerja sama dengan berbagai mitra strategis.</span>
              </li>

              <li class="mt-3">
                <span><i class="uil uil-check"></i></span>
                <span>Mengembangkan kurikulum berbasis kompetensi</span>
              </li>

              <li class="mt-3">
                <span><i class="uil uil-check"></i></span>
                <span>Meningkatkan kualitas sumber daya manusia melalui inovasi</span>
              </li>

            </ul>

          </div>

          <div class="col-lg-6">

            <img
              src="./assets/img/team.png"
              class="img-fluid rounded-4 shadow-lg">

          </div>

        </div>

      </div>

    </section>
    <section class="wrapper bg-light">
      <div class="container py-15">

        <div class="row text-center mb-10">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Dokumen Resmi
            </span>

            <h2 class="display-5 mb-3">
              Dokumen & Legalitas
            </h2>

            <p class="lead">
              Seluruh dokumen resmi sebagai bentuk transparansi dan tata kelola
              institusi yang profesional.
            </p>

          </div>

        </div>

        <div class="row gy-5">
          <div class="col-lg-4">

            <div class="card shadow-lg border-0 rounded-4 h-100">

              <div class="card-body">
                📄
                <h4>SK Pendirian</h4>

                <p>

                  Dokumen resmi yang memuat dasar pendirian STIH Graha Kirana beserta
                  legalitas institusi sesuai ketentuan peraturan perundang-undangan yang berlaku.
                </p>

                <a href="#"
                  class="btn btn-sm btn-primary rounded-pill">

                  Download Dokumen

                </a>

              </div>

            </div>

          </div>
          <div class="col-lg-4">

            <div class="card shadow-lg border-0 rounded-4 h-100">

              <div class="card-body p-7">

                🏛️

                <h4>Izin Operasional</h4>

                <p>
                  Dokumen izin operasional STIH Graha Kirana yang diterbitkan oleh
                  Kementerian Pendidikan sebagai dasar penyelenggaraan pendidikan tinggi.
                </p>

                <a href="#" class="btn btn-sm btn-primary rounded-pill">
                  Download Dokumen
                </a>

              </div>

            </div>

          </div>
          <div class="col-lg-4">

            <div class="card shadow-lg border-0 rounded-4 h-100">

              <div class="card-body p-7">
                🏆

                <h4>Sertifikat Akreditasi</h4>

                <p>
                  Informasi akreditasi institusi dan program studi sebagai bentuk
                  komitmen terhadap mutu pendidikan yang berkelanjutan dan yang berlaku
                </p>

                <a href="#" class="btn btn-sm btn-primary rounded-pill">
                  Download Dokumen
                </a>

              </div>

            </div>

          </div>
          <div class="col-lg-4">

            <div class="card shadow-lg border-0 rounded-4 h-100">

              <div class="card-body p-7">

                📘
                <h4>Statuta STIH</h4>

                <p>
                  Dokumen yang mengatur dasar penyelenggaraan, tata kelola,
                  dan arah pengembangan STIH Graha Kirana.
                </p>

                <a href="#" class="btn btn-sm btn-primary rounded-pill">
                  Download Dokumen
                </a>

              </div>

            </div>

          </div>
          <div class="col-lg-4">

            <div class="card shadow-lg border-0 rounded-4 h-100">

              <div class="card-body p-7">
                👥

                <h4>Organisasi & Tata Kerja</h4>

                <p>
                  Struktur organisasi, pembagian tugas, fungsi, dan tata kerja
                  dalam penyelenggaraan institusi secara profesional.
                </p>

                <a href="#" class="btn btn-sm btn-primary rounded-pill">
                  Download Dokumen
                </a>

              </div>

            </div>

          </div>
          <div class="col-lg-4">

            <div class="card shadow-lg border-0 rounded-4 h-100">

              <div class="card-body p-7">

                📑
                <h4>SK Pengurus</h4>

                <p>
                  Surat Keputusan pengangkatan pengurus STIH Graha Kirana
                  sesuai periode kepengurusan yang sedang berlaku.
                </p>

                <a href="#" class="btn btn-sm btn-primary rounded-pill">
                  Download Dokumen
                </a>

              </div>

            </div>

          </div>
          <div class="col-lg-4">

            <div class="card shadow-lg border-0 rounded-4 h-100">

              <div class="card-body p-7">

                📜
                <h4>Rencana Strategis (Renstra)</h4>

                <p>
                  Dokumen arah kebijakan dan strategi pengembangan STIH Graha Kirana
                  dalam mewujudkan visi, misi, dan sasaran institusi selama lima tahun.
                </p>

                <a href="#" class="btn btn-sm btn-primary rounded-pill">
                  Download Dokumen
                </a>

              </div>

            </div>

          </div>
          <div class="col-lg-4">

            <div class="card shadow-lg border-0 rounded-4 h-100">

              <div class="card-body p-7">

                ⚖️
                <h4>Kode Etik Civitas Akademika</h4>

                <p>
                  Pedoman perilaku, etika, dan profesionalisme bagi dosen,
                  tenaga kependidikan, mahasiswa, serta seluruh sivitas akademika STIH Graha Kirana.
                </p>

                <a href="#" class="btn btn-sm btn-primary rounded-pill">
                  Download Dokumen
                </a>

              </div>

            </div>

          </div>
          <div class="col-lg-4">

            <div class="card shadow-lg border-0 rounded-4 h-100">

              <div class="card-body p-7">
                📚

                <h4>Pedoman Akademik</h4>

                <p>
                  Berisi kalender akademik, peraturan perkuliahan,
                  sistem pembelajaran, evaluasi, serta ketentuan akademik mahasiswa STIH Graha Kirana.
                </p>

                <a href="#" class="btn btn-sm btn-primary rounded-pill">
                  Download Dokumen
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