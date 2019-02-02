<?php

namespace App\DataFixtures;

use App\Entity\User;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setEmail('admin@admin.com');
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $userAdmin->setPassword($this->passwordEncoder->encodePassword($userAdmin, 'admin'));
        $manager->persist($userAdmin);

        $userProducer = new User();
        $userProducer->setEmail('producer@producer.com');
        $userProducer->setRoles(['ROLE_PRODUCER']);
        $userProducer->setPassword($this->passwordEncoder->encodePassword($userProducer, 'producer'));
        $manager->persist($userProducer);

        $manager->flush();

        $this->addReference('admin-user', $userAdmin);
        $this->addReference('producer-user', $userProducer);
    }

    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}
