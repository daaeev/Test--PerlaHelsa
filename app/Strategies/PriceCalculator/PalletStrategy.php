<?php

namespace App\Strategies\PriceCalculator;

use App\Http\Requests\PriceCalculatorRequest;
use App\Services\TariffParser\Interfaces\TariffParserInterface;
use Exception;

class PalletStrategy implements Interfaces\CalculatorStrategyInterface
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
        $pallets = $data['pallet'] ?? [];

        foreach ($pallets as $pallet) {
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
        if ($pallet_price > $this->tariff->getWeightForReceivePercent()) {
            $price += ($pallet_price * $this->tariff->getReceivePercentForWeight()) / 100;
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

        foreach ($this->tariff->getPalletsSizePrices() as $tariffSize => $tariffPrices) {
            if ($size === $tariffSize) {
                if ($is_local) { // Локальная доставка
                    $price += $tariffPrices['local'];
                } else { // Не локальная доставка
                    $price += $tariffPrices['noLocal'];
                }
            }
        }

        return $price;
    }
}