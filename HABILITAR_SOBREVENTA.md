# Cómo Habilitar Sobreventa para Productos de Manufacturing

## ¿Por qué necesito esto?

Los productos de Manufacturing pueden no tener stock disponible inmediatamente después de crear una orden de producción. Habilitar la sobreventa permite vender estos productos incluso cuando el stock muestra 0.

## Pasos para Habilitar Sobreventa

### 1. Inicia Sesión en Audaz POS

Accede a: `https://audaz.site/`

### 2. Ve al Menú de Configuración

```
Menú Principal → Configuración → Configuración del Negocio
```

O directamente:
```
https://audaz.site/business/settings
```

### 3. Busca la Sección "Productos"

Desplázate hacia abajo hasta encontrar la sección **"Productos"** o **"Product Settings"**

### 4. Activa "Permitir Sobreventa"

Busca la opción:
- **Español**: "Permitir sobreventa"
- **Inglés**: "Enable Overselling"

Marca la casilla ✅

### 5. Guarda los Cambios

Haz clic en el botón **"Guardar"** o **"Save"** al final de la página.

## Verificación

### Probar en el POS

1. Ve a: **POS** (Punto de Venta)
2. Agrega un producto manufacturado al carrito
3. Los botones **"Efectivo"** y **"Pago Múltiple"** deben estar habilitados ✅
4. Completa una venta de prueba

### Si los botones siguen deshabilitados

Verifica lo siguiente:

#### 1. Limpia el caché del navegador
- Presiona `Ctrl + Shift + R` (Windows/Linux)
- Presiona `Cmd + Shift + R` (Mac)

#### 2. Verifica la consola del navegador
- Presiona `F12` para abrir las herramientas de desarrollo
- Ve a la pestaña **"Console"**
- Busca errores en rojo
- Si ves errores, toma una captura y compártela

#### 3. Verifica que el producto tenga precio
- Ve a: **Productos → Lista de Productos**
- Busca el producto manufacturado
- Verifica que tenga un **precio de venta** configurado
- Si no tiene precio, edítalo y agrega uno

#### 4. Verifica que el cliente esté seleccionado
- En el POS, asegúrate de seleccionar un cliente
- El cliente por defecto suele ser "Walk-in Customer"

## Alternativa: Completar Órdenes de Producción

Si prefieres no usar sobreventa, puedes completar las órdenes de producción:

### 1. Ve a Manufacturing

```
Menú Principal → Manufacturing → Órdenes de Producción
```

### 2. Busca Órdenes Pendientes

Filtra por estado:
- **Pendiente** (Pending)
- **En Proceso** (In Progress)

### 3. Completa la Orden

1. Haz clic en la orden
2. Verifica que todos los ingredientes estén disponibles
3. Haz clic en **"Completar"** o **"Complete"**
4. Confirma la acción

### 4. Verifica el Stock

1. Ve a: **Productos → Lista de Productos**
2. Busca el producto manufacturado
3. Verifica que el stock se haya actualizado
4. Ahora debería tener stock disponible ✅

## Configuración Avanzada (Opcional)

### Habilitar Sobreventa por Ubicación

Si tienes múltiples ubicaciones, puedes configurar sobreventa por ubicación:

1. Ve a: **Configuración → Ubicaciones del Negocio**
2. Edita cada ubicación
3. Activa "Permitir sobreventa" para esa ubicación específica

### Habilitar Sobreventa por Producto

También puedes habilitar sobreventa para productos específicos:

1. Ve a: **Productos → Lista de Productos**
2. Edita el producto manufacturado
3. En la sección de inventario, busca "Permitir sobreventa"
4. Activa la opción para ese producto

## Preguntas Frecuentes

### ¿Es seguro habilitar la sobreventa?

✅ **Sí**, es seguro para productos manufacturados porque:
- Puedes producir más unidades según demanda
- No dependes de un stock físico limitado
- El sistema sigue registrando las ventas correctamente

### ¿Afecta a todos los productos?

No, solo afecta a productos que:
- Tienen stock 0 o negativo
- Están configurados para permitir sobreventa

Los productos con stock positivo funcionan normalmente.

### ¿Puedo deshabilitarlo después?

✅ **Sí**, puedes deshabilitarlo en cualquier momento desde:
```
Configuración → Configuración del Negocio → Productos
```

### ¿Qué pasa si vendo más de lo que puedo producir?

El sistema registrará la venta normalmente. Deberás:
1. Crear una orden de producción para cubrir la demanda
2. Completar la orden cuando termines de producir
3. El stock se actualizará automáticamente

## Solución de Problemas

### Los botones siguen deshabilitados después de habilitar sobreventa

1. **Limpia el caché del servidor**:
   ```bash
   php artisan cache:clear
   php artisan view:clear
   ```

2. **Limpia el caché del navegador**:
   - Presiona `Ctrl + Shift + Delete`
   - Selecciona "Caché" o "Cached images and files"
   - Haz clic en "Borrar datos"

3. **Verifica la configuración**:
   ```bash
   php artisan tinker
   ```
   Luego ejecuta:
   ```php
   DB::table('business')->select('enable_overselling')->first();
   ```
   Debe mostrar: `enable_overselling: 1`

### Error al guardar la configuración

Si recibes un error al guardar:

1. Verifica los permisos:
   ```bash
   chmod -R 777 storage
   ```

2. Verifica los logs:
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. Intenta guardar de nuevo

## Resumen

1. ✅ Ve a: **Configuración → Configuración del Negocio**
2. ✅ Activa: **"Permitir sobreventa"** en la sección Productos
3. ✅ Guarda los cambios
4. ✅ Limpia caché del navegador (`Ctrl + Shift + R`)
5. ✅ Prueba en el POS

---

**Recomendación**: Para productos de Manufacturing, es mejor tener la sobreventa habilitada para evitar problemas en el POS.
