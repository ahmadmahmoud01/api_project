<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Resources\DomainResource;
use App\Models\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $domains = Domain::all();

        if(count($domains) > 0) {
            return ApiResponse::sendResponse(200, 'Domains retreived successfully!', DomainResource::collection($domains));
        }

        return ApiResponse::sendResponse(200, 'No domains found!', []);

    }
}
