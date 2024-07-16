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
      <!-- /section -->
      <section class="wrapper bg-light">
         <div class="container py-0 py-md-10">
            <ul class="nav nav-tabs nav-tabs-bg nav-tabs-shadow-lg d-flex justify-content-between nav-justified flex-lg-row flex-column">
               <li class="nav-item">
                  <a class="nav-link d-flex flex-row active" data-bs-toggle="tab" href="#tab2-1">
                     <div><img src="./assets/img/icons/lineal/user.svg" class="svg-inject icon-svg icon-svg-md text-yellow me-4" alt="" /></div>
                     <div>
                        <h4 class="mb-1">Tahap 1</h4>
                        <p>Pendaftaran</p>
                     </div>
                  </a>
               </li>
               <li class="nav-item">
                  <a class="nav-link d-flex flex-row" data-bs-toggle="tab" href="#tab2-2">
                     <div><img src="./assets/img/icons/lineal/agenda.svg" class="svg-inject icon-svg icon-svg-md text-info me-4" alt="" /></div>
                     <div>
                        <h4 class="mb-1">Tahap 2</h4>
                        <p>Download & Cetak</p>
                     </div>
                  </a>
               </li>
               <li class="nav-item">
                  <a class="nav-link d-flex flex-row" data-bs-toggle="tab" href="#tab3-3">
                     <div><img src="./assets/img/icons/lineal/savings.svg" class="svg-inject icon-svg icon-svg-md text-green me-4" alt="" /></div>
                     <div>
                        <h4 class="mb-1">Tahap 3</h4>
                        <p>Pembayaran</p>
                     </div>
                  </a>
               </li>
            </ul>
            <!-- /.nav-tabs -->
            <div class="tab-content">
               <div class="tab-pane fade show active" id="tab2-1">
                  <div class="alert alert-primary alert-icon" role="alert">
                     <i class="uil uil-info-circle"></i> Dapatkan potongan biaya pendaftaran sebesar <strong>Rp.300.000</strong> bagi yang mendaftar secara <strong>Online</strong>
                  </div>
                  <div class="card card-border-start border-primary">
                     <div class="card-body">
                        <div class="form-floating mb-2">
                           <input id="textInputExample" type="text" class="form-control" placeholder="NIK">
                           <label for="textInputExample">NIK</label>
                        </div>
                        <div class="form-floating mb-2">
                           <input id="textInputExample" type="text" class="form-control" placeholder="Nama Lengkap">
                           <label for="textInputExample">Nama Lengkap (Sesuai Ijazah)</label>
                        </div>
                        <div class="form-floating mb-2">
                           <input id="textInputExample" type="email" class="form-control" placeholder="Email">
                           <label for="textInputExample">Email</label>
                        </div>
                        <div class="form-select-wrapper mb-2">
                           <select class="form-select" aria-label="Default select example">
                              <option selected>--Pilih Jenis Kelamin--</option>
                              <option value="1">Laki Laki</option>
                              <option value="2">Perempuan</option>
                           </select>
                        </div>
                        <div class="form-select-wrapper mb-2">
                           <select class="form-select" aria-label="Default select example">
                              <option selected>--Pilih Agama--</option>
                              <option value="1">Islam</option>
                              <option value="2">Kristen</option>
                              <option value="2">Budha</option>
                              <option value="2">Hindu</option>
                           </select>
                        </div>
                        <div class="row">
                           <div class="col">
                              <div class="form-floating mb-2">
                                 <input id="textInputExample" type="text" class="form-control" placeholder="Nama Lengkap">
                                 <label for="textInputExample">Tempat Lahir</label>
                              </div>
                           </div>
                           <div class="col">
                              <div class="form-floating mb-2">
                                 <input id="textInputExample" type="date" class="form-control" placeholder="Nama Lengkap">
                                 <label for="textInputExample">Tanggal Lahir</label>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col">
                              <div class="form-floating mb-2">
                                 <input id="textInputExample" type="tel" class="form-control" placeholder="Nama Lengkap">
                                 <label for="textInputExample">No.Telepon</label>
                              </div>
                           </div>
                           <div class="col">
                              <div class="form-floating mb-2">
                                 <input id="textInputExample" type="tel" class="form-control" placeholder="Nama Lengkap">
                                 <label for="textInputExample">No.Handphone (WA)</label>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card mt-3 bg-soft-primary card-border-start border-primary">
                     <div class="card-body">
                        <div class="form-select-wrapper mb-4">
                           <select class="form-select" aria-label="Default select example">
                              <option selected>--Pilih Program Studi--</option>
                              <option value="1">Ilmu Komputer</option>
                           </select>
                        </div>
                        <div class="form-select-wrapper">
                           <a class="btn btn-primary col-12 btn-icon btn-icon-start rounded">
                              <i class="uil uil-sign-in-alt"></i> Login
                           </a>
                        </div>
                     </div>
                  </div>


               </div>
               <!--/.tab-pane -->
               <div class="tab-pane fade" id="tab2-2">
                  <div class="card shadow-lg card-border-top border-primary">
                     <div class="card-body">
                        <H6>Selamat Anda Telah Terdaftar Sebagai Calon Mahasiswa/i Graha Kirana Dengan Nomor Pendaftaran : <span class="text-danger"> <?= rand(11111, 99999) ?></span> Kode Peserta : <span class="text-primary"><?= date('Ymd') . rand(222, 999) ?></span></H6>
                        <div class="alert alert-primary alert-icon" role="alert">
                           <i class="uil uil-info-circle"></i>
                           <p>Anda mendapatkan potongan biaya pendaftaran sebesar <strong>Rp.300.000</strong> secara <strong>Langsung</strong> Klik download dan cetak dengan klik link dibawah ini dan segera lakukan pembayaran</p>
                        </div>
                        <a href="print/registrasi" class="btn btn-success col-12 btn-icon btn-icon-start rounded">
                           <i class="uil uil-print"></i> Download dan Cetak Bukti Pendaftaran
                        </a>
                     </div>
                  </div>

               </div>
               <!--/.tab-pane -->
               <!--/.tab-pane -->
               <div class="tab-pane fade" id="tab3-3">
                  <div class="card shadow-lg card-border-top border-primary">
                     <div class="card-body">
                        <div class="accordion accordion-wrapper" id="accordionIconExample">
                           <div class="card accordion-item icon">
                              <div class="card-header" id="headingIconOne">
                                 <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseIconOne" aria-expanded="true" aria-controls="collapseIconOne"><span><i class="uil uil-shield-exclamation"></i></span>Melalui ATM Bank Bersama</button>
                              </div>
                              <!--/.card-header -->
                              <div id="collapseIconOne" class="accordion-collapse collapse show" aria-labelledby="headingIconOne" data-bs-parent="#accordionIconExample">
                                 <div class="card-body">
                                    <p>Melalui ATM Bank Bersama, Anda dapat dengan mudah mengakses layanan perbankan, melakukan transaksi seperti penarikan tunai, transfer dana, dan pembayaran tagihan secara praktis dan aman di seluruh Indonesia.</p> <span>Universitas Graha Kirana</span> <span class="text-danger"><strong> Bank Central Asia (BCA) : 872912292 </strong> <a onclick="copyToClipboard('Teks yang akan disalin')" class="btn btn-circle btn-gradient gradient-1 btn-sm"><i class="uil uil-copy"></i></a></span>
                                 </div>
                                 <!--/.card-body -->
                              </div>
                              <!--/.accordion-collapse -->
                           </div>
                           <!--/.accordion-item -->
                           <div class="card accordion-item icon">
                              <div class="card-header" id="headingIconTwo">
                                 <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseIconTwo" aria-expanded="false" aria-controls="collapseIconTwo"><span><i class="uil uil-shield-exclamation"></i></span>Pembayaran Langsung Ke Kampus </button>
                              </div>
                              <!--/.card-header -->
                              <div id="collapseIconTwo" class="accordion-collapse collapse" aria-labelledby="headingIconTwo" data-bs-parent="#accordionIconExample">
                                 <div class="card-body">
                                    <p>Datang dengan membawa bukti pendaftaran untuk melakukan pembayaran pendafataran ke biro keuangan</p>

                                 </div>
                                 <!--/.card-body -->
                              </div>
                              <!--/.accordion-collapse -->
                           </div>
                           <!--/.accordion-item -->
                           <div class="alert alert-primary alert-icon" role="alert">
                              <i class="uil uil-info-circle"></i> Untuk informasi lebih lanjut, dapat menghubungi atau kirim pesan whatsapp menggunakan nomor dibawah ini <a href="#" class="alert-link hover">0821-6555-8061</a> untuk melihat panduan pembayaran secara detail <span class="badge bg-danger">Klik Disini</span>
                           </div>
                        </div>
                        <!--/.accordion -->
                     </div>
                  </div>

               </div>
               <!--/.tab-pane -->
            </div>
            <!-- /.tab-content -->
         </div>
         <!-- /.container -->
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