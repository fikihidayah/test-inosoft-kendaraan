<?php

namespace App\Repository\Kendaraan;

use App\Interface\Kendaraan\MotorInterface;
use App\Models\Kendaraan;
use App\Models\Kendaraan\Motor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class MotorRepository implements MotorInterface
{
  private $session;
  public function __construct()
  {
    $this->session = DB::getMongoClient()->startSession();
  }

  public function getAll(): Collection
  {
    return Motor::with('kendaraan')->get();
  }

  public function create(array $kendaraan_data, array $motor_data): Motor
  {
    $this->session->startTransaction();
    try {
      // Perform actions.
      $kendaraan = Kendaraan::create($kendaraan_data);
      $motor_data['kendaraan_id'] = $kendaraan->_id;

      $result = Motor::create($motor_data);
      $this->session->commitTransaction();
      return $result;
    } catch (\Exception $e) {
      $this->session->abortTransaction();
      throw new \Exception($e->getMessage());
    }
  }

  public function getOne(Motor $motor): Motor
  {
    return $motor->with('kendaraan')->first();
  }

  public function update(Motor $data, array $new_motor_data, array $new_kendaran_data = []): Motor
  {
    $this->session->startTransaction();
    try {
      if (isset($new_kendaran_data['kendaraan_id'])) {
        $data->kendaraan_id = $new_motor_data['kendaraan_id'];
      }
      $data->mesin = $new_motor_data['mesin'];
      $data->tipe_suspensi = $new_motor_data['tipe_suspensi'];
      $data->tipe_transmisi = $new_motor_data['tipe_transmisi'];

      if (isset($new_kendaran_data['tahun_keluaran'])) {
        $data->kendaraan->tahun_keluaran = $new_kendaran_data['tahun_keluaran'];
      }

      if (isset($new_kendaran_data['warna'])) {
        $data->kendaraan->warna = $new_kendaran_data['warna'];
        $data->kendaraan->harga = $new_kendaran_data['harga'];
      }

      if (isset($new_kendaran_data['harga'])) {
        $data->kendaraan->harga = $new_kendaran_data['harga'];
      }

      $data->save();
      $this->session->commitTransaction();
      return $data;
    } catch (\Exception $e) {
      $this->session->abortTransaction();
      throw new \Exception($e->getMessage());
    }
  }

  public function delete(Motor $motor): bool
  {
    $this->session->startTransaction();
    try {
      $motor->kendaraan->delete();
      $result = $motor->delete();
      $this->session->commitTransaction();
      return $result;
    } catch (\Exception $e) {
      $this->session->abortTransaction();
      throw new \Exception($e->getMessage());
    }
  }

  public function updateStok(Motor $data, int $stok): string
  {
    $this->session->startTransaction();
    try {
      $data->kendaraan->stok = $stok;
      $data->kendaraan->save();
      return $data->_id;
    } catch (\Exception $e) {
      $this->session->abortTransaction();
      throw new \Exception($e->getMessage());
    }
  }

  public function getStok(string $id): Motor
  {
    return Motor::with('kendaraan:id,stok')->select(['mesin', 'tipe_suspensi', 'kendaraan_id'])->find($id);
  }

  public function findByIdKendaraan(string $id): Motor
  {
    return Motor::with('kendaraan')->whereHas('kendaraan', function ($query) use ($id) {
      return $query->findOrFail($id);
    })->first();
  }
}
