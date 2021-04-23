<?php

namespace App\Repositories\DAL;

use App\Model\App\DataService\ExpertiesList;
use App\Repositories\Contracts\ExpertiesListContract;

class ExpertiesListRepository extends BaseRepository implements ExpertiesListContract{
    //  returns the associate model class
    public function model(){
        return ExpertiesList::class;
    }
}