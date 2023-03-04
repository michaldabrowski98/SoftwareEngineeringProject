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
        for($i = 0; $i < 30; $i++) {
            $manager->persist($this->createProduct());
        }

        $manager->flush();
    }

    private function createProduct(): Product
    {
        return new Product(
            $this->faker->streetName(),
            $this->faker->sentence(),
            $this->faker->randomFloat()
        );
    }
}
