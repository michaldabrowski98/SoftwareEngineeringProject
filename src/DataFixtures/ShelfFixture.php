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
        for ($i=1; $i<10; $i++)
        {
            $manager->persist($this->getShelf($i));
        }

        $manager->flush();
    }

    private function getShelf(int $level): Shelf
    {
        $shelf = new Shelf(
            1,
            $level,
            1,
            500
        );
        $shelf->setQuantity(rand(1,10));
        $shelf->setProduct($this->productRepository->findOneBy(['id' => rand(1, 15)]));

        return $shelf;
    }

    public static function getGroups(): array
    {
        return ['group1', 'group2'];
    }
}
