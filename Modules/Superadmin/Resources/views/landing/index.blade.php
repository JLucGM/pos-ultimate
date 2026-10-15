@extends('superadmin::layouts.landing')
@section('title', 'Kubre | Plataforma de Gestión Empresarial y Control en la Nube')
@section('meta_description', 'Centraliza finanzas, inventario multialmacén, operaciones multisede, facturación multimoneda y ventas en una sola plataforma inteligente. 14 días de prueba gratis.')
@section('meta_keywords', 'software de gestion empresarial, erp en la nube, plataforma de administracion comercial, control de inventario multialmacen, facturacion multimoneda, cuentas por cobrar, gestion de compras, kubre, kubre erp')
@section('og_title', 'Kubre | Plataforma Todo-en-Uno de Gestión Empresarial')
@section('og_description', 'Toma el control total de tu empresa: finanzas en tiempo real, inventario multialmacén, producción, compras y facturación multimoneda.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <!-- Minimalist Top Brand Header (Anchors the top of the page) -->
        <header class="hero-top-bar" data-aos="fade-down">
            <a href="/" class="hero-brand-link">
                <img src="{{ asset('img/logo_v2_full.png') }}" alt="{{ config('app.name', 'Kubre') }}" class="hero-brand-logo">
                <span class="hero-status-pill">
                    <span class="hero-status-dot"></span>
                    <span>Kubre Cloud &bull; v{{ config('author.app_version', '2.5') }}</span>
                </span>
            </a>
            <div class="hero-top-actions">
                <a href="{{ route('login') }}" class="btn-hero-login">
                    <i class="fas fa-arrow-right-to-bracket"></i>
                    <span>Acceso Clientes</span>
                </a>
            </div>
        </header>

        <div class="hero-content">
            <div class="hero-text">
            <div class="auth-pill-badge" data-aos="fade-down" style="margin-bottom: 20px;">
                <span class="auth-pill-dot"></span>
                <span>Plataforma de Control Operativo y Financiero en Vivo</span>
            </div>

            <h1 class="hero-title" data-aos="fade-up">
                Toma el Control de tu Empresa: <span class="text-gradient">Ventas, Inventario y Finanzas</span> sin Fugas de Dinero
            </h1>
            <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="100">
                El sistema integral en la nube con facturación multimoneda en vivo, inventario multialmacén y analítica en tiempo real. Diseñado para comercios, mayoristas, restaurantes y fábricas que buscan crecer con orden y rentabilidad.
            </p>
            <div class="hero-buttons" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('business.getRegister') }}" class="btn btn-accent btn-lg">
                    <i class="fas fa-arrow-right"></i> Prueba Gratis 14 Días
                </a>
                <a href="https://wa.me/584242909870?text=Hola,%20deseo%20una%20demostraci%C3%B3n%20guiada%20de%20Kubre%20para%20mi%20empresa" target="_blank" rel="noopener" class="btn btn-outline-white btn-lg btn-whatsapp-hero">
                    <i class="fab fa-whatsapp"></i> Hablar con un Asesor
                </a>
            </div>

            <div class="hero-trust-bar" data-aos="fade-up" data-aos-delay="250">
                <div class="trust-badge-item">
                    <span class="trust-icon-box success"><i class="fas fa-shield-halved"></i></span>
                    <span>14 días gratis &bull; Sin tarjeta</span>
                </div>
                <div class="trust-badge-item">
                    <span class="trust-icon-box warning"><i class="fas fa-bolt"></i></span>
                    <span>Activación inmediata en la nube</span>
                </div>
                <div class="trust-badge-item">
                    <span class="trust-icon-box primary"><i class="fas fa-headset"></i></span>
                    <span>Soporte prioritario en español</span>
                </div>
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
            <div class="hero-image-frame" style="position: relative; border-radius: 24px; overflow: hidden; box-shadow: 0 30px 70px rgba(0,0,0,0.65); border: 1px solid rgba(255,255,255,0.14);">
                <img src="{{ asset('images/landing/Capture_dashboard.jpg') }}" alt="Kubre OS Dashboard Principal" class="dashboard-img" onerror="this.src='{{ asset('images/landing/dashboard-preview.png') }}'">
            </div>
            <div class="floating-card card-1" style="display: flex; align-items: center; gap: 12px; padding: 12px 18px; border-radius: 16px;">
                <span class="kubre-micro-icon emerald"><i class="fas fa-coins"></i></span>
                <div>
                    <div style="font-size: 11px; color: #94A3B8; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Multimoneda</div>
                    <span style="font-size: 14px; font-weight: 700; color: #FFFFFF;">Tasa Oficial en Vivo</span>
                </div>
            </div>
            <div class="floating-card card-2" style="display: flex; align-items: center; gap: 12px; padding: 12px 18px; border-radius: 16px;">
                <span class="kubre-micro-icon indigo"><i class="fas fa-layer-group"></i></span>
                <div>
                    <div style="font-size: 11px; color: #94A3B8; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Multialmacén</div>
                    <span style="font-size: 14px; font-weight: 700; color: #FFFFFF;">Stock en Tiempo Real</span>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- Impact Highlights / 4 Value Pillars Section -->
<section class="impact-highlights-section">
    <div class="container">
        <div class="impact-highlights-grid">
            <div class="impact-highlight-card" data-aos="fade-up" data-aos-delay="0">
                <span class="impact-icon-circle coral"><i class="fas fa-scale-balanced"></i></span>
                <h3 class="impact-highlight-title">Cero Errores Multimoneda</h3>
                <p class="impact-highlight-desc">Cobra en dólares, euros o moneda local con conversión exacta en cada ticket según la tasa oficial o personalizada del día.</p>
            </div>
            <div class="impact-highlight-card" data-aos="fade-up" data-aos-delay="100">
                <span class="impact-icon-circle indigo"><i class="fas fa-boxes-stacked"></i></span>
                <h3 class="impact-highlight-title">Inventario Multialmacén Blindado</h3>
                <p class="impact-highlight-desc">Evita quiebres de stock y mermas invisibles. Monitorea transferencias, lotes y existencias en tiempo real entre todas tus sedes.</p>
            </div>
            <div class="impact-highlight-card" data-aos="fade-up" data-aos-delay="200">
                <span class="impact-icon-circle emerald"><i class="fas fa-money-bill-transfer"></i></span>
                <h3 class="impact-highlight-title">Control de Créditos y Cobranzas</h3>
                <p class="impact-highlight-desc">Seguimiento riguroso de cuentas por cobrar, límites de crédito por cliente, arqueos ciegos por cajero y balances de utilidad neta.</p>
            </div>
            <div class="impact-highlight-card" data-aos="fade-up" data-aos-delay="300">
                <span class="impact-icon-circle cyan"><i class="fas fa-cloud-arrow-up"></i></span>
                <h3 class="impact-highlight-title">100% en la Nube y Siempre Seguro</h3>
                <p class="impact-highlight-desc">Accede a tus operaciones desde computadoras, tablets o teléfonos. Respaldos automáticos diarios y soporte técnico humano.</p>
            </div>
        </div>
    </div>
</section>

<!-- Soluciones por Organización Showcase -->
<section class="section solutions-showcase-section" id="solutions">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Organizaciones & Nichos</span>
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

<!-- Kubre OS UI Experience & Live Captures Showcase -->
<section class="ui-showcase-section" id="experiencia">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Nueva Experiencia Kubre OS</span>
            <h2 class="section-title">Diseñado para Operar a la Velocidad de tu Negocio</h2>
            <p class="section-subtitle">Descubre una interfaz ultra-moderna, con barra flotante de accesos directos, analítica financiera en tiempo real y navegación ergonómica en cada pantalla.</p>
        </div>

        <!-- Showcase Navigation Tabs -->
        <div class="ui-showcase-nav" data-aos="fade-up">
            <button type="button" class="ui-showcase-tab active" data-target="#ui-tab-dashboard">
                <i class="fas fa-desktop"></i> Dashboard Ejecutivo
            </button>
            <button type="button" class="ui-showcase-tab" data-target="#ui-tab-graphics">
                <i class="fas fa-chart-line"></i> Gráficos & Analítica
            </button>
            <button type="button" class="ui-showcase-tab" data-target="#ui-tab-dock">
                <i class="fas fa-thumbtack"></i> Dock & Sub-Módulos
            </button>
            <button type="button" class="ui-showcase-tab" data-target="#ui-tab-menu">
                <i class="fas fa-bars"></i> Menú ERP Completo
            </button>
            <button type="button" class="ui-showcase-tab" data-target="#ui-tab-tools">
                <i class="fas fa-search"></i> Centro de Comando (Ctrl+K)
            </button>
        </div>

        <!-- Showcase Tabs Panes -->
        <div class="ui-showcase-panes" data-aos="fade-up" data-aos-delay="100">
            
            <!-- 1. Dashboard Ejecutivo -->
            <div class="ui-showcase-pane active" id="ui-tab-dashboard">
                <div class="ui-showcase-card">
                    <div class="ui-window-bar">
                        <div class="ui-window-dots">
                            <span class="ui-dot red"></span>
                            <span class="ui-dot yellow"></span>
                            <span class="ui-dot green"></span>
                        </div>
                        <div class="ui-window-url">
                            <i class="fas fa-lock" style="font-size: 10px; color: #10B981;"></i> kubre.site/home &bull; Dashboard Ejecutivo
                        </div>
                        <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #10B981; border: 1px solid rgba(16, 185, 129, 0.4); font-size: 11px; padding: 4px 10px; border-radius: 20px;">En Vivo</span>
                    </div>
                    <div class="ui-showcase-content">
                        <div class="ui-image-wrap">
                            <img src="{{ asset('images/landing/Capture_dashboard.jpg') }}" alt="Dashboard Principal Kubre OS" loading="lazy">
                        </div>
                        <div class="ui-info-box">
                            <span class="ui-info-pill" style="background: rgba(251, 76, 10, 0.15); color: #FB4C0A;">Control Financiero & Operativo</span>
                            <h3 class="ui-info-title">Métricas Clave al Instante en un Solo Vistazo</h3>
                            <p class="ui-info-desc">Monitorea tus ingresos brutos, cuentas por cobrar, estado de caja y compras sin perder tiempo revisando múltiples planillas.</p>
                            <ul class="ui-feature-list">
                                <li><i class="fas fa-check-circle" style="color: #FB4C0A;"></i> <strong>Facturación Bimoneda:</strong> Visualización simultánea en USD y moneda local.</li>
                                <li><i class="fas fa-check-circle" style="color: #FB4C0A;"></i> <strong>Ranking de Vendedores:</strong> Cartera de cobros y saldos pendientes por vendedor.</li>
                                <li><i class="fas fa-check-circle" style="color: #FB4C0A;"></i> <strong>Alertas de Stock:</strong> Notificación inmediata de productos con existencias críticas.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Gráficos & Analítica -->
            <div class="ui-showcase-pane" id="ui-tab-graphics">
                <div class="ui-showcase-card">
                    <div class="ui-window-bar">
                        <div class="ui-window-dots">
                            <span class="ui-dot red"></span>
                            <span class="ui-dot yellow"></span>
                            <span class="ui-dot green"></span>
                        </div>
                        <div class="ui-window-url">
                            <i class="fas fa-chart-pie" style="font-size: 10px; color: #6366F1;"></i> kubre.site/reports &bull; Rendimiento & Tendencias
                        </div>
                        <span class="badge" style="background: rgba(99, 102, 241, 0.2); color: #818CF8; border: 1px solid rgba(99, 102, 241, 0.4); font-size: 11px; padding: 4px 10px; border-radius: 20px;">Analítica Inteligente</span>
                    </div>
                    <div class="ui-showcase-content">
                        <div class="ui-image-wrap">
                            <img src="{{ asset('images/landing/Capture_dashboard_grafics.jpg') }}" alt="Gráficos y Estadísticas Kubre OS" loading="lazy">
                        </div>
                        <div class="ui-info-box">
                            <span class="ui-info-pill" style="background: rgba(99, 102, 241, 0.15); color: #818CF8;">Analítica y Reportes</span>
                            <h3 class="ui-info-title">Gráficos Interactivos de Ventas y Flujo de Caja</h3>
                            <p class="ui-info-desc">Toma decisiones basadas en datos reales. Compara períodos, analiza el crecimiento de tus sucursales y detecta tendencias comerciales.</p>
                            <ul class="ui-feature-list">
                                <li><i class="fas fa-check-circle" style="color: #818CF8;"></i> <strong>Evolución de Ventas:</strong> Comparativas mensuales y anuales con gráficos dinámicos.</li>
                                <li><i class="fas fa-check-circle" style="color: #818CF8;"></i> <strong>Top Productos:</strong> Descubre qué artículos generan mayor rentabilidad y rotación.</li>
                                <li><i class="fas fa-check-circle" style="color: #818CF8;"></i> <strong>Control de Gastos:</strong> Balances de egresos por categoría y centros de costos.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Dock Flotante con Submenús -->
            <div class="ui-showcase-pane" id="ui-tab-dock">
                <div class="ui-showcase-card">
                    <div class="ui-window-bar">
                        <div class="ui-window-dots">
                            <span class="ui-dot red"></span>
                            <span class="ui-dot yellow"></span>
                            <span class="ui-dot green"></span>
                        </div>
                        <div class="ui-window-url">
                            <i class="fas fa-rocket" style="font-size: 10px; color: #10B981;"></i> kubre.site &bull; Dock Inteligente Estilo macOS
                        </div>
                        <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #10B981; border: 1px solid rgba(16, 185, 129, 0.4); font-size: 11px; padding: 4px 10px; border-radius: 20px;">Acceso en 1 Clic</span>
                    </div>
                    <div class="ui-showcase-content">
                        <div class="ui-image-wrap">
                            <img src="{{ asset('images/landing/Capture_dashboard_sub-menu.jpg') }}" alt="Dock Flotante con Sub-Módulos Kubre OS" loading="lazy">
                        </div>
                        <div class="ui-info-box">
                            <span class="ui-info-pill" style="background: rgba(16, 185, 129, 0.15); color: #10B981;">Productividad Sin Fricciones</span>
                            <h3 class="ui-info-title">Barra Inferior Flotante con Submenús Instantáneos</h3>
                            <p class="ui-info-desc">Olvida los menús tradicionales lentos y engorrosos. Pasa el cursor sobre cualquier aplicación del Dock para abrir opciones clave al instante.</p>
                            <ul class="ui-feature-list">
                                <li><i class="fas fa-check-circle" style="color: #10B981;"></i> <strong>Sub-Docks Rápidos:</strong> Crea ventas, cotizaciones o compras directamente en 1 clic.</li>
                                <li><i class="fas fa-check-circle" style="color: #10B981;"></i> <strong>Personalización Total:</strong> Ancla o desancla los módulos según las necesidades de cada usuario.</li>
                                <li><i class="fas fa-check-circle" style="color: #10B981;"></i> <strong>100% Espacio en Pantalla:</strong> Tu área de trabajo se mantiene despejada y amplia.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Menú ERP Completo -->
            <div class="ui-showcase-pane" id="ui-tab-menu">
                <div class="ui-showcase-card">
                    <div class="ui-window-bar">
                        <div class="ui-window-dots">
                            <span class="ui-dot red"></span>
                            <span class="ui-dot yellow"></span>
                            <span class="ui-dot green"></span>
                        </div>
                        <div class="ui-window-url">
                            <i class="fas fa-bars" style="font-size: 10px; color: #EC4899;"></i> kubre.site &bull; Arquitectura Modular ERP
                        </div>
                        <span class="badge" style="background: rgba(236, 72, 153, 0.2); color: #EC4899; border: 1px solid rgba(236, 72, 153, 0.4); font-size: 11px; padding: 4px 10px; border-radius: 20px;">Multimódulo</span>
                    </div>
                    <div class="ui-showcase-content">
                        <div class="ui-image-wrap">
                            <img src="{{ asset('images/landing/Capture_dashboard_with_menu.jpg') }}" alt="Menú Lateral Extendido Kubre OS" loading="lazy">
                        </div>
                        <div class="ui-info-box">
                            <span class="ui-info-pill" style="background: rgba(236, 72, 153, 0.15); color: #EC4899;">Control Estructurado</span>
                            <h3 class="ui-info-title">Organización Total de Cada Área de tu Empresa</h3>
                            <p class="ui-info-desc">Cuando necesitas explorar la profundidad de tu negocio, despliega el panel lateral para administrar sucursales, permisos y configuraciones avanzadas.</p>
                            <ul class="ui-feature-list">
                                <li><i class="fas fa-check-circle" style="color: #EC4899;"></i> <strong>Acceso a Todos los Módulos:</strong> Inventario, CRM, Gastos, Manufactura, Citas y Ajustes.</li>
                                <li><i class="fas fa-check-circle" style="color: #EC4899;"></i> <strong>Control por Roles:</strong> Permisos granulares para cajeros, vendedores, administradores y contadores.</li>
                                <li><i class="fas fa-check-circle" style="color: #EC4899;"></i> <strong>Diseño Adaptativo:</strong> Funciona con máxima fluidez tanto en computadoras como en tablets.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Centro de Comando / Herramientas -->
            <div class="ui-showcase-pane" id="ui-tab-tools">
                <div class="ui-showcase-card">
                    <div class="ui-window-bar">
                        <div class="ui-window-dots">
                            <span class="ui-dot red"></span>
                            <span class="ui-dot yellow"></span>
                            <span class="ui-dot green"></span>
                        </div>
                        <div class="ui-window-url">
                            <i class="fas fa-search" style="font-size: 10px; color: #F59E0B;"></i> kubre.site &bull; Centro de Comando & Atajos (Ctrl+K)
                        </div>
                        <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: #F59E0B; border: 1px solid rgba(245, 158, 11, 0.4); font-size: 11px; padding: 4px 10px; border-radius: 20px;">Spotlight Universal</span>
                    </div>
                    <div class="ui-showcase-content">
                        <div class="ui-image-wrap">
                            <img src="{{ asset('images/landing/Capture_tools.jpg') }}" alt="Centro de Comando y Herramientas Kubre OS" loading="lazy">
                        </div>
                        <div class="ui-info-box">
                            <span class="ui-info-pill" style="background: rgba(245, 158, 11, 0.15); color: #F59E0B;">Búsqueda y Atajos</span>
                            <h3 class="ui-info-title">Buscador Universal y Personalizador a tu Medida</h3>
                            <p class="ui-info-desc">Encuentra clientes, números de factura o funciones en milisegundos con solo presionar <kbd style="background: #1E293B; border: 1px solid #475569; padding: 2px 8px; border-radius: 6px; color: #F8FAFC; font-weight: 700;">Ctrl + K</kbd>.</p>
                            <ul class="ui-feature-list">
                                <li><i class="fas fa-check-circle" style="color: #F59E0B;"></i> <strong>Spotlight Inteligente:</strong> Búsqueda en vivo de contactos, productos, facturas y reportes.</li>
                                <li><i class="fas fa-check-circle" style="color: #F59E0B;"></i> <strong>Personalizador de Dock:</strong> Activa o desactiva módulos con switches instantáneos.</li>
                                <li><i class="fas fa-check-circle" style="color: #F59E0B;"></i> <strong>Accesos Directos Globales:</strong> Navega todo el sistema sin tocar el ratón.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Impact & Contrast Section (Antes vs Ahora: El Caos Tradicional vs Kubre OS) -->
<section id="features" class="contrast-section">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">Impacto Operativo & Resultados</span>
            <h2 class="section-title">¿Por Qué Tu Negocio Necesita Kubre?</h2>
            <p class="section-subtitle">Compara el desgaste de la administración manual frente a una operación comercial blindada y en piloto automático.</p>
        </div>

        <div class="contrast-grid">
            <!-- Columna 1: El Caos Tradicional -->
            <div class="contrast-card traditional" data-aos="fade-up" data-aos-delay="100">
                <div class="contrast-header">
                    <span class="contrast-badge-icon danger">
                        <i class="fas fa-triangle-exclamation"></i>
                    </span>
                    <div>
                        <h3 class="contrast-title">El Caos Tradicional</h3>
                        <p class="contrast-subtitle">Pérdida de tiempo, fugas de dinero y estrés operativo</p>
                    </div>
                </div>
                <ul class="contrast-list">
                    <li class="contrast-list-item">
                        <span class="contrast-bullet danger"><i class="fas fa-xmark"></i></span>
                        <span><strong>Descuadres continuos al cobrar en divisas:</strong> Errores de cálculo entre dólares, efectivo y transferencias que generan pérdidas en caja.</span>
                    </li>
                    <li class="contrast-list-item">
                        <span class="contrast-bullet danger"><i class="fas fa-xmark"></i></span>
                        <span><strong>Hojas de Excel desactualizadas:</strong> Desconocimiento del inventario real, mermas sin justificar y quiebres de stock frente a clientes.</span>
                    </li>
                    <li class="contrast-list-item">
                        <span class="contrast-bullet danger"><i class="fas fa-xmark"></i></span>
                        <span><strong>Cuentas por cobrar descontroladas:</strong> Clientes con crédito vencido sin límite fijado, provocando asfixia en el flujo de caja.</span>
                    </li>
                    <li class="contrast-list-item">
                        <span class="contrast-bullet danger"><i class="fas fa-xmark"></i></span>
                        <span><strong>Ceguera de métricas comerciales:</strong> Sin saber con exactitud cuál es el margen de ganancia neto ni cuáles productos son los más rentables.</span>
                    </li>
                    <li class="contrast-list-item">
                        <span class="contrast-bullet danger"><i class="fas fa-xmark"></i></span>
                        <span><strong>Sistemas locales obsoletos:</strong> Obligación de estar físicamente en el local comercial para saber cuánto se vendió en el día.</span>
                    </li>
                </ul>
            </div>

            <!-- Columna 2: Tu Empresa con Kubre OS -->
            <div class="contrast-card kubre" data-aos="fade-up" data-aos-delay="200">
                <div class="contrast-header">
                    <span class="contrast-badge-icon success">
                        <i class="fas fa-shield-halved"></i>
                    </span>
                    <div>
                        <h3 class="contrast-title">Tu Empresa con Kubre OS</h3>
                        <p class="contrast-subtitle">Claridad financiera, control total y crecimiento rentable</p>
                    </div>
                </div>
                <ul class="contrast-list">
                    <li class="contrast-list-item">
                        <span class="contrast-bullet success"><i class="fas fa-check"></i></span>
                        <span><strong>Cobro multimoneda automático:</strong> Conversión en tiempo real con tasa oficial o fijada, liquidación mixta y arqueo ciego por cajero.</span>
                    </li>
                    <li class="contrast-list-item">
                        <span class="contrast-bullet success"><i class="fas fa-check"></i></span>
                        <span><strong>Inventario multialmacén inteligente:</strong> Trazabilidad por sucursal, alertas preventivas de bajo stock y cálculo de costos promedio.</span>
                    </li>
                    <li class="contrast-list-item">
                        <span class="contrast-bullet success"><i class="fas fa-check"></i></span>
                        <span><strong>Gestión de cobranza rigurosa:</strong> Reportes de saldos vencidos, historial por cliente y envío de estados de cuenta en 1 clic.</span>
                    </li>
                    <li class="contrast-list-item">
                        <span class="contrast-bullet success"><i class="fas fa-check"></i></span>
                        <span><strong>Analítica financiera en tiempo real:</strong> Tableros ejecutivos con gráficas dinámicas de ingresos, utilidades y rotación de productos.</span>
                    </li>
                    <li class="contrast-list-item">
                        <span class="contrast-bullet success"><i class="fas fa-check"></i></span>
                        <span><strong>Operación 100% en la nube:</strong> Supervisa todas tus sucursales y puntos de venta desde cualquier lugar y en cualquier dispositivo.</span>
                    </li>
                </ul>
                <div style="margin-top: 28px; padding-top: 22px; border-top: 1px solid rgba(255, 255, 255, 0.08);">
                    <a href="{{ route('business.getRegister') }}" class="btn btn-accent btn-lg" style="width: 100%; justify-content: center;">
                        <span>Quiero Controlar Mi Negocio con Kubre</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Preview -->
<section id="pricing" class="pricing-preview-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Planes</span>
            <h2 class="section-title">Planes Flexibles para tu Negocio</h2>
            <p class="section-subtitle">Elige el plan que mejor se adapte a tus necesidades</p>
        </div>

        <!-- WhatsApp Advisory Strip -->
        <div class="advisory-whatsapp-strip" data-aos="fade-up">
            <div class="advisory-text-group">
                <span class="advisory-icon-circle"><i class="fab fa-whatsapp"></i></span>
                <div>
                    <h4 style="margin: 0; font-size: 16px; font-weight: 700; color: #FFFFFF;">¿Tienes dudas sobre qué plan o módulos necesita tu empresa?</h4>
                    <p style="margin: 4px 0 0 0; font-size: 13.5px; color: #94A3B8;">Escríbenos directamente por WhatsApp. Un especialista te brindará una asesoría personalizada sin costo ni compromiso.</p>
                </div>
            </div>
            <a href="https://wa.me/584242909870?text=Hola,%20deseo%20asesor%C3%ADa%20personalizada%20para%20elegir%20el%20plan%20ideal%20de%20Kubre" target="_blank" rel="noopener" class="btn btn-outline-white" style="border-color: #25D366; color: #25D366; white-space: nowrap; font-weight: 600;">
                <i class="fab fa-whatsapp"></i> Asesoría por WhatsApp
            </a>
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
            <h2>Comienza a Escalar tu Empresa con Kubre Hoy Mismo</h2>
            <p>Pruébalo durante 14 días con acceso ilimitado a todas las herramientas. Sin tarjeta de crédito requerida y con acompañamiento personalizado de nuestro equipo.</p>
            <div class="cta-buttons">
                <a href="{{ route('business.getRegister') }}" class="btn btn-white btn-lg">
                    <i class="fas fa-arrow-right"></i> Crear Cuenta de Prueba Gratis (14 Días)
                </a>
                <a href="https://wa.me/584242909870?text=Hola,%20deseo%20activar%20mi%20prueba%20gratuita%20de%20Kubre%20con%20ayuda%20de%20un%20asesor" target="_blank" rel="noopener" class="btn btn-outline-white btn-lg">
                    <i class="fab fa-whatsapp"></i> Solicitar Demo por WhatsApp
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

    // Kubre OS UI Showcase Tabs Switcher
    var uiShowcaseTabs = document.querySelectorAll('.ui-showcase-tab');
    var uiShowcasePanes = document.querySelectorAll('.ui-showcase-pane');

    uiShowcaseTabs.forEach(function(tab) {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var targetId = this.getAttribute('data-target');
            var targetPane = document.querySelector(targetId);

            if (targetPane) {
                uiShowcaseTabs.forEach(function(t) { t.classList.remove('active'); });
                this.classList.add('active');

                uiShowcasePanes.forEach(function(p) { p.classList.remove('active'); });
                targetPane.classList.add('active');
            }
        });
    });
});
</script>
@endsection
