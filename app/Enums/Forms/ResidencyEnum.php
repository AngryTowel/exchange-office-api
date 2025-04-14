<?php

namespace App\Enums\Forms;

enum ResidencyEnum: int
{
    case resident = 3;
    case non_resident = 4;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
