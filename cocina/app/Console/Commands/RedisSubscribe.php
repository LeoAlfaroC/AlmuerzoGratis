<?php

namespace App\Console\Commands;

use App\Jobs\BroadcastOrders;
use App\Jobs\BuyingIngredientsForOrder;
use App\Jobs\CheckingIngredientsForOrder;
use App\Jobs\FinishOrder;
use App\Jobs\PrepareOrder;
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
        ini_set('default_socket_timeout', -1);

        $redis = Redis::connection('inbound');
        $redis->psubscribe(['kitchen.*'], function (string $message, string $channel) {
            info('New message from redis to Cocina');
            info($channel);
            info($message);

            if ($channel === config('channels.new-order')) {
                info('Dispatching PrepareOrder');
                PrepareOrder::dispatch(json_decode($message, true));
            }

            if ($channel === config('channels.checking-ingredients')) {
                info('Dispatching CheckingIngredientsForOrder');
                CheckingIngredientsForOrder::dispatch(json_decode($message, true));
            }

            if ($channel === config('channels.buying-ingredients')) {
                info('Dispatching BuyingIngredientsForOrder');
                BuyingIngredientsForOrder::dispatch(json_decode($message, true));
            }

            if ($channel === config('channels.ingredients-ready')) {
                info('Dispatching FinishOrder');
                FinishOrder::dispatch(json_decode($message, true))->delay(now()->addSecond());
            }

            if ($channel === config('channels.broadcast-orders')) {
                info('Dispatching BroadcastOrders');
                BroadcastOrders::dispatch(json_decode($message, true));
            }
        });
    }
}
