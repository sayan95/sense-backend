<?php

namespace App\Repositories\DAL;

use App\Model\App\DataService\SpectrumSpecializationList;
use App\Repositories\Contracts\SpectrumSpecializationListContract;

class SpectrumSpecializationListRepository extends BaseRepository implements SpectrumSpecializationListContract{
    //  returns the associate model class
    public function model(){
        return SpectrumSpecializationList::class;
    }
}