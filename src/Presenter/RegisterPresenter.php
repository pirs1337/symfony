<?php

namespace App\Presenter;

use App\DTO\RegisterDTO;
use App\DTO\UserDTO;
use App\Entity\User;

final class RegisterPresenter
{
    public function create(User $user, string $token): RegisterDTO
    {
        $userDTO = UserDTO::create($user);

        return RegisterDTO::create($userDTO, $token);
    }
}
