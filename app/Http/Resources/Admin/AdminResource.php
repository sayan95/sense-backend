<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Admin\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->user_name,
            'email' => $this->email,
            'role'=> new RoleResource($this->whenLoaded('role')),
            'dates' => [
                'joined_at' => $this->created_at->toFormattedDateString(),
                'updated_at' => $this->updated_at->toFormattedDateString(),
                'last_login' => $this->last_login->toFormattedDateString(),
            ]
        ];
    }
}
