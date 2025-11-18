<?php

namespace App\DTO;

use Symfony\Component\Serializer\Attribute\Groups;

final class RegisterDTO
{
    #[Groups(['auth:register'])]
    public UserDTO $user;

    #[Groups(['auth:register'])]
    public string $token;

    public static function create(UserDTO $userDTO, string $token): self
    {
        $dto = new self();
        $dto->user = $userDTO;
        $dto->token = $token;

        return $dto;
    }
}
