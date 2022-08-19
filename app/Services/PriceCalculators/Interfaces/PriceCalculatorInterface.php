<?php

namespace App\Services\PriceCalculators\Interfaces;

use App\Http\Requests\PriceCalculatorRequest;
use Exception;

interface PriceCalculatorInterface
{
    /**
     * Расчитать цену за доставку
     *
     * @param PriceCalculatorRequest $validate данные для расчета цены доставки
     * @return int|float
     * @throws Exception при ошибке расчета цены
     */
    public function calculate(PriceCalculatorRequest $validate): int|float;
}
