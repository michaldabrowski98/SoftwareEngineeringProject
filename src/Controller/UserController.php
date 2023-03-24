<?php

namespace App\Controller;

use App\Service\AuthenticationChecker;
use App\Service\UserService;
use App\Traits\AuthenticationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{
    use AuthenticationCheckerTrait;

    private UserService $userService;

    private AuthenticationChecker $authenticationChecker;

    private Security $security;

    public function __construct(
        UserService $userService,
        AuthenticationChecker $authenticationChecker,
        Security $security,
    ) {
        $this->userService = $userService;
        $this->authenticationChecker = $authenticationChecker;
        $this->security = $security;
    }

    #[Route('/api/user/data', name: 'api_user_data', methods: ["GET"])]
    public function userDataAction(Request $request): JsonResponse
    {
        if (null !== $invalidAuthentication = $this->isAuthenticationInvalid()) {
            return $invalidAuthentication;
        }

        return new JsonResponse($this->userService->getUserDTO($this->security->getUser()));
    }
}
