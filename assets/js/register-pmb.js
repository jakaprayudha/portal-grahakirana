document.addEventListener("DOMContentLoaded", function () {
  console.log("Register PMB JS loaded");

  const form = document.getElementById("formRegistrasiPMB");

  if (!form) {
    console.error("Form #formRegistrasiPMB tidak ditemukan.");
    return;
  }

  console.log("Form registrasi ditemukan");

  /*
   * =========================================================
   * SUBMIT FORM
   * =========================================================
   */

  form.addEventListener("submit", async function (event) {
    /*
     * WAJIB
     * Mencegah browser menuju action secara langsung.
     */

    event.preventDefault();
    event.stopPropagation();

    console.log("Submit registrasi PMB dijalankan");

    /*
     * =====================================================
     * VALIDASI HTML
     * =====================================================
     */

    if (!form.checkValidity()) {
      form.classList.add("was-validated");

      showToast("error", "Silakan lengkapi seluruh data pendaftaran.");

      return;
    }

    /*
     * =====================================================
     * PASSWORD
     * =====================================================
     */

    const password = document.getElementById("password");

    const passwordConfirmation = document.getElementById(
      "password_confirmation",
    );

    if (password.value !== passwordConfirmation.value) {
      showToast("error", "Konfirmasi password tidak sama.");

      passwordConfirmation.focus();

      return;
    }

    /*
     * =====================================================
     * TOMBOL
     * =====================================================
     */

    const submitButton = form.querySelector(".pmb-submit");

    const originalButton = submitButton.innerHTML;

    submitButton.disabled = true;

    submitButton.innerHTML = `
            <span
                class="spinner-border spinner-border-sm me-2"
                role="status"
                aria-hidden="true">
            </span>

            Memproses...
        `;

    /*
     * =====================================================
     * FORM DATA
     * =====================================================
     */

    const formData = new FormData(form);

    /*
     * Debug data
     */

    console.log("Data registrasi:", Object.fromEntries(formData.entries()));

    /*
     * =====================================================
     * CONTROLLER
     * =====================================================
     */

    const controllerUrl = "controllers/register-pmb.php";

    try {
      const response = await fetch(controllerUrl, {
        method: "POST",
        body: formData,
        headers: {
          Accept: "application/json",
        },
      });

      console.log("HTTP Status:", response.status);

      /*
       * =================================================
       * AMBIL RESPONSE
       * =================================================
       */

      const text = await response.text();

      console.log("Response controller:", text);

      let result;

      try {
        result = JSON.parse(text);
      } catch (jsonError) {
        console.error("Response bukan JSON:", text);

        showToast(
          "error",
          "Controller tidak mengembalikan response JSON yang valid.",
        );

        return;
      }

      /*
       * =================================================
       * RESPONSE ERROR
       * =================================================
       */
      if (!response.ok || !result.success) {
        showToast("error", result.message || "Registrasi gagal.");

        // Focus field yang bermasalah
        if (result.data && result.data.field) {
          const field = document.getElementById(result.data.field);

          if (field) {
            field.classList.add("is-invalid");
            field.focus();

            setTimeout(function () {
              field.classList.remove("is-invalid");
            }, 3000);
          }
        }

        return;
      }
      /*
       * =================================================
       * SUCCESS
       * =================================================
       */

      showToast("success", result.message || "Registrasi berhasil.");

      /*
       * =================================================
       * REDIRECT
       * =================================================
       */

      const redirectUrl =
        result.data && result.data.redirect
          ? result.data.redirect
          : "./pmb/login-pmb";

      console.log("Redirect ke:", redirectUrl);

      setTimeout(function () {
        window.location.href = redirectUrl;
      }, 1800);
    } catch (error) {
      console.error("Register PMB Error:", error);

      showToast("error", "Tidak dapat terhubung ke controller registrasi.");
    } finally {
      submitButton.disabled = false;

      submitButton.innerHTML = originalButton;
    }
  });

  /*
   * =========================================================
   * TOAST
   * =========================================================
   */

  function showToast(type, message) {
    let container = document.getElementById("pmbToastContainer");

    if (!container) {
      container = document.createElement("div");

      container.id = "pmbToastContainer";

      container.style.position = "fixed";

      container.style.top = "25px";

      container.style.right = "25px";

      container.style.zIndex = "999999";

      container.style.width = "min(380px, calc(100vw - 30px))";

      document.body.appendChild(container);
    }

    const toast = document.createElement("div");

    const isSuccess = type === "success";

    toast.style.background = isSuccess ? "#2b9a59" : "#d63939";

    toast.style.color = "#ffffff";

    toast.style.padding = "15px 18px";

    toast.style.borderRadius = "10px";

    toast.style.marginBottom = "10px";

    toast.style.boxShadow = "0 10px 30px rgba(0,0,0,.15)";

    toast.style.fontSize = "14px";

    toast.style.fontWeight = "500";

    toast.style.opacity = "0";

    toast.style.transform = "translateY(-10px)";

    toast.style.transition = "all .25s ease";

    const icon = isSuccess ? "uil-check-circle" : "uil-times-circle";

    toast.innerHTML = `

            <div class="d-flex align-items-start">

                <i
                    class="uil ${icon} fs-20 me-2">
                </i>

                <div>
                    ${escapeHtml(message)}
                </div>

            </div>

        `;

    container.appendChild(toast);

    requestAnimationFrame(function () {
      toast.style.opacity = "1";

      toast.style.transform = "translateY(0)";
    });

    setTimeout(function () {
      toast.style.opacity = "0";

      toast.style.transform = "translateY(-10px)";

      setTimeout(function () {
        toast.remove();
      }, 300);
    }, 3500);
  }

  /*
   * =========================================================
   * ESCAPE HTML
   * =========================================================
   */

  function escapeHtml(value) {
    const div = document.createElement("div");

    div.textContent = value;

    return div.innerHTML;
  }
});
