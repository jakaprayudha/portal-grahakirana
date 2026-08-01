<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="Graha Kirana">
   <meta name="keywords" content="STIH, STIE, Graha Kirana">
   <meta name="author" content="imzack">
   <title><?= $page ?> - Graha Kirana</title>
   <link rel="shortcut icon" href="./assets/img/stih-grahakirana.png">
   <link rel="stylesheet" href="./assets/css/plugins.css">
   <link rel="stylesheet" href="./assets/css/style.css">
   <link rel="stylesheet" href="./assets/css/colors/grape.css">
   <link rel="preload" href="./assets/css/fonts/urbanist.css" as="style" onload="this.rel='stylesheet'">
</head>

<style>
   .facility-item {
      display: flex;
      align-items: flex-start;
   }

   .facility-icon {
      width: 64px;
      height: 64px;
      min-width: 64px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 40px;
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
      margin-right: 18px;
      transition: .3s;
   }

   .facility-item:hover .facility-icon {
      transform: translateY(-6px);
      box-shadow: 0 18px 35px rgba(233, 30, 99, .20);
   }

   .facility-item h3 {
      margin-bottom: 8px;
   }

   .facility-item p {
      margin-bottom: 0;
      color: #6c757d;
      line-height: 1.8;
   }

   .rounded-4 {
      border-radius: 28px !important;
   }

   .shadow-lg {
      box-shadow: 0 20px 60px rgba(0, 0, 0, .15) !important;
   }

   figure img {
      transition: .4s;
   }

   figure:hover img {
      transform: scale(1.03);
   }
</style>