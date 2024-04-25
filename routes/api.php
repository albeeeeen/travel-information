<?php

use App\Http\Controllers\DestinationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::get('/weather/{location}', [WeatherController::class, 'fetchCurrentWeatherByLocation']);
Route::get('/forecast/{location}', [WeatherController::class, 'fetch5DayForecastByLocation']);

Route::get('/place/{placeId}', [DestinationController::class, 'fetchPlaceDetails']);
Route::get('/geocode/{location}', [DestinationController::class, 'fetchGeoCodeByLocation']);