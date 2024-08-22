<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(): View | Factory | Application
    {
        $users = User::query()->whereNot('id', auth()->id())->get();

        return view('dashboard', compact('users'));
    }
}
