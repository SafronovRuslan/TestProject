<?php

namespace App\Controller;

use App\Interfaces\UserRepositoryInterface;
use App\Service\UserService;


class RegistrationController
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser(string $username, string $phone): string
    {
        // Проверка корректности номера телефона
        if (!preg_match('/^\d{10}$/', $phone)) {
            throw new \InvalidArgumentException('Номер телефона должен содержать 10 цифр.');
        }

        $userService = new UserService($this->userRepository);
        $user = $userService->createUser($username, $phone);

        return 'http://ath.local/?token=' . $user->getToken();
    }
}

