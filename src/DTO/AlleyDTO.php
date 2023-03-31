<?php

namespace App\DTO;

class AlleyDTO implements \JsonSerializable
{
    private int $alleyNum;

    private int $columnCount;

    private int $shelfCount;

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

    public function getColumnCount(): int
    {
        return $this->columnCount;
    }

    public function setColumnCount(int $columnCount): void
    {
        $this->columnCount = $columnCount;
    }

    public function getShelfCount(): int
    {
        return $this->shelfCount;
    }

    public function setShelfCount(int $shelfCount): void
    {
        $this->shelfCount = $shelfCount;
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
            'columnCount' => $this->getColumnCount(),
            'shelfCount' => $this->getShelfCount(),
            'columns' => $this->getColumns(),
        ];
    }
}
