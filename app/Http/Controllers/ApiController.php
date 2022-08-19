<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceCalculatorRequest;
use App\Services\PriceCalculators\Interfaces\PriceCalculatorInterface;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    /**
     * Расчет цены доставки
     *
     * @param PriceCalculatorInterface $service
     * @param PriceCalculatorRequest $validate
     * @return JsonResponse
     */
    public function calculatePrice(
        PriceCalculatorInterface $service,
        PriceCalculatorRequest $validate
    ): JsonResponse {
        try {
            $price = $service->calculate($validate);

            return response()->json(['price' => $price]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
