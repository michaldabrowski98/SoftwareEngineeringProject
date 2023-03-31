<?php

namespace App\Service;

use App\Builder\AlleyBuilder;
use App\Repository\ShelfRepository;

class ShelfService
{
    private ShelfRepository $shelfRepository;

    private AlleyBuilder $alleyBuilder;

    public function __construct(
        ShelfRepository $shelfRepository,
        AlleyBuilder $alleyBuilder
    ) {
        $this->shelfRepository = $shelfRepository;
        $this->alleyBuilder = $alleyBuilder;
    }

    public function getWarehouseScheme(): array
    {
        $allShelfs = $this->shelfRepository->findAll();
        return $this->alleyBuilder->build($allShelfs);
    }
}
