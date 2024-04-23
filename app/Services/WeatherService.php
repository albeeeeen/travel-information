<?php

namespace App\Services;

use Throwable;
use App\Constants\ApiConstants;
use App\Libraries\Api\WeatherApiUtils;
use App\Exceptions\WeatherRequestException;

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

        if ($response[ApiConstants::SUCCESS] === false || array_key_exists(ApiConstants::ERROR, $response)) {
            throw new WeatherRequestException($response[ApiConstants::CODE], $response[ApiConstants::DATA][ApiConstants::MESSAGE]);
        }

        return $response;
    }

    /**
     * fetch current weather information by location
     *
     * @param string $location
     * @return array
     */
    public function fetch5DayForecastByLocation(string $location): array
    {
        $response = $this->weatherApiUtils->fetch5DayForecastByLocation($location);

        if ($response[ApiConstants::SUCCESS] === false || array_key_exists(ApiConstants::ERROR, $response)) {
            throw new WeatherRequestException($response[ApiConstants::CODE], $response[ApiConstants::DATA][ApiConstants::MESSAGE]);
        }

        return $response;
    }
}