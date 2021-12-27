<?php

namespace App\Repositories\Orm\Stock;

use App\Historic;
use App\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use \App\Repositories\Contracts\Stock\StockInterface;

class StockRepository implements StockInterface
{
    /**
     * @inheritDoc
     */
    public function update(Request $request, string $sku): JsonResponse
    {
        try {
            $product = Product::where('sku', $sku)->first();
            $balance = $request->operation_type == 'credit'
                ? $product->initial_quantity + $request->operation_value
                : $product->initial_quantity - $request->operation_value;

            Historic::create([
                'operation_type' => $request->operation_type,
                'operation_value' => $request->operation_value,
                'previous_balance' => $product->initial_quantity,
                'current_inventory' => $balance,
                'product_id' => $product->id
            ]);
            $product->initial_quantity = $balance;
            $product->save();

            return response()->json(['product' => $product]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json(['error' => 'Não foi possível atualizar o estoque'], 400);
        }
    }
}