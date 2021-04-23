<?php

namespace App\Services\Classes;

use App\Repositories\Contracts\TherapyProfileListContract;
use App\Services\Interfaces\ITherapyProfileListService;

class TherapyProfileListService implements ITherapyProfileListService{
    private $therapyProfileList;

    public function __construct(TherapyProfileListContract $therapyProfileList){
        $this->therapyProfileList = $therapyProfileList;
    }

    // adds new therapyProfile to the list
    public function addNewTherapyProfile($data){
        $this->therapyProfileList->create($data);
    }

    // retuns all the therapy profiles
    public function getAllTherapyProfiles(){
        return $this->therapyProfileList->all();
    }
}