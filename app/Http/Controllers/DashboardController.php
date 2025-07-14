<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly Authenticatable $authUser,
    ) {}

    public function index(): View
    {
        $users = $this->userRepository->getAllExcept($this->authUser->getAuthIdentifier());

        return view('dashboard', [
            'users' => UserResource::collection($users),
        ]);
    }
}
