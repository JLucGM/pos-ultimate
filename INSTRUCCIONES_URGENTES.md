# 🚨 INSTRUCCIONES URGENTES - SISTEMA CAÍDO

## PROBLEMA ACTUAL

Tu sistema está caído con este error:
```
UnexpectedValueException: The stream or file could not be opened in append mode: Permission denied
```

Además, los botones de pago en el POS están deshabilitados para productos de Manufacturing.

## SOLUCIÓN RÁPIDA (3 PASOS)

### PASO 1: Conecta al Servidor

```bash
ssh tu_usuario@audaz.site
cd /home/audaz.site/public_html
```

### PASO 2: Ejecuta el Script de Recuperación

```bash
bash fix-sistema-completo.sh
```

Este script hará:
- ✅ Limpiar todos los cachés
- ✅ Corregir permisos de storage y logs
- ✅ Verificar conexión a base de datos
- ✅ Diagnosticar productos manufacturados
- ✅ Verificar órdenes de producción
- ✅ Revisar configuración de sobreventa

### PASO 3: Verifica que Funcione

Abre en tu navegador:
```
https://audaz.site/
```

Si carga correctamente, el sistema está recuperado ✅

## SOLUCIÓN DEL PROBLEMA POS

Una vez que el sistema esté funcionando, para solucionar los botones deshabilitados:

### OPCIÓN A: Habilitar Sobreventa (MÁS FÁCIL) ⭐

1. Inicia sesión en Audaz POS
2. Ve a: **Configuración → Configuración del Negocio**
3. Busca la sección **Productos**
4. Activa: **"Permitir sobreventa"** (Enable Overselling)
5. Guarda los cambios

✅ Esto permitirá vender productos manufacturados incluso sin stock

### OPCIÓN B: Completar Órdenes de Producción

1. Ve a: **Manufacturing → Órdenes de Producción**
2. Busca las órdenes con estado "Pendiente" o "En Proceso"
3. Haz clic en cada orden y márcala como **"Completada"**
4. Verifica que el stock del producto se haya actualizado

## SI EL SCRIPT NO FUNCIONA

Ejecuta estos comandos manualmente:

```bash
# Limpiar cachés
php artisan optimize:clear
rm -rf bootstrap/cache/*.php
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/views/*.php

# Corregir permisos
chmod -R 777 storage
chmod -R 777 bootstrap/cache

# Reconstruir caché
php artisan config:cache
php artisan route:cache
```

## VERIFICAR LOGS

Si el sistema sigue sin funcionar:

```bash
# Ver últimos errores
tail -50 storage/logs/laravel.log

# Ver logs en tiempo real
tail -f storage/logs/laravel.log
```

## REINICIAR SERVICIOS (Si tienes acceso root)

```bash
# Para Apache
sudo systemctl restart apache2

# Para Nginx + PHP-FPM
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm
```

## CONTACTO DE EMERGENCIA

Si nada funciona, verifica:

1. **Base de datos**: ¿Está corriendo MySQL?
   ```bash
   sudo systemctl status mysql
   ```

2. **Servidor web**: ¿Está corriendo Apache/Nginx?
   ```bash
   sudo systemctl status apache2
   # o
   sudo systemctl status nginx
   ```

3. **Archivo .env**: ¿Tiene las credenciales correctas?
   ```bash
   cat .env | grep DB_
   ```

## ARCHIVOS DE AYUDA

- `SOLUCION_COMPLETA_SISTEMA.md` - Guía detallada completa
- `DIAGNOSTICO_POS_MANUFACTURING.md` - Diagnóstico del problema POS
- `fix-sistema-completo.sh` - Script de recuperación automática
- `emergency-recovery.sh` - Script de recuperación básica
- `check-system-status.sh` - Script de verificación de estado

## RESUMEN

1. ✅ Ejecuta: `bash fix-sistema-completo.sh`
2. ✅ Verifica: `https://audaz.site/`
3. ✅ Habilita sobreventa en Configuración
4. ✅ Prueba venta en POS

---

**IMPORTANTE**: El script `fix-sistema-completo.sh` es seguro y no borrará datos. Solo limpia cachés y corrige permisos.
