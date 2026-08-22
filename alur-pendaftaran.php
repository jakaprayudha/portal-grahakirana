<!DOCTYPE html>
<html lang="en">

<head>
   <base href="../">
   <?php
   $page = 'Home PMB';
   require '../head.php';
   ?>
</head>

<body>
   <div class="content-wrapper">
      <?php
      require '../navbar.php';
      ?>
      <!-- =========================================
     SECTION : GAMBARAN SISTEM PMB
========================================= -->
      <section class="wrapper bg-light">
         <div class="container py-10 py-md-14">

            <!-- Heading -->
            <div class="row mb-10">
               <div class="col-lg-9 col-xl-8 col-xxl-7 mx-auto text-center">
                  <h2 class="fs-15 text-uppercase text-primary mb-3">
                     Alur Pendaftaran Mahasiswa Baru
                  </h2>

                  <h3 class="display-4 mb-4">
                     7 Tahapan Menuju Mahasiswa Aktif
                  </h3>

                  <p class="lead fs-18 mb-0">
                     Ikuti seluruh proses penerimaan mahasiswa baru STIH Graha Kirana
                     mulai dari registrasi akun hingga aktivasi akun SIAKAD.
                  </p>
               </div>
            </div>

            <!-- Main Timeline -->
            <div class="row gx-lg-8 gy-8 align-items-center">

               <!-- LEFT : Timeline -->
               <div class="col-lg-8">

                  <div class="row gx-4 gy-5">

                     <!-- STEP 01 -->
                     <div class="col-md-6">
                        <div class="card h-100 shadow-lg hover-rise">
                           <div class="card-body p-6">

                              <div class="d-flex align-items-center mb-4">
                                 <div class="icon btn btn-circle btn-lg btn-soft-yellow me-4">
                                    <img src="./assets/img/icons/lineal/user.svg"
                                       class="svg-inject icon-svg"
                                       alt="Registrasi Akun">
                                 </div>

                                 <div>
                                    <span class="text-uppercase text-muted fs-13 fw-bold">
                                       Tahap 01
                                    </span>
                                    <h4 class="mb-0">Registrasi Akun</h4>
                                 </div>
                              </div>

                              <p class="mb-3">
                                 Calon mahasiswa membuat akun pendaftaran dan memilih
                                 jalur masuk yang tersedia.
                              </p>

                              <ul class="icon-list bullet-bg bullet-soft-yellow mb-0">
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    Data identitas
                                 </li>
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    Email & nomor HP
                                 </li>
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    Pilihan jalur PMB
                                 </li>
                              </ul>

                           </div>
                        </div>
                     </div>

                     <!-- STEP 02 -->
                     <div class="col-md-6">
                        <div class="card h-100 shadow-lg hover-rise">
                           <div class="card-body p-6">

                              <div class="d-flex align-items-center mb-4">
                                 <div class="icon btn btn-circle btn-lg btn-soft-blue me-4">
                                    <img src="./assets/img/icons/lineal/clipboard.svg"
                                       class="svg-inject icon-svg"
                                       alt="Data dan Dokumen">
                                 </div>

                                 <div>
                                    <span class="text-uppercase text-muted fs-13 fw-bold">
                                       Tahap 02
                                    </span>
                                    <h4 class="mb-0">Data & Dokumen</h4>
                                 </div>
                              </div>

                              <p class="mb-3">
                                 Lengkapi biodata calon mahasiswa dan unggah seluruh
                                 dokumen persyaratan.
                              </p>

                              <ul class="icon-list bullet-bg bullet-soft-blue mb-0">
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    Biodata diri
                                 </li>
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    Pilihan pembiayaan
                                 </li>
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    Dokumen persyaratan
                                 </li>
                              </ul>

                           </div>
                        </div>
                     </div>

                     <!-- STEP 03 -->
                     <div class="col-md-6">
                        <div class="card h-100 shadow-lg hover-rise">
                           <div class="card-body p-6">

                              <div class="d-flex align-items-center mb-4">
                                 <div class="icon btn btn-circle btn-lg btn-soft-green me-4">
                                    <img src="./assets/img/icons/lineal/files.svg"
                                       class="svg-inject icon-svg"
                                       alt="Kartu Peserta">
                                 </div>

                                 <div>
                                    <span class="text-uppercase text-muted fs-13 fw-bold">
                                       Tahap 03
                                    </span>
                                    <h4 class="mb-0">Kartu Peserta PMB</h4>
                                 </div>
                              </div>

                              <p class="mb-3">
                                 Setelah data dan dokumen lengkap, calon mahasiswa
                                 dapat mencetak kartu peserta PMB digital.
                              </p>

                              <ul class="icon-list bullet-bg bullet-soft-green mb-0">
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    Kartu digital
                                 </li>
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    Foto peserta
                                 </li>
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    QR Code
                                 </li>
                              </ul>

                           </div>
                        </div>
                     </div>

                     <!-- STEP 04 -->
                     <div class="col-md-6">
                        <div class="card h-100 shadow-lg hover-rise">
                           <div class="card-body p-6">

                              <div class="d-flex align-items-center mb-4">
                                 <div class="icon btn btn-circle btn-lg btn-soft-purple me-4">
                                    <img src="./assets/img/icons/lineal/calendar.svg"
                                       class="svg-inject icon-svg"
                                       alt="Jadwal Seleksi">
                                 </div>

                                 <div>
                                    <span class="text-uppercase text-muted fs-13 fw-bold">
                                       Tahap 04
                                    </span>
                                    <h4 class="mb-0">Jadwal Seleksi</h4>
                                 </div>
                              </div>

                              <p class="mb-3">
                                 Kampus menetapkan dan mengumumkan jadwal pelaksanaan
                                 seleksi kepada seluruh peserta PMB.
                              </p>

                              <ul class="icon-list bullet-bg bullet-soft-purple mb-0">
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    Jadwal TPA
                                 </li>
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    Jadwal wawancara
                                 </li>
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    Notifikasi peserta
                                 </li>
                              </ul>

                           </div>
                        </div>
                     </div>

                     <!-- STEP 05 -->
                     <div class="col-md-6">
                        <div class="card h-100 shadow-lg hover-rise">
                           <div class="card-body p-6">

                              <div class="d-flex align-items-center mb-4">
                                 <div class="icon btn btn-circle btn-lg btn-soft-orange me-4">
                                    <img src="./assets/img/icons/lineal/briefcase.svg"
                                       class="svg-inject icon-svg"
                                       alt="Seleksi PMB">
                                 </div>

                                 <div>
                                    <span class="text-uppercase text-muted fs-13 fw-bold">
                                       Tahap 05
                                    </span>
                                    <h4 class="mb-0">Seleksi PMB</h4>
                                 </div>
                              </div>

                              <p class="mb-3">
                                 Proses seleksi akademik dan penilaian beasiswa
                                 dilakukan oleh tim yang berwenang.
                              </p>

                              <ul class="icon-list bullet-bg bullet-soft-orange mb-0">
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    TPA
                                 </li>
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    Wawancara
                                 </li>
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    Seleksi beasiswa
                                 </li>
                              </ul>

                           </div>
                        </div>
                     </div>

                     <!-- STEP 06 -->
                     <div class="col-md-6">
                        <div class="card h-100 shadow-lg hover-rise">
                           <div class="card-body p-6">

                              <div class="d-flex align-items-center mb-4">
                                 <div class="icon btn btn-circle btn-lg btn-soft-red me-4">
                                    <img src="./assets/img/icons/lineal/megaphone.svg"
                                       class="svg-inject icon-svg"
                                       alt="Pengumuman">
                                 </div>

                                 <div>
                                    <span class="text-uppercase text-muted fs-13 fw-bold">
                                       Tahap 06
                                    </span>
                                    <h4 class="mb-0">Pengumuman Hasil</h4>
                                 </div>
                              </div>

                              <p class="mb-3">
                                 Hasil seleksi diumumkan setelah proses akademik dan
                                 beasiswa selesai divalidasi.
                              </p>

                              <ul class="icon-list bullet-bg bullet-soft-red mb-0">
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    Status kelulusan
                                 </li>
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    Informasi beasiswa
                                 </li>
                                 <li>
                                    <span><i class="uil uil-check"></i></span>
                                    Notifikasi hasil
                                 </li>
                              </ul>

                           </div>
                        </div>
                     </div>

                  </div>

               </div>

               <!-- RIGHT : FINAL STAGE -->
               <div class="col-lg-4">

                  <div class="card bg-primary text-white shadow-lg h-100 border-0">
                     <div class="card-body p-8 d-flex flex-column">

                        <span class="badge bg-white text-primary rounded-pill mb-4 align-self-start">
                           TAHAP 07
                        </span>

                        <div class="icon btn btn-circle btn-lg btn-white text-primary mb-5">
                           <img src="./assets/img/icons/lineal/id-card.svg"
                              class="svg-inject icon-svg"
                              alt="Daftar Ulang">
                        </div>

                        <h3 class="text-white mb-4">
                           Daftar Ulang & Generate NPM
                        </h3>

                        <p class="text-white opacity-75 mb-5">
                           Tahap akhir proses PMB sebelum calon mahasiswa menjadi
                           mahasiswa aktif dan melanjutkan proses ke Portal SIAKAD.
                        </p>

                        <div class="border-top border-white border-opacity-25 pt-5 mt-auto">

                           <div class="d-flex mb-4">
                              <div class="icon btn btn-circle btn-sm btn-white text-primary me-3">
                                 <i class="uil uil-check"></i>
                              </div>
                              <div>
                                 <h5 class="text-white mb-1">Daftar Ulang</h5>
                                 <p class="text-white opacity-75 mb-0">
                                    Konfirmasi kesediaan menjadi mahasiswa.
                                 </p>
                              </div>
                           </div>

                           <div class="d-flex mb-4">
                              <div class="icon btn btn-circle btn-sm btn-white text-primary me-3">
                                 <i class="uil uil-check"></i>
                              </div>
                              <div>
                                 <h5 class="text-white mb-1">Pembayaran</h5>
                                 <p class="text-white opacity-75 mb-0">
                                    Penyelesaian biaya atribut sesuai ketentuan.
                                 </p>
                              </div>
                           </div>

                           <div class="d-flex mb-4">
                              <div class="icon btn btn-circle btn-sm btn-white text-primary me-3">
                                 <i class="uil uil-check"></i>
                              </div>
                              <div>
                                 <h5 class="text-white mb-1">Generate NPM</h5>
                                 <p class="text-white opacity-75 mb-0">
                                    Sistem menerbitkan nomor pokok mahasiswa.
                                 </p>
                              </div>
                           </div>

                           <div class="d-flex">
                              <div class="icon btn btn-circle btn-sm btn-white text-primary me-3">
                                 <i class="uil uil-arrow-right"></i>
                              </div>
                              <div>
                                 <h5 class="text-white mb-1">Masuk SIAKAD</h5>
                                 <p class="text-white opacity-75 mb-0">
                                    Aktivasi akun dan melanjutkan ke sistem akademik.
                                 </p>
                              </div>
                           </div>

                        </div>

                     </div>
                  </div>

               </div>

            </div>

         </div>
      </section>
      <!-- /section -->
   </div>
   <hr>
   <!-- /.content-wrapper -->
   <?php
   require '../footer2.php';
   ?>
   <div class="progress-wrap">
      <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
         <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
      </svg>
   </div>
   <script src="./assets/js/plugins.js"></script>
   <script src="./assets/js/theme.js"></script>
   <script>
      function copyToClipboard(text) {
         navigator.clipboard.writeText(text)
            .then(() => {
               alert('No.Rekening berhasil disalin ke clipboard!');
            })
            .catch(err => {
               console.error('Gagal menyalin teks: ', err);
               alert('Gagal menyalin teks. Silakan coba lagi.');
            });
      }
   </script>
</body>

</html>