<?php

declare(strict_types=1);

namespace App\Controller;

class LogoutController
{
    /**
     * Loggt den Benutzer aus, zerstört die Session und leitet zum Login weiter.
     */
    public function logout(): void
    {
        session_destroy();
        header('Location: ' . dirname(__DIR__, 5) . 'development/HouseholdManager/public/' . '/index.php?route=login');
        exit;
    }
}
