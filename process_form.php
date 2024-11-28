<?php
session_start();
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $experience = $_POST['experience'];
    $date = date("Y-m-d H:i:s");

    // Prepare the data to send as an embed
    $embed = [
        "title" => "New Recruitment Form Submission",
        "description" => "Details of the recruitment form submission",
        "color" => hexdec("FF5733"),
        "fields" => [
            ["name" => "Name", "value" => $name],
            ["name" => "Age", "value" => $age],
            ["name" => "Experience", "value" => $experience],
        ],
        "timestamp" => $date
    ];

    // Discord webhook URL to send the embed
    $webhookUrl = "https://discord.com/api/webhooks/YOUR_WEBHOOK_ID/YOUR_WEBHOOK_TOKEN";

    $data = json_encode(["embeds" => [$embed]]);

    // Send to Discord
    $ch = curl_init($webhookUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    ]);

    curl_exec($ch);
    curl_close($ch);

    // Save to database
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO submissions (name, age, experience, date, status) VALUES (:name, :age, :experience, :date, 'Čaká sa na odpoveď')");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':experience', $experience);
        $stmt->bindParam(':date', $date);
        $stmt->execute();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

    header("Location: nabor.php");
    exit();
}
?>
