<?php

namespace App\DataFixtures;

use App\Entity\Producer;
use App\DataFixtures\UserFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProducerFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $producer = new Producer();
        $producer->setUser($this->getReference('producer-user'));
        $producer->setName('Marcos');
        $producer->setLastname('Pajares');
        $producer->setName('Marcos');
        $producer->setPhone('621577836');
        $producer->setAddress('6 rue de la liberation');
        $producer->setCp('7347');
        $producer->setCity('Steinsel');
        $producer->setCountry('Luxembourg');

        $manager->flush();
    }

    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}
