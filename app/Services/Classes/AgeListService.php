<?php

namespace App\Services\Classes;

use App\Repositories\Contracts\AgeListContract;
use App\Services\Interfaces\IAgeListService;


class AgeListService implements IAgeListService{
    
    private $ageList;

    public function __construct(AgeListContract $ageList){
        $this->ageList = $ageList;
    }

    // adds new age group to the age list
    public function addNewAgeGroup($data){
        $this->ageList->create($data);
    }

    // returns all the age groups
    public function getAllAgeGroups(){
        return $this->ageList->all();
    }
}