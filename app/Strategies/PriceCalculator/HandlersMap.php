<?php

namespace App\Strategies\PriceCalculator;

class HandlersMap
{
    public static function map(): array
    {
        return [
            'Вантажі' => PackageStrategy::class,
            'Документи' => DocumentStrategy::class,
            'Шини та диски' => TireDiskStrategy::class,
            'Паллети' => PalletStrategy::class,
        ];
    }
}
