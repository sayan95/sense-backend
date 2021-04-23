<?php

namespace App\Services\Classes;

use App\Repositories\Contracts\ExpertiesListContract;
use App\Services\Interfaces\IExpertiesListService;

class  ExpertiesListService implements IExpertiesListService{
    private $expertiesList;

    public function __construct(ExpertiesListContract $expertiesList){
        $this->expertiesList = $expertiesList;
    }

    // adds new experties to the list
    public function addNewExperties($data){
        $this->expertiesList->create($data);
    }

    // returns all the experties
    public function getAllExperties(){
        return $this->expertiesList->all();
    }
}