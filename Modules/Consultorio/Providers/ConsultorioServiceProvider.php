<?php

namespace Modules\Consultorio\Providers;

use Illuminate\Support\ServiceProvider;

class ConsultorioServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Cargar migraciones
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        
        // Cargar rutas
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        
        // Cargar vistas
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'consultorio');
    }

    public function register()
    {
        //
    }
}
