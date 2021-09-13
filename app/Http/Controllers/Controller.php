<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected function success($data, $message = null, $code = 200)
    {

        if($data!=null){
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data
            ], $code);
        }
        else{
            return response()->json([
                'success' => true,
                'message' => $message,
            ], $code);
        }
       
    }

    

    protected function error($message = null, $code)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
}
