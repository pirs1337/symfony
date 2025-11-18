<?php

namespace App\Service;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        protected readonly UserRepository $userRepository,
        protected readonly UserPasswordHasherInterface $passwordHasher,
        protected readonly UserFactory $userFactory,
    ) {
    }

    public function create(string $email, string $plainPassword): User
    {
        $user = $this->userFactory->create($email);

        $hashedPassword = $this->passwordHasher->hashPassword(
            user: $user,
            plainPassword: $plainPassword,
        );

        $user->setPassword($hashedPassword);

        return $this->userRepository->create($user);
    }
}
