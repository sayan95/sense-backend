<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
            'name' => $this->permission_name,
            'dates' => [
                'created_at' =>  $this->created_at->toFormattedDateString(),
                'updated_at' => $this->updated_at->toFormattedDateString()
            ]
        ];
    }
}
