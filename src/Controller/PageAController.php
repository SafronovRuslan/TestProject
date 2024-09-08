<?php

namespace App\Controller;

use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\HistoryRepositoryInterface;
use App\Entity\User;
use DateTime;
use Random\RandomException;

class PageAController
{
    private const WINNING_THRESHOLDS = [
        900 => 0.7,
        600 => 0.5,
        300 => 0.3,
        0 => 0.1
    ];

    private UserRepositoryInterface $userRepository;
    private HistoryRepositoryInterface $historyRepository;

    public function __construct(UserRepositoryInterface $userRepository, HistoryRepositoryInterface $historyRepository)
    {
        $this->userRepository = $userRepository;
        $this->historyRepository = $historyRepository;
    }

    public function checkToken(string $token): ?User
    {
        return $this->userRepository->findByToken($token);
    }

    public function generateRandomNumber(): array
    {
        $randomNumber = rand(1, 1000);
        $result = ($randomNumber % 2 === 0) ? 'Win' : 'Lose';
        $winAmount = $this->calculateWinAmount($randomNumber);

        return [
            'number' => $randomNumber,
            'result' => $result,
            'win' => $result === 'Win' ? $winAmount : 0
        ];
    }

    private function calculateWinAmount(int $randomNumber): float
    {
        foreach (self::WINNING_THRESHOLDS as $threshold => $multiplier) {
            if ($randomNumber > $threshold) {
                return $randomNumber * $multiplier;
            }
        }
        return 0;
    }

    public function saveHistory(int $userId, int $randomNumber, string $result, float $winAmount): void
    {
        $this->historyRepository->save($userId, $randomNumber, $result, $winAmount);
    }

    /**
     * @throws \DateMalformedStringException
     * @throws RandomException
     */
    public function generateNewLink(User $user): string
    {
        $newToken = bin2hex(random_bytes(16));
        $newExpiresAt = (new DateTime())->modify('+7 days');
        $user->setToken($newToken);
        $user->setExpiresAt($newExpiresAt);
        $this->userRepository->update($user);

        return 'http://ath.local/?token=' . $newToken;
    }

    public function deactivateLink(User $user): void
    {
        $user->setExpiresAt((new DateTime()));
        $this->userRepository->update($user);
    }

    public function getHistory(int $userId): array
    {
        return $this->historyRepository->getLastThreeHistory($userId);
    }
}
