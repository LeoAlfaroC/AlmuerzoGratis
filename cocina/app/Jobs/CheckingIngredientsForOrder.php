<?php

namespace App\Jobs;

use App\Events\CheckingIngredients;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckingIngredientsForOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(readonly private array $order)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = Order::query()
            ->where('id', $this->order['order_id'])
            ->first();

        $order->status = 'Buscando ingredientes';
        $order->save();

        broadcast(new CheckingIngredients($order));
    }
}
