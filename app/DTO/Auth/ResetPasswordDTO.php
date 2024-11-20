<?php

namespace App\DTO\Auth;

use App\DTO\Interfaces\DTOInterface;
use App\Traits\Api\DTOTrait;

final readonly class ResetPasswordDTO implements DTOInterface
{
    use DTOTrait;
    public readonly string $token;
    public readonly string $password;
}
