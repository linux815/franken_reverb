<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function getAllExcept(int $excludedUserId): Collection
    {
        return User::query()
            ->where('id', '!=', $excludedUserId)
            ->get();
    }
}
