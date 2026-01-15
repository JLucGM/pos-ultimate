# Diagnóstico del Módulo Kitchen

## Pasos para verificar el módulo Kitchen:

### 1. Verificar que el módulo esté habilitado
1. Ve a: https://audaz.site/business/settings
2. Haz clic en la pestaña "Módulos"
3. Busca el checkbox "Kitchen" y asegúrate de que esté **activado**
4. Guarda los cambios si lo activaste

### 2. Verificar permisos
El módulo Kitchen no requiere permisos especiales, pero necesitas tener acceso a ventas.

### 3. Acceder al módulo
URL: https://audaz.site/modules/kitchen

### 4. Problemas comunes:

#### A. No aparece en el menú
- **Causa**: El módulo no está habilitado
- **Solución**: Activarlo en Configuración → Módulos

#### B. Página en blanco o error 404
- **Causa**: Rutas no cargadas o caché
- **Solución**: Ejecutar en el servidor:
```bash
cd /home/audaz.site/public_html
php artisan route:clear
php artisan optimize:clear
```

#### C. No muestra órdenes
- **Causa**: No hay órdenes de restaurante creadas
- **Solución**: El módulo Kitchen muestra órdenes de POS que tienen:
  - `res_line_order_status` = 'received'
  - Productos marcados como "para cocina"

### 5. Cómo funciona Kitchen:

1. **Crear una venta en POS** con productos de restaurante
2. Los productos deben estar marcados como "para cocina" (is_kitchen_order = 1)
3. La orden aparecerá en Kitchen con estado "Recibida"
4. El personal de cocina puede marcar como "Cocinada"
5. El mesero puede ver las órdenes listas para servir

### 6. Configuración necesaria:

Para que Kitchen funcione correctamente, necesitas:

1. **Habilitar módulo "Tables"** (Mesas)
2. **Habilitar módulo "Service Staff"** (Personal de servicio)
3. **Habilitar módulo "Kitchen"**
4. **Configurar productos** con la opción "Para cocina" activada

### 7. Verificar en base de datos:

Ejecuta en el servidor:
```bash
cd /home/audaz.site/public_html
php artisan tinker
```

Luego ejecuta:
```php
// Ver si hay órdenes de cocina
\DB::table('transaction_sell_lines')
    ->where('res_line_order_status', 'received')
    ->count();

// Ver configuración de módulos habilitados
$business = \App\Business::first();
$business->enabled_modules;
exit
```

## ¿Qué error específico estás viendo?

Por favor, dime:
1. ¿El módulo aparece en el menú?
2. ¿Puedes acceder a la URL?
3. ¿Qué mensaje de error ves (si hay alguno)?
4. ¿Tienes órdenes de restaurante creadas?
