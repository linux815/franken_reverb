<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Services\Contracts\UserServiceInterface;
use App\Services\Contracts\AccountServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly AccountServiceInterface $accountService,
    ) {}

    public function edit(): View
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $this->userService->updateProfile(
            user: $request->user(),
            dto: $request->toDTO()
        );

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(DeleteUserRequest $request): RedirectResponse
    {
        $this->accountService->deleteUser($request->user());

        return Redirect::to('/');
    }
}
