<?php

namespace Modules\Superadmin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Entities\Package;
use App\Utils\ModuleUtil;

class LandingController extends Controller
{
    protected $moduleUtil;

    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display the landing page
     *
     * @return Response
     */
    public function index()
    {
        // Get active packages for preview from backend
        $packages = Package::active()
            ->notPrivate()
            ->orderBy('sort_order')
            ->get();

        // Get all module permissions and convert them into name => label
        $permissions = $this->moduleUtil->getModuleData('superadmin_package');
        $permission_formatted = [];
        foreach ($permissions as $permission) {
            foreach ($permission as $details) {
                $permission_formatted[$details['name']] = $details['label'];
            }
        }

        return view('superadmin::landing.index', compact('packages', 'permission_formatted'));
    }

    /**
     * Display the modern pricing page
     *
     * @return Response
     */
    public function pricing()
    {
        $packages = Package::active()
            ->notPrivate()
            ->orderBy('sort_order')
            ->get();

        // Get all module permissions and convert them into name => label
        $permissions = $this->moduleUtil->getModuleData('superadmin_package');
        $permission_formatted = [];
        foreach ($permissions as $permission) {
            foreach ($permission as $details) {
                $permission_formatted[$details['name']] = $details['label'];
            }
        }

        return view('superadmin::pricing.modern', compact('packages', 'permission_formatted'));
    }

    /**
     * Handle contact form submission
     *
     * @param Request $request
     * @return Response
     */
    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Send email notification
        try {
            \Mail::send('superadmin::emails.contact', [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company' => $request->company,
                'user_message' => $request->message,
            ], function ($message) use ($request) {
                $message->to(config('mail.from.address'))
                        ->subject('Nuevo mensaje de contacto - ' . $request->name);
                $message->replyTo($request->email, $request->name);
            });

            return response()->json([
                'success' => true,
                'message' => 'Gracias por contactarnos. Te responderemos pronto.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error sending contact email: ' . $e->getMessage());
            
            return response()->json([
                'success' => true,
                'message' => 'Gracias por contactarnos. Te responderemos pronto.'
            ]);
        }
    }

    /**
     * Display contact page
     *
     * @return Response
     */
    /**
     * Display vertical solutions page
     *
     * @param string $slug
     * @return Response
     */
    public function solution($slug)
    {
        $solutions = $this->getSolutionsData();

        if (!array_key_exists($slug, $solutions)) {
            abort(404);
        }

        $solution = $solutions[$slug];
        $all_solutions = $solutions;

        $packages = Package::active()
            ->notPrivate()
            ->orderBy('sort_order')
            ->get();

        return view('superadmin::landing.solution', compact('solution', 'all_solutions', 'packages', 'slug'));
    }

    /**
     * Data catalog for Industry Vertical Solutions
     *
     * @return array
     */
    public static function getSolutionsData()
    {
        return [
            'restaurantes' => [
                'slug' => 'restaurantes',
                'name' => 'Restaurantes & Gastronomía',
                'short_desc' => 'Comandas, mesas, pantalla de cocina KDS y facturación rápida.',
                'badge' => 'Especial para Gastronomía',
                'icon' => 'fas fa-utensils',
                'color' => '#FB4C0A',
                'gradient' => 'linear-gradient(135deg, #FB4C0A 0%, #E03E00 100%)',
                'hero_title' => 'El Sistema POS que tu Restaurante Necesita para Volar',
                'hero_subtitle' => 'Optimiza tiempos en cocina, gestiona mesas con un toque, divide cuentas y cobra en multimoneda con el sistema diseñado para restaurantes, bares, cafeterías y dark kitchens.',
                'stats' => [
                    ['val' => '+40%', 'label' => 'Velocidad en toma de comandas'],
                    ['val' => '0%', 'label' => 'Errores entre salón y cocina'],
                    ['val' => '100%', 'label' => 'Control de stock e insumos'],
                ],
                'features' => [
                    [
                        'icon' => 'fas fa-tv',
                        'title' => 'Pantalla de Cocina (KDS) en Tiempo Real',
                        'desc' => 'Los pedidos tomados por los mesoneros van directamente a la pantalla de cocina o barra sin necesidad de papeles ni demoras.'
                    ],
                    [
                        'icon' => 'fas fa-chair',
                        'title' => 'Gestor Gráfico de Mesas & Zonas',
                        'desc' => 'Visualiza la disponibilidad de mesas (Libre, Ocupada, Por Cobrar), asigna mozos y cambia mesas en segundos.'
                    ],
                    [
                        'icon' => 'fas fa-receipt',
                        'title' => 'División de Cuentas & Propinas',
                        'desc' => 'Divide la cuenta entre comensales por ítems o partes iguales, calculando propinas sugeridas automáticamente.'
                    ],
                    [
                        'icon' => 'fas fa-sliders-h',
                        'title' => 'Modificadores & Términos de Cocina',
                        'desc' => 'Notas especiales para cada plato (ej. "Sin cebolla", "Término medio", "Extra queso") que se imprimen en cocina.'
                    ],
                    [
                        'icon' => 'fas fa-coins',
                        'title' => 'Pagos Mixtos y Multimoneda',
                        'desc' => 'Acepta Zelle, Pago Móvil, Efectivo USD/VES y Tarjetas en una misma transacción con cálculo de vuelto exacto.'
                    ],
                    [
                        'icon' => 'fas fa-cubes',
                        'title' => 'Recetas & Descuento de Insumos',
                        'desc' => 'Cada plato vendido descuenta automáticamente gramos de carne, queso o bebidas de tu inventario principal.'
                    ]
                ],
                'target_businesses' => ['Restaurantes', 'Bares y Discotecas', 'Cafeterías y Panaderías', 'Food Trucks', 'Pizzerías y Hamburgueserías', 'Dark Kitchens & Delivery']
            ],
            'retail' => [
                'slug' => 'retail',
                'name' => 'Comercio & Tiendas (Retail)',
                'short_desc' => 'Ventas rápidas con código de barras, tallas/colores y sincronización online.',
                'badge' => 'Especial para Retail & Tiendas',
                'icon' => 'fas fa-shopping-bag',
                'color' => '#6366F1',
                'gradient' => 'linear-gradient(135deg, #6366F1 0%, #4F46E5 100%)',
                'hero_title' => 'Ventas en Segundos y Control Total para tu Tienda Comercial',
                'hero_subtitle' => 'Facturación ultrarrápida con lector de código de barras, variantes de tallas y colores, alertas de stock mínimo y sincronización directa con tu tienda en línea.',
                'stats' => [
                    ['val' => '3s', 'label' => 'Tiempo promedio por venta'],
                    ['val' => '+35%', 'label' => 'Mayor rotación de inventario'],
                    ['val' => '100%', 'label' => 'Sincronizado con WooCommerce'],
                ],
                'features' => [
                    [
                        'icon' => 'fas fa-barcode',
                        'title' => 'Lector de Barras & Generador de Etiquetas',
                        'desc' => 'Escanea productos al instante e imprime etiquetas con códigos de barras personalizados para mercadería sin código.'
                    ],
                    [
                        'icon' => 'fas fa-tags',
                        'title' => 'Variantes de Talla, Color & Presentación',
                        'desc' => 'Organiza un producto en múltiples variantes sin duplicar registros, manteniendo existencias independientes por talla.'
                    ],
                    [
                        'icon' => 'fas fa-globe',
                        'title' => 'Sincronización con WooCommerce',
                        'desc' => 'Vende en tu tienda física y tu web al mismo tiempo: el inventario y los precios se actualizan en tiempo real.'
                    ],
                    [
                        'icon' => 'fas fa-cash-register',
                        'title' => 'Multi-cajas y Arqueos Ciegos',
                        'desc' => 'Control de turnos por cajero, cortes X y Z, con cierres ciegos para evitar descuadres o fugas de dinero.'
                    ],
                    [
                        'icon' => 'fas fa-bell',
                        'title' => 'Alertas de Stock Crítico y Caducidad',
                        'desc' => 'Recibe notificaciones automáticas cuando un producto esté por agotarse para emitir órdenes de compra a tiempo.'
                    ],
                    [
                        'icon' => 'fas fa-users',
                        'title' => 'Fidelización y Créditos a Clientes',
                        'desc' => 'Lleva el registro de clientes frecuentes, puntos de recompensa y límites de crédito con historial de pagos.'
                    ]
                ],
                'target_businesses' => ['Tiendas de Ropa & Calzado', 'Minimarkets y Bodegones', 'Farmacias y Droguerías', 'Tiendas de Electrónica & Celulares', 'Ferreterías & Repuestos', 'Cosméticos y Belleza']
            ],
            'mayoristas' => [
                'slug' => 'mayoristas',
                'name' => 'Mayoristas & Distribuidoras',
                'short_desc' => 'Multisucursal, cotizaciones, cuentas por cobrar y listas de precios.',
                'badge' => 'Especial para Mayoristas',
                'icon' => 'fas fa-boxes',
                'color' => '#10B981',
                'gradient' => 'linear-gradient(135deg, #10B981 0%, #059669 100%)',
                'hero_title' => 'Gestión Comercial y Logística de Alto Volumen para Mayoristas',
                'hero_subtitle' => 'Maneja múltiples almacenes, despachos masivos, cotizaciones membretadas, compras a crédito y seguimiento implacable de Cuentas por Cobrar.',
                'stats' => [
                    ['val' => '0%', 'label' => 'Cuentas por cobrar extraviadas'],
                    ['val' => '-50%', 'label' => 'Tiempo en emisión de cotizaciones'],
                    ['val' => '100%', 'label' => 'Trazabilidad de almacén y lotes'],
                ],
                'features' => [
                    [
                        'icon' => 'fas fa-warehouse',
                        'title' => 'Control Multialmacén y Transferencias',
                        'desc' => 'Gestiona stock en diferentes depósitos o sucursales, con transferencias y guías de despacho entre ubicaciones.'
                    ],
                    [
                        'icon' => 'fas fa-file-invoice-dollar',
                        'title' => 'Cuentas por Cobrar & Recordatorios',
                        'desc' => 'Reportes de cartera vencida por cliente, estados de cuenta en PDF y registro de abonos parciales por transacción.'
                    ],
                    [
                        'icon' => 'fas fa-layer-group',
                        'title' => 'Listas de Precios por Tipo de Cliente',
                        'desc' => 'Configura precios automáticos para Mayorista, Distribuidor, Detal o Especial, aplicados según el cliente.'
                    ],
                    [
                        'icon' => 'fas fa-file-signature',
                        'title' => 'Cotizaciones Convertibles en Venta',
                        'desc' => 'Emite cotizaciones profesionales en PDF con membrete y conviértelas en facturas de venta con un solo clic.'
                    ],
                    [
                        'icon' => 'fas fa-truck-loading',
                        'title' => 'Compras a Proveedores & Cuentas por Pagar',
                        'desc' => 'Control de compras a crédito, órdenes de requisición, pagos a plazos y seguimiento de gastos operativos.'
                    ],
                    [
                        'icon' => 'fas fa-user-tie',
                        'title' => 'Comisiones por Vendedor',
                        'desc' => 'Asigna agentes de venta y calcula comisiones automáticamente sobre el total facturado o cobrado.'
                    ]
                ],
                'target_businesses' => ['Distribuidoras de Alimentos y Bebidas', 'Importadoras y Comercializadoras', 'Depósitos Mayoristas', 'Empresas de Suministros Industriales', 'Materiales de Construcción', 'Proveedores de Servicios']
            ],
            'fabricas' => [
                'slug' => 'fabricas',
                'name' => 'Fábricas & Manufactura',
                'short_desc' => 'Órdenes de producción, recetas/fórmulas, materia prima y costeo.',
                'badge' => 'Especial para Fábricas & Producción',
                'icon' => 'fas fa-industry',
                'color' => '#EC4899',
                'gradient' => 'linear-gradient(135deg, #EC4899 0%, #DB2777 100%)',
                'hero_title' => 'Control Total de Producción, Recetas y Costos de Fabricación',
                'hero_subtitle' => 'Transforma materia prima en producto terminado, calcula costos exactos de mano de obra y producción, y controla mermas en cada lote fabricado.',
                'stats' => [
                    ['val' => '100%', 'label' => 'Costeo real por unidad fabricada'],
                    ['val' => '-25%', 'label' => 'Reducción en pérdidas de materia prima'],
                    ['val' => 'Auto', 'label' => 'Descuento de insumos por receta'],
                ],
                'features' => [
                    [
                        'icon' => 'fas fa-clipboard-list',
                        'title' => 'Fórmulas y Recetas de Producción',
                        'desc' => 'Define los insumos y cantidades exactas necesarias para fabricar un producto o lote terminado.'
                    ],
                    [
                        'icon' => 'fas fa-cogs',
                        'title' => 'Órdenes de Fabricación y Lotes',
                        'desc' => 'Genera órdenes de producción que descuentan automáticamente la materia prima y suman el stock del producto final.'
                    ],
                    [
                        'icon' => 'fas fa-calculator',
                        'title' => 'Costeo de Mano de Obra & Gastos Indirectos',
                        'desc' => 'Suma los costos de mano de obra, energía y empaque a la materia prima para obtener el costo unitario real.'
                    ],
                    [
                        'icon' => 'fas fa-trash-alt',
                        'title' => 'Control de Mermas y Desperdicios',
                        'desc' => 'Registra mermas ocurridas durante el proceso productivo para auditorías y ajustes de inventario precisos.'
                    ],
                    [
                        'icon' => 'fas fa-boxes',
                        'title' => 'Stock Diferenciado: Insumos vs Terminados',
                        'desc' => 'Mantén almacenes separados para materias primas, insumos de empaque y productos listos para la venta.'
                    ],
                    [
                        'icon' => 'fas fa-chart-pie',
                        'title' => 'Márgenes de Ganancia Reales',
                        'desc' => 'Conoce con certeza cuánto ganas por cada unidad producida y vendida frente a las variaciones de precio de insumos.'
                    ]
                ],
                'target_businesses' => ['Fábricas de Alimentos & Bebidas', 'Panificadoras & Pastelerías Industriales', 'Talleres de Confección & Textil', 'Fabricantes de Químicos & Limpieza', 'Carpinterías & Mobiliario', 'Microcervecerías & Embotelladoras']
            ],
            'belleza-spa' => [
                'slug' => 'belleza-spa',
                'name' => 'Salones, Estilistas & Barberías',
                'short_desc' => 'Módulo de citas, agenda por barbero/estilista, comisiones y POS.',
                'badge' => 'Especial para Belleza & Barberías',
                'icon' => 'fas fa-cut',
                'color' => '#F59E0B',
                'gradient' => 'linear-gradient(135deg, #F59E0B 0%, #D97706 100%)',
                'hero_title' => 'Agenda de Citas, Comisiones y Control para Salones y Barberías',
                'hero_subtitle' => 'Gestiona reservas de clientes, agenda independiente por estilista o barbero, cálculo automático de comisiones por servicio y venta de productos de estética.',
                'stats' => [
                    ['val' => '24/7', 'label' => 'Recepción de citas y reservas'],
                    ['val' => '100%', 'label' => 'Transparencia en comisiones del staff'],
                    ['val' => '+45%', 'label' => 'Ventas cruzadas de productos'],
                ],
                'features' => [
                    [
                        'icon' => 'fas fa-calendar-check',
                        'title' => 'Módulo de Citas & Reservas Interactivo',
                        'desc' => 'Agenda citas por cliente, hora y servicio, visualizando el calendario del día o semana en tiempo real.'
                    ],
                    [
                        'icon' => 'fas fa-user-friends',
                        'title' => 'Agenda & Turnos por Estilista / Barbero',
                        'desc' => 'Cada profesional tiene su propia agenda de atención para evitar solapamientos y esperas de clientes.'
                    ],
                    [
                        'icon' => 'fas fa-percentage',
                        'title' => 'Cálculo Automático de Comisiones',
                        'desc' => 'Configura porcentajes de comisión por servicio o producto para cada barbero/estilista sin cálculos manuales.'
                    ],
                    [
                        'icon' => 'fas fa-pump-soap',
                        'title' => 'Venta de Productos Capilares & Estética',
                        'desc' => 'Cobra servicios y productos (ceras, champús, cremas) en un solo ticket desde el Punto de Venta.'
                    ],
                    [
                        'icon' => 'fas fa-history',
                        'title' => 'Historial de Clientes y Preferencias',
                        'desc' => 'Guarda notas del corte favorito, color de tinte o tratamientos anteriores de cada cliente.'
                    ],
                    [
                        'icon' => 'fas fa-mobile-alt',
                        'title' => 'Acceso Móvil para el Personal',
                        'desc' => 'Los barberos y estilistas pueden consultar su agenda del día y sus comisiones acumuladas desde su teléfono.'
                    ]
                ],
                'target_businesses' => ['Barberías & Grooming Clubs', 'Salones de Belleza & Peluquerías', 'Spas & Centros de Estética', 'Estudios de Uñas & Pestañas', 'Clínicas de Cuidado Facial', 'Estudios de Tatuajes']
            ]
        ];
    }
}

