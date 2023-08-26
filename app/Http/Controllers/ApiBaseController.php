<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiBaseController extends Controller
{
    public function messageSuccess($message , $status = 200)  {
        return response()->json([
            'status' => 'success',
            'message' => $message,
        ],$status);
    }

    public function messageError($message , $status = 400)  {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ],$status);
    }


    public function respond($data){
        return response()->json($data);
    }
}
