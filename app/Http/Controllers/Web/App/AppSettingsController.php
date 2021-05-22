<?php

namespace App\Http\Controllers\Web\App;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\ICacheService;
use App\Services\Interfaces\IAppSettingsService;
use App\Http\Resources\App\GeneralSettingsService\AppSettingsResource;
use Illuminate\Support\Facades\Log;

class AppSettingsController extends Controller
{
    private $appSettingsService;
    private $cacheService;

    public function __construct(IAppSettingsService $appSettingsService, ICacheService $cacheService){
        $this->appSettingsService = $appSettingsService;  
        $this->cacheService = $cacheService;
    }

    //returns all the app settings info
    public function index(){
        try{
            // cache the data for smoother load
            $appSettingsInfo = $this->cacheService->rememberCache('appSettingsInfo', 6*60, [
                'appSettingsInfo' => new AppSettingsResource($this->appSettingsService->getAllAppSettings())
            ]);
            // return cached data
            return response()->json($appSettingsInfo, 200);
        }catch(\Exception $e){
            Log::channel('applicationLog')->critical('application settings info is not being loaded. #Origin: Check app-seetings-info-controller.');
            return response()->json([
                'alertType' => 'internal-error',
                'message' => 'Something went wrong! Please try after some time.'
            ], 500);
        }
    }
}
