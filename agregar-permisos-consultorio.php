<?php
/**
 * Script para agregar permisos del módulo Consultorio
 * Ejecutar con: php artisan tinker < agregar-permisos-consultorio.php
 * O copiar y pegar en tinker
 */

// Crear permisos
$permissions = [
    'consultorio.view',
    'consultorio.create',
    'consultorio.edit',
    'consultorio.delete'
];

foreach ($permissions as $permission) {
    \Spatie\Permission\Models\Permission::firstOrCreate([
        'name' => $permission,
        'guard_name' => 'web'
    ]);
    echo "✅ Permiso creado: $permission\n";
}

// Asignar permisos al rol Admin
$adminRole = \Spatie\Permission\Models\Role::where('name', 'like', 'Admin#%')->first();

if ($adminRole) {
    $adminRole->givePermissionTo($permissions);
    echo "✅ Permisos asignados al rol: {$adminRole->name}\n";
} else {
    echo "⚠️  No se encontró el rol Admin. Asigna los permisos manualmente.\n";
}

echo "\n✅ PROCESO COMPLETADO\n";
