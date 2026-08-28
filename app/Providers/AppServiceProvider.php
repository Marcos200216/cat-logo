<?php

namespace App\Providers;

use App\Models\Categoria;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    View::composer('tienda', function ($view) {
        $modo = request()->routeIs('mayorista.*') ? 'mayorista' : 'normal';

        $view->with('categoriasNav', Categoria::where('activo', true)
            ->where('canal', $modo)
            ->orderBy('orden')
            ->get());
    });
}
}