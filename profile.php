<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$user = $_SESSION['user'];
$access_token = $_SESSION['access_token'];
$guild_id = '1280088464997482498';
$role_name = 'N/A';
$unit_name = 'N/A';

// Mapping of role IDs
$roles_map = [
    '1280093859598041148' => 'Captain',
    '1280093929835986975' => 'Commander',
    '1280093978037059626' => 'Lieutenant',
    '1280094486097039411' => 'Lieutenant Junior Grade',
    '1280094602032058378' => 'Ensign',
    '1280111801970720809' => 'Master Instructor Chief Petty Officer',
    '1280111798930112522' => 'Senior Instructor Chief Petty Officer',
    '1280111796929433610' => 'Instructor Chief Petty Officer',
    '1280110928427225088' => 'Master Chief Petty Officer',
    '1280111011248209951' => 'Senior Chief Petty Officer',
    '1280111065979682848' => 'Chief Petty Officer',
    '1280111110116347915' => 'Petty Officer First Class',
    '1280111149483823185' => 'Petty Officer Second Class',
    '1280111462743937065' => 'Petty Officer Third Class',
    '1280111450985437204' => 'Seaman',
    '1280111788006981724' => 'Seaman Recruit',
];

// Check user's guild roles
$guild_members_url = "https://discord.com/api/v10/guilds/$guild_id/members/{$user['id']}";
$guild_members_options = [
    'http' => [
        'header' => "Authorization: Bot YOUR_BOT_TOKEN_HERE\r\n", // Zmeňte na svoj bot token
    ],
];
$guild_members_context = stream_context_create($guild_members_options);
$guild_members_response = file_get_contents($guild_members_url, false, $guild_members_context);
$guild_members_data = json_decode($guild_members_response, true);

if (isset($guild_members_data['roles']) && is_array($guild_members_data['roles'])) {
    foreach ($guild_members_data['roles'] as $role_id) {
        if (isset($roles_map[$role_id])) {
            $role_name = $roles_map[$role_id];
            break;
        }
    }
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
    <title>Profil - Joint Task Force Spectre</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
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
                <a href="logout.php" class="nav-link text-light">ODHLÁSIŤ SA</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5 pt-5">
    <h1 class="text-center">Profil používateľa</h1>
    <div class="text-center mt-3">
        <img src="<?= htmlspecialchars($user['avatar']) ? "https://cdn.discordapp.com/avatars/{$user['id']}/{$user['avatar']}.png" : 'https://cdn.discordapp.com/embed/avatars/0.png' ?>" alt="Avatar" class="rounded-circle" width="150" height="150">
    </div>
    <h3 class="text-center mt-3"><?= htmlspecialchars($user['username']) ?>#<?= htmlspecialchars($user['discriminator']) ?></h3>
    <p class="text-center">Rola: <?= htmlspecialchars($role_name) ?></p>
</div>

<script src="./darker_nav.js"></script>

</body>
</html>
