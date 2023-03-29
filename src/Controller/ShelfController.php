<?php

namespace App\Controller;

use App\Service\AuthenticationChecker;
use App\Service\ShelfService;
use App\Traits\AuthenticationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ShelfController extends AbstractController
{
    use AuthenticationCheckerTrait;

    private AuthenticationChecker $authenticationChecker;

    private ShelfService $shelfService;

    public function __construct(
        AuthenticationChecker $authenticationChecker,
        ShelfService $shelfService
    ) {
        $this->authenticationChecker = $authenticationChecker;
        $this->shelfService = $shelfService;
    }

    #[Route('/api/warehouse/scheme', name: 'api_warehouse_scheme', methods: ["GET"])]
    public function getWarehouseSchemeAction(): JsonResponse
    {
        if (null !== $invalidAuthentication = $this->isAuthenticationInvalid()) {
            return $invalidAuthentication;
        }

        return new JsonResponse($this->shelfService->getWarehouseScheme());
    }
}
