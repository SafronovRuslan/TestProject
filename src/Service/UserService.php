<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(string $username, string $phone): User
    {
        $token = bin2hex(random_bytes(16));
        $expiresAt = new \DateTime('+7 days');

        $user = new User(null, $username, $phone, $token, $expiresAt);
        $this->userRepository->save($user);

        return $user;
    }

    public function findByToken(string $token): ?User
    {
        return $this->userRepository->findByToken($token);
    }

    public function generateNewLink(User $user): string
    {
        $newToken = bin2hex(random_bytes(16));
        $expiresAt = new \DateTime('+7 days');
        $this->userRepository->updateToken($user, $newToken, $expiresAt);

        return 'http://ath.local/?token=' . $newToken;
    }
}
