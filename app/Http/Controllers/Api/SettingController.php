<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;

class SettingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $settings = Setting::findOrFail(1);

        if($settings){
            return ApiResponse::sendResponse(200, 'Settings retrieved successfully!', new SettingResource($settings));
        }

        return new SettingResource($settings);
    }
}
