<?php

namespace App\Services\TariffParser;

use App\Services\TariffParser\Interfaces\TariffParserInterface;

class ArrayTariffParser implements TariffParserInterface
{
    protected array $tariff = [
        // Процент от объявленной стоимости
        'ReceivePercentForWeight' => 0.05,

        // Масса, с которой начинает действовать процент от объявленной стоимости
        'WeightForReceivePercent' => 500,

        // Цены за доставку товара с учетом массы
        'PackageWeightPrices' => [
            // До 2 кг.
            '0-2' => [
                'local' => 40, // Локальная доставка
                'noLocal' => 60 // Не локальная доставка
            ],
            // До 10 кг.
            '2-10' => [
                'local' => 60, // Локальная доставка
                'noLocal' => 80 // Не локальная доставка
            ],
            // До 30 кг.
            '10-30' => [
                'local' => 80, // Локальная доставка
                'noLocal' => 120 // Не локальная доставка
            ],
            // От 30 кг.
            '30-' => [
                'local' => 150, // Локальная доставка
                'noLocal' => 250 // Не Локальная доставка
            ]
        ],
        // Ценны за доставку товара курьером
        'PackageWeightCourierPrices' => [
            // От 0 до 30 кг.
            '0-30' => 30,
            // От 30 кг.
            '30-' => 90
        ],
        // Цены за доставку паллета с учетом размера
        'PalletsSizePrices' => [
            // Размер от 0 до 0,49
            '0-0,49' => [
                'local' => 500, // Локальная доставка
                'noLocal' => 850 // Не Локальная доставка
            ],
            // Размер от 0,5 до 0,99
            '0,5-0,99' => [
                'local' => 850, // Локальная доставка
                'noLocal' => 1700, // Не Локальная доставка
            ],
            // Размер от 1 да 1,49
            '1-1,49' => [
                'local' => 1300, // Локальная доставка
                'noLocal' => 2550, // Не Локальная доставка
            ],
            // Размер от 1,5 до 2
            '1,5-2' => [
                'local' => 1700, // Локальная доставка
                'noLocal' => 3450 // Не Локальная доставка
            ],
        ],
        // Ценны за даставку шин/дисков курьером
        'TierDiskCourierPrices' => [
            // Каждые 4 шины/диска стоят 30 грн
            '4' => 30
        ],
        // Ценны за доставку шин/дисков с учетом размера
        'TierDiskPrices' => [

            // Легковые
            // Размер 13-14
            'r 13-14' => [
                'local' => 40, // Локальная доставка
                'noLocal' => 60 // Не Локальная доставка
            ],
            // Размер 15-17
            'r 15-17' => [
                'local' => 50, // Локальная доставка
                'noLocal' => 70 // Не Локальная доставка
            ],
            // Размер 18-23
            'r 18-23' => [
                'local' => 70, // Локальная доставка
                'noLocal' => 90 // Не Локальная доставка
            ],

            // Вантажные
            // Размер 17,5-19,5
            'R 17,5-19,5' => [
                'local' => 80, // Локальная доставка
                'noLocal' => 130 // Не Локальная доставка
            ],
            // Размер 20
            'R 20' => [
                'local' => 140, // Локальная доставка
                'noLocal' => 250 // Не Локальная доставка
            ],
            // Размер 21-22,5
            'R 21-22,5' => [
                'local' => 120, // Локальная доставка
                'noLocal' => 210 // Не Локальная доставка
            ],
        ],
        // Ценна за доставку документов
        'DocumentDeliveryPrice' => 45
    ];

    /**
     * @inheritDoc
     */
    public function getReceivePercentForWeight(): int|float
    {
        return $this->tariff['ReceivePercentForWeight'];
    }

    /**
     * @inheritDoc
     */
    public function getWeightForReceivePercent(): int|float
    {
        return $this->tariff['WeightForReceivePercent'];
    }

    /**
     * @inheritDoc
     */
    public function getPackageWeightPrices(): array
    {
        return $this->tariff['PackageWeightPrices'];
    }

    /**
     * @inheritDoc
     */
    public function getPackageWeightCourierPrices(): array
    {
        return $this->tariff['PackageWeightCourierPrices'];
    }

    /**
     * @inheritDoc
     */
    public function getPalletsSizePrices(): array
    {
        return $this->tariff['PalletsSizePrices'];
    }

    /**
     * @inheritDoc
     */
    public function getTierDiskCourierPrices(): array
    {
        return $this->tariff['TierDiskCourierPrices'];
    }

    /**
     * @inheritDoc
     */
    public function getTierDiskPrices(): array
    {
        return $this->tariff['TierDiskPrices'];
    }

    /**
     * @inheritDoc
     */
    public function getDocumentsDeliveryPrice(): int|float
    {
        return $this->tariff['DocumentDeliveryPrice'];
    }
}