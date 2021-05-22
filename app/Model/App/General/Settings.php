<?php

namespace App\Model\App\General;

use App\Model\BaseModel;
use Illuminate\Support\Facades\Storage;

class Settings extends BaseModel
{
    // fillable properties
    protected $fillable = ['app_name', 'app_logo'];

    // returns the server's file storage path
    public function getAppLogoAttribute($value){
        return Storage::disk('public')->url("image/".$value);
    }
}
