# 🚨 Solución: Sistema Caído + Botones POS Deshabilitados

## 📌 Inicio Rápido (3 Pasos)

### 1️⃣ Conecta al Servidor
```bash
ssh tu_usuario@audaz.site
cd /home/audaz.site/public_html
```

### 2️⃣ Ejecuta el Script de Recuperación
```bash
bash fix-sistema-completo.sh
```

### 3️⃣ Habilita Sobreventa
1. Abre: https://audaz.site/
2. Ve a: **Configuración → Configuración del Negocio → Productos**
3. Activa: **"Permitir sobreventa"**
4. Guarda cambios

✅ **¡Listo!** El sistema debería funcionar correctamente.

---

## 📚 Documentación Completa

### 🔴 Urgente - Lee Primero
- **[INSTRUCCIONES_URGENTES.md](INSTRUCCIONES_URGENTES.md)** - Guía rápida de 3 pasos
- **[FLUJO_SOLUCION.txt](FLUJO_SOLUCION.txt)** - Diagrama visual del proceso

### 📖 Guías Detalladas
- **[RESUMEN_SOLUCION.md](RESUMEN_SOLUCION.md)** - Resumen ejecutivo completo
- **[SOLUCION_COMPLETA_SISTEMA.md](SOLUCION_COMPLETA_SISTEMA.md)** - Documentación técnica detallada
- **[HABILITAR_SOBREVENTA.md](HABILITAR_SOBREVENTA.md)** - Guía paso a paso para habilitar sobreventa
- **[DIAGNOSTICO_POS_MANUFACTURING.md](DIAGNOSTICO_POS_MANUFACTURING.md)** - Análisis técnico del problema

### 🔧 Scripts Disponibles
- **`fix-sistema-completo.sh`** ⭐ - Script principal de recuperación (EJECUTAR PRIMERO)
- **`emergency-recovery.sh`** - Recuperación básica del sistema
- **`check-system-status.sh`** - Verificación de estado del sistema
- **`diagnostico-pos-manufacturing.sh`** - Diagnóstico específico del POS

---

## 🎯 ¿Qué Problemas Resuelve?

### Problema 1: Sistema Caído
**Error:**
```
UnexpectedValueException: The stream or file 
"/home/audaz.site/public_html/storage/logs/laravel-2026-01-19.log" 
could not be opened in append mode: Permission denied
```

**Solución:**
- Limpia todos los cachés
- Corrige permisos de storage y logs
- Reconstruye caché de configuración y rutas

### Problema 2: Botones POS Deshabilitados
**Error:**
- Botones "Efectivo" y "Pago Múltiple" deshabilitados
- No se pueden completar ventas de productos manufacturados

**Solución:**
- Habilitar sobreventa en configuración
- O completar órdenes de producción pendientes

---

## 🛠️ Comandos Útiles

### Recuperación
```bash
# Script completo (recomendado)
bash fix-sistema-completo.sh

# Recuperación básica
bash emergency-recovery.sh

# Verificar estado
bash check-system-status.sh
```

### Limpieza Manual
```bash
# Limpiar cachés
php artisan optimize:clear

# Corregir permisos
chmod -R 777 storage bootstrap/cache

# Reconstruir caché
php artisan config:cache
php artisan route:cache
```

### Diagnóstico
```bash
# Ver logs en tiempo real
tail -f storage/logs/laravel.log

# Verificar productos manufacturados
php artisan tinker
DB::table('products')->where('type', 'manufactured')->get();

# Verificar sobreventa
php artisan tinker
DB::table('business')->select('enable_overselling')->first();
```

---

## 📊 Estructura de la Solución

```
┌─────────────────────────────────────────────────────────┐
│ FASE 1: Recuperación del Sistema                       │
│ ✓ Limpiar cachés                                        │
│ ✓ Corregir permisos                                     │
│ ✓ Verificar BD                                          │
│ ✓ Reconstruir caché                                     │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ FASE 2: Diagnóstico POS                                 │
│ ✓ Verificar productos manufacturados                    │
│ ✓ Verificar órdenes de producción                       │
│ ✓ Verificar configuración de sobreventa                 │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ FASE 3: Solución Botones POS                            │
│ Opción A: Habilitar sobreventa (recomendado)           │
│ Opción B: Completar órdenes de producción              │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ FASE 4: Verificación                                    │
│ ✓ Sistema carga correctamente                           │
│ ✓ Botones POS habilitados                               │
│ ✓ Venta de prueba exitosa                               │
└─────────────────────────────────────────────────────────┘
```

---

## ⏱️ Tiempo Estimado

| Tarea | Tiempo |
|-------|--------|
| Recuperación del sistema | 2-3 min |
| Habilitar sobreventa | 5 min |
| Verificación y pruebas | 5 min |
| **TOTAL** | **10-15 min** |

---

## ✅ Checklist de Verificación

### Sistema Recuperado
- [ ] Script `fix-sistema-completo.sh` ejecutado sin errores
- [ ] URL `https://audaz.site/` carga correctamente
- [ ] No hay errores en `storage/logs/laravel.log`
- [ ] Permisos de storage y bootstrap/cache son 777

### Sobreventa Habilitada
- [ ] Opción "Permitir sobreventa" activada en Configuración
- [ ] Caché del navegador limpiado (`Ctrl + Shift + R`)
- [ ] Verificado con: `DB::table('business')->select('enable_overselling')->first()`

### POS Funcionando
- [ ] Ubicación seleccionada
- [ ] Cliente seleccionado
- [ ] Producto manufacturado agregado al carrito
- [ ] Botones "Efectivo" y "Pago Múltiple" habilitados
- [ ] Venta de prueba completada exitosamente

---

## 🆘 Solución de Problemas

### El script falla
```bash
# Ejecutar recuperación básica
bash emergency-recovery.sh

# O manualmente
php artisan optimize:clear
chmod -R 777 storage bootstrap/cache
php artisan config:cache
```

### El sistema no carga
```bash
# Ver logs
tail -50 storage/logs/laravel.log

# Verificar servicios
sudo systemctl status apache2
sudo systemctl status mysql

# Reiniciar servicios
sudo systemctl restart apache2
```

### Los botones siguen deshabilitados
1. Verificar que sobreventa esté habilitada
2. Limpiar caché del navegador (`Ctrl + Shift + R`)
3. Abrir consola del navegador (F12) y buscar errores
4. Verificar que el producto tenga precio configurado
5. Verificar que el cliente esté seleccionado

### Error de base de datos
```bash
# Verificar credenciales en .env
cat .env | grep DB_

# Probar conexión
php artisan tinker
DB::connection()->getPdo();
```

---

## 📞 Soporte Adicional

Si después de seguir todos los pasos el problema persiste:

1. **Revisar logs completos**
   ```bash
   tail -100 storage/logs/laravel.log
   ```

2. **Verificar configuración del servidor**
   - PHP versión: `php -v`
   - MySQL corriendo: `sudo systemctl status mysql`
   - Apache/Nginx corriendo: `sudo systemctl status apache2`

3. **Verificar espacio en disco**
   ```bash
   df -h
   ```

4. **Verificar permisos del usuario web**
   ```bash
   ps aux | grep apache2 | head -1
   # O
   ps aux | grep nginx | head -1
   ```

---

## 🎓 Información Técnica

### Causa Raíz del Problema POS

El archivo `public/js/pos.js` valida el stock antes de habilitar los botones de pago:

```javascript
// Líneas 201-202, 235, 263
if ((ui.item.enable_stock == 1 && ui.item.qty_available > 0) || 
    (ui.item.enable_stock == 0) || 
    is_overselling_allowed || 
    for_so) {
    // Habilitar botones
}
```

**Problema:** Los productos manufacturados pueden tener `qty_available = 0` después de crear una orden de producción pero antes de completarla.

**Solución:** Habilitar `is_overselling_allowed` permite ventas sin stock, ideal para productos manufacturados que se producen bajo demanda.

### Archivos Involucrados

- `public/js/pos.js` - Validaciones del POS
- `app/Http/Controllers/SellPosController.php` - Controlador del POS
- `Modules/Manufacturing/Http/Controllers/ProductionOrderController.php` - Órdenes de producción
- `storage/logs/laravel.log` - Logs del sistema

---

## 📝 Notas Importantes

- ✅ Los scripts son seguros y no borran datos
- ✅ Solo limpian cachés y corrigen permisos
- ✅ La sobreventa es reversible en cualquier momento
- ✅ Recomendado para productos manufacturados
- ⚠️ Siempre hacer backup antes de cambios importantes

---

## 🎉 Resultado Esperado

Después de completar todos los pasos:

✅ Sistema funcionando correctamente  
✅ Sin errores de permisos  
✅ Botones POS habilitados  
✅ Ventas de productos manufacturados funcionando  
✅ Caché limpio y optimizado  

---

## 📅 Historial

- **2026-01-19**: Problema identificado y solución implementada
- **Problema 1**: Sistema caído por permisos en logs
- **Problema 2**: Botones POS deshabilitados para productos manufacturados
- **Solución**: Scripts de recuperación + habilitar sobreventa

---

## 👨‍💻 Autor

Documentación creada para resolver problemas críticos en Audaz POS.

---

**¿Necesitas ayuda?** Lee primero [INSTRUCCIONES_URGENTES.md](INSTRUCCIONES_URGENTES.md)
