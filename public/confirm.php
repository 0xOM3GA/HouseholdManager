<?php

declare(strict_types=1);

session_start();

// Datenbankverbindung laden
require_once __DIR__ . '/../config/config.php';
$pdo = new PDO($dsn, $dbUser, $dbPassword, $pdoOptions);

$token = $_GET['token'] ?? '';

if (empty($token)) {
    echo 'Ungültiger Bestätigungslink.';
    exit;
}

$stmt = $pdo->prepare('UPDATE user SET confirmed = 1, confirmation_token = NULL WHERE confirmation_token = :token');
$stmt->execute([':token' => $token]);

if ($stmt->rowCount() > 0) {
    echo 'E-Mail erfolgreich bestätigt!';
} else {
    echo 'Ungültiger oder bereits verwendeter Bestätigungslink.';
}
