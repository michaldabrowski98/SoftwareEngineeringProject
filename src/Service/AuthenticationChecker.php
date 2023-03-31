<?php

namespace App\Service;

use Symfony\Component\Security\Core\Security;

class AuthenticationChecker
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function check(): bool
    {
        return null !== $this->security->getUser();
    }
}
