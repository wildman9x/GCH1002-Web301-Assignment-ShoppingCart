<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setProductID('P01');
        $product->setCatID($this->getReference('C01'));
        $product->setName('Handmade Double Layered Wax Cow Leather Apple Watch Bands');
        $product->setPrice(30.00);
        $product->setInfo('Material: 100% genuine wax cowhide imported from Italy.
         Completely handmade with skillful hands, each needlepoint only shows the enthusiasm of the leather artisan on his work, providing the best user experience.');
        $manager->persist($product);

        $product = new Product();
        $product->setProductID('P02');
        $product->setCatID($this->getReference('C01'));
        $product->setName('Handmade Double Layered Wax Cow Leather Apple Watch Bands');
        $product->setPrice(35.00);
        $product->setInfo('Material: 100% genuine wax cowhide imported from Italy.
         Completely handmade with skillful hands, each needlepoint only shows the enthusiasm of the leather artisan on his work, providing the best user experience.');
        $manager->persist($product);

        $manager->flush();
    }
}
