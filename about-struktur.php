<!DOCTYPE html>
<html lang="en">

<?php
$page = "Home";
require 'head.php';
?>
<style>
  /*====================================================
 ORGANIZATION CHART - STIH GRAHA KIRANA
====================================================*/

  .org-chart {
    width: 100%;
  }

  /* =============================
   LEVEL
============================= */

  .org-level {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 40px;
    position: relative;
    margin-bottom: 40px;
  }

  /* garis horizontal */

  .org-level::before {

    content: "";

    position: absolute;

    top: -20px;

    left: 15%;

    right: 15%;

    height: 2px;

    background: #6A3DA8;

  }

  /* level pertama tidak perlu garis */

  .org-level:first-child::before {

    display: none;

  }

  /* =============================
   GARIS VERTIKAL
============================= */

  .org-v-line {

    width: 2px;

    height: 35px;

    background: #6A3DA8;

    margin: 0 auto;

  }

  /* =============================
   CARD
============================= */

  .org-person {

    position: relative;

    width: 180px;

    background: #fff;

    border-radius: 18px;

    padding: 20px 15px;

    text-align: center;

    box-shadow: 0 12px 35px rgba(0, 0, 0, .08);

    transition: .3s;

  }

  /* garis dari card ke atas */

  .org-person::before {

    content: "";

    position: absolute;

    top: -20px;

    left: 50%;

    transform: translateX(-50%);

    width: 2px;

    height: 20px;

    background: #6A3DA8;

  }

  /* ketua tidak perlu */

  .org-level:first-child .org-person::before {

    display: none;

  }

  .org-person:hover {

    transform: translateY(-8px);

    box-shadow: 0 18px 45px rgba(0, 0, 0, .15);

  }

  /* =============================
   FOTO
============================= */

  .org-person img {

    width: 75px;

    height: 75px;

    object-fit: cover;

    border-radius: 50%;

    border: 4px solid #6A3DA8;

    margin-bottom: 12px;

  }

  /* =============================
   TEXT
============================= */

  .org-person h5 {

    font-size: 15px;

    font-weight: 700;

    margin-bottom: 4px;

    line-height: 1.4;

  }

  .org-person span {

    font-size: 13px;

    color: #666;

  }

  /* =============================
   RESPONSIVE
============================= */

  @media(max-width:992px) {

    .org-level {

      gap: 25px;

    }

    .org-person {

      width: 165px;

    }

  }

  @media(max-width:768px) {

    .org-level {

      gap: 20px;

      margin-bottom: 30px;

    }

    .org-level::before {

      display: none;

    }

    .org-v-line {

      display: none;

    }

    .org-person {

      width: 150px;

      padding: 15px;

    }

    .org-person::before {

      display: none;

    }

    .org-person img {

      width: 65px;

      height: 65px;

    }

    .org-person h5 {

      font-size: 14px;

    }

    .org-person span {

      font-size: 12px;

    }

  }
</style>

<body>
  <div class="content-wrapper">
    <?php
    require 'navbar.php';
    ?>
    <section class="wrapper bg-light">
      <div class="container py-15">

        <div class="row mb-12">
          <div class="col-lg-8 mx-auto text-center">

            <span class="badge bg-soft-primary text-primary rounded-pill mb-3">
              Struktur Organisasi
            </span>

            <h2 class="display-5 mb-3">
              Struktur Organisasi STIH Graha Kirana
            </h2>

            <p class="lead">
              Struktur organisasi dalam mendukung tata kelola perguruan tinggi
              yang profesional dan berintegritas.
            </p>

          </div>
        </div>

        <div class="org-chart">

          <!-- LEVEL 1 -->
          <div class="org-level">
            <div class="org-person">

              <img src="./assets/img/ketua.jpeg">

              <h5>Dr. Ahmad Pratama, S.H., M.H.</h5>

              <span>Ketua STIH</span>

            </div>
          </div>

          <div class="org-v-line"></div>

          <!-- LEVEL 2 -->
          <div class="org-level">

            <div class="org-person">
              <img src="https://i.pravatar.cc/150?img=11">
              <h5>Rizky Maulana</h5>
              <span>Wakil Ketua I</span>
            </div>

            <div class="org-person">
              <img src="https://i.pravatar.cc/150?img=32">
              <h5>Nur Aisyah</h5>
              <span>Wakil Ketua II</span>
            </div>

            <div class="org-person">
              <img src="https://i.pravatar.cc/150?img=15">
              <h5>Fajar Hidayat</h5>
              <span>Wakil Ketua III</span>
            </div>

          </div>

          <div class="org-v-line"></div>

          <!-- LEVEL 3 -->

          <div class="org-level">

            <div class="org-person">
              <img src="https://i.pravatar.cc/150?img=18">
              <h5>Dewi Lestari</h5>
              <span>Kepala BAAK</span>
            </div>

            <div class="org-person">
              <img src="https://i.pravatar.cc/150?img=41">
              <h5>Muhammad Rizky</h5>
              <span>Kepala BAUK</span>
            </div>

            <div class="org-person">
              <img src="https://i.pravatar.cc/150?img=45">
              <h5>Salsabila Putri</h5>
              <span>Kepala Kemahasiswaan</span>
            </div>

          </div>

          <div class="org-v-line"></div>

          <!-- LEVEL 4 -->

          <div class="org-level">

            <div class="org-person">
              <img src="https://i.pravatar.cc/150?img=55">
              <h5>Rina Anggraini</h5>
              <span>Staf Akademik</span>
            </div>

            <div class="org-person">
              <img src="https://i.pravatar.cc/150?img=60">
              <h5>Fadli Syahputra</h5>
              <span>Staf Akademik</span>
            </div>

            <div class="org-person">
              <img src="https://i.pravatar.cc/150?img=28">
              <h5>Sri Wahyuni</h5>
              <span>Staf Keuangan</span>
            </div>

            <div class="org-person">
              <img src="https://i.pravatar.cc/150?img=67">
              <h5>Andika Putra</h5>
              <span>Staf Administrasi</span>
            </div>

            <div class="org-person">
              <img src="https://i.pravatar.cc/150?img=49">
              <h5>Yusuf Ramadhan</h5>
              <span>Staf Kemahasiswaan</span>
            </div>

            <div class="org-person">
              <img src="https://i.pravatar.cc/150?img=58">
              <h5>Nabila Safitri</h5>
              <span>Staf Kemahasiswaan</span>
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