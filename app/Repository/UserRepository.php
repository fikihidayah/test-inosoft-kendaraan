<?php

namespace App\Repository;

use App\Interface\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{
  public function store(array $data): User
  {
    return User::create($data);
  }
}
