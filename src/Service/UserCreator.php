<?php

namespace App\Service;

use App\Entity\User;
use App\Enum\UserRoleInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreator
{
    public function getUserEntity(
        UserPasswordHasherInterface $passwordHasher,
        string $plaintextPassword,
        string $email,
        mixed $decoded
    ): User {
        $user = new User();
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $user->setEmail($email);
        $user->setFirstName($decoded->firstName);
        $user->setLastName($decoded->lastName);
        $user->setCreatedAt(new \DateTimeImmutable('NOW'));
        $user->setActive(true);
        $user->setRoles($this->getRoleNames($decoded->roles));

        return $user;
    }

    private function getRoleNames(array $roles): array
    {
        return array_map(
            fn($role) => UserRoleInterface::USER_ROLES[$role],
            $roles
        );
    }
}