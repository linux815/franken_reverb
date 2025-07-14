<?php

namespace App\Services;

use App\DTO\UpdateUserProfileDTO;
use App\Models\User;
use App\Services\Contracts\UserServiceInterface;

class UserService implements UserServiceInterface
{
    public function updateProfile(User $user, UpdateUserProfileDTO $dto): void
    {
        $user->fill([
            'name' => $dto->name,
            'email' => $dto->email,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
    }
}
