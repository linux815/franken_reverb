<?php

namespace App\Services;

use App\Models\User;
use App\Services\Contracts\AccountServiceInterface;
use Illuminate\Support\Facades\Auth;

class AccountService implements AccountServiceInterface
{
    public function deleteUser(User $user): void
    {
        Auth::logout();

        $user->delete();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
