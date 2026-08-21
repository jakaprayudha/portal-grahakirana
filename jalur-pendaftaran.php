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

    <section class="wrapper bg-light">

      <div class="container py-15 py-md-17">

        <div class="row align-items-center gy-8">

          <!-- LEFT -->

          <div class="col-lg-6">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">

              Penerimaan Mahasiswa Baru

            </span>

            <h1 class="display-4 mb-4">

              Jalur Pendaftaran
              <br>
              STIH Graha Kirana

            </h1>

            <p class="lead mb-5">

              Pilih jalur pendaftaran yang sesuai dengan latar belakang
              pendidikan dan pengalaman Anda untuk menjadi bagian dari
              keluarga besar STIH Graha Kirana.

            </p>


            <div class="row g-4">

              <!-- REGULER -->

              <div class="col-md-6">

                <div class="facility-highlight">

                  <div class="facility-icon">

                    🎓

                  </div>

                  <div>

                    <h5 class="mb-1">

                      Jalur Reguler

                    </h5>

                    <small>

                      Untuk lulusan SMA, SMK, dan MA sederajat.

                    </small>

                  </div>

                </div>

              </div>


              <!-- TRANSFER -->

              <div class="col-md-6">

                <div class="facility-highlight">

                  <div class="facility-icon">

                    🔄

                  </div>

                  <div>

                    <h5 class="mb-1">

                      Jalur Transfer

                    </h5>

                    <small>

                      Melanjutkan studi dari perguruan tinggi lain.

                    </small>

                  </div>

                </div>

              </div>


              <!-- RPL -->

              <div class="col-md-6">

                <div class="facility-highlight">

                  <div class="facility-icon">

                    📚

                  </div>

                  <div>

                    <h5 class="mb-1">

                      Jalur RPL

                    </h5>

                    <small>

                      Pengakuan pengalaman belajar dan kompetensi.

                    </small>

                  </div>

                </div>

              </div>


              <!-- PRESTASI -->

              <div class="col-md-6">

                <div class="facility-highlight">

                  <div class="facility-icon">

                    ⭐

                  </div>

                  <div>

                    <h5 class="mb-1">

                      Jalur Prestasi

                    </h5>

                    <small>

                      Bagi calon mahasiswa dengan prestasi akademik
                      maupun nonakademik.

                    </small>

                  </div>

                </div>

              </div>

            </div>


            <!-- ACTION -->

            <div class="mt-5">

              <a href="#jalur"
                class="btn btn-primary rounded-pill me-3">

                <i class="uil uil-direction me-1"></i>

                Pilih Jalur

              </a>

              <a href="#alur"
                class="btn btn-outline-primary rounded-pill">

                <i class="uil uil-list-ui-alt me-1"></i>

                Lihat Alur

              </a>

            </div>

          </div>


          <!-- RIGHT -->

          <div class="col-lg-6">

            <img
              src="./assets/img/pmb/hero.png"
              class="img-fluid rounded-4 shadow-lg"
              alt="Jalur Pendaftaran STIH Graha Kirana">

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