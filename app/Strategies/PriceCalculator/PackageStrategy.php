<?php

namespace App\Strategies\PriceCalculator;

use App\Http\Requests\PriceCalculatorRequest;
use App\Services\TariffParser\Interfaces\TariffParserInterface;
use App\Strategies\PriceCalculator\Interfaces\CalculatorStrategyInterface;
use Exception;

class PackageStrategy implements CalculatorStrategyInterface
{
    public function __construct(
        protected TariffParserInterface  $tariffParser,
        protected PriceCalculatorRequest $validator
    ) {
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function execute(): int|float {
        try {
            $data = $this->validator->validated();
        } catch (\Throwable) {
            throw new Exception('Передані неправильні дані', 422);
        }

        $price = 0;
        $more_than_one = false;
        $is_local = $data['country_sender'] === $data['country_recipient'];

        foreach ($data['package'] as $package) {
            $calculated_price = 0;
            $weight = $package['weight'];
            $package_price = $package['price'];
            $count = $package['count'];
            $service_type = $data['service_type'];

            // Расчет цены по массе
            $calculated_price += $this->calculateWeightPrice($weight, $is_local, $more_than_one);

            // Расчет цены за курьера
            $calculated_price += $this->calculateCourierPrice($weight, $service_type);

            // Расчет цены по указанной стоимости
            $calculated_price += $this->calculateUsingPackagePrice($package_price);

            // Расчет цены по кол-ву товара
            $calculated_price *= $count;

            $price += $calculated_price;

            $more_than_one = true;
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

        if ($package_price > $tariffParser) {
            $price += ($package_price * 0.05) / 100;
        }

        return $price;
    }

    /**
     * Расчитать цену по весу
     *
     * @param integer|float $weight
     * @param boolean $is_local
     * @param boolean $more_than_one
     * @return integer|float
     */
    protected function calculateWeightPrice(
        int|float $weight, 
        bool $is_local, 
        bool $more_than_one
    ): int|float {
        $price = 0;

        if ($weight < 2) {
            // Скидка за каждое следующее место
            if ($more_than_one) {
                $price += 20;
            } else if ($is_local) { // Если доставка локальная
                $price += 40;
            } else { // Если доставка не локальная
                $price += 60;
            }
        } else if ($weight < 10) {
            // Скидка за каждое следующее место
            if ($more_than_one) {
                $price += 40;
            } else if ($is_local) { // Если доставка локальная
                $price += 60;
            } else { // Если доставка не локальная
                $price += 80;
            }
        } else if ($weight < 30) {
            // Скидка за каждое следующее место
            if ($more_than_one) {
                $price += 80;
            } else if ($is_local) { // Если доставка локальная
                $price += 80;
            } else { // Если доставка не локальная
                $price += 120;
            }
        } else {
            // Если доставка локальная
            if ($is_local) {
                $price += $weight * 3;
            } else {
                $price += $weight * 5;
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

        if ($weight < 30) { // Если маса до 30 кг
            if ($service_type == 'Двері-двері') {
                $price += (30 * 2);
            } else if (
                $service_type == 'Двері-відділення'
                || $service_type == 'Відділення-двері'
            ) {
                $price += 30;
            }
        } else { // Если маса больше или равна 30 кг
            if ($service_type == 'Двері-двері') {
                $price += (90 * (floor($weight / 100))) * 2;
            } else if (
                $service_type == 'Двері-відділення'
                || $service_type == 'Відділення-двері'
            ) {
                $price += (90 * (floor($weight / 100)));
            }
        }

        return $price;
    }
}
