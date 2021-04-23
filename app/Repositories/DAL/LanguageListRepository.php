<?php

namespace App\Repositories\DAL;

use App\Model\App\DataService\LanguageList;
use App\Repositories\Contracts\LanguageListContract;

class LanguageListRepository extends BaseRepository implements LanguageListContract{
    //  returns the associate model class
    public function model(){
        return LanguageList::class;
    }
}