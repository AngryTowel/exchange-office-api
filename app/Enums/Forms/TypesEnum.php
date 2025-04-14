<?php

namespace App\Enums\Forms;

enum TypesEnum: int
{
    case buying = 1;
    case selling = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toKT1($val): int
    {
        return match ($val) {
            self::buying => 10,
            self::selling => 12,
            default => $val,
        };
    }
}
