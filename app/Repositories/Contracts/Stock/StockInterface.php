<?php

namespace App\Repositories\Contracts\Stock;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface StockInterface
{
    /**
     * @param Request $request
     * @param string $sku
     *
     * @return JsonResponse
    */
    public function update(Request $request, string $sku): JsonResponse;
}