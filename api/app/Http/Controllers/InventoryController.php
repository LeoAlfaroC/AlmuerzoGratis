<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class InventoryController extends Controller
{
    public function index()
    {
        $redis = Redis::connection('outbound');
        $redis->publish(config('channels.broadcast-inventory'), '');
    }
}
