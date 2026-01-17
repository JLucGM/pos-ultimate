<?php

return [
    /*
    |--------------------------------------------------------------------------
    | UI Theme Configuration
    |--------------------------------------------------------------------------
    |
    | Configuración del tema de la interfaz de usuario
    | 
    | Options: 'default', 'modern'
    |
    */

    'auth_theme' => env('AUTH_THEME', 'modern'),
    
    /*
    |--------------------------------------------------------------------------
    | Landing Page Theme
    |--------------------------------------------------------------------------
    |
    | Configuración del tema de la landing page
    |
    */

    'landing_theme' => env('LANDING_THEME', 'modern'),
];
