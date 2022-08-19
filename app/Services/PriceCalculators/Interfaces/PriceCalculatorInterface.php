<?php

namespace App\Services\PriceCalculators\Interfaces;

interface PriceCalculatorInterface
{
    /**
     * Расчитать цену за доставку
     *
     * @param array $data данные для расчета цены доставки
     * @return integer|false
     */
    public function calculate(array $data): int|false;
}
