<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./bootstrap/app.css">
    <link rel="shortcut icon" type="image/jpeg" href="./images/jtfs_logo.jpg">
    <meta property="og:image" content="./images/jtfs_logo.jpg">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:type" content="website">
    <meta property="og:url" content="#">
    <meta property="og:title" content="Joint Task Force Spectre">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <title>Joint Task Force Spectre</title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body style="margin: 0; padding: 0;">

<nav id="navbar" class="navbar navbar-expand-md navbar-dark fixed-top">
    <a class="navbar-brand d-flex justify-content-end" href="#">
        <img style="width: 17.5%" src="./images/jtfs_logo_rbg.png" alt="Logo">
    </a>
    <div class="container-fluid justify-content-center">
        <ul class="navbar-nav">
            <li class="nav-item"><a href="#" class="nav-link text-light">DOMOV</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-light">O NÁS</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-light">HOVORIŤ S RECRUITEROM</a></li>
            <li class="nav-item">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="profile.php" class="nav-link text-light">PROFIL</a>
                <?php else: ?>
                    <a href="https://discord.com/oauth2/authorize?client_id=1301503755979853957&response_type=code&redirect_uri=http%3A%2F%2Flocalhost%3A8080%2Fcallback.php&scope=identify" class="nav-link text-light">PRIHLÁSIŤ SA</a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</nav>

<div class="text-over-image" style="width: 100%;">
    <img src="./images/Pilot_rescue_4.png" class="gradient" style="width: 100%; height: 100%;">
    <h1 class="text-center text-light" style="font-family: 'Roboto Mono', monospace">Joint Task Force Spectre</h1>
</div>

<div class="container-fluid bg-devgru-blue text-white pt-4">
    <div class="container d-flex justify-content-center">
        <h2 class="text-light" style="font-family: 'Roboto Mono', monospace">NAŠA KOMUNITA</h2>
    </div>
    <div class="container d-flex justify-content-center">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-8 col-md-6 col-lg-4">
                <img src="./images/jtfs_logo_rbg_b.png" class="img-fluid" alt="">
            </div>
            <div class="col-12 col-md-6 col-lg-4 mt-4">
                <p>Naša Arma 3 skupina vznikla 1. novembra 2024 pod vedením zakladateľov Molabe a Foxa. Sme komunita nadšencov vojenských simulácií a reálneho taktického hrania. Naša skupina je zameraná na detailné simulovanie špeciálnych operácií elitnej jednotky DEVGRU (United States Naval Special Warfare Development Group) v kombinácii s leteckou podporou USAF (United States Air Force).</p>
                </br>
                <p>Cieľom našej komunity je vytvoriť realistický zážitok, ktorý hráčom umožní zažiť atmosféru špeciálnych operácií a spolupracovať v tíme na úspešnom splnení misií. Okrem taktického hrania kladieme dôraz aj na komunitu, vzájomnú pomoc a rozvoj hráčskych schopností.</p>
            </div>
        </div>
    </div>
</div>

<script src="./darker_nav.js"></script>

</body>
</html>
