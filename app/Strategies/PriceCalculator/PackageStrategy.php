<?php

namespace App\Strategies\PriceCalculator;

use App\Http\Requests\PriceCalculatorRequest;
use App\Services\TariffParser\Interfaces\TariffParserInterface;
use App\Strategies\PriceCalculator\Interfaces\CalculatorStrategyInterface;
use Exception;

class PackageStrategy implements CalculatorStrategyInterface
{
    public function __construct(
        protected TariffParserInterface  $tariff,
        protected PriceCalculatorRequest $validator
    ) {
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function execute(): int|float
    {
        try {
            $data = $this->validator->validated();
        } catch (\Throwable) {
            throw new Exception('Передані неправильні дані', 422);
        }

        $price = 0;
        $is_local = $data['country_sender'] === $data['country_recipient'];
        $packages = $data['package'] ?? [];

        foreach ($packages as $package) {
            $calculated_price = 0;
            $weight = $package['weight'];
            $package_price = $package['price'];
            $count = $package['count'];
            $service_type = $data['service_type'];

            // Расчет цены по массе
            $calculated_price += $this->calculateWeightPrice($weight, $is_local);

            // Расчет цены за курьера
            $calculated_price += $this->calculateCourierPrice($weight, $service_type);

            // Расчет цены по указанной стоимости
            $calculated_price += $this->calculateUsingPackagePrice($package_price);

            // Расчет цены по кол-ву товара
            $calculated_price *= $count;

            $price += $calculated_price;
        }

        return $price;
    }

    /**
     * Расчитать цену за объявленную стоимость
     *
     * @param integer|float $package_price
     * @return integer|float
     */
    protected function calculateUsingPackagePrice(int|float $package_price): int|float
    {
        $price = 0;

        if ($package_price > $this->tariff->getWeightForReceivePercent()) {
            $price += ($package_price * $this->tariff->getReceivePercentForWeight()) / 100;
        }

        return $price;
    }

    /**
     * Расчитать цену по весу
     *
     * @param integer|float $weight
     * @param boolean $is_local
     * @return integer|float
     */
    protected function calculateWeightPrice(
        int|float $weight,
        bool      $is_local,
    ): int|float {
        $price = 0;

        foreach ($this->tariff->getPackageWeightPrices() as $tariffWeightDiapason => $tariffPrice) {
            list($weightFrom, $weightTo) = explode('-', $tariffWeightDiapason);

            // Если цена ОТ удовлитворительна
            if ($weight >= $weightFrom) {
                // Если указана ценна до и она удовлитворитльна ИЛИ не указана ценна до
                if ((!empty($weightTo) && $weight < $weightTo) || empty($weightTo)) {
                    if ($is_local) { // Если доставка локальная
                        $price += $tariffPrice['local'];
                    } else { // Если доставка не локальная
                        $price += $tariffPrice['noLocal'];;
                    }
                }
            }
        }

        return $price;
    }

    /**
     * Расчитать цену за курьера
     *
     * @param integer|float $weight
     * @param string $service_type
     * @return integer|float
     */
    protected function calculateCourierPrice(int|float $weight, string $service_type): int|float
    {
        $price = 0;

        foreach ($this->tariff->getPackageWeightCourierPrices() as $tariffWeightDiapason => $tariffPrice) {
            list($weightFrom, $weightTo) = explode('-', $tariffWeightDiapason);

            // Если цена ОТ удовлитворительна
            if ($weight >= $weightFrom) {
                // Если указана ценна до и она удовлитворитльна ИЛИ не указана ценна до
                if ((!empty($weightTo) && $weight <= $weightTo) || empty($weightTo)) {
                    if ($service_type == 'Двері-двері') {
                        $price += ($tariffPrice * 2);
                    } else if (
                        $service_type == 'Двері-відділення'
                        || $service_type == 'Відділення-двері'
                    ) {
                        $price += $tariffPrice;
                    }
                }
            }
        }

        return $price;
    }
}
