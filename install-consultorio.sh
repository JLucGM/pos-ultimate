#!/bin/bash

echo "=== Instalación del Módulo Consultorio ==="
echo ""

# Colores
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Paso 1: Ejecutando migraciones...${NC}"
php artisan migrate --path=Modules/Consultorio/Database/Migrations

echo ""
echo -e "${YELLOW}Paso 2: Creando permisos...${NC}"
php artisan tinker << 'EOF'
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

// Asignar permisos al rol Admin
$admin_roles = \Spatie\Permission\Models\Role::where('name', 'like', 'Admin#%')->get();
foreach ($admin_roles as $admin_role) {
    $admin_role->givePermissionTo(['consultorio.view', 'consultorio.create', 'consultorio.edit', 'consultorio.delete']);
    echo "Permisos asignados al rol: " . $admin_role->name . "\n";
}

echo "Permisos configurados correctamente\n";
exit
EOF

echo ""
echo -e "${YELLOW}Paso 3: Limpiando caché...${NC}"
php artisan optimize:clear
composer dump-autoload

echo ""
echo -e "${GREEN}=== Instalación Completada ===${NC}"
echo ""
echo "Próximos pasos:"
echo "1. Ve a Configuración → Módulos"
echo "2. Activa el módulo 'Consultorio'"
echo "3. Accede a Consultorio → Citas"
echo ""
echo "URLs del módulo:"
echo "- Citas: /consultorio/appointments"
echo "- Sala de Espera: /consultorio/waiting-room"
