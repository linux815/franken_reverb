<?php

namespace App\Providers;

use App\Factories\MessageFactory;
use App\Factories\MessageFactoryInterface;
use App\Repositories\Contracts\MessageRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\MessageRepository;
use App\Repositories\UserRepository;
use App\Services\AccountService;
use App\Services\ChatService;
use App\Services\Contracts\AccountServiceInterface;
use App\Services\Contracts\ChatServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\UserService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ChatServiceInterface::class, ChatService::class);
        $this->app->bind(MessageRepositoryInterface::class, MessageRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(
            MessageRepositoryInterface::class,
            MessageRepository::class,
        );

        $this->app->bind(
            MessageFactoryInterface::class,
            MessageFactory::class,
        );

        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(AccountServiceInterface::class, AccountService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
