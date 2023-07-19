<?php

namespace App\Http\Controllers\Kendaraan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kendaraan\Motor\StoreRequest;
use App\Http\Requests\Kendaraan\Motor\UpdateRequest;
use App\Interface\Kendaraan\MotorInterface;
use App\Models\Kendaraan\Motor;
use Illuminate\Http\Request;

class MotorController extends Controller
{
    public function __construct(private MotorInterface $motor)
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
            'data' => $this->motor->getAll()
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
     * @param  \App\Http\Requests\Kendaraan\Motor\StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $kendaraan_data = $this->getKendaraanData($request);

        $motor_data = $this->getMotorData($request);

        $created = $this->motor->create($kendaraan_data, $motor_data);

        return response()->json([
            'status' => 201,
            'message' => 'Berhasil menambahkan data motor',
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

    public function getMotorData($request): array
    {
        return [
            'mesin' => $request->input('mesin'),
            'tipe_suspensi' => $request->input('tipe_suspensi'),
            'tipe_transmisi' => $request->input('tipe_transmisi'),
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kendaraan\Motor  $motor
     * @return \Illuminate\Http\Response
     */
    public function show(Motor $motor)
    {
        return response()->json([
            'status' => 200,
            'data' => $this->motor->getOne($motor),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kendaraan\Motor  $motor
     * @return \Illuminate\Http\Response
     */
    public function edit(Motor $motor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Kendaraan\Motor\UpdateRequest $request
     * @param  \App\Models\Kendaraan\Motor  $motor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Motor $motor)
    {
        $kendaraan_data = $this->getKendaraanData($request);
        $motor_data = $this->getMotorData($request);

        $updated = $this->motor->update($motor, $motor_data, $kendaraan_data);

        return response()->json([
            'status' => 200,
            'message' => 'Berhasil mengubah data motor',
            'data' => $updated,
        ]);
    }

    public function getStok(Motor $motor)
    {
        return response()->json([
            'status' => 200,
            'data' => $this->motor->getStok($motor->id),
        ]);
    }

    public function updateStok(Request $request, Motor $motor)
    {
        $validated = $request->validate(['stok' => 'required']);

        $id = $this->motor->updateStok($motor, $validated['stok']);
        return response()->json([
            'status' => 200,
            'data' => $this->motor->getStok($id),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kendaraan\Motor  $motor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Motor $motor)
    {
        $deleted = $this->motor->delete($motor);
        if ($deleted) {
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil menghapus data motor',
            ]);
        }
    }
}
