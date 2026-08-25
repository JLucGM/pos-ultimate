@extends('superadmin::layouts.landing')
@section('title', 'Kubre | Sistema de Gestión Comercial y Punto de Venta en la Nube')
@section('meta_description', 'Descubre Kubre: software POS y gestión en la nube con ventas rápidas, inventario multialmacén, control de caja y tasas de cambio en tiempo real. 14 días de prueba gratis.')
@section('meta_keywords', 'software pos venezuela, sistema punto de venta, inventario en la nube, facturacion multimoneda, kubre pos, pos restaurantes, pos retail')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <div class="hero-text">
            <div class="auth-pill-badge" data-aos="fade-down" style="margin-bottom: 20px;">
                <span class="auth-pill-dot"></span>
                <span>Nuevo: Facturación & Gestión Multimoneda en Vivo</span>
            </div>

            <h1 class="hero-title" data-aos="fade-up">
                Impulsa tu Negocio con <span class="text-gradient">Kubre</span>: Todo en Uno
            </h1>
            <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="100">
                Controla ventas en segundos, inventario multialmacén, tasas de cambio dinámicas y finanzas desde cualquier dispositivo. La suite definitiva para comercios, restaurantes, mayoristas y empresas.
            </p>
            <div class="hero-buttons" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('business.getRegister') }}" class="btn btn-accent btn-lg">
                    <i class="fas fa-rocket"></i> Prueba Gratis 14 Días
                </a>
                <a href="{{ route('pricing') }}" class="btn btn-outline-white btn-lg">
                    <i class="fas fa-tags"></i> Ver Planes y Precios
                </a>
                <a href="#features" class="btn btn-outline-white btn-lg">
                    <i class="fas fa-sparkles"></i> Módulos
                </a>
            </div>
            <div class="hero-stats" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Empresas Activas</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50K+</div>
                    <div class="stat-label">Ventas / Mes</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">99.9%</div>
                    <div class="stat-label">Uptime Garantizado</div>
                </div>
            </div>
        </div>
        <div class="hero-image" data-aos="fade-left" data-aos-delay="400">
            <img src="{{ asset('images/landing/dashboard-preview.png') }}" alt="Dashboard Preview" class="dashboard-img" onerror="this.style.display='none'">
            <div class="floating-card card-1">
                <i class="fas fa-coins" style="color: #10B981;"></i>
                <span>Tasa Multimoneda en Vivo</span>
            </div>
            <div class="floating-card card-2">
                <i class="fas fa-bolt" style="color: #6366F1;"></i>
                <span>Sistema de Venta Rápido</span>
            </div>
            <div class="floating-card card-3">
                <i class="fas fa-boxes" style="color: #F59E0B;"></i>
                <span>Inventario en Tiempo Real</span>
            </div>
            <div class="floating-card card-4">
                <i class="fas fa-chart-line" style="color: #EC4899;"></i>
                <span>Reportes de Ganancias</span>
            </div>
        </div>
    </div>
</section>

<!-- Soluciones por Organización Showcase -->
<section class="section solutions-showcase-section" id="solutions" style="background: #0B0F1D; padding: 80px 0; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge" style="background: rgba(251, 76, 10, 0.15); color: #FB4C0A; border-color: rgba(251, 76, 10, 0.3);">Organizaciones & Nichos</span>
            <h2 class="section-title">Soluciones Especializadas para Tu Tipo de Negocio</h2>
            <p class="section-subtitle">No importa si vendes comida, ropa, al mayor, fabricas productos o agendas citas. Kubre se adapta a tu modelo operativo.</p>
        </div>

        <!-- Solutions Tabs Buttons -->
        <div class="solution-tabs-nav" data-aos="fade-up">
            <button type="button" class="solution-tab-btn active" data-target="#tab-restaurantes">
                <i class="fas fa-utensils" style="color: #FB4C0A;"></i> Restaurantes
            </button>
            <button type="button" class="solution-tab-btn" data-target="#tab-retail">
                <i class="fas fa-shopping-bag" style="color: #6366F1;"></i> Retail & Tiendas
            </button>
            <button type="button" class="solution-tab-btn" data-target="#tab-mayoristas">
                <i class="fas fa-boxes" style="color: #10B981;"></i> Mayoristas
            </button>
            <button type="button" class="solution-tab-btn" data-target="#tab-fabricas">
                <i class="fas fa-industry" style="color: #EC4899;"></i> Fábricas
            </button>
            <button type="button" class="solution-tab-btn" data-target="#tab-belleza">
                <i class="fas fa-cut" style="color: #F59E0B;"></i> Salones & Barberías
            </button>
        </div>

        <!-- Solutions Tab Panes Content -->
        <div class="solution-tabs-content" data-aos="fade-up">
            <!-- 1. Restaurantes -->
            <div class="solution-tab-pane active" id="tab-restaurantes">
                <div class="solution-tab-grid">
                    <div class="solution-tab-info">
                        <span class="solution-tab-badge" style="color: #FB4C0A; background: rgba(251, 76, 10, 0.15);">Gastronomía & Bares</span>
                        <h3 class="solution-tab-heading">Agiliza la cocina y llena tu salón sin demoras ni errores</h3>
                        <p class="solution-tab-paragraph">Comandas directas a cocina (KDS), mapa de mesas en tiempo real, división de cuentas entre amigos y propinas automáticas.</p>
                        <ul class="solution-tab-bullets">
                            <li><i class="fas fa-check-circle" style="color: #FB4C0A;"></i> Pantalla de cocina (KDS) digital sin papelitos perdidos.</li>
                            <li><i class="fas fa-check-circle" style="color: #FB4C0A;"></i> Mapa de mesas interactivo (Ocupadas, Libres, Por cobrar).</li>
                            <li><i class="fas fa-check-circle" style="color: #FB4C0A;"></i> Recetas y descuento automático de insumos en inventario.</li>
                        </ul>
                        <div class="solution-tab-actions">
                            <a href="{{ route('landing.solution', 'restaurantes') }}" class="btn btn-primary">
                                Conocer Solución Restaurantes <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="solution-tab-visual">
                        <div class="solution-card-mockup" style="border-color: rgba(251, 76, 10, 0.3);">
                            <div class="mockup-header" style="background: rgba(251, 76, 10, 0.1);">
                                <i class="fas fa-utensils" style="color: #FB4C0A;"></i>
                                <span>Pantalla de Comandas & Mesas</span>
                            </div>
                            <div class="mockup-body">
                                <div class="mockup-item"><span>Mesa 4 • Terraza</span><span class="badge" style="background: #10B981; color:#fff;">2 Platos Listos</span></div>
                                <div class="mockup-item"><span>Mesa 12 • Salón Principal</span><span class="badge" style="background: #F59E0B; color:#fff;">En Preparación</span></div>
                                <div class="mockup-item"><span>Mesa 7 • Barra VIP</span><span class="badge" style="background: #FB4C0A; color:#fff;">Por Cobrar $48.50</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Retail & Tiendas -->
            <div class="solution-tab-pane" id="tab-retail">
                <div class="solution-tab-grid">
                    <div class="solution-tab-info">
                        <span class="solution-tab-badge" style="color: #6366F1; background: rgba(99, 102, 241, 0.15);">Comercio & Retail</span>
                        <h3 class="solution-tab-heading">Ventas en 3 segundos con código de barras y multimoneda</h3>
                        <p class="solution-tab-paragraph">Control de existencias por variantes de talla/color, alertas de bajo inventario y tienda online sincronizada con WooCommerce.</p>
                        <ul class="solution-tab-bullets">
                            <li><i class="fas fa-check-circle" style="color: #6366F1;"></i> Lector de barras, tickets térmicos e impresión de etiquetas.</li>
                            <li><i class="fas fa-check-circle" style="color: #6366F1;"></i> Sincronización en vivo con tu tienda online WooCommerce.</li>
                            <li><i class="fas fa-check-circle" style="color: #6366F1;"></i> Multi-cajas con turnos y arqueos ciegos por cajero.</li>
                        </ul>
                        <div class="solution-tab-actions">
                            <a href="{{ route('landing.solution', 'retail') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%);">
                                Conocer Solución Retail <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="solution-tab-visual">
                        <div class="solution-card-mockup" style="border-color: rgba(99, 102, 241, 0.3);">
                            <div class="mockup-header" style="background: rgba(99, 102, 241, 0.1);">
                                <i class="fas fa-barcode" style="color: #6366F1;"></i>
                                <span>Punto de Venta Retail</span>
                            </div>
                            <div class="mockup-body">
                                <div class="mockup-item"><span>Zapato Deportivo (Talla 42)</span><span class="badge" style="background: #6366F1; color:#fff;">Stock: 18 und</span></div>
                                <div class="mockup-item"><span>Camisa Polo Slim (Negro - M)</span><span class="badge" style="background: #10B981; color:#fff;">WooCommerce Sync</span></div>
                                <div class="mockup-item"><span>Tasa del Día (USD/VES)</span><span class="badge" style="background: #0B0F1D; color:#10B981; border: 1px solid #10B981;">En Vivo</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Mayoristas -->
            <div class="solution-tab-pane" id="tab-mayoristas">
                <div class="solution-tab-grid">
                    <div class="solution-tab-info">
                        <span class="solution-tab-badge" style="color: #10B981; background: rgba(16, 185, 129, 0.15);">Mayoristas & Distribuidoras</span>
                        <h3 class="solution-tab-heading">Control multialmacén, cotizaciones y cuentas por cobrar</h3>
                        <p class="solution-tab-paragraph">Diseñado para mover alto volumen de mercancía, compras a crédito, listas de precios diferenciadas y transferencias entre depósitos.</p>
                        <ul class="solution-tab-bullets">
                            <li><i class="fas fa-check-circle" style="color: #10B981;"></i> Reportes de cartera y seguimiento de Cuentas por Cobrar.</li>
                            <li><i class="fas fa-check-circle" style="color: #10B981;"></i> Listas de precios personalizadas (Mayor, Detal, Distribuidor).</li>
                            <li><i class="fas fa-check-circle" style="color: #10B981;"></i> Cotizaciones membretadas convertibles a factura en 1 clic.</li>
                        </ul>
                        <div class="solution-tab-actions">
                            <a href="{{ route('landing.solution', 'mayoristas') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
                                Conocer Solución Mayoristas <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="solution-tab-visual">
                        <div class="solution-card-mockup" style="border-color: rgba(16, 185, 129, 0.3);">
                            <div class="mockup-header" style="background: rgba(16, 185, 129, 0.1);">
                                <i class="fas fa-warehouse" style="color: #10B981;"></i>
                                <span>Logística & Cartera</span>
                            </div>
                            <div class="mockup-body">
                                <div class="mockup-item"><span>Almacén Central ➔ Sucursal Norte</span><span class="badge" style="background: #10B981; color:#fff;">Despachado</span></div>
                                <div class="mockup-item"><span>Distribuidora Los Andes C.A.</span><span class="badge" style="background: #F59E0B; color:#fff;">Crédito 15 días</span></div>
                                <div class="mockup-item"><span>Cotización #COT-2041</span><span class="badge" style="background: #6366F1; color:#fff;">Aprobada $3,450</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Fábricas -->
            <div class="solution-tab-pane" id="tab-fabricas">
                <div class="solution-tab-grid">
                    <div class="solution-tab-info">
                        <span class="solution-tab-badge" style="color: #EC4899; background: rgba(236, 72, 153, 0.15);">Fábricas & Manufactura</span>
                        <h3 class="solution-tab-heading">Fórmulas, recetas y costeo de producción exacto</h3>
                        <p class="solution-tab-paragraph">Gestiona órdenes de producción que transforman materias primas en productos terminados, costeando mano de obra y mermas.</p>
                        <ul class="solution-tab-bullets">
                            <li><i class="fas fa-check-circle" style="color: #EC4899;"></i> Fórmulas de insumos con cálculo automático de costos.</li>
                            <li><i class="fas fa-check-circle" style="color: #EC4899;"></i> Órdenes de fabricación por lote con auto-descuento de stock.</li>
                            <li><i class="fas fa-check-circle" style="color: #EC4899;"></i> Control riguroso de desperdicios y mermas productivas.</li>
                        </ul>
                        <div class="solution-tab-actions">
                            <a href="{{ route('landing.solution', 'fabricas') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #EC4899 0%, #DB2777 100%);">
                                Conocer Solución Fábricas <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="solution-tab-visual">
                        <div class="solution-card-mockup" style="border-color: rgba(236, 72, 153, 0.3);">
                            <div class="mockup-header" style="background: rgba(236, 72, 153, 0.1);">
                                <i class="fas fa-industry" style="color: #EC4899;"></i>
                                <span>Producción & Manufactura</span>
                            </div>
                            <div class="mockup-body">
                                <div class="mockup-item"><span>Lote #LOT-892 (500 galones)</span><span class="badge" style="background: #10B981; color:#fff;">Finalizado</span></div>
                                <div class="mockup-item"><span>Insumos Consumidos</span><span class="badge" style="background: #EC4899; color:#fff;">Descontados</span></div>
                                <div class="mockup-item"><span>Costo Unitario Real</span><span class="badge" style="background: #0B0F1D; color:#EC4899; border: 1px solid #EC4899;">$4.12 / und</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Belleza & Barberías -->
            <div class="solution-tab-pane" id="tab-belleza">
                <div class="solution-tab-grid">
                    <div class="solution-tab-info">
                        <span class="solution-tab-badge" style="color: #F59E0B; background: rgba(245, 158, 11, 0.15);">Salones & Barberías</span>
                        <h3 class="solution-tab-heading">Agenda de citas, comisiones del staff y cobro integrado</h3>
                        <p class="solution-tab-paragraph">Permite a tus estilistas o barberos gestionar su agenda de citas, calcula comisiones por servicio y vende productos en un solo ticket.</p>
                        <ul class="solution-tab-bullets">
                            <li><i class="fas fa-check-circle" style="color: #F59E0B;"></i> Módulo interactivo de Citas & Reservas por profesional.</li>
                            <li><i class="fas fa-check-circle" style="color: #F59E0B;"></i> Cálculo automático de comisiones por corte, tinte o servicio.</li>
                            <li><i class="fas fa-check-circle" style="color: #F59E0B;"></i> Venta de ceras, champús y tratamientos en el mismo POS.</li>
                        </ul>
                        <div class="solution-tab-actions">
                            <a href="{{ route('landing.solution', 'belleza-spa') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);">
                                Conocer Solución Belleza & Citas <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="solution-tab-visual">
                        <div class="solution-card-mockup" style="border-color: rgba(245, 158, 11, 0.3);">
                            <div class="mockup-header" style="background: rgba(245, 158, 11, 0.1);">
                                <i class="fas fa-cut" style="color: #F59E0B;"></i>
                                <span>Agenda de Citas & Staff</span>
                            </div>
                            <div class="mockup-body">
                                <div class="mockup-item"><span>Corte & Barba • Carlos (Barbero 1)</span><span class="badge" style="background: #10B981; color:#fff;">3:30 PM - Confirmada</span></div>
                                <div class="mockup-item"><span>Balayage & Peinado • Sofia (Estilista)</span><span class="badge" style="background: #F59E0B; color:#fff;">5:00 PM - En Proceso</span></div>
                                <div class="mockup-item"><span>Comisión Acumulada del Día</span><span class="badge" style="background: #0B0F1D; color:#F59E0B; border: 1px solid #F59E0B;">$85.00</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="features-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Características</span>
            <h2 class="section-title">Todo lo que Necesitas para Gestionar tu Negocio</h2>
            <p class="section-subtitle">Un sistema completo diseñado para pequeñas y medianas empresas</p>
        </div>

        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="0">
                <div class="feature-icon bg-blue">
                    <i class="fas fa-cash-register"></i>
                </div>
                <h3>Sistema de Ventas Rápido</h3>
                <p>Interfaz intuitiva para procesar ventas en segundos. Soporte para múltiples métodos de pago.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon bg-green">
                    <i class="fas fa-boxes"></i>
                </div>
                <h3>Gestión de Inventario</h3>
                <p>Control total de stock, alertas de bajo inventario, transferencias entre sucursales.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon bg-purple">
                    <i class="fas fa-users"></i>
                </div>
                <h3>CRM de Clientes</h3>
                <p>Gestiona clientes, historial de compras, programas de lealtad y grupos personalizados.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="0">
                <div class="feature-icon bg-orange">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3>Reportes Avanzados</h3>
                <p>Análisis de ventas, Productos más vendidos, reportes financieros y gráficos en tiempo real.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon bg-red">
                    <i class="fas fa-store-alt"></i>
                </div>
                <h3>Multi-Sucursal</h3>
                <p>Gestiona múltiples ubicaciones desde un solo panel. Transferencias y reportes consolidados.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon bg-teal">
                    <i class="fas fa-utensils"></i>
                </div>
                <h3>Módulo Restaurante</h3>
                <p>Gestión de mesas, comandas de cocina, modificadores y Producto de meseros.</p>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="benefits-section">
    <div class="container">
        <div class="benefits-content">
            <div class="benefits-image" data-aos="fade-right">
                <img src="{{ asset('images/landing/pos-interface.png') }}" alt="POS Interface">
            </div>
            <div class="benefits-text" data-aos="fade-left">
                <span class="section-badge">Beneficios</span>
                <h2>¿Por Qué Elegir Kubre?</h2>
                <ul class="benefits-list">
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <strong>Fácil de Usar</strong>
                            <p>Interfaz intuitiva que tu equipo aprenderá en minutos</p>
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <strong>Acceso desde Cualquier Lugar</strong>
                            <p>Sistema en la nube accesible desde cualquier dispositivo</p>
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <strong>Soporte en Español</strong>
                            <p>Equipo de soporte disponible para ayudarte cuando lo necesites</p>
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <strong>Actualizaciones Constantes</strong>
                            <p>Nuevas funcionalidades y mejoras incluidas en tu suscripción</p>
                        </div>
                    </li>
                </ul>
                <a href="{{ route('pricing') }}" class="btn btn-accent btn-lg">
                    Comenzar Ahora <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Preview -->
<section class="pricing-preview-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Planes</span>
            <h2 class="section-title">Planes Flexibles para tu Negocio</h2>
            <p class="section-subtitle">Elige el plan que mejor se adapte a tus necesidades</p>
        </div>

        <div class="pricing-cards">
            @forelse($packages as $package)
            <div class="pricing-card {{ $package->is_popular ? 'featured' : '' }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                @if($package->is_popular)
                <div class="popular-badge"><i class="fas fa-star"></i> Más Popular</div>
                @endif
                <div class="pricing-header">
                    <h3>{{ $package->name }}</h3>
                    <div class="price">
                        <span class="currency">{{ $package->currency }}</span>
                        <span class="amount">{{ number_format($package->price, 2) }}</span>
                        <span class="period">/{{ $package->interval == 'months' ? 'mes' : ($package->interval == 'years' ? 'año' : ($package->interval == 'days' ? 'días' : $package->interval)) }}</span>
                    </div>
                </div>
                <ul class="pricing-features">
                    @if($package->location_count == 0)
                        <li><i class="fas fa-check"></i> <strong>Sucursales Ilimitadas</strong></li>
                    @else
                        <li><i class="fas fa-check"></i> <strong>{{ $package->location_count }}</strong> {{ $package->location_count == 1 ? 'Sucursal' : 'Sucursales' }}</li>
                    @endif

                    @if($package->user_count == 0)
                        <li><i class="fas fa-check"></i> <strong>Usuarios Ilimitados</strong></li>
                    @else
                        <li><i class="fas fa-check"></i> <strong>{{ $package->user_count }}</strong> {{ $package->user_count == 1 ? 'Usuario' : 'Usuarios' }}</li>
                    @endif

                    @if($package->product_count == 0)
                        <li><i class="fas fa-check"></i> <strong>Productos Ilimitados</strong></li>
                    @else
                        <li><i class="fas fa-check"></i> Hasta <strong>{{ number_format($package->product_count) }}</strong> Productos</li>
                    @endif

                    @if($package->invoice_count == 0)
                        <li><i class="fas fa-check"></i> <strong>Facturas Ilimitadas</strong></li>
                    @else
                        <li><i class="fas fa-check"></i> Hasta <strong>{{ number_format($package->invoice_count) }}</strong> Facturas/mes</li>
                    @endif

                    @if(!empty($package->bookings))
                        <li><i class="fas fa-check"></i> Módulo Citas / Reservas</li>
                    @endif

                    @if(!empty($package->kitchen))
                        <li><i class="fas fa-check"></i> Pantalla de Cocina (KDS)</li>
                    @endif

                    @if(!empty($package->tables))
                        <li><i class="fas fa-check"></i> Gestión de Mesas</li>
                    @endif

                    @if(!empty($package->custom_permissions))
                        @php $perm_count = 0; @endphp
                        @foreach($package->custom_permissions as $permission => $value)
                            @if($value == 1 && isset($permission_formatted[$permission]) && $perm_count < 2)
                                <li><i class="fas fa-check"></i> {{ $permission_formatted[$permission] }}</li>
                                @php $perm_count++; @endphp
                            @endif
                        @endforeach
                    @endif
                </ul>
                <a href="{{ route('pricing') }}" class="btn {{ $package->is_popular ? 'btn-primary' : 'btn-outline' }}">
                    <span>{{ $package->is_popular ? 'Comenzar Ahora' : 'Seleccionar Plan' }}</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @empty
            <div class="tw-col-span-3 tw-text-center tw-py-12 tw-text-slate-400">
                <p>No hay planes públicos configurados en el sistema.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section id="testimonials" class="testimonials-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Testimonios</span>
            <h2 class="section-title">Lo Que Dicen Nuestros Clientes</h2>
        </div>

        <div class="testimonials-grid">
            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="0">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p>"Excelente sistema, fácil de usar y con todas las funciones que necesitamos. El soporte es muy rápido."</p>
                <div class="testimonial-author">
                    <img src="{{ asset('images/landing/avatar1.jpg') }}" alt="María González">
                    <div>
                        <strong>María González</strong>
                        <span>Dueña, Café Central</span>
                    </div>
                </div>
            </div>

            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p>"Desde que implementamos este POS, nuestras ventas aumentaron 30%. Los reportes son increíbles."</p>
                <div class="testimonial-author">
                    <img src="{{ asset('images/landing/avatar2.jpg') }}" alt="Carlos Ruiz">
                    <div>
                        <strong>Carlos Ruiz</strong>
                        <span>Gerente, Tienda Fashion</span>
                    </div>
                </div>
            </div>

            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p>"Perfecto para nuestro restaurante. La gestión de mesas y comandas es muy eficiente."</p>
                <div class="testimonial-author">
                    <img src="{{ asset('images/landing/avatar3.jpg') }}" alt="Ana Martínez">
                    <div>
                        <strong>Ana Martínez</strong>
                        <span>Propietaria, Restaurante El Sabor</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section id="faq" class="faq-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">FAQ</span>
            <h2 class="section-title">Preguntas Frecuentes</h2>
        </div>

        <div class="faq-container" data-aos="fade-up" data-aos-delay="100">
            <div class="faq-item">
                <div class="faq-question">
                    <h4>¿Necesito instalar algún software?</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>No, nuestro sistema es 100% en la nube. Solo necesitas un navegador web y conexión a internet para acceder desde cualquier dispositivo.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h4>¿Puedo cambiar de plan en cualquier momento?</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Sí, puedes actualizar o cambiar tu plan en cualquier momento. Los cambios se aplican inmediatamente y solo pagas la diferencia prorrateada.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h4>¿Ofrecen período de prueba?</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Sí, todos nuestros planes incluyen 14 días de prueba gratuita. No se requiere tarjeta de crédito para comenzar.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h4>¿Qué métodos de pago aceptan?</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Aceptamos tarjetas de crédito/débito, PayPal, transferencias bancarias y otros métodos de pago locales.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h4>¿Mis datos están seguros?</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Absolutamente. Utilizamos encriptación SSL, backups diarios automáticos y cumplimos con los estándares de seguridad más altos.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h4>¿Ofrecen capacitación?</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Sí, incluimos videos tutoriales, documentación completa y sesiones de capacitación en vivo para planes Profesional y Empresarial.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content" data-aos="zoom-in">
            <h2>¿Listo para Transformar tu Negocio?</h2>
            <p>Únete a cientos de empresas que ya confían en nuestro sistema POS</p>
            <div class="cta-buttons">
                <a href="{{ route('business.getRegister') }}" class="btn btn-white btn-lg">
                    <i class="fas fa-rocket"></i> Comenzar Prueba Gratuita (14 Días)
                </a>
                <a href="{{ route('pricing') }}" class="btn btn-outline-white btn-lg">
                    <i class="fas fa-tags"></i> Ver Todos los Planes
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')
<script>
// Esperar a que TODO esté cargado
window.addEventListener('load', function() {
    // FAQ Accordion
    var faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(function(question) {
        question.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var item = this.parentElement;
            var wasActive = item.classList.contains('active');
            
            // Cerrar todos los items primero
            document.querySelectorAll('.faq-item').forEach(function(i) {
                i.classList.remove('active');
            });
            
            // Abrir el clickeado SOLO si NO estaba activo
            if (!wasActive) {
                item.classList.add('active');
            }
        });
    });
    
    // Smooth scroll para links internos
    var internalLinks = document.querySelectorAll('a[href^="#"]');
    
    internalLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            var href = this.getAttribute('href');
            
            // Ignorar # vacío
            if (href === '#' || href === '#!') {
                e.preventDefault();
                return;
            }
            
            var target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                var offsetTop = target.getBoundingClientRect().top + window.pageYOffset - 80;
                
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Soluciones Tabs Switcher
    var solutionBtns = document.querySelectorAll('.solution-tab-btn');
    var solutionPanes = document.querySelectorAll('.solution-tab-pane');
    
    solutionBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var targetId = this.getAttribute('data-target');
            var targetPane = document.querySelector(targetId);
            
            if (targetPane) {
                solutionBtns.forEach(function(b) { b.classList.remove('active'); });
                this.classList.add('active');
                
                solutionPanes.forEach(function(p) { p.classList.remove('active'); });
                targetPane.classList.add('active');
            }
        });
    });
});
</script>
@endsection
