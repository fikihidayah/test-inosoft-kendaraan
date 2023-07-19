<?php

namespace App\Repository\Kendaraan;

use App\Interface\Kendaraan\MobilInterface;
use App\Models\Kendaraan;
use App\Models\Kendaraan\Mobil;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class MobilRepository implements MobilInterface
{
  private $session;
  public function __construct()
  {
    $this->session = DB::getMongoClient()->startSession();
  }

  public function getAll(): Collection
  {
    return Mobil::with('kendaraan')->get();
  }

  public function create(array $kendaraan_data, array $mobil_data): Mobil
  {
    $this->session->startTransaction();
    try {
      // Perform actions.
      $kendaraan = Kendaraan::create($kendaraan_data);
      $mobil_data['kendaraan_id'] = $kendaraan->_id;

      $result = Mobil::create($mobil_data);
      $this->session->commitTransaction();
      return $result;
    } catch (\Exception $e) {
      $this->session->abortTransaction();
      throw new \Exception($e->getMessage());
    }
  }

  public function getOne(Mobil $mobil): Mobil
  {
    return $mobil->with('kendaraan')->first();
  }

  public function update(Mobil $data, array $new_mobil_data, array $new_kendaran_data = []): Mobil
  {
    $this->session->startTransaction();
    try {
      if (isset($new_kendaran_data['kendaraan_id'])) {
        $data->kendaraan_id = $new_mobil_data['kendaraan_id'];
      }
      $data->mesin = $new_mobil_data['mesin'];
      $data->kapasitas_penumpang = $new_mobil_data['kapasitas_penumpang'];
      $data->tipe = $new_mobil_data['tipe'];

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

  public function delete(Mobil $mobil): bool
  {
    $this->session->startTransaction();
    try {
      $mobil->kendaraan->delete();
      $result = $mobil->delete();
      $this->session->commitTransaction();
      return $result;
    } catch (\Exception $e) {
      $this->session->abortTransaction();
      throw new \Exception($e->getMessage());
    }
  }

  public function updateStok(Mobil $data, int $stok): string
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

  public function getStok(string $id): Mobil
  {
    return Mobil::with('kendaraan:id,stok')->select(['mesin', 'kapasitas_penumpang', 'kendaraan_id'])->find($id);
  }

  public function findById(string $id): Mobil
  {
    return Mobil::with('kendaraan')->findOrFail($id);
  }
}
