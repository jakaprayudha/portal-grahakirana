document.addEventListener("DOMContentLoaded", function () {
  console.log("=================================");
  console.log("AKTIVASI SIAKAD JS LOADED");
  console.log("=================================");

  /* =========================================================
     ELEMENT
  ========================================================= */

  const form = document.getElementById("formAktivasiSiakad");

  const button = document.getElementById("btnAktivasiSiakad");

  const agreement = document.getElementById("agreement");

  console.log("FORM:", form);

  console.log("BUTTON:", button);

  console.log("AGREEMENT:", agreement);

  if (!form || !button) {
    console.warn("Form atau button aktivasi tidak ditemukan.");

    return;
  }

  /* =========================================================
     FORM ACTION
  ========================================================= */

  const actionAttribute = form.getAttribute("action");

  console.log("FORM ACTION ATTRIBUTE:", actionAttribute);

  /*
   * Jangan menggunakan hard-code:
   *
   * /portal-grahakirana/controllers/aktivasi-siakad.php
   *
   * Karena project bisa dipindahkan ke folder/domain lain.
   *
   * document.baseURI akan mengikuti:
   *
   * <base href="../">
   */

  let controllerURL;

  try {
    controllerURL = new URL(
      actionAttribute || "controllers/aktivasi-siakad.php",
      document.baseURI,
    ).href;
  } catch (error) {
    console.error("GAGAL MEMBUAT CONTROLLER URL:", error);

    controllerURL = form.action;
  }

  console.log("BASE URI:", document.baseURI);

  console.log("CONTROLLER URL:", controllerURL);

  /* =========================================================
     SUBMIT
  ========================================================= */

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    console.log("=================================");
    console.log("AKTIVASI SIAKAD SUBMIT");
    console.log("=================================");

    /* =====================================================
         VALIDATION
      ===================================================== */

    if (agreement && !agreement.checked) {
      showPMBToast(
        "warning",
        "Silakan menyetujui pernyataan aktivasi terlebih dahulu.",
      );

      agreement.focus();

      return;
    }

    /* =====================================================
         CONFIRM
      ===================================================== */

    const confirmed = window.confirm(
      "Apakah Anda yakin ingin mengaktifkan akun SIAKAD?",
    );

    if (!confirmed) {
      return;
    }

    /* =====================================================
         LOADING
      ===================================================== */

    const originalHTML = button.innerHTML;

    button.disabled = true;

    button.innerHTML = `
        <span
          class="spinner-border spinner-border-sm me-2"
          role="status"
          aria-hidden="true">
        </span>
        Mengaktifkan...
      `;

    try {
      /* ===================================================
           FORM DATA
        =================================================== */

      const formData = new FormData(form);

      console.log("=================================");

      console.log("FORM DATA");

      console.log("=================================");

      for (const [key, value] of formData.entries()) {
        console.log(key, value);
      }

      /* ===================================================
           CONTROLLER URL
        =================================================== */

      console.log("=================================");

      console.log("CONTROLLER REQUEST");

      console.log("=================================");

      console.log("BASE URI:", document.baseURI);

      console.log("ACTION ATTRIBUTE:", form.getAttribute("action"));

      console.log("CONTROLLER URL:", controllerURL);

      /* ===================================================
           REQUEST
        =================================================== */

      const response = await fetch(controllerURL, {
        method: "POST",

        body: formData,

        credentials: "same-origin",

        headers: {
          "X-Requested-With": "XMLHttpRequest",

          Accept: "application/json",
        },
      });

      console.log("HTTP STATUS:", response.status);

      console.log("HTTP STATUS TEXT:", response.statusText);

      console.log("CONTENT TYPE:", response.headers.get("content-type"));

      console.log("FINAL RESPONSE URL:", response.url);

      /* ===================================================
           RAW RESPONSE
        =================================================== */

      const text = await response.text();

      console.log("=================================");

      console.log("CONTROLLER RAW RESPONSE");

      console.log("=================================");

      console.log(text);

      console.log("=================================");

      /* ===================================================
           EMPTY RESPONSE
        =================================================== */

      if (!text || !text.trim()) {
        throw new Error("Controller tidak memberikan response.");
      }

      /* ===================================================
           HTTP 404
        =================================================== */

      if (response.status === 404) {
        console.error("CONTROLLER 404");

        console.error("URL:", controllerURL);

        throw new Error(
          "Controller aktivasi SIAKAD tidak ditemukan (HTTP 404).",
        );
      }

      /* ===================================================
           JSON PARSE
        =================================================== */

      let result;

      try {
        result = JSON.parse(text);
      } catch (error) {
        console.error("JSON ERROR:", error);

        console.error("RAW RESPONSE:", text);

        throw new Error(
          "Controller tidak mengembalikan JSON. HTTP " + response.status,
        );
      }

      console.log("=================================");

      console.log("PARSED RESULT");

      console.log("=================================");

      console.log(result);

      /* ===================================================
           SESSION EXPIRED
        =================================================== */

      if (response.status === 401) {
        showPMBToast(
          "warning",
          result.message || "Sesi login telah berakhir. Silakan login kembali.",
        );

        setTimeout(function () {
          window.location.href = "./pmb/login-pmb.php";
        }, 1500);

        return;
      }

      /* ===================================================
           VALIDATION / BUSINESS ERROR
        =================================================== */

      if (!result.success) {
        console.error("AKTIVASI ERROR:", result);

        let message = result.message || "Gagal mengaktifkan akun SIAKAD.";

        /*
         * 422
         */

        if (response.status === 422) {
          showPMBToast("warning", message);
        } else if (response.status === 409) {

        /*
         * 409
         */
          showPMBToast("warning", message);
        } else if (response.status >= 500) {

        /*
         * 500
         */
          showPMBToast("danger", message);
        } else {

        /*
         * ERROR UMUM
         */
          showPMBToast("danger", message);
        }

        return;
      }

      /* ===================================================
           SUCCESS
        =================================================== */

      console.log("=================================");

      console.log("AKTIVASI SIAKAD BERHASIL");

      console.log("=================================");

      console.log("DATA:", result.data);

      showPMBToast(
        "success",
        result.message || "Akun SIAKAD berhasil diaktifkan.",
      );

      /* ===================================================
           REDIRECT
        =================================================== */

      let redirect = "./pmb/aktivasi-siakad.php";

      if (result.data && result.data.redirect) {
        redirect = result.data.redirect;
      }

      console.log("REDIRECT:", redirect);

      setTimeout(function () {
        window.location.href = redirect;
      }, 1500);
    } catch (error) {
      /* ===================================================
           ERROR
        =================================================== */

      console.error("=================================");

      console.error("AKTIVASI SIAKAD ERROR");

      console.error("=================================");

      console.error(error);

      showPMBToast("danger", error.message || "Terjadi kesalahan sistem.");
    } finally {
      /* ===================================================
           RESTORE BUTTON
        =================================================== */

      button.disabled = false;

      button.innerHTML = originalHTML;
    }
  });

  /* =========================================================
     TOAST
  ========================================================= */

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

  /* =========================================================
     ESCAPE HTML
  ========================================================= */

  function escapeHTML(text) {
    const div = document.createElement("div");

    div.textContent = text == null ? "" : String(text);

    return div.innerHTML;
  }
});
