<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class PurchaseController extends Controller
{
    public function index()
    {
        $user = Auth::guard('sanctum')->user();

        $redis = Redis::connection('outbound');
        $redis->publish(config('channels.broadcast-purchases'), json_encode([
            'user_id' => $user->id,
        ]));
    }
}
