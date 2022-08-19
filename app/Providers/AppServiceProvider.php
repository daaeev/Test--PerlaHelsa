<?php

namespace App\Providers;

use App\Services\PriceCalculators\DefaultPriceCalculator;
use App\Services\PriceCalculators\Interfaces\PriceCalculatorInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        PriceCalculatorInterface::class => DefaultPriceCalculator::class,
    ];
}
