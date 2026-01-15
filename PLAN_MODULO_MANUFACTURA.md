# Plan de Implementación: Módulo Manufacturing

## Objetivo
Crear un módulo de manufactura funcional que permita:
- Crear recetas de productos (BOM - Bill of Materials)
- Gestionar ingredientes/materias primas
- Generar órdenes de producción
- Calcular costos de producción
- Controlar inventario de componentes

## Estructura del Módulo

```
Modules/Manufacturing/
├── Config/
│   └── config.php
├── Database/
│   ├── Migrations/
│   │   ├── 2026_01_14_create_mfg_recipes_table.php
│   │   ├── 2026_01_14_create_mfg_recipe_ingredients_table.php
│   │   └── 2026_01_14_create_mfg_production_orders_table.php
│   └── Seeders/
│       └── ManufacturingDatabaseSeeder.php
├── Entities/
│   ├── MfgRecipe.php
│   ├── MfgRecipeIngredient.php
│   └── MfgProductionOrder.php
├── Http/
│   └── Controllers/
│       ├── ManufacturingController.php
│       ├── RecipeController.php
│       └── ProductionOrderController.php
├── Providers/
│   └── ManufacturingServiceProvider.php
├── Resources/
│   └── views/
│       ├── recipes/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       └── production_orders/
│           ├── index.blade.php
│           ├── create.blade.php
│           └── show.blade.php
├── Routes/
│   └── web.php
└── module.json
```

## Funcionalidades Principales

### 1. Gestión de Recetas (BOM)
- **Crear receta:** Definir qué ingredientes/materias primas se necesitan
- **Cantidad por ingrediente:** Especificar cantidades exactas
- **Costo calculado:** Calcular automáticamente el costo de producción
- **Producto final:** Vincular receta con producto del inventario

### 2. Ingredientes/Materias Primas
- **Usar productos existentes:** Los ingredientes son productos del sistema
- **Control de stock:** Verificar disponibilidad antes de producir
- **Unidades de medida:** Respetar las unidades del sistema

### 3. Órdenes de Producción
- **Crear orden:** Seleccionar receta y cantidad a producir
- **Verificar stock:** Validar que hay suficientes ingredientes
- **Descontar inventario:** Restar ingredientes del stock
- **Agregar producto final:** Sumar producto terminado al inventario
- **Estados:** Pendiente, En Proceso, Completada, Cancelada

### 4. Reportes
- **Costo de producción:** Por producto y por período
- **Historial de producción:** Órdenes completadas
- **Ingredientes más usados:** Análisis de consumo

## Base de Datos

### Tabla: mfg_recipes
```sql
- id
- business_id
- product_id (producto final)
- name (nombre de la receta)
- description
- quantity_produced (cantidad que produce la receta)
- total_cost (costo calculado)
- preparation_time_minutes
- is_active
- created_by
- created_at
- updated_at
```

### Tabla: mfg_recipe_ingredients
```sql
- id
- recipe_id
- ingredient_product_id (producto usado como ingrediente)
- quantity (cantidad necesaria)
- unit_id (unidad de medida)
- cost_per_unit
- total_cost
- sort_order
- created_at
- updated_at
```

### Tabla: mfg_production_orders
```sql
- id
- business_id
- location_id
- recipe_id
- ref_no (número de referencia)
- quantity_to_produce
- quantity_produced
- status (pending, in_progress, completed, cancelled)
- production_date
- completion_date
- total_cost
- notes
- created_by
- created_at
- updated_at
```

## Integración con Sistema Actual

### 1. Menú de Navegación
Agregar en el sidebar:
```
Manufacturing
├── Recetas
├── Órdenes de Producción
└── Reportes de Producción
```

### 2. Permisos
Crear permisos en el sistema:
- `manufacturing.view`
- `manufacturing.create`
- `manufacturing.edit`
- `manufacturing.delete`
- `manufacturing.produce`

### 3. Productos
- Marcar productos como "Manufacturables"
- Marcar productos como "Materia Prima"
- Campo adicional: `is_manufactured` en tabla products

## Flujo de Trabajo

### Crear una Receta
1. Seleccionar producto final
2. Agregar ingredientes (productos existentes)
3. Definir cantidades
4. Sistema calcula costo automáticamente
5. Guardar receta

### Producir
1. Crear orden de producción
2. Seleccionar receta
3. Definir cantidad a producir
4. Sistema verifica stock de ingredientes
5. Si hay stock suficiente:
   - Descuenta ingredientes del inventario
   - Agrega producto final al inventario
   - Registra transacción
6. Marca orden como completada

## Características Adicionales

### Fase 1 (Básico) - Implementación Inmediata
- ✅ CRUD de recetas
- ✅ Gestión de ingredientes
- ✅ Órdenes de producción simples
- ✅ Cálculo de costos
- ✅ Control de inventario

### Fase 2 (Futuro)
- 📋 Recetas multinivel (recetas que usan productos manufacturados)
- 📋 Desperdicios y mermas
- 📋 Control de calidad
- 📋 Lotes de producción
- 📋 Fechas de vencimiento automáticas
- 📋 Reportes avanzados

## Ventajas de Nuestra Implementación

1. **Integración nativa:** Se integra perfectamente con tu sistema actual
2. **Multimoneda:** Respeta tu sistema multimoneda
3. **Personalizable:** Podemos agregar funcionalidades específicas
4. **Sin costo adicional:** No pagas licencias
5. **Control total:** Código fuente completo

## Tiempo de Implementación

- **Fase 1 (Básico):** 2-3 horas
  - Estructura del módulo
  - Migraciones de base de datos
  - Modelos y controladores
  - Vistas básicas
  - Funcionalidad core

- **Fase 2 (Refinamiento):** 1-2 horas
  - Mejoras de UI/UX
  - Validaciones adicionales
  - Reportes
  - Testing

## ¿Procedemos?

Si estás de acuerdo, comenzaré a crear el módulo Manufacturing con las funcionalidades de la Fase 1.

**Confirmación necesaria:**
- ¿Procedo con la implementación?
- ¿Alguna funcionalidad específica que necesites prioritariamente?
- ¿Algún flujo de trabajo particular de tu negocio?
