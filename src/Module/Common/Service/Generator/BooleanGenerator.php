<?php

namespace App\Module\Common\Service\Generator;

class BooleanGenerator
{
    public static function averageTrue(): bool
    {
        return array_rand([1, 2, 3]) % 2 === 0;
    }

    public static function rareTrue(): bool
    {
        return array_rand(range(0, 100)) > 90;
    }
}
