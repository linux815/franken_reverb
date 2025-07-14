<?php

namespace App\Services\Contracts;

use App\DTO\UpdateUserProfileDTO;
use App\Models\User;

interface UserServiceInterface
{
    public function updateProfile(User $user, UpdateUserProfileDTO $dto): void;
}
