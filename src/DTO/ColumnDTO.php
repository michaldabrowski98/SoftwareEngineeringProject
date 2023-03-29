<?php

namespace App\DTO;

class ColumnDTO implements \JsonSerializable
{
    private int $colNumber;

    /**
     * @var ShelfDTO[] $shelfs
     */
    private array $shelfs;

    public function getColNumber(): int
    {
        return $this->colNumber;
    }

    public function setColNumber(int $colNumber): void
    {
        $this->colNumber = $colNumber;
    }

    public function getShelfs(): array
    {
        return $this->shelfs;
    }

    public function setShelfs(array $shelfs): void
    {
        $this->shelfs = $shelfs;
    }

    public function jsonSerialize(): array
    {
        return [
            'colNumber' => $this->getColNumber(),
            'shelfs' => $this->getShelfs()
        ];
    }
}
