<?php

namespace App\Console\Commands;

use App\Jobs\CheckIngredients;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to redis channel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $redis = Redis::connection('inbound');
        $redis->psubscribe(['storeroom.*'], function (string $message, string $channel) {
            info('New message from redis to Bodega');
            info($channel);
            info($message);

            if ($channel === config('channels.request-ingredients')) {
                info('Dispatching CheckIngredients');
                CheckIngredients::dispatch(json_decode($message, true));
            }
        });
    }
}