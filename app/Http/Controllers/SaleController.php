<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sale\StoreRequest;
use App\Interface\Kendaraan\MobilInterface;
use App\Interface\Kendaraan\MotorInterface;
use App\Interface\SaleInterface;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct(
        private SaleInterface $sale,
        private MobilInterface $mobil,
        private MotorInterface $motor
    ) {
    }

    public function index()
    {
        return response()->json([
            'status' => 200,
            'data' => $this->sale->getAll()
        ]);
    }


    // Problem saat get data, kendaraan
    // Task sisa, membuat fitur penjualan, laporan dan unit test
    public function store(StoreRequest $request)
    {
        $id = $request->input('kendaraan_id');
        $data = [
            'kendaraan_id' => $id,
            'jumlah' => $request->input('jumlah'),
            'total_harga' => $request->input('total_harga'),
        ];

        if ($request->input('tipe') == 'mobil') {
            $mobil = $this->mobil->findById($id);
            $stok = $mobil->kendaraan->stok - 1;
            $this->mobil->updateStok($mobil, $stok);
        }

        if ($request->input('tipe') == 'motor') {
            $motor = $this->motor->findById($id);
            $stok = $motor->kendaraan->stok + 1;
            $this->motor->updateStok($motor, $stok);
        }

        return response()->json([
            'status' => 201,
            'message' => 'Berhasil menambahan transaksi penjualan!',
            'data' => $this->sale->create($data),
        ]);
    }

    public function destroy(Sale $sale)
    {
        $deleted = $this->sale->delete($sale);
        if ($deleted) {
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil menghapus data penjualan',
            ]);
        }
    }
}
