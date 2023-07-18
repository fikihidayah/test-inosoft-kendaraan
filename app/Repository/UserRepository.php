<?php

namespace App\Repository;

use App\Interface\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{
  public function store(array $data): array
  {
    return User::create($data);
  }
}
