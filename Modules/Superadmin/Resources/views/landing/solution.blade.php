@extends('superadmin::layouts.landing')
@section('title', $solution['hero_title'] . ' | Kubre')

@section('content')
<!-- Vertical Solution Hero Section -->
<section class="solution-hero-section" style="--sol-primary: {{ $solution['color'] }}; --sol-gradient: {{ $solution['gradient'] }};">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <div class="hero-text" data-aos="fade-right">
            <div class="solution-badge-pill" style="border-color: {{ $solution['color'] }}40; background: {{ $solution['color'] }}15; color: {{ $solution['color'] }};">
                <i class="{{ $solution['icon'] }}"></i>
                <span>{{ $solution['badge'] }}</span>
            </div>

            <h1 class="solution-hero-title">
                {{ $solution['hero_title'] }}
            </h1>

            <p class="solution-hero-subtitle">
                {{ $solution['hero_subtitle'] }}
            </p>

            <div class="hero-buttons">
                <a href="{{ route('business.getRegister') }}" class="btn btn-primary btn-lg" style="background: {{ $solution['gradient'] }}; border: none; box-shadow: 0 4px 20px {{ $solution['color'] }}60;">
                    <i class="fas fa-rocket"></i> Comenzar Prueba Gratis
                </a>
                <a href="{{ route('pricing') }}" class="btn btn-outline-white btn-lg">
                    <i class="fas fa-tags"></i> Ver Planes y Precios
                </a>
            </div>

            <!-- Stats Bar -->
            <div class="solution-stats-grid">
                @foreach($solution['stats'] as $st)
                    <div class="solution-stat-card">
                        <div class="solution-stat-val" style="color: {{ $solution['color'] }};">{{ $st['val'] }}</div>
                        <div class="solution-stat-lbl">{{ $st['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="solution-hero-visual" data-aos="fade-left" data-aos-delay="200">
            <div class="solution-visual-card" style="border-color: {{ $solution['color'] }}30; box-shadow: 0 20px 50px {{ $solution['color'] }}20;">
                <div class="solution-visual-header">
                    <div class="solution-visual-icon" style="background: {{ $solution['gradient'] }};">
                        <i class="{{ $solution['icon'] }}"></i>
                    </div>
                    <div>
                        <div class="solution-visual-title">{{ $solution['name'] }}</div>
                        <div class="solution-visual-sub">Kubre Suite Optimizada</div>
                    </div>
                </div>

                <div class="solution-target-tags">
                    <div class="solution-target-title">Ideal para tu tipo de negocio:</div>
                    <div class="solution-tags-wrap">
                        @foreach($solution['target_businesses'] as $tb)
                            <span class="solution-tag"><i class="fas fa-check" style="color: {{ $solution['color'] }};"></i> {{ $tb }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="solution-cta-box">
                    <div class="solution-cta-title">¿Listo para transformar tu operación?</div>
                    <p class="solution-cta-desc">Configuración en 5 minutos. Sin contratos forzosos.</p>
                    <a href="{{ route('business.getRegister') }}" class="btn btn-accent btn-block">
                        <i class="fas fa-arrow-right"></i> Activar Mi Negocio Ahora
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Key Features & Modules Section -->
<section class="section features-section" style="padding: 90px 0; background: #070A14;">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <div class="auth-pill-badge" style="margin-bottom: 16px;">
                <span class="auth-pill-dot" style="background: {{ $solution['color'] }};"></span>
                <span>Herramientas Especializadas</span>
            </div>
            <h2 class="section-title">
                Todo lo que Necesitas para Dominar el Sector de <span style="color: {{ $solution['color'] }};">{{ $solution['name'] }}</span>
            </h2>
            <p class="section-subtitle">
                Diseñado minuciosamente con las funciones exactas que exige tu industria en el día a día.
            </p>
        </div>

        <div class="solution-features-grid">
            @foreach($solution['features'] as $f)
                <div class="solution-feature-card" data-aos="fade-up">
                    <div class="solution-feature-icon" style="background: {{ $solution['color'] }}18; color: {{ $solution['color'] }}; border-color: {{ $solution['color'] }}35;">
                        <i class="{{ $f['icon'] }}"></i>
                    </div>
                    <h3 class="solution-feature-title">{{ $f['title'] }}</h3>
                    <p class="solution-feature-desc">{{ $f['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Switcher: Explore Other Solutions -->
<section class="section" style="padding: 80px 0; background: #0B0F1D; border-top: 1px solid rgba(255, 255, 255, 0.08);">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <h2 class="section-title">Explora Soluciones para Otras Industrias</h2>
            <p class="section-subtitle">Kubre se adapta perfectamente a diferentes modelos de negocio.</p>
        </div>

        <div class="other-solutions-grid">
            @foreach($all_solutions as $other_slug => $other)
                @if($other_slug !== $slug)
                    <a href="{{ route('landing.solution', $other_slug) }}" class="other-solution-card" data-aos="fade-up">
                        <div class="other-sol-icon" style="background: {{ $other['color'] }}18; color: {{ $other['color'] }}; border-color: {{ $other['color'] }}30;">
                            <i class="{{ $other['icon'] }}"></i>
                        </div>
                        <div class="other-sol-info">
                            <h4 class="other-sol-title">{{ $other['name'] }}</h4>
                            <p class="other-sol-desc">{{ $other['short_desc'] }}</p>
                        </div>
                        <div class="other-sol-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</section>

<!-- Final CTA Banner -->
<section class="solution-final-cta" style="background: linear-gradient(135deg, #0B0F1D 0%, #171E38 100%); border-top: 1px solid rgba(255, 255, 255, 0.1); padding: 80px 0;">
    <div class="container text-center" data-aos="zoom-in">
        <h2 style="font-size: 32px; font-weight: 800; color: #FFFFFF; margin-bottom: 12px;">
            Impulsa tu {{ $solution['name'] }} con Kubre Hoy
        </h2>
        <p style="font-size: 16px; color: #94A3B8; max-width: 600px; margin: 0 auto 28px auto;">
            Únete a cientos de empresas que ya automatizan ventas, inventario y finanzas en una sola plataforma.
        </p>
        <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('business.getRegister') }}" class="btn btn-primary btn-lg" style="background: {{ $solution['gradient'] }}; border: none; box-shadow: 0 6px 25px {{ $solution['color'] }}60;">
                <i class="fas fa-rocket"></i> Crear Cuenta Gratis
            </a>
            <a href="{{ route('pricing') }}" class="btn btn-outline-white btn-lg">
                <i class="fas fa-sparkles"></i> Ver Planes
            </a>
        </div>
    </div>
</section>
@endsection
