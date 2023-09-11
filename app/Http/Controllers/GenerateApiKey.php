<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;

class GenerateApiKey extends Controller
{
    public function generateApiKey()
    {
        $apiKey = ApiKey::create([
            'key' => bin2hex(random_bytes(16)),
        ]);

        return response()->json(['api_key' => $apiKey->key]);
    }
}
