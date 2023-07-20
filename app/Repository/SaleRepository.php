<?php

namespace App\Repository;

use App\Interface\SaleInterface;
use App\Models\Kendaraan;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SaleRepository implements SaleInterface
{
  private $session;
  public function __construct()
  {
    $this->session = DB::getMongoClient()->startSession();
  }

  public function create(array $data): Sale
  {
    return Sale::create($data);
  }

  public function getAll(): Collection
  {
    $result = Sale::with('kendaraan', 'kendaraan.motor', 'kendaraan.mobil')->get();
    $result->transform(function ($value) {
      if (empty($value->kendaraan->motor)) unset($value->kendaraan->motor);
      if (empty($value->kendaraan->mobil)) unset($value->kendaraan->mobil);
      return $value;
    });

    return $result;
  }

  public function getOne(Sale $sale): Sale
  {
    $result = $sale->with('kendaraan', 'kendaraan.motor', 'kendaraan.mobil')->first();
    // manually
    if (empty($result->kendaraan->motor)) unset($result->kendaraan->motor);
    if (empty($result->kendaraan->mobil)) unset($result->kendaraan->mobil);

    return $result;
  }

  public function delete(Sale $sale): bool
  {
    $this->session->startTransaction();
    try {
      $result = $sale->delete();
      $this->session->commitTransaction();
      return $result;
    } catch (\Exception $e) {
      $this->session->abortTransaction();
      throw new \Exception($e->getMessage());
    }
  }

  public function filter(array $data): Collection
  {
    $date_start = Carbon::parse($data['tgl_awal'])->startOfDay();
    $date_end = Carbon::parse($data['tgl_akhir'])->endOfDay();

    $result = Sale::whereBetween('created_at', [$date_start, $date_end]);

    // magic, with eloquent
    if ($data['tipe'] == 'motor') {
      $result = $result->with('kendaraan', 'kendaraan.motor')->doesntHave('kendaraan.mobil');
    }

    if ($data['tipe'] == 'mobil') {
      $result = $result->with('kendaraan', 'kendaraan.mobil')->doesntHave('kendaraan.motor');
    }

    return $result->get();
  }
}
