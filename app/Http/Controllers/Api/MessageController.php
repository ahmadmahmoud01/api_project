<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;

class MessageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(MessageRequest $request)
    {

        $validator = validator($request->all(), $request->rules());

        if($validator->fails()) {
            return ApiResponse::sendResponse (422, $validator->errors()->first(), $validator->errors());
        }

        $message = Message::create($request->all());

        return ApiResponse::sendResponse (201, 'message sent successfully!', new MessageResource($message));

    }

}
