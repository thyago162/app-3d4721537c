<?php

namespace App\Http\Controllers\Api\Historic;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Historic\HistoricInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HistoricController extends Controller
{
    /**
     * @var HistoricInterface
    */
    private $historic;

    /**
     * @param HistoricInterface $historic
    */
    public function __construct(HistoricInterface $historic)
    {
        $this->historic = $historic;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            return $this->historic->index();
        } catch (\Exception $exception) {
            Log::error($exception);

            return response()->json(['error' => 'Não foi possível obter os dados'], 400);
        }
    }
}
