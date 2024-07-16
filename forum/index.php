<!DOCTYPE html>
<html lang="en">

<head>
   <base href="../">
   <?php
   $page = "Forum";
   require '../head.php';
   ?>
</head>

<body>
   <div class="content-wrapper">
      <?php
      require '../navbar.php';
      ?>
      <!-- /header -->
      <section class="wrapper bg-soft-primary position-relative">
         <div class="container pt-10 pb-17 pt-md-14 text-center">
            <div class="row">
               <div class="col-lg-8 mx-auto mb-5">
                  <h1 class="fs-15 text-uppercase text-muted mb-3">Forum Diskusi Graha Kirana</h1>
                  <h3 class="display-1 mb-6">berbagi informasi seluruh civitas akademik</h3>
                  <a href="#" class="btn btn-lg btn-primary rounded-pill">Buat Forum Baru</a>
               </div>
               <!-- /column -->
            </div>
            <!-- /.row -->
         </div>
         <!-- /.container -->
         <div class="overflow-hidden">
            <div class="divider text-light mx-n2">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 60">
                  <path fill="currentColor" d="M0,0V60H1440V0A5771,5771,0,0,1,0,0Z" />
               </svg>
            </div>
         </div>
      </section>
      <!-- /section -->
      <section class="wrapper bg-light">

         <div class="container pb-15 pb-md-17">

            <div class="row gx-md-5 gy-5 mt-n18 mt-md-n19">
               <div class="row">
                  <div class="col-xl-10 mx-auto">
                     <form class="filter-form mb-10">
                        <div class="row">
                           <div class="col-md-4 mb-3">
                              <div class="form-select-wrapper">
                                 <select class="form-select" aria-label="">
                                    <option selected>Position</option>
                                    <option value="position1">Business</option>
                                    <option value="position2">Design</option>
                                    <option value="position3">Development</option>
                                    <option value="position4">Engineering</option>
                                    <option value="position5">Finance</option>
                                    <option value="position6">Marketing</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-4 mb-3">
                              <div class="form-select-wrapper">
                                 <select class="form-select" aria-label="">
                                    <option selected>Type</option>
                                    <option value="type1">Full-time</option>
                                    <option value="type3">Part-time</option>
                                    <option value="type4">Remote</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-4 mb-3">
                              <div class="form-select-wrapper">
                                 <select class="form-select" aria-label="">
                                    <option selected>Location</option>
                                    <option value="location1">Chicago, US</option>
                                    <option value="location3">Michigan, US</option>
                                    <option value="location2">New York, US</option>
                                    <option value="location4">Los Angles, US</option>
                                    <option value="location5">Moscow, Russia</option>
                                    <option value="location6">Sydney, Australia</option>
                                    <option value="location7">Birmingham, UK</option>
                                    <option value="location8">Manchester, UK</option>
                                    <option value="location9">Beijing, China</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
                  <!-- /column -->
               </div>
               <div class="col-md-6 col-xl-12 ">
                  <!-- /.blog -->
                  <div class="blog grid grid-view">
                     <div class="row isotope gx-md-12 gy-8 mb-8">
                        <article class="item post col-md-6">
                           <div class="card">
                              <figure class="card-img-top overlay overlay-1 hover-scale"><a href="#"> <img src="./assets/img/photos/b4.jpg" alt="" /></a>
                                 <figcaption>
                                    <h5 class="from-top mb-0">Read More</h5>
                                 </figcaption>
                              </figure>
                              <div class="card-body">
                                 <div class="post-header">
                                    <div class="post-category text-line">
                                       <a href="#" class="hover" rel="category">Coding</a>
                                    </div>
                                    <!-- /.post-category -->
                                    <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark" href="./blog-post.html">Ligula tristique quis risus</a></h2>
                                 </div>
                                 <!-- /.post-header -->
                                 <div class="post-content">
                                    <p>Mauris convallis non ligula non interdum. Gravida vulputate convallis tempus vestibulum cras imperdiet nun eu dolor. Aenean lacinia bibendum nulla sed.</p>
                                 </div>
                                 <!-- /.post-content -->
                              </div>
                              <!--/.card-body -->
                              <div class="card-footer">
                                 <ul class="post-meta d-flex mb-0">
                                    <li class="post-date"><i class="uil uil-calendar-alt"></i><span>14 Apr 2022</span></li>
                                    <li class="post-comments"><a href="#"><i class="uil uil-comment"></i>4</a></li>
                                    <li class="post-likes ms-auto"><a href="#"><i class="uil uil-heart-alt"></i>5</a></li>
                                 </ul>
                                 <!-- /.post-meta -->
                              </div>
                              <!-- /.card-footer -->
                           </div>
                           <!-- /.card -->
                        </article>
                        <!-- /.post -->
                        <article class="item post col-md-6">
                           <div class="card">
                              <figure class="card-img-top overlay overlay-1 hover-scale"><a href="#"> <img src="./assets/img/photos/b5.jpg" alt="" /></a>
                                 <figcaption>
                                    <h5 class="from-top mb-0">Read More</h5>
                                 </figcaption>
                              </figure>
                              <div class="card-body">
                                 <div class="post-header">
                                    <div class="post-category text-line">
                                       <a href="#" class="hover" rel="category">Workspace</a>
                                    </div>
                                    <!-- /.post-category -->
                                    <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark" href="./blog-post.html">Nullam id dolor elit id nibh</a></h2>
                                 </div>
                                 <!-- /.post-header -->
                                 <div class="post-content">
                                    <p>Mauris convallis non ligula non interdum. Gravida vulputate convallis tempus vestibulum cras imperdiet nun eu dolor. Aenean lacinia bibendum nulla sed.</p>
                                 </div>
                                 <!-- /.post-content -->
                              </div>
                              <!--/.card-body -->
                              <div class="card-footer">
                                 <ul class="post-meta d-flex mb-0">
                                    <li class="post-date"><i class="uil uil-calendar-alt"></i><span>29 Mar 2022</span></li>
                                    <li class="post-comments"><a href="#"><i class="uil uil-comment"></i>3</a></li>
                                    <li class="post-likes ms-auto"><a href="#"><i class="uil uil-heart-alt"></i>3</a></li>
                                 </ul>
                                 <!-- /.post-meta -->
                              </div>
                              <!-- /.card-footer -->
                           </div>
                           <!-- /.card -->
                        </article>
                        <!-- /.post -->
                        <article class="item post col-md-6">
                           <div class="card">
                              <figure class="card-img-top overlay overlay-1 hover-scale"><a href="#"> <img src="./assets/img/photos/b6.jpg" alt="" /></a>
                                 <figcaption>
                                    <h5 class="from-top mb-0">Read More</h5>
                                 </figcaption>
                              </figure>
                              <div class="card-body">
                                 <div class="post-header">
                                    <div class="post-category text-line">
                                       <a href="#" class="hover" rel="category">Meeting</a>
                                    </div>
                                    <!-- /.post-category -->
                                    <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark" href="./blog-post.html">Ultricies fusce porta elit</a></h2>
                                 </div>
                                 <!-- /.post-header -->
                                 <div class="post-content">
                                    <p>Mauris convallis non ligula non interdum. Gravida vulputate convallis tempus vestibulum cras imperdiet nun eu dolor. Aenean lacinia bibendum nulla sed.</p>
                                 </div>
                                 <!-- /.post-content -->
                              </div>
                              <!--/.card-body -->
                              <div class="card-footer">
                                 <ul class="post-meta d-flex mb-0">
                                    <li class="post-date"><i class="uil uil-calendar-alt"></i><span>26 Feb 2022</span></li>
                                    <li class="post-comments"><a href="#"><i class="uil uil-comment"></i>6</a></li>
                                    <li class="post-likes ms-auto"><a href="#"><i class="uil uil-heart-alt"></i>3</a></li>
                                 </ul>
                                 <!-- /.post-meta -->
                              </div>
                              <!-- /.card-footer -->
                           </div>
                           <!-- /.card -->
                        </article>
                        <!-- /.post -->
                        <article class="item post col-md-6">
                           <div class="card">
                              <figure class="card-img-top overlay overlay-1 hover-scale"><a href="#"> <img src="./assets/img/photos/b7.jpg" alt="" /></a>
                                 <figcaption>
                                    <h5 class="from-top mb-0">Read More</h5>
                                 </figcaption>
                              </figure>
                              <div class="card-body">
                                 <div class="post-header">
                                    <div class="post-category text-line">
                                       <a href="#" class="hover" rel="category">Business Tips</a>
                                    </div>
                                    <!-- /.post-category -->
                                    <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark" href="./blog-post.html">Morbi leo risus porta eget</a></h2>
                                 </div>
                                 <div class="post-content">
                                    <p>Mauris convallis non ligula non interdum. Gravida vulputate convallis tempus vestibulum cras imperdiet nun eu dolor. Aenean lacinia bibendum nulla sed.</p>
                                 </div>
                                 <!-- /.post-content -->
                              </div>
                              <!--/.card-body -->
                              <div class="card-footer">
                                 <ul class="post-meta d-flex mb-0">
                                    <li class="post-date"><i class="uil uil-calendar-alt"></i><span>7 Jan 2022</span></li>
                                    <li class="post-comments"><a href="#"><i class="uil uil-comment"></i>2</a></li>
                                    <li class="post-likes ms-auto"><a href="#"><i class="uil uil-heart-alt"></i>5</a></li>
                                 </ul>
                                 <!-- /.post-meta -->
                              </div>
                              <!-- /.card-footer -->
                           </div>
                           <!-- /.card -->
                        </article>
                        <!-- /.post -->
                     </div>
                     <!-- /.row -->
                  </div>
               </div>
            </div>

            <!-- /.row -->
         </div>
         <!-- /.container -->
      </section>
      <!-- /section -->
      <section class="wrapper bg-soft-primary">
         <div class="container py-14 py-md-16">
            <div class="row">
               <div class="col-lg-10 col-xl-9 col-xxl-8 mx-auto text-center">
                  <h2 class="fs-15 text-uppercase text-muted mb-3">Can't find the right position?</h2>
                  <h3 class="display-4 mb-7 px-lg-5 px-xl-0 px-xxl-5">We are a community with 5000+ team members. Join and build the future with us.</h3>
                  <a href="#" class="btn btn-lg btn-primary rounded-pill">Contact Us</a>
               </div>
               <!-- /column -->
            </div>
            <!-- /.row -->
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