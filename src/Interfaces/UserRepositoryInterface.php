<?php

namespace App\Interfaces;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function findByToken(string $token): ?User;

    public function save(User $user): void;

    public function update(User $user): void;

    public function findById(int $id): ?User;
}
