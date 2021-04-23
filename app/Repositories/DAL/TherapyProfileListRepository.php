<?php

namespace App\Repositories\DAL;

use App\Model\App\DataService\TherapyProfileList;
use App\Repositories\Contracts\TherapyProfileListContract;

class TherapyProfileListRepository extends BaseRepository implements TherapyProfileListContract{
    //  returns the associate model class
    public function model(){
        return TherapyProfileList::class;
    }
}