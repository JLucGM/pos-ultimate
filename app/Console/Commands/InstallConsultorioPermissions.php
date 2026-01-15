<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InstallConsultorioPermissions extends Command
{
    protected $signature = 'consultorio:install-permissions';
    protected $description = 'Instalar permisos del módulo Consultorio';

    public function handle()
    {
        $this->info('========================================');
        $this->info('INSTALANDO PERMISOS DEL MÓDULO CONSULTORIO');
        $this->info('========================================');
        $this->newLine();

        $permissions = [
            'consultorio.view',
            'consultorio.create',
            'consultorio.edit',
            'consultorio.delete'
        ];

        // Crear permisos
        $this->info('Creando permisos...');
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
            $this->line("✅ {$permission}");
        }

        $this->newLine();

        // Asignar al rol Admin
        $this->info('Asignando permisos al rol Admin...');
        $adminRole = Role::where('name', 'like', 'Admin#%')->first();

        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
            $this->info("✅ Permisos asignados al rol: {$adminRole->name}");
        } else {
            $this->warn('⚠️  No se encontró el rol Admin');
            $this->warn('Deberás asignar los permisos manualmente desde la interfaz');
        }

        $this->newLine();
        $this->info('========================================');
        $this->info('✅ INSTALACIÓN COMPLETADA');
        $this->info('========================================');
        $this->newLine();
        $this->info('Próximos pasos:');
        $this->line('1. Ir a Configuración → Módulos');
        $this->line('2. Habilitar el módulo "Consultorio"');
        $this->line('3. Refrescar la página');
        $this->newLine();

        return 0;
    }
}
