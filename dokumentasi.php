<!DOCTYPE html>
<html lang="en">

<?php
$page = "Home";
require 'head.php';
?>


<body>
  <div class="content-wrapper">
    <?php
    require 'navbar.php';
    ?>
  </div>

  <section class="wrapper bg-light">
    <div class="container py-17 py-md-12">
      <div class="row text-center mb-0">
        <div class="col-lg-9 mx-auto">
          <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
            Dokumentasi
          </span>
          <h2 class="display-4 mb-4">
            Dokumentasi Kegiatan STIH Graha Kirana
          </h2>
          <p class="lead fs-lg">
            Dokumentasi berbagai kegiatan akademik, kemahasiswaan,
            seminar, pengabdian kepada masyarakat, hingga momen wisuda
            yang menjadi bagian perjalanan STIH Graha Kirana.
          </p>
        </div>
      </div>

    </div>
  </section>
  <section class="wrapper bg-white">
    <div class="container pb-6">

      <div class="text-center">

        <a href="#" class="btn btn-soft-primary rounded-pill m-2">📚 Akademik</a>

        <a href="#" class="btn btn-soft-violet rounded-pill m-2">🎓 Wisuda</a>

        <a href="#" class="btn btn-soft-leaf rounded-pill m-2">⚖️ Seminar</a>

        <a href="#" class="btn btn-soft-orange rounded-pill m-2">🏆 Prestasi</a>

        <a href="#" class="btn btn-soft-aqua rounded-pill m-2">🤝 Kerjasama</a>

        <a href="#" class="btn btn-soft-yellow rounded-pill m-2">🌍 Pengabdian</a>

        <a href="#" class="btn btn-soft-red rounded-pill m-2">🎉 Kemahasiswaan</a>

      </div>

    </div>
  </section>
  <section class="wrapper bg-light">
    <div class="container pb-15">
      <div class="row g-4">

        <?php for ($i = 1; $i <= 12; $i++) { ?>

          <div class="col-md-6 col-lg-4">

            <div class="card shadow-lg border-0">

              <figure class="overlay overlay-1 hover-scale rounded mb-0">

                <a href="./assets/img/gallery/gallery.png">

                  <img src="./assets/img/gallery/gallery.png" class="img-fluid">

                </a>

                <figcaption>

                  <h5 class="from-top mb-0">

                    Lihat Dokumentasi

                  </h5>

                </figcaption>

              </figure>

              <div class="card-body">

                <h5 class="mb-1">

                  Kegiatan STIH Graha Kirana

                </h5>

                <p class="mb-0 text-muted">

                  Dokumentasi kegiatan akademik dan kemahasiswaan.

                </p>

              </div>

            </div>

          </div>

        <?php } ?>

      </div>

    </div>
  </section>
  <section class="wrapper bg-white">
    <div class="container py-15">

      <div class="row mb-8">

        <div class="col-lg-8">

          <h2 class="display-5">

            Highlight Kegiatan

          </h2>

        </div>

      </div>

      <div class="row gy-5">

        <div class="col-md-4">

          <div class="card shadow-lg">

            <div class="card-body">

              <h4>🎓 Wisuda Sarjana</h4>

              <p>250 Foto Dokumentasi</p>

            </div>

          </div>

        </div>

        <div class="col-md-4">

          <div class="card shadow-lg">

            <div class="card-body">

              <h4>⚖️ Seminar Nasional</h4>

              <p>180 Foto Dokumentasi</p>

            </div>

          </div>

        </div>

        <div class="col-md-4">

          <div class="card shadow-lg">

            <div class="card-body">

              <h4>🤝 PKKMB</h4>

              <p>320 Foto Dokumentasi</p>

            </div>

          </div>

        </div>

      </div>

    </div>
  </section>
  <section class="wrapper bg-soft-primary">

    <div class="container py-15">

      <div class="row text-center">

        <div class="col-6 col-lg-3">

          <div style="font-size:55px;">📷</div>

          <h2 class="counter">2500+</h2>

          <p>Total Foto</p>

        </div>

        <div class="col-6 col-lg-3">

          <div style="font-size:55px;">🎥</div>

          <h2 class="counter">150+</h2>

          <p>Video</p>

        </div>

        <div class="col-6 col-lg-3">

          <div style="font-size:55px;">🏆</div>

          <h2 class="counter">85+</h2>

          <p>Event</p>

        </div>

        <div class="col-6 col-lg-3">

          <div style="font-size:55px;">📅</div>

          <h2 class="counter">24</h2>

          <p>Tahun Dokumentasi</p>

        </div>

      </div>

    </div>

  </section>
  <section class="wrapper bg-primary">

    <div class="container py-16 text-center">

      <h2 class="display-5 text-white mb-4">

        Mengabadikan Setiap Momen,
        Membangun Kenangan Bersama.

      </h2>

      <p class="lead text-white mb-6">

        Seluruh dokumentasi menjadi bagian perjalanan STIH Graha Kirana
        dalam mencetak lulusan yang profesional dan berintegritas.

      </p>

      <a href="#" class="btn btn-lg btn-white rounded-pill">

        Lihat Semua Dokumentasi

      </a>

    </div>

  </section>
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