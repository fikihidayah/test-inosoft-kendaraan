<?php

namespace App\Http\Controllers\Kendaraan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kendaraan\Mobil\StoreRequest;
use App\Http\Requests\Kendaraan\Mobil\UpdateRequest;
use App\Interface\Kendaraan\MobilInterface;
use App\Models\Kendaraan\Mobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    public function __construct(private MobilInterface $mobil)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => 200,
            'data' => $this->mobil->getAll()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Kendaraan\Mobil\StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $kendaraan_data = $this->getKendaraanData($request);

        $mobil_data = $this->getMobilData($request);

        $created = $this->mobil->create($kendaraan_data, $mobil_data);

        return response()->json([
            'status' => 201,
            'message' => 'Berhasil menambahkan data mobil',
            'data' => $created,
        ], 201);
    }

    private function getKendaraanData($request): array
    {
        $data['stok'] = 0;
        if ($request->has('tahun_keluaran')) {
            $data['tahun_keluaran'] = $request->input('tahun_keluaran');
        }
        if ($request->has('warna')) {
            $data['warna'] = $request->input('warna');
        }
        if ($request->has('harga')) {
            $data['harga'] = $request->input('harga');
        }
        return $data;
    }

    public function getMobilData($request): array
    {
        return [
            'mesin' => $request->input('mesin'),
            'kapasitas_penumpang' => $request->input('kapasitas_penumpang'),
            'tipe' => $request->input('tipe'),
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kendaraan\Mobil  $mobil
     * @return \Illuminate\Http\Response
     */
    public function show(Mobil $mobil)
    {
        return response()->json([
            'status' => 200,
            'data' => $this->mobil->getOne($mobil),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kendaraan\Mobil  $mobil
     * @return \Illuminate\Http\Response
     */
    public function edit(Mobil $mobil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Kendaraan\Mobil\UpdateRequest $request
     * @param  \App\Models\Kendaraan\Mobil  $mobil
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Mobil $mobil)
    {
        $kendaraan_data = $this->getKendaraanData($request);
        $mobil_data = $this->getMobilData($request);

        $updated = $this->mobil->update($mobil, $mobil_data, $kendaraan_data);

        return response()->json([
            'status' => 200,
            'message' => 'Berhasil mengubah data mobil',
            'data' => $updated,
        ]);
    }

    public function getStok(Mobil $mobil)
    {
        return response()->json([
            'status' => 200,
            'data' => $this->mobil->getStok($mobil->id),
        ]);
    }

    public function updateStok(Request $request, Mobil $mobil)
    {
        $validated = $request->validate(['stok' => 'required']);

        $id = $this->mobil->updateStok($mobil, $validated['stok']);
        return response()->json([
            'status' => 200,
            'data' => $this->mobil->getStok($id),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kendaraan\Mobil  $mobil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mobil $mobil)
    {
        $deleted = $this->mobil->delete($mobil);
        if ($deleted) {
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil menghapus data mobil',
            ]);
        }
    }
}
