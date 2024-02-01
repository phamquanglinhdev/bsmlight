<?php

namespace App\Providers;

use App\Composer\MenuComposer;
use App\Composer\NotificationComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        View::composer('components.menu', MenuComposer::class);
        View::composer('notification-list', NotificationComposer::class);
    }
}
