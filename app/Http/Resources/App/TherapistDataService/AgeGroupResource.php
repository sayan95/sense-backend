<?php

namespace App\Http\Resources\App\TherapistDataService;

use Illuminate\Http\Resources\Json\JsonResource;

class AgeGroupResource extends JsonResource
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
            'label' => $this->age_group,
            'value' => $this->age_group
        ];
    }
}
