<?php

namespace App\Interface\Kendaraan;

use App\Models\Kendaraan\Motor;
use Illuminate\Database\Eloquent\Collection;

interface MotorInterface
{
  public function getAll(): Collection;
  public function create(array $kendaraan_data, array $motor_data): Motor;
  public function getOne(Motor $motor): Motor;
  public function update(Motor $data, array $new_data, array $new_kendaran_data): Motor;
  public function delete(Motor $data): bool;
  public function updateStok(Motor $data, int $stok): string;
  public function getStok(string $id): Motor;
  public function findByIdKendaraan(string $id): Motor;
}
