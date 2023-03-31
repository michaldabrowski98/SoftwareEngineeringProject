<?php

namespace App\Service;

use App\Entity\Shelf;
use App\Repository\ShelfRepository;
use Doctrine\ORM\EntityManagerInterface;

class ShelfCreator
{
    private ShelfRepository $shelfRepository;

    private EntityManagerInterface $entityManager;

    public function __construct(
        ShelfRepository $shelfRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->shelfRepository = $shelfRepository;
        $this->entityManager = $entityManager;
    }

    public function createShelfs(int $columnsNumber, int $shelfsNumber, float $maxWeight): void
    {
        $alleyNumber = $this->shelfRepository->getLastAlleyNumber() + 1;

        for ($i = 1; $i <= $columnsNumber; $i++) {
            for ($j = 1; $j <= $shelfsNumber; $j++) {
                $shelfEntity = new Shelf(
                    $alleyNumber,
                    $j,
                    $i,
                    $maxWeight
                );
                $this->entityManager->persist($shelfEntity);
            }
        }

        $this->entityManager->flush();
    }
}
