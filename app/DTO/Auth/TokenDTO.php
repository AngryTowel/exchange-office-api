<?php

namespace App\DTO\Auth;

use App\DTO\Interfaces\DTOInterface;
use App\Models\User;
use App\Traits\Api\DTOTrait;

final readonly class TokenDTO implements DTOInterface
{
    use DTOTrait;

    public readonly User $user;
    public readonly string $token;

}
