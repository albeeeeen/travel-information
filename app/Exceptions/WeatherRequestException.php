<?php

namespace App\Exceptions;

use Exception;

/** 
 * Class WeatherRequestException
 * @Author: Alvin Dela Cruz <delacruzalvinstaana@gmail.com>? 
 * @Date: 2024-04-23
 */
class WeatherRequestException extends Exception
{
    /**
     * WeatherRequestException constructor
     *
     * @param string $message
     * @param integer $code
     */
    public function __construct(int $code = 500, string $message = '')
    {
        parent::__construct($message, $code);
    }
}