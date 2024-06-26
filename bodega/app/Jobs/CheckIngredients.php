<?php

namespace App\Jobs;

use App\Events\IngredientPurchased;
use App\Models\Ingredient;
use App\Models\Inventory;
use App\Models\Purchase;
use App\Services\MarketService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CheckIngredients implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $published = [];

    /**
     * Create a new job instance.
     */
    public function __construct(private array $order)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(MarketService $market_service): void
    {
        $redis = Redis::connection('outbound');
        $redis->publish(config('channels.checking-ingredients'), json_encode(['order_id' => $this->order['order_id']]));

        DB::beginTransaction();
        $ingredients = Ingredient::query()
            ->whereIn('name', Arr::pluck($this->order['ingredients'], 'name'))
            ->get();

        try {
            while (!$this->ingredientsAreReady($this->order['ingredients'])) {
                foreach ($this->order['ingredients'] as &$ingredient) {
                    if ($ingredient['ready'] ?? null) {
                        continue;
                    }

                    $ingredient_model = $ingredients->where('name', $ingredient['name'])->first();
                    $ingredient_id = $ingredient_model->id;
                    $qty_available = Inventory::where('ingredient_id', $ingredient_id)->first()->quantity;
                    info($ingredient['name']);
                    info('Quantity available: ' . $qty_available);

                    if ($qty_available >= $ingredient['quantity']) {
                        info($ingredient['name'] . ' READY');
                        $ingredient['ready'] = true;
                        $ingredient['id'] = $ingredient_id;
                    } else {
                        $this->publishOnce($redis, config('channels.buying-ingredients'), json_encode(['order_id' => $this->order['order_id']]));

                        info('BUYING ' . $ingredient['name']);
                        $quantity_bought = $market_service->buyIngredient($ingredient_model);
                        info('BOUGHT ' . $quantity_bought);

                        if ($quantity_bought > 0) {
                            $purchase = Purchase::query()
                                ->create([
                                    'ingredient_id' => $ingredient_id,
                                    'quantity' => $quantity_bought,
                                ]);

                            broadcast(new IngredientPurchased($purchase));

                            Inventory::query()
                                ->where('ingredient_id', $ingredient_id)
                                ->increment('quantity', $quantity_bought);
                        }
                    }
                }
            }
        } catch (\Exception $exception) {
            report($exception);

            DB::commit();

            info('Publishing ' . config('channels.order-failed'));
            info('Payload:');
            info(print_r(['order_id' => $this->order['order_id']], true));
            $redis->publish(config('channels.order-failed'), json_encode(['order_id' => $this->order['order_id']]));

            return;
        }

        $this->reduceInventory($this->order['ingredients']);

        BroadcastInventory::dispatch();

        DB::commit();

        info('Publishing ' . config('channels.ingredients-ready'));
        info('Payload:');
        info(print_r(['order_id' => $this->order['order_id']], true));

        $redis->publish(config('channels.ingredients-ready'), json_encode(['order_id' => $this->order['order_id']]));
    }

    private function ingredientsAreReady(array $ingredients): bool
    {
        foreach ($ingredients as $ingredient) {
            if (!array_key_exists('ready', $ingredient)) {
                return false;
            }
        }

        return true;
    }

    private function reduceInventory(array $ingredients): void
    {
        foreach ($ingredients as $ingredient) {
            Inventory::query()
                ->where('ingredient_id', $ingredient['id'])
                ->decrement('quantity', $ingredient['quantity']);
        }
    }

    private function publishOnce($redis, string $channel, string $payload): void
    {
        if (!array_key_exists($channel, $this->published)) {
            $redis->publish($channel, $payload);
        }
    }
}
