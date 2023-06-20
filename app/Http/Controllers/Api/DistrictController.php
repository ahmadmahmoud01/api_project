<?php

namespace App\Http\Controllers\Api;

use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictResource;

class DistrictController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $city_id)
    {
        $districts = District::where('city_id', $city_id)->get();
        // using query parameter
        // $districts = District::where('city_id', $request->city_id)->get();

        if(count($districts) > 0) {
            return ApiResponse::sendResponse(200, 'Districts retrieved successfully!', DistrictResource::collection($districts));
        }

        return ApiResponse::sendResponse(200, 'No districts related to this city!', []);
    }
}
