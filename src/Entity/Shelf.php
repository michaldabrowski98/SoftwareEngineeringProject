<?php

namespace App\Entity;

use App\Repository\ShelfRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShelfRepository::class)]
class Shelf
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private int $alley;

    #[ORM\Column]
    private int $level;

    #[ORM\Column]
    private int $col;

    #[ORM\Column]
    private float $maxWeight;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'shelves')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    private ?Product $product = null;

    public function __construct(int $alley, int $level, int $col, float $maxWeight)
    {
        $this->alley = $alley;
        $this->level = $level;
        $this->col = $col;
        $this->maxWeight = $maxWeight;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAlley(): int
    {
        return $this->alley;
    }

    public function setAlley(int $alley): void
    {
        $this->alley = $alley;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    public function getCol(): int
    {
        return $this->col;
    }

    public function setCol(int $col): void
    {
        $this->col = $col;
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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }

}