<?php

namespace App\Entity;

class User
{
    private ?int $id;
    private string $username;
    private string $phone;
    private string $token;
    private \DateTime $expiresAt;

    public function __construct(?int $id, string $username, string $phone, string $token, \DateTime $expiresAt)
    {
        $this->id = $id;
        $this->username = $username;
        $this->phone = $phone;
        $this->token = $token;
        $this->expiresAt = $expiresAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getExpiresAt(): \DateTime
    {
        return $this->expiresAt;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function setExpiresAt(\DateTime $expiresAt): static
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }
}
