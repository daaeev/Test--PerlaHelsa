<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PriceCalculatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'country_sender' => [
                'required',
                Rule::in($this->allowedCities())
            ],
            'country_recipient' => [
                'required',
                Rule::in($this->allowedCities())
            ],

            'service_type' => [
                'required',
                Rule::in($this->allowedServiceTypes())
            ],
            'send_type' => [
                'required',
                Rule::in($this->allowedSendTypes())
            ],

            'package' => 'nullable|array',
            'package.*.count' => 'required|numeric|integer|min:1',
            'package.*.price' => 'required|numeric|min:0',
            'package.*.weight' => 'required|numeric|min:0',
            'package.*.length' => 'required|numeric|min:0',
            'package.*.width' => 'required|numeric|min:0',
            'package.*.height' => 'required|numeric|min:0',

            'disk' => 'nullable|array',
            'disk.*.type' => [
                'required',
                Rule::in($this->allowedDiskOrTire())
            ],
            'disk.*.count' => 'required|numeric|integer|min:1',

            'tire' => 'nullable|array',
            'tire.*.count' => 'required|numeric|integer|min:1',
            'tire.*.type' => [
                'required',
                Rule::in($this->allowedDiskOrTire())
            ],

            'pallet' => 'nullable|array',
            'pallet.*.count' => 'required|numeric|integer|min:1',
            'pallet.*.price' => 'required|numeric|min:0',
            'pallet.*.type' => [
                'required',
                Rule::in($this->allowedPallets())
            ],
        ];
    }

    /**
     * Получить доступные города отправки/получения
     *  (( Я бы вынес его в модель заказа ))
     *
     * @return array
     */
    protected function allowedCities(): array
    {
        return [
            'Вінниця',
            'Дніпро',
            'Запоріжжя',
            'Київ',
            'Кривий Ріг',
            'Миколаїв',
            'Львів',
            'Одеса',
            'Полтава',
            'Харків',
        ];
    }

    /**
     * Получить доступные типы услуги
     *  (( Я бы вынес его в модель заказа ))
     *
     * @return array
     */
    protected function allowedServiceTypes(): array
    {
        return [
            'Відділення-відділення',
            'Двері-двері',
            'Двері-відділення',
            'Відділення-двері',
        ];
    }

    /**
     * Получить доступные типы отправки
     *  (( Я бы вынес его в модель заказа ))
     *
     * @return array
     */
    protected function allowedSendTypes(): array
    {
        return [
            'Вантажі',
            'Документи',
            'Шини та диски',
            'Паллети',
        ];
    }

    /**
     * Получить доступные размеры шини или диска
     *  (( Я бы вынес его в модель заказа ))
     *
     * @return array
     */
    protected function allowedDiskOrTire(): array
    {
        return [
            'R 17,5-19,5',
            'R 20',
            'R 21-22,5',
            'r 13-14',
            'r 15-17',
            'r 18-23',
        ];
    }

    /**
     * Получить доступные размеры палета
     *  (( Я бы вынес его в модель заказа ))
     *
     * @return array
     */
    protected function allowedPallets(): array
    {
        return [
            '1,5-2',
            '1-1,49',
            '0,5-0,99',
            '0-0,49',
        ];
    }
}
