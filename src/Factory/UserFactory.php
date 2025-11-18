<?php

namespace App\Factory;

use App\Entity\User;

class UserFactory
{
    public function create(string $email, array $roles = ['ROLE_USER']): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setRoles($roles);

        return $user;
    }
}
