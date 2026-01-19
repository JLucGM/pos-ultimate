# Diagnóstico: Botones de Pago Deshabilitados en POS para Productos de Manufacturing

## Problema Reportado
Los botones de "Efectivo" y "Pago Múltiple" aparecen deshabilitados al intentar vender productos que provienen del módulo de Manufacturing (Producción).

## Análisis del Código

### Ubicación del Problema
Archivo: `public/js/pos.js`

### Validaciones que Deshabilitan los Botones

1. **Validación de Stock (Líneas 201-202, 235, 263)**
   ```javascript
   if ((ui.item.enable_stock == 1 && ui.item.qty_available > 0) || 
       (ui.item.enable_stock == 0) || is_overselling_allowed || for_so)
   ```

2. **Validación del Formulario (Línea 1125)**
   ```javascript
   if (sell_form.valid()) {
       window.onbeforeunload = null;
       $(this).attr('disabled', true);
       sell_form.submit();
   }
   ```

## Posibles Causas

### 1. Stock No Disponible
Los productos de manufacturing pueden no tener stock disponible correctamente registrado después de completar una orden de producción.

### 2. Validación de Precio Mínimo
La validación de precio mínimo de venta (MSP) puede estar fallando para productos manufacturados.

### 3. Campos Requeridos Faltantes
Puede haber campos requeridos en el formulario que no se están llenando correctamente para productos de manufacturing.

## Soluciones Propuestas

### Solución 1: Verificar Stock de Productos Manufacturados

1. Ir a **Productos → Lista de Productos**
2. Buscar el producto manufacturado
3. Verificar que tenga stock disponible
4. Si no tiene stock, crear una orden de producción y marcarla como completada

### Solución 2: Verificar Configuración de Stock

1. Editar el producto manufacturado
2. Verificar que "Habilitar Stock" esté activado
3. Verificar que el stock actual sea mayor a 0

### Solución 3: Permitir Sobreventa (Overselling)

Si deseas vender productos sin stock:

1. Ir a **Configuración → Configuración del Negocio**
2. En la sección de "Productos"
3. Activar "Permitir sobreventa"

### Solución 4: Revisar Logs del Navegador

Abrir la consola del navegador (F12) y buscar errores JavaScript que puedan estar bloqueando el formulario.

## Comandos para Debugging

### En el Servidor
```bash
# Ver logs de Laravel
tail -f storage/logs/laravel.log

# Limpiar caché
php artisan cache:clear
php artisan view:clear
```

### En el Navegador
1. Presionar F12
2. Ir a la pestaña "Console"
3. Intentar agregar el producto al POS
4. Buscar mensajes de error en rojo

## Verificación Paso a Paso

1. **Verificar que el producto existe y tiene stock**
   ```sql
   SELECT p.name, v.sub_sku, vl.qty_available 
   FROM products p
   JOIN variations v ON p.id = v.product_id
   JOIN variation_location_details vl ON v.id = vl.variation_id
   WHERE p.name LIKE '%nombre_producto%';
   ```

2. **Verificar órdenes de producción completadas**
   ```sql
   SELECT * FROM mfg_production_orders 
   WHERE status = 'completed' 
   ORDER BY created_at DESC 
   LIMIT 10;
   ```

3. **Verificar transacciones de stock**
   ```sql
   SELECT * FROM transaction_sell_lines 
   WHERE product_id IN (SELECT id FROM products WHERE type = 'manufactured')
   ORDER BY created_at DESC 
   LIMIT 10;
   ```

## Próximos Pasos

1. Verificar el stock del producto en la base de datos
2. Revisar la consola del navegador para errores JavaScript
3. Verificar que la orden de producción esté completada
4. Si el problema persiste, revisar el código del módulo Manufacturing

## Archivos Relacionados

- `public/js/pos.js` - Validaciones del POS
- `app/Http/Controllers/SellPosController.php` - Controlador del POS
- `Modules/Manufacturing/Http/Controllers/ProductionOrderController.php` - Órdenes de producción
- `resources/views/sale_pos/create.blade.php` - Vista del POS

## Notas Adicionales

- Los productos manufacturados deben tener stock disponible después de completar una orden de producción
- El sistema valida el stock antes de permitir la venta
- Si "Permitir sobreventa" está desactivado, no se pueden vender productos sin stock
