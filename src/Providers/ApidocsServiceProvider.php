<?php

namespace Johnylemon\Apidocs\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Routing\Route;
use Johnylemon\Apidocs\Facades\Apidocs;
use Johnylemon\Apidocs\Console\Commands\{
    GenerateApidocs,
    Install,
    MakeEndpoint,
    MakeParam
};

class ApidocsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // prepare configuration
        //
        $this->mergeConfigFrom(
            __DIR__.'/../../config/apidocs.php', 'apidocs-config'
        );

        //
        // load routes
        //
        $this->loadRoutesFrom(__DIR__.'/../../routes/apidocs.php');

        //
        // load views
        //
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'apidocs');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        // publish configs
        //
        $this->publishes([
            __DIR__.'/../../config/apidocs.php' => config_path('apidocs.php'),
            __DIR__.'/../../publish/assets' => public_path('vendor/apidocs'),
        ]);

        //
        // define default endpoints grup
        //
        Apidocs::defineGroup('non-groupped', 'Non-groupped', 'Non-grouped endpoints');

        //
        // route macro
        //
        Route::macro('apidocs', function($data = NULL){

            return Apidocs::register($data)
                ->method($this->methods()[0])
                ->uri($this->uri())
                ->group('non-groupped')
                ->mount();
        });

        //
        // register commands
        //
        if ($this->app->runningInConsole())
        {
            $this->commands([
                Install::class,
                GenerateApidocs::class,
                MakeEndpoint::class,
                MakeParam::class,
            ]);
        }
    }
}
