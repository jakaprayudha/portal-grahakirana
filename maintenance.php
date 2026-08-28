<!DOCTYPE html>
<html lang="id">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Maintenance | STIH Graha Kirana</title>

   <meta
      name="description"
      content="Sistem Informasi STIH Graha Kirana sedang dalam pemeliharaan.">

   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

   <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet">

   <style>
      /* =========================================
           RESET
        ========================================= */

      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
      }

      :root {
         --primary: #155eef;
         --primary-dark: #0b4dcc;
         --primary-light: #eaf2ff;

         --text: #172b4d;
         --muted: #667085;

         --white: #ffffff;
         --border: #e4eaf2;

         --success: #12b76a;

         --shadow:
            0 25px 70px rgba(15, 65, 140, 0.12);
      }

      html {
         scroll-behavior: smooth;
      }

      body {
         font-family: "Inter", sans-serif;
         color: var(--text);

         background:
            radial-gradient(circle at 10% 10%,
               rgba(21, 94, 239, 0.08),
               transparent 30%),
            radial-gradient(circle at 90% 90%,
               rgba(21, 94, 239, 0.08),
               transparent 30%),
            #f6f9fd;

         min-height: 100vh;
         overflow-x: hidden;
      }

      button,
      a {
         font-family: inherit;
      }


      /* =========================================
           PAGE
        ========================================= */

      .page {
         position: relative;

         min-height: 100vh;

         display: flex;
         flex-direction: column;

         overflow: hidden;
      }


      /* =========================================
           BACKGROUND SHAPES
        ========================================= */

      .bg-shape {
         position: absolute;

         border-radius: 50%;

         pointer-events: none;

         filter: blur(2px);
      }

      .shape-one {
         width: 420px;
         height: 420px;

         top: -240px;
         right: -150px;

         background: rgba(21, 94, 239, 0.07);
      }

      .shape-two {
         width: 300px;
         height: 300px;

         bottom: -170px;
         left: -120px;

         background: rgba(21, 94, 239, 0.05);
      }


      /* =========================================
           HEADER
        ========================================= */

      .header {
         width: min(1180px, calc(100% - 40px));

         margin: 0 auto;

         padding: 28px 0;

         display: flex;
         align-items: center;
         justify-content: space-between;

         position: relative;
         z-index: 5;
      }

      .brand {
         display: flex;
         align-items: center;

         gap: 13px;
      }

      .brand-logo {
         width: 48px;
         height: 48px;

         border-radius: 13px;

         display: flex;
         align-items: center;
         justify-content: center;

         background:
            linear-gradient(145deg,
               #1769ff,
               #0847bd);

         color: white;

         box-shadow:
            0 8px 20px rgba(21, 94, 239, 0.25);
      }

      .brand-logo span {
         font-size: 11px;

         font-weight: 800;

         letter-spacing: .5px;
      }

      .brand-text {
         display: flex;
         flex-direction: column;

         gap: 3px;
      }

      .brand-text strong {
         font-size: 16px;

         font-weight: 800;

         color: #13284b;
      }

      .brand-text small {
         font-size: 11px;

         color: var(--muted);
      }

      .system-status {
         display: flex;
         align-items: center;

         gap: 8px;

         padding: 9px 14px;

         border-radius: 30px;

         background: white;

         border: 1px solid var(--border);

         color: #64748b;

         font-size: 12px;

         font-weight: 600;
      }

      .status-dot {
         width: 8px;
         height: 8px;

         border-radius: 50%;

         background: #f79009;

         box-shadow:
            0 0 0 4px rgba(247, 144, 9, 0.10);

         animation: pulse 1.8s infinite;
      }


      /* =========================================
           MAIN
        ========================================= */

      .main {
         flex: 1;

         width: min(1180px, calc(100% - 40px));

         margin: 0 auto;

         display: flex;
         align-items: center;
         justify-content: center;

         padding: 40px 0 70px;

         position: relative;

         z-index: 2;
      }


      /* =========================================
           CARD
        ========================================= */

      .maintenance-card {
         width: 100%;

         max-width: 1050px;

         display: grid;

         grid-template-columns: .9fr 1.1fr;

         gap: 70px;

         align-items: center;

         background: rgba(255, 255, 255, .94);

         border: 1px solid rgba(226, 232, 240, .9);

         border-radius: 28px;

         padding: 70px;

         box-shadow: var(--shadow);

         backdrop-filter: blur(10px);

         animation: cardEnter .8s ease both;
      }


      /* =========================================
           ILLUSTRATION
        ========================================= */

      .illustration {
         position: relative;

         width: 100%;

         max-width: 390px;

         aspect-ratio: 1 / 1;

         margin: auto;

         display: flex;

         align-items: center;

         justify-content: center;

         transition: transform .15s ease-out;
      }

      .illustration::before {
         content: "";

         position: absolute;

         width: 310px;
         height: 310px;

         border-radius: 50%;

         background:
            radial-gradient(circle,
               rgba(21, 94, 239, .13),
               rgba(21, 94, 239, .025) 70%,
               transparent 71%);
      }

      .monitor {
         position: relative;

         z-index: 3;

         width: 220px;
         height: 170px;

         background: #dce9fb;

         border-radius: 16px;

         padding: 11px;

         box-shadow:
            0 18px 40px rgba(21, 94, 239, .16);
      }

      .monitor-screen {
         width: 100%;
         height: 100%;

         border-radius: 9px;

         background:
            linear-gradient(145deg,
               #ffffff,
               #edf5ff);

         border: 1px solid #c8d9f1;

         display: flex;
         flex-direction: column;

         align-items: center;
         justify-content: center;

         gap: 7px;
      }

      .screen-icon {
         width: 48px;
         height: 48px;

         border-radius: 13px;

         display: flex;
         align-items: center;
         justify-content: center;

         background: var(--primary-light);

         font-size: 24px;

         margin-bottom: 3px;
      }

      .screen-line {
         height: 6px;

         border-radius: 10px;

         background: #c8d9f1;
      }

      .line-one {
         width: 100px;
      }

      .line-two {
         width: 70px;
      }

      .line-three {
         width: 85px;
      }

      .monitor-stand {
         position: absolute;

         width: 32px;
         height: 28px;

         left: 50%;
         bottom: -28px;

         transform: translateX(-50%);

         background: #c5d8f0;
      }

      .monitor-base {
         position: absolute;

         width: 82px;
         height: 9px;

         left: 50%;
         bottom: -35px;

         transform: translateX(-50%);

         border-radius: 20px;

         background: #abc5e5;
      }


      /* =========================================
           GEARS
        ========================================= */

      .gear {
         position: absolute;

         display: flex;

         align-items: center;
         justify-content: center;

         color: var(--primary);

         z-index: 4;

         filter:
            drop-shadow(0 10px 12px rgba(21, 94, 239, .16));
      }

      .gear-large {
         width: 85px;
         height: 85px;

         top: 25px;
         right: 5px;

         font-size: 72px;

         animation:
            rotateGear 8s linear infinite;
      }

      .gear-small {
         width: 55px;
         height: 55px;

         bottom: 35px;
         left: 15px;

         font-size: 47px;

         animation:
            rotateGearReverse 6s linear infinite;
      }


      /* =========================================
           CONTENT
        ========================================= */

      .content {
         max-width: 520px;
      }

      .eyebrow {
         display: flex;

         align-items: center;

         gap: 9px;

         margin-bottom: 17px;

         color: var(--primary);

         font-size: 11px;

         font-weight: 800;

         letter-spacing: 1.5px;
      }

      .eyebrow span {
         width: 25px;
         height: 2px;

         background: var(--primary);

         border-radius: 10px;
      }

      h1 {
         font-size: clamp(34px, 4vw, 51px);

         line-height: 1.08;

         letter-spacing: -1.8px;

         color: #102a50;

         margin-bottom: 22px;
      }

      h1 span {
         display: block;

         color: var(--primary);
      }

      .description {
         color: #667085;

         font-size: 15px;

         line-height: 1.8;

         max-width: 500px;

         margin-bottom: 30px;
      }


      /* =========================================
           PROGRESS
        ========================================= */

      .maintenance-progress {
         margin-bottom: 28px;
      }

      .progress-header {
         display: flex;

         align-items: center;

         justify-content: space-between;

         margin-bottom: 9px;

         font-size: 12px;

         font-weight: 700;

         color: #667085;
      }

      .progress-header strong {
         color: var(--primary);
      }

      .progress-bar {
         width: 100%;
         height: 9px;

         border-radius: 20px;

         background: #edf2f8;

         overflow: hidden;
      }

      .progress-value {
         width: 75%;
         height: 100%;

         border-radius: inherit;

         background:
            linear-gradient(90deg,
               #0d55db,
               #4389ff);

         box-shadow:
            0 0 15px rgba(21, 94, 239, .3);

         animation:
            progressAnimation 1.5s ease;
      }

      .progress-info {
         margin-top: 10px;

         display: flex;

         justify-content: space-between;

         font-size: 11px;

         color: #98a2b3;
      }

      .progress-info span:first-child {
         display: flex;

         align-items: center;

         gap: 6px;
      }

      .live-dot {
         width: 6px;
         height: 6px;

         border-radius: 50%;

         background: var(--success);

         animation:
            pulseGreen 1.6s infinite;
      }


      /* =========================================
           ACTIONS
        ========================================= */

      .actions {
         display: flex;

         gap: 12px;

         margin-bottom: 12px;
      }

      .btn {
         height: 48px;

         padding: 0 21px;

         border-radius: 10px;

         display: inline-flex;

         align-items: center;

         justify-content: center;

         gap: 8px;

         text-decoration: none;

         font-size: 13px;

         font-weight: 700;

         cursor: pointer;

         transition:
            transform .2s ease,
            box-shadow .2s ease,
            background .2s ease;
      }

      .btn-primary {
         border: none;

         color: white;

         background:
            linear-gradient(135deg,
               #1769ff,
               #0750d5);

         box-shadow:
            0 8px 20px rgba(21, 94, 239, .22);
      }

      .btn-primary:hover {
         transform: translateY(-2px);

         box-shadow:
            0 13px 28px rgba(21, 94, 239, .28);
      }

      .btn-secondary {
         color: #36506f;

         background: white;

         border: 1px solid #dbe4ef;
      }

      .btn-secondary:hover {
         transform: translateY(-2px);

         background: #f8fbff;

         border-color: #b9cce5;
      }

      .refresh-icon {
         display: inline-block;

         font-size: 19px;

         transition:
            transform .5s ease;
      }

      .btn-primary.loading .refresh-icon {
         animation:
            spin .8s linear infinite;
      }


      /* =========================================
           BACK BUTTON
        ========================================= */

      .back-page {
         width: 100%;

         display: flex;

         justify-content: flex-start;
      }

      .back-button {
         display: inline-flex;

         align-items: center;

         gap: 7px;

         padding: 6px 0;

         border: none;

         background: transparent;

         color: #7a8799;

         font-size: 12px;

         font-weight: 600;

         cursor: pointer;

         transition:
            color .2s ease,
            transform .2s ease;
      }

      .back-button:hover {
         color: var(--primary);

         transform: translateX(-3px);
      }

      .back-icon {
         font-size: 16px;

         line-height: 1;
      }


      /* =========================================
           NOTICE
        ========================================= */

      .notice {
         display: flex;

         align-items: flex-start;

         gap: 11px;

         padding: 15px;

         margin-top: 18px;

         border-radius: 12px;

         background: #f7faff;

         border: 1px solid #e6eef9;
      }

      .notice-icon {
         flex-shrink: 0;

         width: 25px;
         height: 25px;

         border-radius: 50%;

         display: flex;

         align-items: center;

         justify-content: center;

         background: var(--primary-light);

         color: var(--primary);

         font-size: 12px;

         font-weight: 800;
      }

      .notice strong {
         display: block;

         font-size: 12px;

         margin-bottom: 3px;

         color: #36506f;
      }

      .notice p {
         color: #7a8799;

         font-size: 11px;

         line-height: 1.6;
      }


      /* =========================================
           FOOTER
        ========================================= */

      .footer {
         text-align: center;

         padding: 0 20px 28px;

         position: relative;

         z-index: 2;

         color: #98a2b3;

         font-size: 11px;
      }

      .footer strong {
         color: #667085;
      }


      /* =========================================
           ANIMATIONS
        ========================================= */

      @keyframes pulse {

         0%,
         100% {
            box-shadow:
               0 0 0 4px rgba(247, 144, 9, .10);
         }

         50% {
            box-shadow:
               0 0 0 8px rgba(247, 144, 9, .04);
         }

      }

      @keyframes pulseGreen {

         0%,
         100% {
            opacity: 1;
         }

         50% {
            opacity: .35;
         }

      }

      @keyframes rotateGear {

         from {
            transform: rotate(0deg);
         }

         to {
            transform: rotate(360deg);
         }

      }

      @keyframes rotateGearReverse {

         from {
            transform: rotate(0deg);
         }

         to {
            transform: rotate(-360deg);
         }

      }

      @keyframes progressAnimation {

         from {
            width: 0;
         }

         to {
            width: 75%;
         }

      }

      @keyframes cardEnter {

         from {
            opacity: 0;

            transform:
               translateY(25px);
         }

         to {
            opacity: 1;

            transform:
               translateY(0);
         }

      }

      @keyframes spin {

         from {
            transform: rotate(0);
         }

         to {
            transform: rotate(360deg);
         }

      }


      /* =========================================
           RESPONSIVE
        ========================================= */

      @media (max-width: 900px) {

         .maintenance-card {

            grid-template-columns: 1fr;

            gap: 35px;

            padding: 50px 40px;

            text-align: center;
         }

         .content {

            max-width: 650px;

            margin: auto;
         }

         .eyebrow {

            justify-content: center;
         }

         .description {

            margin-left: auto;

            margin-right: auto;
         }

         .actions {

            justify-content: center;
         }

         .back-page {

            justify-content: center;
         }

         .notice {

            text-align: left;
         }

      }


      @media (max-width: 600px) {

         .header {

            width: calc(100% - 28px);

            padding: 18px 0;
         }

         .brand-text small {

            display: none;
         }

         .brand-text strong {

            font-size: 14px;
         }

         .brand-logo {

            width: 42px;
            height: 42px;
         }

         .system-status {

            padding: 7px 10px;

            font-size: 10px;
         }

         .main {

            width: calc(100% - 28px);

            padding: 25px 0 45px;
         }

         .maintenance-card {

            border-radius: 22px;

            padding: 35px 22px;

            gap: 15px;
         }

         .illustration {

            max-width: 280px;
         }

         .illustration::before {

            width: 230px;
            height: 230px;
         }

         .monitor {

            width: 175px;
            height: 135px;
         }

         .gear-large {

            font-size: 55px;

            right: -5px;
            top: 10px;
         }

         .gear-small {

            font-size: 38px;

            left: 0;
            bottom: 25px;
         }

         h1 {

            font-size: 34px;

            letter-spacing: -1px;
         }

         .description {

            font-size: 13px;

            line-height: 1.7;
         }

         .actions {

            flex-direction: column;
         }

         .btn {

            width: 100%;
         }

         .progress-info {

            font-size: 10px;
         }

         .footer {

            padding-bottom: 20px;
         }

      }
   </style>
</head>


<body>

   <div class="page">


      <!-- =========================================
         BACKGROUND
    ========================================= -->

      <div class="bg-shape shape-one"></div>

      <div class="bg-shape shape-two"></div>


      <!-- =========================================
         HEADER
    ========================================= -->

      <header class="header">

         <div class="brand">

            <div class="brand-logo">

               <span>
                  STIH
               </span>

            </div>

            <div class="brand-text">

               <strong>
                  STIH Graha Kirana
               </strong>

               <small>
                  Sekolah Tinggi Ilmu Hukum
               </small>

            </div>

         </div>


         <div class="system-status">

            <span class="status-dot"></span>

            Sistem Maintenance

         </div>

      </header>


      <!-- =========================================
         MAIN
    ========================================= -->

      <main class="main">

         <section class="maintenance-card">


            <!-- =====================================
                 ILLUSTRATION
            ====================================== -->

            <div class="illustration">

               <div class="gear gear-large">
                  ⚙
               </div>

               <div class="gear gear-small">
                  ⚙
               </div>


               <div class="monitor">

                  <div class="monitor-screen">

                     <div class="screen-icon">
                        🔧
                     </div>

                     <div class="screen-line line-one"></div>

                     <div class="screen-line line-two"></div>

                     <div class="screen-line line-three"></div>

                  </div>


                  <div class="monitor-stand"></div>

                  <div class="monitor-base"></div>

               </div>

            </div>


            <!-- =====================================
                 CONTENT
            ====================================== -->

            <div class="content">


               <div class="eyebrow">

                  <span></span>

                  SISTEM DALAM PEMELIHARAAN

               </div>


               <h1>

                  Kami Sedang

                  <span>
                     Melakukan Maintenance
                  </span>

               </h1>


               <p class="description">

                  Sistem Informasi STIH Graha Kirana sedang
                  dalam proses pemeliharaan dan peningkatan
                  layanan. Mohon menunggu beberapa saat
                  hingga sistem kembali dapat digunakan.

               </p>


               <!-- =================================
                     PROGRESS
                ================================== -->

               <div class="maintenance-progress">

                  <div class="progress-header">

                     <span>
                        Status Pemeliharaan
                     </span>

                     <strong id="progressPercent">
                        75%
                     </strong>

                  </div>


                  <div class="progress-bar">

                     <div
                        class="progress-value"
                        id="progressValue">
                     </div>

                  </div>


                  <div class="progress-info">

                     <span>

                        <span class="live-dot"></span>

                        Maintenance berlangsung

                     </span>

                     <span>
                        Mohon tunggu...
                     </span>

                  </div>

               </div>


               <!-- =================================
                     ACTION BUTTONS
                ================================== -->

               <div class="actions">


                  <button
                     type="button"
                     class="btn btn-primary"
                     id="refreshButton">

                     <span class="refresh-icon">
                        ↻
                     </span>

                     Coba Lagi

                  </button>


                  <a
                     href="#contact"
                     class="btn btn-secondary">

                     Hubungi Admin

                  </a>


               </div>


               <!-- =================================
                     BACK TO PREVIOUS PAGE
                ================================== -->

               <div class="back-page">

                  <button
                     type="button"
                     class="back-button"
                     id="backButton">

                     <span class="back-icon">
                        ←
                     </span>

                     Kembali ke Halaman Sebelumnya

                  </button>

               </div>


               <!-- =================================
                     INFORMATION
                ================================== -->

               <div class="notice">

                  <div class="notice-icon">
                     i
                  </div>


                  <div>

                     <strong>
                        Informasi
                     </strong>

                     <p>

                        Data dan akun Anda tetap aman.
                        Silakan kembali beberapa saat lagi
                        untuk melanjutkan aktivitas.

                     </p>

                  </div>

               </div>


            </div>

         </section>

      </main>


      <!-- =========================================
         FOOTER
    ========================================= -->

      <footer class="footer">

         &copy;

         <span id="year"></span>

         <strong>
            STIH Graha Kirana
         </strong>

         &nbsp;•&nbsp;

         Sistem Informasi Akademik

      </footer>


   </div>


   <script>
      /* =========================================
       CURRENT YEAR
    ========================================= */

      const yearElement =
         document.getElementById("year");

      yearElement.textContent =
         new Date().getFullYear();


      /* =========================================
         REFRESH BUTTON
      ========================================= */

      const refreshButton =
         document.getElementById("refreshButton");


      refreshButton.addEventListener(
         "click",
         function() {

            refreshButton.classList.add("loading");

            refreshButton.innerHTML = `
                <span class="refresh-icon">↻</span>
                Memeriksa Sistem...
            `;


            setTimeout(function() {

               window.location.reload();

            }, 1200);

         }
      );


      /* =========================================
         BACK TO PREVIOUS PAGE
      ========================================= */

      const backButton =
         document.getElementById("backButton");


      backButton.addEventListener(
         "click",
         function() {

            /*
             * Jika terdapat halaman sebelumnya
             * pada browser history, kembali ke sana.
             */

            if (window.history.length > 1) {

               window.history.back();

            } else {

               /*
                * Fallback jika halaman maintenance
                * dibuka langsung.
                *
                * Ganti URL berikut dengan halaman
                * utama portal Anda.
                */

               window.location.href = "/";

            }

         }
      );


      /* =========================================
         MOUSE PARALLAX
      ========================================= */

      const illustration =
         document.querySelector(".illustration");


      document.addEventListener(
         "mousemove",
         function(event) {

            if (window.innerWidth < 900) {
               return;
            }


            const x =
               (window.innerWidth / 2 - event.clientX) / 80;


            const y =
               (window.innerHeight / 2 - event.clientY) / 80;


            illustration.style.transform =
               `translate(${x}px, ${y}px)`;

         }
      );


      /* =========================================
         RESET PARALLAX
      ========================================= */

      document.addEventListener(
         "mouseleave",
         function() {

            illustration.style.transform =
               "translate(0, 0)";

         }
      );


      /* =========================================
         PAGE VISIBILITY
      ========================================= */

      document.addEventListener(
         "visibilitychange",
         function() {

            if (!document.hidden) {

               document.title =
                  "Maintenance | STIH Graha Kirana";

            }

         }
      );
   </script>

</body>

</html>