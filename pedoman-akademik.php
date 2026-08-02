<!DOCTYPE html>
<html lang="en">

<?php
$page = "Home";
require 'head.php';
?>
<style>
  .handbook-info {

    display: flex;

    gap: 18px;

    align-items: center;

    padding: 20px;

    background: #fff;

    border-radius: 20px;

    height: 100%;

    box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

    transition: .35s;

  }

  .handbook-info:hover {

    transform: translateY(-6px);

    box-shadow: 0 20px 40px rgba(106, 61, 168, .12);

  }

  .info-icon {

    width: 65px;

    height: 65px;

    background: #F3EEFD;

    border-radius: 18px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 30px;

    flex-shrink: 0;

  }

  .handbook-info h5 {

    margin-bottom: 6px;

  }

  .handbook-info small {

    color: #666;

  }

  .nav-guide-card {

    background: #fff;

    border-radius: 22px;

    padding: 30px 20px;

    text-align: center;

    height: 100%;

    transition: .35s;

    border: 1px solid #ECECEC;

    box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

    cursor: pointer;

  }

  .nav-guide-card:hover {

    transform: translateY(-8px);

    box-shadow: 0 20px 45px rgba(106, 61, 168, .15);

    border-color: #6A3DA8;

  }

  .nav-guide-icon {

    width: 80px;

    height: 80px;

    margin: auto;

    margin-bottom: 20px;

    background: #F4EEFD;

    border-radius: 22px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 40px;

    transition: .3s;

  }

  .nav-guide-card:hover .nav-guide-icon {

    background: #6A3DA8;

    color: #fff;

    transform: rotate(8deg);

  }

  .nav-guide-card h5 {

    margin-bottom: 8px;

    color: #222;

  }

  .nav-guide-card small {

    color: #777;

  }

  .academic-roadmap {

    display: flex;

    align-items: flex-start;

    gap: 10px;

    overflow-x: auto;

    padding: 20px 0;

  }

  .roadmap-item {

    min-width: 220px;

    text-align: center;

  }

  .roadmap-number {

    width: 42px;

    height: 42px;

    margin: auto;

    margin-bottom: 15px;

    background: #6A3DA8;

    color: #fff;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    font-weight: 700;

  }

  .roadmap-icon {

    width: 90px;

    height: 90px;

    margin: auto;

    background: #fff;

    border-radius: 22px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 42px;

    box-shadow: 0 15px 35px rgba(0, 0, 0, .08);

    margin-bottom: 20px;

    transition: .35s;

  }

  .roadmap-item:hover .roadmap-icon {

    background: #6A3DA8;

    color: #fff;

    transform: translateY(-8px);

  }

  .roadmap-line {

    height: 5px;

    background: #D9CCF4;

    flex: 1;

    min-width: 70px;

    margin-top: 70px;

    border-radius: 50px;

  }

  .roadmap-item h5 {

    margin-bottom: 10px;

  }

  .roadmap-item p {

    font-size: 14px;

    color: #666;

    margin: 0;

  }

  .rule-card {

    background: #fff;

    border: 1px solid #ECECEC;

    border-radius: 22px;

    padding: 35px 25px;

    text-align: center;

    height: 100%;

    transition: .35s;

    box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

  }

  .rule-card:hover {

    transform: translateY(-8px);

    border-color: #6A3DA8;

    box-shadow: 0 20px 45px rgba(106, 61, 168, .15);

  }

  .rule-icon {

    width: 85px;

    height: 85px;

    margin: auto;

    margin-bottom: 20px;

    border-radius: 22px;

    background: #F4EEFD;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 40px;

    transition: .35s;

  }

  .rule-card:hover .rule-icon {

    background: #6A3DA8;

    color: #fff;

    transform: rotate(10deg);

  }

  .rule-card h4 {

    margin-bottom: 10px;

  }

  .rule-card h2 {

    font-size: 34px;

    font-weight: 700;

    margin-bottom: 15px;

  }

  .rule-card p {

    color: #666;

    margin: 0;

    font-size: 14px;

  }

  .rights-card,
  .obligation-card {

    background: #fff;

    border-radius: 24px;

    padding: 40px;

    height: 100%;

    box-shadow: 0 18px 45px rgba(0, 0, 0, .08);

    transition: .35s;

  }

  .rights-card:hover,
  .obligation-card:hover {

    transform: translateY(-8px);

  }

  .rights-header {

    display: flex;

    align-items: center;

    gap: 20px;

    margin-bottom: 30px;

  }

  .rights-icon {

    width: 75px;

    height: 75px;

    border-radius: 20px;

    background: #28a745;

    color: #fff;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 34px;

    flex-shrink: 0;

  }

  .rights-list {

    list-style: none;

    padding: 0;

    margin: 0;

  }

  .rights-list li {

    padding: 14px 0;

    border-bottom: 1px dashed #E5E5E5;

    font-size: 15px;

    display: flex;

    align-items: flex-start;

    gap: 10px;

  }

  .rights-list li:last-child {

    border-bottom: none;

  }

  .procedure-wrapper {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 10px;

    overflow-x: auto;

    padding: 20px 0;

  }

  .procedure-item {

    min-width: 180px;

    text-align: center;

  }

  .procedure-icon {

    width: 90px;

    height: 90px;

    margin: auto;

    margin-bottom: 20px;

    border-radius: 50%;

    background: #6A3DA8;

    color: #fff;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 42px;

    box-shadow: 0 15px 35px rgba(0, 0, 0, .15);

    transition: .35s;

  }

  .procedure-item:hover .procedure-icon {

    transform: scale(1.08);

  }

  .procedure-arrow {

    font-size: 34px;

    color: #6A3DA8;

    flex-shrink: 0;

  }

  .procedure-item h5 {

    margin-bottom: 10px;

  }

  .procedure-item p {

    font-size: 14px;

    color: #666;

    margin: 0;

  }

  @media(max-width:991px) {

    .procedure-wrapper {

      justify-content: flex-start;

    }

  }

  .doc-center-card {

    background: #fff;

    border-radius: 24px;

    padding: 30px;

    height: 100%;

    border: 1px solid #ECECEC;

    transition: .35s;

    box-shadow: 0 15px 35px rgba(0, 0, 0, .05);

  }

  .doc-center-card:hover {

    transform: translateY(-8px);

    box-shadow: 0 20px 45px rgba(106, 61, 168, .15);

    border-color: #6A3DA8;

  }

  .doc-top {

    display: flex;

    justify-content: space-between;

    align-items: center;

  }

  .doc-icon {

    width: 80px;

    height: 80px;

    border-radius: 20px;

    background: #F3EEFD;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 42px;

    transition: .35s;

  }

  .doc-center-card:hover .doc-icon {

    background: #6A3DA8;

    color: #fff;

    transform: rotate(8deg);

  }

  .doc-center-card h4 {

    margin-top: 20px;

    margin-bottom: 15px;

  }

  .doc-center-card p {

    min-height: 70px;

    color: #666;


  }

  .support-box {

    background: #fff;

    padding: 35px;

    border-radius: 24px;

    box-shadow: 0 15px 40px rgba(0, 0, 0, .08);

    position: sticky;

    top: 100px;

  }

  .support-icon {

    width: 90px;

    height: 90px;

    margin: auto;

    margin-bottom: 25px;

    background: #F3EEFD;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 45px;

  }

  .support-box h3 {

    text-align: center;

    margin-bottom: 15px;

  }

  .support-box p {

    text-align: center;

    color: #666;

  }

  .support-item {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 15px 0;

    border-bottom: 1px dashed #ddd;

  }

  .support-item:last-child {

    border-bottom: none;

  }

  .support-item i {

    font-size: 22px;

    color: #6A3DA8;

    width: 28px;

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
              Academic Handbook
            </span>

            <h2 class="display-4 mb-4">

              Pedoman Akademik
              STIH Graha Kirana

            </h2>

            <p class="lead mb-5">

              Pedoman Akademik merupakan acuan resmi bagi seluruh sivitas
              akademika dalam melaksanakan proses pendidikan, mulai dari
              registrasi, perkuliahan, evaluasi pembelajaran,
              hingga penyelesaian studi.

            </p>

            <div class="row g-4">

              <div class="col-md-6">

                <div class="handbook-info">

                  <div class="info-icon">

                    📚

                  </div>

                  <div>

                    <h5>
                      Kurikulum
                    </h5>

                    <small>
                      Struktur pembelajaran dan mata kuliah.
                    </small>

                  </div>

                </div>

              </div>

              <div class="col-md-6">

                <div class="handbook-info">

                  <div class="info-icon">

                    📝

                  </div>

                  <div>

                    <h5>
                      Registrasi
                    </h5>

                    <small>
                      Prosedur administrasi akademik.
                    </small>

                  </div>

                </div>

              </div>

              <div class="col-md-6">

                <div class="handbook-info">

                  <div class="info-icon">

                    ⚖️

                  </div>

                  <div>

                    <h5>
                      Tata Tertib
                    </h5>

                    <small>
                      Etika dan peraturan akademik mahasiswa.
                    </small>

                  </div>

                </div>

              </div>

              <div class="col-md-6">

                <div class="handbook-info">

                  <div class="info-icon">

                    🎓

                  </div>

                  <div>

                    <h5>
                      Kelulusan
                    </h5>

                    <small>
                      Skripsi, yudisium, dan wisuda.
                    </small>

                  </div>

                </div>

              </div>

            </div>

            <div class="mt-5">

              <a href="#"
                class="btn btn-primary rounded-pill me-3">

                📘 Download Pedoman

              </a>

              <a href="#"
                class="btn btn-outline-primary rounded-pill">

                📑 Lihat Daftar Isi

              </a>

            </div>

          </div>

          <!-- RIGHT -->

          <div class="col-lg-6">

            <img src="./assets/img/pedoman-akademik.png"
              class="img-fluid rounded-4 shadow-lg"
              alt="Pedoman Akademik">

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
              Quick Navigation
            </span>

            <h2 class="display-5 mb-3">
              Jelajahi Pedoman Akademik
            </h2>

            <p class="lead">
              Pilih kategori pedoman yang ingin Anda pelajari.
              Seluruh informasi telah dikelompokkan agar mudah diakses.
            </p>

          </div>

        </div>

        <div class="row g-4">

          <div class="col-6 col-lg-3">

            <a href="#kurikulum" class="text-decoration-none">

              <div class="nav-guide-card">

                <div class="nav-guide-icon">
                  📚
                </div>

                <h5>Kurikulum</h5>

                <small>Struktur Mata Kuliah</small>

              </div>

            </a>

          </div>

          <div class="col-6 col-lg-3">

            <a href="#registrasi" class="text-decoration-none">

              <div class="nav-guide-card">

                <div class="nav-guide-icon">
                  📝
                </div>

                <h5>Registrasi</h5>

                <small>KRS & Administrasi</small>

              </div>

            </a>

          </div>

          <div class="col-6 col-lg-3">

            <a href="#perkuliahan" class="text-decoration-none">

              <div class="nav-guide-card">

                <div class="nav-guide-icon">
                  👨‍🏫
                </div>

                <h5>Perkuliahan</h5>

                <small>Proses Belajar</small>

              </div>

            </a>

          </div>

          <div class="col-6 col-lg-3">

            <a href="#penilaian" class="text-decoration-none">

              <div class="nav-guide-card">

                <div class="nav-guide-icon">
                  📊
                </div>

                <h5>Penilaian</h5>

                <small>UTS • UAS • Nilai</small>

              </div>

            </a>

          </div>

          <div class="col-6 col-lg-3">

            <a href="#skripsi" class="text-decoration-none">

              <div class="nav-guide-card">

                <div class="nav-guide-icon">
                  📖
                </div>

                <h5>Skripsi</h5>

                <small>Tugas Akhir</small>

              </div>

            </a>

          </div>

          <div class="col-6 col-lg-3">

            <a href="#wisuda" class="text-decoration-none">

              <div class="nav-guide-card">

                <div class="nav-guide-icon">
                  🎓
                </div>

                <h5>Wisuda</h5>

                <small>Kelulusan</small>

              </div>

            </a>

          </div>

          <div class="col-6 col-lg-3">

            <a href="#etika" class="text-decoration-none">

              <div class="nav-guide-card">

                <div class="nav-guide-icon">
                  ⚖️
                </div>

                <h5>Etika Akademik</h5>

                <small>Tata Tertib</small>

              </div>

            </a>

          </div>

          <div class="col-6 col-lg-3">

            <a href="#administrasi" class="text-decoration-none">

              <div class="nav-guide-card">

                <div class="nav-guide-icon">
                  📄
                </div>

                <h5>Administrasi</h5>

                <small>Surat & Dokumen</small>

              </div>

            </a>

          </div>

        </div>

      </div>
    </section>
    <section class="wrapper bg-light" id="roadmap">
      <div class="container py-15 py-md-17">

        <div class="row text-center mb-12">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Academic Roadmap
            </span>

            <h2 class="display-5 mb-3">
              Alur Perjalanan Akademik Mahasiswa
            </h2>

            <p class="lead">
              Setiap mahasiswa mengikuti tahapan akademik secara
              sistematis mulai dari registrasi hingga dinyatakan lulus
              dan mengikuti prosesi wisuda.
            </p>

          </div>

        </div>

        <div class="academic-roadmap">

          <!-- STEP -->

          <div class="roadmap-item">

            <div class="roadmap-number">

              01

            </div>

            <div class="roadmap-icon">

              📝

            </div>

            <h5>

              Registrasi

            </h5>

            <p>

              Registrasi mahasiswa baru maupun daftar ulang
              setiap awal semester.

            </p>

          </div>

          <div class="roadmap-line"></div>

          <div class="roadmap-item">

            <div class="roadmap-number">

              02

            </div>

            <div class="roadmap-icon">

              📚

            </div>

            <h5>

              Pengisian KRS

            </h5>

            <p>

              Mahasiswa memilih mata kuliah sesuai
              kurikulum yang berlaku.

            </p>

          </div>

          <div class="roadmap-line"></div>

          <div class="roadmap-item">

            <div class="roadmap-number">

              03

            </div>

            <div class="roadmap-icon">

              👨‍🏫

            </div>

            <h5>

              Perkuliahan

            </h5>

            <p>

              Mengikuti proses pembelajaran
              selama satu semester.

            </p>

          </div>

          <div class="roadmap-line"></div>

          <div class="roadmap-item">

            <div class="roadmap-number">

              04

            </div>

            <div class="roadmap-icon">

              📖

            </div>

            <h5>

              Evaluasi

            </h5>

            <p>

              Quiz, tugas,
              UTS dan UAS.

            </p>

          </div>

          <div class="roadmap-line"></div>

          <div class="roadmap-item">

            <div class="roadmap-number">

              05

            </div>

            <div class="roadmap-icon">

              📄

            </div>

            <h5>

              Skripsi

            </h5>

            <p>

              Penelitian,
              seminar proposal,
              seminar hasil,
              hingga sidang.

            </p>

          </div>

          <div class="roadmap-line"></div>

          <div class="roadmap-item">

            <div class="roadmap-number">

              06

            </div>

            <div class="roadmap-icon">

              🎓

            </div>

            <h5>

              Wisuda

            </h5>

            <p>

              Yudisium,
              wisuda,
              dan resmi menjadi alumni.

            </p>

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
              Academic Regulations
            </span>

            <h2 class="display-5 mb-3">
              Peraturan Akademik Utama
            </h2>

            <p class="lead">
              Berikut merupakan ketentuan akademik yang wajib dipahami
              oleh setiap mahasiswa STIH Graha Kirana selama mengikuti
              proses pendidikan.
            </p>

          </div>

        </div>

        <div class="row g-4">

          <!-- CARD -->

          <div class="col-md-6 col-xl-3">

            <div class="rule-card">

              <div class="rule-icon">
                📅
              </div>

              <h4>Presensi</h4>

              <h2 class="text-primary">
                ≥75%
              </h2>

              <p>
                Kehadiran minimal sebagai syarat mengikuti Ujian Akhir Semester.
              </p>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="rule-card">

              <div class="rule-icon">
                📝
              </div>

              <h4>Pengisian KRS</h4>

              <h2 class="text-primary">
                Wajib
              </h2>

              <p>
                Dilaksanakan sesuai jadwal yang telah ditetapkan.
              </p>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="rule-card">

              <div class="rule-icon">
                📚
              </div>

              <h4>Beban Studi</h4>

              <h2 class="text-primary">
                144 SKS
              </h2>

              <p>
                Jumlah SKS yang harus diselesaikan untuk Program Sarjana.
              </p>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="rule-card">

              <div class="rule-icon">
                📊
              </div>

              <h4>IPK Minimum</h4>

              <h2 class="text-primary">
                2.00
              </h2>

              <p>
                Salah satu syarat penyelesaian studi sesuai ketentuan.
              </p>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="rule-card">

              <div class="rule-icon">
                📖
              </div>

              <h4>Skripsi</h4>

              <h2 class="text-primary">
                Wajib
              </h2>

              <p>
                Disusun sesuai pedoman akademik dan ketentuan program studi.
              </p>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="rule-card">

              <div class="rule-icon">
                🎓
              </div>

              <h4>Wisuda</h4>

              <h2 class="text-primary">
                Lulus
              </h2>

              <p>
                Menyelesaikan seluruh persyaratan akademik dan administrasi.
              </p>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="rule-card">

              <div class="rule-icon">
                ⚖️
              </div>

              <h4>Etika</h4>

              <h2 class="text-primary">
                Wajib
              </h2>

              <p>
                Menjunjung tinggi kode etik dan tata tertib kampus.
              </p>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="rule-card">

              <div class="rule-icon">
                📄
              </div>

              <h4>Administrasi</h4>

              <h2 class="text-primary">
                Lengkap
              </h2>

              <p>
                Tidak memiliki tunggakan administrasi akademik.
              </p>

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
              Student Rights & Responsibilities
            </span>

            <h2 class="display-5 mb-3">
              Hak dan Kewajiban Mahasiswa
            </h2>

            <p class="lead">
              Mahasiswa memiliki hak untuk memperoleh layanan akademik
              yang berkualitas sekaligus berkewajiban mematuhi seluruh
              ketentuan yang berlaku di lingkungan STIH Graha Kirana.
            </p>

          </div>

        </div>

        <div class="row g-5 align-items-stretch">

          <!-- HAK -->

          <div class="col-lg-6">

            <div class="rights-card">

              <div class="rights-header">

                <div class="rights-icon">

                  ✅

                </div>

                <div>

                  <h3 class="mb-1">

                    Hak Mahasiswa

                  </h3>

                  <p class="mb-0">

                    Fasilitas dan layanan yang diperoleh mahasiswa.

                  </p>

                </div>

              </div>

              <ul class="rights-list">

                <li>📚 Memperoleh layanan pendidikan yang berkualitas.</li>

                <li>👨‍🏫 Mendapat bimbingan akademik dari dosen pembimbing.</li>

                <li>🏛️ Menggunakan fasilitas kampus sesuai ketentuan.</li>

                <li>📖 Mengakses perpustakaan dan sumber belajar digital.</li>

                <li>🤝 Mengikuti organisasi kemahasiswaan.</li>

                <li>🏆 Mengikuti kompetisi dan program pengembangan diri.</li>

                <li>💰 Mengajukan beasiswa sesuai persyaratan.</li>

                <li>📝 Menyampaikan aspirasi melalui mekanisme yang berlaku.</li>

              </ul>

            </div>

          </div>

          <!-- KEWAJIBAN -->

          <div class="col-lg-6">

            <div class="obligation-card">

              <div class="rights-header">

                <div class="rights-icon bg-danger">

                  📌

                </div>

                <div>

                  <h3 class="mb-1">

                    Kewajiban Mahasiswa

                  </h3>

                  <p class="mb-0">

                    Tanggung jawab selama menjadi mahasiswa.

                  </p>

                </div>

              </div>

              <ul class="rights-list">

                <li>🎓 Mematuhi seluruh peraturan akademik.</li>

                <li>📅 Mengikuti perkuliahan sesuai jadwal.</li>

                <li>📝 Mengisi KRS tepat waktu.</li>

                <li>📊 Memenuhi persyaratan kehadiran minimal.</li>

                <li>⚖️ Menjaga etika dan integritas akademik.</li>

                <li>🏛️ Menjaga nama baik almamater.</li>

                <li>💳 Menyelesaikan kewajiban administrasi akademik.</li>

                <li>🤝 Menghormati dosen, tenaga kependidikan, dan sesama mahasiswa.</li>

              </ul>

            </div>

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
              Academic Procedures
            </span>

            <h2 class="display-5 mb-3">
              Prosedur Akademik Mahasiswa
            </h2>

            <p class="lead">
              Setiap proses akademik memiliki tahapan yang harus diikuti
              secara berurutan agar kegiatan perkuliahan berjalan
              dengan baik dan sesuai ketentuan.
            </p>

          </div>

        </div>

        <div class="procedure-wrapper">

          <!-- STEP 1 -->

          <div class="procedure-item">

            <div class="procedure-icon bg-success">

              📝

            </div>

            <h5>

              Registrasi

            </h5>

            <p>

              Registrasi mahasiswa baru
              atau daftar ulang.

            </p>

          </div>

          <div class="procedure-arrow">

            <i class="uil uil-arrow-right"></i>

          </div>

          <!-- STEP 2 -->

          <div class="procedure-item">

            <div class="procedure-icon bg-primary">

              📚

            </div>

            <h5>

              Pengisian KRS

            </h5>

            <p>

              Menentukan mata kuliah
              setiap semester.

            </p>

          </div>

          <div class="procedure-arrow">

            <i class="uil uil-arrow-right"></i>

          </div>

          <!-- STEP 3 -->

          <div class="procedure-item">

            <div class="procedure-icon bg-info">

              👨‍🏫

            </div>

            <h5>

              Perkuliahan

            </h5>

            <p>

              Mengikuti kegiatan
              pembelajaran.

            </p>

          </div>

          <div class="procedure-arrow">

            <i class="uil uil-arrow-right"></i>

          </div>

          <!-- STEP 4 -->

          <div class="procedure-item">

            <div class="procedure-icon bg-warning">

              📊

            </div>

            <h5>

              Evaluasi

            </h5>

            <p>

              Quiz, tugas,
              UTS dan UAS.

            </p>

          </div>

          <div class="procedure-arrow">

            <i class="uil uil-arrow-right"></i>

          </div>

          <!-- STEP 5 -->

          <div class="procedure-item">

            <div class="procedure-icon bg-danger">

              📖

            </div>

            <h5>

              Skripsi

            </h5>

            <p>

              Penelitian,
              seminar,
              sidang.

            </p>

          </div>

          <div class="procedure-arrow">

            <i class="uil uil-arrow-right"></i>

          </div>

          <!-- STEP 6 -->

          <div class="procedure-item">

            <div class="procedure-icon">

              🎓

            </div>

            <h5>

              Wisuda

            </h5>

            <p>

              Menyelesaikan studi
              dan menjadi alumni.

            </p>

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
              Document Center
            </span>

            <h2 class="display-5 mb-3">
              Unduh Dokumen Akademik
            </h2>

            <p class="lead">
              Seluruh pedoman, panduan, dan formulir akademik dapat
              diunduh melalui pusat dokumen resmi STIH Graha Kirana.
            </p>

          </div>

        </div>

        <div class="row g-4">

          <?php

          $docs = [

            [
              "📘",
              "Pedoman Akademik",
              "Panduan lengkap pelaksanaan akademik mahasiswa.",
              "PDF",
              "2.8 MB"
            ],

            [
              "📚",
              "Buku Kurikulum",
              "Struktur kurikulum dan mata kuliah setiap program studi.",
              "PDF",
              "3.4 MB"
            ],

            [
              "📝",
              "Panduan KRS",
              "Petunjuk pengisian KRS dan registrasi semester.",
              "PDF",
              "1.2 MB"
            ],

            [
              "📖",
              "Pedoman Skripsi",
              "Panduan penyusunan proposal, skripsi, dan sidang.",
              "PDF",
              "4.5 MB"
            ],

            [
              "🎓",
              "Pedoman Wisuda",
              "Persyaratan yudisium dan pelaksanaan wisuda.",
              "PDF",
              "1.8 MB"
            ],

            [
              "📄",
              "Formulir Akademik",
              "Kumpulan formulir administrasi akademik.",
              "ZIP",
              "980 KB"
            ]

          ];

          foreach ($docs as $doc) {

          ?>

            <div class="col-md-6 col-xl-4">

              <div class="doc-center-card">

                <div class="doc-top">

                  <div class="doc-icon">

                    <?= $doc[0] ?>

                  </div>

                  <div>

                    <span class="badge bg-soft-primary text-primary">

                      <?= $doc[3] ?>

                    </span>

                  </div>

                </div>

                <h4 class="mt-4">

                  <?= $doc[1] ?>

                </h4>

                <p>

                  <?= $doc[2] ?>

                </p>

                <hr>

                <div class="d-flex justify-content-between align-items-center">

                  <small class="text-muted">

                    Ukuran : <?= $doc[4] ?>

                  </small>

                  <a href="#"
                    class="btn btn-sm btn-primary rounded-pill">

                    Download

                  </a>

                </div>

              </div>

            </div>

          <?php } ?>

        </div>

      </div>
    </section>
    <section class="wrapper bg-primary">
      <div class="container py-16 py-md-18">

        <div class="row">

          <div class="col-lg-9 mx-auto text-center">

            <div style="font-size:70px;">
              📘
            </div>

            <h2 class="display-4 text-white mt-4 mb-4">

              Pedoman Akademik Program Studi

            </h2>

            <p class="lead text-white mb-5">

              Pahami setiap ketentuan akademik sejak awal agar perjalanan
              studi Anda berjalan dengan lancar. Unduh Pedoman Akademik
              terbaru atau hubungi Bagian Akademik apabila membutuhkan
              informasi lebih lanjut.

            </p>

            <div class="d-flex justify-content-center flex-wrap gap-3">

              <a href="#"
                class="btn btn-white rounded-pill btn-lg">

                📘 Download Pedoman

              </a>

              <a href="#"
                class="btn btn-outline-white rounded-pill btn-lg">

                📞 Hubungi Akademik

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
              Temukan jawaban atas berbagai pertanyaan seputar
              Pedoman Akademik STIH Graha Kirana.
            </p>

          </div>

        </div>

        <div class="row gy-5">

          <!-- FAQ -->

          <div class="col-lg-8">

            <div class="accordion accordion-wrapper" id="faqAcademic">

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq1">

                    Bagaimana cara memperoleh Pedoman Akademik terbaru?

                  </button>

                </div>

                <div id="faq1"
                  class="accordion-collapse collapse show"
                  data-bs-parent="#faqAcademic">

                  <div class="card-body">

                    Pedoman Akademik dapat diunduh melalui halaman ini
                    atau diperoleh melalui Bagian Akademik STIH Graha Kirana.

                  </div>

                </div>

              </div>

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq2">

                    Berapa minimal kehadiran untuk mengikuti UAS?

                  </button>

                </div>

                <div id="faq2"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqAcademic">

                  <div class="card-body">

                    Mahasiswa wajib memenuhi ketentuan kehadiran
                    sesuai Pedoman Akademik yang berlaku sebelum
                    mengikuti Ujian Akhir Semester.

                  </div>

                </div>

              </div>

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq3">

                    Bagaimana prosedur pengajuan cuti akademik?

                  </button>

                </div>

                <div id="faq3"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqAcademic">

                  <div class="card-body">

                    Pengajuan cuti dilakukan melalui Bagian Akademik
                    dengan memenuhi persyaratan administrasi sesuai
                    ketentuan yang berlaku.

                  </div>

                </div>

              </div>

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq4">

                    Kapan mahasiswa dapat mengambil skripsi?

                  </button>

                </div>

                <div id="faq4"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqAcademic">

                  <div class="card-body">

                    Pengambilan skripsi dilakukan setelah mahasiswa
                    memenuhi persyaratan akademik yang telah ditetapkan
                    oleh program studi.

                  </div>

                </div>

              </div>

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq5">

                    Bagaimana syarat mengikuti wisuda?

                  </button>

                </div>

                <div id="faq5"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqAcademic">

                  <div class="card-body">

                    Mahasiswa wajib menyelesaikan seluruh beban studi,
                    memenuhi persyaratan administrasi, dan mengikuti
                    proses yudisium.

                  </div>

                </div>

              </div>

            </div>

          </div>

          <!-- CONTACT -->

          <div class="col-lg-4">

            <div class="support-box">

              <div class="support-icon">

                🎓

              </div>

              <h3>

                Masih Ada Pertanyaan?

              </h3>

              <p>

                Tim Akademik siap membantu Anda memperoleh
                informasi terkait pedoman, registrasi,
                maupun proses akademik.

              </p>

              <hr>

              <div class="support-item">

                <i class="uil uil-phone"></i>

                <span>(061) 8888 9999</span>

              </div>

              <div class="support-item">

                <i class="uil uil-envelope"></i>

                <span>akademik@grahakirana.ac.id</span>

              </div>

              <div class="support-item">

                <i class="uil uil-whatsapp"></i>

                <span>+62 821-6652-4717</span>

              </div>

              <div class="d-grid mt-4">

                <a href="#"
                  class="btn btn-primary rounded-pill">

                  Hubungi Akademik

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