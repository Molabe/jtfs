<?php
session_start();
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (!isset($_SESSION['user'])) {
    header('location: index.php');
    exit();
}

$user = $_SESSION['user'];
$mysqli = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch submitted forms
$result = $mysqli->query("SELECT * FROM forms ORDER BY submitted_at DESC");

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JTFS Panel | Nabor</title>
    <link rel="shortcut icon" type="image/jpeg" href="./images/jtfs_logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./bootstrap/app.css">
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

    <div class="container-fluid d-flex justify-content-center align-items-center mt-5 text-light">
        <div class="row justify-content-center align-items-center g-5">
            <div class="col-sm-4">
                <div class="container d-flex justify-content-center align-items-center flex-column devgru-card-nswdg">
                    <img src="./images/NSWDG.png" alt="NSWDG-Logo" style="width:75%">
                    <h4 class="text-light devgru-text">NSWDG</h4>
                    <p>Nábor: OTVORENÝ</p>
                    <button class="btn btn-success"><a class="text-light" href="formular.php">FORMULÁR</a></button>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="container d-flex justify-content-center align-items-center flex-column devgru-card-usaf">
                    <img src="./images/usaf_logo.png" alt="USAF-Logo" style="width:83%">
                    <h4 class="text-light devgru-text">USAF</h4>
                    <p>Nábor: OTVORENÝ</p>
                    <button class="btn btn-success"><a class="text-light" href="formular.php">FORMULÁR</a></button>
                </div>
            </div>
        </div>

        <!-- Display submitted forms -->
        <h2 class="text-light">Odoslané formuláre</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="bg-devgru-black p-3 mb-3">
                    <strong>Čas a Dátum:</strong> <?php echo $row['submitted_at']; ?><br>
                    <strong>Status:</strong> <?php echo $row['status']; ?><br>
                    <strong>Odpovede:</strong><br>
                    Vek: <?php echo $row['vek']; ?><br>
                    Skúsenosti: <?php echo $row['skusenosti']; ?><br>
                    DLC: <?php echo $row['dlc']; ?><br>
                    Členstvo: <?php echo $row['clenstvo']; ?><br>
                    Predchádzajúca Skupina: <?php echo $row['predchadzajuca_skupina']; ?><br>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-light">Žiadne formuláre neboli odoslané.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

<?php
$mysqli->close();
?>
