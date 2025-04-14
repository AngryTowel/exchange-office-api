<?php

namespace App\Enums\Organization;

enum StatusEnum: int
{
    case inActive = 0;
    case active = 1;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
