# Correcciones Dashboard Multimoneda

## Fecha: 14 de Enero 2026

## Problema Identificado
El widget de tasa de cambio en el dashboard mostraba **0.00** en lugar del valor correcto de la tasa de cambio USD → Bs.

## Causa Raíz
En el método `getMultimonedaData()` del `HomeController`, se estaba accediendo al campo `exchange_rate` cuando el nombre correcto del campo en la base de datos es `rate`.

## Cambios Realizados

### 1. HomeController.php
**Archivo:** `app/Http/Controllers/HomeController.php`

**Cambio:** Corregido acceso al campo de tasa de cambio
```php
// ANTES (incorrecto)
'rate' => $exchange_rate->exchange_rate,

// DESPUÉS (correcto)
'rate' => $exchange_rate->rate,
```

**Líneas afectadas:** 
- Línea ~270: `'rate' => $exchange_rate->rate,`
- Línea ~280: `'rate' => 1 / $exchange_rate->rate,`

### 2. Vista Dashboard (index.blade.php)
**Archivo:** `resources/views/home/index.blade.php`

**Cambios de diseño:**
- ✅ Colores del widget de tasa de cambio cambiados de púrpura a sky-blue (consistente con otros widgets)
- ✅ Tamaño de fuente del valor principal ajustado de `tw-text-2xl` a `tw-text-xl` (consistente)
- ✅ Grid ya configurado en 3 columnas: `md:tw-grid-cols-3`

**Antes:**
```html
<div class="tw-bg-purple-100 tw-text-purple-600">
    <p class="tw-text-2xl">{{ number_format(...) }}</p>
</div>
```

**Después:**
```html
<div class="tw-bg-sky-100 tw-text-sky-500">
    <p class="tw-text-xl">{{ number_format(...) }}</p>
</div>
```

### 3. Versión de Assets
**Archivo:** `config/constants.php`

**Cambio:** Incrementada versión de assets
```php
// ANTES
'asset_version' => 672,

// DESPUÉS
'asset_version' => 673,
```

## Estructura de la Base de Datos

### Tabla: exchange_rates
```sql
- id (bigint)
- business_id (int)
- from_currency_id (int)
- to_currency_id (int)
- rate (decimal 20,6)  ← Campo correcto
- effective_date (date)
- created_by (int)
- notes (text)
- created_at (timestamp)
- updated_at (timestamp)
```

## Verificación

### Antes del Fix
- Widget mostraba: **0.00**
- Causa: Campo `exchange_rate` no existe en la tabla

### Después del Fix
- Widget debe mostrar: **336.47** (o el valor actual de la tasa)
- Formato: `1 USD = 336.47 Bs`

## Deployment

### Opción 1: Script Automático
```bash
./deploy-dashboard-fix.sh
```

### Opción 2: Manual
```bash
# 1. Subir archivos
scp app/Http/Controllers/HomeController.php root@audaz.site:/home/audaz.site/public_html/app/Http/Controllers/
scp resources/views/home/index.blade.php root@audaz.site:/home/audaz.site/public_html/resources/views/home/
scp config/constants.php root@audaz.site:/home/audaz.site/public_html/config/

# 2. Limpiar caché
ssh root@audaz.site "cd /home/audaz.site/public_html && php artisan optimize:clear"

# 3. Permisos
ssh root@audaz.site "cd /home/audaz.site/public_html && chmod -R 777 storage bootstrap/cache"
```

## Testing Post-Deployment

1. **Acceder al dashboard:** https://audaz.site/
2. **Verificar widget de tasa de cambio:**
   - Debe mostrar el valor correcto (ej: 336.47)
   - Debe mostrar "1 USD = 336.47 Bs"
   - Debe mostrar la fecha de actualización
3. **Verificar colores:**
   - Ícono debe ser sky-blue (azul claro)
   - Fondo blanco
   - Consistente con otros widgets
4. **Verificar grid:**
   - En desktop: 3 columnas
   - En mobile: 1 columna

## Archivos Modificados

```
✓ app/Http/Controllers/HomeController.php
✓ resources/views/home/index.blade.php
✓ config/constants.php
✓ deploy-dashboard-fix.sh (nuevo)
✓ CAMBIOS_DASHBOARD_MULTIMONEDA.md (nuevo)
```

## Notas Técnicas

- El modelo `ExchangeRate` ya tenía el campo correcto definido como `rate`
- La migración también usa el nombre correcto `rate`
- Solo el controlador tenía el error de nomenclatura
- No se requieren cambios en la base de datos

## Próximos Pasos

1. Ejecutar deployment
2. Verificar en producción
3. Si todo funciona correctamente, marcar como completado
4. Continuar con otras mejoras del dashboard si es necesario
