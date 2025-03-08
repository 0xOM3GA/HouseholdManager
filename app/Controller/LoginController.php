<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\UserModel;

class LoginController
{
    private UserModel $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * Verarbeitet den Login.
     *
     * @param array $postData POST-Daten des Login-Formulars.
     */
    public function login(array $postData): void
    {
        $email = filter_var($postData['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $password = $postData['password'] ?? '';

        if (!$email) {
            echo 'Ungültige E-Mail-Adresse.';
            return;
        }

        $user = $this->userModel->getUserByEmail($email);
        if (!$user) {
            echo 'Benutzer nicht gefunden.';
            return;
        }

        if (!$user['confirmed']) {
            echo 'Bitte bestätigen Sie zuerst Ihre E-Mail-Adresse.';
            return;
        }

        if (!password_verify($password, $user['password'])) {
            echo 'Falsches Passwort.';
            return;
        }

        // Login erfolgreich, Benutzer-ID in der Session speichern
        $_SESSION['user_id'] = $user['id'];
        echo 'Login erfolgreich!';
    }
}