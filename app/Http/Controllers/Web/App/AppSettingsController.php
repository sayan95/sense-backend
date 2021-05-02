<?php

namespace App\Http\Controllers\Web\App;

use Illuminate\Http\Request;
use App\Model\App\General\Settings;
use App\Http\Controllers\Controller;

class AppSettingsController extends Controller
{
    //returns all the app settings info
    public function index(){
        $settings = Settings::first();
        return response()->json([
            'appSettingsInfo' => $settings
        ], 200);
    }
}
