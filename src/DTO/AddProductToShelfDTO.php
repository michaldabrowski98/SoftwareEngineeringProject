<?php

namespace App\DTO;

use Doctrine\DBAL\Types\Types;

class AddProductToShelfDTO implements \JsonSerializable
{
    private int $id;

    private float $weight;

    private float $totalWeight;

    private int $quantity;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    public function getTotalWeight(): float
    {
        return $this->totalWeight;
    }

    public function setTotalWeight(float $totalWeight): void
    {
        $this->totalWeight = $totalWeight;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): void
    {
        $this->quantity = $quantity;
    }



    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'totalWeight' => $this->getTotalWeight(),
            'weight' => $this->getWeight(),
            'quantity' => $this->getQuantity()
        ];
    }
}