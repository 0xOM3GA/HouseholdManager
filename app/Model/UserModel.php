<?php

declare(strict_types=1);

namespace App\Model;

use PDO;

class UserModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Prüft, ob die E-Mail bereits existiert.
     *
     * @param string $email
     * @return bool
     */
    public function existsByEmail(string $email): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM user WHERE email = :email');
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Legt einen neuen Benutzer an und speichert den Bestätigungstoken.
     *
     * @param string $email
     * @param string $hashedPassword
     * @param string $confirmationToken
     * @return int Die ID des neuen Benutzers.
     */
    public function createUser(string $email, string $hashedPassword, string $confirmationToken): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO user (email, password, confirmation_token, confirmed) VALUES (:email, :password, :confirmation_token, 0)'
        );
        $stmt->execute([
            ':email'              => $email,
            ':password'           => $hashedPassword,
            ':confirmation_token' => $confirmationToken,
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Liest einen Benutzer anhand der E-Mail-Adresse aus.
     *
     * @param string $email
     * @return array|null
     */
    public function getUserByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }
}
