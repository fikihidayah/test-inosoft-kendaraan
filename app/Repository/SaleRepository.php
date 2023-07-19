<?php

namespace App\Repository;

use App\Interface\SaleInterface;
use App\Models\Kendaraan;
use App\Models\Sale;
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
    return Sale::with('kendaraan')->get();
  }

  public function getOne(Sale $sale): Sale
  {
    return $sale;
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
}
