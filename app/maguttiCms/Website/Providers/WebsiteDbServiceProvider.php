<?php

namespace App\maguttiCms\Website\Providers;
Use App;
use Illuminate\Support\ServiceProvider;

class WebsiteDbServiceProvider extends ServiceProvider
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
        App::bind('App\maguttiCms\Website\Repos\Article\ArticleRepositoryInterface', 'App\maguttiCms\Website\Repos\Article\DbArticleRepository');
        App::bind('App\maguttiCms\Website\Repos\News\NewsRepositoryInterface', 'App\maguttiCms\Website\Repos\News\DbNewsRepository');
        App::bind('App\maguttiCms\Website\Repos\Product\ProductRepositoryInterface', 'App\maguttiCms\Website\Repos\Product\DbProductRepository');
		App::bind('App\maguttiCms\Website\Repos\Category\CategoryRepositoryInterface', 'App\maguttiCms\Website\Repos\Category\DbCategoryRepository');

    }
}
