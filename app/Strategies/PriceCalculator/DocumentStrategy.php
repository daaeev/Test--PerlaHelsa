<?php

namespace App\Strategies\PriceCalculator;

use App\Http\Requests\PriceCalculatorRequest;
use App\Services\TariffParser\Interfaces\TariffParserInterface;
use App\Strategies\PriceCalculator\Interfaces\CalculatorStrategyInterface;

class DocumentStrategy implements CalculatorStrategyInterface
{
    public function __construct(
        protected TariffParserInterface  $tariffParser,
        protected PriceCalculatorRequest $validator
    ) {
    }

    public function execute(): int|float
    {
        return 45;
    }
}
