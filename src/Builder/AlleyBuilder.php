<?php

namespace App\Builder;

use App\DTO\AlleyDTO;
use App\DTO\ColumnDTO;
use App\DTO\ShelfDTO;
use App\Entity\Shelf;

class AlleyBuilder
{
    public function build(array $shelfs): array
    {
        $alleys = [];
        /** @var Shelf $shelf */
        foreach ($shelfs as $shelf) {
            $alleyNum = $shelf->getAlley();
            $alley = new AlleyDTO();
            $alley->setAlleyNum($alleyNum);
            $alley->setColumns($this->getColumns($shelfs, $alleyNum));
            $alleys[] = $alley;
        }
        return $alleys;
    }

    private function getColumns(array $shelfs, int $alleyNum): array
    {
        $columns = [];
        foreach ($shelfs as $shelf) {
            /** @var Shelf $shelf */
            if ($alleyNum === $shelf->getAlley()) {
                $columnNum = $shelf->getCol();
                $column = new ColumnDTO();
                $column->setColNumber($columnNum);
                $column->setShelfs($this->getShelfsForColumn($shelfs, $columnNum, $alleyNum));
                $columns[] = $column;
            }
        }

        return $columns;
    }

    private function getShelfsForColumn(array $shelfs, int $columnNum, int $alleyNum): array
    {
        $shelfDTOs = [];
        foreach ($shelfs as $shelf) {
            /** @var Shelf $shelf */
            if ($columnNum === $shelf->getCol() && $alleyNum === $shelf->getAlley()) {
                $shelfDTO = new ShelfDTO();
                $shelfDTO->setId($shelf->getId());
                $shelfDTO->setShelfNumber($shelf->getLevel());
                $shelfDTO->setQuantity($shelf->getQuantity());
                $shelfDTO->setMaxWeight($shelf->getMaxWeight());
                $shelfDTOs[] = $shelfDTO;
            }
        }

        return $shelfDTOs;
    }
}
