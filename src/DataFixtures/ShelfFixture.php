<?php

namespace App\DataFixtures;

use App\Entity\Shelf;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ShelfFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i<10; $i++)
        {
            $manager->persist($this->getShelf($i));
        }

        $manager->flush();
    }

    private function getShelf(int $level): Shelf
    {
        $shelf = new Shelf();
        $shelf->setAlley(1);
        $shelf->setLevel($level);
        $shelf->setCol(1);
        $shelf->setMaxWeight(500);

        return $shelf;
    }
}
