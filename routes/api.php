<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::post('/calculator/price', [ApiController::class, 'calculatePrice'])->name('api.calculator');