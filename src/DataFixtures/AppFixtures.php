<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        protected readonly UserFactory $userFactory,
        protected readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userFactory->create('test@mail.ru');
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'password'));

        $manager->persist($user);

        $manager->flush();
    }
}
