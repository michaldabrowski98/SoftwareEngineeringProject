<?php

namespace App\Service;

use App\DTO\UserDTO;
use Symfony\Component\Security\Core\User\UserInterface;

class UserService
{
    public function getUserDTO(UserInterface $user): UserDTO
    {
        return new UserDTO(
            $user->getEmail(),
            sprintf('%s %s', $user->getFirstName(), $user->getLastName()),
            $user->getCreatedAt()
        );
    }
}
