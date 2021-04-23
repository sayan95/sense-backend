<?php

namespace App\Model\User\Therapist;

use App\Model\BaseModel as Eloquent;
use App\Model\User\Therapist\Therapist;

class TherapistProfile extends Eloquent
{
    
    // fillable properties
    protected $fillable = [
        'therapist_id', 'firstname', 'lastname', 'phone', 'gender', 
        'language_proficiency', 'education', 'therapist_profile', 
        'expertise', 'spectrum_specialization', 'age_group'
    ];

    // moloquent relationships
    public function therapist(){
        return $this->belongsTo(Therapist::class);
    }
    
}
