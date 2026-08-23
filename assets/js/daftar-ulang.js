document.addEventListener("DOMContentLoaded", function () {
  console.log("=================================");
  console.log("PMB DAFTAR ULANG JS LOADED");
  console.log("=================================");

  const button = document.getElementById("btnAjukanDaftarUlang");

  const agreement = document.getElementById("agreement");

  const agreement2 = document.getElementById("agreement2");

  console.log("BUTTON:", button);
  console.log("AGREEMENT:", agreement);
  console.log("AGREEMENT2:", agreement2);

  /**
   * =========================================================
   * BUTTON TIDAK DITEMUKAN
   * =========================================================
   */

  if (!button) {
    console.warn("Tombol #btnAjukanDaftarUlang tidak ditemukan.");

    return;
  }

  /**
   * =========================================================
   * CLICK
   * =========================================================
   */

  button.addEventListener("click", async function (e) {
    e.preventDefault();

    console.log("=================================");

    console.log("KLIK AJUKAN DAFTAR ULANG");

    console.log("=================================");

    /**
     * =====================================================
     * CHECK AGREEMENT
     * =====================================================
     */

    if (agreement && !agreement.checked) {
      showPMBToast("warning", "Silakan menyetujui pernyataan pertama.");

      agreement.focus();

      return;
    }

    if (agreement2 && !agreement2.checked) {
      showPMBToast("warning", "Silakan menyetujui pernyataan kedua.");

      agreement2.focus();

      return;
    }

    /**
     * =====================================================
     * CONFIRM
     * =====================================================
     */

    const confirmed = window.confirm(
      "Apakah Anda yakin ingin mengajukan daftar ulang?",
    );

    if (!confirmed) {
      console.log("Pengajuan dibatalkan user.");

      return;
    }

    /**
     * =====================================================
     * LOADING
     * =====================================================
     */

    const originalHTML = button.innerHTML;

    button.disabled = true;

    button.innerHTML = `
            <span
                class="spinner-border spinner-border-sm me-2"
                role="status"
                aria-hidden="true">
            </span>

            Mengajukan...
        `;

    /**
     * =====================================================
     * REQUEST
     * =====================================================
     */

    try {
      console.log("POST controller...");

      const response = await fetch("./controllers/ajukan-daftar-ulang.php", {
        method: "POST",

        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },

        body: new URLSearchParams({
          action: "ajukan",
        }),
      });

      console.log("HTTP STATUS:", response.status);

      const text = await response.text();

      console.log("CONTROLLER RESPONSE:", text);

      /**
       * =================================================
       * PARSE JSON
       * =================================================
       */

      let result;

      try {
        result = JSON.parse(text);
      } catch (error) {
        console.error("JSON ERROR:", error);

        throw new Error(
          "Response controller bukan JSON. Cek error PHP di Network.",
        );
      }

      console.log("RESULT:", result);

      /**
       * =================================================
       * SESSION EXPIRED
       * =================================================
       */

      if (response.status === 401) {
        showPMBToast("warning", result.message || "Sesi login telah berakhir.");

        setTimeout(function () {
          window.location.href = "./login-pmb.php";
        }, 1500);

        return;
      }

      /**
       * =================================================
       * ERROR
       * =================================================
       */

      if (!result.success) {
        showPMBToast(
          "danger",
          result.message || "Gagal mengajukan daftar ulang.",
        );

        return;
      }

      /**
       * =================================================
       * SUCCESS
       * =================================================
       */

      showPMBToast(
        "success",
        result.message || "Daftar ulang berhasil diajukan.",
      );

      /**
       * =================================================
       * RELOAD
       * =================================================
       */

      setTimeout(function () {
        window.location.reload();
      }, 1500);
    } catch (error) {
      console.error("PMB DAFTAR ULANG ERROR:", error);

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

      container.style.maxWidth = "380px";

      document.body.appendChild(container);
    }

    const toast = document.createElement("div");

    let icon = "uil-info-circle";

    if (type === "success") {
      icon = "uil-check-circle";
    } else if (type === "danger") {
      icon = "uil-times-circle";
    } else if (type === "warning") {
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
