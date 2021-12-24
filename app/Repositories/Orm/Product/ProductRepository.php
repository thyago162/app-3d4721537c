<?php

namespace App\Repositories\Orm\Product;

use App\Http\Requests\Product\ProductRequest;
use App\Product;
use App\Repositories\Contracts\Product\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductRepository implements ProductInterface
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        try {
            $product = Product::orderBy('created_at', 'desc')
                ->pagination(request('per_page'));

            return response()->json(['product' => $product]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json(['error' => 'Não foi possível carregar os produtos'], 400);
        }
    }

    /**
     * @inheritDoc
     */
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);

            return response()->json(['product' => $product]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json(['error' => 'Não foi possível encontrar o produto'], 400);
        }
    }

    /**
     * @inheritDoc
     */
    public function store(ProductRequest $request)
    {
        try {
            $product = Product::create([
                'name' => $request->name,
                'sku' => $request->sku,
                'initial_quantity' => $request->initial_quantity,
                'price' => $request->price
            ]);

            return response()->json(['product' => $product]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json(['error' => 'Não foi possível salvar o produto'], 400);
        }
    }

    /**
     * @inheritDoc
     */
    public function update(ProductRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->sku = $request->sku;
            $product->initial_quantity = $request->initial_quantity;
            $product->price = $request->price;

            return response()->json(['product' => $product]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json(['error' => 'Não foi possível atualizar o produto'], 400);
        }
    }

    /**
     * @inheritDoc
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json(['product' => $product]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json(['error' => 'Não foi possível atualizar o produto'], 400);
        }
    }
}