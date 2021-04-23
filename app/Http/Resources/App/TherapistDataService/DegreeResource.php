<?php

namespace App\Http\Resources\App\TherapistDataService;

use Illuminate\Http\Resources\Json\JsonResource;

class DegreeResource extends JsonResource
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
            'label' => $this->degree_name,
            'value' => $this->degree_name
        ];
    }
}
