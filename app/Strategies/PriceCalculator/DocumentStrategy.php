<?php

namespace App\Strategies\PriceCalculator;

use App\Http\Requests\PriceCalculatorRequest;
use App\Strategies\PriceCalculator\Interfaces\CalculatorStrategyInterface;

class DocumentStrategy implements CalculatorStrategyInterface
{
    public function execute(PriceCalculatorRequest $validator): int|float
    {
        return 45;
    }
}
