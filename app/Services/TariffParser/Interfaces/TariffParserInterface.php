<?php

namespace App\Services\TariffParser\Interfaces;

interface TariffParserInterface
{
    /**
     * Получить тарифный процент от объявленной суммы
     *
     * @return int|float
     */
    public function getReceivePercentForWeight(): int|float;

    /**
     * Получить тарифную массу товара, с которой будет считываться процент от объявлкнной стоимости
     *
     * @return int|float
     */
    public function getWeightForReceivePercent(): int|float;

    /**
     * Список тарифных ценн за доставку товаров с учетом массы, локальной и не локальной отправки.
     * Ключи массива - масса 'от'-'до': '2-10' или только 'от': '5-'
     * Значения - массивы  с ключами 'local' и 'noLocal' с соответствующими ценнами.
     *
     * @return array
     */
    public function getPackageWeightPrices(): array;

    /**
     * Список тарифных ценн за доставку товаров с учетом массы, локальной и не локальной отправки.
     * Ключи массива - масса 'от'-'до': '2-10' или только 'от': '5-'
     * Значения - ценна за доставку
     *
     * @return array
     */
    public function getPackageWeightCourierPrices(): array;

    /**
     * Список тарифных ценн товаров за доставку паллет с учетом размера, локальной и не локальной отправки.
     * Ключи массива - размер 'от'-'до': '1-2'
     * Значения - массивы  с ключами 'local' и 'noLocal' с соответствующими ценнами.
     *
     * @return array
     */
    public function getPalletsSizePrices(): array;

    /**
     * Список тарифных цен за доставку циш/дисков курьером.
     * Массив должен содержать один элемент!
     * Ключ массива - кол-во дисков/шин
     * Значение - ценна за доставку каждых n дисков/шин
     *
     * @return array
     */
    public function getTierDiskCourierPrices(): array;

    /**
     * Список тарифных ценн за доставку циш/дисков учитывая их размер.
     * Ключи массива - размер типа 'R 20' - вантажные или 'r 20' - легковые
     * Значения - массивы  с ключами 'local' и 'noLocal' с соответствующими ценнами.
     *
     * @return array
     */
    public function getTierDiskPrices(): array;

    /**
     * Получить тарифную ценну за доставку документов
     *
     * @return int|float
     */
    public function getDocumentsDeliveryPrice(): int|float;
}