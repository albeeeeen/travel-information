<?php

namespace App\Libraries\Api;

use App\Constants\ApiConstants;

/** 
 * Class DestinationApiUtils
 * @Author: Alvin Dela Cruz <delacruzalvinstaana@gmail.com> 
 * @Date: 2024-04-24
 */
class DestinationApiUtils extends BaseApiUtils
{
    /**
     * DestinationApiUtils constructor
     */
    public function __construct()
    {
        $this->setBaseUri(config('place.base_uri_v2'));
    }

    /**
     * fetch all places information by location
     *
     * @param string $location
     * @return array
     */
    public function fetchAllDestinationsByLocation(string $place): array
    {
        return $this->request(ApiConstants::GET, '/places', [
                ApiConstants::FILTER => ApiConstants::PLACE . ':' . $place,
                ApiConstants::LIMIT => config('place.api_limit'),
                ApiConstants::API_KEY => config('place.api_key')
            ]
        );
    }

    /**
     * fetch geo code by location
     *
     * @param string $location
     * @return array
     */
    public function fetchGeoCodeByLocation(string $location): array
    {
        $this->setBaseUri(config('place.base_uri_v1'));
        return $this->request(ApiConstants::GET, '/geocode/search', [
                ApiConstants::TEXT  => $location,
                ApiConstants::FORMAT => ApiConstants::JSON,
                ApiConstants::API_KEY => config('place.api_key')
            ]
        );
    }

    /**
     * fetch place details by place id
     *
     * @param string $placeId
     * @return array
     */
    public function fetchPlaceDetails(string $placeId): array
    {
        return $this->request(ApiConstants::GET, '/place-details', [
                ApiConstants::ID  => $placeId,
                ApiConstants::API_KEY => config('place.api_key')
            ]
        );
    }
}
