@extends('superadmin::layouts.landing')
@section('title', 'Sistema POS para Pequeñas Empresas')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <div class="hero-text">
            <h1 class="hero-title" data-aos="fade-up">
                Gestiona tu Negocio con el <span class="text-gradient">Sistema POS</span> Más Completo
            </h1>
            <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="100">
                Controla ventas, inventario, clientes y reportes desde cualquier lugar. 
                Perfecto para restaurantes, tiendas y pequeñas empresas.
            </p>
            <div class="hero-buttons" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('pricing') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-rocket"></i> Ver Planes y Precios
                </a>
                <a href="#features" class="btn btn-outline-white btn-lg">
                    <i class="fas fa-play-circle"></i> Ver Demo
                </a>
            </div>
            <div class="hero-stats" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Empresas Activas</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50K+</div>
                    <div class="stat-label">Transacciones/Mes</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">99.9%</div>
                    <div class="stat-label">Uptime</div>
                </div>
            </div>
        </div>
        <div class="hero-image" data-aos="fade-left" data-aos-delay="400">
            <img src="{{ asset('images/landing/dashboard-preview.png') }}" alt="Dashboard Preview" class="dashboard-img">
            <div class="floating-card card-1">
                <i class="fas fa-calendar-check"></i>
                <span>Ventas en tiempo real</span>
            </div>
            <div class="floating-card card-2">
                <i class="fas fa-box"></i>
                <span>Control de inventario</span>
            </div>
            <div class="floating-card card-3">
                <i class="fas fa-box"></i>
                <span>Control de citas</span>
            </div>
            <div class="floating-card card-4">
                <i class="fas fa-cash-register"></i>
                <span>Control de gastos</span>
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
                <h3>Punto de Venta Rápido</h3>
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
                <p>Análisis de ventas, productos más vendidos, reportes financieros y gráficos en tiempo real.</p>
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
                <p>Gestión de mesas, comandas de cocina, modificadores y servicio de meseros.</p>
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
                <h2>¿Por Qué Elegir Nuestro Sistema POS?</h2>
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
                <a href="{{ route('pricing') }}" class="btn btn-primary btn-lg">
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
            <div class="pricing-card" data-aos="fade-up" data-aos-delay="0">
                <div class="pricing-header">
                    <h3>Basic</h3>
                    <div class="price">
                        <span class="currency">$</span>
                        <span class="amount">8</span>
                        <span class="period">/mes</span>
                    </div>
                </div>
                <ul class="pricing-features">
                    <li><i class="fas fa-check"></i> 1 Sucursal</li>
                    <li><i class="fas fa-check"></i> 2 Usuarios</li>
                    <li><i class="fas fa-check"></i> 100 Productos</li>
                    <li><i class="fas fa-check"></i> Reportes Básicos</li>
                    <li><i class="fas fa-check"></i> Soporte por Email</li>
                </ul>
                <a href="{{ route('pricing') }}" class="btn btn-outline">Seleccionar Plan</a>
            </div>

            <div class="pricing-card featured" data-aos="fade-up" data-aos-delay="100">
                <div class="popular-badge">Más Popular</div>
                <div class="pricing-header">
                    <h3>Pymes</h3>
                    <div class="price">
                        <span class="currency">$</span>
                        <span class="amount">15</span>
                        <span class="period">/mes</span>
                    </div>
                </div>
                <ul class="pricing-features">
                    <li><i class="fas fa-check"></i> 1 Sucursales</li>
                    <li><i class="fas fa-check"></i> 3 Usuarios</li>
                    <li><i class="fas fa-check"></i> Productos Ilimitados</li>
                    <li><i class="fas fa-check"></i> Reportes Avanzados</li>
                    <li><i class="fas fa-check"></i> Módulo citas</li>
                    <li><i class="fas fa-check"></i> Soporte Prioritario</li>
                </ul>
                <a href="{{ route('pricing') }}" class="btn btn-primary">Seleccionar Plan</a>
            </div>

            <div class="pricing-card" data-aos="fade-up" data-aos-delay="200">
                <div class="pricing-header">
                    <h3>Business</h3>
                    <div class="price">
                        <span class="currency">$</span>
                        <span class="amount">28</span>
                        <span class="period">/mes</span>
                    </div>
                </div>
                <ul class="pricing-features">
                    <li><i class="fas fa-check"></i> Sucursales Ilimitadas</li>
                    <li><i class="fas fa-check"></i> Usuarios Ilimitados</li>
                    <li><i class="fas fa-check"></i> Productos Ilimitados</li>
                    <li><i class="fas fa-check"></i> Todas las Funciones</li>
                    <li><i class="fas fa-check"></i> API Personalizada</li>
                    <li><i class="fas fa-check"></i> Soporte 24/7</li>
                </ul>
                <a href="{{ route('pricing') }}" class="btn btn-outline">Seleccionar Plan</a>
            </div>
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
                <a href="{{ route('pricing') }}" class="btn btn-white btn-lg">
                    Comenzar Prueba Gratuita
                </a>
                <a href="#contact" class="btn btn-outline-white btn-lg">
                    Contactar Ventas
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
    console.log('=== Landing Page FAQ Debug ===');
    console.log('jQuery disponible:', typeof $ !== 'undefined');
    console.log('FAQ items encontrados:', document.querySelectorAll('.faq-item').length);
    
    // FAQ Accordion - Versión corregida
    var faqQuestions = document.querySelectorAll('.faq-question');
    console.log('FAQ questions encontradas:', faqQuestions.length);
    
    faqQuestions.forEach(function(question, index) {
        question.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var item = this.parentElement;
            var wasActive = item.classList.contains('active');
            
            console.log('FAQ #' + index + ' clickeado. Estaba activo:', wasActive);
            
            // Cerrar todos los items primero
            document.querySelectorAll('.faq-item').forEach(function(i) {
                i.classList.remove('active');
            });
            
            // Abrir el clickeado SOLO si NO estaba activo
            if (!wasActive) {
                item.classList.add('active');
                console.log('FAQ #' + index + ' ABIERTO');
            } else {
                console.log('FAQ #' + index + ' CERRADO (todos cerrados)');
            }
            
            // Debug: verificar estado después del click
            setTimeout(function() {
                console.log('Estado después del click:', item.classList.contains('active') ? 'ACTIVO' : 'INACTIVO');
            }, 100);
        });
    });
    
    // Smooth scroll para links internos
    var internalLinks = document.querySelectorAll('a[href^="#"]');
    console.log('Links internos encontrados:', internalLinks.length);
    
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
                
                console.log('Scroll a:', href);
            }
        });
    });
    
    console.log('=== FAQ inicializado correctamente ===');
});
</script>
@endsection
