<?php

namespace App\Serializers;

use App\Models\Order;
use App\Models\Recipe;

class OrderSerializer
{
    public function serialize(Order $order, Recipe $recipe): string
    {
        $recipe->loadMissing('ingredients');

        $result = [
            'order_id' => $order->id,
            'ingredients' => [],
        ];

        foreach ($recipe->ingredients as $ingredient) {
            $result['ingredients'][] = [
                'name' => $ingredient->name,
                'quantity' => $ingredient->pivot->quantity,
            ];
        }

        return json_encode($result);
    }
}
