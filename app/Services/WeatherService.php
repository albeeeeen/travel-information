<?php

namespace App\Services;

use App\Constants\ApiConstants;
use App\Exceptions\RequestException;
use App\Libraries\Api\WeatherApiUtils;

/**
 * Class WeatherService
 * @Author: Alvin Dela Cruz <delacruzalvinstaana@gmail.com> 
 * @Date: 2024-04-23
 */
class WeatherService
{
    /**
     * @var WeatherApiUtils
     */
    private $weatherApiUtils;

    /**
     * WeatherService constructor
     *
     * @param WeatherApiUtils $weatherApiUtils
     */
    public function __construct(WeatherApiUtils $weatherApiUtils)
    {
        $this->weatherApiUtils = $weatherApiUtils;
    }

    /**
     * fetch current weather information by location
     *
     * @param string $location
     * @return array
     */
    public function fetchCurrentWeatherByLocation(string $location): array
    {
        $response = $this->weatherApiUtils->fetchCurrentWeatherByLocation($location);

        if ($response[ApiConstants::SUCCESS] === false || 
            array_key_exists(ApiConstants::ERROR, $response)) {
            throw new RequestException($response[ApiConstants::CODE], 
                $response[ApiConstants::DATA][ApiConstants::MESSAGE]
            );
        }

        return $response;
    }

    /**
     * fetch 5 day forecast information by location
     *
     * @param string $location
     * @return array
     */
    public function fetch5DayForecastByLocation(string $location): array
    {
        $response = $this->weatherApiUtils->fetch5DayForecastByLocation($location);

        if ($response[ApiConstants::SUCCESS] === false || 
            array_key_exists(ApiConstants::ERROR, $response)) {
            throw new RequestException($response[ApiConstants::CODE], 
                $response[ApiConstants::DATA][ApiConstants::MESSAGE]
            );
        }

        return $response;
    }
}
