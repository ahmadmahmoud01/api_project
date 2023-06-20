<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name of sender' => $this->name,
            'email of sender' => $this->email,
            'phone of sender' => $this->phone,
            'the content of the message' => $this->message
        ];
    }
}
