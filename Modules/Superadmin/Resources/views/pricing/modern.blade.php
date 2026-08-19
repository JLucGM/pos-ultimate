@extends('superadmin::layouts.landing')
@section('title', 'Planes y Precios - Sistema POS')

@section('content')
<!-- Pricing Hero -->
<section class="pricing-hero">
    <div class="container">
        <div class="pricing-hero-content" data-aos="fade-up">
            <span class="section-badge">Precios Transparentes</span>
            <h1 class="hero-title">Elige el Plan Perfecto para tu Negocio</h1>
            <p class="hero-subtitle">Sin costos ocultos. Cancela cuando quieras. Soporte incluido en todos los planes.</p>
            
            <!-- Billing Toggle -->
            <div class="billing-toggle">
                <span class="toggle-label active" id="label-monthly">Mensual</span>
                <label class="switch">
                    <input type="checkbox" class="duration_check" id="billingToggle">
                    <span class="slider"></span>
                </label>
                <span class="toggle-label" id="label-yearly">
                    Anual
                    <span class="save-badge">Ahorra 20%</span>
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Plans -->
<section class="pricing-plans-section">
    <div class="container">
        <div class="pricing-grid">
            @foreach($packages as $package)
            <div class="pricing-plan {{ $package->is_popular ? 'popular' : '' }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                @if($package->is_popular)
                <div class="popular-ribbon">
                    <i class="fas fa-star"></i> Más Popular
                </div>
                @endif
                
                <div class="plan-header">
                    <h3 class="plan-name">{{ $package->name }}</h3>
                    <p class="plan-description">{{ $package->description }}</p>
                    
                    <div class="plan-price">
                        <div class="price-monthly months">
                            <span class="currency">{{ $package->currency }}</span>
                            <span class="amount">{{ number_format($package->price, 2) }}</span>
                            <span class="period">/mes</span>
                        </div>
                        <div class="price-yearly years" style="display: none;">
                            <span class="currency">{{ $package->currency }}</span>
                            <span class="amount">{{ number_format($package->annual_price, 2) }}</span>
                            <span class="period">/año</span>
                            <div class="tw-text-sm tw-text-green-600 tw-font-semibold tw-mt-1">
                                Ahorras ${{ number_format(($package->price * 12) - $package->annual_price, 2) }}/año
                            </div>
                        </div>
                    </div>
                    
                    @if($package->trial_days > 0)
                    <div class="trial-badge">
                        <i class="fas fa-gift"></i> {{ $package->trial_days }} días de prueba gratis
                    </div>
                    @endif
                </div>
                
                <div class="plan-features">
                    <ul>
                        @if($package->location_count == 0)
                        <li><i class="fas fa-check"></i> <strong>Sucursales ilimitadas</strong></li>
                        @else
                        <li><i class="fas fa-check"></i> <strong>{{ $package->location_count }}</strong> {{ $package->location_count == 1 ? 'Sucursal' : 'Sucursales' }}</li>
                        @endif
                        
                        @if($package->user_count == 0)
                        <li><i class="fas fa-check"></i> <strong>Usuarios ilimitados</strong></li>
                        @else
                        <li><i class="fas fa-check"></i> <strong>{{ $package->user_count }}</strong> {{ $package->user_count == 1 ? 'Usuario' : 'Usuarios' }}</li>
                        @endif
                        
                        @if($package->product_count == 0)
                        <li><i class="fas fa-check"></i> <strong>Productos ilimitados</strong></li>
                        @else
                        <li><i class="fas fa-check"></i> Hasta <strong>{{ number_format($package->product_count) }}</strong> Productos</li>
                        @endif
                        
                        @if($package->invoice_count == 0)
                        <li><i class="fas fa-check"></i> <strong>Facturas ilimitadas</strong></li>
                        @else
                        <li><i class="fas fa-check"></i> Hasta <strong>{{ number_format($package->invoice_count) }}</strong> facturas/mes</li>
                        @endif
                        
                        @if(!empty($package->custom_permissions))
                            @foreach($package->custom_permissions as $permission => $value)
                                @if($value == 1 && isset($permission_formatted[$permission]))
                                <li><i class="fas fa-check"></i> {{ $permission_formatted[$permission] }}</li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
                
                <div class="plan-footer">
                    @auth
                        <a href="{{ action([\Modules\Superadmin\Http\Controllers\SubscriptionController::class, 'pay'], [$package->id]) }}" 
                           class="btn {{ $package->is_popular ? 'btn-primary' : 'btn-outline' }} btn-block">
                            Seleccionar Plan
                        </a>
                    @else
                        <button onclick="openPaymentModal({{ $package->id }}, '{{ $package->name }}', '{{ $package->currency }}{{ number_format($package->price, 0) }}/mes')" 
                           class="btn {{ $package->is_popular ? 'btn-primary' : 'btn-outline' }} btn-block">
                            Comenzar Ahora
                        </button>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Features Comparison -->
<section class="features-comparison-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2 class="section-title">Comparación Detallada de Planes</h2>
            <p class="section-subtitle">Todas las características que necesitas para gestionar tu negocio</p>
        </div>
        
        <div class="comparison-table" data-aos="fade-up" data-aos-delay="100">
            <table>
                <thead>
                    <tr>
                        <th>Características</th>
                        @foreach($packages->take(4) as $package)
                        <th>{{ $package->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Sucursales</strong></td>
                        @foreach($packages->take(4) as $package)
                        <td>{{ $package->location_count == 0 ? 'Ilimitadas' : $package->location_count }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Usuarios</strong></td>
                        @foreach($packages->take(4) as $package)
                        <td>{{ $package->user_count == 0 ? 'Ilimitados' : $package->user_count }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Productos</strong></td>
                        @foreach($packages->take(4) as $package)
                        <td>{{ $package->product_count == 0 ? 'Ilimitados' : number_format($package->product_count) }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Punto de Venta</strong></td>
                        @foreach($packages->take(4) as $package)
                        <td><i class="fas fa-check text-success"></i></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Gestión de Inventario</strong></td>
                        @foreach($packages->take(4) as $package)
                        <td><i class="fas fa-check text-success"></i></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Reportes Básicos</strong></td>
                        @foreach($packages->take(4) as $package)
                        <td><i class="fas fa-check text-success"></i></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Módulo Restaurante</strong></td>
                        @foreach($packages->take(4) as $package)
                        <td>
                            @if(isset($package->custom_permissions['restaurant']) && $package->custom_permissions['restaurant'])
                            <i class="fas fa-check text-success"></i>
                            @else
                            <i class="fas fa-times text-muted"></i>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Soporte</strong></td>
                        @foreach($packages->take(4) as $package)
                        <td>{{ $loop->first ? 'Email' : ($loop->last ? '24/7' : 'Prioritario') }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="pricing-faq-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2 class="section-title">Preguntas Frecuentes sobre Precios</h2>
        </div>
        
        <div class="faq-grid">
            <div class="faq-column" data-aos="fade-right">
                <div class="faq-item">
                    <div class="faq-question">
                        <h4>¿Puedo cambiar de plan después?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Sí, puedes actualizar o cambiar tu plan en cualquier momento desde tu panel de control. Los cambios se aplican inmediatamente.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h4>¿Qué métodos de pago aceptan?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Aceptamos tarjetas de crédito/débito, PayPal, Stripe, y transferencias bancarias. Todos los pagos son seguros y encriptados.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h4>¿Hay costos adicionales?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>No, el precio que ves es el precio final. No hay costos ocultos ni tarifas de instalación.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-column" data-aos="fade-left">
                <div class="faq-item">
                    <div class="faq-question">
                        <h4>¿Puedo cancelar en cualquier momento?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Sí, puedes cancelar tu suscripción en cualquier momento sin penalizaciones. Tu acceso continuará hasta el final del período pagado.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h4>¿Ofrecen descuentos para ONGs?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Sí, ofrecemos descuentos especiales para organizaciones sin fines de lucro y educativas. Contáctanos para más información.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h4>¿Qué incluye el soporte?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Todos los planes incluyen soporte técnico, documentación completa y videos tutoriales. Los planes superiores incluyen soporte prioritario.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="pricing-cta-section">
    <div class="container">
        <div class="cta-box" data-aos="zoom-in">
            <div class="cta-content">
                <h2>¿Necesitas un Plan Personalizado?</h2>
                <p>Si tienes necesidades específicas o múltiples ubicaciones, contáctanos para crear un plan a tu medida.</p>
            </div>
            <div class="cta-action">
                <a href="{{ route('contact.page') }}" class="btn btn-white btn-lg">
                    <i class="fas fa-envelope"></i> Formulario de Contacto
                </a>
                <a href="https://wa.me/584242909870" class="btn btn-outline-white btn-lg" style="margin-left: 16px;">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
.pricing-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 140px 0 80px;
    text-align: center;
    color: white;
}

.pricing-hero-content {
    max-width: 800px;
    margin: 0 auto;
}

.billing-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    margin-top: 40px;
}

.toggle-label {
    font-size: 18px;
    font-weight: 600;
    opacity: 0.7;
    transition: opacity 0.3s;
}

.toggle-label.active {
    opacity: 1;
}

.save-badge {
    display: inline-block;
    background: #10b981;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    margin-left: 8px;
}

.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(255, 255, 255, 0.3);
    transition: .4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: rgba(255, 255, 255, 0.5);
}

input:checked + .slider:before {
    transform: translateX(26px);
}

.pricing-plans-section {
    padding: 80px 0;
    background: #f8fafc;
}

.pricing-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    max-width: 1400px;
    margin: 0 auto;
}

.pricing-plan {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
    position: relative;
    border: 2px solid transparent;
}

.pricing-plan:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.pricing-plan.popular {
    border-color: #6366f1;
    transform: scale(1.05);
}

.pricing-plan.popular:hover {
    transform: scale(1.08) translateY(-10px);
}

.popular-ribbon {
    position: absolute;
    top: -15px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 8px 24px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.plan-name {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 12px;
    color: #1e293b;
}

.plan-description {
    color: #64748b;
    margin-bottom: 24px;
    min-height: 48px;
}

.plan-price {
    margin-bottom: 20px;
}

.plan-price .amount {
    font-size: 56px;
    font-weight: 800;
    color: #1e293b;
}

.plan-price .currency {
    font-size: 24px;
    font-weight: 600;
    color: #64748b;
}

.plan-price .period {
    font-size: 18px;
    color: #64748b;
}

.trial-badge {
    background: #10b98120;
    color: #10b981;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    display: inline-block;
}

.plan-features {
    margin: 32px 0;
}

.plan-features ul {
    list-style: none;
    padding: 0;
}

.plan-features li {
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 12px;
}

.plan-features i {
    color: #10b981;
    font-size: 18px;
}

.btn-block {
    width: 100%;
    justify-content: center;
}

.features-comparison-section {
    padding: 80px 0;
}

.comparison-table {
    overflow-x: auto;
}

.comparison-table table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.comparison-table th {
    background: #6366f1;
    color: white;
    padding: 20px;
    text-align: left;
    font-weight: 600;
}

.comparison-table td {
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
}

.comparison-table tr:hover {
    background: #f8fafc;
}

.pricing-faq-section {
    padding: 80px 0;
    background: #f8fafc;
}

.faq-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
}

.pricing-cta-section {
    padding: 80px 0;
}

.cta-box {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 60px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: white;
    box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
}

.cta-box h2 {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 12px;
}

.cta-box p {
    font-size: 18px;
    opacity: 0.95;
}

@media (max-width: 768px) {
    .pricing-grid {
        grid-template-columns: 1fr;
    }
    
    .pricing-plan.popular {
        transform: scale(1);
    }
    
    .faq-grid {
        grid-template-columns: 1fr;
    }
    
    .cta-box {
        flex-direction: column;
        text-align: center;
        gap: 24px;
    }
    
    .comparison-table {
        font-size: 14px;
    }
}
</style>
@endsection

@section('javascript')
<script>
// Esperar a que TODO esté cargado
window.addEventListener('load', function() {
    // Toggle between monthly and yearly pricing
    var billingToggle = document.getElementById('billingToggle');
    if (billingToggle) {
        billingToggle.addEventListener('change', function() {
            var monthlyEls = document.querySelectorAll('.price-monthly');
            var yearlyEls = document.querySelectorAll('.price-yearly');
            var labelMonthly = document.getElementById('label-monthly');
            var labelYearly = document.getElementById('label-yearly');
            
            if (this.checked) {
                // Mostrar anual
                monthlyEls.forEach(function(el) { el.style.display = 'none'; });
                yearlyEls.forEach(function(el) { el.style.display = 'block'; });
                labelMonthly.classList.remove('active');
                labelYearly.classList.add('active');
            } else {
                // Mostrar mensual
                yearlyEls.forEach(function(el) { el.style.display = 'none'; });
                monthlyEls.forEach(function(el) { el.style.display = 'block'; });
                labelYearly.classList.remove('active');
                labelMonthly.classList.add('active');
            }
        });
    }
    
    // FAQ Accordion - Versión JavaScript vanilla
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
});
</script>
@endsection
