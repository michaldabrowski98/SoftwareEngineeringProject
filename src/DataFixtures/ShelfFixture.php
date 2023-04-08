<?php

namespace App\DataFixtures;

use App\Entity\Shelf;
use App\Repository\ProductRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ShelfFixture extends Fixture implements FixtureGroupInterface
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function load(ObjectManager $manager): void
    {
        for ($j = 1; $j < 3; $j++) {
            for ($k = 1; $k < 5; $k++) {
                for ($i = 1; $i <= 10; $i++) {
                    $manager->persist($this->getShelf($j, $i, $k));
                }
            }
        }

        $manager->flush();
    }

    private function getShelf(int $alley, int $level, int $col): Shelf
    {
        return new Shelf($alley, $level, $col, 500);
    }

    public static function getGroups(): array
    {
        return ['group1', 'group2'];
    }
}