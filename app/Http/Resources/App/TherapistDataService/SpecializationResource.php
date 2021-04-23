<?php

namespace App\Http\Resources\App\TherapistDataService;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecializationResource extends JsonResource
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
            'label' => $this->spectrum_specialization,
            'value' => $this->spectrum_specialization
        ];
    }
}
