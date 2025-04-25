<?php

namespace App\Module\Common\Service\Generator;

class BooleanGenerator
{
    public static function averageTrue(): bool
    {
        $seq = [1, 2, 3];

        return $seq[array_rand($seq)] % 2 === 0;
    }

    public static function rareTrue(): bool
    {
        $seq = range(0, 100);

        return $seq[array_rand($seq)] > 90;
    }

    public static function higherTrue(): bool
    {
        $seq = [1, 2, 3];

        return $seq[array_rand($seq)] % 2 !== 0;
    }
}
