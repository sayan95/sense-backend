<?php

namespace App\Services\Classes;

use App\Repositories\Contracts\AppSettingsContract;
use App\Services\Interfaces\IAppSettingsService;


class AppSettingsService implements IAppSettingsService{
    private $appSettingsInfo; 

    public function __construct(AppSettingsContract $appSettingsInfo){
        $this->appSettingsInfo = $appSettingsInfo;
    }

    // returns all the application settings info
    public function getAllAppSettings(){
        return $this->appSettingsInfo->getAppSettingsEntry();
    }

    // update existing settings info
    public function updateAppSettings($id, $data){
        return $this->appSettingsInfo->update($id, $data); 
    }
}