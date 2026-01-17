<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Feed;
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

        $this->app->bind(
            \App\Repositories\Contracts\FeedUsageRepositoryInterface::class,
            \App\Repositories\Eloquent\FeedUsageRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\ScheduleRepositoryInterface::class,
            \App\Repositories\Eloquent\ScheduleRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\FarmRecordRepositoryInterface::class,
            \App\Repositories\Eloquent\FarmRecordRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\SupplierRepositoryInterface::class,
            \App\Repositories\Eloquent\SupplierRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\CartRepositoryInterface::class,
            \App\Repositories\Eloquent\CartRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\OrderRepositoryInterface::class,
            \App\Repositories\Eloquent\OrderRepository::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\SalesTransactionRepositoryInterface::class,
            \App\Repositories\Eloquent\SalesTransactionRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(\App\Observers\UserObserver::class);
        Feed::observe(\App\Observers\FeedObserver::class);
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
