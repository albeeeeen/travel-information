<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::get('/weather/{location}', [WeatherController::class, 'fetchCurrentWeatherByLocation']);
Route::get('/forecast/{location}', [WeatherController::class, 'fetch5DayForecastByLocation']);