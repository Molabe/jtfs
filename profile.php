<?php
session_start();
require 'vendor/autoload.php'; // Make sure to include this if you're using Dotenv

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$user = $_SESSION['user'];
$access_token = $_SESSION['access_token'];
$guild_id = $_ENV['GUILD_ID'];
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
    '1280111608772694129' => 'Seaman Apprentice',
    '1280111673444663387' => 'Seaman Recruit',
];

$units_map = [
    '1280842675825803286' => 'NSWDG, United States Navy',
    '1280842681110630410' => 'Phantom Squadron, USAF',
];

// Call Discord API for member info
$ch = curl_init("https://discord.com/api/v10/guilds/$guild_id/members/{$user['id']}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bot {$_ENV['BOT_TOKEN']}"]);
$response = curl_exec($ch);
curl_close($ch);

$nickname = 'N/A'; // Default nickname if not found
if ($response && ($member_data = json_decode($response, true)) && isset($member_data['roles'])) {
    // Get nickname
    $nickname = $member_data['nick'] ?: 'N/A';

    // Assign role by ID
    $roles = $member_data['roles'];
    $role_names = [];
    foreach ($roles as $role_id) {
        if (isset($roles_map[$role_id])) {
            $role_names[] = $roles_map[$role_id];
        }
        // Assign unit based on ID
        if (isset($units_map[$role_id])) {
            $unit_name = $units_map[$role_id];
        }
    }
    $role_name = implode(', ', $role_names);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./bootstrap/app.css">
    <link rel="shortcut icon" type="image/jpeg" href="./images/jtfs_logo.jpg">
    <title>JTFS Panel</title>
    <link rel="shortcut icon" type="image/jpeg" href="./images/jtfs_logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-devgru-black">

<div class="container-fluid d-flex mt-5">

        <ul class="nav flex-column align-items-center justify-content-center" style="border-right: 5px solid #2E2E3A; min-width: 35vh; width:35vh; max-width:40vh;">
            <li class="nav-item"><a href="index.php" class="nav-link text-light">DOMOV</a></li>
            <li class="nav-item"><a href="nabor.php" class="nav-link text-light">NÁBOR</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-light">HOVORIŤ S RECRUITEROM</a></li>
            <li class="nav-item">
                <a href="logout.php" class="nav-link text-light">ODHLÁSIŤ SA</a>
            </li>
        </ul>

    <div class="container-fluid d-flex align-items-center justify-content-center">
        <div class="container-fluid row justify-content-center">
            <h1 class="text-light text-center-dashboard">Vitajte, <?php echo htmlspecialchars($nickname); ?>!</h1>
            <img src="https://cdn.discordapp.com/avatars/<?php echo $user['id']; ?>/<?php echo $user['avatar']; ?>.png" class="rounded-img" style="width: 50%" alt="Avatar" />
        </div>
        <div class="container-fluid">
            <div class="container">
                <h4 class="text-light">ID Užívateľa</h4>
                <p class="devgru-profile-border text-light"><?php echo htmlspecialchars($user['id']); ?></p>
            </div>
            <div class="container">
                <h4 class="text-light">Hodnosť</h4>
                <p class="devgru-profile-border text-light"><?php echo htmlspecialchars($role_name); ?></p>
            </div>
            <div class="container">
                <h4 class="text-light">Unit</h4>
                <p class="devgru-profile-border text-light"><?php echo htmlspecialchars($unit_name); ?></p>
            </div>
        </div>
    </div>

</div>
</body>
</html>
