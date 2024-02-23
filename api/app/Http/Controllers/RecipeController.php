<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;

class RecipeController extends Controller
{
    public function index()
    {
        $redis = Redis::connection('outbound');
        $redis->publish(config('channels.broadcast-recipes'), '');
    }
}
