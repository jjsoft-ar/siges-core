<?php

namespace JJSoft\SigesCore\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use JJSoft\SigesCore\Auth\AppAuthenticationProvider;

class SigesCoreServiceProvider extends ServiceProvider
{

    /**
     * Service providers to load
     * @var array
     */
    protected $providers = [
        \Joselfonseca\LaravelApiTools\LaravelApiToolsServiceProvider::class,
        \Pingpong\Generators\GeneratorsServiceProvider::class,
        \JJSoft\SigesUi\Providers\SigesUiServiceProvider::class,
        \Joselfonseca\LaravelTactician\Providers\LaravelTacticianServiceProvider::class,
        \Styde\Html\HtmlServiceProvider::class,
        \Pingpong\Menus\MenusServiceProvider::class,
        \JJSoft\SigesCore\Providers\MenuServiceProvider::class,
        \Pingpong\Widget\WidgetServiceProvider::class,
        \Pingpong\Modules\ModulesServiceProvider::class,
        \Barryvdh\Debugbar\ServiceProvider::class,
        \Baum\Providers\BaumServiceProvider::class,
        \Laracasts\Utilities\JavaScript\JavaScriptServiceProvider::class,
        \UxWeb\SweetAlert\SweetAlertServiceProvider::class,
        \yajra\Datatables\DatatablesServiceProvider::class,
        \Joselfonseca\ImageManager\ImageManagerServiceProvider::class,
        \JJSoft\SigesCore\Providers\ViewComposersServiceProvider::class,
        \Maatwebsite\Excel\ExcelServiceProvider::class,
        \Prettus\Repository\Providers\RepositoryServiceProvider::class,
        \Fenos\Notifynder\NotifynderServiceProvider::class,
        Elibyy\TCPDF\ServiceProvider::class,

    ];

    protected $aliases = [
        'MenuPing' => \Pingpong\Menus\MenuFacade::class,
        'Module' => \Pingpong\Modules\Facades\Module::class,
        'Widget' => \Pingpong\Widget\WidgetFacade::class,
        'Debugbar' => \Barryvdh\Debugbar\Facade::class,
        'Uuid' => \Webpatser\Uuid\Uuid::class,
        'SweetAlert' => \UxWeb\SweetAlert\SweetAlert::class,
        'Excel' => \Maatwebsite\Excel\Facades\Excel::class,
        'Notifynder' => Fenos\Notifynder\Facades\Notifynder::class,
        'PDF' => Elibyy\TCPDF\Facades\TCPDF::class
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../resources/assets' => public_path('vendor/siges'),
        ], 'public');
        app('Dingo\Api\Auth\Auth')->extend('inSession', function ($app) {
            return app('siges.auth.provider');
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerOtherProviders()->registerAliases();
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'siges');
        $this->app->bind('siges.auth.provider', AppAuthenticationProvider::class);
        $this->loadRoutes();
    }

    /**
     * Register other Service Providers
     * @return $this
     */
    private function registerOtherProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
        return $this;
    }

    /**
     * Register some Aliases
     * @return $this
     */
    protected function registerAliases()
    {
        foreach ($this->aliases as $alias => $original) {
            AliasLoader::getInstance()->alias($alias, $original);
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function loadRoutes()
    {
        require_once __DIR__.'/../Http/routes.php';
        return $this;
    }
}
