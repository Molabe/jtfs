<?php
session_start();
require 'vendor/autoload.php'; // Load Composer autoloader for .env handling

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get authorization code
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Create POST request to obtain access token
    $url = 'https://discord.com/api/oauth2/token';
    $data = [
        'client_id' => $_ENV['CLIENT_ID'], // Make sure the env variable is named correctly
        'client_secret' => $_ENV['CLIENT_SECRET'],
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $_ENV['REDIRECT_URI'], // Corrected variable name
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

    // Retrieve access token
    $access_token = $response_data['access_token'];

    // Load user information
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

    // Save user info to session
    $user_data = json_decode($user_response, true);
    $_SESSION['user'] = $user_data;
    $_SESSION['access_token'] = $access_token;

    // Redirect to index.php or profile.php
    header('Location: profile.php'); // Redirect to profile page
    exit();
} else {
    die('Authorization code not received');
}
