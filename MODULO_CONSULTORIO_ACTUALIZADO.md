# Módulo Consultorio - Actualización con Calendario

## Cambios Realizados

### ✅ Calendario Interactivo
- Implementado calendario estilo FullCalendar (igual al módulo Restaurant)
- Vista mensual, semanal, diaria y lista
- Colores por estado:
  - 🟡 Amarillo: Reservada / En Espera
  - 🔵 Azul: Atendiendo
  - 🟢 Verde: Atendido
  - 🔴 Rojo: Cancelada
- Doble click en cualquier día para crear nueva cita
- Click en cita para ver detalles y cambiar estado

### ✅ Formulario de Creación de Citas Mejorado
El formulario ahora incluye:
- **Paciente/Cliente**: Selector con opción de crear nuevo cliente rápido
- **Fecha y Hora**: DateTimePicker con calendario
- **Duración**: En minutos (por defecto 30 min)
- **Ubicación**: Selector de sucursales
- **Asignar a**: Selector de personal (doctor/estilista)
- **Tipo de Servicio**: Campo de texto para describir el servicio requerido
- **Monto Estimado**: Campo numérico para el costo estimado
- **Notas Adicionales**: Para observaciones, alergias, preferencias, etc.

### ✅ Creación Rápida de Clientes
Al hacer click en el botón "+" junto al selector de clientes, se abre un modal para crear un nuevo cliente con:
- Nombre
- Apellido
- Teléfono/WhatsApp
- Tipo de contacto (automáticamente "Cliente")
- Otros campos opcionales

### ✅ Vista de Citas de Hoy
- Tabla con las citas del día actual
- Filtro por ubicación
- Actualización automática al crear/editar citas

### ✅ Modal de Detalles de Cita
Al hacer click en una cita del calendario se muestra:
- Información completa del paciente/cliente
- Teléfono de contacto
- Fecha, hora y duración
- Ubicación y personal asignado
- Tipo de servicio solicitado
- Notas adicionales
- Selector de estado para cambiar el estado de la cita
- Botón para eliminar cita (si no está completada o cancelada)

### ✅ Corrección de Errores
- Corregido error de `user_full_name` en el controlador
- Ahora usa `first_name` y `last_name` correctamente
- Agregado `Util` para formateo de fechas
- Soporte para AJAX en store/update para el calendario

## Estructura de Archivos

```
Modules/Consultorio/
├── Http/Controllers/
│   └── AppointmentController.php (actualizado)
├── Resources/views/appointments/
│   ├── index.blade.php (actualizado con calendario)
│   ├── create_modal.blade.php (nuevo)
│   └── show_modal.blade.php (nuevo)
```

## Deployment

### En el Servidor

```bash
cd /home/audaz.site/public_html
bash deploy-consultorio.sh
php artisan consultorio:install-permissions
```

### En la Interfaz Web

1. Ir a **Configuración → Módulos**
2. Habilitar el módulo **Consultorio**
3. Refrescar la página (F5)
4. Click en **Consultorio** en el menú lateral

## Uso del Módulo

### Crear una Cita

**Opción 1: Desde el botón**
1. Click en "Nueva Cita"
2. Llenar el formulario
3. Guardar

**Opción 2: Desde el calendario**
1. Doble click en cualquier día del calendario
2. Se abre el modal con la fecha pre-seleccionada
3. Llenar los demás campos
4. Guardar

### Crear un Cliente Rápido

1. En el formulario de cita, click en el botón "+" junto a "Paciente/Cliente"
2. Llenar:
   - Nombre
   - Apellido
   - Teléfono/WhatsApp
3. Guardar
4. El cliente se selecciona automáticamente en el formulario de cita

### Ver/Editar una Cita

1. Click en cualquier cita del calendario
2. Se abre el modal con los detalles
3. Cambiar el estado si es necesario
4. Click en "Actualizar"

### Cambiar Estado de Cita

Los estados disponibles son:
- **Reservada**: Estado inicial al crear la cita
- **En Espera**: Cuando el paciente llega y está esperando
- **Atendiendo**: Cuando está siendo atendido
- **Atendido**: Cuando terminó la atención
- **Cancelada**: Si se cancela la cita

### Sala de Espera

1. Click en "Sala de Espera" en la vista de citas
2. Ver todas las citas en estado "En Espera"
3. Cambiar estado a "Atendiendo" cuando corresponda

## Características Técnicas

- **FullCalendar**: Biblioteca JavaScript para el calendario
- **Select2**: Para selectores mejorados
- **DateTimePicker**: Para selección de fecha y hora
- **DataTables**: Para la tabla de citas de hoy
- **AJAX**: Para crear/editar citas sin recargar la página
- **Validación**: Formularios validados con jQuery Validate

## Próximas Mejoras Sugeridas

- [ ] Notificaciones por WhatsApp/SMS
- [ ] Recordatorios automáticos de citas
- [ ] Historial de citas por paciente
- [ ] Integración con facturación desde la cita
- [ ] Reportes de citas por período
- [ ] Bloqueo de horarios no disponibles
- [ ] Citas recurrentes

## Soporte

Si encuentras algún error o necesitas ayuda:
1. Revisar logs: `tail -50 storage/logs/laravel.log`
2. Limpiar caché: `php artisan optimize:clear`
3. Verificar permisos: `chmod -R 777 storage bootstrap/cache`
