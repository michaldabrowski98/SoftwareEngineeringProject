<?php

namespace App\DTO;

class ShelfFoundDTO implements \JsonSerializable
{
    private int $shelfId;
    private int $alley;
    private int $column;
    private int $shelf;
    private ?int $productId = null;

    private ?int $quantity = null;

    public function __construct(
        int $shelfId,
        int $alley,
        int $column,
        int $shelf,
        ?int $productId,
        ?int $quantity
    ) {
        $this->shelfId = $shelfId;
        $this->alley = $alley;
        $this->column = $column;
        $this->shelf = $shelf;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public function getShelfId(): int
    {
        return $this->shelfId;
    }

    public function getAlley(): int
    {
        return $this->alley;
    }

    public function getColumn(): int
    {
        return $this->column;
    }

    public function getShelf(): int
    {
        return $this->shelf;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function jsonSerialize(): array
    {
        return [
            'shelfId' => $this->getShelfId(),
            'alley' =>  $this->getAlley(),
            'column' => $this->getColumn(),
            'shelf' => $this->getShelf(),
            'productId' => $this->getProductId(),
            'quantity' => $this->getQuantity(),
        ];
    }
}
