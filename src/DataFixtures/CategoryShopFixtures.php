<?php

namespace App\DataFixtures;

use App\Entity\CategoryShop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryShopFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create 6 categories! Bam!
        $c = [
            1=>[
                'name'=>'T-shirt',
                'slug'=>'t-shirt',
                'description'=>'T-shirt',
            ],
            2=>[
                'name'=>'Pants',
                'slug'=>'pants',
                'description'=>'Pants',
            ],
            3=>[
                'name'=>'Outerwear',
                'slug'=>'outerwear',
                'description'=>'Outerwear',
            ],
            4=>[
                'name'=>'Shirt',
                'slug'=>'shirt',
                'description'=>'Shirt',
            ],
            5=>[
                'name'=>'Bag',
                'slug'=>'bag',
                'description'=>'Bag',
            ],
        ];

        foreach ($c as $key => $value){
            $category = new CategoryShop();
            $category->setName($value['name']);
            $category->setSlug($value['slug']);
            $category->setDescription($value['description']);
            $manager->persist($category);

            $this->addReference('categoryshop_' . $key, $category);
        }

        $manager->flush();
    }
}