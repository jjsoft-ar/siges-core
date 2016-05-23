<?php

namespace JJSoft\SigesCore\Providers;

use MenuPing;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!MenuPing::instance('sidebar')) {
            MenuPing::create('sidebar', function ($menu) {
                $menu->enableOrdering();
                $menu->setPresenter('JJSoft\SigesCore\Menu\Presenters\SidebarMenuPresenter');
            });
        }
        if (!MenuPing::instance('config')) {
            MenuPing::create('config', function ($menu) {
                $menu->dropdown('Configuración', function ($sub) {

                }, ['icon' => 'fa fa-cogs']);
                $menu->setPresenter('JJSoft\SigesCore\Menu\Presenters\SidebarMenuPresenter');
            });
        }
        if (!MenuPing::instance('topnav')) {
            MenuPing::create('topnav', function ($menu) {
                $menu->enableOrdering();
            });
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
