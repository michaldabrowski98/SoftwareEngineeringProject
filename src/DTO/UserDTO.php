<?php

namespace App\DTO;

class UserDTO implements \JsonSerializable
{
    private string $email;

    private string $name;

    private \DateTimeImmutable $createdAt;

    public function __construct(
        string $email,
        string $name,
        \DateTimeImmutable $createdAt
    ) {
        $this->email = $email;
        $this->name = $name;
        $this->createdAt = $createdAt;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function jsonSerialize(): array
    {
        return [
            'email' => $this->getEmail(),
            'name' => $this->getName(),
            'createdAt' => $this->getCreatedAt(),
        ];
    }
}
