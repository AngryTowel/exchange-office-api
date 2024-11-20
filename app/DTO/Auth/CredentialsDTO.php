<?php

namespace App\DTO\Auth;

use App\DTO\Interfaces\DTOInterface;
use App\Traits\Api\DTOTrait;

final readonly class CredentialsDTO implements DTOInterface
{
    use DTOTrait;
    public readonly string $email;
    public readonly string $password;
}
