<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixture extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 30; $i++) {
             $manager->persist($this->getProductFixture());
        }

        $manager->flush();
    }

    private function getProductFixture(): Product
    {
        return new Product(
            $this->faker->streetName(),
            $this->faker->sentence(),
            $this->faker->randomFloat(),
            (string) $this->faker->numberBetween(10, 4567)
        );
    }
}
