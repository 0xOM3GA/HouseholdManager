<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\RegistrationService;

class RegistrationController
{
    private RegistrationService $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    /**
     * Verarbeitet die Registrierung.
     *
     * @param array $postData POST-Daten des Registrierungsformulars.
     */
    public function register(array $postData): void
    {
        $email           = filter_var($postData['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $password        = $postData['password'] ?? '';
        $confirmPassword = $postData['confirm_password'] ?? '';

        if (!$email) {
            echo 'Ungültige E-Mail-Adresse.';
            return;
        }

        if ($password !== $confirmPassword) {
            echo 'Passwörter stimmen nicht überein.';
            return;
        }

        try {
            $this->registrationService->registerUser($email, $password);
            echo 'Registrierung erfolgreich. Bitte prüfen Sie Ihre E-Mails zur Bestätigung.';
        } catch (\Exception $e) {
            echo 'Registrierung fehlgeschlagen: ' . $e->getMessage();
        }
    }
}
