<?php

declare(strict_types=1);

session_start();

// Einfacher Autoloader für Klassen im /app Verzeichnis
spl_autoload_register(function ($class) {
    $prefix   = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    $len      = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file           = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Datenbankverbindung laden
require_once __DIR__ . '/../config/config.php';
$pdo = new PDO($dsn, $dbUser, $dbPassword, $pdoOptions);

// Instanziierung der benötigten Klassen
use App\Model\UserModel;
use App\Service\RegistrationService;
use App\Controller\RegistrationController;
use App\Controller\LoginController;
use App\Controller\LogoutController;
use App\Controller\UserController;

$userModel             = new UserModel($pdo);
$registrationService   = new RegistrationService($userModel);
$registrationController = new RegistrationController($registrationService);
$loginController       = new LoginController($userModel);
$logoutController      = new LogoutController();
$userController        = new UserController();

// Flash Message Helper
function displayFlashMessages(): void
{
    if (!empty($_SESSION['flash'])) {
        foreach ($_SESSION['flash'] as $flash) {
            echo '<div class="' . htmlspecialchars($flash['type']) . '">'
                . htmlspecialchars($flash['message']) . '</div>';
        }
        unset($_SESSION['flash']);
    }
}

// Routing anhand des GET-Parameters "route"
$route = $_GET['route'] ?? 'home';

// Gemeinsame Header-Informationen
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Household Manager</title>
    <style>
        /* Einfaches CSS für Flash Messages */
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
<?php
displayFlashMessages();

if ($route === 'register') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $registrationController->register($_POST);
    } else {
        include __DIR__ . '/../app/View/register.php';
    }
} elseif ($route === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $loginController->login($_POST);
    } else {
        include __DIR__ . '/../app/View/login.php';
    }
} elseif ($route === 'dashboard') {
    $userController->dashboard();
} elseif ($route === 'logout') {
    $logoutController->logout();
} else {
    echo 'Willkommen auf der Startseite! <br>';
    if (isset($_SESSION['user_id'])) {
        echo '<a href="' . dirname(__DIR__, 5) . 'development/HouseholdManager/public/' . 'index.php?route=dashboard">Zum Dashboard</a> | ';
        echo '<a href="' . dirname(__DIR__, 5) . 'development/HouseholdManager/public/' . 'index.php?route=logout">Logout</a>';
    } else {
        echo '<a href="' . dirname(__DIR__, 5) . 'development/HouseholdManager/public/' . 'index.php?route=login">Login</a> | ';
        echo '<a href="' . dirname(__DIR__, 5) . 'development/HouseholdManager/public/' . 'index.php?route=register">Registrieren</a>';
    }
}
?>
</body>
</html>
