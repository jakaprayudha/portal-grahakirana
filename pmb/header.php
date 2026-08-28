   <!-- =====================================================
                              WELCOME
                           ====================================================== -->

   <div class="card bg-primary text-white shadow-lg pmb-welcome-card mb-6">

      <div class="card-body p-5 p-md-6">

         <div class="pmb-welcome-content">

            <div class="row align-items-center">


               <!-- =============================================
                                                                  PESERTA
                                                               ============================================== -->

               <div class="col-lg">

                  <div class="d-flex align-items-center">


                     <!-- AVATAR -->

                     <div class="pmb-avatar me-4">

                        <i class="uil uil-user fs-30"></i>

                     </div>


                     <!-- INFO -->

                     <div>

                        <span
                           class="
                                                                              text-white
                                                                              opacity-75
                                                                              text-uppercase
                                                                              fs-13
                                                                              fw-bold
                                                                           ">

                           Peserta PMB

                        </span>


                        <h3
                           class="
                                                                              text-white
                                                                              mt-1
                                                                              mb-2
                                                                           ">

                           <?= htmlspecialchars(
                              $pmbUser['fullname'] ?? '-',
                              ENT_QUOTES,
                              'UTF-8'
                           ) ?>

                        </h3>


                        <div class="pmb-meta">


                           <!-- UID -->

                           <span
                              class="
                                                                                 pmb-meta-item
                                                                                 text-white
                                                                                 opacity-75
                                                                              ">

                              <i
                                 class="
                                                                                    uil
                                                                                    uil-card-atm
                                                                                    me-1
                                                                                 ">
                              </i>

                              UID:

                              <strong class="text-white">

                                 <?= htmlspecialchars(
                                    $pmbUser['register_uid'] ?? '-',
                                    ENT_QUOTES,
                                    'UTF-8'
                                 ) ?>

                              </strong>

                           </span>


                           <!-- EMAIL -->

                           <span
                              class="
                                                                                 pmb-meta-item
                                                                                 text-white
                                                                                 opacity-75
                                                                              ">

                              <i
                                 class="
                                                                                    uil
                                                                                    uil-envelope
                                                                                    me-1
                                                                                 ">
                              </i>

                              <?= htmlspecialchars(
                                 $pmbUser['email_register'] ?? '-',
                                 ENT_QUOTES,
                                 'UTF-8'
                              ) ?>

                           </span>


                           <!-- JALUR -->

                           <span
                              class="
                                                                                 pmb-meta-item
                                                                                 text-white
                                                                                 opacity-75
                                                                              ">

                              <i
                                 class="
                                                                                    uil
                                                                                    uil-sign-alt
                                                                                    me-1
                                                                                 ">
                              </i>

                              <?= htmlspecialchars(
                                 $pmbUser['register_type'] ?? '-',
                                 ENT_QUOTES,
                                 'UTF-8'
                              ) ?>

                           </span>


                        </div>

                     </div>

                  </div>

               </div>



               <!-- =============================================
                                 STATUS + ACTION
                              ============================================== -->

               <div
                  class="
                                    col-lg-auto
                                    mt-4
                                    mt-lg-0
                                 ">

                  <div
                     class="
                                       d-flex
                                       align-items-center
                                       justify-content-lg-end
                                       gap-2
                                       flex-wrap
                                    ">


                     <div class="col-lg-auto mt-4 mt-lg-0">

                        <?php

                        $statusPendaftaran =
                           $pmbUser['status_pendaftaran'] ?? 'REGISTRASI';

                        $accountStatus =
                           $pmbUser['account_status'] ?? 'PENDING';

                        ?>

                        <?php if ($accountStatus === 'ACTIVE'): ?>

                           <span
                              class="badge bg-soft-green text-green pmb-status-badge">

                              <i class="uil uil-check-circle me-1"></i>

                              Peserta Aktif

                           </span>

                        <?php elseif ($accountStatus === 'BLOCKED'): ?>

                           <span
                              class="badge bg-soft-red text-red pmb-status-badge">

                              <i class="uil uil-times-circle me-1"></i>

                              Akun Diblokir

                           </span>

                        <?php else: ?>

                           <span
                              class="badge bg-soft-yellow text-yellow pmb-status-badge">

                              <i class="uil uil-clock me-1"></i>

                              Menunggu Aktivasi

                           </span>

                        <?php endif; ?>

                     </div>


                     <!-- ======================================
                                          UBAH PASSWORD
                                       ======================================= -->

                     <button
                        type="button"
                        class="
                                             btn
                                             btn-sm
                                             btn-outline-light
                                             rounded-pill
                                             px-4
                                             pmb-password-btn
                                          "
                        data-bs-toggle="modal"
                        data-bs-target="#modalUbahPassword">

                        <i
                           class="
                                                uil
                                                uil-lock-access
                                                me-1
                                             ">
                        </i>

                        Ubah Password

                     </button>


                     <!-- ======================================
                                       LOGOUT
                                    ======================================= -->

                     <a
                        href="./controllers/logout-pmb"
                        class="
                                             btn
                                             btn-sm
                                             btn-outline-light
                                             rounded-pill
                                             px-4
                                             pmb-logout-btn
                                          "
                        onclick="
                                             return confirm(
                                                'Apakah Anda yakin ingin keluar dari Portal PMB?'
                                             );
                                          ">

                        <i
                           class="
                                                uil
                                                uil-sign-out-alt
                                                me-1
                                             ">
                        </i>

                        Keluar

                     </a>


                  </div>

               </div>


            </div>

         </div>

      </div>

   </div>
   <!-- =====================================================
     MODAL UBAH PASSWORD
====================================================== -->

   <div
      class="modal fade"
      id="modalUbahPassword"
      tabindex="-1"
      aria-labelledby="modalUbahPasswordLabel"
      aria-hidden="true">

      <div
         class="
         modal-dialog
         modal-dialog-centered
         modal-md
      ">

         <div class="modal-content border-0 shadow-lg">


            <!-- =============================================
              HEADER
         ============================================== -->

            <div class="modal-header">

               <div>

                  <span
                     class="
                     text-uppercase
                     text-muted
                     fs-13
                     fw-bold
                  ">

                     Keamanan Akun

                  </span>

                  <h4
                     class="modal-title mt-1"
                     id="modalUbahPasswordLabel">

                     Ubah Password

                  </h4>

               </div>


               <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close">
               </button>

            </div>


            <!-- =============================================
              BODY
         ============================================== -->

            <div class="modal-body p-5">


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

                     Gunakan password yang kuat dan mudah Anda
                     ingat. Password baru akan langsung digunakan
                     untuk login Portal PMB.

                  </p>

               </div>


               <!-- =========================================
                 FORM
            ========================================== -->

               <form
                  id="formUbahPassword"
                  action="./controllers/ubah-password-pmb"
                  method="POST"
                  novalidate>


                  <!-- ======================================
                    PASSWORD LAMA
               ======================================= -->

                  <div
                     class="
                     form-floating
                     mb-4
                     position-relative
                  ">

                     <input
                        type="password"
                        name="password_lama"
                        id="passwordLama"
                        class="form-control pe-5"
                        placeholder="Password Lama"
                        autocomplete="current-password"
                        required>

                     <label for="passwordLama">

                        Password Lama

                     </label>


                     <button
                        type="button"
                        class="
                        btn
                        btn-link
                        position-absolute
                        end-0
                        top-50
                        translate-middle-y
                        text-muted
                        p-0
                        me-3
                     "
                        id="togglePasswordLama"
                        tabindex="-1"
                        aria-label="Tampilkan password lama">

                        <i class="uil uil-eye"></i>

                     </button>

                  </div>


                  <!-- ======================================
                    PASSWORD BARU
               ======================================= -->

                  <div
                     class="
                     form-floating
                     mb-4
                     position-relative
                  ">

                     <input
                        type="password"
                        name="password_baru"
                        id="passwordBaru"
                        class="form-control pe-5"
                        placeholder="Password Baru"
                        autocomplete="new-password"
                        minlength="6"
                        required>

                     <label for="passwordBaru">

                        Password Baru

                     </label>


                     <button
                        type="button"
                        class="
                        btn
                        btn-link
                        position-absolute
                        end-0
                        top-50
                        translate-middle-y
                        text-muted
                        p-0
                        me-3
                     "
                        id="togglePasswordBaru"
                        tabindex="-1"
                        aria-label="Tampilkan password baru">

                        <i class="uil uil-eye"></i>

                     </button>

                  </div>


                  <!-- ======================================
                    KONFIRMASI PASSWORD
               ======================================= -->

                  <div
                     class="
                     form-floating
                     mb-5
                     position-relative
                  ">

                     <input
                        type="password"
                        name="password_konfirmasi"
                        id="passwordKonfirmasi"
                        class="form-control pe-5"
                        placeholder="Konfirmasi Password"
                        autocomplete="new-password"
                        minlength="6"
                        required>

                     <label for="passwordKonfirmasi">

                        Konfirmasi Password Baru

                     </label>


                     <button
                        type="button"
                        class="
                        btn
                        btn-link
                        position-absolute
                        end-0
                        top-50
                        translate-middle-y
                        text-muted
                        p-0
                        me-3
                     "
                        id="togglePasswordKonfirmasi"
                        tabindex="-1"
                        aria-label="Tampilkan konfirmasi password">

                        <i class="uil uil-eye"></i>

                     </button>

                  </div>


                  <!-- ======================================
                    BUTTON
               ======================================= -->

                  <button
                     type="submit"
                     id="btnUbahPassword"
                     class="
                     btn
                     btn-primary
                     rounded
                     w-100
                     btn-icon
                     btn-icon-end
                  ">

                     Simpan Password

                     <i class="uil uil-check"></i>

                  </button>


               </form>

            </div>

         </div>

      </div>

   </div>