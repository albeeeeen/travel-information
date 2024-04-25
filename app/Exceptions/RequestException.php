<?php

namespace App\Exceptions;

use Exception;

/** 
 * Class RequestException
 * @Author: Alvin Dela Cruz <delacruzalvinstaana@gmail.com>? 
 * @Date: 2024-04-23
 */
class RequestException extends Exception
{
    /**
     * RequestException constructor
     *
     * @param string $message
     * @param integer $code
     */
    public function __construct(int $code = 500, string $message = '')
    {
        parent::__construct($message, $code);
    }
}
