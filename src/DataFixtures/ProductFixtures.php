<?php

namespace App\DataFixtures;

use App\Entity\Product;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $prodcut = new Product();
        $prodcut->setName('Tomatoes');
        $prodcut->setCategory('Roma');
        $prodcut->setDescription('The best one');
        $prodcut->setPrice(3.5);

        $manager->persist($prodcut);
        $manager->flush();
    }
}
