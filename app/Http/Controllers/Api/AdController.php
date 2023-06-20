<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use Illuminate\Http\Request;
use App\Http\Requests\AdRequest;
use App\Http\Helpers\ApiResponse;
use App\Http\Resources\AdResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AdController extends Controller
{
    public function index() {

        $ads = Ad::latest()->paginate(1);

        if(count($ads) > 0) {
            if ($ads->total() > $ads->perPage()) {
                $data = [
                    'records' => AdResource::collection($ads),
                    'pagination links' => [
                        'current page' => $ads->currentPage(),
                        'per page' => $ads->perPage(),
                        'total' => $ads->total(),
                        'links' => [
                            'first' => $ads->url(1),
                            'last' => $ads->url($ads->lastPage()),
                        ],
                    ],
                ];
            } else {
                $data = AdResource::collection($ads);
            }

            return ApiResponse::sendResponse(200, 'Ads retrieved Successfully!', $data);
        }

        return ApiResponse::sendResponse(200, 'No ads found!', []);

    }

    public function latest() {

        $ads = Ad::latest()->take(2)->get();

        if(count($ads) > 0) {
            return ApiResponse::sendResponse(200, 'Latest ads retrieved successfully!', AdResource::collection($ads));
        }

        return ApiResponse::sendResponse(200, 'No ads found!', []);

    }

    public function getAdsByDomain($domain_id) {

        $ads = Ad::where('domain_id', $domain_id)->latest()->get();

        if(count($ads) > 0) {
            return ApiResponse::sendResponse(200, 'Ads related to the specific domain retrieved successfully!', AdResource::collection($ads));
        }

        return ApiResponse::sendResponse(200, 'No ads found for this domain!', []);

    }

    public function search(Request $request) {

        $ads = Ad::where(function($query) use($request) {

            if($request->has('title') && $request->title !== ''){
                $query->where('title', 'like', "%$request->title%");
            }

        })->paginate(10);

        if(count($ads) > 0) {
            return ApiResponse::sendResponse(200, 'Search results retrieved successfully!', AdResource::collection($ads));
        }

        return ApiResponse::sendResponse(200, 'No ads found!', []);

    }

    public function store(AdRequest $request) {

        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $record = Ad::create($data);

        if($record) {
            return ApiResponse::sendResponse(201, 'Ad created successfully!', new AdResource($record));
        }
        return ApiResponse::sendResponse(200, 'Error!', []);
    }

    public function update(AdRequest $request, $id) {

        $ad = Ad::findOrFail($id);
        if ($ad->user_id != $request->user()->id) {
            return ApiResponse::sendResponse(403, 'You aren\'t allowed to take this action', []);
        }

        $data = $request->validated();
        $record = $ad->update($data);
        if ($record) return ApiResponse::sendResponse(201, 'Your Ad updated successfully', new AdResource($ad));


    }

    public function destroy(Request $request, $id) {
        $ad = Ad::findOrFail($id);

        if($request->user()->id !== $ad->user_id) {
            return ApiResponse::sendResponse(403, 'You aren\'t allowed to take this action', []);
        }

        $record = $ad->delete();

        if($record) {
            return ApiResponse::sendResponse(200, 'Ad deleted successfully', []);
        }

    }


    public function allAds(Request $request) {

        $ads = Ad::where('user_id', $request->user()->id)->latest()->paginate(10);

        if(count($ads) > 0) {
            return ApiResponse::sendResponse(200, 'Ads retrieved successfully', AdResource::collection($ads));
        }

        return ApiResponse::sendResponse(200, 'No ads found!', []);


    }
}
