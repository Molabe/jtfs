<?php
session_start();
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (!isset($_SESSION['user'])) {
    header('location: index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vek = $_POST['vek'];
    $skusenosti = $_POST['skusenosti'];
    $dlc = $_POST['dlc'];
    $clenstvo = $_POST['clenstvo'];
    $predchadzajuca_skupina = $_POST['predchadzajuca_skupina'];

    // Send data to Discord
    $url = 'https://discord.com/api/webhooks/1302060201557622815/1sVD3GL9AYJooQVrfXMz7SlM5t-ZgRQpV8HY7-95l2sezDcHdFDwXqvbrOwAHIvmQ5T7'; // Use your webhook URL
    $data = [
        "embeds" => [
            [
                "title" => "Nový formulár",
                "fields" => [
                    ["name" => "Vek", "value" => $vek, "inline" => true],
                    ["name" => "Skúsenosti", "value" => $skusenosti, "inline" => true],
                    ["name" => "DLC", "value" => $dlc, "inline" => true],
                    ["name" => "Členstvo", "value" => $clenstvo, "inline" => true],
                    ["name" => "Predchádzajúca Skupina", "value" => $predchadzajuca_skupina, "inline" => true],
                ],
                "color" => 0x00FF00
            ]
        ]
    ];

    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    // Insert the form data into the database
    $mysqli = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $insert_stmt = $mysqli->prepare("INSERT INTO forms (vek, skusenosti, dlc, clenstvo, predchadzajuca_skupina) VALUES (?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("issss", $vek, $skusenosti, $dlc, $clenstvo, $predchadzajuca_skupina);
    $insert_stmt->execute();
    $insert_stmt->close();

    $mysqli->close();

    // Redirect to nabor.php after submission
    header('Location: nabor.php');
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JTFS Panel | Formulár</title>
    <link rel="shortcut icon" type="image/jpeg" href="./images/jtfs_logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./bootstrap/app.css">
</head>
<body class="bg-devgru-black">

<div class="container mt-5">
    <h2 class="text-light">Vyplňte formulár</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="vek" class="form-label text-light">Tvoj vek</label>
            <input type="number" class="form-control" id="vek" name="vek" required>
        </div>
        <div class="mb-3">
            <label for="skusenosti" class="form-label text-light">Tvoje skúsenosti</label>
            <textarea class="form-control" id="skusenosti" name="skusenosti" required></textarea>
        </div>
        <div class="mb-3">
            <label for="dlc" class="form-label text-light">Aké vlastníš ArmA 3 DLC?</label>
            <input type="text" class="form-control" id="dlc" name="dlc" required>
        </div>
        <div class="mb-3">
            <label for="clenstvo" class="form-label text-light">Si aktuálne členom inej skupiny?</label>
            <input type="text" class="form-control" id="clenstvo" name="clenstvo" required>
        </div>
        <div class="mb-3">
            <label for="predchadzajuca_skupina" class="form-label text-light">Ak si bol členom, tak u akej skupiny si pôsobil?</label>
            <input type="text" class="form-control" id="predchadzajuca_skupina" name="predchadzajuca_skupina" required>
        </div>
        <button type="submit" class="btn btn-primary">Odoslať</button>
    </form>
</div>

</body>
</html>
