document.addEventListener("DOMContentLoaded", function () {
  console.log("=================================");
  console.log("ADMIN LOGIN JS LOADED");
  console.log("=================================");

  const password = document.getElementById("password");

  const toggle = document.getElementById("togglePassword");

  const icon = document.getElementById("passwordIcon");

  /**
   * =========================================================
   * SHOW / HIDE PASSWORD
   * =========================================================
   */

  if (toggle && password && icon) {
    toggle.addEventListener("click", function () {
      if (password.type === "password") {
        password.type = "text";

        icon.className = "uil uil-eye-slash";

        toggle.setAttribute("aria-label", "Sembunyikan password");
      } else {
        password.type = "password";

        icon.className = "uil uil-eye";

        toggle.setAttribute("aria-label", "Tampilkan password");
      }
    });
  }

  /**
   * =========================================================
   * FORM LOGIN
   * =========================================================
   */

  const form = document.getElementById("formAdminLogin");

  const button = document.getElementById("btnAdminLogin");

  const buttonText = document.getElementById("btnAdminLoginText");

  console.log("FORM:", form);

  console.log("BUTTON:", button);

  if (!form || !button) {
    console.warn("Form atau button admin login tidak ditemukan.");

    return;
  }

  /**
   * =========================================================
   * SUBMIT
   * =========================================================
   */

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    console.log("ADMIN LOGIN SUBMIT");

    /**
     * =================================================
     * VALIDATION
     * =================================================
     */

    if (!form.checkValidity()) {
      form.classList.add("was-validated");

      return;
    }

    /**
     * =================================================
     * LOADING
     * =================================================
     */

    const originalHTML = buttonText.innerHTML;

    button.disabled = true;

    buttonText.innerHTML = `

                <span
                    class="spinner-border spinner-border-sm me-2"
                    role="status"
                    aria-hidden="true">
                </span>

                Memproses...

            `;

    try {
      /**
       * =============================================
       * FORM DATA
       * =============================================
       */

      const formData = new FormData(form);

      console.log("FORM ACTION:", form.action);

      /**
       * =============================================
       * REQUEST
       * =============================================
       */

      const response = await fetch(form.action, {
        method: "POST",
        body: formData,
        credentials: "same-origin",
      });

      console.log("HTTP STATUS:", response.status);

      console.log("CONTENT TYPE:", response.headers.get("content-type"));

      /**
       * =============================================
       * RAW RESPONSE
       * =============================================
       */

      const text = await response.text();

      console.log("CONTROLLER RESPONSE:", text);

      /**
       * =============================================
       * JSON
       * =============================================
       */

      let result;

      try {
        result = JSON.parse(text);
      } catch (error) {
        console.error("JSON ERROR:", error);

        console.error("RAW RESPONSE:", text);

        throw new Error("Controller login tidak mengembalikan JSON.");
      }

      console.log("LOGIN RESULT:", result);

      /**
       * =============================================
       * ERROR
       * =============================================
       */

      if (!result.success) {
        showAdminToast(
          "danger",
          result.message || "Username atau password salah.",
        );

        return;
      }

      /**
       * =============================================
       * SUCCESS
       * =============================================
       */

      showAdminToast(
        "success",
        result.message || "Login administrator berhasil.",
      );

      /**
       * =============================================
       * REDIRECT
       * =============================================
       */

      const redirect =
        result.data && result.data.redirect
          ? result.data.redirect
          : "dashboard.php";

      console.log("REDIRECT:", redirect);

      setTimeout(function () {
        window.location.href = redirect;
      }, 800);
    } catch (error) {
      console.error("=================================");

      console.error("ADMIN LOGIN ERROR:", error);

      console.error("=================================");

      showAdminToast("danger", error.message || "Terjadi kesalahan sistem.");
    } finally {
      button.disabled = false;

      buttonText.innerHTML = originalHTML;
    }
  });

  /**
   * =========================================================
   * TOAST
   * =========================================================
   */

  function showAdminToast(type, message) {
    let container = document.getElementById("adminToastContainer");

    if (!container) {
      container = document.createElement("div");

      container.id = "adminToastContainer";

      container.style.position = "fixed";

      container.style.top = "25px";

      container.style.right = "25px";

      container.style.zIndex = "999999";

      container.style.maxWidth = "380px";

      document.body.appendChild(container);
    }

    const toast = document.createElement("div");

    let icon = "uil-info-circle";

    if (type === "success") {
      icon = "uil-check-circle";
    }

    if (type === "danger") {
      icon = "uil-times-circle";
    }

    if (type === "warning") {
      icon = "uil-exclamation-triangle";
    }

    toast.className = `alert alert-${type} shadow-sm`;

    toast.innerHTML = `

            <div class="d-flex align-items-start">

                <i
                    class="uil ${icon} fs-20 me-2">
                </i>

                <div>
                    ${escapeHTML(message)}
                </div>

            </div>

        `;

    container.appendChild(toast);

    setTimeout(function () {
      toast.style.opacity = "0";

      toast.style.transition = "opacity .3s";

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

  function escapeHTML(text) {
    const div = document.createElement("div");

    div.textContent = text;

    return div.innerHTML;
  }
});
