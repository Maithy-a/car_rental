<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

try {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} catch (Exception $e) {
    file_put_contents(__DIR__ . '/../debug.log', "Dotenv error: " . $e->getMessage() . "\n", FILE_APPEND);
    exit("Error loading .env file: " . $e->getMessage());
}

define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_USER', $_ENV['DB_USER'] ?? '');
define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? '');
define('DB_NAME', $_ENV['DB_NAME'] ?? '');


if (empty(DB_HOST) || empty(DB_USER) || empty(DB_NAME)) {
    file_put_contents(__DIR__ . '/../debug.log', "Missing DB config: HOST=" . DB_HOST . ", USER=" . DB_USER . ", NAME=" . DB_NAME . "\n", FILE_APPEND);
    exit("Error: Database configuration missing.");
}

$SecretKey = $_ENV['PAYSTACK_SECRET_KEY'] ?? '';
$PublicKey = $_ENV['PAYSTACK_PUBLIC_KEY'] ?? '';


if (empty($PublicKey) || empty($SecretKey)) {
    file_put_contents(__DIR__ . '/../debug.log', "Paystack keys missing: Public=$PublicKey, Secret=$SecretKey\n", FILE_APPEND);
    exit("Error: Paystack keys not loaded. Check .env file.");
}


try {
    $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
    ]);
} catch (PDOException $e) {
    file_put_contents(__DIR__ . '/../debug.log', "DB connection error: " . $e->getMessage() . "\n", FILE_APPEND);
    exit("Error: " . $e->getMessage());
}
?>