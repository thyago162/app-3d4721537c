<?php

namespace App\Repositories\Contracts\Product;

use App\Http\Requests\Product\ProductRequest;
use Illuminate\Http\JsonResponse;

interface ProductInterface
{
    /**
     * Retrive all the products
     *
     * @return JsonResponse
    */
    public function index();

    /**
     * Retrive one product
     *
     * @param int $id
     * @return JsonResponse
    */
    public function show(int $id);

    /**
     * Save one product
     *
     * @param ProductRequest $request
     * @return JsonResponse
    */
    public function store(ProductRequest $request);

    /**
     * Update one product
     *
     * @param ProductRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ProductRequest $request, int $id);

    /**
     * Remove one product
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id);
}
