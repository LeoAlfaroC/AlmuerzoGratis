<?php

namespace App\Jobs;

use App\Events\PreparingOrder;
use App\Models\Order;
use App\Models\Recipe;
use App\Serializers\OrderSerializer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class PrepareOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(readonly private array $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(OrderSerializer $serializer): void
    {
        $recipe = Recipe::query()
            ->inRandomOrder()
            ->with('ingredients')
            ->first();
        $new_order = Order::query()
            ->create([
                'user_id' => $this->user['user_id'],
                'recipe_id' => $recipe->id,
            ]);

        broadcast(new PreparingOrder($new_order));

        info('Publishing ' . config('channels.request-ingredients'));
        info('Payload:');
        info(print_r($serializer->serialize($new_order, $recipe), true));

        $redis = Redis::connection('outbound');
        $redis->publish(config('channels.request-ingredients'), $serializer->serialize($new_order, $recipe));
    }
}
