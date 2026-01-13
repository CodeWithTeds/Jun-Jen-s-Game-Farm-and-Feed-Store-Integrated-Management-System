<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use App\Listeners\LogSuccessfulLogin;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Contracts\UserRepositoryInterface::class,
            \App\Repositories\Eloquent\UserRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\GameFowlRepositoryInterface::class,
            \App\Repositories\Eloquent\GameFowlRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\EggCollectionRepositoryInterface::class,
            \App\Repositories\Eloquent\EggCollectionRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\HatcheryRecordRepositoryInterface::class,
            \App\Repositories\Eloquent\HatcheryRecordRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\ChickRearingRepositoryInterface::class,
            \App\Repositories\Eloquent\ChickRearingRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\FeedRepositoryInterface::class,
            \App\Repositories\Eloquent\FeedRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(\App\Observers\UserObserver::class);
        Event::listen(Login::class, LogSuccessfulLogin::class);

        Gate::define('view-users', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('create-users', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('edit-users', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('delete-users', function (User $user) {
            return $user->isAdmin();
        });
    }
}
