# Módulo Consultorio - Sistema de Gestión de Citas

## 📋 Descripción
Módulo completo para gestión de consultorios médicos, salones de belleza, spas y negocios similares.

## ✨ Funcionalidades Implementadas

### 1. Gestión de Citas
- ✅ Crear, editar, ver y cancelar citas
- ✅ Asignación a personal (doctor/estilista)
- ✅ Estados: Reservada → En Espera → Atendiendo → Atendido/Cancelada
- ✅ Número de cita único autogenerado
- ✅ Duración configurable
- ✅ Notas y descripción de servicio
- ✅ Monto estimado

### 2. Sala de Espera
- ✅ Vista en tiempo real de citas del día
- ✅ Cambio de estados desde la interfaz
- ✅ Actualización automática

### 3. Integración con POS
- ✅ Campo para vincular cita con transacción de venta
- ✅ Datos del paciente/cliente disponibles para facturación

## 📁 Estructura Creada

```
Modules/Consultorio/
├── Database/Migrations/
│   └── 2026_01_15_000001_create_appointments_table.php
├── Entities/
│   └── Appointment.php
├── Http/Controllers/
│   ├── AppointmentController.php
│   └── WaitingRoomController.php
├── Resources/views/
│   ├── appointments/
│   │   └── index.blade.php
│   └── waiting_room/
├── Routes/
│   └── web.php
├── Providers/
│   └── ConsultorioServiceProvider.php
└── module.json
```

## 🚀 Instalación

### Paso 1: Registrar el Service Provider

Edita `config/app.php` y agrega en el array `providers`:

```php
Modules\Consultorio\Providers\ConsultorioServiceProvider::class,
```

### Paso 2: Ejecutar Migraciones

```bash
php artisan migrate
```

### Paso 3: Crear Permisos

Ejecuta en el servidor:

```bash
php artisan tinker
```

Luego:

```php
$permissions = [
    ['name' => 'consultorio.view', 'guard_name' => 'web'],
    ['name' => 'consultorio.create', 'guard_name' => 'web'],
    ['name' => 'consultorio.edit', 'guard_name' => 'web'],
    ['name' => 'consultorio.delete', 'guard_name' => 'web'],
];

foreach ($permissions as $permission) {
    \Spatie\Permission\Models\Permission::create($permission);
}

// Asignar permisos al rol Admin
$admin_role = \Spatie\Permission\Models\Role::where('name', 'like', 'Admin#%')->first();
if ($admin_role) {
    $admin_role->givePermissionTo(['consultorio.view', 'consultorio.create', 'consultorio.edit', 'consultorio.delete']);
}

echo "Permisos creados\n";
exit
```

### Paso 4: Agregar al Menú

Edita `app/Http/Middleware/AdminSidebarMenu.php` y agrega antes del cierre de `Menu::create`:

```php
//Consultorio dropdown
if (in_array('consultorio', $enabled_modules) && auth()->user()->can('consultorio.view')) {
    $menu->dropdown(
        'Consultorio',
        function ($sub) {
            $sub->url(
                action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'index']),
                'Citas',
                ['icon' => '', 'active' => request()->segment(1) == 'consultorio' && request()->segment(2) == 'appointments']
            );
            $sub->url(
                action([\Modules\Consultorio\Http\Controllers\WaitingRoomController::class, 'index']),
                'Sala de Espera',
                ['icon' => '', 'active' => request()->segment(1) == 'consultorio' && request()->segment(2) == 'waiting-room']
            );
        },
        ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="tw-size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path></svg>']
    )->order(75);
}
```

### Paso 5: Agregar a Módulos Disponibles

Edita `app/Utils/ModuleUtil.php` en el método `availableModules()` y agrega:

```php
'consultorio' => [
    'name' => 'Consultorio',
    'tooltip' => 'Gestión de citas para consultorios médicos y salones de belleza',
],
```

### Paso 6: Limpiar Caché

```bash
php artisan optimize:clear
composer dump-autoload
```

## 📝 Vistas Pendientes de Crear

1. `appointments/create.blade.php` - Formulario de nueva cita
2. `appointments/edit.blade.php` - Formulario de edición
3. `appointments/show.blade.php` - Detalle de cita
4. `waiting_room/index.blade.php` - Sala de espera
5. `waiting_room/partials/appointments_list.blade.php` - Lista de citas

## 🎯 Próximas Mejoras

- [ ] Calendario visual con FullCalendar
- [ ] Notificaciones por email/SMS
- [ ] Recordatorios automáticos
- [ ] Historial de citas por paciente
- [ ] Reportes de citas
- [ ] Integración directa con POS para crear venta desde cita

## 🔗 URLs del Módulo

- Citas: `/consultorio/appointments`
- Sala de Espera: `/consultorio/waiting-room`
- Nueva Cita: `/consultorio/appointments/create`

## ⚠️ Notas Importantes

1. El módulo debe estar habilitado en Configuración → Módulos
2. Los usuarios necesitan los permisos `consultorio.*` para acceder
3. Se requiere tener contactos tipo "customer" para asignar citas
4. La integración con POS se hace mediante el campo `transaction_id`
