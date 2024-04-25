<?php

namespace App\Libraries\Api;

use App\Constants\ApiConstants;

/** 
 * Class WeatherApiUtils
 * @Author: Alvin Dela Cruz <delacruzalvinstaana@gmail.com> 
 * @Date: 2024-04-23 
 */
class WeatherApiUtils extends BaseApiUtils
{
    /**
     * WeatherApiUtils constructor
     */
    public function __construct()
    {
        $this->setBaseUri(config('weather.base_uri'));
    }

    /**
     * fetch current weather information by location
     *
     * @param string $location
     * @return array
     */
    public function fetchCurrentWeatherByLocation(string $location): array
    {
        return $this->request(ApiConstants::GET, '/weather', [
            ApiConstants::QUERY  => $location,
            ApiConstants::UNITS => config('weather.units'),
            ApiConstants::APP_ID => config('weather.api_key')
        ]);
    }

    /**
     * fetch 5 day forecast information by location
     *
     * @param string $location
     * @return array
     */
    public function fetch5DayForecastByLocation(string $location): array
    {
        return $this->request(ApiConstants::GET, '/forecast', [
            ApiConstants::QUERY  => $location,
            ApiConstants::UNITS => config('weather.units'),
            ApiConstants::APP_ID => config('weather.api_key')
        ]);
    }
}
