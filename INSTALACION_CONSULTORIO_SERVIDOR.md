# 🏥 Instalación del Módulo Consultorio en Producción

## Pasos para instalar en el servidor

### 1. Conectarse al servidor y actualizar código

```bash
cd /home/audaz.site/public_html
git pull origin main
```

### 2. Ejecutar el script de instalación

```bash
chmod +x install-consultorio.sh
./install-consultorio.sh
```

**O manualmente:**

```bash
# Ejecutar migraciones
php artisan migrate --path=Modules/Consultorio/Database/Migrations

# Crear permisos
php artisan tinker
```

Dentro de tinker:
```php
$permissions = [
    ['name' => 'consultorio.view', 'guard_name' => 'web'],
    ['name' => 'consultorio.create', 'guard_name' => 'web'],
    ['name' => 'consultorio.edit', 'guard_name' => 'web'],
    ['name' => 'consultorio.delete', 'guard_name' => 'web'],
];

foreach ($permissions as $permission) {
    try {
        \Spatie\Permission\Models\Permission::create($permission);
        echo "Permiso creado: " . $permission['name'] . "\n";
    } catch (\Exception $e) {
        echo "Permiso ya existe: " . $permission['name'] . "\n";
    }
}

$admin_roles = \Spatie\Permission\Models\Role::where('name', 'like', 'Admin#%')->get();
foreach ($admin_roles as $admin_role) {
    $admin_role->givePermissionTo(['consultorio.view', 'consultorio.create', 'consultorio.edit', 'consultorio.delete']);
    echo "Permisos asignados al rol: " . $admin_role->name . "\n";
}

exit
```

### 3. Limpiar caché

```bash
php artisan optimize:clear
composer dump-autoload
chown -R www-data:www-data Modules/Consultorio
chmod -R 755 Modules/Consultorio
```

### 4. Habilitar el módulo

1. Ve a: https://audaz.site/business/settings
2. Haz clic en la pestaña **"Módulos"**
3. Busca y activa el checkbox **"Consultorio"**
4. Guarda los cambios

### 5. Verificar instalación

Accede a:
- **Citas**: https://audaz.site/consultorio/appointments
- **Sala de Espera**: https://audaz.site/consultorio/waiting-room

El menú "Consultorio" debería aparecer en el sidebar con dos opciones:
- Citas
- Sala de Espera

## 🎯 Funcionalidades del Módulo

### Gestión de Citas
- ✅ Crear citas con fecha, hora y duración
- ✅ Asignar a personal (doctor/estilista)
- ✅ Agregar notas y descripción del servicio
- ✅ Monto estimado
- ✅ Editar citas en estado "Reservada"
- ✅ Cancelar citas

### Estados de Citas
1. **Reservada** (por defecto al crear)
2. **En Espera** (cuando el paciente llega)
3. **Atendiendo** (cuando está siendo atendido)
4. **Atendido** (cuando termina)
5. **Cancelada** (si se cancela)

### Sala de Espera
- Vista en tiempo real de citas del día
- Organizada por pestañas según estado
- Cambio rápido de estados
- Auto-actualización cada 30 segundos
- Botones de acción rápida

### Integración con POS
- Desde el detalle de una cita completada, se puede crear venta en POS
- Los datos del paciente/cliente se pasan automáticamente
- Campo para vincular cita con transacción de venta

## 📊 Estructura de la Base de Datos

Tabla: `appointments`
- `id`: ID único
- `business_id`: Negocio
- `location_id`: Ubicación
- `contact_id`: Paciente/Cliente
- `assigned_to`: Personal asignado
- `appointment_number`: Número único (APT202601XXXX)
- `appointment_datetime`: Fecha y hora
- `duration_minutes`: Duración en minutos
- `status`: Estado (reserved, waiting, attending, completed, cancelled)
- `notes`: Notas
- `service_description`: Descripción del servicio
- `estimated_amount`: Monto estimado
- `transaction_id`: Venta asociada (nullable)
- `created_by`: Creado por
- `timestamps`: Fechas de creación/actualización

## 🔐 Permisos

- `consultorio.view`: Ver citas y sala de espera
- `consultorio.create`: Crear nuevas citas
- `consultorio.edit`: Editar citas
- `consultorio.delete`: Cancelar citas

## 🚀 Próximas Mejoras Sugeridas

- [ ] Calendario visual con FullCalendar
- [ ] Notificaciones por email/SMS
- [ ] Recordatorios automáticos
- [ ] Historial de citas por paciente
- [ ] Reportes de citas
- [ ] Integración directa con POS
- [ ] Bloqueo de horarios
- [ ] Citas recurrentes

## ⚠️ Notas Importantes

1. El módulo debe estar habilitado en Configuración → Módulos
2. Los usuarios necesitan los permisos `consultorio.*` para acceder
3. Se requiere tener contactos tipo "customer" para asignar citas
4. La integración con POS se hace mediante el campo `transaction_id`
5. Los números de cita se generan automáticamente: APT + AÑO + MES + SECUENCIA

## 🐛 Solución de Problemas

### El módulo no aparece en el menú
- Verifica que esté habilitado en Configuración → Módulos
- Limpia el caché: `php artisan optimize:clear`
- Verifica permisos del usuario

### Error al crear cita
- Verifica que existan contactos tipo "customer"
- Verifica que existan ubicaciones (business_locations)
- Revisa los logs: `tail -50 storage/logs/laravel.log`

### Sala de espera no actualiza
- Verifica que JavaScript esté habilitado
- Revisa la consola del navegador (F12)
- Limpia caché del navegador

## 📞 Soporte

Para cualquier problema o mejora, revisa:
- `MODULO_CONSULTORIO_README.md` - Documentación completa
- `storage/logs/laravel.log` - Logs de errores
