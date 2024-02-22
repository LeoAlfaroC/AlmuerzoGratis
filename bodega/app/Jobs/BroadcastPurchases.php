<?php

namespace App\Jobs;

use App\Events\PurchasesListed;
use App\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BroadcastPurchases implements ShouldQueue
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
    public function handle(): void
    {
        $purchases = Purchase::query()
            ->orderBy('created_at', 'desc')
            ->take(30)
            ->get();
        broadcast(new PurchasesListed($this->user['user_id'], $purchases));
    }
}
