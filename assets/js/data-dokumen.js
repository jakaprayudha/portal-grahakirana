document.addEventListener("DOMContentLoaded", function () {
  console.log("=================================");
  console.log("PMB DATA & DOKUMEN JS LOADED");
  console.log("=================================");

  const form = document.getElementById("formDataDokumen");

  const button = document.getElementById("btnSimpanData");

  console.log("FORM:", form);
  console.log("BUTTON:", button);

  /**
   * =========================================================
   * CHECK ELEMENT
   * =========================================================
   */

  if (!form) {
    console.error("ERROR: #formDataDokumen tidak ditemukan.");

    return;
  }

  if (!button) {
    console.error("ERROR: #btnSimpanData tidak ditemukan.");

    return;
  }

  console.log("Form dan button berhasil ditemukan.");

  /**
   * =========================================================
   * SUBMIT
   * =========================================================
   */

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    console.log("SUBMIT FORM DATA & DOKUMEN");

    /**
     * =================================================
     * VALIDATION
     * =================================================
     */

    if (!form.checkValidity()) {
      console.warn("FORM TIDAK VALID");

      form.classList.add("was-validated");

      form.reportValidity();

      showPMBToast("danger", "Silakan lengkapi data yang wajib diisi.");

      return;
    }

    /**
     * =================================================
     * LOADING
     * =================================================
     */

    const originalHTML = button.innerHTML;

    button.disabled = true;

    button.innerHTML = `
                <span
                    class="spinner-border spinner-border-sm me-2"
                    role="status"
                    aria-hidden="true">
                </span>

                Menyimpan...
            `;

    /**
     * =================================================
     * FORM DATA
     * =================================================
     */

    const formData = new FormData(form);

    console.log("FORM DATA SIAP DIKIRIM");

    /**
     * Debug isi FormData
     */

    for (const [key, value] of formData.entries()) {
      if (value instanceof File) {
        console.log(key, value.name, value.size);
      } else {
        console.log(key, value);
      }
    }

    /**
     * =================================================
     * CONTROLLER
     * =================================================
     */

    console.log("POST:", form.action);

    try {
      const response = await fetch(form.action, {
        method: form.method || "POST",

        body: formData,

        headers: {
          Accept: "application/json",
        },
      });

      console.log("HTTP STATUS:", response.status);

      /**
       * =================================================
       * RESPONSE TEXT
       * =================================================
       */

      const text = await response.text();

      console.log("CONTROLLER RESPONSE:", text);

      let result;

      try {
        result = JSON.parse(text);
      } catch (jsonError) {
        console.error("JSON ERROR:", jsonError);

        throw new Error("Response controller bukan JSON.");
      }

      console.log("PARSED RESULT:", result);

      /**
       * =================================================
       * SESSION EXPIRED
       * =================================================
       */

      if (response.status === 401) {
        showPMBToast("info", result.message || "Sesi login telah berakhir.");

        setTimeout(function () {
          window.location.href = "login-pmb";
        }, 1500);

        return;
      }

      /**
       * =================================================
       * ERROR
       * =================================================
       */

      if (!response.ok || !result.success) {
        console.error("SAVE ERROR:", result);

        showPMBToast("danger", result.message || "Gagal menyimpan data.");

        /**
         * Focus field
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
       * =================================================
       * SUCCESS
       * =================================================
       */

      console.log("SAVE SUCCESS:", result);

      showPMBToast("success", result.message || "Data berhasil disimpan.");

      /**
       * =================================================
       * REDIRECT NEXT STAGE
       * =================================================
       */

      if (result.data && result.data.complete && result.data.redirect) {
        console.log("REDIRECT:", result.data.redirect);

        setTimeout(function () {
          window.location.href = result.data.redirect;
        }, 1500);
      } else {
        /**
         * Refresh halaman
         */

        setTimeout(function () {
          window.location.reload();
        }, 1200);
      }
    } catch (error) {
      console.error("PMB ERROR:", error);

      showPMBToast("danger", error.message || "Terjadi kesalahan sistem.");
    } finally {
      button.disabled = false;

      button.innerHTML = originalHTML;
    }
  });

  /**
   * =========================================================
   * TOAST
   * =========================================================
   */

  function showPMBToast(type, message) {
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

    const icon =
      type === "success"
        ? "uil-check-circle"
        : type === "danger"
          ? "uil-times-circle"
          : "uil-info-circle";

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
