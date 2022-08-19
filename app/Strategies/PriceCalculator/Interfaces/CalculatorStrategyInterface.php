<?php

namespace App\Strategies\PriceCalculator\Interfaces;

use App\Http\Requests\PriceCalculatorRequest;
use App\Services\TariffParser\Interfaces\TariffParserInterface;

interface CalculatorStrategyInterface
{
    /**
     * @param TariffParserInterface $tariffParser
     * @param PriceCalculatorRequest $validator
     */
    public function __construct(
        TariffParserInterface $tariffParser,
        PriceCalculatorRequest $validator
    );

    /**
     * Расчитать цену за доставку
     *
     * @return integer|float
     */
    public function execute(): int|float;
}
