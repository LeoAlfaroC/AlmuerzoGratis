<?php

namespace App\Services;

use App\Models\Ingredient;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MarketService
{
    private Client $client;
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('hosts.market-host'),
        ]);
    }

    public function buyIngredient(Ingredient $ingredient): int
    {
        try {
            $response = $this->client->get('/api/farmers-market/buy', [
                'query' => [
                    'ingredient' => Str::lower($ingredient->name),
                ],
            ]);

            $response = json_decode($response->getBody(), true);

            if ($response['quantitySold'] == 0) {
                Log::warning("Ingredient $ingredient->name not found in market :(");
            }

            return $response['quantitySold'];
        } catch (Exception $exception) {
            report($exception);
            throw $exception;
        }
    }
}
