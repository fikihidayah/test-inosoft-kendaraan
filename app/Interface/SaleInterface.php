<?php

namespace App\Interface;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;

interface SaleInterface
{
  public function getAll(): Collection;
  public function create(array $data): Sale;
  public function getOne(Sale $sale): Sale;
  public function delete(Sale $data): bool;
}
