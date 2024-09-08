<?php

namespace App\Interfaces;

interface HistoryRepositoryInterface
{
    public function save(int $userId, int $randomNumber, string $result, float $winAmount): void;
    public function findByUserId(int $userId): array; // Добавленный метод
}
