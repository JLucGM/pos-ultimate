@extends('superadmin::layouts.landing_modern')
@section('title', 'Contacto | Kubre - Plataforma de Gestión Empresarial')
@section('meta_description', 'Ponte en contacto con el equipo de Kubre. Estamos listos para ayudarte a implementar y optimizar la gestión de tu negocio.')

@section('content')
<!-- Contact Hero Section -->
<section class="contact-hero-modern">
    <div class="hero-background">
        <div class="gradient-orb orb-1"></div>
        <div class="gradient-orb orb-2"></div>
    </div>
    
    <div class="container">
        <div class="contact-hero-content" data-aos="fade-up">
            <h1 class="contact-hero-title">¿Tienes Preguntas?</h1>
            <p class="contact-hero-subtitle">Estamos aquí para ayudarte. Contáctanos y te responderemos lo antes posible.</p>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="contact-form-section">
    <div class="container">
        <div class="contact-grid">
            <!-- Contact Info -->
            <div class="contact-info-card" data-aos="fade-right">
                <h2>Información de Contacto</h2>
                <p class="contact-info-subtitle">Puedes contactarnos a través de cualquiera de estos medios</p>
                
                <div class="contact-info-items">
                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-info-content">
                            <h4>Email</h4>
                            <a href="mailto:{{ config('app.contact_email', 'info@kubre.site') }}">
                                {{ config('app.contact_email', 'info@kubre.site') }}
                            </a>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="contact-info-content">
                            <h4>WhatsApp</h4>
                            <a href="https://wa.me/{{ config('app.whatsapp_number', '584242909870') }}" target="_blank">
                                {{ config('app.whatsapp_display', '+58 424 290 9870') }}
                            </a>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-info-content">
                            <h4>Horario de Atención</h4>
                            <p>Lunes a Viernes: 9:00 AM - 6:00 PM<br>Sábados: 9:00 AM - 1:00 PM</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-info-content">
                            <h4>Ubicación</h4>
                            <p>Venezuela<br>Servicio en toda Latinoamérica</p>
                        </div>
                    </div>
                </div>

                <div class="contact-social">
                    <h4>Síguenos</h4>
                    <div class="social-links">
                        @php
                            $fb = config('landing.social.facebook') ?: config('app.facebook_url');
                            $tw = config('landing.social.twitter') ?: config('app.twitter_url');
                            $ig = config('landing.social.instagram') ?: config('app.instagram_url');
                            $li = config('landing.social.linkedin') ?: config('app.linkedin_url');
                        @endphp
                        @if($fb && $fb !== '#')
                        <a href="{{ $fb }}" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif
                        @if($tw && $tw !== '#')
                        <a href="{{ $tw }}" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="X (Twitter)">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" style="display: block;">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                        @endif
                        @if($ig && $ig !== '#')
                        <a href="{{ $ig }}" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @endif
                        @if($li && $li !== '#')
                        <a href="{{ $li }}" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-card" data-aos="fade-left">
                <h2>Envíanos un Mensaje</h2>
                <p class="contact-form-subtitle">Completa el formulario y nos pondremos en contacto contigo</p>

                <form id="contactForm" class="contact-form">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Nombre Completo *</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="tel" id="phone" name="phone" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="company">Empresa</label>
                            <input type="text" id="company" name="company" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">Mensaje *</label>
                        <textarea id="message" name="message" class="form-control" rows="6" required></textarea>
                    </div>

                    <button type="submit" class="btn-modern btn-primary-modern btn-lg w-full" id="submitBtn">
                        <span>Enviar Mensaje</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>

                    <div id="formMessage" class="form-message" style="display: none;"></div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section-modern">
    <div class="container">
        <div class="section-header-modern" data-aos="fade-up">
            <span class="section-badge-modern">Preguntas Frecuentes</span>
            <h2 class="section-title-modern">¿Tienes Dudas?</h2>
            <p class="section-subtitle-modern">Aquí respondemos las preguntas más comunes</p>
        </div>

        <div class="faq-grid">
            <div class="faq-item" data-aos="fade-up" data-aos-delay="0">
                <h3>¿Cuánto tiempo tarda la implementación?</h3>
                <p>La implementación básica toma entre 1-2 días. Incluye configuración inicial, capacitación y soporte personalizado.</p>
            </div>

            <div class="faq-item" data-aos="fade-up" data-aos-delay="100">
                <h3>¿Ofrecen soporte técnico?</h3>
                <p>Sí, ofrecemos soporte técnico por WhatsApp, email y teléfono. Nuestro equipo está disponible de lunes a sábado.</p>
            </div>

            <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
                <h3>¿Puedo probar el sistema antes de comprar?</h3>
                <p>Sí, ofrecemos una demostración gratuita donde te mostramos todas las funcionalidades del sistema.</p>
            </div>

            <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                <h3>¿Qué métodos de pago aceptan?</h3>
                <p>Aceptamos transferencias bancarias, Zelle, PayPal y criptomonedas. Planes de pago flexibles disponibles.</p>
            </div>
        </div>
    </div>
</section>

<style>
    /* Contact Hero */
    .contact-hero-modern {
        position: relative;
        padding: 150px 0 100px;
        background: linear-gradient(135deg, #1e0a3c 0%, #2d1b4e 50%, #4a2c7c 100%);
        overflow: hidden;
    }

    .contact-hero-content {
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .contact-hero-title {
        font-size: 48px;
        font-weight: 900;
        color: var(--white);
        margin-bottom: 20px;
    }

    .contact-hero-subtitle {
        font-size: 20px;
        color: rgba(255, 255, 255, 0.8);
        max-width: 600px;
        margin: 0 auto;
    }

    /* Contact Form Section */
    .contact-form-section {
        padding: 100px 0;
        background: var(--gray-50);
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 60px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .contact-info-card,
    .contact-form-card {
        background: var(--white);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .contact-info-card h2,
    .contact-form-card h2 {
        font-size: 28px;
        font-weight: 800;
        color: var(--gray-900);
        margin-bottom: 12px;
    }

    .contact-info-subtitle,
    .contact-form-subtitle {
        color: var(--gray-600);
        margin-bottom: 32px;
    }

    .contact-info-items {
        margin-bottom: 40px;
    }

    .contact-info-item {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }

    .contact-info-icon {
        width: 50px;
        height: 50px;
        min-width: 50px;
        background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 20px;
    }

    .contact-info-content h4 {
        font-size: 16px;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 6px;
    }

    .contact-info-content p,
    .contact-info-content a {
        color: var(--gray-600);
        text-decoration: none;
        line-height: 1.6;
    }

    .contact-info-content a:hover {
        color: var(--primary);
    }

    .contact-social h4 {
        font-size: 16px;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 16px;
    }

    .social-links {
        display: flex;
        gap: 12px;
    }

    .social-link {
        width: 40px;
        height: 40px;
        background: var(--gray-100);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-700);
        text-decoration: none;
        transition: all 0.3s;
    }

    .social-link:hover {
        background: var(--primary);
        color: var(--white);
        transform: translateY(-2px);
    }

    /* Contact Form */
    .contact-form {
        margin-top: 32px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--gray-200);
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    .form-message {
        margin-top: 20px;
        padding: 16px;
        border-radius: 10px;
        font-weight: 600;
    }

    .form-message.success {
        background: #d1fae5;
        color: #065f46;
        border: 2px solid #10b981;
    }

    .form-message.error {
        background: #fee2e2;
        color: #991b1b;
        border: 2px solid #ef4444;
    }

    /* FAQ Section */
    .faq-section-modern {
        padding: 80px 0;
        background: var(--white);
    }

    .faq-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 32px;
        max-width: 1000px;
        margin: 0 auto;
    }

    .faq-item {
        padding: 32px;
        background: var(--gray-50);
        border-radius: 16px;
        border: 2px solid var(--gray-200);
        transition: all 0.3s;
    }

    .faq-item:hover {
        border-color: var(--primary);
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(124, 58, 237, 0.1);
    }

    .faq-item h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 12px;
    }

    .faq-item p {
        color: var(--gray-600);
        line-height: 1.6;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .contact-hero-title {
            font-size: 32px;
        }

        .contact-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .faq-grid {
            grid-template-columns: 1fr;
        }

        .contact-info-card,
        .contact-form-card {
            padding: 30px 20px;
        }
    }
</style>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const submitBtn = document.getElementById('submitBtn');
    const formMessage = document.getElementById('formMessage');
    const formData = new FormData(form);
    
    // Disable button
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span>Enviando...</span><i class="fas fa-spinner fa-spin"></i>';
    
    // Hide previous message
    formMessage.style.display = 'none';
    
    fetch('{{ route("contact") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            formMessage.className = 'form-message success';
            formMessage.textContent = data.message;
            formMessage.style.display = 'block';
            form.reset();
        } else {
            formMessage.className = 'form-message error';
            formMessage.textContent = data.message || 'Hubo un error. Por favor intenta nuevamente.';
            formMessage.style.display = 'block';
        }
    })
    .catch(error => {
        formMessage.className = 'form-message error';
        formMessage.textContent = 'Hubo un error al enviar el mensaje. Por favor intenta nuevamente.';
        formMessage.style.display = 'block';
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<span>Enviar Mensaje</span><i class="fas fa-paper-plane"></i>';
    });
});
</script>
@endsection
