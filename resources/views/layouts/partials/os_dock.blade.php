@php
    $is_logged_in = auth()->check();
    $user = $is_logged_in ? auth()->user() : null;
    $enabled_modules = !empty(session('business.enabled_modules')) ? session('business.enabled_modules') : [];
    
    $is_admin = false;
    if ($is_logged_in && !empty($user)) {
        try {
            $is_admin = !empty($user->business_id) ? $user->hasRole('Admin#' . $user->business_id) : true;
        } catch (\Throwable $e) {
            $is_admin = false;
        }
    }

    $is_home = request()->is('home*') || request()->segment(1) == 'home';
    $is_sales = (request()->is('sells*') && request()->get('sale_type') != 'sales_order') || request()->is('quotations*') || request()->is('drafts*');
    $is_products = request()->is('products*') || request()->is('inventory*') || request()->is('stock*') || request()->is('units*') || request()->is('categories*') || request()->is('brands*') || request()->is('warranties*');
    $is_purchases = request()->is('purchases*') || request()->is('purchase-order*') || request()->is('purchase-requisition*') || request()->is('purchase-return*');
    $is_finance = request()->is('account*') || request()->is('financial*') || request()->is('exchange-rates*');
    $is_expenses = request()->is('expenses*') || request()->is('expense-categories*');
    $is_contacts = request()->is('contacts*') || request()->is('customer-group*');
    $is_reports = request()->is('reports*');
    $is_settings = request()->is('business/settings*') || request()->is('business-location*') || request()->is('invoice-schemes*') || request()->is('invoice-layouts*') || request()->is('tax-rates*') || request()->is('roles*') || request()->is('users*');
    $is_pos = request()->segment(1) == 'pos';
    $is_consultorio = request()->is('consultorio*');
    $is_manufacturing = request()->is('manufacturing*');

    $can_access_sales = $is_admin || ($user && $user->hasAnyPermission(['sell.view', 'sell.create', 'direct_sell.access', 'direct_sell.view']));
    $can_access_products = $is_admin || ($user && $user->hasAnyPermission(['product.view', 'product.create']));
    $can_access_purchases = $is_admin || ($user && $user->hasAnyPermission(['purchase.view', 'purchase.create']));
    $can_access_finance = $is_admin || ($user && $user->hasAnyPermission(['account.access', 'view_cash_register']));
    $can_access_expenses = $is_admin || ($user && $user->hasAnyPermission(['all_expense.access', 'view_own_expense']));
    $can_access_contacts = $is_admin || ($user && $user->hasAnyPermission(['customer.view', 'supplier.view']));
    $can_access_reports = $is_admin || ($user && $user->hasAnyPermission(['profit_loss_report.view', 'purchase_n_sell_report.view']));
    $can_access_settings = $is_admin || ($user && $user->hasAnyPermission(['business_settings.access']));
    $can_access_pos = $is_admin || ($user && $user->hasAnyPermission(['sell.create', 'pos_sale.create']));
@endphp

@if ($is_logged_in && request()->segment(1) != 'customer-display')
    <!-- Kubre OS Floating Desktop Dock -->
    <div id="kubre-os-dock-container" class="no-print">
        <nav class="kubre-os-dock" aria-label="Kubre OS Dock">
            
            <!-- 1. Kubre Launcher Button -->
            <div class="kubre-dock-item kubre-open-launchpad" title="Kubre OS • Centro de Comando (Ctrl+K)">
                <div class="kubre-app-tile tile-kubre-logo">
                    <img src="{{ asset('images/landing/icono.png') }}" alt="Kubre" style="width: 22px; height: 22px; object-fit: contain; filter: brightness(0) invert(1);" />
                </div>
                <span class="kubre-dock-label">Kubre</span>
                <span class="active-dot"></span>
            </div>

            <div class="kubre-dock-divider"></div>

            <!-- 2. Dashboard Ejecutivo -->
            <a href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}" 
               class="kubre-dock-item {{ $is_home ? 'is-active' : '' }}" data-dock-app="dashboard">
                <div class="kubre-app-tile tile-dashboard">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="9" rx="1.5"></rect>
                        <rect x="14" y="3" width="7" height="5" rx="1.5"></rect>
                        <rect x="14" y="12" width="7" height="9" rx="1.5"></rect>
                        <rect x="3" y="16" width="7" height="5" rx="1.5"></rect>
                    </svg>
                </div>
                <span class="kubre-dock-label">Dashboard</span>
                <span class="active-dot"></span>
            </a>

            <!-- 3. Ventas & Facturación (con Sub-Dock Flotante) -->
            @if ($can_access_sales)
                <div class="kubre-dock-item {{ $is_sales ? 'is-active' : '' }} kubre-has-subdock" data-dock-app="sales">
                    <div class="kubre-app-tile tile-sales">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                    </div>
                    <span class="kubre-dock-label">Ventas</span>
                    <span class="active-dot"></span>

                    <!-- Sub-Dock Flotante de Ventas -->
                    <div class="kubre-subdock-deck">
                        <div class="kubre-subdock-header">
                            <span class="kubre-subdock-title">
                                <i class="fas fa-file-invoice-dollar" style="color: #818CF8;"></i> Ventas & Facturación
                            </span>
                            <div class="kubre-subdock-header-actions">
                                <button type="button" class="kubre-subdock-unpin-btn" data-unpin="sales" title="Desanclar del Dock">
                                    <i class="fas fa-thumbtack"></i> Desanclar
                                </button>
                                <a href="{{ action([\App\Http\Controllers\SellController::class, 'index']) }}" class="kubre-subdock-mainlink">Ver Todo &rarr;</a>
                            </div>
                        </div>
                        <a href="{{ action([\App\Http\Controllers\SellController::class, 'create']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-plus-circle"></i></span>
                            <span>Nueva Venta</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\SellController::class, 'index']) }}" class="kubre-subdock-link {{ request()->is('sells') && !request()->get('status') ? 'is-active-sub' : '' }}">
                            <span class="kubre-subdock-icon"><i class="fas fa-list"></i></span>
                            <span>Todas las Ventas</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\SellController::class, 'create']) }}?status=quotation" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-file-alt"></i></span>
                            <span>Nueva Cotización / Pedido</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\SellController::class, 'getQuotations']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-clipboard-list"></i></span>
                            <span>Lista de Pedidos</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\SellController::class, 'getDrafts']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-edit"></i></span>
                            <span>Borradores</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- 4. Inventario & Productos (con Sub-Dock Flotante) -->
            @if ($can_access_products)
                <div class="kubre-dock-item {{ $is_products ? 'is-active' : '' }} kubre-has-subdock" data-dock-app="products">
                    <div class="kubre-app-tile tile-products">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <span class="kubre-dock-label">Inventario</span>
                    <span class="active-dot"></span>

                    <!-- Sub-Dock Flotante de Inventario -->
                    <div class="kubre-subdock-deck">
                        <div class="kubre-subdock-header">
                            <span class="kubre-subdock-title">
                                <i class="fas fa-boxes" style="color: #34D399;"></i> Inventario & Stock
                            </span>
                            <div class="kubre-subdock-header-actions">
                                <button type="button" class="kubre-subdock-unpin-btn" data-unpin="products" title="Desanclar del Dock">
                                    <i class="fas fa-thumbtack"></i> Desanclar
                                </button>
                                <a href="{{ action([\App\Http\Controllers\ProductController::class, 'index']) }}" class="kubre-subdock-mainlink">Ver Todo &rarr;</a>
                            </div>
                        </div>
                        <a href="{{ action([\App\Http\Controllers\ProductController::class, 'index']) }}" class="kubre-subdock-link {{ request()->is('products') ? 'is-active-sub' : '' }}">
                            <span class="kubre-subdock-icon"><i class="fas fa-cubes"></i></span>
                            <span>Catálogo de Productos</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\ProductController::class, 'create']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-plus-circle"></i></span>
                            <span>Agregar Producto</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\StockAdjustmentController::class, 'index']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-sliders-h"></i></span>
                            <span>Ajustes de Inventario</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\StockTransferController::class, 'index']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-dolly"></i></span>
                            <span>Transferencias de Stock</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\TaxonomyController::class, 'index']) }}?type=product" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-tags"></i></span>
                            <span>Categorías & Marcas</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- 5. Compras & Abastecimiento (con Sub-Dock Flotante) -->
            @if ($can_access_purchases)
                <div class="kubre-dock-item {{ $is_purchases ? 'is-active' : '' }} kubre-has-subdock" data-dock-app="purchases">
                    <div class="kubre-app-tile tile-purchases">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="3" width="15" height="13" rx="2"></rect>
                            <polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon>
                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                        </svg>
                    </div>
                    <span class="kubre-dock-label">Compras</span>
                    <span class="active-dot"></span>

                    <!-- Sub-Dock Flotante de Compras -->
                    <div class="kubre-subdock-deck">
                        <div class="kubre-subdock-header">
                            <span class="kubre-subdock-title">
                                <i class="fas fa-truck-loading" style="color: #FBBF24;"></i> Compras & Abasto
                            </span>
                            <div class="kubre-subdock-header-actions">
                                <button type="button" class="kubre-subdock-unpin-btn" data-unpin="purchases" title="Desanclar del Dock">
                                    <i class="fas fa-thumbtack"></i> Desanclar
                                </button>
                                <a href="{{ action([\App\Http\Controllers\PurchaseController::class, 'index']) }}" class="kubre-subdock-mainlink">Ver Todo &rarr;</a>
                            </div>
                        </div>
                        <a href="{{ action([\App\Http\Controllers\PurchaseController::class, 'index']) }}" class="kubre-subdock-link {{ request()->is('purchases') ? 'is-active-sub' : '' }}">
                            <span class="kubre-subdock-icon"><i class="fas fa-list-alt"></i></span>
                            <span>Todas las Compras</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\PurchaseController::class, 'create']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-plus-circle"></i></span>
                            <span>Registrar Compra</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\PurchaseOrderController::class, 'index']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-file-invoice"></i></span>
                            <span>Órdenes de Compra</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\PurchaseReturnController::class, 'index']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-undo"></i></span>
                            <span>Devolución de Compras</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- 6. Finanzas & Tesorería (con Sub-Dock Flotante) -->
            @if ($can_access_finance)
                <div class="kubre-dock-item {{ $is_finance ? 'is-active' : '' }} kubre-has-subdock" data-dock-app="finance">
                    <div class="kubre-app-tile tile-finance">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                            <circle cx="6.5" cy="15" r="1.5"></circle>
                        </svg>
                    </div>
                    <span class="kubre-dock-label">Finanzas</span>
                    <span class="active-dot"></span>

                    <!-- Sub-Dock Flotante de Finanzas -->
                    <div class="kubre-subdock-deck">
                        <div class="kubre-subdock-header">
                            <span class="kubre-subdock-title">
                                <i class="fas fa-university" style="color: #34D399;"></i> Finanzas & Tesorería
                            </span>
                            <div class="kubre-subdock-header-actions">
                                <button type="button" class="kubre-subdock-unpin-btn" data-unpin="finance" title="Desanclar del Dock">
                                    <i class="fas fa-thumbtack"></i> Desanclar
                                </button>
                                <a href="{{ action([\App\Http\Controllers\AccountController::class, 'index']) }}" class="kubre-subdock-mainlink">Ver Todo &rarr;</a>
                            </div>
                        </div>
                        <a href="{{ action([\App\Http\Controllers\AccountController::class, 'index']) }}" class="kubre-subdock-link {{ request()->is('account/account') ? 'is-active-sub' : '' }}">
                            <span class="kubre-subdock-icon"><i class="fas fa-wallet"></i></span>
                            <span>Cuentas Bancarias & Caja</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\AccountController::class, 'cashFlow']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-exchange-alt"></i></span>
                            <span>Flujo de Caja</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\AccountReportsController::class, 'balanceSheet']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-balance-scale"></i></span>
                            <span>Balance General</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\AccountReportsController::class, 'trialBalance']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-book"></i></span>
                            <span>Balance de Comprobación</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- 7. Gastos & Egresos (con Sub-Dock Flotante) -->
            @if ($can_access_expenses)
                <div class="kubre-dock-item {{ $is_expenses ? 'is-active' : '' }} kubre-has-subdock" data-dock-app="expenses">
                    <div class="kubre-app-tile tile-expenses">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <span class="kubre-dock-label">Gastos</span>
                    <span class="active-dot"></span>

                    <!-- Sub-Dock Flotante de Gastos -->
                    <div class="kubre-subdock-deck">
                        <div class="kubre-subdock-header">
                            <span class="kubre-subdock-title">
                                <i class="fas fa-arrow-circle-down" style="color: #F87171;"></i> Gastos & Egresos
                            </span>
                            <div class="kubre-subdock-header-actions">
                                <button type="button" class="kubre-subdock-unpin-btn" data-unpin="expenses" title="Desanclar del Dock">
                                    <i class="fas fa-thumbtack"></i> Desanclar
                                </button>
                                <a href="{{ action([\App\Http\Controllers\ExpenseController::class, 'index']) }}" class="kubre-subdock-mainlink">Ver Todo &rarr;</a>
                            </div>
                        </div>
                        <a href="{{ action([\App\Http\Controllers\ExpenseController::class, 'index']) }}" class="kubre-subdock-link {{ request()->is('expenses') ? 'is-active-sub' : '' }}">
                            <span class="kubre-subdock-icon"><i class="fas fa-list"></i></span>
                            <span>Todos los Gastos</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\ExpenseController::class, 'create']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-plus-circle"></i></span>
                            <span>Registrar Gasto</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\ExpenseCategoryController::class, 'index']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-tags"></i></span>
                            <span>Categorías de Gastos</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- 8. Contactos & CRM (con Sub-Dock Flotante) -->
            @if ($can_access_contacts)
                <div class="kubre-dock-item {{ $is_contacts ? 'is-active' : '' }} kubre-has-subdock" data-dock-app="contacts">
                    <div class="kubre-app-tile tile-contacts">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <span class="kubre-dock-label">Contactos</span>
                    <span class="active-dot"></span>

                    <!-- Sub-Dock Flotante de Contactos -->
                    <div class="kubre-subdock-deck">
                        <div class="kubre-subdock-header">
                            <span class="kubre-subdock-title">
                                <i class="fas fa-users" style="color: #38BDF8;"></i> Contactos & CRM
                            </span>
                            <div class="kubre-subdock-header-actions">
                                <button type="button" class="kubre-subdock-unpin-btn" data-unpin="contacts" title="Desanclar del Dock">
                                    <i class="fas fa-thumbtack"></i> Desanclar
                                </button>
                                <a href="{{ action([\App\Http\Controllers\ContactController::class, 'index'], ['type' => 'customer']) }}" class="kubre-subdock-mainlink">Ver Todo &rarr;</a>
                            </div>
                        </div>
                        <a href="{{ action([\App\Http\Controllers\ContactController::class, 'index'], ['type' => 'customer']) }}" class="kubre-subdock-link {{ request()->get('type') == 'customer' ? 'is-active-sub' : '' }}">
                            <span class="kubre-subdock-icon"><i class="fas fa-user-friends"></i></span>
                            <span>Clientes</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\ContactController::class, 'index'], ['type' => 'supplier']) }}" class="kubre-subdock-link {{ request()->get('type') == 'supplier' ? 'is-active-sub' : '' }}">
                            <span class="kubre-subdock-icon"><i class="fas fa-store"></i></span>
                            <span>Proveedores</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\ContactController::class, 'create']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-user-plus"></i></span>
                            <span>Nuevo Contacto</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\CustomerGroupController::class, 'index']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-layer-group"></i></span>
                            <span>Grupos de Clientes</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- 9. Módulo Consultorio (Si está habilitado) -->
            @if (\Module::has('Consultorio') && \Module::isEnabled('Consultorio'))
                <div class="kubre-dock-item {{ $is_consultorio ? 'is-active' : '' }} kubre-has-subdock" data-dock-app="consultorio">
                    <div class="kubre-app-tile tile-consultorio">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                        </svg>
                    </div>
                    <span class="kubre-dock-label">Salud</span>
                    <span class="active-dot"></span>

                    <!-- Sub-Dock Consultorio -->
                    <div class="kubre-subdock-deck">
                        <div class="kubre-subdock-header">
                            <span class="kubre-subdock-title">
                                <i class="fas fa-stethoscope" style="color: #2DD4BF;"></i> Consultorio Médico
                            </span>
                            <div class="kubre-subdock-header-actions">
                                <button type="button" class="kubre-subdock-unpin-btn" data-unpin="consultorio" title="Desanclar del Dock">
                                    <i class="fas fa-thumbtack"></i> Desanclar
                                </button>
                                <a href="{{ route('consultorio.appointments.index') }}" class="kubre-subdock-mainlink">Ver Todo &rarr;</a>
                            </div>
                        </div>
                        <a href="{{ route('consultorio.appointments.index') }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-calendar-check"></i></span>
                            <span>Agenda de Citas</span>
                        </a>
                        <a href="{{ route('consultorio.appointments.create') }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-plus"></i></span>
                            <span>Nueva Cita</span>
                        </a>
                        <a href="{{ route('consultorio.waiting_room.index') }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-chair"></i></span>
                            <span>Sala de Espera</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- 10. Módulo Manufactura (Si está habilitado) -->
            @if (\Module::has('Manufacturing') && \Module::isEnabled('Manufacturing'))
                <div class="kubre-dock-item {{ $is_manufacturing ? 'is-active' : '' }} kubre-has-subdock" data-dock-app="manufacturing">
                    <div class="kubre-app-tile tile-manufacturing">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                    </div>
                    <span class="kubre-dock-label">Producción</span>
                    <span class="active-dot"></span>

                    <!-- Sub-Dock Manufactura -->
                    <div class="kubre-subdock-deck">
                        <div class="kubre-subdock-header">
                            <span class="kubre-subdock-title">
                                <i class="fas fa-industry" style="color: #94A3B8;"></i> Manufactura & Producción
                            </span>
                            <div class="kubre-subdock-header-actions">
                                <button type="button" class="kubre-subdock-unpin-btn" data-unpin="manufacturing" title="Desanclar del Dock">
                                    <i class="fas fa-thumbtack"></i> Desanclar
                                </button>
                                <a href="{{ route('manufacturing.production_orders.index') }}" class="kubre-subdock-mainlink">Ver Todo &rarr;</a>
                            </div>
                        </div>
                        <a href="{{ route('manufacturing.production_orders.index') }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-tasks"></i></span>
                            <span>Órdenes de Producción</span>
                        </a>
                        <a href="{{ route('manufacturing.recipes.index') }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-flask"></i></span>
                            <span>Recetas / Fórmulas</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- 11. Reportes & Auditoría (con Sub-Dock Flotante) -->
            @if ($can_access_reports)
                <div class="kubre-dock-item {{ $is_reports ? 'is-active' : '' }} kubre-has-subdock" data-dock-app="reports">
                    <div class="kubre-app-tile tile-reports">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="20" x2="18" y2="10"></line>
                            <line x1="12" y1="20" x2="12" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="14"></line>
                        </svg>
                    </div>
                    <span class="kubre-dock-label">Reportes</span>
                    <span class="active-dot"></span>

                    <!-- Sub-Dock Flotante de Reportes -->
                    <div class="kubre-subdock-deck">
                        <div class="kubre-subdock-header">
                            <span class="kubre-subdock-title">
                                <i class="fas fa-chart-line" style="color: #C084FC;"></i> Reportes & Analítica
                            </span>
                            <div class="kubre-subdock-header-actions">
                                <button type="button" class="kubre-subdock-unpin-btn" data-unpin="reports" title="Desanclar del Dock">
                                    <i class="fas fa-thumbtack"></i> Desanclar
                                </button>
                                <a href="{{ action([\App\Http\Controllers\ReportController::class, 'getProfitLoss']) }}" class="kubre-subdock-mainlink">Ver Todo &rarr;</a>
                            </div>
                        </div>
                        <a href="{{ action([\App\Http\Controllers\ReportController::class, 'getProfitLoss']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-dollar-sign"></i></span>
                            <span>Ganancias y Pérdidas</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\ReportController::class, 'getPurchaseSell']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-balance-scale-left"></i></span>
                            <span>Reporte Ventas & Compras</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\ReportController::class, 'getStockReport']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-warehouse"></i></span>
                            <span>Reporte de Inventario</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\ReportController::class, 'getCustomerSuppliers']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-money-check-alt"></i></span>
                            <span>Cuentas por Cobrar/Pagar</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\ReportController::class, 'getTaxReport']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-university"></i></span>
                            <span>Reporte Fiscal de Impuestos</span>
                        </a>
                    </div>
                </div>
            @endif

            <div class="kubre-dock-divider"></div>

            <!-- 12. Configuración ERP (con Sub-Dock Flotante) -->
            @if ($can_access_settings)
                <div class="kubre-dock-item {{ $is_settings ? 'is-active' : '' }} kubre-has-subdock" data-dock-app="settings">
                    <div class="kubre-app-tile tile-settings">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="4" y1="21" x2="4" y2="14"></line>
                            <line x1="4" y1="10" x2="4" y2="3"></line>
                            <line x1="12" y1="21" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12" y2="3"></line>
                            <line x1="20" y1="21" x2="20" y2="16"></line>
                            <line x1="20" y1="12" x2="20" y2="3"></line>
                            <line x1="1" y1="14" x2="7" y2="14"></line>
                            <line x1="9" y1="8" x2="15" y2="8"></line>
                            <line x1="17" y1="16" x2="23" y2="16"></line>
                        </svg>
                    </div>
                    <span class="kubre-dock-label">Ajustes</span>
                    <span class="active-dot"></span>

                    <!-- Sub-Dock Flotante de Ajustes -->
                    <div class="kubre-subdock-deck">
                        <div class="kubre-subdock-header">
                            <span class="kubre-subdock-title">
                                <i class="fas fa-cogs" style="color: #94A3B8;"></i> Configuración ERP
                            </span>
                            <div class="kubre-subdock-header-actions">
                                <button type="button" class="kubre-subdock-unpin-btn kubre-open-customizer" title="Personalizar Dock">
                                    <i class="fas fa-sliders-h"></i> Dock
                                </button>
                                <a href="{{ action([\App\Http\Controllers\BusinessController::class, 'getBusinessSettings']) }}" class="kubre-subdock-mainlink">Ver Todo &rarr;</a>
                            </div>
                        </div>
                        <a href="{{ action([\App\Http\Controllers\BusinessController::class, 'getBusinessSettings']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-building"></i></span>
                            <span>Ajustes de Empresa</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\BusinessLocationController::class, 'index']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-map-marker-alt"></i></span>
                            <span>Sucursales & Sedes</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\TaxRateController::class, 'index']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-receipt"></i></span>
                            <span>Impuestos & SENIAT</span>
                        </a>
                        <a href="{{ action([\App\Http\Controllers\ManageUserController::class, 'index']) }}" class="kubre-subdock-link">
                            <span class="kubre-subdock-icon"><i class="fas fa-user-shield"></i></span>
                            <span>Usuarios & Roles</span>
                        </a>
                        <a href="javascript:void(0);" class="kubre-subdock-link kubre-open-customizer" style="color: #FB4C0A; border-top: 1px dashed rgba(255,255,255,0.1); margin-top: 4px;">
                            <span class="kubre-subdock-icon" style="color: #FB4C0A;"><i class="fas fa-thumbtack"></i></span>
                            <span>Personalizar este Dock...</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- 13. Caja Rápida / Mostrador (POS) -->
            @if ($can_access_pos)
                <a href="{{ action([\App\Http\Controllers\SellPosController::class, 'create']) }}" 
                   class="kubre-dock-item {{ $is_pos ? 'is-active' : '' }}" target="_blank" title="Caja Rápida (Punto de Venta)" data-dock-app="pos">
                    <div class="kubre-app-tile tile-pos">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                    <span class="kubre-dock-label" style="color: #FB923C;">POS</span>
                    <span class="active-dot"></span>
                </a>
            @endif

        </nav>
    </div>

    <!-- Modal de Personalización de Dock (Kubre OS Dock Settings) -->
    <div id="kubre-dock-customizer-modal" class="no-print" role="dialog" aria-modal="true" aria-label="Personalizar Kubre Dock">
        <div class="kubre-customizer-card">
            
            <div class="kubre-customizer-header">
                <div>
                    <h3 class="kubre-customizer-title">
                        <i class="fas fa-thumbtack" style="color: #FB4C0A;"></i> Personalizar mi Dock
                    </h3>
                    <p class="kubre-customizer-subtitle">
                        Elige qué aplicaciones deseas mantener visibles en tu barra inferior.
                    </p>
                </div>
                <button type="button" class="kubre-close-btn" id="kubre-customizer-close" title="Cerrar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="kubre-customizer-body">
                
                <!-- Dashboard -->
                <div class="kubre-customizer-item" data-custom-item="dashboard">
                    <div class="kubre-customizer-item-info">
                        <div class="kubre-app-tile tile-dashboard" style="width: 36px; height: 36px; border-radius: 10px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <rect x="3" y="3" width="7" height="9" rx="1.5"></rect>
                                <rect x="14" y="3" width="7" height="5" rx="1.5"></rect>
                                <rect x="14" y="12" width="7" height="9" rx="1.5"></rect>
                                <rect x="3" y="16" width="7" height="5" rx="1.5"></rect>
                            </svg>
                        </div>
                        <div>
                            <div class="kubre-customizer-item-name">Dashboard Ejecutivo</div>
                            <div class="kubre-customizer-item-desc">Métricas, gráficos y resumen del negocio</div>
                        </div>
                    </div>
                    <label class="kubre-switch">
                        <input type="checkbox" class="kubre-dock-toggle" data-app="dashboard" checked>
                        <span class="kubre-switch-slider"></span>
                    </label>
                </div>

                <!-- Ventas -->
                @if ($can_access_sales)
                    <div class="kubre-customizer-item" data-custom-item="sales">
                        <div class="kubre-customizer-item-info">
                            <div class="kubre-app-tile tile-sales" style="width: 36px; height: 36px; border-radius: 10px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                            </div>
                            <div>
                                <div class="kubre-customizer-item-name">Ventas & Facturación</div>
                                <div class="kubre-customizer-item-desc">Cotizaciones, facturas, pedidos y cobros</div>
                            </div>
                        </div>
                        <label class="kubre-switch">
                            <input type="checkbox" class="kubre-dock-toggle" data-app="sales" checked>
                            <span class="kubre-switch-slider"></span>
                        </label>
                    </div>
                @endif

                <!-- Inventario -->
                @if ($can_access_products)
                    <div class="kubre-customizer-item" data-custom-item="products">
                        <div class="kubre-customizer-item-info">
                            <div class="kubre-app-tile tile-products" style="width: 36px; height: 36px; border-radius: 10px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="kubre-customizer-item-name">Inventario & Stock</div>
                                <div class="kubre-customizer-item-desc">Catálogo, lotes, traslados y ajustes</div>
                            </div>
                        </div>
                        <label class="kubre-switch">
                            <input type="checkbox" class="kubre-dock-toggle" data-app="products" checked>
                            <span class="kubre-switch-slider"></span>
                        </label>
                    </div>
                @endif

                <!-- Compras -->
                @if ($can_access_purchases)
                    <div class="kubre-customizer-item" data-custom-item="purchases">
                        <div class="kubre-customizer-item-info">
                            <div class="kubre-app-tile tile-purchases" style="width: 36px; height: 36px; border-radius: 10px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                    <rect x="1" y="3" width="15" height="13" rx="2"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                </svg>
                            </div>
                            <div>
                                <div class="kubre-customizer-item-name">Compras & Abastecimiento</div>
                                <div class="kubre-customizer-item-desc">Recepción, órdenes y proveedores</div>
                            </div>
                        </div>
                        <label class="kubre-switch">
                            <input type="checkbox" class="kubre-dock-toggle" data-app="purchases" checked>
                            <span class="kubre-switch-slider"></span>
                        </label>
                    </div>
                @endif

                <!-- Finanzas -->
                @if ($can_access_finance)
                    <div class="kubre-customizer-item" data-custom-item="finance">
                        <div class="kubre-customizer-item-info">
                            <div class="kubre-app-tile tile-finance" style="width: 36px; height: 36px; border-radius: 10px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                    <line x1="2" y1="10" x2="22" y2="10"></line>
                                </svg>
                            </div>
                            <div>
                                <div class="kubre-customizer-item-name">Finanzas & Tesorería</div>
                                <div class="kubre-customizer-item-desc">Bancos, tasas bimoneda y flujo de caja</div>
                            </div>
                        </div>
                        <label class="kubre-switch">
                            <input type="checkbox" class="kubre-dock-toggle" data-app="finance" checked>
                            <span class="kubre-switch-slider"></span>
                        </label>
                    </div>
                @endif

                <!-- Gastos -->
                @if ($can_access_expenses)
                    <div class="kubre-customizer-item" data-custom-item="expenses">
                        <div class="kubre-customizer-item-info">
                            <div class="kubre-app-tile tile-expenses" style="width: 36px; height: 36px; border-radius: 10px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="kubre-customizer-item-name">Gastos & Egresos</div>
                                <div class="kubre-customizer-item-desc">Control de egresos y centros de costo</div>
                            </div>
                        </div>
                        <label class="kubre-switch">
                            <input type="checkbox" class="kubre-dock-toggle" data-app="expenses" checked>
                            <span class="kubre-switch-slider"></span>
                        </label>
                    </div>
                @endif

                <!-- Contactos -->
                @if ($can_access_contacts)
                    <div class="kubre-customizer-item" data-custom-item="contacts">
                        <div class="kubre-customizer-item-info">
                            <div class="kubre-app-tile tile-contacts" style="width: 36px; height: 36px; border-radius: 10px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div>
                                <div class="kubre-customizer-item-name">Contactos & CRM</div>
                                <div class="kubre-customizer-item-desc">Directorio de clientes y proveedores</div>
                            </div>
                        </div>
                        <label class="kubre-switch">
                            <input type="checkbox" class="kubre-dock-toggle" data-app="contacts" checked>
                            <span class="kubre-switch-slider"></span>
                        </label>
                    </div>
                @endif

                <!-- Consultorio -->
                @if (\Module::has('Consultorio') && \Module::isEnabled('Consultorio'))
                    <div class="kubre-customizer-item" data-custom-item="consultorio">
                        <div class="kubre-customizer-item-info">
                            <div class="kubre-app-tile tile-consultorio" style="width: 36px; height: 36px; border-radius: 10px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="kubre-customizer-item-name">Salud & Consultorio</div>
                                <div class="kubre-customizer-item-desc">Agenda médica, citas e historias clínicas</div>
                            </div>
                        </div>
                        <label class="kubre-switch">
                            <input type="checkbox" class="kubre-dock-toggle" data-app="consultorio" checked>
                            <span class="kubre-switch-slider"></span>
                        </label>
                    </div>
                @endif

                <!-- Manufactura -->
                @if (\Module::has('Manufacturing') && \Module::isEnabled('Manufacturing'))
                    <div class="kubre-customizer-item" data-custom-item="manufacturing">
                        <div class="kubre-customizer-item-info">
                            <div class="kubre-app-tile tile-manufacturing" style="width: 36px; height: 36px; border-radius: 10px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </div>
                            <div>
                                <div class="kubre-customizer-item-name">Manufactura & Producción</div>
                                <div class="kubre-customizer-item-desc">Órdenes de producción y recetas</div>
                            </div>
                        </div>
                        <label class="kubre-switch">
                            <input type="checkbox" class="kubre-dock-toggle" data-app="manufacturing" checked>
                            <span class="kubre-switch-slider"></span>
                        </label>
                    </div>
                @endif

                <!-- Reportes -->
                @if ($can_access_reports)
                    <div class="kubre-customizer-item" data-custom-item="reports">
                        <div class="kubre-customizer-item-info">
                            <div class="kubre-app-tile tile-reports" style="width: 36px; height: 36px; border-radius: 10px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                    <line x1="18" y1="20" x2="18" y2="10"></line>
                                    <line x1="12" y1="20" x2="12" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="14"></line>
                                </svg>
                            </div>
                            <div>
                                <div class="kubre-customizer-item-name">Reportes & Analítica</div>
                                <div class="kubre-customizer-item-desc">Balances, libros fiscales y ventas</div>
                            </div>
                        </div>
                        <label class="kubre-switch">
                            <input type="checkbox" class="kubre-dock-toggle" data-app="reports" checked>
                            <span class="kubre-switch-slider"></span>
                        </label>
                    </div>
                @endif

                <!-- Configuración -->
                @if ($can_access_settings)
                    <div class="kubre-customizer-item" data-custom-item="settings">
                        <div class="kubre-customizer-item-info">
                            <div class="kubre-app-tile tile-settings" style="width: 36px; height: 36px; border-radius: 10px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                    <line x1="4" y1="21" x2="4" y2="14"></line>
                                    <line x1="4" y1="10" x2="4" y2="3"></line>
                                </svg>
                            </div>
                            <div>
                                <div class="kubre-customizer-item-name">Configuración ERP</div>
                                <div class="kubre-customizer-item-desc">Ajustes, sucursales y permisos</div>
                            </div>
                        </div>
                        <label class="kubre-switch">
                            <input type="checkbox" class="kubre-dock-toggle" data-app="settings" checked>
                            <span class="kubre-switch-slider"></span>
                        </label>
                    </div>
                @endif

                <!-- POS -->
                @if ($can_access_pos)
                    <div class="kubre-customizer-item" data-custom-item="pos">
                        <div class="kubre-customizer-item-info">
                            <div class="kubre-app-tile tile-pos" style="width: 36px; height: 36px; border-radius: 10px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                    <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                                    <line x1="8" y1="21" x2="16" y2="21"></line>
                                </svg>
                            </div>
                            <div>
                                <div class="kubre-customizer-item-name">Caja Rápida (POS)</div>
                                <div class="kubre-customizer-item-desc">Terminal de venta de mostrador</div>
                            </div>
                        </div>
                        <label class="kubre-switch">
                            <input type="checkbox" class="kubre-dock-toggle" data-app="pos" checked>
                            <span class="kubre-switch-slider"></span>
                        </label>
                    </div>
                @endif

            </div>

            <div class="kubre-customizer-footer">
                <button type="button" class="kubre-btn-reset-dock" id="kubre-reset-dock-btn">
                    <i class="fas fa-undo"></i> Restablecer Todo
                </button>
                <button type="button" class="kubre-btn-done-dock" id="kubre-done-dock-btn">
                    Listo
                </button>
            </div>

        </div>
    </div>
@endif
