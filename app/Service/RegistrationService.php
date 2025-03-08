<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\UserModel;
use Random\RandomException;
use RuntimeException;

class RegistrationService
{
    private UserModel $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * Registriert einen neuen Benutzer und versendet eine Bestätigungs-E-Mail.
     *
     * @param string $email
     * @param string $password
     * @throws RuntimeException|RandomException Falls die E-Mail bereits existiert.
     */
    public function registerUser(string $email, string $password): void
    {
        if ($this->userModel->existsByEmail($email)) {
            throw new RuntimeException('Die E-Mail-Adresse ist bereits registriert.');
        }

        // Passwort sicher hashen
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Bestätigungstoken generieren
        $confirmationToken = bin2hex(random_bytes(16));

        // Neuen Benutzer anlegen inklusive Token und confirmed = 0
        $this->userModel->createUser($email, $hashedPassword, $confirmationToken);

        // E-Mail-Bestätigung senden
        $this->sendConfirmationEmail($email, $confirmationToken);
    }

    /**
     * Versendet eine Bestätigungs-E-Mail an den Benutzer.
     *
     * @param string $email
     * @param string $token
     */
    private function sendConfirmationEmail(string $email, string $token): void
    {
        // Hinweis: Für den produktiven Einsatz sollte ein robustes Mail-Framework (z.B. PHPMailer) verwendet werden.
        $subject = 'Bitte bestätigen Sie Ihre E-Mail-Adresse';
        // Die URL muss an Deine Domain und Pfade angepasst werden.
        $confirmationLink = 'http://' . $_SERVER['HTTP_HOST'] . '/confirm.php?token=' . $token;
        $message = "Hallo,\n\nbitte bestätigen Sie Ihre E-Mail-Adresse, indem Sie auf den folgenden Link klicken:\n\n" . $confirmationLink . "\n\nVielen Dank!";
        $headers = 'From: no-reply@deinedomain.de' . "\r\n" .
            'Reply-To: no-reply@deinedomain.de' . "\r\n" .
            'X-Mailer: PHP/' . PHP_VERSION;

        // Einfaches Versenden via mail() – in der Entwicklung genügt das oft
        mail($email, $subject, $message, $headers);
    }
}
