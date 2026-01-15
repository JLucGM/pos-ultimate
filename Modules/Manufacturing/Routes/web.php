<?php

use Illuminate\Support\Facades\Route;
use Modules\Manufacturing\Http\Controllers\RecipeController;
use Modules\Manufacturing\Http\Controllers\ProductionOrderController;

Route::middleware(['web', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu'])->prefix('manufacturing')->group(function() {
    
    // Rutas de Recetas
    Route::get('/recipes', [RecipeController::class, 'index'])->name('manufacturing.recipes.index');
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('manufacturing.recipes.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('manufacturing.recipes.store');
    Route::get('/recipes/{id}', [RecipeController::class, 'show'])->name('manufacturing.recipes.show');
    Route::get('/recipes/{id}/edit', [RecipeController::class, 'edit'])->name('manufacturing.recipes.edit');
    Route::put('/recipes/{id}', [RecipeController::class, 'update'])->name('manufacturing.recipes.update');
    Route::delete('/recipes/{id}', [RecipeController::class, 'destroy'])->name('manufacturing.recipes.destroy');
    
    // Rutas de Órdenes de Producción
    Route::get('/production-orders', [ProductionOrderController::class, 'index'])->name('manufacturing.production_orders.index');
    Route::get('/production-orders/create', [ProductionOrderController::class, 'create'])->name('manufacturing.production_orders.create');
    Route::post('/production-orders', [ProductionOrderController::class, 'store'])->name('manufacturing.production_orders.store');
    Route::get('/production-orders/{id}', [ProductionOrderController::class, 'show'])->name('manufacturing.production_orders.show');
    Route::post('/production-orders/{id}/produce', [ProductionOrderController::class, 'produce'])->name('manufacturing.production_orders.produce');
    Route::delete('/production-orders/{id}', [ProductionOrderController::class, 'destroy'])->name('manufacturing.production_orders.destroy');
    
    // AJAX
    Route::get('/recipes/{id}/details', [RecipeController::class, 'getRecipeDetails'])->name('manufacturing.recipes.details');
    Route::get('/production-orders/recipe/{id}/details', [ProductionOrderController::class, 'getRecipeDetails'])->name('manufacturing.production_orders.recipe_details');
});
