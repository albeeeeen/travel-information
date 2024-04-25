<?php

namespace App\Http\Controllers;

use App\Constants\ApiConstants;
use Illuminate\Http\JsonResponse;
use App\Exceptions\RequestException;
use App\Services\DestinationService;

/**
 * Class DestinationController
 * @Author: Alvin Dela Cruz <delacruzalvinstaana@gmail.com> 
 * @Date: 2024-04-24
 */
class DestinationController extends BaseController
{
    /**
     * @var DestinationService
     */
    private $destinationService;

    /**
     * DestinationController constructor
     *
     * @param DestinationService $destinationService
     */
    public function __construct(DestinationService $destinationService)
    {
        $this->destinationService = $destinationService;
    }

    /**
     * fetch all destination by place id
     *
     * @param string $place
     * @return JsonResponse
     */
    public function fetchAllDestinationsByPlaceId(string $place): JsonResponse
    {
        try {

            $places = $this->destinationService
                ->fetchAllDestinationsByLocation($place);
            return response()->json($places);

        } catch (RequestException $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    /**
     * fetch geocode by location
     *
     * @param string $location
     * @return JsonResponse
     */
    public function fetchGeoCodeByLocation(string $location): JsonResponse
    {
        try {

            $places = $this->destinationService
                ->fetchGeoCodeByLocation($location . ApiConstants::DEFAULT_CC);
            return response()->json($places);

        } catch (RequestException $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }

    /**
     * fetch place details by place id
     *
     * @param string $placeId
     * @return JsonResponse
     */
    public function fetchPlaceDetails(string $placeId): JsonResponse
    {
        try {

            $places = $this->destinationService->fetchPlaceDetails($placeId);
            return response()->json($places);

        } catch (RequestException $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }
}
