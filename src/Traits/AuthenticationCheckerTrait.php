<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;

trait AuthenticationCheckerTrait
{
    public function isAuthenticationInvalid(): ?JsonResponse
    {
        if (!$this->authenticationChecker->check()) {
            return new JsonResponse(
                'Unauthorized user',
                401
            );
        }

        return null;
    }
}