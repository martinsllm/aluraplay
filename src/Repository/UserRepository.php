<?php

namespace Alura\Mvc\Repository;

use PDO;

class UserRepository {

    public function __construct(private PDO $pdo) {

    }

    public function fetchUserByEmail(string $email): array|false {
        $statement = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $statement->bindValue(':email', $email);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword(string $id, string $newHash): void {
        $statement = $this->pdo->prepare('UPDATE users SET password = :password WHERE id = :id');
        $statement->bindValue(':password', $newHash);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }
}