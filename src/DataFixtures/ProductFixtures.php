<?php

namespace App\DataFixtures;


use App\Entity\Product;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
//            $category = new $this->getReference('categoryshop_' . rand(1, 5));
            $product = new Product();
            $product->setTitle($faker->sentence( 4,  true));
            $product->setSlug($faker->slug);
            $product->setOnline(true);
            $product->setContent($faker->text( 200));
            $product->setPrice($faker->randomFloat(2, 5, 200));
            $product->setSubtitle($faker->text(255));
            $product->setCreatedAt(new DateTime('now'));
            $product->setAttachment($faker->imageUrl(640, 480, 'animals', true));
            $product->setCategory($this->getReference('categoryshop_' . rand(1, 5)));

            $manager->persist($product);
        }

        $manager->flush();
    }

}