<?php

namespace App\Repository;

use App\Interfaces\UserRepositoryInterface;
use App\Entity\User;
use DateTime;
use PDO;

class UserRepository implements UserRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByToken(string $token): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE token = ? AND expires_at > NOW()');
        $stmt->execute([$token]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        return $this->mapToUser($result);
    }

    public function save(User $user): void
    {
        if ($user->getId() === null) {
            // Вставка нового пользователя
            $stmt = $this->pdo->prepare('INSERT INTO users (username, phone, token, expires_at) VALUES (?, ?, ?, ?)');
            $stmt->execute([$user->getUsername(), $user->getPhone(), $user->getToken(), $user->getExpiresAt()->format('Y-m-d H:i:s')]);

            // Получение последнего вставленного ID
            $userId = $this->pdo->lastInsertId();
            $user->setId((int) $userId);
        } else {
            // Обновление существующего пользователя
            $stmt = $this->pdo->prepare('UPDATE users SET username = ?, phone = ?, token = ?, expires_at = ? WHERE id = ?');
            $stmt->execute([$user->getUsername(), $user->getPhone(), $user->getToken(), $user->getExpiresAt()->format('Y-m-d H:i:s'), $user->getId()]);
        }
    }


    public function update(User $user): void
    {
        $stmt = $this->pdo->prepare('UPDATE users SET token = ?, expires_at = ? WHERE id = ?');
        $stmt->execute([
            $user->getToken(),
            $user->getExpiresAt()->format('Y-m-d H:i:s'),
            $user->getId()
        ]);
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        return $this->mapToUser($result);
    }

    /**
     * @throws \DateMalformedStringException
     */
    private function mapToUser(array $data): User
    {
        return new User(
            (int) $data['id'],
            $data['username'],
            $data['phone'],
            $data['token'],
            new DateTime($data['expires_at'])
        );
    }
}
