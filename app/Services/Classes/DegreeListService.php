<?php

namespace App\Services\Classes;

use App\Repositories\Contracts\DegreeListContract;
use App\Services\Interfaces\IDegreeListService;

class DegreeListService implements IDegreeListService{
    private $degreeList;

    public function __construct(DegreeListContract $degreeList){
        $this->degreeList = $degreeList;
    }

    // adds new degree to the degree list
    public function addNewDegree($data){
        $this->degreeList->create($data);
    }

    // gets all the degrees
    public function getAllDegrees(){
        return $this->degreeList->all();
    }
}