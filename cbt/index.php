<!DOCTYPE html>
<html lang="en">

<head>
   <base href="../">
   <?php
   $page = "Alumni";
   require '../head.php';
   ?>
</head>

<body>
   <div class="content-wrapper">
      <?php
      require '../navbar.php';
      ?>
      <!-- /header -->
      <section class="wrapper bg-dark text-white">
         <div class="container pt-18 pt-md-0 pb-20 pb-md-21 text-center">
            <!-- /.row -->
         </div>
         <!-- /.container -->
      </section>
      <!-- /section -->
      <section class="wrapper bg-light">
         <div class="container pb-14 pb-md-16">
            <div class="row">
               <div class="col mt-n19">
                  <div class="card shadow-lg">
                     <div class="row gx-0 text-center">
                        <div class="col-lg-6 image-wrapper bg-image bg-cover rounded-top rounded-lg-start d-none d-md-block" data-image-src="./assets/img/photos/tm3.jpg">
                        </div>
                        <!--/column -->
                        <div class="col-lg-6">
                           <div class="p-10 p-md-11 p-lg-13">
                              <h2 class="mb-3 text-start">Welcome Back</h2>
                              <p class="lead mb-6 text-start">Fill your email and password to sign in.</p>
                              <form class="text-start mb-3">
                                 <div class="form-floating mb-4">
                                    <input type="email" class="form-control" placeholder="Email" id="loginEmail">
                                    <label for="loginEmail">Email</label>
                                 </div>
                                 <div class="form-floating password-field mb-4">
                                    <input type="password" class="form-control" placeholder="Password" id="loginPassword">
                                    <span class="password-toggle"><i class="uil uil-eye"></i></span>
                                    <label for="loginPassword">Password</label>
                                 </div>
                                 <a class="btn btn-primary rounded-pill btn-login w-100 mb-2">Sign In</a>
                              </form>
                              <!-- /form -->
                              <p class="mb-1"><a href="#" class="hover">Forgot Password?</a></p>
                              <p class="mb-0">Don't have an account? <a href="./signup2.html" class="hover">Sign up</a></p>
                              <div class="divider-icon my-4">or</div>
                              <nav class="nav social justify-content-center text-center">
                                 <a href="#" class="btn btn-circle btn-sm btn-google"><i class="uil uil-google"></i></a>
                                 <a href="#" class="btn btn-circle btn-sm btn-facebook-f"><i class="uil uil-facebook-f"></i></a>
                                 <a href="#" class="btn btn-circle btn-sm btn-twitter"><i class="uil uil-twitter"></i></a>
                              </nav>
                              <!--/.social -->
                           </div>
                           <!--/div -->
                        </div>
                        <!--/column -->
                     </div>
                     <!--/.row -->
                  </div>
                  <!-- /.card -->
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