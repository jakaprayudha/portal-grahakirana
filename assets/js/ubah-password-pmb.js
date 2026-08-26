document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formUbahPassword");

  const button = document.getElementById("btnUbahPassword");

  if (!form || !button) {
    return;
  }

  /**
   * =====================================================
   * SHOW / HIDE PASSWORD
   * =====================================================
   */

  function setupToggle(inputId, buttonId) {
    const input = document.getElementById(inputId);

    const toggle = document.getElementById(buttonId);

    if (!input || !toggle) {
      return;
    }

    toggle.addEventListener("click", function () {
      const icon = this.querySelector("i");

      if (input.type === "password") {
        input.type = "text";

        icon.classList.remove("uil-eye");

        icon.classList.add("uil-eye-slash");

        this.setAttribute("aria-label", "Sembunyikan password");
      } else {
        input.type = "password";

        icon.classList.remove("uil-eye-slash");

        icon.classList.add("uil-eye");

        this.setAttribute("aria-label", "Tampilkan password");
      }
    });
  }

  setupToggle("passwordLama", "togglePasswordLama");

  setupToggle("passwordBaru", "togglePasswordBaru");

  setupToggle("passwordKonfirmasi", "togglePasswordKonfirmasi");

  /**
   * =====================================================
   * SUBMIT
   * =====================================================
   */

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const passwordLama = document.getElementById("passwordLama").value;

    const passwordBaru = document.getElementById("passwordBaru").value;

    const passwordKonfirmasi =
      document.getElementById("passwordKonfirmasi").value;

    /**
     * ==============================================
     * VALIDATION
     * ==============================================
     */

    if (!passwordLama) {
      showToast("warning", "Password lama wajib diisi.");

      document.getElementById("passwordLama").focus();

      return;
    }

    if (!passwordBaru) {
      showToast("warning", "Password baru wajib diisi.");

      document.getElementById("passwordBaru").focus();

      return;
    }

    if (passwordBaru.length < 6) {
      showToast("warning", "Password baru minimal 6 karakter.");

      document.getElementById("passwordBaru").focus();

      return;
    }

    if (passwordBaru !== passwordKonfirmasi) {
      showToast("warning", "Konfirmasi password tidak sesuai.");

      document.getElementById("passwordKonfirmasi").focus();

      return;
    }

    if (passwordLama === passwordBaru) {
      showToast("warning", "Password baru harus berbeda dengan password lama.");

      return;
    }

    /**
     * ==============================================
     * CONFIRM
     * ==============================================
     */

    const confirmed = window.confirm(
      "Apakah Anda yakin ingin mengubah password?",
    );

    if (!confirmed) {
      return;
    }

    /**
     * ==============================================
     * LOADING
     * ==============================================
     */

    const originalHTML = button.innerHTML;

    button.disabled = true;

    button.innerHTML = `

               <span
                  class="
                     spinner-border
                     spinner-border-sm
                     me-2
                  "
                  role="status"
                  aria-hidden="true">
               </span>

               Menyimpan...

            `;

    try {
      const formData = new FormData(form);

      /**
       * =========================================
       * REQUEST
       * =========================================
       */

      const response = await fetch(form.action, {
        method: "POST",
        body: formData,
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
      });

      const text = await response.text();

      console.log("CHANGE PASSWORD RESPONSE:", text);

      let result;

      try {
        result = JSON.parse(text);
      } catch (error) {
        console.error("JSON ERROR:", error);

        throw new Error("Controller tidak mengembalikan JSON.");
      }

      /**
       * =========================================
       * SESSION EXPIRED
       * =========================================
       */

      if (response.status === 401) {
        showToast("warning", result.message || "Sesi login telah berakhir.");

        setTimeout(function () {
          window.location.href = "./login-pmb";
        }, 1500);

        return;
      }

      /**
       * =========================================
       * ERROR
       * =========================================
       */

      if (!result.success) {
        showToast("danger", result.message || "Gagal mengubah password.");

        return;
      }

      /**
       * =========================================
       * SUCCESS
       * =========================================
       */

      showToast("success", result.message || "Password berhasil diubah.");

      /**
       * =========================================
       * RESET FORM
       * =========================================
       */

      form.reset();

      /**
       * =========================================
       * TUTUP MODAL
       * =========================================
       */

      const modalElement = document.getElementById("modalUbahPassword");

      if (modalElement) {
        const modal = bootstrap.Modal.getInstance(modalElement);

        if (modal) {
          modal.hide();
        }
      }
    } catch (error) {
      console.error("UBAH PASSWORD ERROR:", error);

      showToast("danger", error.message || "Terjadi kesalahan sistem.");
    } finally {
      button.disabled = false;

      button.innerHTML = originalHTML;
    }
  });

  /**
   * =====================================================
   * TOAST
   * =====================================================
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

      container.style.maxWidth = "380px";

      container.style.width = "calc(100% - 30px)";

      document.body.appendChild(container);
    }

    const toast = document.createElement("div");

    let icon = "uil-info-circle";

    let alertClass = "alert-info";

    if (type === "success") {
      icon = "uil-check-circle";

      alertClass = "alert-success";
    }

    if (type === "danger") {
      icon = "uil-times-circle";

      alertClass = "alert-danger";
    }

    if (type === "warning") {
      icon = "uil-exclamation-triangle";

      alertClass = "alert-warning";
    }

    toast.className = `alert ${alertClass} shadow-lg border-0`;

    toast.innerHTML = `

            <div
               class="
                  d-flex
                  align-items-start
               ">

               <i
                  class="
                     uil
                     ${icon}
                     fs-20
                     me-2
                  ">
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
   * =====================================================
   * ESCAPE HTML
   * =====================================================
   */

  function escapeHTML(text) {
    const div = document.createElement("div");

    div.textContent = text;

    return div.innerHTML;
  }
});
