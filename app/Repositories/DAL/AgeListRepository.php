<?php

namespace App\Repositories\DAL;

use App\Model\App\DataService\AgeList;
use App\Repositories\Contracts\AgeListContract;

class AgeListRepository extends BaseRepository implements AgeListContract{
    //  returns the associate model class
    public function model(){
        return AgeList::class;
    }
}