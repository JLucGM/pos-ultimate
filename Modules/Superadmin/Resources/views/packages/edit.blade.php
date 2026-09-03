@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.edit_package'))

@section('content')
    @include('superadmin::layouts.nav')

    <!-- Header & Breadcrumbs -->
    <section class="content-header" style="padding: 20px 25px 10px 25px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h1 style="font-size: 24px; font-weight: 800; color: #0F172A; margin: 0; display: flex; align-items: center; gap: 10px;">
                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, #4F46E5 0%, #3B82F6 100%); color: white; font-size: 18px; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);">
                        <i class="fa fa-box-open"></i>
                    </span>
                    Editar Paquete de Suscripción
                    <span style="font-size: 14px; font-weight: 600; color: #64748B; background: #F1F5F9; padding: 4px 12px; border-radius: 20px; border: 1px solid #E2E8F0;">
                        {{ $packages->name }}
                    </span>
                </h1>
                <p style="color: #64748B; font-size: 13px; margin: 5px 0 0 50px;">
                    Configura las características, límites de recursos, precios y módulos habilitados para este plan SaaS.
                </p>
            </div>
            <div>
                <a href="{{ action([\Modules\Superadmin\Http\Controllers\PackagesController::class, 'index']) }}" class="btn btn-default" style="border-radius: 10px; font-weight: 600; padding: 8px 16px; border: 1px solid #CBD5E1; color: #475569;">
                    <i class="fa fa-arrow-left" style="margin-right: 6px;"></i> Volver a Paquetes
                </a>
            </div>
        </div>
    </section>

    <!-- Main Form Content -->
    <section class="content" style="padding: 10px 25px 40px 25px;">
        {!! Form::open(['route' => ['packages.update', $packages->id], 'method' => 'put', 'id' => 'edit_package_form']) !!}

        <div class="row">
            <!-- Columna Izquierda: Información Principal y Límites -->
            <div class="col-md-8">
                
                <!-- 1. INFORMACIÓN GENERAL -->
                <div class="box box-solid" style="border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 24px; overflow: hidden;">
                    <div class="box-header with-border" style="background: #F8FAFC; padding: 16px 20px; border-bottom: 1px solid #E2E8F0;">
                        <h3 class="box-title" style="font-size: 16px; font-weight: 700; color: #1E293B; display: flex; align-items: center; gap: 8px;">
                            <i class="fa fa-info-circle text-primary"></i> 1. Información General del Plan
                        </h3>
                    </div>
                    <div class="box-body" style="padding: 24px;">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    {!! Form::label('name', 'Nombre del Paquete *', ['style' => 'font-weight: 700; color: #334155; font-size: 13px;']) !!}
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background: #F8FAFC; border-color: #CBD5E1; color: #64748B;"><i class="fa fa-tag"></i></span>
                                        {!! Form::text('name', $packages->name, ['class' => 'form-control', 'required', 'placeholder' => 'Ej: Plan Emprendedor, Plan Pro Restaurante', 'style' => 'border-color: #CBD5E1; border-radius: 0 8px 8px 0; font-weight: 600; font-size: 14px; height: 42px;']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    {!! Form::label('sort_order', 'Orden de Aparición *', ['style' => 'font-weight: 700; color: #334155; font-size: 13px;']) !!}
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background: #F8FAFC; border-color: #CBD5E1; color: #64748B;"><i class="fa fa-sort-numeric-down"></i></span>
                                        {!! Form::number('sort_order', $packages->sort_order, ['class' => 'form-control', 'required', 'min' => 1, 'style' => 'border-color: #CBD5E1; border-radius: 0 8px 8px 0; height: 42px; font-weight: 600;']) !!}
                                    </div>
                                    <small class="text-muted" style="font-size: 11px;">(1 = Primero en la lista)</small>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group" style="margin-bottom: 0;">
                                    {!! Form::label('description', 'Descripción Pública del Plan *', ['style' => 'font-weight: 700; color: #334155; font-size: 13px;']) !!}
                                    {!! Form::textarea('description', $packages->description, ['class' => 'form-control', 'required', 'rows' => 2, 'placeholder' => 'Breve resumen comercial visible para los clientes en la tabla de precios...', 'style' => 'border-color: #CBD5E1; border-radius: 8px; font-size: 13px; resize: vertical;']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. LÍMITES DE RECURSOS -->
                <div class="box box-solid" style="border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 24px; overflow: hidden;">
                    <div class="box-header with-border" style="background: #F8FAFC; padding: 16px 20px; border-bottom: 1px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center;">
                        <h3 class="box-title" style="font-size: 16px; font-weight: 700; color: #1E293B; display: flex; align-items: center; gap: 8px;">
                            <i class="fa fa-sliders-h text-info"></i> 2. Límites y Capacidad de Recursos
                        </h3>
                        <span class="badge" style="background: #E0E7FF; color: #4338CA; font-weight: 700; font-size: 11px; padding: 4px 10px; border-radius: 20px;">
                            <i class="fa fa-infinity"></i> 0 = Ilimitado
                        </span>
                    </div>
                    <div class="box-body" style="padding: 24px;">
                        <p style="color: #64748B; font-size: 12px; margin-top: 0; margin-bottom: 18px;">
                            Define la cantidad máxima de registros que el negocio podrá crear con este plan. Si colocas <strong>0</strong>, no tendrá límite.
                        </p>

                        <div class="row">
                            <!-- Sucursales -->
                            <div class="col-sm-6" style="margin-bottom: 16px;">
                                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 16px;">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                        <div style="width: 34px; height: 34px; border-radius: 8px; background: #EFF6FF; color: #2563EB; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                            <i class="fa fa-map-marker-alt"></i>
                                        </div>
                                        <div>
                                            <strong style="color: #1E293B; font-size: 13px; display: block;">Sucursales / Ubicaciones</strong>
                                            <span style="color: #64748B; font-size: 11px;">Límite de sedes permitidas</span>
                                        </div>
                                    </div>
                                    {!! Form::number('location_count', $packages->location_count, ['class' => 'form-control', 'required', 'min' => 0, 'style' => 'border-radius: 8px; font-weight: 700; font-size: 15px; border-color: #CBD5E1;']) !!}
                                </div>
                            </div>

                            <!-- Usuarios -->
                            <div class="col-sm-6" style="margin-bottom: 16px;">
                                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 16px;">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                        <div style="width: 34px; height: 34px; border-radius: 8px; background: #F0FDF4; color: #16A34A; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div>
                                            <strong style="color: #1E293B; font-size: 13px; display: block;">Usuarios / Empleados</strong>
                                            <span style="color: #64748B; font-size: 11px;">Cajeros, admin y roles</span>
                                        </div>
                                    </div>
                                    {!! Form::number('user_count', $packages->user_count, ['class' => 'form-control', 'required', 'min' => 0, 'style' => 'border-radius: 8px; font-weight: 700; font-size: 15px; border-color: #CBD5E1;']) !!}
                                </div>
                            </div>

                            <!-- Productos -->
                            <div class="col-sm-6" style="margin-bottom: 16px;">
                                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 16px;">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                        <div style="width: 34px; height: 34px; border-radius: 8px; background: #FFFBEB; color: #D97706; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                            <i class="fa fa-boxes"></i>
                                        </div>
                                        <div>
                                            <strong style="color: #1E293B; font-size: 13px; display: block;">Productos en Inventario</strong>
                                            <span style="color: #64748B; font-size: 11px;">Catálogo total de artículos</span>
                                        </div>
                                    </div>
                                    {!! Form::number('product_count', $packages->product_count, ['class' => 'form-control', 'required', 'min' => 0, 'style' => 'border-radius: 8px; font-weight: 700; font-size: 15px; border-color: #CBD5E1;']) !!}
                                </div>
                            </div>

                            <!-- Facturas -->
                            <div class="col-sm-6" style="margin-bottom: 16px;">
                                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 16px;">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                        <div style="width: 34px; height: 34px; border-radius: 8px; background: #FAF5FF; color: #9333EA; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                            <i class="fa fa-file-invoice-dollar"></i>
                                        </div>
                                        <div>
                                            <strong style="color: #1E293B; font-size: 13px; display: block;">Ventas y Facturas</strong>
                                            <span style="color: #64748B; font-size: 11px;">Total de comprobantes emitidos</span>
                                        </div>
                                    </div>
                                    {!! Form::number('invoice_count', $packages->invoice_count, ['class' => 'form-control', 'required', 'min' => 0, 'style' => 'border-radius: 8px; font-weight: 700; font-size: 15px; border-color: #CBD5E1;']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. MÓDULOS Y EXTENSIONES ESPECIALIZADAS -->
                <div class="box box-solid" style="border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 24px; overflow: hidden;">
                    <div class="box-header with-border" style="background: #F8FAFC; padding: 16px 20px; border-bottom: 1px solid #E2E8F0;">
                        <h3 class="box-title" style="font-size: 16px; font-weight: 700; color: #1E293B; display: flex; align-items: center; gap: 8px;">
                            <i class="fa fa-cubes text-warning"></i> 3. Módulos Especializados Incluidos en el Paquete
                        </h3>
                    </div>
                    <div class="box-body" style="padding: 24px;">
                        <p style="color: #64748B; font-size: 12px; margin-top: 0; margin-bottom: 18px;">
                            Marca los módulos a los que tendrán acceso los clientes suscritos a este paquete.
                        </p>

                        <div class="row">
                            @php
                                $module_icons = [
                                    'manufacturing_module' => ['icon' => 'fa fa-industry', 'bg' => '#EFF6FF', 'color' => '#2563EB', 'desc' => 'Órdenes de producción, recetas e insumos.'],
                                    'consultorio_module'   => ['icon' => 'fa fa-user-md', 'bg' => '#F0FDF4', 'color' => '#16A34A', 'desc' => 'Historias clínicas, citas y pacientes.'],
                                    'account_module'       => ['icon' => 'fa fa-landmark', 'bg' => '#FAF5FF', 'color' => '#9333EA', 'desc' => 'Libro mayor, transferencias y bancos.'],
                                    'subscription_module'  => ['icon' => 'fa fa-sync-alt', 'bg' => '#FEF3C7', 'color' => '#D97706', 'desc' => 'Facturación recurrente y suscripciones.'],
                                    'crm_module'           => ['icon' => 'fa fa-users-cog', 'bg' => '#FFF1F2', 'color' => '#E11D48', 'desc' => 'Gestión de clientes y seguimiento.'],
                                    'woocommerce_module'   => ['icon' => 'fa fa-shopping-bag', 'bg' => '#F5F3FF', 'color' => '#7C3AED', 'desc' => 'Sincronización con tienda online.'],
                                    'essentials_module'    => ['icon' => 'fa fa-briefcase', 'bg' => '#F1F5F9', 'color' => '#475569', 'desc' => 'Nómina, asistencia y tareas de equipo.'],
                                ];
                            @endphp

                            @foreach ($permissions as $module => $module_permissions)
                                @foreach ($module_permissions as $permission)
                                    @php
                                        $value = isset($packages->custom_permissions[$permission['name']])
                                            ? $packages->custom_permissions[$permission['name']]
                                            : false;
                                        $meta = $module_icons[$permission['name']] ?? ['icon' => 'fa fa-cube', 'bg' => '#F8FAFC', 'color' => '#475569', 'desc' => 'Extensión modular del sistema.'];
                                    @endphp

                                    @if (isset($permission['field_type']) && in_array($permission['field_type'], ['number', 'input']))
                                        <div class="col-sm-6" style="margin-bottom: 16px;">
                                            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 12px; padding: 14px 16px;">
                                                {!! Form::label("custom_permissions[$permission[name]]", $permission['label'] . ':', ['style' => 'font-weight: 700; color: #334155; font-size: 13px;']) !!}
                                                @if (isset($permission['tooltip']))
                                                    @show_tooltip($permission['tooltip'])
                                                @endif
                                                {!! Form::text("custom_permissions[$permission[name]]", $value, [
                                                    'class' => 'form-control',
                                                    'type' => $permission['field_type'],
                                                    'style' => 'border-radius: 8px; border-color: #CBD5E1; margin-top: 6px;',
                                                ]) !!}
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-sm-6" style="margin-bottom: 16px;">
                                            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 12px; padding: 14px 16px; height: 100%; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s ease;">
                                                <div style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 10px;">
                                                    <div style="width: 36px; height: 36px; border-radius: 8px; background: {{ $meta['bg'] }}; color: {{ $meta['color'] }}; display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0;">
                                                        <i class="{{ $meta['icon'] }}"></i>
                                                    </div>
                                                    <div>
                                                        <strong style="color: #0F172A; font-size: 13px; display: block;">{{ $permission['label'] }}</strong>
                                                        <p style="color: #64748B; font-size: 11px; margin: 2px 0 0 0; line-height: 1.3;">{{ $meta['desc'] }}</p>
                                                    </div>
                                                </div>
                                                <div style="border-top: 1px dashed #E2E8F0; padding-top: 8px;">
                                                    <div class="checkbox" style="margin: 0;">
                                                        <label style="font-weight: 600; color: #334155; font-size: 12px; cursor: pointer; padding-left: 0;">
                                                            {!! Form::checkbox("custom_permissions[$permission[name]]", 1, $value, ['class' => 'input-icheck']) !!}
                                                            <span style="margin-left: 6px;">Habilitar en este paquete</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>

                        <!-- Sub-sección: Restaurantes y Hostelería -->
                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #F1F5F9;">
                            <h5 style="font-weight: 700; color: #334155; font-size: 13px; margin-bottom: 14px; display: flex; align-items: center; gap: 6px;">
                                <i class="fa fa-utensils text-danger"></i> Funciones Especiales para Restaurantes y Servicios:
                            </h5>

                            <div class="row">
                                <div class="col-sm-6 col-md-3" style="margin-bottom: 12px;">
                                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 10px 12px;">
                                        <div class="checkbox" style="margin: 0;">
                                            <label style="font-weight: 600; color: #1E293B; font-size: 12px; cursor: pointer; padding-left: 0;">
                                                {!! Form::checkbox('tables', 1, $packages->tables, ['class' => 'input-icheck']) !!}
                                                <span style="margin-left: 6px;"><i class="fa fa-table text-muted"></i> Control Mesas</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3" style="margin-bottom: 12px;">
                                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 10px 12px;">
                                        <div class="checkbox" style="margin: 0;">
                                            <label style="font-weight: 600; color: #1E293B; font-size: 12px; cursor: pointer; padding-left: 0;">
                                                {!! Form::checkbox('kitchen', 1, $packages->kitchen, ['class' => 'input-icheck']) !!}
                                                <span style="margin-left: 6px;"><i class="fa fa-fire text-muted"></i> Cocina KDS</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3" style="margin-bottom: 12px;">
                                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 10px 12px;">
                                        <div class="checkbox" style="margin: 0;">
                                            <label style="font-weight: 600; color: #1E293B; font-size: 12px; cursor: pointer; padding-left: 0;">
                                                {!! Form::checkbox('order_screen', 1, $packages->order_screen, ['class' => 'input-icheck']) !!}
                                                <span style="margin-left: 6px;"><i class="fa fa-desktop text-muted"></i> Pantalla Pedidos</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3" style="margin-bottom: 12px;">
                                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 10px 12px;">
                                        <div class="checkbox" style="margin: 0;">
                                            <label style="font-weight: 600; color: #1E293B; font-size: 12px; cursor: pointer; padding-left: 0;">
                                                {!! Form::checkbox('bookings', 1, $packages->bookings, ['class' => 'input-icheck']) !!}
                                                <span style="margin-left: 6px;"><i class="fa fa-calendar-check text-muted"></i> Citas / Reservas</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Precios, Facturación, Visibilidad y Acciones -->
            <div class="col-md-4">
                
                <!-- 4. PRECIOS Y FACTURACIÓN -->
                <div class="box box-solid" style="border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 24px; overflow: hidden;">
                    <div class="box-header with-border" style="background: #F8FAFC; padding: 16px 20px; border-bottom: 1px solid #E2E8F0;">
                        <h3 class="box-title" style="font-size: 16px; font-weight: 700; color: #1E293B; display: flex; align-items: center; gap: 8px;">
                            <i class="fa fa-credit-card text-success"></i> 4. Precio y Facturación
                        </h3>
                    </div>
                    <div class="box-body" style="padding: 20px;">
                        <!-- Precio -->
                        <div class="form-group">
                            {!! Form::label('price', 'Precio del Paquete (USD) *', ['style' => 'font-weight: 700; color: #334155; font-size: 13px;']) !!}
                            <div class="input-group">
                                <span class="input-group-addon" style="background: #F8FAFC; border-color: #CBD5E1; font-weight: 700; color: #0F172A;">$</span>
                                {!! Form::text('price', $packages->price, ['class' => 'form-control input_number', 'required', 'style' => 'border-color: #CBD5E1; font-size: 16px; font-weight: 800; color: #0F172A; height: 44px;']) !!}
                            </div>
                            <small class="text-muted" style="font-size: 11px;">Coloca 0 para que sea un paquete gratuito.</small>
                        </div>

                        <!-- Frecuencia / Intervalo -->
                        <div class="form-group">
                            {!! Form::label('interval', 'Frecuencia de Cobro *', ['style' => 'font-weight: 700; color: #334155; font-size: 13px;']) !!}
                            <div class="row">
                                <div class="col-xs-5" style="padding-right: 5px;">
                                    {!! Form::number('interval_count', $packages->interval_count, ['class' => 'form-control', 'required', 'min' => 1, 'style' => 'border-color: #CBD5E1; border-radius: 8px; font-weight: 700; height: 40px;']) !!}
                                </div>
                                <div class="col-xs-7" style="padding-left: 5px;">
                                    {!! Form::select('interval', $intervals, $packages->interval, [
                                        'class' => 'form-control select2',
                                        'required',
                                        'style' => 'width: 100%;',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <!-- Días de Prueba -->
                        <div class="form-group" style="margin-bottom: 0;">
                            {!! Form::label('trial_days', 'Días de Prueba Gratis (Demo) *', ['style' => 'font-weight: 700; color: #334155; font-size: 13px;']) !!}
                            <div class="input-group">
                                <span class="input-group-addon" style="background: #F8FAFC; border-color: #CBD5E1; color: #64748B;"><i class="fa fa-clock"></i></span>
                                {!! Form::number('trial_days', $packages->trial_days, ['class' => 'form-control', 'required', 'min' => 0, 'style' => 'border-color: #CBD5E1; border-radius: 0 8px 8px 0; height: 40px; font-weight: 700;']) !!}
                            </div>
                            <small class="text-muted" style="font-size: 11px;">0 = Sin período de prueba.</small>
                        </div>
                    </div>
                </div>

                <!-- 5. ESTADO Y VISIBILIDAD -->
                <div class="box box-solid" style="border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 24px; overflow: hidden;">
                    <div class="box-header with-border" style="background: #F8FAFC; padding: 16px 20px; border-bottom: 1px solid #E2E8F0;">
                        <h3 class="box-title" style="font-size: 16px; font-weight: 700; color: #1E293B; display: flex; align-items: center; gap: 8px;">
                            <i class="fa fa-cog text-secondary"></i> 5. Visibilidad y Reglas
                        </h3>
                    </div>
                    <div class="box-body" style="padding: 20px;">
                        <!-- Activo -->
                        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 10px 14px; margin-bottom: 10px;">
                            <div class="checkbox" style="margin: 0;">
                                <label style="font-weight: 700; color: #1E293B; font-size: 13px; cursor: pointer; padding-left: 0;">
                                    {!! Form::checkbox('is_active', 1, $packages->is_active, ['class' => 'input-icheck']) !!}
                                    <span style="margin-left: 6px;">Paquete Activo para Venta</span>
                                </label>
                            </div>
                        </div>

                        <!-- Popular -->
                        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 10px 14px; margin-bottom: 10px;">
                            <div class="checkbox" style="margin: 0;">
                                <label style="font-weight: 600; color: #1E293B; font-size: 13px; cursor: pointer; padding-left: 0;">
                                    {!! Form::checkbox('mark_package_as_popular', 1, $packages->mark_package_as_popular, ['class' => 'input-icheck']) !!}
                                    <span style="margin-left: 6px;"><i class="fa fa-star text-warning"></i> Marcar como Plan Popular</span>
                                </label>
                            </div>
                        </div>

                        <!-- Privado -->
                        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 10px 14px; margin-bottom: 10px;">
                            <div class="checkbox" style="margin: 0;">
                                <label style="font-weight: 600; color: #1E293B; font-size: 13px; cursor: pointer; padding-left: 0;">
                                    {!! Form::checkbox('is_private', 1, $packages->is_private, ['class' => 'input-icheck']) !!}
                                    <span style="margin-left: 6px;"><i class="fa fa-lock text-muted"></i> Privado (Solo Superadmin)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Solo una vez -->
                        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 10px 14px; margin-bottom: 14px;">
                            <div class="checkbox" style="margin: 0;">
                                <label style="font-weight: 600; color: #1E293B; font-size: 13px; cursor: pointer; padding-left: 0;">
                                    {!! Form::checkbox('is_one_time', 1, $packages->is_one_time, ['class' => 'input-icheck']) !!}
                                    <span style="margin-left: 6px;"><i class="fa fa-hand-paper text-muted"></i> Contratable una sola vez</span>
                                </label>
                            </div>
                        </div>

                        <!-- Exclusivo para empresas -->
                        <div class="form-group" style="margin-bottom: 14px;">
                            {!! Form::label('businesses', 'Exclusivo para Empresas Específicas:', ['style' => 'font-weight: 700; color: #334155; font-size: 12px;']) !!}
                            @show_tooltip(__('superadmin::lang.tooltip_only_for_businesses'))
                            {!! Form::select('businesses[]', $businesses, json_decode($packages->businesses), [
                                'class' => 'form-control select2',
                                'multiple',
                                'style' => 'width: 100%;',
                                'data-placeholder' => 'Visible para todos si está vacío',
                            ]) !!}
                        </div>

                        <!-- Enlace Personalizado -->
                        <div style="border-top: 1px dashed #E2E8F0; padding-top: 12px;">
                            <div class="checkbox" style="margin: 0 0 10px 0;">
                                <label style="font-weight: 600; color: #334155; font-size: 12px; cursor: pointer; padding-left: 0;">
                                    {!! Form::checkbox('enable_custom_link', 1, $packages->enable_custom_link, [
                                        'class' => 'input-icheck',
                                        'id' => 'enable_custom_link',
                                    ]) !!}
                                    <span style="margin-left: 6px;">Redireccionar botón a enlace externo</span>
                                </label>
                            </div>

                            <div id="custom_link_div" @if (empty($packages->enable_custom_link)) class="hide" @endif>
                                <div class="form-group" style="margin-bottom: 10px;">
                                    {!! Form::text('custom_link', $packages->custom_link, ['class' => 'form-control input-sm', 'placeholder' => 'URL (Ej: https://wa.me/...)', 'style' => 'border-radius: 6px;']) !!}
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    {!! Form::text('custom_link_text', $packages->custom_link_text, ['class' => 'form-control input-sm', 'placeholder' => 'Texto del Botón (Ej: Contactar Ventas)', 'style' => 'border-radius: 6px;']) !!}
                                </div>
                            </div>
                        </div>

                        <!-- Actualizar Suscripciones Existentes -->
                        <div style="background: #FEF3C7; border: 1px solid #FCD34D; border-radius: 10px; padding: 12px; margin-top: 16px;">
                            <div class="checkbox" style="margin: 0;">
                                <label style="font-weight: 700; color: #92400E; font-size: 12px; cursor: pointer; padding-left: 0;">
                                    {!! Form::checkbox('update_subscriptions', 1, false, ['class' => 'input-icheck']) !!}
                                    <span style="margin-left: 6px;">Sincronizar cambios con clientes activos</span>
                                </label>
                            </div>
                            <p style="color: #B45309; font-size: 11px; margin: 4px 0 0 20px; line-height: 1.3;">
                                Si se marca, los negocios actualmente suscritos a este plan recibirán estos nuevos límites y módulos de inmediato.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                    <button type="submit" class="btn btn-primary btn-block btn-lg" style="border-radius: 10px; font-weight: 700; font-size: 15px; padding: 12px; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);">
                        <i class="fa fa-save" style="margin-right: 8px;"></i> Guardar Cambios
                    </button>
                    <a href="{{ action([\Modules\Superadmin\Http\Controllers\PackagesController::class, 'index']) }}" class="btn btn-default btn-block" style="border-radius: 10px; font-weight: 600; margin-top: 10px; border-color: #E2E8F0; color: #64748B;">
                        Cancelar
                    </a>
                </div>

            </div>
        </div>

        {!! Form::close() !!}
    </section>
@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('form#edit_package_form').validate();

            $('#enable_custom_link').on('ifChecked', function(event) {
                $("div#custom_link_div").removeClass('hide');
            });
            $('#enable_custom_link').on('ifUnchecked', function(event) {
                $("div#custom_link_div").addClass('hide');
            });
        });
    </script>
@endsection
