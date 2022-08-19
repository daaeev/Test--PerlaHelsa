<?php

namespace App\Services\PriceCalculators\Interfaces;

interface PriceCalculatorInterface
{
    /**
     * Расчитать цену за доставку
     *
     * @param integer|float $actual_weight фактическая масса
     * @param string $service_type тип услуги
     * @param string $send_type тип отправки
     * @param string $city_from город-отправитель
     * @param string $city_to город-приниматель
     * @return integer|false
     */
    public function calculate(
        int|float $actual_weight,
        string $service_type,
        string $send_type,
        string $city_from,
        string $city_to,
    ): int|false;
}
