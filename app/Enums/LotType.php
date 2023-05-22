<?php

namespace App\Enums;

use App\Traits\EnumMethods;

enum LotType: string
{
    use EnumMethods;

    case RESIDENTIAL = 'R';
    case COMMERCIAL = 'C';

    public function name(): string
    {
        return match ($this) {
            static::RESIDENTIAL => 'Residencial',
            static::COMMERCIAL => 'Comercial'
        };
    }
}
