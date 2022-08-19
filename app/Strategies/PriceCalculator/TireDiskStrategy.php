<?php

namespace App\Strategies\PriceCalculator;

use App\Http\Requests\PriceCalculatorRequest;
use App\Services\TariffParser\Interfaces\TariffParserInterface;
use App\Strategies\PriceCalculator\Interfaces\CalculatorStrategyInterface;
use Exception;

class TireDiskStrategy implements CalculatorStrategyInterface
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
        $disks = $data['disk'] ?? [];
        $tires = $data['tire'] ?? [];

        // Расчет цены за шины
        foreach ($tires as $tire) {
            $calculated_price = 0;
            $type = $tire['type'];

            // Расчет цены шин по размеру
            $calculated_price += $this->calculatePriceBySize($type, $is_local);

            // Расчет цены по кол-ву
            $calculated_price *= $tire['count'];

            $price += $calculated_price;
        }

        // Расчет цены за курьера
        $price += $this->calculateCourierPrice($tires, $data['service_type']);


        // Расчет цены за диски
        foreach ($disks as $disk) {
            $calculated_price = 0;
            $type = $disk['type'];

            // Расчет цены дисков по размеру
            $calculated_price += $this->calculatePriceBySize($type, $is_local);

            // Расчет цены по кол-ву
            $calculated_price *= $disk['count'];

            $price += $calculated_price;
        }

        // Расчет цены за курьера
        $price += $this->calculateCourierPrice($disks, $data['service_type']);


        return $price;
    }

    /**
     * Расчет цены за курьера
     *
     * @param array $list
     * @param string $service_type
     * @return integer|float
     */
    protected function calculateCourierPrice(array $list, string $service_type): int|float
    {
        $price = 0;

        // Количество элементов
        $count = 0;

        // Расчитать сумму количество элементов
        foreach ($list as $element) {
            $count += $element['count'];
        }

        $tariffData = $this->tariff->getTierDiskCourierPrices();
        $tariffCount = array_key_first($tariffData);
        $tariffPrice = $tariffData[$tariffCount];

        // Расчет ценны с учетом типа отправки
        if ($service_type == 'Двері-двері') {
            // Каждые n шины/диска по n грн.
            $price += ((floor($count / $tariffCount) * $tariffPrice) * 2);
        } else if (
            $service_type == 'Двері-відділення'
            || $service_type == 'Відділення-двері'
        ) {
            // Каждые n шины/диска по n грн.
            $price += (floor($count / $tariffCount) * $tariffPrice);
        }

        return $price;
    }

    /**
     * Расчет цены по размеру шины/диска
     *
     * @param string $type
     * @param boolean $is_local
     * @return integer|float
     */
    protected function calculatePriceBySize(
        string $type,
        bool   $is_local
    ): int|float {
        $price = 0;

        $tariff_data = $this->tariff->getTierDiskPrices();

        if ($is_local) { // Если отправка локальная
            $price += $tariff_data[$type]['local'];
        } else { // Если отправка не локальная
            $price += $tariff_data[$type]['noLocal'];
        }

        return $price;
    }
}
