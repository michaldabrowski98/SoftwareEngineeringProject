<?php

namespace App\Controller;

use App\DTO\AddProductToShelfDTO;
use App\Service\AuthenticationChecker;
use App\Service\ShelfCreator;
use App\Service\ShelfService;
use App\Traits\AuthenticationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShelfController extends AbstractController
{
    use AuthenticationCheckerTrait;

    private AuthenticationChecker $authenticationChecker;

    private ShelfService $shelfService;

    private ShelfCreator $shelfCreator;

    public function __construct(
        AuthenticationChecker $authenticationChecker,
        ShelfService $shelfService,
        ShelfCreator $shelfCreator
    ) {
        $this->authenticationChecker = $authenticationChecker;
        $this->shelfService = $shelfService;
        $this->shelfCreator = $shelfCreator;
    }

    #[Route('/api/warehouse/scheme', name: 'api_warehouse_scheme', methods: ["GET"])]
    public function getWarehouseSchemeAction(): JsonResponse
    {
        if (null !== $invalidAuthentication = $this->isAuthenticationInvalid()) {
            return $invalidAuthentication;
        }

        return new JsonResponse($this->shelfService->getWarehouseScheme());
    }

    #[Route('/api/warehouse/new/alley', name: 'api_warehouse_new_alley', methods: ["PUT"])]
    public function newAlleyAction(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $this->shelfCreator->createShelfs(
                (int) $data['colNum'],
                (int) $data['shelfNum'],
                (float) $data['maxWeight']
            );
        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'error'], 401);
        }

        return new JsonResponse(['message' => 'success']);
    }

    #[Route('/api/warehouse/remove/alley', name: 'api_warehouse_new_alley', methods: ["DELETE"])]
    public function removeAlleyAction(Request $request): JsonResponse
    {
        return new JsonResponse(['message' => 'success']);
    }

    #[Route('/api/shelf/addProduct', name: 'api_warehouse_shelf_add_product', methods: ["POST"])]
    public function addProductToShelf (Request $request): JsonResponse
    {
        if (null !== $invalidAuthentication = $this->isAuthenticationInvalid()) {
            return $invalidAuthentication;
        }

        $addProductToShelfDTO = $this->addProductToShelfDTO(json_decode($request->getContent(), true));
        $this->shelfService->addProductToShelf($addProductToShelfDTO);
        return new JsonResponse("DUPA");
    }

    private function addProductToShelfDTO(array $array): AddProductToShelfDTO
    {
        return  new AddProductToShelfDTO(
            (int) $array['id'],
            (float) $array['weight'],
            (float) $array['totalWeight'],
            (int) $array['quantity']
        );
    }
}
