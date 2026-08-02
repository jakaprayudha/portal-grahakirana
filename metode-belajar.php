<!DOCTYPE html>
<html lang="en">

<?php
$page = "Home";
require 'head.php';
?>
<style>
  .learning-box {

    display: flex;

    gap: 18px;

    padding: 20px;

    background: #fff;

    border-radius: 20px;

    height: 100%;

    transition: .35s;

    box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

  }

  .learning-box:hover {

    transform: translateY(-6px);

    box-shadow: 0 18px 40px rgba(106, 61, 168, .12);

  }

  .learning-icon {

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

  .learning-box h5 {

    margin-bottom: 8px;

  }

  .learning-box p {

    margin: 0;

    font-size: 14px;

    color: #666;

  }

  .learning-roadmap {

    display: flex;

    align-items: flex-start;

    justify-content: space-between;

    gap: 15px;

    overflow-x: auto;

    padding: 20px 0;

  }

  .road-item {

    min-width: 220px;

    text-align: center;

    position: relative;

  }

  .road-number {

    width: 45px;

    height: 45px;

    margin: auto;

    border-radius: 50%;

    background: #6A3DA8;

    color: #fff;

    display: flex;

    align-items: center;

    justify-content: center;

    font-weight: 700;

    margin-bottom: 18px;

  }

  .road-icon {

    width: 95px;

    height: 95px;

    margin: auto;

    border-radius: 50%;

    background: #F3EEFD;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 45px;

    margin-bottom: 20px;

    transition: .3s;

    box-shadow: 0 10px 30px rgba(0, 0, 0, .08);

  }

  .road-item:hover .road-icon {

    background: #6A3DA8;

    color: #fff;

    transform: translateY(-8px);

  }

  .road-item h4 {

    font-size: 18px;

    margin-bottom: 12px;

  }

  .road-item p {

    font-size: 14px;

    color: #666;

  }

  .road-line {

    flex: 1;

    height: 4px;

    background: #D9CCF4;

    margin-top: 65px;

    min-width: 60px;

    border-radius: 50px;

  }

  .media-card {

    background: #fff;

    border-radius: 22px;

    padding: 35px 25px;

    text-align: center;

    height: 100%;

    transition: .35s;

    box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

    border: 1px solid #eee;

  }

  .media-card:hover {

    transform: translateY(-10px);

    box-shadow: 0 20px 45px rgba(106, 61, 168, .15);

  }

  .media-icon {

    width: 85px;

    height: 85px;

    margin: auto;

    margin-bottom: 20px;

    border-radius: 22px;

    background: #F3EEFD;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 42px;

    transition: .3s;

  }

  .media-card:hover .media-icon {

    background: #6A3DA8;

    color: #fff;

    transform: rotate(10deg);

  }

  .media-card h4 {

    margin-bottom: 15px;

  }

  .media-card p {

    margin: 0;

    color: #666;

  }

  .assessment-process {

    display: flex;

    align-items: flex-start;

    justify-content: center;

    gap: 15px;

    overflow-x: auto;

    padding: 20px 0;

  }

  .assessment-item {

    min-width: 240px;

    text-align: center;

  }

  .assessment-circle {

    width: 95px;

    height: 95px;

    margin: auto;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 42px;

    color: #fff;

    margin-bottom: 20px;

    box-shadow: 0 15px 35px rgba(0, 0, 0, .15);

    transition: .35s;

  }

  .assessment-circle:hover {

    transform: scale(1.08);

  }

  .assessment-line {

    flex: 1;

    height: 5px;

    background: #D8CCF3;

    margin-top: 45px;

    min-width: 70px;

    border-radius: 50px;

  }

  .assessment-item h4 {

    margin-bottom: 12px;

  }

  .assessment-item p {

    color: #666;

    font-size: 14px;

    margin: 0;

  }

  .outcome-card {

    background: #fff;

    border-radius: 22px;

    padding: 35px;

    text-align: center;

    height: 100%;

    transition: .35s;

    border: 1px solid #ececec;

    box-shadow: 0 12px 30px rgba(0, 0, 0, .05);

  }

  .outcome-card:hover {

    transform: translateY(-8px);

    box-shadow: 0 20px 45px rgba(106, 61, 168, .15);

  }

  .outcome-icon {

    width: 90px;

    height: 90px;

    margin: auto;

    margin-bottom: 20px;

    border-radius: 50%;

    background: #F3EEFD;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 42px;

    transition: .3s;

  }

  .outcome-card:hover .outcome-icon {

    background: #6A3DA8;

    color: #fff;

    transform: rotate(10deg);

  }

  .outcome-card h4 {

    margin-bottom: 15px;

  }

  .outcome-card p {

    margin: 0;

    color: #666;

  }

  .career-box {

    background: #fff;

    border-radius: 24px;

    padding: 35px 25px;

    text-align: center;

    height: 100%;

    transition: .35s;

    border: 1px solid #eee;

    box-shadow: 0 15px 35px rgba(0, 0, 0, .05);

  }

  .career-box:hover {

    transform: translateY(-8px);

    box-shadow: 0 20px 45px rgba(106, 61, 168, .12);

  }

  .career-icon {

    width: 90px;

    height: 90px;

    margin: auto;

    margin-bottom: 20px;

    background: #F3EEFD;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 42px;

    transition: .3s;

  }

  .career-box:hover .career-icon {

    background: #6A3DA8;

    color: #fff;

    transform: rotate(8deg);

  }

  .career-box h4 {

    margin-bottom: 12px;

  }

  .career-box p {

    margin: 0;

    color: #666;

  }

  .journey {

    display: flex;

    align-items: center;

    justify-content: center;

    overflow-x: auto;

    padding: 20px 0;

  }

  .journey-item {

    min-width: 170px;

    text-align: center;

  }

  .journey-icon {

    width: 95px;

    height: 95px;

    margin: auto;

    border-radius: 50%;

    background: #fff;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 42px;

    margin-bottom: 18px;

    box-shadow: 0 15px 40px rgba(0, 0, 0, .15);

    transition: .35s;

  }

  .journey-item:hover .journey-icon {

    transform: translateY(-8px);

  }

  .journey-item h5 {

    color: #fff;

    margin-bottom: 6px;

  }

  .journey-item small {

    color: rgba(255, 255, 255, .8);

  }

  .journey-line {

    height: 4px;

    background: rgba(255, 255, 255, .35);

    flex: 1;

    min-width: 70px;

    margin-top: -40px;

  }

  .journey-stat {

    text-align: center;

    padding: 25px;

  }

  .journey-stat p {

    color: #fff;

    margin: 0;

    opacity: .9;

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
              Filosofi Pembelajaran
            </span>

            <h2 class="display-5 mb-4">
              Membangun Kompetensi Hukum
              Melalui Pembelajaran Aktif
            </h2>

            <p class="lead mb-5">
              STIH Graha Kirana menerapkan pendekatan pembelajaran modern yang
              mengintegrasikan teori, praktik, riset, dan pengalaman lapangan
              untuk menghasilkan lulusan yang profesional, kritis, dan berintegritas.
            </p>

            <div class="row g-4">

              <div class="col-md-6">

                <div class="learning-box">

                  <div class="learning-icon">
                    👨‍🏫
                  </div>

                  <div>

                    <h5>Student Centered</h5>

                    <p>
                      Mahasiswa menjadi pusat proses pembelajaran.
                    </p>

                  </div>

                </div>

              </div>

              <div class="col-md-6">

                <div class="learning-box">

                  <div class="learning-icon">
                    ⚖️
                  </div>

                  <div>

                    <h5>Case Based Learning</h5>

                    <p>
                      Analisis kasus hukum nyata sebagai media belajar.
                    </p>

                  </div>

                </div>

              </div>

              <div class="col-md-6">

                <div class="learning-box">

                  <div class="learning-icon">
                    💬
                  </div>

                  <div>

                    <h5>Collaborative</h5>

                    <p>
                      Diskusi dan kerja sama antar mahasiswa.
                    </p>

                  </div>

                </div>

              </div>

              <div class="col-md-6">

                <div class="learning-box">

                  <div class="learning-icon">
                    🔬
                  </div>

                  <div>

                    <h5>Research Based</h5>

                    <p>
                      Pembelajaran didukung penelitian ilmiah.
                    </p>

                  </div>

                </div>

              </div>

            </div>

          </div>

          <!-- RIGHT -->

          <div class="col-lg-6">

            <img
              src="./assets/img/metode-belajar.png"
              class="img-fluid rounded-4 shadow-lg"
              alt="Metode Belajar">

          </div>

        </div>

      </div>
    </section>
    <section class="wrapper bg-white">
      <div class="container py-15 py-md-17">

        <div class="row text-center mb-12">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Learning Journey
            </span>

            <h2 class="display-5 mb-3">
              Alur Metode Pembelajaran
            </h2>

            <p class="lead">
              Mahasiswa mengikuti proses pembelajaran secara bertahap mulai dari
              penguasaan teori hingga praktik profesional untuk membentuk lulusan
              yang kompeten di bidang hukum.
            </p>

          </div>

        </div>

        <div class="learning-roadmap">

          <!-- 1 -->

          <div class="road-item">

            <div class="road-number">01</div>

            <div class="road-icon">👨‍🏫</div>

            <h4>Kuliah Tatap Muka</h4>

            <p>
              Penyampaian konsep, teori, dan dasar-dasar ilmu hukum oleh dosen.
            </p>

          </div>

          <div class="road-line"></div>

          <!-- 2 -->

          <div class="road-item">

            <div class="road-number">02</div>

            <div class="road-icon">💬</div>

            <h4>Diskusi Kelompok</h4>

            <p>
              Mahasiswa berdiskusi, bertukar gagasan, dan mengembangkan kemampuan argumentasi.
            </p>

          </div>

          <div class="road-line"></div>

          <!-- 3 -->

          <div class="road-item">

            <div class="road-number">03</div>

            <div class="road-icon">⚖️</div>

            <h4>Case Based Learning</h4>

            <p>
              Analisis kasus hukum nyata sebagai media penerapan teori.
            </p>

          </div>

          <div class="road-line"></div>

          <!-- 4 -->

          <div class="road-item">

            <div class="road-number">04</div>

            <div class="road-icon">🏛️</div>

            <h4>Moot Court</h4>

            <p>
              Simulasi persidangan untuk melatih keterampilan litigasi mahasiswa.
            </p>

          </div>

          <div class="road-line"></div>

          <!-- 5 -->

          <div class="road-item">

            <div class="road-number">05</div>

            <div class="road-icon">🏢</div>

            <h4>Magang</h4>

            <p>
              Pengalaman belajar langsung di kantor hukum maupun instansi terkait.
            </p>

          </div>

          <div class="road-line"></div>

          <!-- 6 -->

          <div class="road-item">

            <div class="road-number">06</div>

            <div class="road-icon">🎓</div>

            <h4>Siap Berkarier</h4>

            <p>
              Lulusan memiliki kompetensi akademik, profesional, dan etika hukum.
            </p>

          </div>

        </div>

      </div>
    </section>
    <section class="wrapper bg-light">
      <div class="container py-15 py-md-17">

        <div class="row text-center mb-10">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Learning Resources
            </span>

            <h2 class="display-5 mb-3">
              Media Pembelajaran Modern
            </h2>

            <p class="lead">
              Seluruh proses pembelajaran didukung oleh berbagai media
              digital dan fasilitas akademik untuk meningkatkan kualitas
              belajar mahasiswa.
            </p>

          </div>

        </div>

        <div class="row g-4">

          <div class="col-md-6 col-xl-3">

            <div class="media-card">

              <div class="media-icon">
                💻
              </div>

              <h4>E-Learning</h4>

              <p>
                Akses materi kuliah, tugas, forum diskusi,
                dan evaluasi secara online.
              </p>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="media-card">

              <div class="media-icon">
                📚
              </div>

              <h4>Digital Library</h4>

              <p>
                Ribuan koleksi buku, jurnal hukum,
                dan referensi ilmiah digital.
              </p>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="media-card">

              <div class="media-icon">
                🎥
              </div>

              <h4>Video Learning</h4>

              <p>
                Rekaman kuliah, webinar,
                serta video pembelajaran interaktif.
              </p>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="media-card">

              <div class="media-icon">
                ☁️
              </div>

              <h4>Cloud Storage</h4>

              <p>
                Penyimpanan materi kuliah dan dokumen
                yang dapat diakses kapan saja.
              </p>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="media-card">

              <div class="media-icon">
                📄
              </div>

              <h4>Modul Digital</h4>

              <p>
                Modul pembelajaran elektronik
                yang selalu diperbarui setiap semester.
              </p>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="media-card">

              <div class="media-icon">
                📝
              </div>

              <h4>Quiz Online</h4>

              <p>
                Latihan soal, kuis,
                serta evaluasi pembelajaran berbasis web.
              </p>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="media-card">

              <div class="media-icon">
                📱
              </div>

              <h4>Mobile Learning</h4>

              <p>
                Belajar melalui smartphone
                kapan saja dan di mana saja.
              </p>

            </div>

          </div>

          <div class="col-md-6 col-xl-3">

            <div class="media-card">

              <div class="media-icon">
                🤝
              </div>

              <h4>Collaborative Learning</h4>

              <p>
                Berbagi materi, diskusi,
                dan tugas kelompok secara digital.
              </p>

            </div>

          </div>

        </div>

      </div>
    </section>
    <section class="wrapper bg-white">
      <div class="container py-15 py-md-17">

        <div class="row text-center mb-12">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Experience Learning
            </span>

            <h2 class="display-5 mb-3">
              Belajar Melalui Pengalaman Nyata
            </h2>

            <p class="lead">
              Pembelajaran tidak hanya berlangsung di dalam kelas, tetapi juga
              melalui praktik, simulasi, observasi lapangan, dan pengabdian
              kepada masyarakat.
            </p>

          </div>

        </div>

        <!-- ITEM 1 -->

        <div class="row align-items-center gy-8 mb-15">

          <div class="col-lg-6">

            <img src="./assets/img/moot-court.png"
              class="img-fluid rounded-4 shadow-lg">

          </div>

          <div class="col-lg-6">

            <span class="badge bg-soft-primary text-primary mb-3">
              Moot Court
            </span>

            <h3 class="mb-4">
              Simulasi Persidangan
            </h3>

            <p class="lead">
              Mahasiswa berlatih menjadi hakim, jaksa, advokat,
              maupun panitera melalui simulasi persidangan sehingga
              memahami praktik hukum secara langsung.
            </p>

          </div>

        </div>

        <!-- ITEM 2 -->

        <div class="row align-items-center gy-8 flex-lg-row-reverse mb-15">

          <div class="col-lg-6">

            <img src="./assets/img/magang.png"
              class="img-fluid rounded-4 shadow-lg">

          </div>

          <div class="col-lg-6">

            <span class="badge bg-soft-success text-success mb-3">
              Internship
            </span>

            <h3 class="mb-4">
              Program Magang
            </h3>

            <p class="lead">
              Mahasiswa memperoleh pengalaman profesional melalui
              magang di kantor hukum, pengadilan, kejaksaan,
              instansi pemerintah maupun perusahaan.
            </p>

          </div>

        </div>

        <!-- ITEM 3 -->

        <div class="row align-items-center gy-8 mb-15">

          <div class="col-lg-6">

            <img src="./assets/img/pengabdian.png"
              class="img-fluid rounded-4 shadow-lg">

          </div>

          <div class="col-lg-6">

            <span class="badge bg-soft-danger text-danger mb-3">
              Community Service
            </span>

            <h3 class="mb-4">
              Penyuluhan Hukum
            </h3>

            <p class="lead">
              Mahasiswa terlibat langsung dalam kegiatan penyuluhan hukum
              kepada masyarakat sebagai bentuk pengabdian sekaligus
              implementasi ilmu yang telah dipelajari.
            </p>

          </div>

        </div>

        <!-- ITEM 4 -->

        <div class="row align-items-center gy-8 flex-lg-row-reverse">

          <div class="col-lg-6">

            <img src="./assets/img/penelitian.png"
              class="img-fluid rounded-4 shadow-lg">

          </div>

          <div class="col-lg-6">

            <span class="badge bg-soft-warning text-warning mb-3">
              Research
            </span>

            <h3 class="mb-4">
              Penelitian Hukum
            </h3>

            <p class="lead">
              Mahasiswa didorong menghasilkan karya ilmiah,
              melakukan penelitian hukum, serta mempublikasikan
              hasil penelitian pada seminar maupun jurnal ilmiah.
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
              Assessment
            </span>

            <h2 class="display-5 mb-3">
              Evaluasi Pembelajaran
            </h2>

            <p class="lead">
              Proses evaluasi dilakukan secara berkesinambungan untuk mengukur
              kemampuan akademik, keterampilan, serta kompetensi mahasiswa
              selama mengikuti proses pembelajaran.
            </p>

          </div>

        </div>

        <div class="assessment-process">

          <!-- 1 -->

          <div class="assessment-item">

            <div class="assessment-circle bg-primary">

              📝

            </div>

            <h4>Quiz</h4>

            <p>
              Evaluasi singkat untuk mengukur pemahaman materi setiap pertemuan.
            </p>

          </div>

          <div class="assessment-line"></div>

          <!-- 2 -->

          <div class="assessment-item">

            <div class="assessment-circle bg-success">

              📚

            </div>

            <h4>Tugas</h4>

            <p>
              Penugasan individu maupun kelompok untuk meningkatkan analisis hukum.
            </p>

          </div>

          <div class="assessment-line"></div>

          <!-- 3 -->

          <div class="assessment-item">

            <div class="assessment-circle bg-warning">

              📖

            </div>

            <h4>UTS & UAS</h4>

            <p>
              Ujian tengah dan akhir semester sebagai evaluasi capaian pembelajaran.
            </p>

          </div>

          <div class="assessment-line"></div>

          <!-- 4 -->

          <div class="assessment-item">

            <div class="assessment-circle bg-danger">

              🎓

            </div>

            <h4>Tugas Akhir</h4>

            <p>
              Skripsi, seminar hasil, hingga sidang sebagai syarat kelulusan.
            </p>

          </div>

        </div>

      </div>
    </section>
    <section class="wrapper bg-white">
      <div class="container py-15 py-md-17">

        <!-- Heading -->

        <div class="row text-center mb-12">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Learning Outcomes
            </span>

            <h2 class="display-5 mb-3">
              Kompetensi Lulusan
            </h2>

            <p class="lead">
              Lulusan STIH Graha Kirana dipersiapkan menjadi sarjana hukum
              yang profesional, berintegritas, adaptif terhadap perkembangan
              teknologi, dan mampu memberikan solusi terhadap berbagai
              persoalan hukum.
            </p>

          </div>

        </div>

        <div class="row g-5">

          <!-- 1 -->

          <div class="col-md-6 col-xl-4">

            <div class="outcome-card">

              <div class="outcome-icon">
                ⚖️
              </div>

              <h4>Kompetensi Hukum</h4>

              <p>
                Memahami teori, asas, serta penerapan hukum nasional
                maupun internasional secara komprehensif.
              </p>

            </div>

          </div>

          <!-- 2 -->

          <div class="col-md-6 col-xl-4">

            <div class="outcome-card">

              <div class="outcome-icon">
                💬
              </div>

              <h4>Komunikasi</h4>

              <p>
                Mampu menyampaikan argumentasi hukum secara lisan maupun
                tertulis dengan baik dan profesional.
              </p>

            </div>

          </div>

          <!-- 3 -->

          <div class="col-md-6 col-xl-4">

            <div class="outcome-card">

              <div class="outcome-icon">
                🤝
              </div>

              <h4>Etika Profesi</h4>

              <p>
                Menjunjung tinggi etika profesi, integritas,
                dan tanggung jawab dalam praktik hukum.
              </p>

            </div>

          </div>

          <!-- 4 -->

          <div class="col-md-6 col-xl-4">

            <div class="outcome-card">

              <div class="outcome-icon">
                🔍
              </div>

              <h4>Analisis & Penelitian</h4>

              <p>
                Mampu melakukan penelitian hukum serta menyusun
                karya ilmiah berbasis metodologi yang tepat.
              </p>

            </div>

          </div>

          <!-- 5 -->

          <div class="col-md-6 col-xl-4">

            <div class="outcome-card">

              <div class="outcome-icon">
                🌐
              </div>

              <h4>Literasi Digital</h4>

              <p>
                Memanfaatkan teknologi informasi dalam riset,
                pembelajaran, dan praktik hukum modern.
              </p>

            </div>

          </div>

          <!-- 6 -->

          <div class="col-md-6 col-xl-4">

            <div class="outcome-card">

              <div class="outcome-icon">
                🏛️
              </div>

              <h4>Kepemimpinan</h4>

              <p>
                Memiliki jiwa kepemimpinan, kemampuan bekerja
                dalam tim, dan berkontribusi bagi masyarakat.
              </p>

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
              Career Opportunities
            </span>

            <h2 class="display-5 mb-3">
              Prospek Karier Lulusan
            </h2>

            <p class="lead">
              Lulusan STIH Graha Kirana memiliki peluang karier yang luas
              di berbagai sektor hukum, pemerintahan, dunia usaha,
              maupun akademik.
            </p>

          </div>

        </div>

        <div class="row g-4">

          <!-- 1 -->

          <div class="col-md-6 col-xl-3">

            <div class="career-box">

              <div class="career-icon">

                ⚖️

              </div>

              <h4>Advokat</h4>

              <p>
                Menjadi praktisi hukum yang memberikan bantuan
                hukum kepada masyarakat.
              </p>

            </div>

          </div>

          <!-- 2 -->

          <div class="col-md-6 col-xl-3">

            <div class="career-box">

              <div class="career-icon">

                👨‍⚖️

              </div>

              <h4>Hakim</h4>

              <p>
                Berkarier di lingkungan peradilan sesuai
                ketentuan yang berlaku.
              </p>

            </div>

          </div>

          <!-- 3 -->

          <div class="col-md-6 col-xl-3">

            <div class="career-box">

              <div class="career-icon">

                🏛️

              </div>

              <h4>Jaksa</h4>

              <p>
                Mengabdi sebagai aparat penegak hukum
                di Kejaksaan Republik Indonesia.
              </p>

            </div>

          </div>

          <!-- 4 -->

          <div class="col-md-6 col-xl-3">

            <div class="career-box">

              <div class="career-icon">

                📜

              </div>

              <h4>Notaris</h4>

              <p>
                Melanjutkan pendidikan profesi
                untuk menjadi Notaris dan PPAT.
              </p>

            </div>

          </div>

          <!-- 5 -->

          <div class="col-md-6 col-xl-3">

            <div class="career-box">

              <div class="career-icon">

                🏢

              </div>

              <h4>Legal Officer</h4>

              <p>
                Menangani aspek hukum perusahaan,
                kontrak, dan kepatuhan hukum.
              </p>

            </div>

          </div>

          <!-- 6 -->

          <div class="col-md-6 col-xl-3">

            <div class="career-box">

              <div class="career-icon">

                👮

              </div>

              <h4>Penyidik</h4>

              <p>
                Berkarier pada lembaga penegak hukum
                sesuai ketentuan yang berlaku.
              </p>

            </div>

          </div>

          <!-- 7 -->

          <div class="col-md-6 col-xl-3">

            <div class="career-box">

              <div class="career-icon">

                🎓

              </div>

              <h4>Akademisi</h4>

              <p>
                Menjadi dosen, peneliti,
                maupun konsultan pendidikan hukum.
              </p>

            </div>

          </div>

          <!-- 8 -->

          <div class="col-md-6 col-xl-3">

            <div class="career-box">

              <div class="career-icon">

                🤝

              </div>

              <h4>Konsultan Hukum</h4>

              <p>
                Memberikan konsultasi hukum
                kepada individu maupun perusahaan.
              </p>

            </div>

          </div>

        </div>

      </div>
    </section>
    <section class="wrapper bg-primary">
      <div class="container py-16 py-md-18">

        <div class="row text-center mb-12">

          <div class="col-lg-8 mx-auto">

            <span class="badge bg-white text-primary rounded-pill mb-3">
              Student Journey
            </span>

            <h2 class="display-4 text-white mb-3">

              Perjalanan Menuju
              Profesional Hukum

            </h2>

            <p class="lead text-white">

              STIH Graha Kirana mendampingi mahasiswa sejak awal
              perkuliahan hingga menjadi lulusan yang siap
              bersaing di dunia profesional.

            </p>

          </div>

        </div>

        <div class="row justify-content-center">

          <div class="col-xl-11">

            <div class="journey">

              <!-- STEP -->

              <div class="journey-item">

                <div class="journey-icon">
                  🎓
                </div>

                <h5>Mahasiswa Baru</h5>

                <small>
                  Memulai perjalanan akademik
                </small>

              </div>

              <div class="journey-line"></div>

              <div class="journey-item">

                <div class="journey-icon">
                  📚
                </div>

                <h5>Pembelajaran</h5>

                <small>
                  Teori & Praktik
                </small>

              </div>

              <div class="journey-line"></div>

              <div class="journey-item">

                <div class="journey-icon">
                  ⚖️
                </div>

                <h5>Moot Court</h5>

                <small>
                  Simulasi Persidangan
                </small>

              </div>

              <div class="journey-line"></div>

              <div class="journey-item">

                <div class="journey-icon">
                  🏢
                </div>

                <h5>Magang</h5>

                <small>
                  Dunia Kerja
                </small>

              </div>

              <div class="journey-line"></div>

              <div class="journey-item">

                <div class="journey-icon">
                  🏆
                </div>

                <h5>Lulusan</h5>

                <small>
                  Siap Berkarier
                </small>

              </div>

            </div>

          </div>

        </div>

        <div class="row mt-15">

          <div class="col-md-3">

            <div class="journey-stat">

              <h2 class="text-white">

                1.800+

              </h2>

              <p>

                Alumni

              </p>

            </div>

          </div>

          <div class="col-md-3">

            <div class="journey-stat">

              <h2 class="text-white">

                65+

              </h2>

              <p>

                Dosen

              </p>

            </div>

          </div>

          <div class="col-md-3">

            <div class="journey-stat">

              <h2 class="text-white">

                150+

              </h2>

              <p>

                Mitra

              </p>

            </div>

          </div>

          <div class="col-md-3">

            <div class="journey-stat">

              <h2 class="text-white">

                95%

              </h2>

              <p>

                Alumni Berkarier

              </p>

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