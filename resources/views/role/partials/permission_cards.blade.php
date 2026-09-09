@php
    $enabled_modules = !empty(session('business.enabled_modules')) ? session('business.enabled_modules') : [];
    $pos_settings = !empty(session('business.pos_settings')) ? json_decode(session('business.pos_settings'), true) : [];
    $role_permissions = !empty($role_permissions) ? $role_permissions : [];
    $is_edit = !empty($role);
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
    gap: 10px;
}

.permission-module-icon {
    width: 32px;
    height: 32px;
    background: #EFF6FF;
    color: #2563EB;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
}

.permission-module-name {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: #0F172A;
}

.permission-module-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.permission-module-badge {
    background: #E2E8F0;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    padding: 3px 9px;
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
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 12px;
}

.permission-subgroup-title {
    grid-column: 1 / -1;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    color: #64748B;
    letter-spacing: 0.5px;
    margin-top: 8px;
    margin-bottom: 2px;
    border-bottom: 1px dashed #E2E8F0;
    padding-bottom: 4px;
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
    margin-bottom: 0 !important;
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

.permission-item-card.is-checked .permission-custom-radio {
    border-color: #10B981;
}

.permission-item-card.is-checked .permission-custom-radio-dot {
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

/* Radio visual personalizado */
.permission-custom-radio {
    width: 22px;
    height: 22px;
    min-width: 22px;
    border: 2px solid #CBD5E1;
    border-radius: 50%;
    background: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s ease;
}

.permission-custom-radio-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #10B981;
    opacity: 0;
    transform: scale(0.4);
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
                    <input type="text" id="permission_search_input" class="role-search-input" placeholder="Buscar permiso (ej: ventas, compras, caja, reportes, precios, descuentos, comisiones...)" autocomplete="off">
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
        <div class="permission-module-card" data-module="otros general service staff export botones">
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

                    <label class="permission-item-card {{ in_array('send_notifications', $role_permissions) ? 'is-checked' : '' }}">
                        <input type="checkbox" name="permissions[]" value="send_notifications" {{ in_array('send_notifications', $role_permissions) ? 'checked' : '' }}>
                        <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                        <span class="permission-item-label">Enviar Notificaciones (WhatsApp / SMS / Email)</span>
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
                    @foreach([
                        'user.view' => 'role.user.view',
                        'user.create' => 'role.user.create',
                        'user.update' => 'role.user.update',
                        'user.delete' => 'role.user.delete'
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
                    @foreach([
                        'roles.view' => 'lang_v1.view_role',
                        'roles.create' => 'role.add_role',
                        'roles.update' => 'role.edit_role',
                        'roles.delete' => 'lang_v1.delete_role'
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

        {{-- 4. PROVEEDORES --}}
        <div class="permission-module-card" data-module="proveedores supplier compras ver crear editar eliminar">
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
                    <div class="permission-subgroup-title">Visualización de Proveedores (Exclusivo)</div>
                    @php
                        $sup_own_checked = in_array('supplier.view_own', $role_permissions);
                        $sup_all_checked = $is_edit ? in_array('supplier.view', $role_permissions) : !$sup_own_checked;
                    @endphp
                    <label class="permission-item-card {{ $sup_all_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[supplier_view]" value="supplier.view" {{ $sup_all_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_all_supplier') }}</span>
                    </label>

                    <label class="permission-item-card {{ $sup_own_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[supplier_view]" value="supplier.view_own" {{ $sup_own_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_own_supplier') }}</span>
                    </label>

                    <div class="permission-subgroup-title">Acciones de Proveedores</div>
                    @foreach([
                        'supplier.create' => 'role.supplier.create',
                        'supplier.update' => 'role.supplier.update',
                        'supplier.delete' => 'role.supplier.delete'
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

        {{-- 5. CLIENTES --}}
        <div class="permission-module-card" data-module="clientes customer ventas ver crear editar eliminar filtro sin ventas">
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
                    <div class="permission-subgroup-title">Visualización de Clientes (Exclusivo)</div>
                    @php
                        $cust_own_checked = in_array('customer.view_own', $role_permissions);
                        $cust_all_checked = $is_edit ? in_array('customer.view', $role_permissions) : !$cust_own_checked;
                    @endphp
                    <label class="permission-item-card {{ $cust_all_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[customer_view]" value="customer.view" {{ $cust_all_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_all_customer') }}</span>
                    </label>

                    <label class="permission-item-card {{ $cust_own_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[customer_view]" value="customer.view_own" {{ $cust_own_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_own_customer') }}</span>
                    </label>

                    <div class="permission-subgroup-title">Filtro de Clientes sin Ventas (Exclusivo)</div>
                    @php
                        $has_nosell_opt = in_array('customer_with_no_sell_one_month', $role_permissions) ||
                                          in_array('customer_with_no_sell_three_month', $role_permissions) ||
                                          in_array('customer_with_no_sell_six_month', $role_permissions) ||
                                          in_array('customer_with_no_sell_one_year', $role_permissions);
                        $no_sell_irr = $is_edit ? in_array('customer_irrespective_of_sell', $role_permissions) : !$has_nosell_opt;
                    @endphp
                    <label class="permission-item-card {{ $no_sell_irr ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[customer_view_by_sell]" value="customer_irrespective_of_sell" {{ $no_sell_irr ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.customer_irrespective_of_sell') }}</span>
                    </label>

                    @foreach([
                        'customer_with_no_sell_one_month' => 'lang_v1.customer_with_no_sell_one_month',
                        'customer_with_no_sell_three_month' => 'lang_v1.customer_with_no_sell_three_month',
                        'customer_with_no_sell_six_month' => 'lang_v1.customer_with_no_sell_six_month',
                        'customer_with_no_sell_one_year' => 'lang_v1.customer_with_no_sell_one_year'
                    ] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="radio" name="radio_option[customer_view_by_sell]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach

                    <div class="permission-subgroup-title">Acciones de Clientes</div>
                    @foreach([
                        'customer.create' => 'role.customer.create',
                        'customer.update' => 'role.customer.update',
                        'customer.delete' => 'role.customer.delete'
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

        {{-- 6. PRODUCTOS E INVENTARIO --}}
        <div class="permission-module-card" data-module="productos inventario stock product precio compra ver crear editar eliminar apertura">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-boxes"></i></div>
                    <h4 class="permission-module-name">@lang('product.product')</h4>
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
                        'product.opening_stock' => 'role.product.opening_stock',
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

        {{-- 7. COMPRAS Y AJUSTES DE STOCK --}}
        <div class="permission-module-card" data-module="compras purchase ajuste stock pagos status ver crear editar eliminar">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-shopping-bag"></i></div>
                    <h4 class="permission-module-name">@lang('purchase.purchase_n_stock_adjustment')</h4>
                </div>
                <div class="permission-module-actions">
                    <span class="permission-module-badge">0 / 0</span>
                    <button type="button" class="btn btn-xs btn-default module-toggle-all-btn" style="border-radius: 4px; font-weight: 700;">Marcar Módulo</button>
                    <i class="fa fa-chevron-up toggle-collapse-icon" style="color: #94A3B8; margin-left: 5px;"></i>
                </div>
            </div>
            <div class="permission-module-body">
                <div class="permission-grid">
                    <div class="permission-subgroup-title">Visualización de Compras (Exclusivo)</div>
                    @php
                        $pur_own_checked = in_array('view_own_purchase', $role_permissions);
                        $pur_all_checked = $is_edit ? in_array('purchase.view', $role_permissions) : !$pur_own_checked;
                    @endphp
                    <label class="permission-item-card {{ $pur_all_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[purchase_view]" value="purchase.view" {{ $pur_all_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('purchase.view_all_purchase') }}</span>
                    </label>

                    <label class="permission-item-card {{ $pur_own_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[purchase_view]" value="view_own_purchase" {{ $pur_own_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('purchase.view_own_purchase') }}</span>
                    </label>

                    <div class="permission-subgroup-title">Acciones y Pagos de Compras</div>
                    @foreach([
                        'purchase.create' => 'role.purchase.create',
                        'purchase.update' => 'role.purchase.update',
                        'purchase.delete' => 'role.purchase.delete',
                        'purchase.payments' => 'lang_v1.add_purchase_payment',
                        'edit_purchase_payment' => 'lang_v1.edit_purchase_payment',
                        'delete_purchase_payment' => 'lang_v1.delete_purchase_payment',
                        'purchase.update_status' => 'lang_v1.update_purchase_status'
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

        {{-- 8. ÓRDENES DE COMPRA (PURCHASE ORDER) --}}
        @if(in_array('purchase_order', $enabled_modules))
        <div class="permission-module-card" data-module="ordenes de compra purchase order po crear editar ver eliminar">
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
                    <div class="permission-subgroup-title">Visualización de Órdenes de Compra (Exclusivo)</div>
                    @php
                        $po_own_checked = in_array('purchase_order.view_own', $role_permissions);
                        $po_all_checked = $is_edit ? in_array('purchase_order.view_all', $role_permissions) : !$po_own_checked;
                    @endphp
                    <label class="permission-item-card {{ $po_all_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[purchase_order_view]" value="purchase_order.view_all" {{ $po_all_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_all_purchase_order') }}</span>
                    </label>

                    <label class="permission-item-card {{ $po_own_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[purchase_order_view]" value="purchase_order.view_own" {{ $po_own_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_own_purchase_order') }}</span>
                    </label>

                    <div class="permission-subgroup-title">Acciones de Órdenes de Compra</div>
                    @foreach([
                        'purchase_order.create' => 'lang_v1.create_purchase_order',
                        'purchase_order.update' => 'lang_v1.edit_purchase_order',
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

        {{-- 9. REQUISICIONES DE COMPRA (PURCHASE REQUISITION) --}}
        @if(in_array('purchase_requisition', $enabled_modules))
        <div class="permission-module-card" data-module="requisiciones compra purchase requisition crear ver eliminar">
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
                    <div class="permission-subgroup-title">Visualización de Requisiciones (Exclusivo)</div>
                    @php
                        $pr_own_checked = in_array('purchase_requisition.view_own', $role_permissions);
                        $pr_all_checked = $is_edit ? in_array('purchase_requisition.view_all', $role_permissions) : !$pr_own_checked;
                    @endphp
                    <label class="permission-item-card {{ $pr_all_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[purchase_requisition_view]" value="purchase_requisition.view_all" {{ $pr_all_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_all_purchase_requisition') }}</span>
                    </label>

                    <label class="permission-item-card {{ $pr_own_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[purchase_requisition_view]" value="purchase_requisition.view_own" {{ $pr_own_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_own_purchase_requisition') }}</span>
                    </label>

                    <div class="permission-subgroup-title">Acciones de Requisiciones</div>
                    @foreach([
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

        {{-- 10. PUNTO DE VENTA (POS) --}}
        @if(in_array('pos_sale', $enabled_modules))
        <div class="permission-module-card" data-module="pos punto de venta pos_sale pantalla caja ticket precio descuento cobrar tarjeta credito suspender imprimir factura cotizacion borrador ver crear editar eliminar">
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
                    <div class="permission-subgroup-title">Operaciones de POS</div>
                    @foreach([
                        'sell.view' => 'role.sell.view',
                        'sell.create' => 'role.sell.create',
                        'sell.update' => 'role.sell.update',
                        'sell.delete' => 'role.sell.delete'
                    ] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach

                    <div class="permission-subgroup-title">Configuración y Restricciones de Pantalla POS</div>
                    @foreach([
                        'edit_product_price_from_pos_screen' => 'lang_v1.edit_product_price_from_pos_screen',
                        'edit_product_discount_from_pos_screen' => 'lang_v1.edit_product_discount_from_pos_screen',
                        'edit_pos_payment' => 'lang_v1.edit_pos_payment',
                        'disable_discount' => 'lang_v1.disable_discount',
                        'disable_draft' => 'lang_v1.disable_draft',
                        'disable_credit_sale' => 'lang_v1.disable_credit_sale',
                        'disable_suspend_sale' => 'lang_v1.disable_suspend_sale',
                        'disable_card' => 'lang_v1.disable_card',
                        'disable_pay_checkout' => 'lang_v1.disable_pay_checkout',
                        'disable_express_checkout' => 'lang_v1.disable_express_checkout',
                        'disable_quotation' => 'lang_v1.disable_quotation',
                        'print_invoice' => 'lang_v1.print_invoice'
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

        {{-- 11. VENTAS GENERALES --}}
        <div class="permission-module-card" data-module="ventas sale direct_sell crear editar eliminar pagos devoluciones facturas comisiones tipos servicio parciales vencidas">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-receipt"></i></div>
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
                    <div class="permission-subgroup-title">Visualización de Ventas (Exclusivo)</div>
                    @php
                        $sell_own_checked = in_array('view_own_sell_only', $role_permissions);
                        $sell_all_checked = $is_edit ? in_array('direct_sell.view', $role_permissions) : !$sell_own_checked;
                    @endphp
                    <label class="permission-item-card {{ $sell_all_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[sell_view]" value="direct_sell.view" {{ $sell_all_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_all_sells') }}</span>
                    </label>

                    <label class="permission-item-card {{ $sell_own_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[sell_view]" value="view_own_sell_only" {{ $sell_own_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_own_sells_only') }}</span>
                    </label>

                    <div class="permission-subgroup-title">Filtros de Estado de Cobro de Ventas</div>
                    @foreach([
                        'view_paid_sells_only' => 'lang_v1.view_paid_sells_only',
                        'view_due_sells_only' => 'lang_v1.view_due_sells_only',
                        'view_partial_sells_only' => 'lang_v1.view_partially_paid_sells_only',
                        'view_overdue_sells_only' => 'lang_v1.view_overdue_sells_only'
                    ] as $p_val => $p_lang)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ __($p_lang) }}</span>
                        </label>
                    @endforeach

                    <div class="permission-subgroup-title">Acciones y Pagos de Ventas</div>
                    @foreach([
                        'direct_sell.access' => 'lang_v1.add_sell',
                        'direct_sell.update' => 'lang_v1.update_sale',
                        'direct_sell.delete' => 'lang_v1.delete_sell',
                        'view_commission_agent_sell' => 'lang_v1.view_commission_agent_sell',
                        'sell.payments' => 'lang_v1.add_sell_payment',
                        'edit_sell_payment' => 'lang_v1.edit_sell_payment',
                        'delete_sell_payment' => 'lang_v1.delete_sell_payment',
                        'edit_product_price_from_sale_screen' => 'lang_v1.edit_product_price_from_sale_screen',
                        'edit_product_discount_from_sale_screen' => 'lang_v1.edit_product_discount_from_sale_screen',
                        'discount.access' => 'lang_v1.discount.access',
                        'access_types_of_service' => 'lang_v1.access_types_of_service',
                        'access_sell_return' => 'lang_v1.access_all_sell_return',
                        'access_own_sell_return' => 'lang_v1.access_own_sell_return',
                        'edit_invoice_number' => 'lang_v1.add_edit_invoice_number'
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

        {{-- 12. PEDIDOS DE VENTA (SALES ORDER) --}}
        <div class="permission-module-card" data-module="pedidos venta sales order so pedidos crear editar ver eliminar">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-cart-arrow-down"></i></div>
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
                    <div class="permission-subgroup-title">Visualización de Pedidos de Venta (Exclusivo)</div>
                    @php
                        $so_own_checked = in_array('so.view_own', $role_permissions);
                        $so_all_checked = $is_edit ? in_array('so.view_all', $role_permissions) : !$so_own_checked;
                    @endphp
                    <label class="permission-item-card {{ $so_all_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[so_view]" value="so.view_all" {{ $so_all_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_all_so') }}</span>
                    </label>

                    <label class="permission-item-card {{ $so_own_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[so_view]" value="so.view_own" {{ $so_own_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_own_so') }}</span>
                    </label>

                    <div class="permission-subgroup-title">Acciones de Pedidos de Venta</div>
                    @foreach([
                        'so.create' => 'lang_v1.create_so',
                        'so.update' => 'lang_v1.edit_so',
                        'so.delete' => 'lang_v1.delete_so'
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

        {{-- 13. BORRADORES (DRAFT) --}}
        <div class="permission-module-card" data-module="borradores draft ventas editar eliminar ver">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-pencil-ruler"></i></div>
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
                    <div class="permission-subgroup-title">Visualización de Borradores (Exclusivo)</div>
                    @php
                        $draft_own_checked = in_array('draft.view_own', $role_permissions);
                        $draft_all_checked = $is_edit ? in_array('draft.view_all', $role_permissions) : !$draft_own_checked;
                    @endphp
                    <label class="permission-item-card {{ $draft_all_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[draft_view]" value="draft.view_all" {{ $draft_all_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_all_drafts') }}</span>
                    </label>

                    <label class="permission-item-card {{ $draft_own_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[draft_view]" value="draft.view_own" {{ $draft_own_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_own_drafts') }}</span>
                    </label>

                    <div class="permission-subgroup-title">Acciones de Borradores</div>
                    @foreach([
                        'draft.update' => 'lang_v1.edit_draft',
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

        {{-- 14. COTIZACIONES (QUOTATION) --}}
        <div class="permission-module-card" data-module="cotizaciones quotation presupuesto editar eliminar ver">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-calculator"></i></div>
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
                    <div class="permission-subgroup-title">Visualización de Cotizaciones (Exclusivo)</div>
                    @php
                        $quot_own_checked = in_array('quotation.view_own', $role_permissions);
                        $quot_all_checked = $is_edit ? in_array('quotation.view_all', $role_permissions) : !$quot_own_checked;
                    @endphp
                    <label class="permission-item-card {{ $quot_all_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[quotation_view]" value="quotation.view_all" {{ $quot_all_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_all_quotations') }}</span>
                    </label>

                    <label class="permission-item-card {{ $quot_own_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[quotation_view]" value="quotation.view_own" {{ $quot_own_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_own_quotations') }}</span>
                    </label>

                    <div class="permission-subgroup-title">Acciones de Cotizaciones</div>
                    @foreach([
                        'quotation.update' => 'lang_v1.edit_quotation',
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

        {{-- 15. ENVÍOS Y DESPACHOS (SHIPMENTS) --}}
        <div class="permission-module-card" data-module="envios despachos shipments fletes comisiones entregas pendientes">
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
                    <div class="permission-subgroup-title">Visualización de Envíos (Exclusivo)</div>
                    @php
                        $ship_own_checked = in_array('access_own_shipping', $role_permissions);
                        $ship_all_checked = $is_edit ? in_array('access_shipping', $role_permissions) : !$ship_own_checked;
                    @endphp
                    <label class="permission-item-card {{ $ship_all_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[shipping_view]" value="access_shipping" {{ $ship_all_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.access_all_shipments') }}</span>
                    </label>

                    <label class="permission-item-card {{ $ship_own_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[shipping_view]" value="access_own_shipping" {{ $ship_own_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.access_own_shipping') }}</span>
                    </label>

                    <div class="permission-subgroup-title">Opciones Adicionales de Envíos</div>
                    @foreach([
                        'access_pending_shipments_only' => 'lang_v1.access_pending_shipments_only',
                        'access_commission_agent_shipping' => 'lang_v1.access_commission_agent_shipping'
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

        {{-- 16. CAJA REGISTRADORA / CAJA CHICA --}}
        <div class="permission-module-card" data-module="caja registradora cash_register turnos arqueo apertura cierre ver">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-cash-register"></i></div>
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
                    @foreach([
                        'view_cash_register' => 'lang_v1.view_cash_register',
                        'close_cash_register' => 'lang_v1.close_cash_register'
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

        {{-- 17. MARCAS (BRANDS) --}}
        <div class="permission-module-card" data-module="marcas brand productos crear editar ver eliminar">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-copyright"></i></div>
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
                    @foreach([
                        'brand.view' => 'role.brand.view',
                        'brand.create' => 'role.brand.create',
                        'brand.update' => 'role.brand.update',
                        'brand.delete' => 'role.brand.delete'
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

        {{-- 18. TASAS DE IMPUESTOS (TAX RATES) --}}
        <div class="permission-module-card" data-module="impuestos tax iva tasas tributos crear editar ver eliminar">
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
                    @foreach([
                        'tax_rate.view' => 'role.tax_rate.view',
                        'tax_rate.create' => 'role.tax_rate.create',
                        'tax_rate.update' => 'role.tax_rate.update',
                        'tax_rate.delete' => 'role.tax_rate.delete'
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

        {{-- 19. UNIDADES DE MEDIDA (UNITS) --}}
        <div class="permission-module-card" data-module="unidades unit medida peso cantidad crear editar ver eliminar">
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
                    @foreach([
                        'unit.view' => 'role.unit.view',
                        'unit.create' => 'role.unit.create',
                        'unit.update' => 'role.unit.update',
                        'unit.delete' => 'role.unit.delete'
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

        {{-- 20. CATEGORÍAS --}}
        <div class="permission-module-card" data-module="categorias category productos rubros crear editar ver eliminar">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-tags"></i></div>
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
                    @foreach([
                        'category.view' => 'role.category.view',
                        'category.create' => 'role.category.create',
                        'category.update' => 'role.category.update',
                        'category.delete' => 'role.category.delete'
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

        {{-- 21. REPORTES --}}
        <div class="permission-module-card" data-module="reportes report ganancias perdidas stock valor gastos ventas compras caja representantes">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-chart-line"></i></div>
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
                    @foreach([
                        'purchase_n_sell_report.view' => 'role.purchase_n_sell_report.view',
                        'tax_report.view' => 'role.tax_report.view',
                        'contacts_report.view' => 'role.contacts_report.view',
                        'expense_report.view' => 'role.expense_report.view',
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

        {{-- 22. CONFIGURACIÓN DEL SISTEMA --}}
        <div class="permission-module-card" data-module="configuracion settings negocio empresa codigo barras facturas impresoras sucursales">
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
                        'access_printers' => 'lang_v1.access_printers',
                        'access_all_locations' => 'lang_v1.access_all_locations'
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

        {{-- 23. GASTOS (EXPENSES) --}}
        @if(in_array('expenses', $enabled_modules))
        <div class="permission-module-card" data-module="gastos expense compras pagos egresos agregar editar eliminar ver">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-money-bill-wave"></i></div>
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
                    <div class="permission-subgroup-title">Visualización de Gastos (Exclusivo)</div>
                    @php
                        $exp_own_checked = in_array('view_own_expense', $role_permissions);
                        $exp_all_checked = $is_edit ? in_array('all_expense.access', $role_permissions) : !$exp_own_checked;
                    @endphp
                    <label class="permission-item-card {{ $exp_all_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[expense_view]" value="all_expense.access" {{ $exp_all_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.access_all_expense') }}</span>
                    </label>

                    <label class="permission-item-card {{ $exp_own_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[expense_view]" value="view_own_expense" {{ $exp_own_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('lang_v1.view_own_expense') }}</span>
                    </label>

                    <div class="permission-subgroup-title">Acciones de Gastos</div>
                    @foreach([
                        'expense.add' => 'expense.add_expense',
                        'expense.edit' => 'expense.edit_expense',
                        'expense.delete' => 'lang_v1.delete_expense'
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

        {{-- 24. TASAS DE CAMBIO Y MONEDAS (EXCHANGE RATES) --}}
        <div class="permission-module-card" data-module="tasas cambio dolar bcv exchange rate oficial paralelo bsf divisas monedas ver crear editar eliminar">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-dollar-sign"></i></div>
                    <h4 class="permission-module-name">Tasas de Cambio / Divisas</h4>
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
                        'view_exchange_rate' => 'Ver Tasas de Cambio',
                        'create_exchange_rate' => 'Crear / Actualizar Tasa de Cambio',
                        'edit_exchange_rate' => 'Editar Historial de Tasas',
                        'delete_exchange_rate' => 'Eliminar Tasas de Cambio'
                    ] as $p_val => $p_label)
                        <label class="permission-item-card {{ in_array($p_val, $role_permissions) ? 'is-checked' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $p_val }}" {{ in_array($p_val, $role_permissions) ? 'checked' : '' }}>
                            <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                            <span class="permission-item-label">{{ $p_label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 25. DASHBOARD / INICIO --}}
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

        {{-- 26. CUENTAS CONTABLES Y BANCOS --}}
        @if(in_array('account', $enabled_modules))
        <div class="permission-module-card" data-module="cuentas contabilidad bancos account transacciones editar eliminar">
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
                    @foreach([
                        'account.access' => 'lang_v1.access_accounts',
                        'edit_account_transaction' => 'lang_v1.edit_account_transaction',
                        'delete_account_transaction' => 'lang_v1.delete_account_transaction'
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

        {{-- 27. RESERVAS (BOOKINGS) --}}
        @if(in_array('booking', $enabled_modules))
        <div class="permission-module-card" data-module="reservas bookings restaurant citas">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-calendar-check"></i></div>
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
                    <div class="permission-subgroup-title">Gestión de Reservas (Exclusivo)</div>
                    @php
                        $book_own_checked = in_array('crud_own_bookings', $role_permissions);
                        $book_all_checked = $is_edit ? in_array('crud_all_bookings', $role_permissions) : !$book_own_checked;
                    @endphp
                    <label class="permission-item-card {{ $book_all_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[bookings_view]" value="crud_all_bookings" {{ $book_all_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('restaurant.add_edit_view_all_booking') }}</span>
                    </label>

                    <label class="permission-item-card {{ $book_own_checked ? 'is-checked' : '' }}">
                        <input type="radio" name="radio_option[bookings_view]" value="crud_own_bookings" {{ $book_own_checked ? 'checked' : '' }}>
                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                        <span class="permission-item-label">{{ __('restaurant.add_edit_view_own_booking') }}</span>
                    </label>
                </div>
            </div>
        </div>
        @endif

        {{-- 28. GRUPOS DE PRECIOS DE VENTA (SELLING PRICE GROUPS) --}}
        <div class="permission-module-card" data-module="grupos precios venta selling price groups listas precios">
            <div class="permission-module-header">
                <div class="permission-module-title-group">
                    <div class="permission-module-icon"><i class="fa fa-tags"></i></div>
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
                    <label class="permission-item-card {{ in_array('access_default_selling_price', $role_permissions) ? 'is-checked' : '' }}">
                        <input type="checkbox" name="permissions[]" value="access_default_selling_price" {{ in_array('access_default_selling_price', $role_permissions) ? 'checked' : '' }}>
                        <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                        <span class="permission-item-label">{{ __('lang_v1.default_selling_price') }}</span>
                    </label>

                    @if(!empty($selling_price_groups) && count($selling_price_groups) > 0)
                        @foreach($selling_price_groups as $selling_price_group)
                            @php
                                $spg_perm = 'selling_price_group.' . $selling_price_group->id;
                                $spg_checked = in_array($spg_perm, $role_permissions);
                            @endphp
                            <label class="permission-item-card {{ $spg_checked ? 'is-checked' : '' }}">
                                <input type="checkbox" name="spg_permissions[]" value="{{ $spg_perm }}" {{ $spg_checked ? 'checked' : '' }}>
                                <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                                <span class="permission-item-label">{{ $selling_price_group->name }}</span>
                            </label>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        {{-- 29. MESAS DE RESTAURANTE (TABLES) --}}
        @if(in_array('tables', $enabled_modules))
        <div class="permission-module-card" data-module="mesas tables restaurante restaurant">
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

        {{-- 30. MÓDULOS ADICIONALES DINÁMICOS ($module_permissions) --}}
        @if(!empty($module_permissions))
            @foreach($module_permissions as $mod_key => $mod_perms)
                <div class="permission-module-card" data-module="{{ strtolower($mod_key) }} modulo plugin extension">
                    <div class="permission-module-header">
                        <div class="permission-module-title-group">
                            <div class="permission-module-icon"><i class="fa fa-puzzle-piece"></i></div>
                            <h4 class="permission-module-name">{{ ucwords(str_replace('_', ' ', $mod_key)) }}</h4>
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
                                        <div class="permission-custom-radio"><div class="permission-custom-radio-dot"></div></div>
                                    @else
                                        <input type="checkbox" name="permissions[]" value="{{ $mp['value'] }}" {{ $is_checked ? 'checked' : '' }}>
                                        <div class="permission-custom-checkbox"><i class="fa fa-check"></i></div>
                                    @endif
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
            <i class="fa fa-save" style="margin-right: 4px;"></i> {{ !empty($role) ? __('messages.update') : __('messages.save') }}
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
        if (e.target.tagName.toLowerCase() !== 'input') {
            var $input = $(this).find('input[type="checkbox"], input[type="radio"]');
            if ($input.is(':radio')) {
                var radioName = $input.attr('name');
                $('input[name="' + radioName + '"]').prop('checked', false).closest('.permission-item-card').removeClass('is-checked');
                $input.prop('checked', true);
            } else {
                $input.prop('checked', !$input.is(':checked'));
            }
        } else {
            var $input = $(this).find('input[type="checkbox"], input[type="radio"]');
            if ($input.is(':radio')) {
                var radioName = $input.attr('name');
                $('input[name="' + radioName + '"]').not($input).prop('checked', false).closest('.permission-item-card').removeClass('is-checked');
            }
        }
        updateCardState($(this));
        updateAllCounts();
    });

    $(document).on('change', '.permission-item-card input', function() {
        var $input = $(this);
        if ($input.is(':radio')) {
            var radioName = $input.attr('name');
            $('input[name="' + radioName + '"]').not($input).closest('.permission-item-card').removeClass('is-checked');
        }
        updateCardState($input.closest('.permission-item-card'));
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
            $('.permission-subgroup-title').show();
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
