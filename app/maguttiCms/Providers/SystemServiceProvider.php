<?php namespace App\maguttiCms\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class SystemServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!App::runningInConsole())
        {
            // Check if we use Redis for this project
            if (!is_null(env('REDIS_HOST', null))) {

                $prefix = env('REDIS_PREFIX', null);
                // Make sure that a random enough prefix has been provided.
                if (is_null($prefix))
                    die('REDIS_PREFIX not specified. App killed');

                if (!preg_match('/^.{44}\z/', $prefix))
                    die('REDIS_PREFIX must be a random string of at least 44 characters (php artisan laracms:setup-redis)');
            }
        }
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