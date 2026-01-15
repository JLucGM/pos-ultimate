# FIX: Error al Crear Órdenes de Producción

## Problema
Al intentar crear una nueva orden de producción, aparece un error: "Call to undefined method"

## Solución

### PASO 1: Verificar en el servidor si el git pull funcionó

Conéctate al servidor vía SSH o Terminal de cPanel y ejecuta:

```bash
cd /home/audaz.site/public_html
git status
git log -1
```

Si ves que hay cambios sin aplicar o conflictos, ejecuta:

```bash
git reset --hard origin/main
```

### PASO 2: Verificar el archivo ProductionOrderController.php

Abre el archivo en el servidor:
```
/home/audaz.site/public_html/Modules/Manufacturing/Http/Controllers/ProductionOrderController.php
```

Ve al FINAL del archivo (antes del último `}`) y verifica que exista este método:

```php
    public function getRecipeDetails($id)
    {
        try {
            $business_id = request()->session()->get('user.business_id');
            
            $recipe = MfgRecipe::where('business_id', $business_id)
                ->with(['product', 'ingredients.product', 'ingredients.unit'])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'recipe' => $recipe
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Error al obtener detalles de la receta'
            ]);
        }
    }
```

**Si NO existe**, agrégalo manualmente antes del último `}` del archivo.

### PASO 3: Verificar el archivo create.blade.php

Abre el archivo en el servidor:
```
/home/audaz.site/public_html/Modules/Manufacturing/Resources/views/production_orders/create.blade.php
```

En la línea 10 (aproximadamente), busca esta línea:

```php
{!! Form::open(['action' => '\Modules\Manufacturing\Http\Controllers\ProductionOrderController@store', 'method' => 'post']) !!}
```

Y cámbiala por:

```php
{!! Form::open(['url' => action([\Modules\Manufacturing\Http\Controllers\ProductionOrderController::class, 'store']), 'method' => 'post']) !!}
```

### PASO 4: Limpiar caché

Ejecuta en el servidor:

```bash
cd /home/audaz.site/public_html
php artisan optimize:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
composer dump-autoload
```

### PASO 5: Verificar permisos

```bash
cd /home/audaz.site/public_html
chmod -R 755 Modules/Manufacturing
chmod -R 777 storage bootstrap/cache
```

### PASO 6: Probar

Abre en el navegador:
https://audaz.site/manufacturing/production-orders/create

Y intenta crear una nueva orden.

---

## Si el problema persiste

Envíame el contenido de estos archivos del servidor:

1. Las últimas 50 líneas de:
   `/home/audaz.site/public_html/Modules/Manufacturing/Http/Controllers/ProductionOrderController.php`

2. Las primeras 20 líneas de:
   `/home/audaz.site/public_html/Modules/Manufacturing/Resources/views/production_orders/create.blade.php`

3. El log de errores:
   `/home/audaz.site/public_html/storage/logs/laravel.log` (últimas 100 líneas)
