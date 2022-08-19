<?php

namespace App\Strategies\PriceCalculator\Interfaces;

use App\Http\Requests\PriceCalculatorRequest;

interface CalculatorStrategyInterface
{
    /**
     * Расчитать цену за доставку
     *
     * @param PriceCalculatorRequest $validator
     * @return integer|float
     */
    public function execute(PriceCalculatorRequest $validator): int|float;
}
