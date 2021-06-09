<?php

namespace App\Http\Controllers\Web\Connection;

use Throwable;
use App\Http\Controllers\Controller;

/**
 *  Cheks the connection health between backend and frontend
 */
class AppConnectionController extends Controller
{
    public function checkAppConnection(){
        return response()->json([
            'alertType' => 'connection-success',
            'message' => 'connection to API endpoints is established successfully'
        ], 200);
    }
}
