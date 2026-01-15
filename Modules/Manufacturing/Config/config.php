<?php

return [
    'name' => 'Manufacturing',
    'version' => '1.0.0',
    
    // Estados de órdenes de producción
    'production_order_statuses' => [
        'pending' => 'Pendiente',
        'in_progress' => 'En Proceso',
        'completed' => 'Completada',
        'cancelled' => 'Cancelada',
    ],
    
    // Prefijo para números de referencia
    'production_order_prefix' => 'PRD',
    
    // Configuraciones adicionales
    'allow_negative_stock' => false,
    'auto_complete_orders' => true,
    'track_production_time' => true,
];
