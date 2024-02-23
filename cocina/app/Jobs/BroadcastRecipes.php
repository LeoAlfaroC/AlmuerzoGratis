<?php

namespace App\Jobs;

use App\Events\OrdersListed;
use App\Events\RecipesListed;
use App\Models\Order;
use App\Models\Recipe;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BroadcastRecipes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $recipes = Recipe::query()
            ->with('ingredients')
            ->get();
        broadcast(new RecipesListed($recipes));
    }
}
