@php
    $is_logged_in = auth()->check();
    $user = $is_logged_in ? auth()->user() : null;
    $business_name = session('business.name', 'Kubre ERP');
    $user_name = $user ? $user->user_full_name : 'Usuario';
    $user_initials = $user ? strtoupper(substr($user->first_name ?? 'U', 0, 1) . substr($user->last_name ?? '', 0, 1)) : 'K';
    
    $is_admin = false;
    if ($is_logged_in && !empty($user)) {
        try {
            $is_admin = !empty($user->business_id) ? $user->hasRole('Admin#' . $user->business_id) : true;
        } catch (\Throwable $e) {
            $is_admin = false;
        }
    }
@endphp

@if ($is_logged_in)
    <!-- Kubre OS Launchpad / Command Center -->
    <div id="kubre-launchpad-overlay" class="no-print" role="dialog" aria-modal="true" aria-label="Centro de Comando Kubre OS">
        <div class="kubre-launchpad-modal">
            
            <!-- 1. Header con Buscador Universal -->
            <div class="kubre-launchpad-header">
                <div class="kubre-launchpad-logo">
                    <div class="kubre-app-tile tile-kubre-logo" style="width: 38px; height: 38px; border-radius: 10px;">
                        <img src="{{ asset('images/landing/icono.png') }}" alt="Kubre" style="width: 20px; height: 20px; object-fit: contain; filter: brightness(0) invert(1);" />
                    </div>
                </div>

                <div class="kubre-search-container">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" 
                           id="kubre-launchpad-search" 
                           class="kubre-search-input" 
                           placeholder="Buscar en Kubre OS... (módulos, facturas, clientes, reportes)" 
                           autocomplete="off">
                </div>

                <button type="button" class="kubre-header-btn kubre-open-customizer" title="Personalizar Dock de Aplicaciones">
                    <i class="fas fa-thumbtack"></i>
                </button>

                <button type="button" class="kubre-close-btn" id="kubre-launchpad-close" title="Cerrar (Esc)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- 2. Cuerpo del Launchpad -->
            <div class="kubre-launchpad-body">
                
                <!-- Acciones Rápidas ERP -->
                <div class="kubre-quick-actions-section">
                    <div class="kubre-section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg>
                        Acciones Rápidas
                    </div>
                    <div class="kubre-quick-actions-grid">
                        @can('sell.create')
                            <a href="{{ action([\App\Http\Controllers\SellController::class, 'create']) }}" class="kubre-quick-btn" data-keywords="nueva venta facturar factura emitir cobrar">
                                <div class="kubre-quick-icon" style="background: rgba(99, 102, 241, 0.2); color: #818CF8;">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <span>Nueva Venta</span>
                            </a>
                        @endcan

                        @can('purchase.create')
                            <a href="{{ action([\App\Http\Controllers\PurchaseController::class, 'create']) }}" class="kubre-quick-btn" data-keywords="nueva compra registrar proveedor gasto compra">
                                <div class="kubre-quick-icon" style="background: rgba(245, 158, 11, 0.2); color: #FBBF24;">
                                    <i class="fas fa-truck-loading"></i>
                                </div>
                                <span>Registrar Compra</span>
                            </a>
                        @endcan

                        @can('expense.access')
                            <a href="{{ action([\App\Http\Controllers\ExpenseController::class, 'create']) }}" class="kubre-quick-btn" data-keywords="nuevo gasto egreso pago comprobante">
                                <div class="kubre-quick-icon" style="background: rgba(239, 68, 68, 0.2); color: #F87171;">
                                    <i class="fas fa-arrow-down"></i>
                                </div>
                                <span>Nuevo Gasto</span>
                            </a>
                        @endcan

                        @can('customer.create')
                            <a href="{{ action([\App\Http\Controllers\ContactController::class, 'create']) }}?type=customer" class="kubre-quick-btn" data-keywords="nuevo cliente contacto proveedor crm">
                                <div class="kubre-quick-icon" style="background: rgba(14, 165, 233, 0.2); color: #38BDF8;">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <span>Nuevo Cliente</span>
                            </a>
                        @endcan

                        @can('product.create')
                            <a href="{{ action([\App\Http\Controllers\ProductController::class, 'create']) }}" class="kubre-quick-btn" data-keywords="nuevo producto item articulo crear inventario">
                                <div class="kubre-quick-icon" style="background: rgba(16, 185, 129, 0.2); color: #34D399;">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <span>Crear Producto</span>
                            </a>
                        @endcan

                        <a href="{{ action([\App\Http\Controllers\SellPosController::class, 'create']) }}" class="kubre-quick-btn" data-keywords="pos caja rapida cobro mostrador punto venta" target="_blank">
                            <div class="kubre-quick-icon" style="background: rgba(251, 76, 10, 0.2); color: #FB4C0A;">
                                <i class="fas fa-cash-register"></i>
                            </div>
                            <span>Caja Rápida (POS)</span>
                        </a>
                    </div>
                </div>

                <!-- Ecosistema de Módulos Kubre OS -->
                <div class="kubre-quick-actions-section">
                    <div class="kubre-section-title" style="justify-content: space-between;">
                        <span style="display: inline-flex; align-items: center; gap: 6px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                            Módulos del Sistema ERP
                        </span>
                        <button type="button" class="kubre-footer-link-btn kubre-open-customizer" style="font-size: 10px; padding: 2px 8px;">
                            <i class="fas fa-sliders-h"></i> Personalizar Dock
                        </button>
                    </div>
                    
                    <div class="kubre-apps-grid">
                        
                        <!-- Dashboard -->
                        <div class="kubre-app-card" data-app-id="dashboard" data-keywords="dashboard inicio panel metricas kpis finanzas">
                            <button type="button" class="kubre-app-pin-btn is-pinned" data-pin-toggle="dashboard" title="Fijar / Desanclar del Dock">
                                <i class="fas fa-thumbtack"></i>
                            </button>
                            <a href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}" style="display: flex; flex-direction: column; align-items: center; gap: 8px; text-decoration: none; width: 100%;">
                                <div class="kubre-app-tile tile-dashboard">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="7" height="9" rx="1.5"></rect>
                                        <rect x="14" y="3" width="7" height="5" rx="1.5"></rect>
                                        <rect x="14" y="12" width="7" height="9" rx="1.5"></rect>
                                        <rect x="3" y="16" width="7" height="5" rx="1.5"></rect>
                                    </svg>
                                </div>
                                <span class="kubre-app-label">Dashboard</span>
                            </a>
                        </div>

                        <!-- Ventas & Facturación -->
                        <div class="kubre-app-card" data-app-id="sales" data-keywords="ventas facturacion cotizaciones pedidos facturas notas entrega cobros">
                            <button type="button" class="kubre-app-pin-btn is-pinned" data-pin-toggle="sales" title="Fijar / Desanclar del Dock">
                                <i class="fas fa-thumbtack"></i>
                            </button>
                            <a href="{{ action([\App\Http\Controllers\SellController::class, 'index']) }}" style="display: flex; flex-direction: column; align-items: center; gap: 8px; text-decoration: none; width: 100%;">
                                <div class="kubre-app-tile tile-sales">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                    </svg>
                                </div>
                                <span class="kubre-app-label">Ventas & Facturas</span>
                            </a>
                        </div>

                        <!-- Inventario & Almacén -->
                        <div class="kubre-app-card" data-app-id="products" data-keywords="inventario stock productos almacenes catalogo lotes transferencias ajustes">
                            <button type="button" class="kubre-app-pin-btn is-pinned" data-pin-toggle="products" title="Fijar / Desanclar del Dock">
                                <i class="fas fa-thumbtack"></i>
                            </button>
                            <a href="{{ action([\App\Http\Controllers\ProductController::class, 'index']) }}" style="display: flex; flex-direction: column; align-items: center; gap: 8px; text-decoration: none; width: 100%;">
                                <div class="kubre-app-tile tile-products">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                </div>
                                <span class="kubre-app-label">Inventario & Stock</span>
                            </a>
                        </div>

                        <!-- Compras & Proveedores -->
                        <div class="kubre-app-card" data-app-id="purchases" data-keywords="compras proveedores ordenes compra recepcion facturas cuentas por pagar">
                            <button type="button" class="kubre-app-pin-btn is-pinned" data-pin-toggle="purchases" title="Fijar / Desanclar del Dock">
                                <i class="fas fa-thumbtack"></i>
                            </button>
                            <a href="{{ action([\App\Http\Controllers\PurchaseController::class, 'index']) }}" style="display: flex; flex-direction: column; align-items: center; gap: 8px; text-decoration: none; width: 100%;">
                                <div class="kubre-app-tile tile-purchases">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="1" y="3" width="15" height="13" rx="2"></rect>
                                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                    </svg>
                                </div>
                                <span class="kubre-app-label">Compras & Abasto</span>
                            </a>
                        </div>

                        <!-- Finanzas & Tesorería -->
                        <div class="kubre-app-card" data-app-id="finance" data-keywords="finanzas tesoreria cuentas bancarias bancos flujo caja bcv tasas cambio">
                            <button type="button" class="kubre-app-pin-btn is-pinned" data-pin-toggle="finance" title="Fijar / Desanclar del Dock">
                                <i class="fas fa-thumbtack"></i>
                            </button>
                            <a href="{{ action([\App\Http\Controllers\AccountController::class, 'index']) }}" style="display: flex; flex-direction: column; align-items: center; gap: 8px; text-decoration: none; width: 100%;">
                                <div class="kubre-app-tile tile-finance">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                        <line x1="2" y1="10" x2="22" y2="10"></line>
                                        <circle cx="6.5" cy="15" r="1.5"></circle>
                                    </svg>
                                </div>
                                <span class="kubre-app-label">Tesorería & Bancos</span>
                            </a>
                        </div>

                        <!-- Gastos & Egresos -->
                        <div class="kubre-app-card" data-app-id="expenses" data-keywords="gastos egresos costos categorias compras operativas">
                            <button type="button" class="kubre-app-pin-btn is-pinned" data-pin-toggle="expenses" title="Fijar / Desanclar del Dock">
                                <i class="fas fa-thumbtack"></i>
                            </button>
                            <a href="{{ action([\App\Http\Controllers\ExpenseController::class, 'index']) }}" style="display: flex; flex-direction: column; align-items: center; gap: 8px; text-decoration: none; width: 100%;">
                                <div class="kubre-app-tile tile-expenses">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="12" y1="1" x2="12" y2="23"></line>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                    </svg>
                                </div>
                                <span class="kubre-app-label">Gastos & Egresos</span>
                            </a>
                        </div>

                        <!-- Contactos & CRM -->
                        <div class="kubre-app-card" data-app-id="contacts" data-keywords="contactos clientes proveedores crm directorio seniat retenciones">
                            <button type="button" class="kubre-app-pin-btn is-pinned" data-pin-toggle="contacts" title="Fijar / Desanclar del Dock">
                                <i class="fas fa-thumbtack"></i>
                            </button>
                            <a href="{{ action([\App\Http\Controllers\ContactController::class, 'index'], ['type' => 'customer']) }}" style="display: flex; flex-direction: column; align-items: center; gap: 8px; text-decoration: none; width: 100%;">
                                <div class="kubre-app-tile tile-contacts">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <span class="kubre-app-label">Contactos & CRM</span>
                            </a>
                        </div>

                        <!-- Reportes & Analítica -->
                        <div class="kubre-app-card" data-app-id="reports" data-keywords="reportes analitica ganancias perdidas libros fiscales seniat inventario ventas">
                            <button type="button" class="kubre-app-pin-btn is-pinned" data-pin-toggle="reports" title="Fijar / Desanclar del Dock">
                                <i class="fas fa-thumbtack"></i>
                            </button>
                            <a href="{{ action([\App\Http\Controllers\ReportController::class, 'getProfitLoss']) }}" style="display: flex; flex-direction: column; align-items: center; gap: 8px; text-decoration: none; width: 100%;">
                                <div class="kubre-app-tile tile-reports">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="20" x2="18" y2="10"></line>
                                        <line x1="12" y1="20" x2="12" y2="4"></line>
                                        <line x1="6" y1="20" x2="6" y2="14"></line>
                                    </svg>
                                </div>
                                <span class="kubre-app-label">Reportes & Libros</span>
                            </a>
                        </div>

                        <!-- Consultorio Médico (Si está disponible) -->
                        @if (\Module::has('Consultorio') && \Module::isEnabled('Consultorio'))
                            <div class="kubre-app-card" data-app-id="consultorio" data-keywords="consultorio medico citas pacientes historias clinicas salud medicos">
                                <button type="button" class="kubre-app-pin-btn is-pinned" data-pin-toggle="consultorio" title="Fijar / Desanclar del Dock">
                                    <i class="fas fa-thumbtack"></i>
                                </button>
                                <a href="{{ route('consultorio.appointments.index') }}" style="display: flex; flex-direction: column; align-items: center; gap: 8px; text-decoration: none; width: 100%;">
                                    <div class="kubre-app-tile tile-consultorio">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                                        </svg>
                                    </div>
                                    <span class="kubre-app-label">Consultorio & Salud</span>
                                </a>
                            </div>
                        @endif

                        <!-- Manufactura / Producción (Si está disponible) -->
                        @if (\Module::has('Manufacturing') && \Module::isEnabled('Manufacturing'))
                            <div class="kubre-app-card" data-app-id="manufacturing" data-keywords="manufactura produccion recetas formulas fabrica ordenes produccion">
                                <button type="button" class="kubre-app-pin-btn is-pinned" data-pin-toggle="manufacturing" title="Fijar / Desanclar del Dock">
                                    <i class="fas fa-thumbtack"></i>
                                </button>
                                <a href="{{ route('manufacturing.production_orders.index') }}" style="display: flex; flex-direction: column; align-items: center; gap: 8px; text-decoration: none; width: 100%;">
                                    <div class="kubre-app-tile tile-manufacturing">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="3"></circle>
                                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                        </svg>
                                    </div>
                                    <span class="kubre-app-label">Manufactura</span>
                                </a>
                            </div>
                        @endif

                        <!-- Superadmin SaaS (Si es Superadmin) -->
                        @if ($is_admin && \Module::has('Superadmin'))
                            <div class="kubre-app-card" data-app-id="superadmin" data-keywords="superadmin saas suscripciones paquetes empresas inquilinos pagos">
                                <a href="{{ action([\Modules\Superadmin\Http\Controllers\SuperadminController::class, 'index']) }}" style="display: flex; flex-direction: column; align-items: center; gap: 8px; text-decoration: none; width: 100%;">
                                    <div class="kubre-app-tile tile-superadmin">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                        </svg>
                                    </div>
                                    <span class="kubre-app-label">Superadmin SaaS</span>
                                </a>
                            </div>
                        @endif

                        <!-- Configuración del Negocio -->
                        <div class="kubre-app-card" data-app-id="settings" data-keywords="configuracion ajustes negocio empresa sucursales roles usuarios impuestos seniat">
                            <button type="button" class="kubre-app-pin-btn is-pinned" data-pin-toggle="settings" title="Fijar / Desanclar del Dock">
                                <i class="fas fa-thumbtack"></i>
                            </button>
                            <a href="{{ action([\App\Http\Controllers\BusinessController::class, 'getBusinessSettings']) }}" style="display: flex; flex-direction: column; align-items: center; gap: 8px; text-decoration: none; width: 100%;">
                                <div class="kubre-app-tile tile-settings">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                    </svg>
                                </div>
                                <span class="kubre-app-label">Configuración</span>
                            </a>
                        </div>

                    </div>
                </div>

            </div>

            <!-- 3. Footer con Atajos y Perfil -->
            <div class="kubre-launchpad-footer">
                <div class="kubre-footer-shortcuts">
                    <span><kbd class="kubre-shortcut-badge">ESC</kbd> cerrar</span>
                    <span><kbd class="kubre-shortcut-badge">Ctrl+K</kbd> / <kbd class="kubre-shortcut-badge">Cmd+K</kbd> alternar</span>
                    <button type="button" class="kubre-footer-link-btn kubre-open-customizer">
                        <i class="fas fa-thumbtack"></i> Personalizar Dock
                    </button>
                </div>
                
                <div class="kubre-footer-user">
                    <div class="kubre-user-avatar-mini">{{ $user_initials }}</div>
                    <span>{{ $user_name }}</span>
                    <span style="opacity: 0.5;">•</span>
                    <span style="color: #FB4C0A; font-weight: 600;">{{ $business_name }}</span>
                </div>
            </div>

        </div>
    </div>
@endif
