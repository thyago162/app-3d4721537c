<?php

namespace App\Repositories\Orm\Historic;

use App\Historic;
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
            $historic = Historic::orderBy('created_at', 'desc')
                ->sku(request('sku'))
                ->pagination(request('per_page'));

            return response()->json(['historic' => $historic]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json(['error' => 'Dados indisponíveis no momento'], 400);
        }
    }
}