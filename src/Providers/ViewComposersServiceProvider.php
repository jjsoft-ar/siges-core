<?php

namespace JJSoft\SigesCore\Providers;

use Illuminate\Support\ServiceProvider;
use JJSoft\SigesCore\Notifications\ViewComposers\InAppNotificationsViewComposer;

class ViewComposersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('jplatformui::partials.nav', InAppNotificationsViewComposer::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
