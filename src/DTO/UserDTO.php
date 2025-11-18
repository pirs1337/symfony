<?php

namespace App\DTO;

use App\Entity\User;
use Symfony\Component\Serializer\Attribute\Groups;

final class UserDTO
{
    #[Groups(['user:read'])]
    public int $id;

    #[Groups(['user:read'])]
    public string $email;

    #[Groups(['user:read'])]
    public array $roles;

    public static function create(User $user): self
    {
        $dto = new self();
        $dto->id = $user->getId();
        $dto->email = $user->getEmail();
        $dto->roles = $user->getRoles();

        return $dto;
    }
}
