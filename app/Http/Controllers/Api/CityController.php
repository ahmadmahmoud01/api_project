<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;

class CityController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $cities = City::all();

        if(count($cities) > 0) {
            return ApiResponse::sendResponse(200, 'cities retrieved successfully!', CityResource::collection($cities));
        }
        return ApiResponse::sendResponse(200, 'cities not found!', []);

    }
}
