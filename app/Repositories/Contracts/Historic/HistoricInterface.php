<?php

namespace App\Repositories\Contracts\Historic;

use Illuminate\Http\JsonResponse;

interface HistoricInterface
{
    /**
     * Retrive all the products
     *
     * @return JsonResponse
     */
    public function index();
}
