<style>
   .logo-navbar {
      height: 60px;
      width: auto;
      display: block;
   }

   @media (max-width:991px) {

      .logo-navbar {
         height: 50px;
      }

   }

   .nav.social {
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 12px;
      flex-wrap: nowrap;
   }
</style>
<header class="wrapper">
   <nav class="navbar navbar-expand-lg center-nav transparent navbar-light caret-none">
      <div class="container flex-lg-row flex-nowrap align-items-center">
         <div class="navbar-brand">
            <a href="./index">
               <img src="./assets/img/logo-stih.png"
                  alt="STIH Graha Kirana"
                  class="logo-navbar">
            </a>
         </div>
         <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
            <div class="offcanvas-header d-lg-none">
               <h3 class="text-white fs-30 mb-0">Graha Kirana</h3>
               <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body ms-lg-auto d-flex flex-column h-100">
               <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Tentang</a>
                     <ul class="dropdown-menu">
                        <!-- <li class="dropdown dropdown-submenu dropend"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Kata Sambutan</a>
                           <ul class="dropdown-menu">
                              <li class="nav-item"><a class="dropdown-item" href="./sambutan-yayasan">Sambutan Yayasan </a></li>
                              <li class="nav-item"><a class="dropdown-item" href="./sambutan-ketua">Sambutan Ketua Sekolah Tinggi</a></li>
                           </ul>
                        </li> -->
                        <li class="dropdown dropdown-submenu dropend"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Graha Kirana</a>
                           <ul class="dropdown-menu">
                              <li class="nav-item"><a class="dropdown-item" href="./about-pendiri">Pendiri</a></li>
                              <li class="nav-item"><a class="dropdown-item" href="./about-pengurus">Pengurus</a></li>
                              <!-- <li class="nav-item"><a class="dropdown-item" href="./about-struktur">Struktur Organisasi</a></li> -->
                              <li class="nav-item"><a class="dropdown-item" href="./about-identitas">Identitas Kampus</a></li>
                           </ul>
                        </li>
                        <!-- <li class="nav-item"><a class="dropdown-item" href="./dokumentasi">Dokumentasi</a></li> -->
                        <!-- <li class="nav-item"><a class="dropdown-item" href="./laporan-tahunan">Laporan Tahunan</a></li> -->
                        <li class="nav-item"><a class="dropdown-item" href="./sejarah">Sejarah dan Pendirian </a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./visi-misi">Visi, Misi dan Tujuan </a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./program-studi">Program Studi </a></li>
                     </ul>
                  </li>


                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Akademik</a>
                     <div class="dropdown-menu dropdown-lg">
                        <div class="dropdown-lg-content">
                           <div>
                              <h6 class="dropdown-header">STIH</h6>
                              <ul class="list-unstyled">
                                 <li><a class="dropdown-item" href="./kebijakan-akademik">Kebijakan Akademik & Kurikulum</a></li>
                                 <li><a class="dropdown-item" href="./kurikulum">Kurikulum & Mata Kuliah Program Studi</a></li>
                                 <li><a class="dropdown-item" href="./pengajar">Tenaga Pengajar</a></li>
                                 <li><a class="dropdown-item" href="./hak-belajar">Hak Belajar Di Luar Prodi</a></li>
                                 <li><a class="dropdown-item" href="./tenaga-kependidikan">Tenaga Kependidikan</a></li>
                                 <li><a class="dropdown-item" href="./layanan-kemahasiswaan">Layanan Kemahasiswaan</a></li>
                                 <li><a class="dropdown-item" href="./metode-belajar">Metode Belajar</a></li>
                                 <li><a class="dropdown-item" href="./kalender-akademik">Kalender Akademik</a></li>
                                 <li><a class="dropdown-item" href="./pedoman-akademik">Pedoman Akademik</a></li>
                              </ul>
                           </div>
                        </div>
                        <!-- /auto-column -->
                     </div>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Fasilitas Kampus</a>
                     <ul class="dropdown-menu">
                        <li class="nav-item"><a class="dropdown-item" href="./fasilitas-layanan">Fasilitas Pembelajaran</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./lab-peradilan">Laboratorium Peradilan Semu</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./library">Perpustakaan </a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./organisasi-kemahasiswaan">Organisasi Kemahasiswaan</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./kabar-mahasiswa-alumni">Kabar Mahasiswa & Alumni</a></li>
                     </ul>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">P2M</a>
                     <ul class="dropdown-menu">
                        <li class="nav-item"><a class="dropdown-item" href="./ojs-jurnal">OJS Jurnal</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./kabar-penelitian">Kabar Penelitian</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./kabar-pengmas">Kabar Pengmas </a></li>
                     </ul>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">PMB</a>
                     <ul class="dropdown-menu">
                        <li class="nav-item"><a class="dropdown-item" href="./jalur-pendaftaran">Jalur Pendaftaran</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./syarat-ketentuan">Syarat & Ketentuan</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./biaya-kuliah">Biaya Kuliah</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./beasiswa">Beasiswa</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./jadwal-alur-pendaftaran">Jadwal & Alur Pendaftaran </a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./pmb/register">Daftar</a></li>
                     </ul>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Penjaminan Mutu</a>
                     <ul class="dropdown-menu">
                        <li class="nav-item"><a class="dropdown-item" href="./status-akreditasi">Status Akreditasi</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./spmi">SPMI</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./siklus-ppepp">Siklus PPEPP</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./fakta-angka-kinerja">Fakta & Angka Kinerja</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./survey-kepuasan">Survey Kepuasan</a></li>
                     </ul>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Tata Kelola</a>
                     <ul class="dropdown-menu">
                        <li class="nav-item"><a class="dropdown-item" href="./about-struktur">Struktur Organisasi</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./praktik-gug">Praktik GUG</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./perencanaan">Perencanaan</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./kode-etik">Kode Etik</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./suasana-akademik">Suasana Akademik</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./akuntabilitas">Akuntabilitas</a></li>
                     </ul>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Berita</a>
                     <ul class="dropdown-menu">
                        <li class="nav-item"><a class="dropdown-item" href="./berita-umum">Berita Umum</a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./berita-kampus">Berita Kampus </a></li>
                        <li class="nav-item"><a class="dropdown-item" href="./berita-pengumuman">Pengumuman </a></li>
                     </ul>
                  </li>
                  <li class="nav-item dropdown dropdown-mega">
                     <a class="nav-link dropdown-toggle" href="javascripr:;" data-bs-toggle="dropdown">Layanan</a>
                     <ul class="dropdown-menu mega-menu mega-menu-dark mega-menu-img">
                        <li class="mega-menu-content">
                           <ul class="row row-cols-1 row-cols-lg-6 gx-0 gx-lg-6 gy-lg-4 list-unstyled">
                              <li class="col"><a class="dropdown-item" href="pmb/">
                                    <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block1.svg" alt=""></div>
                                    <span>PMB</span>
                                 </a>
                              </li>
                              <li class="col"><a class="dropdown-item" href="https://siakad.info/" target="_blank">
                                    <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block10.svg" alt=""></div>
                                    <span>SIAKAD</span>
                                 </a>
                              </li>
                              <li class="col"><a class="dropdown-item" href="./administrasi-akademik">
                                    <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block14.svg" alt=""></div>
                                    <span>Administrasi Akademik</span>
                                 </a>
                              </li>
                              <li class="col"><a class="dropdown-item" href="./bimbingan-konseling">
                                    <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block15.svg" alt=""></div>
                                    <span>Bimbingan Konseling</span>
                                 </a>
                              </li>
                              <li class="col"><a class="dropdown-item" href="./alumni/">
                                    <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block13.svg" alt=""></div>
                                    <span>Almuni</span>
                                 </a>
                              </li>
                              <li class="col"><a class="dropdown-item" href="./karir/">
                                    <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block3.svg" alt=""></div>
                                    <span>Karir</span>
                                 </a>
                              </li>
                              <li class="col"><a class="dropdown-item" href="./cbt/">
                                    <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block4.svg" alt=""></div>
                                    <span>CBT</span>
                                 </a>
                              </li>
                              <li class="col"><a class="dropdown-item" href="./perpustakaan/">
                                    <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block5.svg" alt=""></div>
                                    <span>E-Perpustakaan</span>
                                 </a>
                              </li>
                              <li class="col"><a class="dropdown-item" href="./forum/">
                                    <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block6.svg" alt=""></div>
                                    <span>Forum</span>
                                 </a>
                              </li>
                              <li class="col"><a class="dropdown-item" href="./docs/blocks/faq.html">
                                    <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block7.svg" alt=""></div>
                                    <span>Jurnal Kampus</span>
                                 </a>
                              </li>
                              <li class="col"><a class="dropdown-item" href="./docs/blocks/features.html">
                                    <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block8.svg" alt=""></div>
                                    <span>PRPM</span>
                                 </a>
                              </li>
                              <li class="col"><a class="dropdown-item" href="./docs/blocks/footer.html">
                                    <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block9.svg" alt=""></div>
                                    <span>Kotak Saran</span>
                                 </a>
                              </li>
                              <li class="col"><a class="dropdown-item" href="./docs/blocks/hero.html">
                                    <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block10.svg" alt=""></div>
                                    <span>Graha Kirana Apps</span>
                                 </a>
                              </li>
                              <li class="col"><a class="dropdown-item" href="./docs/blocks/testimonials.html">
                                    <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block16.svg" alt=""></div>
                                    <span>Testimoni</span>
                                 </a>
                              </li>
                           </ul>
                           <!--/.row -->
                        </li>
                        <!--/.mega-menu-content-->
                     </ul>
                     <!--/.dropdown-menu -->
                  </li>
               </ul>
               <!-- /.navbar-nav -->
               <div class="offcanvas-footer d-lg-none">
                  <div>
                     <a href="mailto:info@grahakirana-stih.ac.id" class="link-inverse">info@grahakirana-stih.ac.id</a>
                     <br /> 62 821-6652-4717 <br />
                     <nav class="nav social social-white mt-4">
                        <a href="#"><i class="uil uil-twitter"></i></a>
                        <a href="#"><i class="uil uil-facebook-f"></i></a>
                        <a href="#"><i class="uil uil-instagram"></i></a>
                        <a href="#"><i class="uil uil-youtube"></i></a>
                     </nav>
                     <!-- /.social -->
                  </div>
               </div>
               <!-- /.offcanvas-footer -->
            </div>
            <!-- /.offcanvas-body -->
         </div>
         <!-- /.navbar-collapse -->
         <div class="navbar-other w-100 d-flex ms-auto">
            <ul class="navbar-nav flex-row align-items-center ms-auto">
               <li class="nav-item">
                  <nav class="nav social social-muted justify-content-end text-end">
                     <a href="#"><i class="uil uil-twitter"></i></a>
                     <a href="#"><i class="uil uil-facebook-f"></i></a>
                     <a href="#"><i class="uil uil-youtube"></i></a>
                     <a href="#"><i class="uil uil-instagram"></i></a>
                  </nav>
                  <!-- /.social -->
               </li>
               <li class="nav-item d-lg-none">
                  <button class="hamburger offcanvas-nav-btn"><span></span></button>
               </li>
            </ul>
            <!-- /.navbar-nav -->
         </div>
         <!-- /.navbar-other -->
      </div>
      <!-- /.container -->
   </nav>
   <!-- /.navbar -->
</header>