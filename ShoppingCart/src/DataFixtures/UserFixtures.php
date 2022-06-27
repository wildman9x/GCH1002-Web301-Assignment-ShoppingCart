<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        // add an admin user with admin@admin.com and password admin
        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setPassword('admin');
        $user->setRoles(['ROLE_ADMIN']);
        
        $manager->flush();
    }
}
