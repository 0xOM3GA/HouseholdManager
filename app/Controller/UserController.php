<?php

declare(strict_types=1);

namespace App\Controller;

class UserController
{
    /**
     * Zeigt das Dashboard an – nur für eingeloggte Benutzer.
     */
    public function dashboard(): void
    {
        if (!isset($_SESSION['user_id'])) {
            // Flash Message setzen
            $_SESSION['flash'][] = [
                'type' => 'error',
                'message' => 'Bitte logge dich ein, um auf das Dashboard zuzugreifen.'
            ];
            header('Location: /index.php?route=login');
            exit;
        }
        include __DIR__ . '/../View/dashboard.php';
    }
}
