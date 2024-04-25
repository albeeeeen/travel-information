<?php

namespace App\Services;

use App\Constants\ApiConstants;
use App\Exceptions\RequestException;
use App\Libraries\Api\DestinationApiUtils;

/**
 * Class DestinationService
 * @Author: Alvin Dela Cruz <delacruzalvinstaana@gmail.com> 
 * @Date: 2024-04-24
 */
class DestinationService
{
    /**
     * @var DestinationApiUtils
     */
    private $destinationApiUtils;

    /**
     * DestinationService constructor
     *
     * @param DestinationApiUtils $destinationApiUtils
     */
    public function __construct(DestinationApiUtils $destinationApiUtils)
    {
        $this->destinationApiUtils = $destinationApiUtils;
    }

    /**
     * fetch all place information information by location
     *
     * @param string $location
     * @return array
     */
    public function fetchAllDestinationsByLocation(string $place): array
    {
        $response = $this->destinationApiUtils->fetchAllDestinationsByLocation($place);

        if ($response[ApiConstants::SUCCESS] === false || 
            array_key_exists(ApiConstants::ERROR, $response)) {
            throw new RequestException($response[ApiConstants::CODE], 
                $response[ApiConstants::DATA][ApiConstants::MESSAGE]
            );
        }

        return $response;
    }

    /**
     * fetch all place information information by location
     *
     * @param string $location
     * @return array
     */
    public function fetchGeoCodeByLocation(string $location): array
    {
        $response = $this->destinationApiUtils->fetchGeoCodeByLocation($location);

        if ($response[ApiConstants::SUCCESS] === false || 
            array_key_exists(ApiConstants::ERROR, $response)) {
            throw new RequestException($response[ApiConstants::CODE], 
                $response[ApiConstants::DATA][ApiConstants::MESSAGE]
            );
        }

        return $response;
    }

    /**
     * fetch place details by place id
     *
     * @param string $placeId
     * @return array
     */
    public function fetchPlaceDetails(string $placeId): array
    {
        $response = $this->destinationApiUtils->fetchPlaceDetails($placeId);

        if ($response[ApiConstants::SUCCESS] === false || 
            array_key_exists(ApiConstants::ERROR, $response)) {
            throw new RequestException($response[ApiConstants::CODE], 
                $response[ApiConstants::DATA][ApiConstants::MESSAGE]
            );
        }

        return $response;
    }
}
