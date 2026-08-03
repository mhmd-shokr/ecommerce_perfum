<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'device_name'=>$this->name,
            'last_used_at'=>$this->last_used_at,
            'current_device'=>$request->user()->currentAccessToken()?->id ===$this->id,
            'created_at'=>$this->created_at,
        ];
    }
}
