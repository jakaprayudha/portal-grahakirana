<!DOCTYPE html>
<html lang="en">

<head>
   <base href="../">
   <?php
   $page = "E-Library";
   require '../head.php';
   ?>
</head>

<body>
   <div class="content-wrapper">
      <?php
      require '../navbar.php';
      ?>
      <!-- /header -->
      <section class="wrapper bg-gray">
         <div class="container py-3 py-md-5">
            <nav class="d-inline-block" aria-label="breadcrumb">
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">E-Library</li>
               </ol>
            </nav>
            <!-- /nav -->
         </div>
         <!-- /.container -->
      </section>
      <!-- /section -->
      <section class="wrapper bg-light">
         <div class="container pb-14 pb-md-16 pt-12">
            <div class="row gy-10">
               <div class="col-lg-9 order-lg-2">
                  <div class="row align-items-center mb-10 position-relative zindex-1">
                     <div class="col-md-7 col-xl-8 pe-xl-20">
                        <h2 class="display-6 mb-1">Katalog Buku</h2>
                        <p class="mb-0 text-muted">Showing 1–3 of 30 results</p>
                     </div>
                     <!--/column -->
                     <div class="col-md-5 col-xl-4 ms-md-auto text-md-end mt-5 mt-md-0">
                        <div class="form-select-wrapper">
                           <select class="form-select">
                              <option value="popularity">Sort by popularity</option>
                              <option value="rating">Sort by category</option>
                              <option value="newness">Sort by publisher</option>
                              <option value="price: low to high">Sort by availability</option>
                           </select>
                        </div>
                        <!--/.form-select-wrapper -->
                     </div>
                     <!--/column -->
                  </div>
                  <!--/.row -->
                  <div class="grid grid-view projects-masonry shop mb-13">
                     <div class="row gx-md-8 gy-10 gy-md-13 isotope">
                        <div class="project item col-md-6 col-xl-4">
                           <figure class="rounded mb-6">
                              <img src="./assets/img/photos/sh1.jpg" srcset="./assets/img/photos/sh1@2x.jpg 2x" alt="" />
                              <a class="item-like" href="#" data-bs-toggle="white-tooltip" title="Add to wishlist"><i class="uil uil-heart"></i></a>
                              <a class="item-view" href="#" data-bs-toggle="white-tooltip" title="Quick view"><i class="uil uil-eye"></i></a>
                              <a href="#" class="item-cart"><i class="uil uil-shopping-bag"></i> Add to Cart</a>
                              <span class="avatar bg-pink text-white w-10 h-10 position-absolute text-uppercase fs-13" style="top: 1rem; left: 1rem;"><span>New!</span></span>
                           </figure>
                           <div class="post-header">
                              <div class="d-flex flex-row align-items-center justify-content-between mb-2">
                                 <div class="post-category text-ash mb-0">Shoes</div>
                                 <span class="ratings five"></span>
                              </div>
                              <h2 class="post-title h3 fs-22"><a href="./shop-product.html" class="link-dark">Nike Air Sneakers</a></h2>
                              <p class="price"><del><span class="amount">$55.00</span></del> <ins><span class="amount">$45.00</span></ins></p>
                           </div>
                           <!-- /.post-header -->
                        </div>
                        <!-- /.item -->
                        <div class="project item col-md-6 col-xl-4">
                           <figure class="rounded mb-6">
                              <img src="./assets/img/photos/sh2.jpg" srcset="./assets/img/photos/sh2@2x.jpg 2x" alt="" />
                              <a class="item-like" href="#" data-bs-toggle="white-tooltip" title="Add to wishlist"><i class="uil uil-heart"></i></a>
                              <a class="item-view" href="#" data-bs-toggle="white-tooltip" title="Quick view"><i class="uil uil-eye"></i></a>
                              <a href="#" class="item-cart"><i class="uil uil-shopping-bag"></i> Add to Cart</a>
                           </figure>
                           <div class="post-header">
                              <div class="d-flex flex-row align-items-center justify-content-between mb-2">
                                 <div class="post-category text-ash mb-0">Electronics</div>
                                 <span class="ratings four"></span>
                              </div>
                              <h2 class="post-title h3 fs-22"><a href="./shop-product.html" class="link-dark">Apple Watch</a></h2>
                              <p class="price"><span class="amount">$55.00</span></p>
                           </div>
                           <!-- /.post-header -->
                        </div>
                        <!-- /.item -->
                        <div class="project item col-md-6 col-xl-4">
                           <figure class="rounded mb-6">
                              <img src="./assets/img/photos/sh3.jpg" srcset="./assets/img/photos/sh3@2x.jpg 2x" alt="" />
                              <a class="item-like" href="#" data-bs-toggle="white-tooltip" title="Add to wishlist"><i class="uil uil-heart"></i></a>
                              <a class="item-view" href="#" data-bs-toggle="white-tooltip" title="Quick view"><i class="uil uil-eye"></i></a>
                              <a href="#" class="item-cart"><i class="uil uil-shopping-bag"></i> Add to Cart</a>
                              <span class="avatar bg-aqua text-white w-10 h-10 position-absolute text-uppercase fs-13" style="top: 1rem; left: 1rem;"><span>New!</span></span>
                           </figure>
                           <div class="post-header">
                              <div class="d-flex flex-row align-items-center justify-content-between mb-2">
                                 <div class="post-category text-ash mb-0">Electronics</div>
                              </div>
                              <h2 class="post-title h3 fs-22"><a href="./shop-product.html" class="link-dark">Headphones</a></h2>
                              <p class="price"><span class="amount">$55.00</span></p>
                           </div>
                           <!-- /.post-header -->
                        </div>

                     </div>
                     <!-- /.row -->
                  </div>
                  <!-- /.grid -->
                  <nav class="d-flex" aria-label="pagination">
                     <ul class="pagination">
                        <li class="page-item disabled">
                           <a class="page-link" href="#" aria-label="Previous">
                              <span aria-hidden="true"><i class="uil uil-arrow-left"></i></span>
                           </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                           <a class="page-link" href="#" aria-label="Next">
                              <span aria-hidden="true"><i class="uil uil-arrow-right"></i></span>
                           </a>
                        </li>
                     </ul>
                     <!-- /.pagination -->
                  </nav>
                  <!-- /nav -->
               </div>
               <!-- /column -->
               <aside class="col-lg-3 sidebar">
                  <div class="widget mt-1">
                     <h4 class="widget-title mb-3">Categories</h4>
                     <ul class="list-unstyled ps-0">
                        <li class="mb-1">
                           <a href="#" class="align-items-center rounded link-body" data-bs-toggle="collapse" data-bs-target="#clothing-collapse" aria-expanded="true"> Komputer <span class="fs-sm text-muted ms-1">(21)</span>
                           </a>
                           <div class="collapse show mt-1" id="clothing-collapse">
                              <ul class="btn-toggle-nav list-unstyled ps-2">
                                 <li><a href="#" class="link-body">Bahasa Pemrograman</a></li>
                                 <li><a href="#" class="link-body">Android</a></li>
                                 <li><a href="#" class="link-body">Matlab</a></li>
                              </ul>
                           </div>
                        </li>
                        <li class="mb-1">
                           <a href="#" class="align-items-center rounded collapsed link-body" data-bs-toggle="collapse" data-bs-target="#electronics-collapse" aria-expanded="false"> Ekonomi Bisnis <span class="fs-sm text-muted ms-1">(19)</span>
                           </a>
                           <div class="collapse mt-1" id="electronics-collapse">
                              <ul class="btn-toggle-nav list-unstyled ps-2">
                                 <li><a href="#" class="link-body">Akuntansi</a></li>
                                 <li><a href="#" class="link-body">Bisnis Digital</a></li>
                              </ul>
                           </div>
                        </li>
                        <li class="mb-1">
                           <a href="#" class="align-items-center rounded collapsed link-body" data-bs-toggle="collapse" data-bs-target="#shoes-collapse" aria-expanded="false"> Hukum <span class="fs-sm text-muted ms-1">(12)</span>
                           </a>
                           <div class="collapse mt-1" id="shoes-collapse">
                              <ul class="btn-toggle-nav list-unstyled ps-2">
                                 <li><a href="#" class="link-body">Hak Asasi Manusia</a></li>
                                 <li><a href="#" class="link-body">Perdata</a></li>
                                 <li><a href="#" class="link-body">Pidana</a></li>
                              </ul>
                           </div>
                        </li>
                     </ul>
                  </div>
                  <!-- /.widget -->
                  <div class="widget">
                     <h4 class="widget-title mb-3">Rating</h4>
                     <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="rating" id="rating5" checked>
                        <label class="form-check-label" for="rating5">
                           <span class="ratings five"></span>
                        </label>
                     </div>
                     <!-- /.form-check -->
                     <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="rating" id="rating4">
                        <label class="form-check-label" for="rating4">
                           <span class="ratings four"></span>
                        </label>
                     </div>
                     <!-- /.form-check -->
                     <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="rating" id="rating3">
                        <label class="form-check-label" for="rating3">
                           <span class="ratings three"></span>
                        </label>
                     </div>
                     <!-- /.form-check -->
                     <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="rating" id="rating2">
                        <label class="form-check-label" for="rating2">
                           <span class="ratings two"></span>
                        </label>
                     </div>
                     <!-- /.form-check -->
                     <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="rating" id="rating1">
                        <label class="form-check-label" for="rating1">
                           <span class="ratings one"></span>
                        </label>
                     </div>
                     <!-- /.form-check -->
                  </div>
                  <div class="widget">
                     <h4 class="widget-title mb-3">Penerbit</h4>
                     <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="price" id="price1" checked>
                        <label class="form-check-label" for="price1"> Andi Publisher </label>
                     </div>
                     <!-- /.form-check -->
                     <div class="form-check mb-1">
                        <input class="form-check-input" type="radio" name="price" id="price2">
                        <label class="form-check-label" for="price2"> Informatika Pub</label>
                     </div>
                  </div>
                  <!-- /.widget -->
               </aside>
               <!-- /column .sidebar -->
            </div>
            <!-- /.row -->
         </div>
         <!-- /.container -->
      </section>
      <!-- /section -->
      <section class="wrapper bg-gray">
         <div class="container py-12 py-md-14">
            <div class="row gx-lg-8 gx-xl-12 gy-8">
               <div class="col-md-6 col-lg-4">
                  <div class="d-flex flex-row">
                     <div>
                        <img src="./assets/img/icons/solid/shipment.svg" class="svg-inject icon-svg icon-svg-sm solid-mono text-navy me-4" alt="" />
                     </div>
                     <div>
                        <h4 class="mb-1">Free Biaya</h4>
                        <p class="mb-0">Duis mollis gravida commodo id luctus erat porttitor ligula, eget lacinia odio sem.</p>
                     </div>
                  </div>
               </div>
               <!--/column -->
               <div class="col-md-6 col-lg-4">
                  <div class="d-flex flex-row">
                     <div>
                        <img src="./assets/img/icons/solid/push-cart.svg" class="svg-inject icon-svg icon-svg-sm solid-mono text-navy me-4" alt="" />
                     </div>
                     <div>
                        <h4 class="mb-1">30 Days Return</h4>
                        <p class="mb-0">Duis mollis gravida commodo id luctus erat porttitor ligula, eget lacinia odio sem.</p>
                     </div>
                  </div>
               </div>
               <!--/column -->
               <div class="col-md-6 col-lg-4">
                  <div class="d-flex flex-row">
                     <div>
                        <img src="./assets/img/icons/solid/verify.svg" class="svg-inject icon-svg icon-svg-sm solid-mono text-navy me-4" alt="" />
                     </div>
                     <div>
                        <h4 class="mb-1">Multiple rent book</h4>
                        <p class="mb-0">Duis mollis gravida commodo id luctus erat porttitor ligula, eget lacinia odio sem.</p>
                     </div>
                  </div>
               </div>
               <!--/column -->
            </div>
            <!--/.row -->
         </div>
         <!-- /.container -->
      </section>
      <!-- /section -->
   </div>
   <!-- /.content-wrapper -->
   <?php
   require '../footer3.php';
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