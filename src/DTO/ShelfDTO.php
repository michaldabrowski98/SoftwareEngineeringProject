<?php

namespace App\DTO;

class ShelfDTO implements \JsonSerializable
{
    private int $id;

    private int $shelfNumber;

    private float $maxWeight;

    private ?int $quantity = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getShelfNumber(): int
    {
        return $this->shelfNumber;
    }

    public function setShelfNumber(int $shelfNumber): void
    {
        $this->shelfNumber = $shelfNumber;
    }

    public function getMaxWeight(): float
    {
        return $this->maxWeight;
    }

    public function setMaxWeight(float $maxWeight): void
    {
        $this->maxWeight = $maxWeight;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'shelfNumber' => $this->getShelfNumber(),
            'maxWeight' => $this->getMaxWeight(),
            'quantity' => $this->getQuantity(),
        ];
    }
}
