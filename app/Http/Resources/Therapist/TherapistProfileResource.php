<?php

namespace App\Http\Resources\Therapist;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class TherapistProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // therapist profile resource
        return [
            'firstname' => Str::ucfirst($this->firstname),
            'lastname' => Str::ucfirst($this->lastname),
            'gender' => Str::ucfirst($this->gender),
            'phone' => $this->phone,
            'education' => $this->education,
            'experties' => $this->experties,
            'age_group' => $this->age_group,
            'therapist_profile' => $this->therapist_profile,
            'language_proficiency' => $this->language_proficiency,
            'spectrum_specialization' => $this->spectrum_specialization,
        ];
    }
}
