<?php

namespace App\Repositories\DAL;

use App\Model\App\DataService\DegreeList;
use App\Repositories\Contracts\DegreeListContract;

class DegreeListRepository extends BaseRepository implements DegreeListContract{
    //  returns the associate model class
    public function model(){
        return DegreeList::class;
    }
}