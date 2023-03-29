<?php

namespace App\DTO;

class AlleyDTO implements \JsonSerializable
{
    private int $alleyNum;

    /**
     * @var ColumnDTO[] $columns
     */
    private array $columns;

    public function getAlleyNum(): int
    {
        return $this->alleyNum;
    }

    public function setAlleyNum(int $alleyNum): void
    {
        $this->alleyNum = $alleyNum;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }

    public function jsonSerialize(): array
    {
        return [
            'alleyNum' => $this->getAlleyNum(),
            'columns' => $this->getColumns(),
        ];
    }
}
