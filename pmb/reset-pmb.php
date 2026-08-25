<?php

session_start();

require_once '../config/connect.php';

$page = 'Lupa Password PMB';

?>
<!DOCTYPE html>

<html lang="en">

<head>

   <base href="../">

   <?php
   require '../head.php';
   ?>

   <style>
      /* =========================================================
         LUPA PASSWORD PMB
      ========================================================= */

      .pmb-forgot-section {

         min-height: calc(100vh - 120px);

         display: flex;

         align-items: center;

         padding-top: 60px;

         padding-bottom: 60px;

      }


      .pmb-forgot-wrapper {

         max-width: 1000px;

         margin: 0 auto;

      }


      .pmb-forgot-info {

         min-height: 500px;

      }


      .pmb-forgot-card {

         max-width: 520px;

         margin: 0 auto;

      }


      .pmb-forgot-card .card-body {

         padding: 3rem !important;

      }


      .pmb-forgot-input {

         min-height: 56px;

      }


      .pmb-forgot-button {

         min-height: 54px;

      }


      .pmb-reset-result {

         display: none;

      }


      .pmb-reset-code {

         font-size: 38px;

         font-weight: 700;

         letter-spacing: 8px;

         text-align: center;

         padding: 20px;

         border-radius: 12px;

         background: #f1f5ff;

         color: #3f78e0;

      }


      /* =========================================================
         TABLET
      ========================================================= */

      @media (max-width: 991.98px) {

         .pmb-forgot-section {

            padding-top: 50px;

            padding-bottom: 50px;

         }


         .pmb-forgot-info {

            min-height: auto;

         }


         .pmb-forgot-card {

            max-width: 100%;

         }

      }


      /* =========================================================
         MOBILE
      ========================================================= */

      @media (max-width: 767.98px) {

         .pmb-forgot-section {

            padding-top: 35px;

            padding-bottom: 35px;

         }


         .pmb-forgot-info {

            margin-bottom: 20px;

         }


         .pmb-forgot-info .card-body {

            padding: 1.5rem !important;

         }


         .pmb-forgot-card .card-body {

            padding: 1.5rem !important;

         }


         .pmb-reset-code {

            font-size: 30px;

            letter-spacing: 5px;

         }

      }


      @media (max-width: 575.98px) {

         .pmb-reset-code {

            font-size: 26px;

            letter-spacing: 4px;

         }

      }
   </style>

</head>


<body>

   <div class="content-wrapper">


      <?php
      require '../navbar.php';
      ?>


      <!-- =====================================================
           SECTION : LUPA PASSWORD
      ====================================================== -->

      <section class="wrapper bg-light pmb-forgot-section">

         <div class="container">

            <div
               class="
                  row
                  gx-lg-8
                  gy-8
                  align-items-center
                  pmb-forgot-wrapper
               ">


               <!-- =================================================
                    LEFT
               ================================================== -->

               <div class="col-12 col-lg-5">

                  <div
                     class="
                        card
                        bg-primary
                        text-white
                        border-0
                        shadow-lg
                        pmb-forgot-info
                     ">

                     <div
                        class="
                           card-body
                           p-8
                           d-flex
                           flex-column
                        ">


                        <!-- ICON -->

                        <div
                           class="
                              icon
                              btn
                              btn-circle
                              btn-lg
                              btn-white
                              text-primary
                              mb-5
                           ">

                           <i class="uil uil-lock-access fs-24"></i>

                        </div>


                        <span
                           class="
                              text-white
                              opacity-75
                              text-uppercase
                              fs-13
                              fw-bold
                              mb-2
                           ">

                           PORTAL PMB

                        </span>


                        <h2 class="text-white mb-4">

                           Lupa Password?

                        </h2>


                        <p class="text-white opacity-75 mb-6">

                           Jangan khawatir. Masukkan email yang
                           digunakan saat registrasi untuk melakukan
                           reset password akun Portal PMB.

                        </p>


                        <!-- SECURITY -->

                        <div
                           class="
                              border-top
                              border-white
                              border-opacity-25
                              pt-5
                              mt-auto
                           ">


                           <div class="d-flex mb-5">

                              <div
                                 class="
                                    icon
                                    btn
                                    btn-circle
                                    btn-sm
                                    btn-white
                                    text-primary
                                    me-3
                                    flex-shrink-0
                                 ">

                                 <i class="uil uil-envelope"></i>

                              </div>


                              <div>

                                 <h5 class="text-white mb-1">

                                    Email Terdaftar

                                 </h5>

                                 <p
                                    class="
                                       text-white
                                       opacity-75
                                       mb-0
                                    ">

                                    Gunakan email yang digunakan
                                    saat melakukan pendaftaran PMB.

                                 </p>

                              </div>

                           </div>


                           <div class="d-flex">

                              <div
                                 class="
                                    icon
                                    btn
                                    btn-circle
                                    btn-sm
                                    btn-white
                                    text-primary
                                    me-3
                                    flex-shrink-0
                                 ">

                                 <i class="uil uil-key-skeleton"></i>

                              </div>


                              <div>

                                 <h5 class="text-white mb-1">

                                    Password Baru

                                 </h5>

                                 <p
                                    class="
                                       text-white
                                       opacity-75
                                       mb-0
                                    ">

                                    Sistem akan membuat password
                                    baru berupa 6 digit angka.

                                 </p>

                              </div>

                           </div>


                        </div>

                     </div>

                  </div>

               </div>


               <!-- =================================================
                    RIGHT
               ================================================== -->

               <div class="col-12 col-lg-7">


                  <div
                     class="
                        card
                        shadow-lg
                        border-0
                        pmb-forgot-card
                     ">

                     <div class="card-body">


                        <!-- HEADER -->

                        <div class="text-center mb-7">

                           <div
                              class="
                                 icon
                                 btn
                                 btn-circle
                                 btn-lg
                                 btn-soft-primary
                                 mb-4
                              ">

                              <i class="uil uil-key-skeleton fs-24"></i>

                           </div>


                           <span
                              class="
                                 text-uppercase
                                 text-muted
                                 fs-13
                                 fw-bold
                                 d-block
                                 mb-2
                              ">

                              Pemulihan Akun

                           </span>


                           <h3 class="mb-2">

                              Reset Password

                           </h3>


                           <p class="text-muted mb-0">

                              Masukkan email pendaftaran Anda
                              untuk mendapatkan password baru.

                           </p>

                        </div>


                        <!-- =================================================
                             FORM
                        ================================================== -->

                        <form
                           action="controllers/reset-password-pmb"
                           method="POST"
                           id="formForgotPassword"
                           novalidate>


                           <div class="form-floating mb-4">

                              <input
                                 type="email"
                                 name="email"
                                 id="email"
                                 class="form-control pmb-forgot-input"
                                 placeholder="Email"
                                 autocomplete="email"
                                 required>

                              <label for="email">

                                 Email Pendaftaran

                              </label>

                           </div>


                           <div
                              class="
                                 alert
                                 alert-primary
                                 alert-icon
                                 fs-14
                                 mb-5
                              ">

                              <i class="uil uil-shield-check"></i>

                              <p class="mb-0">

                                 Password baru akan dibuat secara
                                 otomatis oleh sistem menggunakan
                                 6 digit angka acak.

                              </p>

                           </div>


                           <button
                              type="submit"
                              id="btnResetPassword"
                              class="
                                 btn
                                 btn-primary
                                 rounded
                                 w-100
                                 btn-icon
                                 btn-icon-end
                                 pmb-forgot-button
                              ">

                              Reset Password

                              <i class="uil uil-arrow-right"></i>

                           </button>


                        </form>


                        <!-- =================================================
                             RESULT
                        ================================================== -->

                        <div
                           id="resetResult"
                           class="pmb-reset-result mt-6">


                           <div
                              class="
                                 alert
                                 alert-success
                                 alert-icon
                                 mb-5
                              ">

                              <i class="uil uil-check-circle"></i>

                              <div>

                                 <strong>

                                    Password berhasil direset.

                                 </strong>

                                 <p class="mb-0 mt-1 fs-14">

                                    Gunakan password baru berikut
                                    untuk login ke Portal PMB.

                                 </p>

                              </div>

                           </div>


                           <div class="mb-4">

                              <div
                                 class="
                                    text-uppercase
                                    text-muted
                                    fs-13
                                    fw-bold
                                    text-center
                                    mb-2
                                 ">

                                 Password Baru

                              </div>


                              <div
                                 id="newPassword"
                                 class="pmb-reset-code">

                                 ------

                              </div>

                           </div>


                           <div
                              class="
                                 alert
                                 alert-warning
                                 alert-icon
                                 fs-14
                                 mb-5
                              ">

                              <i class="uil uil-exclamation-triangle"></i>

                              <p class="mb-0">

                                 Segera login menggunakan password ini
                                 dan jangan membagikannya kepada orang lain.

                              </p>

                           </div>


                           <a
                              href="pmb/login-pmb"
                              class="
                                 btn
                                 btn-primary
                                 rounded
                                 w-100
                                 btn-icon
                                 btn-icon-end
                              ">

                              Login ke Portal PMB

                              <i class="uil uil-arrow-right"></i>

                           </a>


                        </div>


                        <!-- BACK -->

                        <div
                           id="forgotBack"
                           class="
                              text-center
                              mt-5
                           ">

                           <a
                              href="pmb/login-pmb"
                              class="text-muted fs-14">

                              <i class="uil uil-arrow-left me-1"></i>

                              Kembali ke Login

                           </a>

                        </div>


                     </div>

                  </div>


                  <!-- SECURITY -->

                  <div class="text-center mt-5">

                     <p class="text-muted fs-13 mb-0">

                        <i class="uil uil-shield-check me-1"></i>

                        Jangan membagikan password kepada orang lain.

                     </p>

                  </div>


               </div>


            </div>

         </div>

      </section>


   </div>


   <?php
   require '../footer2.php';
   ?>


   <div class="progress-wrap">

      <svg
         class="progress-circle svg-content"
         width="100%"
         height="100%"
         viewBox="-1 -1 102 102">

         <path
            d="M50,1 a49,49 0,0,1 0,98 a49,49 0,0,1 0,-98" />

      </svg>

   </div>


   <script src="./assets/js/plugins.js"></script>

   <script src="./assets/js/theme.js"></script>


   <script>
      document.addEventListener(
         'DOMContentLoaded',
         function() {


            const form =
               document.getElementById(
                  'formForgotPassword'
               );


            const button =
               document.getElementById(
                  'btnResetPassword'
               );


            const result =
               document.getElementById(
                  'resetResult'
               );


            const newPassword =
               document.getElementById(
                  'newPassword'
               );


            const back =
               document.getElementById(
                  'forgotBack'
               );


            if (!form || !button) {

               return;

            }


            form.addEventListener(
               'submit',
               async function(e) {

                  e.preventDefault();


                  const email =
                     document
                     .getElementById('email')
                     .value
                     .trim();


                  if (!email) {

                     showToast(
                        'warning',
                        'Email pendaftaran wajib diisi.'
                     );

                     return;

                  }


                  const originalHTML =
                     button.innerHTML;


                  button.disabled = true;


                  button.innerHTML = `

                     <span
                        class="
                           spinner-border
                           spinner-border-sm
                           me-2
                        "
                        role="status">
                     </span>

                     Memproses...

                  `;


                  try {


                     const formData =
                        new FormData(form);


                     const response =
                        await fetch(
                           form.action, {
                              method: 'POST',
                              body: formData,
                              headers: {
                                 'X-Requested-With': 'XMLHttpRequest'
                              }
                           }
                        );


                     const text =
                        await response.text();


                     let data;


                     try {

                        data =
                           JSON.parse(text);

                     } catch (error) {

                        console.error(
                           'JSON ERROR:',
                           text
                        );

                        throw new Error(
                           'Controller tidak mengembalikan JSON.'
                        );

                     }


                     if (!data.success) {

                        showToast(
                           'danger',
                           data.message ||
                           'Gagal melakukan reset password.'
                        );

                        return;

                     }


                     showToast(
                        'success',
                        data.message ||
                        'Password berhasil direset.'
                     );


                     if (
                        data.data &&
                        data.data.password
                     ) {

                        newPassword.textContent =
                           data.data.password;

                     }


                     form.style.display =
                        'none';


                     result.style.display =
                        'block';


                     back.style.display =
                        'none';


                  } catch (error) {

                     console.error(
                        'RESET PASSWORD ERROR:',
                        error
                     );


                     showToast(
                        'danger',
                        error.message ||
                        'Terjadi kesalahan sistem.'
                     );


                  } finally {

                     button.disabled =
                        false;

                     button.innerHTML =
                        originalHTML;

                  }

               }
            );


            function showToast(
               type,
               message
            ) {


               let container =
                  document.getElementById(
                     'pmbToastContainer'
                  );


               if (!container) {

                  container =
                     document.createElement(
                        'div'
                     );

                  container.id =
                     'pmbToastContainer';

                  container.style.position =
                     'fixed';

                  container.style.top =
                     '25px';

                  container.style.right =
                     '25px';

                  container.style.zIndex =
                     '999999';

                  container.style.maxWidth =
                     '380px';

                  document.body.appendChild(
                     container
                  );

               }


               const toast =
                  document.createElement(
                     'div'
                  );


               let icon =
                  'uil-info-circle';

               let alertClass =
                  'alert-info';


               if (type === 'success') {

                  icon =
                     'uil-check-circle';

                  alertClass =
                     'alert-success';

               }


               if (type === 'danger') {

                  icon =
                     'uil-times-circle';

                  alertClass =
                     'alert-danger';

               }


               if (type === 'warning') {

                  icon =
                     'uil-exclamation-triangle';

                  alertClass =
                     'alert-warning';

               }


               toast.className =
                  `alert ${alertClass} shadow-lg border-0`;


               toast.innerHTML = `

                  <div class="d-flex align-items-start">

                     <i
                        class="
                           uil
                           ${icon}
                           fs-20
                           me-2
                        ">
                     </i>

                     <div>

                        ${escapeHtml(message)}

                     </div>

                  </div>

               `;


               container.appendChild(
                  toast
               );


               setTimeout(
                  function() {

                     toast.style.opacity =
                        '0';

                     toast.style.transition =
                        'opacity .3s';


                     setTimeout(
                        function() {

                           toast.remove();

                        },
                        300
                     );

                  },
                  3500
               );

            }


            function escapeHtml(text) {

               const div =
                  document.createElement(
                     'div'
                  );

               div.textContent =
                  text;

               return div.innerHTML;

            }

         }
      );
   </script>

</body>

</html>