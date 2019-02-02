<?php

namespace App\DataFixtures;

use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
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
    }
}
