@extends('layouts.auth2')
@section('title', __('lang_v1.login'))
@inject('request', 'Illuminate\Http\Request')

@section('content')
@php
    $username = old('username');
    $password = null;
    if (config('app.env') == 'demo') {
        $username = 'admin';
        $password = '123456';

        $demo_types = [
            'all_in_one' => 'admin',
            'super_market' => 'admin',
            'pharmacy' => 'admin-pharmacy',
            'electronics' => 'admin-electronics',
            'services' => 'admin-services',
            'restaurant' => 'admin-restaurant',
            'superadmin' => 'superadmin',
            'woocommerce' => 'woocommerce_user',
            'essentials' => 'admin-essentials',
            'manufacturing' => 'manufacturer-demo',
        ];

        if (!empty($_GET['demo_type']) && array_key_exists($_GET['demo_type'], $demo_types)) {
            $username = $demo_types[$_GET['demo_type']];
        }
    }
@endphp

<div class="auth-fullscreen-layout">
    <!-- Panel Izquierdo: Experiencia de Marca (55% de pantalla en Desktop) -->
    <div class="auth-brand-side">
        <!-- Header de Marca -->
        <div class="auth-brand-header">
            <a href="{{ url('/') }}" class="auth-brand-logo-wrap">
                <div class="auth-brand-logo-icon">
                    <img src="{{ asset('img/logo_v2_full.png') }}" alt="{{ config('app.name', 'Kubre') }}" style="max-height: 48px; width: auto;" />
                </div>
            </a>
            
            <div style="font-size: 12px; font-weight: 700; color: #FB4C0A; background: rgba(251, 76, 10, 0.12); border: 1px solid rgba(251, 76, 10, 0.25); padding: 4px 12px; border-radius: 999px; font-family: monospace;">
                v{{ config('author.app_version') }} &bull; b{{ config('constants.asset_version') }}
            </div>
        </div>

        <!-- Contenido Central Hero de Marca -->
        <div class="auth-brand-main-content">
            <div class="auth-pill-live">
                <span class="auth-live-dot"></span>
                <span>Tecnología en Tiempo Real</span>
            </div>

            <h1 class="auth-hero-title">
                Gestiona y escala tu negocio con <span class="gradient-highlight">precisión</span>
            </h1>

            <p class="auth-hero-subtitle">
                La plataforma empresarial que unifica tus ventas físicas, tienda online, facturación multimoneda e inventario.
            </p>

            <div class="auth-benefits-grid">
                <div class="auth-benefit-card">
                    <div class="auth-benefit-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="auth-benefit-text">
                        <h4>Sistema de Ventas Ultrarrápido</h4>
                        <p>Facturación ágil con soporte offline y múltiples métodos de pago.</p>
                    </div>
                </div>

                <div class="auth-benefit-card">
                    <div class="auth-benefit-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="auth-benefit-text">
                        <h4>Métricas y Ganancias en Vivo</h4>
                        <p>Informes financieros detallados con conversión multimoneda automática.</p>
                    </div>
                </div>

                <div class="auth-benefit-card">
                    <div class="auth-benefit-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="auth-benefit-text">
                        <h4>Seguridad de Nivel Bancario</h4>
                        <p>Tus datos siempre cifrados y respaldados de manera continua.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Izquierdo -->
        <div class="auth-brand-bottom">
            <span><i class="fas fa-lock" style="color: #10B981; margin-right: 6px;"></i> Conexión Segura SSL 256-Bit</span>
            <span>&copy; {{ date('Y') }} {{ config('app.name') }} &bull; <span style="font-family: monospace; opacity: 0.75;">v{{ config('author.app_version') }} (Build #{{ config('constants.asset_version') }})</span></span>
        </div>
    </div>

    <!-- Panel Derecho: Formulario de Acceso (45% de pantalla en Desktop) -->
    <div class="auth-form-side">
        <!-- Top Nav en el Panel Derecho -->
        <div class="auth-form-top-nav">
            <a href="{{ url('/') }}" class="auth-nav-action-link">
                <i class="fas fa-home"></i> Inicio
            </a>
            
            @if(config('constants.allow_registration'))
                <a href="{{ route('business.getRegister') }}" class="auth-nav-action-link" style="color: #FB4C0A; border-color: rgba(251, 76, 10, 0.35); background: rgba(251, 76, 10, 0.1);">
                    <i class="fas fa-user-plus"></i> Registrarse
                </a>
            @endif

            <div style="display: inline-block;">
                @include('layouts.partials.language_btn')
            </div>
        </div>

        <!-- Contenedor Central del Formulario -->
        <div class="auth-form-center-box">
            <h2 class="auth-header-title">Bienvenido de nuevo 👋</h2>
            <p class="auth-header-sub">Ingresa tus credenciales para acceder a tu panel de control</p>

            @if ($errors->has('username'))
                <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35); border-radius: var(--auth-radius-sm); padding: 12px 16px; margin-bottom: 20px; color: #FCA5A5; font-size: 13px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-exclamation-circle" style="flex-shrink: 0;"></i>
                    <span>{{ $errors->first('username') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="login-form">
                {{ csrf_field() }}

                <!-- Campo Usuario / Email -->
                <div class="auth-group">
                    <label for="username" class="auth-form-label">
                        @lang('lang_v1.username')
                    </label>
                    <div class="auth-field-wrapper">
                        <input 
                            id="username" 
                            type="text" 
                            class="auth-text-input" 
                            name="username" 
                            value="{{ $username }}" 
                            required 
                            autofocus 
                            placeholder="Tu nombre de usuario"
                            autocomplete="username"
                        >
                        <i class="fas fa-user auth-field-icon"></i>
                    </div>
                </div>

                <!-- Campo Contraseña -->
                <div class="auth-group">
                    <div class="auth-label-wrap">
                        <label for="password" class="auth-form-label">
                            @lang('lang_v1.password')
                        </label>
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="auth-forgot-link">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                    <div class="auth-field-wrapper">
                        <input 
                            id="password" 
                            type="password" 
                            class="auth-text-input" 
                            name="password" 
                            required 
                            placeholder="••••••••••••"
                            autocomplete="current-password"
                        >
                        <i class="fas fa-lock auth-field-icon"></i>
                        <button type="button" class="auth-toggle-pwd" id="show_hide_icon" onclick="togglePasswordVisibility()" title="Mostrar/Ocultar contraseña" tabindex="-1">
                            <i class="fas fa-eye" id="eye_icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Recordarme Checkbox -->
                <div class="auth-remember-row">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="auth-remember-text">
                        @lang('lang_v1.remember_me')
                    </label>
                </div>

                <!-- Recaptcha si aplica -->
                @if(config('constants.enable_recaptcha'))
                    <div style="margin-bottom: 20px;">
                        <div class="g-recaptcha" data-sitekey="{{ config('constants.google_recaptcha_key') }}"></div>
                        @if ($errors->has('g-recaptcha-response'))
                            <span style="color: #F87171; font-size: 12px; margin-top: 4px; display: block;">{{ $errors->first('g-recaptcha-response') }}</span>
                        @endif
                    </div>
                @endif

                <!-- Botón Login -->
                <button type="submit" class="auth-btn-primary" id="btn-submit-login">
                    <span>@lang('lang_v1.login')</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            @if(config('constants.allow_registration'))
                <div style="text-align: center; margin-top: 24px; padding-top: 18px; border-top: 1px solid var(--auth-border); font-size: 14px; color: var(--auth-text-muted);">
                    ¿No tienes una cuenta aún? 
                    <a href="{{ route('business.getRegister') }}" style="color: #FB4C0A; font-weight: 700; text-decoration: none; margin-left: 4px;">
                        Regístrate gratis aquí <i class="fas fa-chevron-right" style="font-size: 11px;"></i>
                    </a>
                </div>
            @endif

            <!-- Acceso a Demos si está activo -->
            @if (config('app.env') == 'demo' && !empty($demo_types))
                <div class="auth-demo-box">
                    <div class="auth-demo-label">
                        <i class="fas fa-magic" style="color: #FB4C0A;"></i>
                        Perfiles Demo de Prueba
                    </div>
                    <div class="auth-demo-items">
                        <a href="?demo_type=all_in_one" class="auth-demo-item-btn demo-login" data-admin="{{ $demo_types['all_in_one'] }}">
                            <i class="fas fa-store"></i> General
                        </a>
                        <a href="?demo_type=restaurant" class="auth-demo-item-btn demo-login" data-admin="{{ $demo_types['restaurant'] }}">
                            <i class="fas fa-utensils"></i> Restaurante
                        </a>
                        <a href="?demo_type=manufacturing" class="auth-demo-item-btn demo-login" data-admin="{{ $demo_types['manufacturing'] }}">
                            <i class="fas fa-industry"></i> Manufactura
                        </a>
                        <a href="?demo_type=pharmacy" class="auth-demo-item-btn demo-login" data-admin="{{ $demo_types['pharmacy'] }}">
                            <i class="fas fa-pills"></i> Farmacia
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Footer Derecho -->
        <div class="auth-form-footer">
            ¿Necesitas ayuda? Contáctanos a <a href="mailto:soporte@audazpos.com" style="color: #FB4C0A; text-decoration: none;">soporte@audazpos.com</a>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script type="text/javascript">
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        var icon = document.getElementById('eye_icon');
        if (!passwordInput) return;

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            if (icon) {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        } else {
            passwordInput.type = 'password';
            if (icon) {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    }

    $(document).ready(function() {
        $(document).on('click', '#show_hide_icon', function(e) {
            e.preventDefault();
            togglePasswordVisibility();
        });

        $('.change_lang').click(function() {
            window.location = "{{ route('login') }}?lang=" + $(this).attr('value');
        });

        $('a.demo-login').click(function(e) {
            e.preventDefault();
            $('#username').val($(this).data('admin'));
            $('#password').val("{{ $password }}");
            $('form#login-form').submit();
        });
    });
</script>
@endsection


