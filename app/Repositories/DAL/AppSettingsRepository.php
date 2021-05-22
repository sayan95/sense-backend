<?php

namespace App\Repositories\DAL;

use App\Model\App\General\Settings;
use App\Repositories\DAL\BaseRepository;
use App\Repositories\Contracts\AppSettingsContract;

class AppSettingsRepository extends BaseRepository implements AppSettingsContract{
    //  returns the associate model class
    public function model(){
        return Settings::class;
    }

    // returns the one and only settings entry of the ap
    public function getAppSettingsEntry(){
        return Settings::first();
    }
} 