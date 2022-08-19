<?php

namespace App\Providers;

use App\Services\PriceCalculators\DefaulPriceCalculator;
use App\Services\PriceCalculators\Interfaces\PriceCalculatorInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        PriceCalculatorInterface::class => DefaulPriceCalculator::class,
    ];
}
