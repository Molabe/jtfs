<?php
session_start();
require 'vendor/autoload.php'; // Načítanie Composer autoloaderu na prácu s .env

// Načítanie env premenných
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function countMembersWithRole($roleId) {
    $token = $_ENV['BOT_TOKEN'];
    $guildId = $_ENV['GUILD_ID'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://discord.com/api/v10/guilds/$guildId/members?limit=1000");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bot $token",
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === false) {
        return "Error fetching data.";
    }

    $members = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return "Error decoding JSON response.";
    }

    $count = 0;
    foreach ($members as $member) {
        if (in_array($roleId, $member['roles'])) {
            $count++;
        }
    }

    return $count;
}

function countModsAndSize()
{
    $modIds = [
        "3360859953",
        "3360858612",
        "3360855745",
        "3360853441",
        "3360851247"
    ];
    $modCount = count($modIds);
    $approxSize = "40 GB";

    return [$modCount, $approxSize];

// List of mod IDs
    $modIds = [
        "3360859953",
        "3360858612",
        "3360855745",
        "3360853441",
        "3360851247"
    ];

    $modDetails = getModDetails($modIds);
}
?>

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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <li class="nav-item"><a href="#" class="nav-link text-light">DISCORD</a></li>
            <li class="nav-item">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="profile.php" class="nav-link text-light">PANEL</a>
                <?php else: ?>
                    <a href="https://discord.com/oauth2/authorize?client_id=<?php echo $_ENV['CLIENT_ID']; ?>&response_type=code&redirect_uri=<?php echo urlencode('http://localhost:8080/callback.php'); ?>&scope=identify" class="nav-link text-light">PRIHLÁSIŤ SA</a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</nav>


<div class="text-over-image" style="width: 100%;">
    <img src="./images/Pilot_rescue_4.png" class="gradient" style="width: 100%; height: 100%;">
    <h1 id="text" class="text-center text-light" style="font-family: 'Roboto Mono', monospace">Joint Task Force Spectre</h1>
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
                <br>
                <p>Cieľom našej komunity je vytvoriť realistický zážitok, ktorý hráčom umožní zažiť atmosféru špeciálnych operácií a spolupracovať v tíme na úspešnom splnení misií. Okrem taktického hrania kladieme dôraz aj na komunitu, vzájomnú pomoc a rozvoj hráčskych schopností.</p>
            </div>
        </div>
    </div>
</div>

<div class="text-over-image center-cropped d-flex justify-content-center" style="width: 100%">
    <img src="./images/Arma3_x64_2023-10-01_20-37-35.png" class="gradient center-cropped"></img>
    <div class="row g-5 text text-light d-flex flex-nowrap" style="position: absolute; left: 50%; transform: translateX(-50%);">
        <div class="col-sm-4 d-flex flex-column align-items-center">
            <h2 class="h2 d-flex devgru-text">POČET KAMPANÍ</h2>
            <h4 class="h4 devgru-text">0</h4>
        </div>
        <div class="col-sm-5 d-flex flex-column align-items-center">
            <h2 class="h2 d-flex devgru-text">POČET OPERÁTOROV</h2>
            <h4 class="h4 devgru-text"><?php echo countMembersWithRole($_ENV['ROLE_ID']); ?></h4>
        </div>
        <div class="col-sm-4 d-flex flex-column align-items-center">
            <h2 class="h2 d-flex devgru-text">POČET MÓDOV</h2>
            <h4 class="h4 devgru-text"><?php echo $modCount; ?> (cca <?php echo $modSize; ?>)</h4>
        </div>
    </div>
</div>

<div class="container-fluid bg-devgru-blue text-white pt-4">
    <div class="container d-flex justify-content-center">
        <h2 class="text-light" style="font-family: 'Roboto Mono', monospace">NAŠE ROLE</h2>
    </div>
    <div class="container mt-5 mb-3 d-flex justify-content-center">
        <div class="row align-items-center justify-content-center">
            <div class="col d-flex align-items-center justify-content-center flex-column">
                <h3 class="h3">31O - Specter Operator</h3>
                <p>Naši Specter Operátori sú základom tímu, schopní rýchleho nasadenia, taktických manévrov a zvládania intenzívnych bojových situácií. Sú zameraní na priamu akciu, likvidáciu cieľov a podporu tímu na bojisku.</p>
            </div>

            <div class="col d-flex align-items-center justify-content-center flex-column">
                <h3 class="h3">25R - Scout Recon</h3>
                <p>Prieskumníci sú oči a uši nášho tímu. Zameriavajú sa na prieskum, zber informácií a sledovanie nepriateľských pohybov. Ich cieľom je zabezpečiť, aby tím vždy vedel o hrozbách a mohol sa bezpečne a efektívne pohybovať.</p>
            </div>

            <div class="col d-flex align-items-center justify-content-center flex-column">
                <h3 class="h3">68M - Combat Medic</h3>
                <p>Medic je srdcom tímu, vždy pripravený poskytnúť rýchlu a efektívnu pomoc v prípade zranenia. Tento vojak je vyškolený na bojové zdravotnícke zásahy priamo na bojisku, aby zabezpečil prežitie každého člena tímu.</p>
            </div>
        </div>
    </div>

    <div class="container br-line"></div>

    <div class="container mt-4 d-flex justify-content-center">
        <div class="row align-items-center justify-content-center">
            <div class="col d-flex align-items-center justify-content-center flex-column">
                <h3 class="h3">25J - JTAC | TACP</h3>
                <p>JTAC/TACP operátori sú kľúčoví pre koordináciu vzdušných útokov a leteckej podpory. Ich úlohou je presne nasmerovať letecké sily na nepriateľské ciele a zaistiť maximálnu efektivitu útokov.</p>
            </div>

            <div class="col d-flex align-items-center justify-content-center flex-column">
                <h3 class="h3">12X - EOD Specialist</h3>
                <p>EOD špecialisti majú na starosti identifikáciu, zneškodňovanie a odstraňovanie nebezpečných výbušnín. V nebezpečných situáciách zabezpečujú, aby boli výbušniny eliminované, čím chránia životy všetkých členov tímu.</p>
            </div>

            <div class="col d-flex align-items-center justify-content-center flex-column">
                <h3 class="h3">12B - Breaching Operator</h3>
                <p>Operátori na prieraz sú experti na otvorenie cesty tímu do nepriateľských priestorov. S využitím taktických prierazových metód zabezpečujú rýchly prístup do objektov, pričom eliminujú všetky prekážky.</p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid bg-devgru-black">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 border-top bg-devgru-black">
        <p class="col-md-4 mb-0 text-light">© 2024 Joint Task Force Specter</p>

        <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-md-4 justify-content-end bg-devgru-black">
            <li class="nav-item"><a href="#" class="nav-link px-2 text-light">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-light">Features</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-light">Pricing</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-light">FAQs</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-light">About</a></li>
        </ul>
    </footer>
</div>

<script src="textGenerator.js"></script>
<script src="./darker_nav.js"></script>

</body>
</html>
