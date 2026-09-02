<?php

namespace Modules\Consultorio\Http\Controllers;

use Illuminate\Routing\Controller;

class DataController extends Controller
{
    /**
     * Defines user permissions for the module.
     *
     * @return array
     */
    public function user_permissions()
    {
        return [
            [
                'value' => 'consultorio.view',
                'label' => 'Ver Consultorio y Citas',
                'default' => false,
            ],
            [
                'value' => 'consultorio.create',
                'label' => 'Crear y Agendar Citas',
                'default' => false,
            ],
            [
                'value' => 'consultorio.edit',
                'label' => 'Editar Citas',
                'default' => false,
            ],
            [
                'value' => 'consultorio.delete',
                'label' => 'Eliminar y Cancelar Citas',
                'default' => false,
            ],
        ];
    }

    /**
     * Superadmin package custom permissions
     *
     * @return array
     */
    public function superadmin_package()
    {
        return [
            [
                'name' => 'consultorio_module',
                'label' => 'Módulo de Consultorio y Citas',
                'default' => false,
            ],
        ];
    }
}
