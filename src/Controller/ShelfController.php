<?php

namespace App\Controller;

use App\DTO\AddProductToShelfDTO;
use App\Finder\ShelfFinder;
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

    private ShelfFinder $shelfFinder;

    public function __construct(
        AuthenticationChecker $authenticationChecker,
        ShelfService $shelfService,
        ShelfCreator $shelfCreator,
        ShelfFinder $shelfFinder
    ) {
        $this->authenticationChecker = $authenticationChecker;
        $this->shelfService = $shelfService;
        $this->shelfCreator = $shelfCreator;
        $this->shelfFinder = $shelfFinder;
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

    #[Route('/api/warehouse/remove/alley', name: 'api_warehouse_remove_alley', methods: ["POST"])]
    public function removeAlleyAction(Request $request): JsonResponse
    {
        $alley = json_decode($request->getContent(), true)['alley'] ?? null;

        if (null === $alley) {
            return new JsonResponse(['message' => 'error'], 401);
        }

        try {
            $this->shelfService->removeAlley((int) $alley);
        } catch(\Exception $e) {
            return new JsonResponse(['message' => 'error'], 401);
        }

        return new JsonResponse(['message' => 'success']);
    }

    #[Route('/api/warehouse/remove/shelf', name: 'api_warehouse_remove_shelf', methods: ["POST"])]
    public function removeShelfAction(Request $request): JsonResponse
    {
        $shelfId = json_decode($request->getContent(), true)['shelfId'] ?? null;

        if (null === $shelfId) {
            return new JsonResponse(['message' => 'error'], 401);
        }

        try {
            $this->shelfService->removeShelf((int) $shelfId);
        } catch(\Exception $e) {
            return new JsonResponse(['message' => 'error'], 401);
        }

        return new JsonResponse(['message' => 'success']);
    }

    #[Route('/api/shelf/find', name: 'api_shelf_find', methods: ["GET"])]
    public function findAvailableShelfsAction(Request $request): JsonResponse
    {
        if (null !== $invalidAuthentication = $this->isAuthenticationInvalid()) {
            return $invalidAuthentication;
        }

        $requestContent = json_decode($request->getContent(), true);

        return new JsonResponse(
            $this->shelfFinder->findShelfsByProductIdAndQuantity(
                (int) $requestContent['productId'],
                (int) $requestContent['quantity']
            )
        );
    }

    #[Route('/api/shelf/find/position', name: 'api_shelf_find_position', methods: ["GET"])]
    public function findShelfPositionAction(Request $request): JsonResponse
    {
        if (null !== $invalidAuthentication = $this->isAuthenticationInvalid()) {
            return $invalidAuthentication;
        }

//        dd(json_decode($request->get('products'), true));
        $products = json_decode($request->get('products'), true);
        return new JsonResponse(
            $this->shelfFinder->findShelfsPositionsByQuantity(
                $products
            )
        );
    }

    #[Route('/api/shelf/save', name: 'api_shelf_save', methods: ["PUT"])]
    public function saveChosenShelfsAction(Request $request): JsonResponse
    {
        if (null !== $invalidAuthentication = $this->isAuthenticationInvalid()) {
            return $invalidAuthentication;
        }

        $requestContent = json_decode($request->getContent(), true);

        try {
            $this->shelfService->saveShelfs($requestContent);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false], 500);
        }

        return new JsonResponse(['success' => true]);
    }

    #[Route('/api/shelf/remove', name: 'api_shelf_remove', methods: ["PUT"])]
    public function removeChosenProductsFromShelfsAction(Request $request): JsonResponse
    {
        if (null !== $invalidAuthentication = $this->isAuthenticationInvalid()) {
            return $invalidAuthentication;
        }

        $requestContent = json_decode($request->getContent(), true);

        try {
            $this->shelfService->removeShelfs($requestContent['shelfs']);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false], 500);
        }

        return new JsonResponse(['success' => true]);
    }
    #[Route('/api/shelf/addProduct', name: 'api_warehouse_shelf_add_product', methods: ["POST"])]
    public function addProductToShelf(Request $request): JsonResponse
    {
        if (null !== $invalidAuthentication = $this->isAuthenticationInvalid()) {
            return $invalidAuthentication;
        }

        $addProductToShelfDTO = $this->addProductToShelfDTO(json_decode($request->getContent(), true));
        $this->shelfService->addProductToShelf($addProductToShelfDTO);
        return new JsonResponse();
    }

    private function addProductToShelfDTO(array $array): AddProductToShelfDTO
    {
        $dto = new AddProductToShelfDTO();
        $dto->setId((int)$array['id']);
        $dto->setWeight((float)$array['weight']);
        $dto->setTotalWeight((float)$array['totalWeight']);
        $dto->setQuantity((int)$array['quantity']);
        return $dto;
    }
}
