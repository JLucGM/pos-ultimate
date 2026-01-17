@extends('layouts.auth_modern')
@section('title', __('lang_v1.register'))

@section('styles')
<style>
    .auth-container {
        max-width: 1400px;
    }

    .register-form {
        max-width: 100%;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-section {
        margin-bottom: 35px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }

    .phone-input-group {
        display: flex;
        gap: 10px;
    }

    .country-code {
        width: 120px;
        flex-shrink: 0;
    }

    .phone-number {
        flex: 1;
    }

    .helper-text {
        font-size: 12px;
        color: #999;
        margin-top: 6px;
        display: block;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .phone-input-group {
            flex-direction: column;
        }

        .country-code {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <!-- Left Side - Branding -->
    <div class="auth-left">
        <div class="auth-branding">
            <div class="brand-logo">
                <img src="{{ asset('img/logo-audaz.png') }}" alt="{{ config('app.name') }}" class="logo-img">
            </div>
            <h1 class="brand-title">{{ config('app.name', 'AudazPOS') }}</h1>
            <p class="brand-subtitle">Comienza a gestionar tu negocio de forma profesional</p>
            
            <div class="features-list">
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Configuración rápida en minutos</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Sin tarjeta de crédito requerida</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Soporte técnico incluido</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Actualizaciones automáticas</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Register Form -->
    <div class="auth-right">
        <div class="auth-form-container">
            <div class="auth-header">
                <h2 class="auth-title">¡Bienvenido a {{ config('app.name') }}!</h2>
                <p class="auth-subtitle">Crea una cuenta nueva</p>
            </div>

            {!! Form::open([
                'url' => route('business.postRegister'),
                'method' => 'post',
                'id' => 'business_register_form',
                'class' => 'auth-form register-form',
                'files' => true,
            ]) !!}

                <!-- Información del Negocio -->
                <div class="form-section">
                    <h3 class="section-title">Información del Negocio</h3>
                    
                    <div class="form-group">
                        <label for="name" class="form-label">Nombre del negocio *</label>
                        <div class="input-wrapper">
                            <i class="fas fa-store input-icon"></i>
                            {!! Form::text('name', null, [
                                'class' => 'form-input',
                                'placeholder' => 'Este será el enlace para ingresar a su cuenta',
                                'required'
                            ]); !!}
                        </div>
                        <span class="helper-text">finepartner.com</span>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="start_date" class="form-label">Fecha de inicio *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-calendar input-icon"></i>
                                {!! Form::text('start_date', @format_date('now'), [
                                    'class' => 'form-input',
                                    'placeholder' => 'Fecha de inicio',
                                    'required',
                                    'readonly'
                                ]); !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="currency_id" class="form-label">Moneda *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-dollar-sign input-icon"></i>
                                {!! Form::select('currency_id', $currencies, 'USD', [
                                    'class' => 'form-input',
                                    'placeholder' => 'Selecciona la moneda',
                                    'required'
                                ]); !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Propietario -->
                <div class="form-section">
                    <h3 class="section-title">Información del Propietario</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="surname" class="form-label">Apellido *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                {!! Form::text('surname', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'Apellido',
                                    'required'
                                ]); !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="first_name" class="form-label">Nombre *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                {!! Form::text('first_name', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'Nombre',
                                    'required'
                                ]); !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email *</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            {!! Form::email('email', null, [
                                'class' => 'form-input',
                                'placeholder' => 'correo@ejemplo.com',
                                'required'
                            ]); !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contact_no" class="form-label">Número de teléfono del dueño del negocio *</label>
                        <div class="phone-input-group">
                            <div class="input-wrapper country-code">
                                <i class="fas fa-flag input-icon"></i>
                                {!! Form::text('country_code', '+58', [
                                    'class' => 'form-input',
                                    'placeholder' => '+58',
                                    'required'
                                ]); !!}
                            </div>
                            <div class="input-wrapper phone-number">
                                <i class="fas fa-phone input-icon"></i>
                                {!! Form::text('contact_no', null, [
                                    'class' => 'form-input',
                                    'placeholder' => '4123456789',
                                    'required'
                                ]); !!}
                            </div>
                        </div>
                        <span class="helper-text">IMPORTANTE: no puede ser el teléfono de ningún empleado ni del negocio</span>
                    </div>
                </div>

                <!-- Credenciales de Acceso -->
                <div class="form-section">
                    <h3 class="section-title">Credenciales de Acceso</h3>
                    
                    <div class="form-group">
                        <label for="username" class="form-label">Usuario *</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user-circle input-icon"></i>
                            {!! Form::text('username', null, [
                                'class' => 'form-input',
                                'placeholder' => 'Usuario para iniciar sesión',
                                'required'
                            ]); !!}
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="password" class="form-label">Contraseña *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock input-icon"></i>
                                {!! Form::password('password', [
                                    'class' => 'form-input',
                                    'placeholder' => 'Mínimo 8 caracteres',
                                    'required',
                                    'id' => 'password'
                                ]); !!}
                                <button type="button" class="toggle-password" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <span class="helper-text">Contraseña con al menos 8 caracteres</span>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password" class="form-label">Confirmar contraseña *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock input-icon"></i>
                                {!! Form::password('confirm_password', [
                                    'class' => 'form-input',
                                    'placeholder' => 'Confirma tu contraseña',
                                    'required',
                                    'id' => 'confirm_password'
                                ]); !!}
                                <button type="button" class="toggle-password" id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <span class="helper-text">Las contraseñas coinciden</span>
                        </div>
                    </div>
                </div>

                {!! Form::hidden('package_id', $package_id) !!}

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    <span>Crear cuenta</span>
                    <i class="fas fa-arrow-right"></i>
                </button>

                <!-- Login Link -->
                <div class="auth-footer">
                    <p class="footer-text">
                        ¿Ya tienes una cuenta? 
                        <a href="{{ route('login') }}" class="footer-link">Inicia sesión</a>
                    </p>
                </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/login.js?v=' . $asset_v) }}"></script>
<script>
$(document).ready(function() {
    // Toggle password visibility
    $('#togglePassword').on('click', function() {
        const passwordInput = $('#password');
        const icon = $(this).find('i');
        
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#toggleConfirmPassword').on('click', function() {
        const passwordInput = $('#confirm_password');
        const icon = $(this).find('i');
        
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Validate password match
    $('#confirm_password').on('keyup', function() {
        const password = $('#password').val();
        const confirmPassword = $(this).val();
        const helperText = $(this).closest('.form-group').find('.helper-text');
        
        if (confirmPassword === '') {
            helperText.text('Las contraseñas coinciden').css('color', '#999');
        } else if (password === confirmPassword) {
            helperText.text('✓ Las contraseñas coinciden').css('color', '#10b981');
        } else {
            helperText.text('✗ Las contraseñas no coinciden').css('color', '#ef4444');
        }
    });
});
</script>
@endsection
