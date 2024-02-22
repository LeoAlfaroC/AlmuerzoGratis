<?php

namespace App\Jobs;

use App\Events\BuyingIngredients;
use App\Events\CheckingIngredients;
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
        broadcast(new CheckingIngredients($this->order['order_id'], $this->order['user_id']));

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
                        broadcast(new BuyingIngredients($this->order['order_id'], $this->order['user_id']));
                        info('BUYING ' . $ingredient['name']);
                        $quantity_bought = $market_service->buyIngredient($ingredient_model);
                        info('BOUGHT ' . $quantity_bought);

                        Purchase::query()
                            ->create([
                                'ingredient_id' => $ingredient_id,
                                'quantity' => $quantity_bought,
                            ]);

                        Inventory::query()
                            ->where('ingredient_id', $ingredient_id)
                            ->increment('quantity', $quantity_bought);
                    }
                }
            }
        } catch (\Exception $exception) {
            report($exception);

            DB::commit();

            info('Publishing ' . config('channels.order-failed'));
            info('Payload:');
            info(print_r(['order_id' => $this->order['order_id']], true));
            $redis = Redis::connection('outbound');
            $redis->publish(config('channels.order-failed'), json_encode(['order_id' => $this->order['order_id']]));

            return;
        }

        $this->reduceInventory($this->order['ingredients']);

        DB::commit();

        info('Publishing ' . config('channels.ingredients-ready'));
        info('Payload:');
        info(print_r(['order_id' => $this->order['order_id']], true));

        $redis = $redis ?? Redis::connection('outbound');
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
}
