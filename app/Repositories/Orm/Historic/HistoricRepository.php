<?php

namespace App\Repositories\Orm\Historic;

use App\Historic;
use App\Product;
use Illuminate\Http\JsonResponse;
use \App\Repositories\Contracts\Historic\HistoricInterface;
use Illuminate\Support\Facades\Log;

class HistoricRepository implements HistoricInterface
{

    /**
     * @inheritDoc
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $id = null;
            if (request('search')) {
                $produto = Product::where('sku', 'like', '%' . request('search') . '%')->first();
                $id = $produto->id;
            }
            $stock_balance = Historic::with('product')
                ->orderBy('created_at', 'desc')
                ->sku($id)
                ->pagination(request('per_page'));

            return response()->json(['stock_balance' => $stock_balance]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json(['error' => 'Dados indisponíveis no momento'], 400);
        }
    }
}