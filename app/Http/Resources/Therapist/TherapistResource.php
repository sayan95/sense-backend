<?php

namespace App\Http\Resources\Therapist;

use App\Model\User\Therapist\TherapistProfile;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Therapist\TherapistProfileResource;
use Carbon\CarbonImmutable;

class TherapistResource extends JsonResource
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
            'username' => $this->username ? $this->username : 'not set yet',
            'email' => $this->email, 
            'profile' => $this->profile,
            'dates' => [
                'email_verified_at' => $this->email_verified_at,
                'created_at' => $this->created_at->format('jS F Y, g:i a'),
                'updated_at' => $this->updated_at->format('jS F Y, g:i a'),
                'logged_in_at' => $this->logged_in_at ? $this->logged_in_at->format('jS F Y, g:i a') : null 
            ], 
            'account_status' => [
                'is_active'=> $this->is_active ? 'verified' : 'pending', 
                'profile_created' => $this->profile_created
            ]
        ];
    }
}
