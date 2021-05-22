<?php

namespace App\Repositories\DAL;

use App\Model\User\Therapist\Therapist;
use App\Repositories\Contracts\TherapistContract;

class TherapistRepository extends BaseRepository implements TherapistContract{
    
    public function model(){
        return Therapist::class;
    }

    // create therapist profile
    public function createProfile($email, array $data){
        $therapist = $this->findWhereFirst('email', $email);
        return $therapist->profile()->create($data);
    }

}