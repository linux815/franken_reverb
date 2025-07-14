<?php

namespace App\Services\Contracts;

use App\Models\User;

interface AccountServiceInterface
{
    public function deleteUser(User $user): void;
}
