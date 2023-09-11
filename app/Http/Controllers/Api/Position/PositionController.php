<?php

namespace App\Http\Controllers\Api\Position;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    public function getPosition(Request $request){
        try {
            $apiInput = $request->input('api_key');
            $validApiKey = ApiKey::where('key', $apiInput)->first();
            if ($validApiKey){

                $position = DB::table('position')->get();
                return response()->json([
                    'code' => '200',
                    'status' => 'OK',
                    'data' => $position
                ], 200);
            }else{
                return response()->json([
                    'code' => '401',
                    'status' => 'UNAUTHORIZED',
                    'data' => 'Unauthorized'
                ], 401);
            }
        }catch (\Exception $e){
            return response()->json([
                'code' => '500',
                'status' => 'INTERNAL_SERVER_ERROR',
                'data' => $e->getMessage()
            ], 500);
        }
    }
}
