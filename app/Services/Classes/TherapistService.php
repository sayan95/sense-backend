<?php

namespace App\Services\Classes;

use App\Repositories\Contracts\TherapistContract;
use App\Services\Interfaces\ITherapistService;

class TherapistService implements ITherapistService{
    private $therapist;

    public function __construct(TherapistContract $therapist)
    {
        $this->therapist = $therapist;
    }

    // find a therapist by id
    public function findTherapistById($id)
    {
        return $this->therapist->find($id);    
    }

    // find a therapist by specifi field
    public function findTherapistBySpecificField($col, $value){
        return $this->therapist->findWhereFirst($col, $value);
    }

    // add therapist details to database
    public function addTherapist(array $data){
        return $this->therapist->create($data);
    }

    // update therapist data to database
    public function updateTherapistDetails($id, array $data)
    {
        return $this->therapist->update($id, $data);
    }

    // add therapist's profile
    public function addTherpistProfile($email, array $data)
    {
        return $this->therapist->createProfile($email, $data);
    }
}