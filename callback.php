<?php
session_start();

// Nahradiť tieto hodnoty svojimi
$client_id = '1301503755979853957';
$client_secret = 'qa__Ab2sWrvMRIBb4rFhMh6ZZ-5yG7Oo';
$redirect_uri = 'http://localhost:8080/callback.php'; // alebo tvoje URL
$guild_id = '1280088464997482498';

// Získaj autorizačný kód
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Vytvoríme POST požiadavku na získanie prístupového tokenu
    $url = 'https://discord.com/api/oauth2/token';
    $data = [
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $redirect_uri,
        'scope' => 'identify',
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        die('Error fetching access token');
    }

    $response_data = json_decode($response, true);

    // Získanie prístupového tokenu
    $access_token = $response_data['access_token'];

    // Načítať informácie o používateľovi
    $user_url = 'https://discord.com/api/v10/users/@me';
    $user_options = [
        'http' => [
            'header' => "Authorization: Bearer $access_token\r\n",
        ],
    ];

    $user_context = stream_context_create($user_options);
    $user_response = file_get_contents($user_url, false, $user_context);

    if ($user_response === false) {
        die('Error fetching user information');
    }

    // Uložiť informácie do session
    $user_data = json_decode($user_response, true);
    $_SESSION['user'] = $user_data;
    $_SESSION['access_token'] = $access_token;

    // Presmerovanie na index.php alebo profil.php
    header('Location: index.php'); // alebo 'Location: profile.php';
    exit();
} else {
    die('Authorization code not received');
}
