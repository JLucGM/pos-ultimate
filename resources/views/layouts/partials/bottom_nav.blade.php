@php
    $is_pos_page = request()->segment(1) == 'pos';
    $is_home_page = request()->is('home*');
    $is_sells_page = request()->is('sells*');
    $is_products_page = request()->is('products*');
@endphp

@if (!$is_pos_page && request()->segment(1) != 'customer-display')
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

        <!-- 2. Ventas -->
        @if (auth()->user()->can('direct_sell.view') || auth()->user()->can('view_own_sell_only'))
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

        <!-- 3. POS FAB Central (Elevado) -->
        @can('sell.create')
            <a href="{{ action([\App\Http\Controllers\SellPosController::class, 'create']) }}" 
               class="audaz-bottom-nav-item audaz-nav-fab-item" 
               title="Abrir Punto de Venta">
                <div class="audaz-nav-fab">
                    <i class="fas fa-cash-register"></i>
                </div>
                <span class="nav-label">POS</span>
            </a>
        @endcan

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
