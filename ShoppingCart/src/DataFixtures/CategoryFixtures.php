<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setCatId('C01');
        $category->setName('Leather crafts');
        $category->setDescription('Handcrafted products are 100% handmade by skilled craftsmen. Product material is 100% animal skin. Friendly and safe');
        $manager->persist($category);
        $category = new Category();
        $category->setCatId('C02');
        $category->setName('Bamboo');
        $category->setDescription('Products are 100% handmade by skilled craftsmen. Product material is 100% bamboo, rattan. Friendly and safe');
        $manager->persist($category);
        $manager->flush();
        $manager->flush();
    }
}
