<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Admin\PermissionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'name' => $this->role_name,
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'dates' => [
                'created_at' =>  $this->created_at->toFormattedDateString(),
                'updated_at' => $this->updated_at->toFormattedDateString()
            ]
        ];
    }
}
