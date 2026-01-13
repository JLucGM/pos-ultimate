<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Landing Page Configuration
    |--------------------------------------------------------------------------
    |
    | Configuración para personalizar la landing page del sistema POS
    |
    */

    'site_name' => env('APP_NAME', 'Audaz POS'),
    
    'tagline' => 'Gestiona tu Negocio con el Sistema POS Más Completo',
    
    'description' => 'Controla ventas, inventario, clientes y reportes desde cualquier lugar. Perfecto para restaurantes, tiendas y pequeñas empresas.',

    /*
    |--------------------------------------------------------------------------
    | Contact Information
    |--------------------------------------------------------------------------
    */
    'contact' => [
        'email' => env('CONTACT_EMAIL', 'info@audaz.site'),
        'phone' => env('CONTACT_PHONE', '+58 424 290 9870'),
        'address' => env('CONTACT_ADDRESS', 'Carrera 34, Terrazas del ingenio'),
        'whatsapp' => env('WHATSAPP_NUMBER', '+58 424 290 9870'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Social Media Links
    |--------------------------------------------------------------------------
    */
    'social' => [
        'facebook' => env('FACEBOOK_URL', '#'),
        'twitter' => env('TWITTER_URL', '#'),
        'instagram' => env('INSTAGRAM_URL', '#'),
        'linkedin' => env('LINKEDIN_URL', '#'),
        'youtube' => env('YOUTUBE_URL', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Statistics (Hero Section)
    |--------------------------------------------------------------------------
    */
    'stats' => [
        [
            'number' => '500+',
            'label' => 'Empresas Activas',
        ],
        [
            'number' => '50K+',
            'label' => 'Transacciones/Mes',
        ],
        [
            'number' => '99.9%',
            'label' => 'Uptime',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    */
    'features' => [
        [
            'icon' => 'fas fa-cash-register',
            'color' => 'blue',
            'title' => 'Punto de Venta Rápido',
            'description' => 'Interfaz intuitiva para procesar ventas en segundos. Soporte para múltiples métodos de pago.',
        ],
        [
            'icon' => 'fas fa-boxes',
            'color' => 'green',
            'title' => 'Gestión de Inventario',
            'description' => 'Control total de stock, alertas de bajo inventario, transferencias entre sucursales.',
        ],
        [
            'icon' => 'fas fa-users',
            'color' => 'purple',
            'title' => 'CRM de Clientes',
            'description' => 'Gestiona clientes, historial de compras, programas de lealtad y grupos personalizados.',
        ],
        [
            'icon' => 'fas fa-chart-bar',
            'color' => 'orange',
            'title' => 'Reportes Avanzados',
            'description' => 'Análisis de ventas, Productos más vendidos, reportes financieros y gráficos en tiempo real.',
        ],
        [
            'icon' => 'fas fa-store-alt',
            'color' => 'red',
            'title' => 'Multi-Sucursal',
            'description' => 'Gestiona múltiples ubicaciones desde un solo panel. Transferencias y reportes consolidados.',
        ],
        [
            'icon' => 'fas fa-utensils',
            'color' => 'teal',
            'title' => 'Módulo Restaurante',
            'description' => 'Gestión de mesas, comandas de cocina, modificadores y Producto de meseros.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Benefits
    |--------------------------------------------------------------------------
    */
    'benefits' => [
        [
            'title' => 'Fácil de Usar',
            'description' => 'Interfaz intuitiva que tu equipo aprenderá en minutos',
        ],
        [
            'title' => 'Acceso desde Cualquier Lugar',
            'description' => 'Sistema en la nube accesible desde cualquier dispositivo',
        ],
        [
            'title' => 'Soporte en Español',
            'description' => 'Equipo de soporte disponible para ayudarte cuando lo necesites',
        ],
        [
            'title' => 'Actualizaciones Constantes',
            'description' => 'Nuevas funcionalidades y mejoras incluidas en tu suscripción',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Testimonials
    |--------------------------------------------------------------------------
    */
    'testimonials' => [
        [
            'name' => 'María González',
            'position' => 'Dueña, Café Central',
            'avatar' => 'avatar1.jpg',
            'rating' => 5,
            'text' => 'Excelente sistema, fácil de usar y con todas las funciones que necesitamos. El soporte es muy rápido.',
        ],
        [
            'name' => 'Carlos Ruiz',
            'position' => 'Gerente, Tienda Fashion',
            'avatar' => 'avatar2.jpg',
            'rating' => 5,
            'text' => 'Desde que implementamos este POS, nuestras ventas aumentaron 30%. Los reportes son increíbles.',
        ],
        [
            'name' => 'Ana Martínez',
            'position' => 'Propietaria, Restaurante El Sabor',
            'avatar' => 'avatar3.jpg',
            'rating' => 5,
            'text' => 'Perfecto para nuestro restaurante. La gestión de mesas y comandas es muy eficiente.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | FAQ
    |--------------------------------------------------------------------------
    */
    'faq' => [
        [
            'question' => '¿Necesito instalar algún software?',
            'answer' => 'No, nuestro sistema es 100% en la nube. Solo necesitas un navegador web y conexión a internet para acceder desde cualquier dispositivo.',
        ],
        [
            'question' => '¿Puedo cambiar de plan en cualquier momento?',
            'answer' => 'Sí, puedes actualizar o cambiar tu plan en cualquier momento. Los cambios se aplican inmediatamente y solo pagas la diferencia prorrateada.',
        ],
        [
            'question' => '¿Ofrecen período de prueba?',
            'answer' => 'Sí, todos nuestros planes incluyen 14 días de prueba gratuita. No se requiere tarjeta de crédito para comenzar.',
        ],
        [
            'question' => '¿Qué métodos de pago aceptan?',
            'answer' => 'Aceptamos tarjetas de crédito/débito, PayPal, transferencias bancarias y otros métodos de pago locales.',
        ],
        [
            'question' => '¿Mis datos están seguros?',
            'answer' => 'Absolutamente. Utilizamos encriptación SSL, backups diarios automáticos y cumplimos con los estándares de seguridad más altos.',
        ],
        [
            'question' => '¿Ofrecen capacitación?',
            'answer' => 'Sí, incluimos videos tutoriales, documentación completa y sesiones de capacitación en vivo para planes Profesional y Empresarial.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Call to Action
    |--------------------------------------------------------------------------
    */
    'cta' => [
        'title' => '¿Listo para Transformar tu Negocio?',
        'subtitle' => 'Únete a cientos de empresas que ya confían en nuestro sistema POS',
        'primary_button' => 'Comenzar Prueba Gratuita',
        'secondary_button' => 'Contactar Ventas',
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO Configuration
    |--------------------------------------------------------------------------
    */
    'seo' => [
        'title' => 'Sistema POS para Pequeñas Empresas | ' . env('APP_NAME', 'POS System'),
        'description' => 'Sistema POS completo en la nube para gestionar ventas, inventario, clientes y reportes. Perfecto para restaurantes, tiendas y pequeñas empresas.',
        'keywords' => 'pos, punto de venta, sistema pos, inventario, ventas, restaurante, tienda, pequeñas empresas',
        'og_image' => env('APP_URL', 'http://localhost') . '/images/og-image.jpg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Analytics
    |--------------------------------------------------------------------------
    */
    'analytics' => [
        'google_analytics_id' => env('GOOGLE_ANALYTICS_ID', null),
        'facebook_pixel_id' => env('FACEBOOK_PIXEL_ID', null),
        'google_tag_manager_id' => env('GOOGLE_TAG_MANAGER_ID', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Features Flags
    |--------------------------------------------------------------------------
    */
    'features_enabled' => [
        'chat_widget' => env('ENABLE_CHAT_WIDGET', false),
        'blog' => env('ENABLE_BLOG', false),
        'demo_request' => env('ENABLE_DEMO_REQUEST', true),
        'newsletter' => env('ENABLE_NEWSLETTER', true),
    ],
];
