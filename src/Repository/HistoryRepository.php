<?php

namespace App\Repository;

use App\Interfaces\HistoryRepositoryInterface;
use App\Entity\History;
use PDO;

class HistoryRepository implements HistoryRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(int $userId, int $randomNumber, string $result, float $winAmount): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO history (user_id, random_number, result, win_amount) VALUES (?, ?, ?, ?)');
        $stmt->execute([$userId, $randomNumber, $result, $winAmount]);
    }

    public function findByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM history WHERE user_id = ?');
        $stmt->execute([$userId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($result) {
            return new History(
                (int) $result['id'],
                (int) $result['user_id'],
                (int) $result['random_number'],
                $result['result'],
                (float) $result['win_amount']
            );
        }, $results);
    }

    public function getLastThreeHistory(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM history WHERE user_id = ? ORDER BY created_at DESC LIMIT 3');
        $stmt->execute([$userId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($result) {
            return new History(
                (int) $result['id'],
                (int) $result['user_id'],
                (int) $result['random_number'],
                $result['result'],
                (float) $result['win_amount']
            );
        }, $results);
    }
}
