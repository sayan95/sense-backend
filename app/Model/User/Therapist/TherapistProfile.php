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
        'experties', 'spectrum_specialization', 'age_group'
    ];

    // casts to array
    protected $casts = [
        'experties' => 'array',
        'education' => 'array',
        'age_group' => 'array',
        'therapist_profile' => 'array', 
        'language_proficiency' => 'array',
        'spectrum_specialization' => 'array',
    ];


    // moloquent relationships
    public function therapist(){
        return $this->belongsTo(Therapist::class);
    }
    
    // accesor and mutators
    // public function setLanguageProficiencyAttribute($value){
    //     $this->attributes['language_proficiency'] = serialize($value);
    // }
    // public function getLanguageProficiencyAttribute($value){
    //     return unserialize($value);
    // }

    // public function setEducationAttribute($value){
    //     $this->attributes['education'] = serialize($value);
    // }
    // public function getEducationAttribute($value){
    //     return unserialize($value);
    // }
    // public function setTherapistProfileAttribute($value){
    //     $this->attributes['therapist_profile'] = serialize($value);
    // }
    // public function getTherapistProfileAttribute($value){
    //     return unserialize($value);
    // }
    // public function setExpertiesAttribute($value){
    //     $this->attributes['experties'] = serialize($value);
    // }
    // public function getExpertiesAttribute($value){
    //     return unserialize($value);
    // }
    // public function setSpectrumSpecializationAttribute($value){
    //     $this->attributes['spectrum_specialization'] = serialize($value);
    // }
    // public function getSpectrumSpecializationAttribute($value){
    //     return unserialize($value);
    // }
    // public function setAgeGroupAttribute($value){
    //     $this->attributes['age_group'] = serialize($value);
    // }
    // public function getAgeGroupAttribute($value){
    //     return unserialize($value);
    // }
}
