<?php

namespace App\Builder;

use App\DTO\AlleyDTO;
use App\DTO\ColumnDTO;
use App\DTO\ShelfDTO;
use App\Entity\Shelf;

class AlleyBuilder
{
    private int $shelfCounter = 0;

    public function build(array $shelfs): array
    {
        $alleys = [];
        /** @var Shelf $shelf */
        foreach ($shelfs as $shelf) {
            $alleyNum = $shelf->getAlley();
            $alley = new AlleyDTO();
            $alley->setAlleyNum($alleyNum);
            $columns = $this->getColumns($shelfs, $alleyNum);
            $alley->setColumns(array_values($columns));
            $alley->setShelfCount($this->shelfCounter);
            $alley->setColumnCount(count($columns));
            $alleys[$alleyNum] = $alley;
            $this->shelfCounter = 0;
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
                $column->setShelfs(array_values($this->getShelfsForColumn($shelfs, $columnNum, $alleyNum)));
                $columns[$columnNum] = $column;
            }
        }

        return $columns;
    }

    private function getShelfsForColumn(array $shelfs, int $columnNum, int $alleyNum): array
    {
        $shelfDTOs = [];
        $this->shelfCounter = 0;
        foreach ($shelfs as $shelf) {
            if ($alleyNum === $shelf->getAlley()) {
                $this->shelfCounter++;
            }
            /** @var Shelf $shelf */
            if ($columnNum === $shelf->getCol() && $alleyNum === $shelf->getAlley()) {
                $shelfDTO = new ShelfDTO();
                $shelfDTO->setId($shelf->getId());
                $shelfDTO->setShelfNumber($shelf->getLevel());
                $shelfDTO->setQuantity($shelf->getQuantity());
                $shelfDTO->setMaxWeight($shelf->getMaxWeight());
                $shelfDTOs[$shelf->getId()] = $shelfDTO;
            }
        }

        return $shelfDTOs;
    }
}
