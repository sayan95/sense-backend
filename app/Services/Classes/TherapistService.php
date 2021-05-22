<?php

namespace App\Services\Classes;

use App\Repositories\DAL\Criterias\EagerLoad;
use App\Services\Interfaces\ITherapistService;
use App\Repositories\Contracts\TherapistContract;

class TherapistService implements ITherapistService{
    private $therapist;

    public function __construct(TherapistContract $therapist)
    {
        $this->therapist = $therapist;
    }

    // find a therapist by id
    public function findTherapistById($id, array $relations)
    {
        return $this->therapist->withCriterias([new EagerLoad($relations)])->find($id);    
    }

    // find a therapist by specifi field
    public function findTherapistBySpecificField($col, $value, array $relations){
        return $this->therapist->withCriterias([new EagerLoad($relations)])->findWhereFirst($col, $value);
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

    // delet therapist account by id
    public function deleteTherapistAccountById($id){
        $this->therapist->delete($id);
    }

    // 
    public function deleteTherapistAccountByField($col, $value){
        $this->therapist->deleteBySpecificField($col, $value);
    }
}