<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;
use App\Exceptions\RequestException;
use App\Http\Controllers\BaseController;

/**
 * Class WeatherController
 * @Author: Alvin Dela Cruz <delacruzalvinstaana@gmail.com> 
 * @Date: 2024-04-23
 */
class WeatherController extends BaseController
{
    /**
     *
     * @var WeatherService
     */
    private $weatherService;

    /**
     * WeatherController constructor
     *
     * @param WeatherService $weatherService
     */
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * fetch current weather by location
     *
     * @param string $location
     * @return JsonResponse
     */
    public function fetchCurrentWeatherByLocation(string $location): JsonResponse
    {
        try {

            $weather = $this->weatherService
                ->fetchCurrentWeatherByLocation($location);
            return response()->json($weather);

        } catch (RequestException $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    /**
     * fetch 5 day forecast information by location
     *
     * @param string $location
     * @return JsonResponse
     */
    public function fetch5DayForecastByLocation(string $location): JsonResponse
    {
        try {

            $weather = $this->weatherService
                ->fetch5DayForecastByLocation($location);
            return response()->json($weather);

        } catch (RequestException $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }
}
