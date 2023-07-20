<?php

namespace App\Http\Controllers;

use App\Http\Requests\Laporan\KendaraanRequest;
use App\Interface\SaleInterface;
use App\Models\Sale;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function __construct(private SaleInterface $sale)
    {
    }

    public function __invoke(KendaraanRequest $request)
    {
        $validated = $request->validated();
        return response()->json([
            'status' => 200,
            'data' => $this->sale->filter($validated),
        ]);
    }
}
