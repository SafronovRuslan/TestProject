<?php

namespace App\Entity;

class History
{
    private int $id;
    private int $userId;
    private int $randomNumber;
    private string $result;
    private float $winAmount;

    public function __construct(int $id, int $userId, int $randomNumber, string $result, float $winAmount)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->randomNumber = $randomNumber;
        $this->result = $result;
        $this->winAmount = $winAmount;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'random_number' => $this->randomNumber,
            'result' => $this->result,
            'win_amount' => $this->winAmount,
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getRandomNumber(): int
    {
        return $this->randomNumber;
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function getWinAmount(): float
    {
        return $this->winAmount;
    }
}
