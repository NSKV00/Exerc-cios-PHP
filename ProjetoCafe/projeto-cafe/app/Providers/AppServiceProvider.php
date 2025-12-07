<?php

namespace App\Providers;

use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

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
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        // Registrar alias de middleware 'admin' para verificar campo 'acesso' do usuário
        $router = $this->app->make(\Illuminate\Routing\Router::class);
        $router->aliasMiddleware('admin', \App\Http\Middleware\Admin::class);
    }
}
