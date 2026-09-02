<?php

namespace Modules\Manufacturing\Http\Controllers;

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
                'value' => 'manufacturing.view',
                'label' => 'Ver Recetas y Órdenes de Producción',
                'default' => false,
            ],
            [
                'value' => 'manufacturing.edit',
                'label' => 'Crear y Editar Recetas',
                'default' => false,
            ],
            [
                'value' => 'manufacturing.delete',
                'label' => 'Eliminar Recetas y Órdenes',
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
                'name' => 'manufacturing_module',
                'label' => 'Módulo de Producción / Manufactura',
                'default' => false,
            ],
        ];
    }
}
