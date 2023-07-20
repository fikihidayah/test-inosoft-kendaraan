<?php

namespace App\Interface;

use App\Models\User;

interface UserInterface
{
  public function store(array $data): User;
}
