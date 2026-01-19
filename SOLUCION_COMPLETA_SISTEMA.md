# SOLUCIÓN COMPLETA: Sistema Caído y Problema POS con Manufacturing

## SITUACIÓN ACTUAL

### 1. Sistema Caído
- **Error**: `UnexpectedValueException: The stream or file "/home/audaz.site/public_html/storage/logs/laravel-2026-01-19.log" could not be opened in append mode: Permission denied`
- **Estado**: Sistema completamente inoperativo
- **Causa**: Permisos incorrectos en directorios críticos

### 2. Problema POS con Productos Manufacturing
- **Error**: Botones "Efectivo" y "Pago Múltiple" deshabilitados
- **Causa**: Validación de stock falla para productos manufacturados
- **Ubicación**: `public/js/pos.js` líneas 201-202, 235, 263

## SOLUCIÓN PASO A PASO

### PASO 1: RECUPERAR EL SISTEMA (URGENTE)

Ejecuta este comando en el servidor:

```bash
cd /home/audaz.site/public_html
bash emergency-recovery.sh
```

Si no funciona, ejecuta manualmente:

```bash
# 1. Limpiar cachés
php artisan optimize:clear
rm -rf bootstrap/cache/*.php
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/views/*.php

# 2. Corregir permisos
chmod -R 777 storage
chmod -R 777 bootstrap/cache

# 3. Reconstruir caché
php artisan config:cache
php artisan route:cache
```

### PASO 2: VERIFICAR ESTADO DEL SISTEMA

```bash
bash check-system-status.sh
```

O manualmente:

```bash
# Ver logs
tail -f storage/logs/laravel.log

# Verificar permisos
ls -la storage/logs/

# Probar acceso
curl -I https://audaz.site/
```

### PASO 3: SOLUCIONAR PROBLEMA POS CON MANUFACTURING

Una vez que el sistema esté funcionando, hay 3 opciones:

#### OPCIÓN A: Habilitar Sobreventa (Recomendado para Manufacturing)

1. Ir a **Configuración → Configuración del Negocio → Productos**
2. Activar "Permitir sobreventa" (Allow Overselling)
3. Guardar cambios

Esto permitirá vender productos de Manufacturing incluso si el stock no está actualizado.

#### OPCIÓN B: Verificar y Completar Órdenes de Producción

```sql
-- Ver órdenes de producción pendientes
SELECT id, ref_no, status, final_quantity, created_at 
FROM mfg_production_orders 
WHERE status != 'completed' 
ORDER BY created_at DESC;

-- Completar orden manualmente (reemplaza ID)
UPDATE mfg_production_orders 
SET status = 'completed' 
WHERE id = [ID_DE_LA_ORDEN];
```

Luego en el sistema:
1. Ir a **Manufacturing → Órdenes de Producción**
2. Buscar la orden del producto
3. Hacer clic en "Completar"
4. Verificar que el stock se haya actualizado

#### OPCIÓN C: Modificar Validación del POS (Avanzado)

Editar `public/js/pos.js` para permitir productos sin stock:

```javascript
// Buscar línea 201-202 y cambiar:
if ((ui.item.enable_stock == 1 && ui.item.qty_available > 0) || 
    (ui.item.enable_stock == 0) || is_overselling_allowed || for_so) {

// Por:
if ((ui.item.enable_stock == 1 && ui.item.qty_available > 0) || 
    (ui.item.enable_stock == 0) || is_overselling_allowed || for_so || 
    ui.item.is_manufactured) {  // Agregar esta condición
```

Luego limpiar caché:
```bash
php artisan cache:clear
```

## VERIFICACIÓN FINAL

### 1. Verificar que el sistema funciona
```bash
curl https://audaz.site/
# Debe devolver código 200
```

### 2. Verificar stock de productos manufacturados
```sql
SELECT 
    p.name AS producto,
    v.sub_sku AS sku,
    vl.qty_available AS stock_disponible,
    l.name AS ubicacion
FROM products p
JOIN variations v ON p.id = v.product_id
JOIN variation_location_details vl ON v.id = vl.variation_id
JOIN business_locations l ON vl.location_id = l.id
WHERE p.type = 'manufactured' OR p.id IN (
    SELECT DISTINCT product_id FROM mfg_production_orders
)
ORDER BY p.name;
```

### 3. Probar POS
1. Ir a **POS**
2. Agregar un producto manufacturado
3. Verificar que los botones "Efectivo" y "Pago Múltiple" estén habilitados
4. Completar una venta de prueba

## COMANDOS ÚTILES

### Reiniciar Servicios (si tienes acceso root)
```bash
sudo systemctl restart apache2
# O
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm
```

### Ver Logs en Tiempo Real
```bash
tail -f storage/logs/laravel.log
```

### Verificar Procesos PHP
```bash
ps aux | grep php
```

### Verificar Espacio en Disco
```bash
df -h
```

## PREVENCIÓN FUTURA

### 1. Configurar Permisos Correctos
Agregar al deployment:
```bash
# En deploy-manufacturing.sh
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

### 2. Habilitar Sobreventa para Manufacturing
En `.env`:
```env
ALLOW_OVERSELLING=true
```

### 3. Monitoreo de Logs
Configurar rotación de logs en `config/logging.php`:
```php
'daily' => [
    'driver' => 'daily',
    'path' => storage_path('logs/laravel.log'),
    'level' => 'debug',
    'days' => 14,
    'permission' => 0664,
],
```

## CONTACTO DE EMERGENCIA

Si el problema persiste:

1. **Verificar .env**: Asegúrate que las credenciales de BD sean correctas
2. **Verificar BD**: Conecta directamente a MySQL para verificar que esté funcionando
3. **Verificar Servidor Web**: Apache/Nginx debe estar corriendo
4. **Verificar PHP**: `php -v` debe mostrar la versión correcta

## RESUMEN DE ARCHIVOS MODIFICADOS

- `emergency-recovery.sh` - Script de recuperación
- `check-system-status.sh` - Script de verificación
- `DIAGNOSTICO_POS_MANUFACTURING.md` - Diagnóstico del problema POS
- `fix-permissions-logs.sh` - Corrección de permisos
- `public/js/pos.js` - Validaciones del POS (opcional modificar)

## PRÓXIMOS PASOS INMEDIATOS

1. ✅ Ejecutar `emergency-recovery.sh`
2. ✅ Verificar que el sistema cargue: https://audaz.site/
3. ✅ Habilitar "Permitir sobreventa" en configuración
4. ✅ Probar venta de producto manufacturado en POS
5. ✅ Verificar que los botones funcionen correctamente

---

**IMPORTANTE**: Ejecuta primero el script de recuperación. Sin eso, nada más funcionará.
