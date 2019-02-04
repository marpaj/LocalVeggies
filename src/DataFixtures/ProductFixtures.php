<?php

namespace App\DataFixtures;

use App\Entity\Product;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $nextDistributionDateTime = strtotime("next saturday");
        $secondNextDistributionDatetime = strtotime("+1 weeks", $nextDistributionDateTime);
        $nextDistributionDate = date("l d M Y", $nextDistributionDateTime);
        $secondNextDistributionDate = date("l d M Y", $secondNextDistributionDatetime);

        $product = new Product();
        $product->setName('Tomatoes');
        $product->setCategory('Roma');
        $product->setDescription('Roma tomato or Roma is a plum tomato popularly used both for canning and producing tomato paste because of their slender and firm nature.');
        $product->setPrice(3.5);
        $product->setDistributionDate(date_create($nextDistributionDate));
        $manager->persist($product);

        $product2 = new Product();
        $product2->setName('Potatoes');
        $product2->setCategory('White');
        $product2->setDescription('Compared to russets, white potatoes, such as Onaway and Elba have smoother, thinner and lighter-colored skin. Considered all-purpose potatoes, they are creamy when baked yet hold their texture when boiled. If you don\'t know what potatoes to use in a recipe, you\'ll be safe with white potatoes.');
        $product2->setPrice(2.7);
        $product2->setDistributionDate(date_create($nextDistributionDate));
        $manager->persist($product2);

        $product3 = new Product();
        $product3->setName('Carrots');
        $product3->setCategory('baby');
        $product3->setDescription('The immature roots of the carrot plant are sometimes harvested simply as the result of crop thinning, but are also grown to this size as a specialty crop.');
        $product3->setPrice(3.1);
        $product3->setDistributionDate(date_create($secondNextDistributionDate));
        $manager->persist($product3);


        $manager->flush();
    }
}
