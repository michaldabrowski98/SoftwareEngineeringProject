<?php

namespace App\Controller;

use App\Service\AuthenticationChecker;
use App\Traits\AuthenticationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    use AuthenticationCheckerTrait;

    private AuthenticationChecker $authenticationChecker;

    public function __construct(AuthenticationChecker $authenticationChecker)
    {
        $this->authenticationChecker = $authenticationChecker;
    }

    #[Route('/home/page', name: 'app_home_page')]
    public function index(): JsonResponse
    {
        if (null !== $invalidAuthentication = $this->isAuthenticationInvalid()) {
            return $invalidAuthentication;
        }

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/HomePageController.php',
        ]);
    }
}
