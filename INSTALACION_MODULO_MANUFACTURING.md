# Instalación del Módulo Manufacturing

## ✅ Módulo Creado Exitosamente

El módulo Manufacturing ha sido creado con todas las funcionalidades básicas.

## 📁 Estructura Creada

```
Modules/Manufacturing/
├── Config/
│   └── config.php
├── Database/
│   └── Migrations/
│       ├── 2026_01_14_000001_create_mfg_recipes_table.php
│       ├── 2026_01_14_000002_create_mfg_recipe_ingredients_table.php
│       └── 2026_01_14_000003_create_mfg_production_orders_table.php
├── Entities/
│   ├── MfgRecipe.php
│   ├── MfgRecipeIngredient.php
│   └── MfgProductionOrder.php
├── Http/Controllers/
│   ├── RecipeController.php
│   └── ProductionOrderController.php
├── Providers/
│   ├── ManufacturingServiceProvider.php
│   └── RouteServiceProvider.php
├── Resources/views/
│   ├── recipes/
│   │   ├── index.blade.php
│   │   └── create.blade.php
│   └── production_orders/
│       ├── index.blade.php
│       └── create.blade.php
├── Routes/
│   └── web.php
├── composer.json
└── module.json
```

## 🚀 Pasos de Instalación

### 1. Regenerar Autoload de Composer

```bash
composer dump-autoload
```

### 2. Ejecutar Migraciones

```bash
php artisan migrate
```

### 3. Limpiar Caché

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
```

### 4. Agregar Permisos al Sistema

Necesitas agregar los permisos en la base de datos. Ejecuta este SQL:

```sql
-- Insertar permisos de Manufacturing
INSERT INTO permissions (name, guard_name, created_at, updated_at) VALUES
('manufacturing.view', 'web', NOW(), NOW()),
('manufacturing.create', 'web', NOW(), NOW()),
('manufacturing.edit', 'web', NOW(), NOW()),
('manufacturing.delete', 'web', NOW(), NOW());

-- Asignar permisos al rol de Admin (ajusta el role_id según tu sistema)
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT id, 1 FROM permissions WHERE name LIKE 'manufacturing.%';
```

### 5. Agregar al Menú de Navegación

Edita el archivo que gestiona el menú lateral (generalmente `resources/views/layouts/partials/sidebar.blade.php` o similar) y agrega:

```blade
@can('manufacturing.view')
<li class="treeview" id="tour_step_manufacturing">
    <a href="#">
        <i class="fa fa-industry"></i>
        <span>Manufacturing</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{ action([\Modules\Manufacturing\Http\Controllers\RecipeController::class, 'index']) }}"><i class="fa fa-book"></i> Recetas</a></li>
        <li><a href="{{ action([\Modules\Manufacturing\Http\Controllers\ProductionOrderController::class, 'index']) }}"><i class="fa fa-cogs"></i> Órdenes de Producción</a></li>
    </ul>
</li>
@endcan
```

## 📋 Deployment a Producción

### Script de Deployment

```bash
#!/bin/bash

echo "🚀 Desplegando Módulo Manufacturing..."

# 1. Subir archivos al servidor
scp -r Modules/Manufacturing root@audaz.site:/home/audaz.site/public_html/Modules/

# 2. Conectar y ejecutar comandos
ssh root@audaz.site << 'EOF'
cd /home/audaz.site/public_html

# Regenerar autoload
composer dump-autoload

# Ejecutar migraciones
php artisan migrate --force

# Limpiar caché
php artisan optimize:clear

# Permisos
chmod -R 777 storage bootstrap/cache

echo "✅ Módulo Manufacturing instalado!"
EOF
```

Guarda este script como `deploy-manufacturing.sh` y ejecútalo:

```bash
chmod +x deploy-manufacturing.sh
./deploy-manufacturing.sh
```

### Deployment Manual

```bash
# 1. Subir módulo
scp -r Modules/Manufacturing root@audaz.site:/home/audaz.site/public_html/Modules/

# 2. Conectar al servidor
ssh root@audaz.site

# 3. Ir al directorio
cd /home/audaz.site/public_html

# 4. Regenerar autoload
composer dump-autoload

# 5. Ejecutar migraciones
php artisan migrate --force

# 6. Limpiar caché
php artisan optimize:clear

# 7. Permisos
chmod -R 777 storage bootstrap/cache
```

## 🎯 Funcionalidades Implementadas

### ✅ Recetas (BOM)
- Crear recetas con múltiples ingredientes
- Definir cantidades y costos
- Calcular costo total automáticamente
- Activar/desactivar recetas
- Editar y eliminar recetas

### ✅ Órdenes de Producción
- Crear órdenes basadas en recetas
- Verificar stock de ingredientes
- Producir (descontar ingredientes, agregar producto final)
- Estados: Pendiente, En Proceso, Completada, Cancelada
- Números de referencia únicos

### ✅ Control de Inventario
- Integración con sistema de inventario existente
- Descuento automático de ingredientes
- Adición automática de productos finales
- Verificación de stock antes de producir

### ✅ Interfaz de Usuario
- Listados con DataTables
- Formularios intuitivos
- Cálculos en tiempo real
- Confirmaciones de acciones críticas

## 📊 Uso del Módulo

### Crear una Receta

1. Ir a **Manufacturing > Recetas**
2. Click en **Nueva Receta**
3. Seleccionar producto final
4. Agregar ingredientes con cantidades
5. El sistema calcula el costo automáticamente
6. Guardar

### Producir

1. Ir a **Manufacturing > Órdenes de Producción**
2. Click en **Nueva Orden**
3. Seleccionar receta y cantidad
4. El sistema muestra ingredientes necesarios
5. Crear orden
6. Click en **Producir** cuando esté listo
7. El sistema:
   - Descuenta ingredientes del inventario
   - Agrega producto final al inventario
   - Marca orden como completada

## 🔧 Configuración

Edita `Modules/Manufacturing/Config/config.php` para personalizar:

```php
return [
    // Prefijo para números de referencia
    'production_order_prefix' => 'PRD',
    
    // Permitir stock negativo
    'allow_negative_stock' => false,
    
    // Auto-completar órdenes
    'auto_complete_orders' => true,
];
```

## 🐛 Troubleshooting

### Error: Class not found
```bash
composer dump-autoload
php artisan optimize:clear
```

### Error: Table doesn't exist
```bash
php artisan migrate
```

### Error: Permission denied
```bash
chmod -R 777 storage bootstrap/cache
```

### No aparece en el menú
- Verifica que tengas los permisos asignados
- Limpia caché: `php artisan cache:clear`
- Revisa que agregaste el menú en el sidebar

## 📈 Próximas Mejoras (Fase 2)

- [ ] Recetas multinivel
- [ ] Control de desperdicios
- [ ] Reportes avanzados
- [ ] Lotes de producción
- [ ] Fechas de vencimiento automáticas
- [ ] Integración con compras
- [ ] Dashboard de producción

## 🎉 ¡Listo!

El módulo Manufacturing está completamente funcional y listo para usar.

**URLs de acceso:**
- Recetas: https://audaz.site/manufacturing/recipes
- Órdenes: https://audaz.site/manufacturing/production-orders

**Soporte:**
- Cualquier duda o mejora, estoy aquí para ayudarte
