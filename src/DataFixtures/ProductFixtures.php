<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\String\Slugger\SluggerInterface;


class ProductFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger)
    {

    }

    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');

        for($prod = 1; $prod <= 10; $prod++){
            $product = new product();
            $product->setName($faker->text(15));
            $product->setIngredients($faker->text());
            $product->setPrice($faker->numberBetween(900, 1500));
          

            $manager->persist($product);

        }

        $manager->flush();
    }
}