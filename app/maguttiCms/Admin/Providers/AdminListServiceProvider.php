<?php

namespace App\maguttiCms\Admin\Providers;
Use App;
use Illuminate\Support\ServiceProvider;

class AdminListServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('AdminList', function()
        {
            return new \App\maguttiCms\Admin\AdminList;
        });
        App::bind('AdminDecorator', function()
        {
            return new \App\maguttiCms\Admin\Decorators\AdminDecorator();
        });

    }
}
