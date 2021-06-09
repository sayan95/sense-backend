<?php

namespace App\Http\Controllers\Web\Connection;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IAppSettingsService;

/**
 *  Checks the database is vconnected or not
 */
class DBConnectionController extends Controller
{
    private $appService;

    public function __construct(IAppSettingsService $appService ){
        $this->appService = $appService;
    }

    public function checkDBConnection(){
        try{
            $this->appService->getAllAppSettings();
        }catch(\Exception $e){
            // log the error
            Log::channel('applicationLog')
                ->critical('#error '.$e->getMessage().'. #Resolution: Database connection failure.');
            
            // return error resposne
            return response()->json([
                'alertType' => 'internal-error',
                'message' => 'Something went wrong! please try after sometime.'
            ], 500);
        }

        // return success error
        return response()->json([
            'alertType' => 'db-connction-success',
            'message' => 'connection to database succeded'
        ], 200);
    }
}
