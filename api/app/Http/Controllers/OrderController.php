<?php

namespace App\Http\Controllers;

use App\Events\OrderDispatched;
use App\Services\KitchenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    public function process(): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        $redis = Redis::connection('outbound');
        $redis->publish(config('channels.new-order'), json_encode([
            'user_id' => $user->id,
        ]));

        broadcast(new OrderDispatched($user));

        return response()->json([
            'success' => true,
        ]);
    }
}
