<?php

namespace App\Strategies\PriceCalculator;

use App\Http\Requests\PriceCalculatorRequest;
use App\Services\TariffParser\Interfaces\TariffParserInterface;
use Exception;

class PalletStrategy implements Interfaces\CalculatorStrategyInterface
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

        foreach ($data['pallet'] as $pallet) {
            $calculated_price = 0;

            // Расчет цены за размер
            $calculated_price += $this->calculatePriceBySize($pallet['type'], $is_local);

            // Расчет цены за объявленную стоимость
            $calculated_price += $this->calculateUsingPalletPrice($pallet['price']);

            // Расчет цены за кол-во
            $calculated_price *= $pallet['count'];

            $price += $calculated_price;
        }

        return $price;
    }

    /**
     * Расчет цены за объявленную стоимость
     *
     * @param int|float $pallet_price
     * @return int|float
     */
    public function calculateUsingPalletPrice(int|float $pallet_price): int|float
    {
        $price = 0;

        // Если указаная стоимость больше 500 грн.
        if ($pallet_price > 500) {
            $price += ($pallet_price * 0.05) / 100;
        }

        return $price;
    }

    /**
     * Расчет цены за размер
     *
     * @param string $size
     * @param bool $is_local
     * @return int|float
     */
    protected function calculatePriceBySize(string $size, bool $is_local): int|float
    {
        $price = 0;

        if ($size === '0-0,49') { // Размер от 0 до 0,49
            if ($is_local) { // Локальная доставка
                $price += 500;
            } else { // Не локальная доставка
                $price += 850;
            }
        } else if ($size === '0,5-0,99') { // Размер от 0,5 до 0,99
            if ($is_local) { // Локальная доставка
                $price += 850;
            } else { // Не локальная доставка
                $price += 1700;
            }
        } else if ($size === '1-1,49') { // Размер от 1 да 1,49
            if ($is_local) { // Локальная доставка
                $price += 1300;
            } else { // Не локальная доставка
                $price += 2550;
            }
        } else if ($size === '1,5-2') { // Размер от 1,5 до 2
            if ($is_local) { // Локальная доставка
                $price += 1700;
            } else { // Не локальная доставка
                $price += 3450;
            }
        }

        return $price;
    }
}