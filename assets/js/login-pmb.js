document.addEventListener("DOMContentLoaded", function () {
  console.log("LOGIN PMB JS LOADED");

  const form = document.getElementById("formLoginPMB");

  if (!form) {
    console.error("formLoginPMB tidak ditemukan.");

    return;
  }

  console.log("FORM LOGIN PMB DITEMUKAN");

  /**
   * =========================================================
   * SHOW PASSWORD
   * =========================================================
   */

  const showPassword = document.getElementById("showPassword");

  const password = document.getElementById("password");

  if (showPassword && password) {
    showPassword.addEventListener("change", function () {
      password.type = this.checked ? "text" : "password";
    });
  }

  /**
   * =========================================================
   * SUBMIT LOGIN
   * =========================================================
   */

  form.addEventListener("submit", async function (event) {
    event.preventDefault();
    event.stopPropagation();

    console.log("SUBMIT LOGIN DITANGKAP");

    /**
     * =================================================
     * VALIDASI
     * =================================================
     */

    if (!form.checkValidity()) {
      form.classList.add("was-validated");

      showToast("error", "Silakan masukkan email dan password.");

      return;
    }

    /**
     * =================================================
     * BUTTON
     * =================================================
     */

    const button = form.querySelector(".pmb-login-button");

    if (!button) {
      return;
    }

    const originalButton = button.innerHTML;

    button.disabled = true;

    button.innerHTML = `
                <span
                    class="spinner-border spinner-border-sm me-2"
                    role="status"
                    aria-hidden="true">
                </span>

                Memproses...
            `;

    /**
     * =================================================
     * FORM DATA
     * =================================================
     */

    const formData = new FormData(form);

    /**
     * =================================================
     * CONTROLLER
     * =================================================
     */

    const controllerUrl = "controllers/login-pmb.php";

    console.log("POST LOGIN:", controllerUrl);

    try {
      const response = await fetch(controllerUrl, {
        method: "POST",

        body: formData,

        headers: {
          Accept: "application/json",
        },
      });

      console.log("HTTP STATUS:", response.status);

      const result = await response.json();

      console.log("LOGIN RESPONSE:", result);

      /**
       * =============================================
       * LOGIN ERROR
       * =============================================
       */

      if (!response.ok || !result.success) {
        showToast("error", result.message || "Login gagal.");

        /**
         * Focus field error
         */

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

      /**
       * =============================================
       * LOGIN SUCCESS
       * =============================================
       */

      showToast("success", result.message || "Login berhasil.");

      /**
       * =============================================
       * REDIRECT
       * =============================================
       */

      const redirectUrl =
        result.data && result.data.redirect
          ? result.data.redirect
          : "pmb/welcome";

      setTimeout(function () {
        window.location.href = redirectUrl;
      }, 1200);
    } catch (error) {
      console.error("LOGIN ERROR:", error);

      showToast("error", "Tidak dapat terhubung ke server.");
    } finally {
      button.disabled = false;

      button.innerHTML = originalButton;
    }
  });

  /**
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

      container.style.width = "380px";

      container.style.maxWidth = "calc(100vw - 30px)";

      document.body.appendChild(container);
    }

    const toast = document.createElement("div");

    const success = type === "success";

    toast.style.background = success ? "#2b9a59" : "#d63939";

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

    const icon = success ? "uil-check-circle" : "uil-times-circle";

    toast.innerHTML = `

            <div class="d-flex align-items-center">

                <i
                    class="uil ${icon} fs-20 me-2">
                </i>

                <span>
                    ${escapeHtml(message)}
                </span>

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

  /**
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
