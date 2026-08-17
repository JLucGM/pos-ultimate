@extends('superadmin::layouts.landing_modern')
@section('title', 'Sistema POS para Pequeñas Empresas')

@section('content')
<!-- Hero Section -->
<section class="hero-modern">
    <div class="hero-background">
        <div class="gradient-orb orb-1"></div>
        <div class="gradient-orb orb-2"></div>
        <div class="gradient-orb orb-3"></div>
    </div>
    
    <div class="container-fluid">
        <div class="hero-content-wrapper">
            <div class="hero-text-content" data-aos="fade-right">
                <span class="hero-badge">
                    <i class="fas fa-star"></i> Sistema POS #1 en Venezuela
                </span>
                <h1 class="hero-title-modern">
                    Gestiona tu Negocio con 
                    <span class="gradient-text">Inteligencia</span>
                </h1>
                <p class="hero-description">
                    Sistema POS completo en la nube. Controla ventas, inventario, clientes y reportes desde cualquier lugar. 
                    Perfecto para restaurantes, tiendas, consultorios y pequeñas empresas.
                </p>
                
                <div class="hero-cta-buttons">
                    <a href="{{ route('business.getRegister') }}" class="btn-modern btn-primary-modern">
                        <span>Comenzar Gratis</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('pricing') }}" class="btn-modern btn-outline-modern">
                        <i class="fas fa-tag"></i>
                        <span>Ver Precios</span>
                    </a>
                </div>

                <div class="hero-trust-badges">
                    <div class="trust-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>100% Seguro</span>
                    </div>
                    <div class="trust-item">
                        <i class="fas fa-cloud"></i>
                        <span>En la Nube</span>
                    </div>
                    <div class="trust-item">
                        <i class="fas fa-headset"></i>
                        <span>Soporte 24/7</span>
                    </div>
                </div>
            </div>

            <div class="hero-visual-content" data-aos="fade-left" data-aos-delay="200">
                <div class="dashboard-mockup">
                    <div class="mockup-window">
                        <div class="window-header">
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                        </div>
                        <div class="window-content">
                            <img src="{{ asset('images/landing/dashboard-preview.png') }}" alt="Dashboard" class="dashboard-img">
                        </div>
                    </div>
                    
                    <!-- Floating Stats Cards -->
                    <div class="floating-stat stat-1" data-aos="fade-up" data-aos-delay="400">
                        <div class="stat-icon bg-gradient-blue">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-label">Ventas Hoy</span>
                            <span class="stat-value">$12,450</span>
                        </div>
                    </div>

                    <div class="floating-stat stat-2" data-aos="fade-up" data-aos-delay="500">
                        <div class="stat-icon bg-gradient-green">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-label">Clientes</span>
                            <span class="stat-value">+245</span>
                        </div>
                    </div>

                    <div class="floating-stat stat-3" data-aos="fade-up" data-aos-delay="600">
                        <div class="stat-icon bg-gradient-purple">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-label">Productos</span>
                            <span class="stat-value">1,234</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="features-modern">
    <div class="container">
        <div class="section-header-modern" data-aos="fade-up">
            <span class="section-badge-modern">Características</span>
            <h2 class="section-title-modern">Todo lo que Necesitas en un Solo Lugar</h2>
            <p class="section-subtitle-modern">Funcionalidades diseñadas para hacer crecer tu negocio</p>
        </div>

        <div class="features-grid-modern">
            <div class="feature-card-modern" data-aos="fade-up" data-aos-delay="0">
                <div class="feature-icon-modern bg-gradient-blue">
                    <i class="fas fa-cash-register"></i>
                </div>
                <h3>Punto de Venta Rápido</h3>
                <p>Procesa ventas en segundos con nuestra interfaz intuitiva. Soporte para múltiples métodos de pago y descuentos.</p>
                <a href="#" class="feature-link">
                    Conocer más <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="feature-card-modern" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon-modern bg-gradient-green">
                    <i class="fas fa-boxes"></i>
                </div>
                <h3>Control de Inventario</h3>
                <p>Gestiona tu stock en tiempo real, alertas automáticas de bajo inventario y transferencias entre sucursales.</p>
                <a href="#" class="feature-link">
                    Conocer más <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="feature-card-modern" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon-modern bg-gradient-purple">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3>Gestión de Citas</h3>
                <p>Calendario inteligente para consultorios y salones. Recordatorios automáticos y sala de espera digital.</p>
                <a href="#" class="feature-link">
                    Conocer más <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="feature-card-modern" data-aos="fade-up" data-aos-delay="0">
                <div class="feature-icon-modern bg-gradient-orange">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3>Reportes Inteligentes</h3>
                <p>Análisis detallados de ventas, productos más vendidos y reportes financieros con gráficos interactivos.</p>
                <a href="#" class="feature-link">
                    Conocer más <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="feature-card-modern" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon-modern bg-gradient-red">
                    <i class="fas fa-store-alt"></i>
                </div>
                <h3>Multi-Sucursal</h3>
                <p>Administra múltiples ubicaciones desde un solo panel. Reportes consolidados y transferencias automáticas.</p>
                <a href="#" class="feature-link">
                    Conocer más <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="feature-card-modern" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon-modern bg-gradient-teal">
                    <i class="fas fa-utensils"></i>
                </div>
                <h3>Módulo Restaurante</h3>
                <p>Gestión de mesas, comandas de cocina, modificadores de productos y control de meseros.</p>
                <a href="#" class="feature-link">
                    Conocer más <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section id="stats" class="stats-modern">
    <div class="container">
        <div class="stats-grid-modern" data-aos="fade-up">
            <div class="stat-item-modern">
                <div class="stat-number-modern">500+</div>
                <div class="stat-label-modern">Empresas Activas</div>
            </div>
            <div class="stat-item-modern">
                <div class="stat-number-modern">50K+</div>
                <div class="stat-label-modern">Transacciones/Mes</div>
            </div>
            <div class="stat-item-modern">
                <div class="stat-number-modern">99.9%</div>
                <div class="stat-label-modern">Uptime Garantizado</div>
            </div>
            <div class="stat-item-modern">
                <div class="stat-number-modern">24/7</div>
                <div class="stat-label-modern">Soporte Técnico</div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section id="pricing" class="pricing-modern">
    <div class="container">
        <div class="section-header-modern" data-aos="fade-up">
            <span class="section-badge-modern">Precios</span>
            <h2 class="section-title-modern">Planes Flexibles para tu Negocio</h2>
            <p class="section-subtitle-modern">Sin contratos, cancela cuando quieras</p>
        </div>

        <div class="pricing-grid-modern">
            <div class="pricing-card-modern" data-aos="fade-up" data-aos-delay="0">
                <div class="pricing-header-modern">
                    <h3>Basic</h3>
                    <div class="price-modern">
                        <span class="currency">$</span>
                        <span class="amount">8</span>
                        <span class="period">/mes</span>
                    </div>
                    <p class="pricing-description">Perfecto para empezar</p>
                </div>
                <ul class="pricing-features-modern">
                    <li><i class="fas fa-check"></i> 1 Sucursal</li>
                    <li><i class="fas fa-check"></i> 2 Usuarios</li>
                    <li><i class="fas fa-check"></i> 100 Productos</li>
                    <li><i class="fas fa-check"></i> Reportes Básicos</li>
                    <li><i class="fas fa-check"></i> Soporte por Email</li>
                </ul>
                <a href="{{ route('pricing') }}" class="btn-modern btn-outline-modern w-full">
                    Seleccionar Plan
                </a>
            </div>

            <div class="pricing-card-modern featured-modern" data-aos="fade-up" data-aos-delay="100">
                <div class="popular-badge-modern">Más Popular</div>
                <div class="pricing-header-modern">
                    <h3>Pymes</h3>
                    <div class="price-modern">
                        <span class="currency">$</span>
                        <span class="amount">15</span>
                        <span class="period">/mes</span>
                    </div>
                    <p class="pricing-description">Para negocios en crecimiento</p>
                </div>
                <ul class="pricing-features-modern">
                    <li><i class="fas fa-check"></i> 1 Sucursal</li>
                    <li><i class="fas fa-check"></i> 3 Usuarios</li>
                    <li><i class="fas fa-check"></i> Productos Ilimitados</li>
                    <li><i class="fas fa-check"></i> Reportes Avanzados</li>
                    <li><i class="fas fa-check"></i> Módulo de Citas</li>
                    <li><i class="fas fa-check"></i> Soporte Prioritario</li>
                </ul>
                <a href="{{ route('pricing') }}" class="btn-modern btn-primary-modern w-full">
                    Seleccionar Plan
                </a>
            </div>

            <div class="pricing-card-modern" data-aos="fade-up" data-aos-delay="200">
                <div class="pricing-header-modern">
                    <h3>Business</h3>
                    <div class="price-modern">
                        <span class="currency">$</span>
                        <span class="amount">28</span>
                        <span class="period">/mes</span>
                    </div>
                    <p class="pricing-description">Sin límites</p>
                </div>
                <ul class="pricing-features-modern">
                    <li><i class="fas fa-check"></i> Sucursales Ilimitadas</li>
                    <li><i class="fas fa-check"></i> Usuarios Ilimitados</li>
                    <li><i class="fas fa-check"></i> Productos Ilimitados</li>
                    <li><i class="fas fa-check"></i> Todas las Funciones</li>
                    <li><i class="fas fa-check"></i> API Personalizada</li>
                    <li><i class="fas fa-check"></i> Soporte 24/7</li>
                </ul>
                <a href="{{ route('pricing') }}" class="btn-modern btn-outline-modern w-full">
                    Seleccionar Plan
                </a>
            </div>
        </div>
    </div>
</section>

<!-- How to Start Section -->
<section id="como-empezar" class="how-to-start-modern">
    <div class="container">
        <div class="how-to-start-card" style="background: #ffffff; border-radius: 20px; padding: 60px 48px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
            <div class="section-header-modern" data-aos="fade-up" style="text-align: center; margin-bottom: 48px;">
                <h2 style="font-size: 36px; font-weight: 800; color: #1E293B;">¿Cómo empezar con Audaz POS?</h2>
            </div>

            <div class="steps-container" style="display: flex; flex-direction: column; gap: 0; max-width: 640px; margin: 0 auto;">
                <div class="step-item" data-aos="fade-up" data-aos-delay="0">
                    <div style="display: flex; align-items: flex-start; gap: 20px;">
                        <div style="width: 56px; height: 56px; min-width: 56px; border-radius: 14px; background: #1D4ED8; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-plus" style="color: #fff; font-size: 20px;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 18px; font-weight: 700; color: #1E293B; margin-bottom: 6px;">1. Regístrate para empezar</h3>
                            <p style="font-size: 15px; color: #475569; line-height: 1.6; margin: 0;">Cuéntanos sobre tu negocio para ayudarte a aprovechar Audaz POS desde el primer día.</p>
                        </div>
                    </div>
                    <div style="width: 2px; height: 32px; background: #e2e8f0; margin-left: 27px;"></div>
                </div>

                <div class="step-item" data-aos="fade-up" data-aos-delay="100">
                    <div style="display: flex; align-items: flex-start; gap: 20px;">
                        <div style="width: 56px; height: 56px; min-width: 56px; border-radius: 14px; background: #1D4ED8; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-cogs" style="color: #fff; font-size: 20px;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 18px; font-weight: 700; color: #1E293B; margin-bottom: 6px;">2. Configuración inicial con expertos</h3>
                            <p style="font-size: 15px; color: #475569; line-height: 1.6; margin: 0;">Recibirás apoyo para configurar el sistema según las necesidades específicas de tu negocio, sin costos adicionales.</p>
                        </div>
                    </div>
                    <div style="width: 2px; height: 32px; background: #e2e8f0; margin-left: 27px;"></div>
                </div>

                <div class="step-item" data-aos="fade-up" data-aos-delay="200">
                    <div style="display: flex; align-items: flex-start; gap: 20px;">
                        <div style="width: 56px; height: 56px; min-width: 56px; border-radius: 14px; background: #1D4ED8; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-rocket" style="color: #fff; font-size: 20px;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 18px; font-weight: 700; color: #1E293B; margin-bottom: 6px;">3. Personaliza y comienza</h3>
                            <p style="font-size: 15px; color: #475569; line-height: 1.6; margin: 0;">Configura Audaz POS en pocos minutos. Registra tus productos, organiza tu inventario y automatiza tareas clave desde el primer día.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 40px;" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('business.getRegister') }}" class="btn-modern btn-primary-modern btn-lg" style="background: #1D4ED8; color: #fff; padding: 14px 32px; border-radius: 12px; font-weight: 600; font-size: 16px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <span>Crea tu cuenta hoy</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-modern">
    <div class="container">
        <div class="cta-content-modern" data-aos="zoom-in">
            <h2>¿Listo para Transformar tu Negocio?</h2>
            <p>Únete a cientos de empresas que ya confían en nuestro sistema</p>
            <div class="cta-buttons-modern">
                <a href="{{ route('business.getRegister') }}" class="btn-modern btn-white-modern btn-lg">
                    <span>Comenzar Gratis</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="https://wa.me/584242909870" class="btn-modern btn-outline-white-modern btn-lg">
                    <i class="fab fa-whatsapp"></i>
                    <span>Contactar por WhatsApp</span>
                </a>
                <a href="{{ route('contact.page') }}" class="btn-modern btn-outline-white-modern btn-lg">
                    <i class="fas fa-envelope"></i>
                    <span>Formulario de Contacto</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
