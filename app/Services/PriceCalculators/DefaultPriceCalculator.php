<?php

namespace App\Services\PriceCalculators;

use App\Http\Requests\PriceCalculatorRequest;
use App\Services\PriceCalculators\Interfaces\PriceCalculatorInterface;
use App\Strategies\PriceCalculator\HandlersMap;
use Exception;

class DefaultPriceCalculator implements PriceCalculatorInterface
{
    /**
     * @inheritDoc
     */
    public function calculate(PriceCalculatorRequest $validator): int|float
    {
        try {
            $send_type = $validator->validated('send_type');
        } catch (\Throwable) {
            throw new Exception('Передані неправильні дані', 422);
        }

        $handlers = HandlersMap::map();
        $strategy = app($handlers[$send_type]);

        return $strategy->execute($validator);
    }
}
