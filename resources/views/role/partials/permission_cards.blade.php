@php
    $enabled_modules = !empty(session('business.enabled_modules')) ? session('business.enabled_modules') : [];
    $pos_settings = !empty(session('business.pos_settings')) ? json_decode(session('business.pos_settings'), true) : [];
    $role_permissions = !empty($role_permissions) ? $role_permissions : [];
@endphp

<style>
/* Estilos modernos para el panel de Permisos y Roles */
.role-permissions-wrapper {
    margin-top: 10px;
    font-family: inherit;
}

/* Barra de Control y Búsqueda */
.role-control-toolbar {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 24px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
}

.role-search-input-box {
    position: relative;
    width: 100%;
}

.role-search-input-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    font-size: 16px;
}

.role-search-input {
    width: 100%;
    padding: 10px 16px 10px 42px;
    font-size: 14px;
    border: 1.5px solid #CBD5E1;
    border-radius: 8px;
    transition: all 0.2s ease;
    background: #F8FAFC;
}

.role-search-input:focus {
    background: #FFFFFF;
    border-color: #3B82F6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    outline: none;
}

/* Barra de progreso global */
.role-progress-box {
    margin-top: 14px;
}

.role-progress-bar-bg {
    height: 8px;
    background: #E2E8F0;
    border-radius: 999px;
    overflow: hidden;
}

.role-progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #3B82F6, #10B981);
    border-radius: 999px;
    width: 0%;
    transition: width 0.3s ease;
}

/* Tarjeta de Módulo */
.permission-module-card {
    background: #FFFFFF;
    border: 1.5px solid #E2E8F0;
    border-radius: 12px;
    margin-bottom: 20px;
    overflow: hidden;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}

.permission-module-card:hover {
    border-color: #CBD5E1;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
}

.permission-module-header {
    background: #F8FAFC;
    border-bottom: 1px solid #E2E8F0;
    padding: 14px 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    cursor: pointer;
    user-select: none;
}

.permission-module-title-group {
    display: flex;
    align-items: center;
    gap: 12px;
}

.permission-module-icon {
    width: 36px;
    height: 36px;
    background: #EFF6FF;
    color: #2563EB;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 700;
}

.permission-module-name {
    font-size: 15px;
    font-weight: 800;
    color: #0F172A;
    margin: 0;
}

.permission-module-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.permission-module-badge {
    background: #E2E8F0;
    color: #334155;
    font-size: 12px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 999px;
    transition: all 0.2s ease;
}

.permission-module-badge.active {
    background: #DCFCE7;
    color: #166534;
}

.permission-module-body {
    padding: 18px;
}

/* Grid de Permisos */
.permission-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
    gap: 12px;
}

/* Tarjeta individual de permiso */
.permission-item-card {
    border: 1.5px solid #E2E8F0;
    background: #FFFFFF;
    border-radius: 8px;
    padding: 10px 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    transition: all 0.15s ease;
    position: relative;
    user-select: none;
}

.permission-item-card:hover {
    border-color: #93C5FD;
    background: #F8FAFC;
    transform: translateY(-1px);
}

.permission-item-card.is-checked {
    background: #F0FDF4;
    border-color: #10B981;
    box-shadow: 0 1px 2px rgba(16, 185, 129, 0.1);
}

.permission-item-card.is-checked .permission-custom-checkbox {
    background: #10B981;
    border-color: #10B981;
    color: #FFFFFF;
}

.permission-item-card.is-checked .permission-custom-checkbox i {
    opacity: 1;
    transform: scale(1);
}

/* Checkbox visual personalizado */
.permission-custom-checkbox {
    width: 22px;
    height: 22px;
    min-width: 22px;
    border: 2px solid #CBD5E1;
    border-radius: 6px;
    background: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    color: transparent;
    font-size: 12px;
    transition: all 0.15s ease;
}

.permission-custom-checkbox i {
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.15s ease;
}

.permission-item-label {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    line-height: 1.35;
    margin: 0;
    flex-grow: 1;
}

.permission-item-card.is-checked .permission-item-label {
    color: #065F46;
    font-weight: 700;
}

/* Input nativo oculto visualmente pero accesible para el formulario */
.permission-item-card input[type="checkbox"],
.permission-item-card input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
    margin: 0;
}

/* Sticky Bottom Action Bar */
.role-sticky-bottom-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(15, 23, 42, 0.95);
    backdrop-filter: blur(8px);
    color: #FFFFFF;
    padding: 12px 24px;
    box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.15);
    z-index: 1040;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

@media (max-width: 768px) {
    .permission-grid {
        grid-template-columns: 1fr;
    }
    .role-sticky-bottom-bar {
        position: static;
        margin-top: 20px;
        border-radius: 8px;
    }
}
</style>

<div class="role-permissions-wrapper">
    <!-- BARRA DE CONTROL SUPERIOR -->
    <div class="role-control-toolbar">
        <div class="row" style="align-items: center;">
            <div class="col-md-6 col-sm-12" style="margin-bottom: 10px;">
                <div class="role-search-input-box">
                    <i class="fa fa-search"></i>
                    <input type="text" id="permission_search_input" class="role-search-input" placeholder="Buscar permiso (ej: ventas, compras, precio, caja, descuento, reportes...)" autocomplete="off">
                </div>
            </div>
            <div class="col-md-6 col-sm-12 text-right" style="display: flex; gap: 8px; justify-content: flex-end; flex-wrap: wrap;">
                <button type="button" class="btn btn-sm btn-success" id="btn_select_all_global" style="font-weight: 700; border-radius: 6px;">
                    <i class="fa fa-check-double"></i> Marcar Todos
                </button>
                <button type="button" class="btn btn-sm btn-default" id="btn_deselect_all_global" style="font-weight: 700; border-radius: 6px; background: #F1F5F9; border-color: #CBD5E1;">
                    <i class="fa fa-times"></i> Desmarcar Todos
                </button>
                <button type="button" class="btn btn-sm btn-default" id="btn_toggle_expand_all" style="font-weight: 700; border-radius: 6px; background: #F1F5F9; border-color: #CBD5E1;">
                    <i class="fa fa-compress-arrows-alt"></i> Colapsar / Expandir
                </button>
            </div>
        </div>

        <!-- Barra de progreso de permisos -->
        <div class="role-progress-box">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <span style="font-size: 12px; font-weight: 700; color: #475569;">
                    <i class="fa fa-shield-alt text-primary"></i> Permisos Asignados al Rol:
                </span>
                <span id="global_selected_count_badge" style="font-size: 13px; font-weight: 800; color: #0F172A;">
                    0 de 0 (0%)
                </span>
            </div>
            <div class="role-progress-bar-bg">
                <div class="role-progress-bar-fill" id="global_selected_progress_bar"></div>
            </div>
        </div>
    </div>

    <!-- LISTADO DE MÓDULOS Y PERMISOS -->
    <div id="permissions_cards_container">

        {{-- 1. OTROS / GENERAL --}}
        <div class="permission-module-card" data-module="otros general service staff export">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-cube"></i></div>
                    <h4 class="permission-module-name">@lang('lang_v1.others')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @if(in_array('service_staff', $enabled_modules))
                        <label class="permission-item-card {{ (!empty($role->is_service_staff) && $role->is_service_staff == 1) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="is_service_staff" value="1" {{ (!empty($role->is_service_staff) && $role->is_service_staff == 1) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __('restaurant.service_staff') }} @show_tooltip(__('restaurant.tooltip_service_staff'))</span>
                        </label>
                    @endif

                    <label class="permission-item-card {{ in_array('view_export_buttons', $role_permissions) ? 'is-checked' : '' }}">
                        <input type="checkbox" name="permissions[]" value="view_export_buttons" {{ in_array('view_export_buttons', $role_permissions) ? 'checked' : '' }}>
                        <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_export_buttons') }}</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- 2. USUARIOS --}}
        <div class="permission-module-card" data-module="usuarios users user crear editar ver eliminar">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-users"></i></div>
                    <h4 class="permission-module-name">@lang('role.user')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach(['user.view' => 'role.user.view', 'user.create' => 'role.user.create', 'user.update' => 'role.user.update', 'user.delete' => 'role.user.delete'] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 3. ROLES --}}
        <div class="permission-module-card" data-module="roles permisos role crear editar ver eliminar">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-user-shield"></i></div>
                    <h4 class="permission-module-name">@lang('user.roles')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach(['roles.view' => 'role.roles.view', 'roles.create' => 'role.roles.create', 'roles.update' => 'role.roles.update', 'roles.delete' => 'role.roles.delete'] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 4. PROVEEDORES --}}
        <div class="permission-module-card" data-module="proveedores suppliers supplier compras">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-truck"></i></div>
                    <h4 class="permission-module-name">@lang('role.supplier')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach(['supplier.view' => 'role.supplier.view', 'supplier.view_own' => 'lang_v1.view_own_supplier', 'supplier.create' => 'role.supplier.create', 'supplier.update' => 'role.supplier.update', 'supplier.delete' => 'role.supplier.delete'] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 5. CLIENTES --}}
        <div class="permission-module-card" data-module="clientes customers customer contactos ventas">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-address-book"></i></div>
                    <h4 class="permission-module-name">@lang('role.customer')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach(['customer.view' => 'role.customer.view', 'customer.view_own' => 'lang_v1.view_own_customer', 'customer.create' => 'role.customer.create', 'customer.update' => 'role.customer.update', 'customer.delete' => 'role.customer.delete'] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 6. PRODUCTOS E INVENTARIO --}}
        <div class="permission-module-card" data-module="productos inventario stock precios compras product items">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-boxes"></i></div>
                    <h4 class="permission-module-name">@lang('business.product')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach([
                        'product.view' => 'role.product.view',
                        'product.create' => 'role.product.create',
                        'product.update' => 'role.product.update',
                        'product.delete' => 'role.product.delete',
                        'product.opening_stock' => 'lang_v1.add_opening_stock',
                        'view_purchase_price' => 'lang_v1.view_purchase_price'
                    ] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 7. COMPRAS --}}
        @if(in_array('purchases', $enabled_modules))
        <div class="permission-module-card" data-module="compras purchase pagos facturas gastos">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-shopping-basket"></i></div>
                    <h4 class="permission-module-name">@lang('role.purchase')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach([
                        'purchase.view' => 'role.purchase.view',
                        'view_own_purchase' => 'lang_v1.view_own_purchase',
                        'purchase.create' => 'role.purchase.create',
                        'purchase.update' => 'role.purchase.update',
                        'purchase.delete' => 'role.purchase.delete',
                        'purchase.payments' => 'lang_v1.add_edit_payment',
                        'purchase.update_status' => 'lang_v1.update_status'
                    ] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- 8. REQUISICIONES DE COMPRA --}}
        @if(in_array('purchase_requisition', $enabled_modules))
        <div class="permission-module-card" data-module="requisiciones compras purchase requisition">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-clipboard-list"></i></div>
                    <h4 class="permission-module-name">@lang('lang_v1.purchase_requisition')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach([
                        'purchase_requisition.view_all' => 'lang_v1.view_all_purchase_requisition',
                        'purchase_requisition.view_own' => 'lang_v1.view_own_purchase_requisition',
                        'purchase_requisition.create' => 'lang_v1.create_purchase_requisition',
                        'purchase_requisition.delete' => 'lang_v1.delete_purchase_requisition'
                    ] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- 9. ÓRDENES DE COMPRA --}}
        @if(in_array('purchase_order', $enabled_modules))
        <div class="permission-module-card" data-module="ordenes compra purchase order">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-file-invoice"></i></div>
                    <h4 class="permission-module-name">@lang('lang_v1.purchase_order')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach([
                        'purchase_order.view_all' => 'lang_v1.view_all_purchase_orders',
                        'purchase_order.view_own' => 'lang_v1.view_own_purchase_orders',
                        'purchase_order.create' => 'lang_v1.create_purchase_order',
                        'purchase_order.edit' => 'lang_v1.edit_purchase_order',
                        'purchase_order.delete' => 'lang_v1.delete_purchase_order'
                    ] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- 10. VENTAS POS --}}
        <div class="permission-module-card" data-module="pos punto de venta ventas caja descuentos precios impresion ticket facturacion">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-cash-register"></i></div>
                    <h4 class="permission-module-name">@lang('sale.pos_sale')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @if(in_array('pos_sale', $enabled_modules))
                        <label class="permission-item-card {{ in_array('sell.view', $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="sell.view" {{ in_array('sell.view', $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __('role.sell.view') }}</span>
                        </label>
                        <label class="permission-item-card {{ in_array('sell.create', $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="sell.create" {{ in_array('sell.create', $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __('role.sell.create') }}</span>
                        </label>
                    @endif

                    @foreach([
                        'sell.update' => 'role.sell.update',
                        'sell.delete' => 'role.sell.delete',
                        'edit_product_price_from_pos_screen' => 'lang_v1.edit_product_price_from_pos_screen',
                        'edit_product_discount_from_pos_screen' => 'lang_v1.edit_product_discount_from_pos_screen',
                        'edit_pos_payment' => 'lang_v1.add_edit_payment',
                        'access_shipping' => 'lang_v1.access_shipping',
                        'print_invoice' => 'lang_v1.print_invoice',
                        'access_printers' => 'lang_v1.access_printers'
                    ] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 11. VENTAS Y FACTURACIÓN --}}
        <div class="permission-module-card" data-module="ventas facturacion comisiones descuentos pagos comisionistas sale direct sell">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-shopping-cart"></i></div>
                    <h4 class="permission-module-name">@lang('sale.sale')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach([
                        'view_own_sell_only' => 'lang_v1.view_own_sell_only',
                        'view_commission_agent_sell' => 'lang_v1.view_commission_agent_sell',
                        'direct_sell.access' => 'lang_v1.access_types_of_service',
                        'direct_sell.view' => 'role.sell.view',
                        'direct_sell.create' => 'role.sell.create',
                        'direct_sell.update' => 'role.sell.update',
                        'direct_sell.delete' => 'role.sell.delete',
                        'edit_product_price_from_sale_screen' => 'lang_v1.edit_product_price_from_sale_screen',
                        'edit_product_discount_from_sale_screen' => 'lang_v1.edit_product_discount_from_sale_screen',
                        'sell.payments' => 'lang_v1.add_edit_payment',
                        'discount.access' => 'lang_v1.discount.access',
                        'sales_representative.view' => 'role.sales_representative.view'
                    ] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 12. ÓRDENES DE VENTA --}}
        @if(in_array('sales_order', $enabled_modules))
        <div class="permission-module-card" data-module="ordenes venta sales order so">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-file-contract"></i></div>
                    <h4 class="permission-module-name">@lang('lang_v1.sales_order')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach([
                        'so.view_all' => 'lang_v1.view_all_sales_orders',
                        'so.view_own' => 'lang_v1.view_own_sales_orders',
                        'so.create' => 'lang_v1.create_sales_order',
                        'so.edit' => 'lang_v1.edit_sales_order',
                        'so.delete' => 'lang_v1.delete_sales_order'
                    ] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- 13. BORRADORES --}}
        @if(in_array('draft', $enabled_modules))
        <div class="permission-module-card" data-module="borradores draft ventas">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-file-alt"></i></div>
                    <h4 class="permission-module-name">@lang('sale.draft')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach([
                        'list_drafts' => 'lang_v1.list_drafts',
                        'draft.view_all' => 'lang_v1.view_all_drafts',
                        'draft.view_own' => 'lang_v1.view_own_drafts',
                        'draft.create' => 'lang_v1.create_draft',
                        'draft.edit' => 'lang_v1.edit_draft',
                        'draft.delete' => 'lang_v1.delete_draft'
                    ] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- 14. COTIZACIONES --}}
        @if(in_array('quotations', $enabled_modules))
        <div class="permission-module-card" data-module="cotizaciones presupuesto quotation presupuestos">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-file-invoice-dollar"></i></div>
                    <h4 class="permission-module-name">@lang('lang_v1.quotation')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach([
                        'list_quotations' => 'lang_v1.list_quotations',
                        'quotation.view_all' => 'lang_v1.view_all_quotations',
                        'quotation.view_own' => 'lang_v1.view_own_quotations',
                        'quotation.create' => 'lang_v1.create_quotation',
                        'quotation.edit' => 'lang_v1.edit_quotation',
                        'quotation.delete' => 'lang_v1.delete_quotation'
                    ] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- 15. ENVÍOS --}}
        <div class="permission-module-card" data-module="envios despachos shipments entrega">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-shipping-fast"></i></div>
                    <h4 class="permission-module-name">@lang('lang_v1.shipments')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach(['access_all_shipments' => 'lang_v1.access_all_shipments', 'access_own_shipment' => 'lang_v1.access_own_shipping'] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 16. CAJA REGISTRADORA --}}
        <div class="permission-module-card" data-module="caja registradora cash register apertura cierre">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-calculator"></i></div>
                    <h4 class="permission-module-name">@lang('cash_register.cash_register')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach(['view_cash_register' => 'lang_v1.view_cash_register', 'close_cash_register' => 'lang_v1.close_cash_register'] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 17. MARCAS --}}
        <div class="permission-module-card" data-module="marcas brands brand productos">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-tags"></i></div>
                    <h4 class="permission-module-name">@lang('role.brand')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach(['brand.view' => 'role.brand.view', 'brand.create' => 'role.brand.create', 'brand.update' => 'role.brand.update', 'brand.delete' => 'role.brand.delete'] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 18. IMPUESTOS / TASAS --}}
        <div class="permission-module-card" data-module="impuestos iva tax rate tasas seniat">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-percent"></i></div>
                    <h4 class="permission-module-name">@lang('role.tax_rate')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach(['tax_rate.view' => 'role.tax_rate.view', 'tax_rate.create' => 'role.tax_rate.create', 'tax_rate.update' => 'role.tax_rate.update', 'tax_rate.delete' => 'role.tax_rate.delete'] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 19. UNIDADES --}}
        <div class="permission-module-card" data-module="unidades unit medida productos">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-balance-scale"></i></div>
                    <h4 class="permission-module-name">@lang('role.unit')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach(['unit.view' => 'role.unit.view', 'unit.create' => 'role.unit.create', 'unit.update' => 'role.unit.update', 'unit.delete' => 'role.unit.delete'] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 20. CATEGORÍAS --}}
        <div class="permission-module-card" data-module="categorias category productos grupos">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-folder"></i></div>
                    <h4 class="permission-module-name">@lang('category.category')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach(['category.view' => 'role.category.view', 'category.create' => 'role.category.create', 'category.update' => 'role.category.update', 'category.delete' => 'role.category.delete'] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 21. REPORTES --}}
        <div class="permission-module-card" data-module="reportes report ganancias perdidas stock ventas compras comisiones">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-chart-bar"></i></div>
                    <h4 class="permission-module-name">@lang('role.report')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @if(in_array('purchases', $enabled_modules) || in_array('add_sale', $enabled_modules) || in_array('pos_sale', $enabled_modules))
                        <label class="permission-item-card {{ in_array('purchase_n_sell_report.view', $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="purchase_n_sell_report.view" {{ in_array('purchase_n_sell_report.view', $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __('role.purchase_n_sell_report.view') }}</span>
                        </label>
                    @endif

                    @if(in_array('expenses', $enabled_modules))
                        <label class="permission-item-card {{ in_array('expense_report.view', $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="expense_report.view" {{ in_array('expense_report.view', $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __('role.expense_report.view') }}</span>
                        </label>
                    @endif

                    @foreach([
                        'tax_report.view' => 'role.tax_report.view',
                        'contacts_report.view' => 'role.contacts_report.view',
                        'profit_loss_report.view' => 'role.profit_loss_report.view',
                        'stock_report.view' => 'role.stock_report.view',
                        'trending_product_report.view' => 'role.trending_product_report.view',
                        'register_report.view' => 'role.register_report.view',
                        'sales_representative.view' => 'role.sales_representative.view',
                        'view_product_stock_value' => 'lang_v1.view_product_stock_value'
                    ] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 22. CONFIGURACIÓN --}}
        <div class="permission-module-card" data-module="configuracion settings negocio facturas impresoras codigo barra notificaciones">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-cogs"></i></div>
                    <h4 class="permission-module-name">@lang('role.settings')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach([
                        'business_settings.access' => 'role.business_settings.access',
                        'barcode_settings.access' => 'role.barcode_settings.access',
                        'invoice_settings.access' => 'role.invoice_settings.access',
                        'send_notifications' => 'lang_v1.send_notifications'
                    ] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 23. GASTOS --}}
        @if(in_array('expenses', $enabled_modules))
        <div class="permission-module-card" data-module="gastos expense egresos compras">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-receipt"></i></div>
                    <h4 class="permission-module-name">@lang('lang_v1.expense')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach([
                        'expense.access' => 'role.expense.access',
                        'all_expense.access' => 'lang_v1.all_expense.access',
                        'view_own_expense' => 'lang_v1.view_own_expense'
                    ] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- 24. DASHBOARD / INICIO --}}
        <div class="permission-module-card" data-module="dashboard inicio metricas estadisticas">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-tachometer-alt"></i></div>
                    <h4 class="permission-module-name">@lang('role.dashboard')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    <label class="permission-item-card {{ in_array('dashboard.data', $role_permissions) ? 'is-checked' : '' }}">
                        <input type="checkbox" name="permissions[]" value="dashboard.data" {{ in_array('dashboard.data', $role_permissions) ? 'checked' : '' }}>
                        <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                        <span class="permission-item-label">{{ __('role.dashboard.data') }} @show_tooltip(__('tooltip.dashboard_permission'))</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- 25. CUENTAS CONTABLES Y BANCOS --}}
        @if(in_array('account', $enabled_modules))
        <div class="permission-module-card" data-module="cuentas contabilidad bancos account">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-university"></i></div>
                    <h4 class="permission-module-name">@lang('account.account')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    <label class="permission-item-card {{ in_array('account.access', $role_permissions) ? 'is-checked' : '' }}">
                        <input type="checkbox" name="permissions[]" value="account.access" {{ in_array('account.access', $role_permissions) ? 'checked' : '' }}>
                        <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                        <span class="permission-item-label">{{ __('role.account.access') }}</span>
                    </label>
                </div>
            </div>
        </div>
        @endif

        {{-- 26. RESERVACIONES --}}
        @if(in_array('booking', $enabled_modules))
        <div class="permission-module-card" data-module="reservas reservaciones booking restaurant">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-calendar-alt"></i></div>
                    <h4 class="permission-module-name">@lang('restaurant.bookings')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    @foreach(['crud_all_bookings' => 'restaurant.crud_all_bookings', 'crud_own_bookings' => 'restaurant.crud_own_bookings'] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- 27. GRUPOS DE PRECIOS DE VENTA --}}
        <div class="permission-module-card" data-module="precios grupos precio selling price groups tarifas">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-layer-group"></i></div>
                    <h4 class="permission-module-name">@lang('lang_v1.access_selling_price_groups')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    <label class="permission-item-card {{ (empty($role_permissions) || in_array('access_default_selling_price', $role_permissions)) ? 'is-checked' : '' }}">
                        <input type="checkbox" name="permissions[]" value="access_default_selling_price" {{ (empty($role_permissions) || in_array('access_default_selling_price', $role_permissions)) ? 'checked' : '' }}>
                        <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                        <span class="permission-item-label">{{ __('lang_v1.default_selling_price') }}</span>
                    </label>

                    @if(!empty($selling_price_groups) && count($selling_price_groups) > 0)
                        @foreach($selling_price_groups as $selling_price_group)
                            @php
                                $spg_perm = 'selling_price_group.' . $selling_price_group->id;
                            @endphp
                            <label class="permission-item-card {{ in_array($spg_perm, $role_permissions) ? 'is-checked' : '' }}">
                                <input type="checkbox" name="spg_permissions[]" value="{{ $spg_perm }}" {{ in_array($spg_perm, $role_permissions) ? 'checked' : '' }}>
                                <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                                <span class="permission-item-label">{{ $selling_price_group->name }}</span>
                            </label>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        {{-- 28. RESTAURANTE Y MESAS --}}
        @if(in_array('tables', $enabled_modules))
        <div class="permission-module-card" data-module="restaurante mesas tables restaurant">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-utensils"></i></div>
                    <h4 class="permission-module-name">@lang('restaurant.restaurant')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    <label class="permission-item-card {{ in_array('access_tables', $role_permissions) ? 'is-checked' : '' }}">
                        <input type="checkbox" name="permissions[]" value="access_tables" {{ in_array('access_tables', $role_permissions) ? 'checked' : '' }}>
                        <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                        <span class="permission-item-label">{{ __('lang_v1.access_tables') }}</span>
                    </label>
                </div>
            </div>
        </div>
        @endif

        {{-- 29. MÓDULOS EXTERNOS DINÁMICOS --}}
        @if(!empty($module_permissions) && count($module_permissions) > 0)
            @foreach($module_permissions as $mod_key => $mod_perms)
                <div class="permission-module-card" data-module="{{ strtolower($mod_key) }} plugins modulos">
                    <div class="permission-module-header">
                        <div class="permission-module-title-group">
                            <div class="permission-module-icon"><i class="fa fa-puzzle-piece"></i></div>
                            <h4 class="permission-module-name">{{ $mod_key }}</h4>
                        </div>
                        <div class="permission-module-actions">
                            <span class="permission-module-badge">0 / 0</span>
                            <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                            <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                        </div>
                    </div>
                    <div class="permission-module-body">
                        <div class="permission-grid">
                            @foreach($mod_perms as $mp)
                                @php
                                    $is_checked = in_array($mp['value'], $role_permissions) || (empty($role_permissions) && !empty($mp['default']));
                                @endphp
                                <label class="permission-item-card {{ $is_checked ? 'is-checked' : '' }}">
                                    @if(!empty($mp['is_radio']))
                                        <input type="radio" name="radio_option[{{ $mp['radio_input_name'] }}]" value="{{ $mp['value'] }}" {{ $is_checked ? 'checked' : '' }}>
                                    @else
                                        <input type="checkbox" name="permissions[]" value="{{ $mp['value'] }}" {{ $is_checked ? 'checked' : '' }}>
                                    @endif
                                    <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                                    <span class="permission-item-label">{{ $mp['label'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

    </div>
</div>

<!-- BARRA STICKY INFERIOR DE GUARDADO -->
<div class="role-sticky-bottom-bar">
    <div style="display: flex; align-items: center; gap: 15px;">
        <span style="font-size: 14px; color: #94A3B8;">
            <i class="fa fa-user-tag text-primary"></i> Rol: <strong id="sticky_role_name_display" style="color: #FFF;">--</strong>
        </span>
        <span style="background: rgba(255,255,255,0.1); padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 700; color: #38BDF8;">
            <span id="sticky_selected_count_display">0</span> permisos seleccionados
        </span>
    </div>
    <div style="display: flex; gap: 10px; align-items: center;">
        <a href="{{ action([\App\Http\Controllers\RoleController::class, 'index']) }}" class="btn btn-sm btn-default" style="color: #FFF; background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.2); font-weight: 700; border-radius: 6px; padding: 6px 14px;">
            @lang('messages.cancel')
        </a>
        <button type="submit" class="btn btn-sm btn-success" style="font-weight: 800; border-radius: 6px; padding: 8px 20px; font-size: 14px; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.4);">
            <i class="fa fa-save" style="margin-right: 4px;"></i> @lang('messages.save')
        </button>
    </div>
</div>

<script>
$(document).ready(function() {
    // Función para actualizar el estado visual de una tarjeta de permiso
    function updateCardState($card) {
        var $input = $card.find('input[type="checkbox"], input[type="radio"]');
        if ($input.is(':checked')) {
            $card.addClass('is-checked');
        } else {
            $card.removeClass('is-checked');
        }
    }

    // Actualizar conteos por módulo y global
    function updateAllCounts() {
        var totalGlobal = 0;
        var selectedGlobal = 0;

        $('.permission-module-card').each(function() {
            var $module = $(this);
            var $inputs = $module.find('input[type="checkbox"], input[type="radio"]');
            var totalModule = $inputs.length;
            var selectedModule = $inputs.filter(':checked').length;

            totalGlobal += totalModule;
            selectedGlobal += selectedModule;

            var $badge = $module.find('.permission-module-badge');
            $badge.text(selectedModule + ' / ' + totalModule);
            if (selectedModule > 0) {
                $badge.addClass('active');
            } else {
                $badge.removeClass('active');
            }

            var $toggleBtn = $module.find('.module-toggle-all-btn');
            if (selectedModule === totalModule && totalModule > 0) {
                $toggleBtn.text('Desmarcar Módulo').addClass('btn-primary').removeClass('btn-default');
            } else {
                $toggleBtn.text('Marcar Módulo').addClass('btn-default').removeClass('btn-primary');
            }
        });

        // Actualizar barra de progreso y badges globales
        var pct = totalGlobal > 0 ? Math.round((selectedGlobal / totalGlobal) * 100) : 0;
        $('#global_selected_count_badge').text(selectedGlobal + ' de ' + totalGlobal + ' (' + pct + '%)');
        $('#global_selected_progress_bar').css('width', pct + '%');
        $('#sticky_selected_count_display').text(selectedGlobal);
    }

    // Actualizar nombre del rol en barra sticky
    function updateStickyRoleName() {
        var name = $('input#name').val() || '--';
        $('#sticky_role_name_display').text(name);
    }

    $('input#name').on('input change', updateStickyRoleName);
    updateStickyRoleName();

    // Evento de clic en tarjeta de permiso individual
    $(document).on('click', '.permission-item-card', function(e) {
        // Evitar doble toggle si se hace click directamente en el input
        if (e.target.tagName.toLowerCase() !== 'input') {
            var $input = $(this).find('input[type="checkbox"], input[type="radio"]');
            if ($input.is(':radio')) {
                var radioName = $input.attr('name');
                $('input[name="' + radioName + '"]').closest('.permission-item-card').removeClass('is-checked');
                $input.prop('checked', true);
            } else {
                $input.prop('checked', !$input.is(':checked'));
            }
        }
        updateCardState($(this));
        updateAllCounts();
    });

    $(document).on('change', '.permission-item-card input', function() {
        updateCardState($(this).closest('.permission-item-card'));
        updateAllCounts();
    });

    // Toggle para marcar/desmarcar todos los permisos de un módulo
    $(document).on('click', '.module-toggle-all-btn', function(e) {
        e.stopPropagation();
        var $module = $(this).closest('.permission-module-card');
        var $inputs = $module.find('input[type="checkbox"]');
        var allChecked = $inputs.length === $inputs.filter(':checked').length;

        $inputs.prop('checked', !allChecked);
        $module.find('.permission-item-card').each(function() {
            updateCardState($(this));
        });
        updateAllCounts();
    });

    // Colapsar / Expandir módulo al hacer click en el header
    $(document).on('click', '.permission-module-header', function(e) {
        if ($(e.target).closest('.module-toggle-all-btn').length > 0) return;
        var $body = $(this).next('.permission-module-body');
        var $icon = $(this).find('.toggle-collapse-icon');
        $body.slideToggle(180);
        $icon.toggleClass('fa-chevron-up fa-chevron-down');
    });

    // Botón Marcar Todos Global
    $('#btn_select_all_global').on('click', function() {
        $('.permission-module-card input[type="checkbox"]').prop('checked', true);
        $('.permission-item-card').each(function() {
            updateCardState($(this));
        });
        updateAllCounts();
    });

    // Botón Desmarcar Todos Global
    $('#btn_deselect_all_global').on('click', function() {
        $('.permission-module-card input[type="checkbox"]').prop('checked', false);
        $('.permission-item-card').each(function() {
            updateCardState($(this));
        });
        updateAllCounts();
    });

    // Expandir / Colapsar todos
    var allExpanded = true;
    $('#btn_toggle_expand_all').on('click', function() {
        if (allExpanded) {
            $('.permission-module-body').slideUp(180);
            $('.toggle-collapse-icon').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            allExpanded = false;
        } else {
            $('.permission-module-body').slideDown(180);
            $('.toggle-collapse-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            allExpanded = true;
        }
    });

    // Buscador en tiempo real
    $('#permission_search_input').on('keyup input', function() {
        var query = $(this).val().toLowerCase().trim();

        if (query === '') {
            $('.permission-module-card').show();
            $('.permission-item-card').show();
            $('.permission-module-body').show();
            $('.toggle-collapse-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            allExpanded = true;
            return;
        }

        $('.permission-module-card').each(function() {
            var $module = $(this);
            var moduleKeywords = ($module.attr('data-module') || '') + ' ' + $module.find('.permission-module-name').text().toLowerCase();
            var moduleMatches = moduleKeywords.indexOf(query) !== -1;

            var matchingCardsCount = 0;
            $module.find('.permission-item-card').each(function() {
                var $card = $(this);
                var cardText = $card.text().toLowerCase();
                if (cardText.indexOf(query) !== -1 || moduleMatches) {
                    $card.show();
                    matchingCardsCount++;
                } else {
                    $card.hide();
                }
            });

            if (matchingCardsCount > 0) {
                $module.show();
                $module.find('.permission-module-body').show();
                $module.find('.toggle-collapse-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            } else {
                $module.hide();
            }
        });
    });

    // Inicialización inicial
    $('.permission-item-card').each(function() {
        updateCardState($(this));
    });
    updateAllCounts();
});
</script>
