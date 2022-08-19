<?php

namespace App\Strategies\PriceCalculator\Interfaces;

use App\Http\Requests\PriceCalculatorRequest;
use App\Services\TariffParser\Interfaces\TariffParserInterface;

interface CalculatorStrategyInterface
{
    /**
     * @param TariffParserInterface $tariff
     * @param PriceCalculatorRequest $validator
     */
    public function __construct(
        TariffParserInterface $tariff,
        PriceCalculatorRequest $validator
    );

    /**
     * Расчитать цену за доставку
     *
     * @return integer|float
     */
    public function execute(): int|float;
}
