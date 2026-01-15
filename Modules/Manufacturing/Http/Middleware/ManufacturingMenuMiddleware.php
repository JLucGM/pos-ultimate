<?php

namespace Modules\Manufacturing\Http\Middleware;

use Closure;
use Menu;

class ManufacturingMenuMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            if (auth()->user()->can('manufacturing.view')) {
                Menu::modify('admin-sidebar-menu', function ($menu) {
                    $menu->url(
                        action([\Modules\Manufacturing\Http\Controllers\RecipeController::class, 'index']),
                        __('Recetas'),
                        ['icon' => '<i class="fa fa-book"></i>', 'active' => request()->segment(1) == 'manufacturing' && request()->segment(2) == 'recipes']
                    )->order(50);
                    
                    $menu->url(
                        action([\Modules\Manufacturing\Http\Controllers\ProductionOrderController::class, 'index']),
                        __('Órdenes de Producción'),
                        ['icon' => '<i class="fa fa-cogs"></i>', 'active' => request()->segment(1) == 'manufacturing' && request()->segment(2) == 'production-orders']
                    )->order(51);
                });
            }
        }

        return $next($request);
    }
}
