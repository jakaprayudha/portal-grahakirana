<!DOCTYPE html>
<html lang="en">

<?php
$page = "Home";
require 'head.php';
?>
<style>
  .quick-service {

    display: block;

    text-align: center;

    background: #fff;

    border-radius: 22px;

    padding: 35px 20px;

    text-decoration: none;

    color: #333;

    transition: .35s;

    border: 1px solid #EEE;

    box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

    height: 100%;

  }

  .quick-service:hover {

    transform: translateY(-8px);

    box-shadow: 0 20px 45px rgba(106, 61, 168, .15);

    border-color: #6A3DA8;

    color: #6A3DA8;

  }

  .quick-icon {

    width: 85px;

    height: 85px;

    border-radius: 50%;

    background: #F4EEFD;

    display: flex;

    align-items: center;

    justify-content: center;

    margin: auto;

    font-size: 42px;

    margin-bottom: 20px;

    transition: .3s;

  }

  .quick-service:hover .quick-icon {

    background: #6A3DA8;

    color: #fff;

    transform: rotate(8deg) scale(1.08);

  }

  .quick-service h5 {

    margin-bottom: 8px;

    font-weight: 700;

  }

  .quick-service small {

    color: #777;

    display: block;

  }

  .service-list {

    display: flex;

    gap: 18px;

    padding: 20px;

    background: #fff;

    border-radius: 18px;

    height: 100%;

    transition: .35s;

    box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

  }

  .service-list:hover {

    transform: translateY(-6px);

    box-shadow: 0 18px 40px rgba(106, 61, 168, .12);

  }

  .service-icon {

    width: 65px;

    height: 65px;

    border-radius: 18px;

    background: #F3EEFD;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 30px;

    flex-shrink: 0;

  }

  .service-list h5 {

    margin-bottom: 8px;

  }

  .service-list p {

    margin: 0;

    font-size: 14px;

    color: #666;

  }

  .scholarship-card {

    background: #fff;

    border-radius: 22px;

    padding: 35px;

    height: 100%;

    transition: .35s;

    border: 1px solid #ECECEC;

    box-shadow: 0 15px 35px rgba(0, 0, 0, .05);

  }

  .scholarship-card:hover {

    transform: translateY(-10px);

    box-shadow: 0 20px 45px rgba(106, 61, 168, .15);

  }

  .scholarship-icon {

    width: 80px;

    height: 80px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 40px;

    margin-bottom: 20px;

  }

  .scholarship-card h4 {

    margin-bottom: 15px;

  }

  .scholarship-card p {

    color: #666;

    min-height: 90px;

  }

  .student-flow {

    position: relative;

  }

  .flow-item {

    display: flex;

    gap: 20px;

    align-items: flex-start;

  }

  .flow-icon {

    width: 70px;

    height: 70px;

    background: #6A3DA8;

    color: #fff;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 30px;

    flex-shrink: 0;

  }

  .flow-item h4 {

    margin-bottom: 8px;

  }

  .flow-item p {

    margin: 0;

    color: #666;

  }

  .flow-line {

    width: 3px;

    height: 40px;

    background: #D9CCF4;

    margin: 0 0 0 34px;

  }

  .career-card {

    background: #fff;

    padding: 35px;

    border-radius: 24px;

    box-shadow: 0 20px 45px rgba(0, 0, 0, .08);

  }

  .career-item {

    display: flex;

    gap: 20px;

    align-items: flex-start;

  }

  .career-icon {

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

  .career-item p {

    margin: 0;

    color: #666;

  }

  .career-stat {

    background: rgba(255, 255, 255, .15);

    padding: 25px;

    border-radius: 18px;

    text-align: center;

    backdrop-filter: blur(8px);

  }

  .career-stat h2 {

    color: #fff;

    margin-bottom: 8px;

    font-size: 34px;

  }

  .career-stat span {

    color: #fff;

    opacity: .9;

  }

  .download-card {

    background: #fff;

    border-radius: 22px;

    padding: 30px;

    text-align: center;

    height: 100%;

    transition: .35s;

    border: 1px solid #eee;

    box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

  }

  .download-card:hover {

    transform: translateY(-8px);

    box-shadow: 0 20px 45px rgba(106, 61, 168, .12);

  }

  .download-icon {

    width: 80px;

    height: 80px;

    margin: auto;

    margin-bottom: 20px;

    border-radius: 22px;

    background: #F4EEFD;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 42px;

  }

  .download-card h5 {

    margin-bottom: 15px;

  }

  .download-card p {

    color: #666;

    min-height: 70px;

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
              Layanan Mahasiswa
            </span>

            <h2 class="display-5 mb-4">
              Mendukung Kesuksesan Mahasiswa
              Selama Masa Studi
            </h2>

            <p class="lead mb-4">
              STIH Graha Kirana menyediakan berbagai layanan akademik,
              administrasi, pengembangan minat bakat, hingga layanan karier
              guna mendukung mahasiswa berkembang secara optimal.
            </p>

            <a href="#" class="btn btn-primary rounded-pill">
              Hubungi Kemahasiswaan
            </a>

          </div>

          <div class="col-lg-6">

            <img src="./assets/img/kemahasiswaan.png"
              class="img-fluid rounded-4 shadow-lg">

          </div>

        </div>

      </div>
    </section>

    <section class="wrapper bg-white">
      <div class="container py-15 py-md-17">

        <!-- Heading -->

        <div class="row mb-10">

          <div class="col-lg-8 mx-auto text-center">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Quick Access
            </span>

            <h2 class="display-5 mb-3">
              Akses Cepat Layanan Mahasiswa
            </h2>

            <p class="lead">
              Temukan berbagai layanan mahasiswa secara cepat untuk mendukung
              aktivitas akademik, organisasi, prestasi, hingga pengembangan karier.
            </p>

          </div>

        </div>

        <div class="row g-4">

          <!-- 1 -->

          <div class="col-6 col-md-3">

            <a href="#" class="quick-service">

              <div class="quick-icon">
                🎓
              </div>

              <h5>Administrasi</h5>

              <small>
                Surat & Akademik
              </small>

            </a>

          </div>

          <!-- 2 -->

          <div class="col-6 col-md-3">

            <a href="#" class="quick-service">

              <div class="quick-icon">
                💰
              </div>

              <h5>Beasiswa</h5>

              <small>
                Bantuan Pendidikan
              </small>

            </a>

          </div>

          <!-- 3 -->

          <div class="col-6 col-md-3">

            <a href="#" class="quick-service">

              <div class="quick-icon">
                🏆
              </div>

              <h5>Prestasi</h5>

              <small>
                Mahasiswa Berprestasi
              </small>

            </a>

          </div>

          <!-- 4 -->

          <div class="col-6 col-md-3">

            <a href="#" class="quick-service">

              <div class="quick-icon">
                🤝
              </div>

              <h5>Organisasi</h5>

              <small>
                BEM • UKM • HIMA
              </small>

            </a>

          </div>

          <!-- 5 -->

          <div class="col-6 col-md-3">

            <a href="#" class="quick-service">

              <div class="quick-icon">
                💼
              </div>

              <h5>Career Center</h5>

              <small>
                Karier & Magang
              </small>

            </a>

          </div>

          <!-- 6 -->

          <div class="col-6 col-md-3">

            <a href="#" class="quick-service">

              <div class="quick-icon">
                🌍
              </div>

              <h5>MBKM</h5>

              <small>
                Kampus Merdeka
              </small>

            </a>

          </div>

          <!-- 7 -->

          <div class="col-6 col-md-3">

            <a href="#" class="quick-service">

              <div class="quick-icon">
                ❤️
              </div>

              <h5>Konseling</h5>

              <small>
                Pendampingan
              </small>

            </a>

          </div>

          <!-- 8 -->

          <div class="col-6 col-md-3">

            <a href="#" class="quick-service">

              <div class="quick-icon">
                📄
              </div>

              <h5>Download</h5>

              <small>
                Formulir
              </small>

            </a>

          </div>

        </div>

      </div>
    </section>

    <section class="wrapper bg-light">
      <div class="container py-15 py-md-17">

        <div class="row align-items-center gy-8">

          <!-- Image -->

          <div class="col-lg-6">

            <img src="./assets/img/student-services.png"
              class="img-fluid rounded-4 shadow-lg"
              alt="Layanan Mahasiswa">

          </div>

          <!-- Content -->

          <div class="col-lg-6">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Layanan Akademik
            </span>

            <h2 class="display-5 mb-4">
              Pelayanan Cepat, Mudah,
              dan Terintegrasi
            </h2>

            <p class="lead mb-5">
              STIH Graha Kirana memberikan pelayanan akademik dan administrasi
              secara profesional untuk mendukung kelancaran studi mahasiswa
              sejak awal perkuliahan hingga kelulusan.
            </p>

            <div class="row gy-4">

              <div class="col-md-6">

                <div class="service-list">

                  <div class="service-icon">📄</div>

                  <div>

                    <h5>Surat Akademik</h5>

                    <p>
                      Surat aktif kuliah, izin penelitian,
                      cuti akademik, dan surat rekomendasi.
                    </p>

                  </div>

                </div>

              </div>

              <div class="col-md-6">

                <div class="service-list">

                  <div class="service-icon">📝</div>

                  <div>

                    <h5>KRS & KHS</h5>

                    <p>
                      Pengisian KRS, cetak KHS,
                      dan monitoring hasil studi.
                    </p>

                  </div>

                </div>

              </div>

              <div class="col-md-6">

                <div class="service-list">

                  <div class="service-icon">🎓</div>

                  <div>

                    <h5>Tugas Akhir</h5>

                    <p>
                      Layanan proposal, seminar,
                      sidang skripsi, dan yudisium.
                    </p>

                  </div>

                </div>

              </div>

              <div class="col-md-6">

                <div class="service-list">

                  <div class="service-icon">💳</div>

                  <div>

                    <h5>Administrasi</h5>

                    <p>
                      Pembayaran UKT, registrasi,
                      serta layanan administrasi lainnya.
                    </p>

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

        <div class="row mb-10">

          <div class="col-lg-8 mx-auto text-center">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Program Beasiswa
            </span>

            <h2 class="display-5 mb-3">
              Kesempatan Meraih Beasiswa
            </h2>

            <p class="lead">
              STIH Graha Kirana menyediakan berbagai program beasiswa untuk
              mendukung mahasiswa berprestasi maupun yang membutuhkan bantuan
              pendidikan selama masa studi.
            </p>

          </div>

        </div>

        <div class="row g-4">

          <!-- KIP -->

          <div class="col-md-6 col-xl-3">

            <div class="scholarship-card">

              <div class="scholarship-icon bg-success-subtle">
                💚
              </div>

              <h4>KIP Kuliah</h4>

              <p>
                Bantuan biaya pendidikan dan biaya hidup bagi mahasiswa yang memenuhi persyaratan pemerintah.
              </p>

              <hr>

              <ul class="icon-list bullet-bg bullet-soft-success">

                <li><span><i class="uil uil-check"></i></span><span>Bebas UKT</span></li>
                <li><span><i class="uil uil-check"></i></span><span>Biaya Hidup</span></li>
                <li><span><i class="uil uil-check"></i></span><span>Pendampingan</span></li>

              </ul>

            </div>

          </div>

          <!-- Prestasi -->

          <div class="col-md-6 col-xl-3">

            <div class="scholarship-card">

              <div class="scholarship-icon bg-primary-subtle">
                🏆
              </div>

              <h4>Prestasi</h4>

              <p>
                Beasiswa bagi mahasiswa yang memiliki prestasi akademik maupun non-akademik di tingkat regional maupun nasional.
              </p>

              <hr>

              <ul class="icon-list bullet-bg bullet-soft-primary">

                <li><span><i class="uil uil-check"></i></span><span>IPK Tinggi</span></li>
                <li><span><i class="uil uil-check"></i></span><span>Kompetisi</span></li>
                <li><span><i class="uil uil-check"></i></span><span>Sertifikat</span></li>

              </ul>

            </div>

          </div>

          <!-- Yayasan -->

          <div class="col-md-6 col-xl-3">

            <div class="scholarship-card">

              <div class="scholarship-icon bg-warning-subtle">
                🤝
              </div>

              <h4>Yayasan</h4>

              <p>
                Dukungan pendidikan dari Yayasan Graha Kirana bagi mahasiswa yang memenuhi kriteria tertentu.
              </p>

              <hr>

              <ul class="icon-list bullet-bg bullet-soft-yellow">

                <li><span><i class="uil uil-check"></i></span><span>Seleksi Internal</span></li>
                <li><span><i class="uil uil-check"></i></span><span>Kuota Terbatas</span></li>
                <li><span><i class="uil uil-check"></i></span><span>Evaluasi Berkala</span></li>

              </ul>

            </div>

          </div>

          <!-- Mitra -->

          <div class="col-md-6 col-xl-3">

            <div class="scholarship-card">

              <div class="scholarship-icon bg-info-subtle">
                🌏
              </div>

              <h4>Mitra</h4>

              <p>
                Program beasiswa hasil kerja sama dengan instansi pemerintah, perusahaan, dan lembaga lainnya.
              </p>

              <hr>

              <ul class="icon-list bullet-bg bullet-soft-aqua">

                <li><span><i class="uil uil-check"></i></span><span>Perusahaan</span></li>
                <li><span><i class="uil uil-check"></i></span><span>Pemerintah</span></li>
                <li><span><i class="uil uil-check"></i></span><span>Lembaga</span></li>

              </ul>

            </div>

          </div>

        </div>

      </div>
    </section>

    <section class="wrapper bg-light">
      <div class="container py-15 py-md-17">

        <!-- Heading -->

        <div class="row mb-10">

          <div class="col-lg-8 mx-auto text-center">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Organisasi Mahasiswa
            </span>

            <h2 class="display-5 mb-3">
              Wadah Pengembangan Kepemimpinan
            </h2>

            <p class="lead">
              Mahasiswa didorong aktif dalam organisasi sebagai sarana
              mengembangkan kepemimpinan, komunikasi, kolaborasi,
              serta kemampuan manajerial.
            </p>

          </div>

        </div>

        <div class="row align-items-center gy-8">

          <!-- Timeline -->

          <div class="col-lg-6">

            <div class="student-flow">

              <div class="flow-item">

                <div class="flow-icon">
                  🎓
                </div>

                <div>

                  <h4>Mahasiswa Baru</h4>

                  <p>
                    Mengikuti PKKMB dan mulai mengenal kehidupan kampus.
                  </p>

                </div>

              </div>

              <div class="flow-line"></div>

              <div class="flow-item">

                <div class="flow-icon">
                  👥
                </div>

                <div>

                  <h4>Himpunan Mahasiswa</h4>

                  <p>
                    Aktif dalam kegiatan akademik dan pengembangan program studi.
                  </p>

                </div>

              </div>

              <div class="flow-line"></div>

              <div class="flow-item">

                <div class="flow-icon">
                  🏛️
                </div>

                <div>

                  <h4>BEM STIH</h4>

                  <p>
                    Mengembangkan kepemimpinan dan koordinasi kegiatan mahasiswa.
                  </p>

                </div>

              </div>

              <div class="flow-line"></div>

              <div class="flow-item">

                <div class="flow-icon">
                  🎭
                </div>

                <div>

                  <h4>Unit Kegiatan Mahasiswa</h4>

                  <p>
                    Menyalurkan minat dan bakat melalui berbagai UKM kampus.
                  </p>

                </div>

              </div>

              <div class="flow-line"></div>

              <div class="flow-item">

                <div class="flow-icon">
                  🏆
                </div>

                <div>

                  <h4>Mahasiswa Berprestasi</h4>

                  <p>
                    Berpartisipasi dalam kompetisi akademik maupun non-akademik.
                  </p>

                </div>

              </div>

            </div>

          </div>

          <!-- Gallery -->

          <div class="col-lg-6">

            <div class="row g-3">

              <div class="col-6">

                <img src="./assets/img/organization1.png"
                  class="img-fluid rounded-4 shadow">

              </div>

              <div class="col-6">

                <img src="./assets/img/organization2.png"
                  class="img-fluid rounded-4 shadow">

              </div>

              <div class="col-12">

                <img src="./assets/img/organization3.png"
                  class="img-fluid rounded-4 shadow">

              </div>

            </div>

          </div>

        </div>

      </div>
    </section>
    <section class="wrapper bg-primary">
      <div class="container py-15 py-md-17">

        <div class="row align-items-center gy-8">

          <!-- Left -->

          <div class="col-lg-6">

            <span class="badge bg-white text-primary rounded-pill mb-3">
              Career Development Center
            </span>

            <h2 class="display-5 text-white mb-4">
              Persiapkan Karier
              Sejak di Bangku Kuliah
            </h2>

            <p class="lead text-white mb-5">
              Career Development Center (CDC) STIH Graha Kirana membantu
              mahasiswa mempersiapkan diri memasuki dunia kerja melalui
              pelatihan, magang, seminar karier, hingga jaringan alumni.
            </p>

            <div class="row g-4">

              <div class="col-6">

                <div class="career-stat">

                  <h2>150+</h2>

                  <span>Perusahaan Mitra</span>

                </div>

              </div>

              <div class="col-6">

                <div class="career-stat">

                  <h2>95%</h2>

                  <span>Alumni Bekerja</span>

                </div>

              </div>

              <div class="col-6">

                <div class="career-stat">

                  <h2>40+</h2>

                  <span>Seminar Karier</span>

                </div>

              </div>

              <div class="col-6">

                <div class="career-stat">

                  <h2>80+</h2>

                  <span>Program Magang</span>

                </div>

              </div>

            </div>

          </div>

          <!-- Right -->

          <div class="col-lg-6">

            <div class="career-card">

              <div class="career-item">

                <div class="career-icon">💼</div>

                <div>

                  <h5>Career Coaching</h5>

                  <p>
                    Pendampingan karier bersama dosen dan praktisi profesional.
                  </p>

                </div>

              </div>

              <hr>

              <div class="career-item">

                <div class="career-icon">📄</div>

                <div>

                  <h5>CV & Interview</h5>

                  <p>
                    Pelatihan penyusunan CV, personal branding, dan simulasi wawancara.
                  </p>

                </div>

              </div>

              <hr>

              <div class="career-item">

                <div class="career-icon">🏢</div>

                <div>

                  <h5>Magang Industri</h5>

                  <p>
                    Kesempatan magang di kantor hukum, pengadilan, kejaksaan,
                    perusahaan, dan instansi pemerintah.
                  </p>

                </div>

              </div>

              <hr>

              <div class="career-item">

                <div class="career-icon">🤝</div>

                <div>

                  <h5>Job Fair & Rekrutmen</h5>

                  <p>
                    Akses informasi lowongan kerja dan kegiatan rekrutmen bersama mitra.
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

        <!-- Heading -->

        <div class="row mb-10">

          <div class="col-lg-8 mx-auto text-center">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Portal Digital
            </span>

            <h2 class="display-5 mb-3">
              Download Formulir & Layanan Online
            </h2>

            <p class="lead">
              Seluruh layanan administrasi mahasiswa tersedia secara digital
              sehingga dapat diakses kapan saja dan di mana saja.
            </p>

          </div>

        </div>

        <div class="row g-4">

          <!-- CARD -->

          <div class="col-md-6 col-xl-3">

            <div class="download-card">

              <div class="download-icon">
                📄
              </div>

              <h5>Surat Aktif Kuliah</h5>

              <p>
                Pengajuan surat aktif kuliah untuk berbagai keperluan.
              </p>

              <a href="#" class="btn btn-sm btn-primary rounded-pill mt-3">
                Download
              </a>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="download-card">

              <div class="download-icon">
                🎓
              </div>

              <h5>Form Cuti Akademik</h5>

              <p>
                Formulir pengajuan cuti kuliah sesuai ketentuan akademik.
              </p>

              <a href="#" class="btn btn-sm btn-primary rounded-pill mt-3">
                Download
              </a>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="download-card">

              <div class="download-icon">
                💰
              </div>

              <h5>Form Beasiswa</h5>

              <p>
                Dokumen persyaratan dan formulir pengajuan beasiswa.
              </p>

              <a href="#" class="btn btn-sm btn-primary rounded-pill mt-3">
                Download
              </a>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="download-card">

              <div class="download-icon">
                📚
              </div>

              <h5>Kalender Akademik</h5>

              <p>
                Jadwal akademik semester berjalan dalam format PDF.
              </p>

              <a href="#" class="btn btn-sm btn-primary rounded-pill mt-3">
                Download
              </a>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="download-card">

              <div class="download-icon">
                📝
              </div>

              <h5>Form Wisuda</h5>

              <p>
                Persyaratan administrasi dan formulir pendaftaran wisuda.
              </p>

              <a href="#" class="btn btn-sm btn-primary rounded-pill mt-3">
                Download
              </a>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="download-card">

              <div class="download-icon">
                📖
              </div>

              <h5>Buku Pedoman</h5>

              <p>
                Pedoman akademik dan tata tertib mahasiswa terbaru.
              </p>

              <a href="#" class="btn btn-sm btn-primary rounded-pill mt-3">
                Download
              </a>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="download-card">

              <div class="download-icon">
                🏛️
              </div>

              <h5>Template Proposal</h5>

              <p>
                Format proposal kegiatan organisasi mahasiswa.
              </p>

              <a href="#" class="btn btn-sm btn-primary rounded-pill mt-3">
                Download
              </a>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="download-card">

              <div class="download-icon">
                💻
              </div>

              <h5>Portal Akademik</h5>

              <p>
                Akses Sistem Informasi Akademik dan layanan mahasiswa.
              </p>

              <a href="#" class="btn btn-sm btn-outline-primary rounded-pill mt-3">
                Buka Portal
              </a>

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
              FAQ
            </span>

            <h2 class="display-5 mb-3">
              Pertanyaan yang Sering Diajukan
            </h2>

            <p class="lead">
              Temukan jawaban atas berbagai pertanyaan mengenai layanan akademik,
              administrasi, beasiswa, hingga kegiatan kemahasiswaan.
            </p>

          </div>

        </div>

        <div class="row gy-6">

          <!-- FAQ -->

          <div class="col-lg-8">

            <div class="accordion accordion-wrapper" id="faqAccordion">

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq1">

                    Bagaimana cara mengajukan Surat Aktif Kuliah?

                  </button>

                </div>

                <div id="faq1"
                  class="accordion-collapse collapse show"
                  data-bs-parent="#faqAccordion">

                  <div class="card-body">

                    Pengajuan dapat dilakukan melalui Portal Akademik
                    atau langsung ke Bagian Kemahasiswaan dengan
                    melampirkan identitas mahasiswa.

                  </div>

                </div>

              </div>

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq2">

                    Bagaimana prosedur pengajuan Beasiswa?

                  </button>

                </div>

                <div id="faq2"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqAccordion">

                  <div class="card-body">

                    Mahasiswa dapat melihat jadwal pembukaan beasiswa,
                    mengunduh formulir, serta mengunggah dokumen
                    melalui portal layanan mahasiswa.

                  </div>

                </div>

              </div>

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq3">

                    Bagaimana mengurus cuti akademik?

                  </button>

                </div>

                <div id="faq3"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqAccordion">

                  <div class="card-body">

                    Mahasiswa mengisi formulir cuti akademik,
                    memperoleh persetujuan dosen pembimbing,
                    kemudian mengajukannya ke BAAK.

                  </div>

                </div>

              </div>

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq4">

                    Bagaimana menghubungi Bagian Kemahasiswaan?

                  </button>

                </div>

                <div id="faq4"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqAccordion">

                  <div class="card-body">

                    Hubungi melalui email, WhatsApp resmi,
                    atau datang langsung ke kantor
                    Bagian Kemahasiswaan STIH Graha Kirana.

                  </div>

                </div>

              </div>

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq5">

                    Bagaimana cara mengakses Portal Akademik?

                  </button>

                </div>

                <div id="faq5"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqAccordion">

                  <div class="card-body">

                    Mahasiswa dapat login menggunakan NIM dan kata sandi yang diberikan
                    oleh pihak kampus melalui Portal Akademik STIH Graha Kirana.

                  </div>

                </div>

              </div>

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq6">

                    Bagaimana prosedur pengisian KRS?

                  </button>

                </div>

                <div id="faq6"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqAccordion">

                  <div class="card-body">

                    Pengisian KRS dilakukan secara online melalui Portal Akademik sesuai
                    jadwal yang telah ditetapkan dengan persetujuan Dosen Pembimbing Akademik.

                  </div>

                </div>

              </div>

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq7">

                    Bagaimana cara mendaftar kegiatan organisasi mahasiswa?

                  </button>

                </div>

                <div id="faq7"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqAccordion">

                  <div class="card-body">

                    Mahasiswa dapat mengikuti proses rekrutmen yang dibuka oleh BEM,
                    Himpunan Mahasiswa, maupun Unit Kegiatan Mahasiswa (UKM)
                    pada setiap awal semester.

                  </div>

                </div>

              </div>

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq8">

                    Bagaimana syarat mengikuti program magang?

                  </button>

                </div>

                <div id="faq8"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqAccordion">

                  <div class="card-body">

                    Mahasiswa wajib memenuhi persyaratan akademik sesuai ketentuan
                    program studi dan mengikuti prosedur pendaftaran melalui
                    Career Development Center.

                  </div>

                </div>

              </div>

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq9">

                    Bagaimana cara mengajukan wisuda?

                  </button>

                </div>

                <div id="faq9"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqAccordion">

                  <div class="card-body">

                    Mahasiswa yang telah memenuhi seluruh persyaratan akademik dapat
                    mengisi formulir pendaftaran wisuda dan melengkapi dokumen yang
                    dipersyaratkan oleh bagian akademik.

                  </div>

                </div>

              </div>

              <div class="card plain accordion-item">

                <div class="card-header">

                  <button class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq10">

                    Bagaimana jika mengalami kendala selama perkuliahan?

                  </button>

                </div>

                <div id="faq10"
                  class="accordion-collapse collapse"
                  data-bs-parent="#faqAccordion">

                  <div class="card-body">

                    Mahasiswa dapat berkonsultasi dengan Dosen Pembimbing Akademik,
                    Bagian Kemahasiswaan, atau memanfaatkan layanan konseling yang
                    disediakan oleh STIH Graha Kirana.

                  </div>

                </div>

              </div>

            </div>

          </div>

          <!-- Contact -->

          <div class="col-lg-4">

            <div class="card shadow-lg border-0 rounded-4">

              <div class="card-body text-center p-6">

                <div style="font-size:60px;">
                  🎓
                </div>

                <h4 class="mt-2">
                  Masih Ada Pertanyaan?
                </h4>

                <p>
                  Tim Kemahasiswaan siap membantu Anda mengenai layanan
                  akademik maupun administrasi.
                </p>

                <hr>

                <p class="mb-2">

                  📞 (061) 8888-8888

                </p>

                <p class="mb-4">

                  ✉ kemahasiswaan@grahakirana.ac.id

                </p>

                <a href="#"
                  class="btn btn-primary rounded-pill">

                  Hubungi Kami

                </a>

              </div>

            </div>

          </div>

        </div>

      </div>
    </section>
    <section class="wrapper bg-primary">

      <div class="container py-16 text-center">

        <span class="badge bg-white text-primary rounded-pill mb-4">
          Student Services
        </span>

        <h2 class="display-4 text-white mb-4">
          Kami Siap Mendampingi
          Perjalanan Akademik Anda
        </h2>

        <p class="lead text-white mb-5">

          Dari administrasi akademik, pengembangan organisasi,
          program beasiswa, hingga persiapan karier,
          STIH Graha Kirana berkomitmen memberikan layanan terbaik
          bagi seluruh mahasiswa.

        </p>

        <div class="d-flex justify-content-center flex-wrap gap-3">

          <a href="#"
            class="btn btn-white rounded-pill btn-lg">

            🎓 Portal Akademik

          </a>

          <a href="#"
            class="btn btn-outline-white rounded-pill btn-lg">

            📞 Hubungi Kemahasiswaan

          </a>

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