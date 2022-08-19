<?php

namespace App\Strategies\PriceCalculator;

use App\Http\Requests\PriceCalculatorRequest;
use App\Services\TariffParser\Interfaces\TariffParserInterface;
use App\Strategies\PriceCalculator\Interfaces\CalculatorStrategyInterface;
use Exception;

class TireDiskStrategy implements CalculatorStrategyInterface
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
    public function execute(): int|float
    {
        try {
            $data = $this->validator->validated();
        } catch (\Throwable) {
            throw new Exception('Передані неправильні дані', 422);
        }

        $price = 0;
        $is_local = $data['country_sender'] === $data['country_recipient'];

        // Расчет цены за шины
        if (!empty($data['tire'])) {
            foreach ($data['tire'] as $tire) {
                $calculated_price = 0;
                list($light_vantage, $size) = explode(' ', $tire['type']);

                // Расчет цены шин по размеру
                $calculated_price += $this->calculatePriceBySize($light_vantage, $size, $is_local);

                // Расчет цены по кол-ву
                $calculated_price *= $tire['count'];

                $price += $calculated_price;
            }

            // Расчет цены за курьера
            $price += $this->calculateCourierPrice($data['tire'], $data['service_type']);
        }

        // Расчет цены за диски
        if (!empty($data['disk'])) {
            foreach ($data['disk'] as $disk) {
                $calculated_price = 0;
                list($light_vantage, $size) = explode(' ', $disk['type']);

                // Расчет цены дисков по размеру
                $calculated_price += $this->calculatePriceBySize($light_vantage, $size, $is_local) * $disk['count'];

                // Расчет цены по кол-ву
                $calculated_price *= $disk['count'];

                $price += $calculated_price;
            }

            // Расчет цены за курьера
            $price += $this->calculateCourierPrice($data['disk'], $data['service_type']);
        }

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

        // Количество легковых элементов
        $light_count = 0;

        // Количество вантажных элементов
        $vantage_count = 0;

        // Расчитать сумму легковых и вантажных элементов
        foreach ($list as $element) {
            $type = explode(' ', $element['type'])[0];

            // Если элемент легковой
            if ($type == 'r') {
                $light_count += $element['count'];
            } else { // Если элемент вантажный
                $vantage_count += $element['count'];
            }
        }

        // Расчет цены с учетом типа отправки
        if ($service_type == 'Двері-двері') {
            // Каждые 4 шины/диска одного типа по 30 грн.
            $price += ((floor($light_count / 4) * 30) * 2);
            $price += ((floor($vantage_count / 4) * 30) * 2);
        } else if (
            $service_type == 'Двері-відділення'
            || $service_type == 'Відділення-двері'
        ) {
            // Каждые 4 шины/диска одного типа по 30 грн.
            $price += (floor($light_count / 4) * 30);
            $price += (floor($vantage_count / 4) * 30);
        }

        return $price;
    }

    /**
     * Расчет цены по размеру шины/диска
     *
     * @param string $light_vantage
     * @param string $size
     * @param boolean $is_local
     * @return integer|float
     */
    protected function calculatePriceBySize(
        string $light_vantage,
        string $size,
        bool $is_local
    ): int|float {
        $price = 0;

        // Если шина/диск легковые
        if ($light_vantage == 'r') {
            if ($size == '13-14') { // Если размер 13-14
                if ($is_local) { // Если отправка локальная
                    $price += 40;
                } else { // Если отправка не локальная
                    $price += 60;
                }
            }
            if ($size == '15-17') { // Если размер 15-17
                if ($is_local) { // Если отправка локальная
                    $price += 50;
                } else { // Если отправка не локальная
                    $price += 70;
                }
            }
            if ($size == '18-23') { // Если размер 18-23
                if ($is_local) { // Если отправка локальная
                    $price += 70;
                } else { // Если отправка не локальная
                    $price += 90;
                }
            }
        } else { // Если шина/диск вантажные
            if ($size == '17,5-19,5') { // Если размер 17,5-19,5
                if ($is_local) { // Если отправка локальная
                    $price += 80;
                } else { // Если отправка не локальная
                    $price += 130;
                }
            }
            if ($size == '20') { // Если размер 20
                if ($is_local) { // Если отправка локальная
                    $price += 140;
                } else { // Если отправка не локальная
                    $price += 250;
                }
            }
            if ($size == '21-22,5') { // Если размер 21-22,5
                if ($is_local) { // Если отправка локальная
                    $price += 120;
                } else { // Если отправка не локальная
                    $price += 210;
                }
            }
        }

        return $price;
    }
}
