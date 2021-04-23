<?php

namespace App\Services\Classes;

use App\Repositories\Contracts\SpectrumSpecializationListContract;
use App\Services\Interfaces\ISpectrumSpecializationListService;

class SpectrumSpecializationListService implements ISpectrumSpecializationListService{
    private $specializationList;

    public function __construct(SpectrumSpecializationListContract $specializationList){
        $this->specializationList = $specializationList;
    }

    // adds a new specialization to the list
    public function addNewSpecializations($data){
        $this->specializationList->create($data);
    }

    // returns all the specialization
    public function getAllSpecializations(){
        return $this->specializationList->all();
    }
}