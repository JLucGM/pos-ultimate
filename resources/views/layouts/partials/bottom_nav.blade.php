@php
    $is_logged_in = auth()->check();
    $user = $is_logged_in ? auth()->user() : null;
    $is_admin = false;
    if ($is_logged_in && !empty($user)) {
        try {
            $is_admin = !empty($user->business_id) ? $user->hasRole('Admin#' . $user->business_id) : true;
        } catch (\Throwable $e) {
            $is_admin = false;
        }
    }

    $is_pos_page = request()->segment(1) == 'pos';
    $is_home_page = request()->is('home*');
    $is_sales_order_create = request()->is('sells/create*') && request()->get('sale_type') == 'sales_order';
    $is_sales_order_page = request()->is('sales-order*') || (request()->is('sells*') && request()->get('sale_type') == 'sales_order');
    $is_sells_page = request()->is('sells*') && request()->get('sale_type') != 'sales_order';
    $is_products_page = request()->is('products*');

    $can_create_so = $is_logged_in && ($is_admin || ($user && ($user->can('so.create') || $user->can('sell.create') || $user->can('direct_sell.access'))));
    $can_view_so = $is_logged_in && ($is_admin || ($user && ($user->can('so.view_own') || $user->can('so.view_all'))));
    $can_view_sells = $is_logged_in && ($is_admin || ($user && ($user->can('direct_sell.view') || $user->can('view_own_sell_only') || $user->can('sell.view'))));
@endphp

@if ($is_logged_in && !$is_pos_page && request()->segment(1) != 'customer-display')
    <!-- Kubre Mobile Bottom Navigation Bar -->
    <nav class="audaz-bottom-nav no-print" aria-label="Navegación Móvil">
        <!-- 1. Inicio -->
        <a href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}" 
           class="audaz-bottom-nav-item {{ $is_home_page ? 'active' : '' }}">
            <div class="nav-icon-wrapper">
                <i class="fas fa-home"></i>
            </div>
            <span class="nav-label">Inicio</span>
        </a>

        <!-- 2. Pedidos / Ventas -->
        @if ($can_view_so)
            <a href="{{ action([\App\Http\Controllers\SalesOrderController::class, 'index']) }}" 
               class="audaz-bottom-nav-item {{ $is_sales_order_page ? 'active' : '' }}">
                <div class="nav-icon-wrapper">
                    <i class="fas fa-receipt"></i>
                </div>
                <span class="nav-label">Pedidos</span>
            </a>
        @elseif ($can_view_sells)
            <a href="{{ action([\App\Http\Controllers\SellController::class, 'index']) }}" 
               class="audaz-bottom-nav-item {{ $is_sells_page ? 'active' : '' }}">
                <div class="nav-icon-wrapper">
                    <i class="fas fa-receipt"></i>
                </div>
                <span class="nav-label">Ventas</span>
            </a>
        @else
            <a href="{{ action([\App\Http\Controllers\HomeController::class, 'index']) }}" 
               class="audaz-bottom-nav-item">
                <div class="nav-icon-wrapper">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <span class="nav-label">Panel</span>
            </a>
        @endif

        <!-- 3. Botón Central Elevado: Pedido -->
        @if ($can_create_so)
            <a href="{{ action([\App\Http\Controllers\SellController::class, 'create']) }}?sale_type=sales_order" 
               class="audaz-bottom-nav-item audaz-nav-fab-item {{ $is_sales_order_create ? 'active' : '' }}" 
               title="Cargar Pedido">
                <div class="audaz-nav-fab">
                    <i class="fas fa-cart-plus"></i>
                </div>
                <span class="nav-label">Pedido</span>
            </a>
        @elseif (auth()->user()->can('sell.create'))
            <a href="{{ action([\App\Http\Controllers\SellPosController::class, 'create']) }}" 
               class="audaz-bottom-nav-item audaz-nav-fab-item" 
               title="Abrir Punto de Venta">
                <div class="audaz-nav-fab">
                    <i class="fas fa-cash-register"></i>
                </div>
                <span class="nav-label">POS</span>
            </a>
        @endif

        <!-- 4. Inventario / Productos -->
        @can('product.view')
            <a href="{{ action([\App\Http\Controllers\ProductController::class, 'index']) }}" 
               class="audaz-bottom-nav-item {{ $is_products_page ? 'active' : '' }}">
                <div class="nav-icon-wrapper">
                    <i class="fas fa-boxes"></i>
                </div>
                <span class="nav-label">Inventario</span>
            </a>
        @else
            <a href="{{ action([\App\Http\Controllers\PurchaseController::class, 'index']) }}" 
               class="audaz-bottom-nav-item {{ request()->is('purchases*') ? 'active' : '' }}">
                <div class="nav-icon-wrapper">
                    <i class="fas fa-shopping-basket"></i>
                </div>
                <span class="nav-label">Compras</span>
            </a>
        @endcan

        <!-- 5. Menú Lateral Toggle -->
        <a href="javascript:void(0);" 
           class="audaz-bottom-nav-item small-view-button" 
           id="audazBottomMenuToggle" 
           data-toggle="push-menu" 
           role="button" 
           title="Abrir Menú">
            <div class="nav-icon-wrapper">
                <i class="fas fa-bars"></i>
            </div>
            <span class="nav-label">Menú</span>
        </a>
    </nav>
@endif
