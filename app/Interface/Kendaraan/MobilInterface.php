<?php

namespace App\Interface\Kendaraan;

use App\Models\Kendaraan\Mobil;
use Illuminate\Database\Eloquent\Collection;

interface MobilInterface
{
  public function getAll(): Collection;
  public function create(array $kendaraan_data, array $mobil_data): Mobil;
  public function getOne(Mobil $mobil): Mobil;
  public function update(Mobil $data, array $new_data, array $new_kendaran_data): Mobil;
  public function delete(Mobil $data): bool;
  public function updateStok(Mobil $data, int $stok): string;
  public function getStok(string $id): Mobil;
  public function findByIdKendaraan(string $id): Mobil;
}
