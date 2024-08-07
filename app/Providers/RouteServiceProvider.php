<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->prefix('sitemap')
            ->namespace($this->namespace)
            ->group(base_path('routes/sitemap.php'));

        Route::middleware('web')
            ->prefix('global-media')
            ->namespace($this->namespace)
            ->group(base_path('routes/media.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/list.php'));

        Route::middleware('web')
            ->prefix('user/ajax')
            ->namespace($this->namespace)
            ->group(base_path('routes/user/ajax.php'));

        Route::middleware('web')
            ->prefix('user')
            ->namespace($this->namespace)
            ->group(base_path('routes/user/web.php'));


        Route::middleware('web')
            ->prefix('admin')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin/web.php'));

        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));

        Route::middleware('web')
            ->prefix('payment')
            ->namespace($this->namespace)
            ->group(base_path('routes/payment.php'));




    }

    /**
     *
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
