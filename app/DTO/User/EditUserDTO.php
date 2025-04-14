<?php

namespace App\DTO\User;

use App\DTO\Interfaces\DTOInterface;
use App\Traits\Api\DTOTrait;

final readonly class EditUserDTO implements DTOInterface
{
    use DTOTrait;
    protected readonly ?string $email;
    protected readonly ?string $first_name;
    protected readonly ?string $last_name;
}
