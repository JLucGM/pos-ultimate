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

                {!! Form::hidden('language', request()->lang); !!}

                <!-- Información del Negocio -->
                <div class="form-section">
                    <h3 class="section-title">Información del Negocio</h3>
                    
                    <div class="form-group">
                        <label for="name" class="form-label">Nombre del negocio *</label>
                        <div class="input-wrapper">
                            <i class="fas fa-store input-icon"></i>
                            {!! Form::text('name', null, [
                                'class' => 'form-input',
                                'placeholder' => 'Nombre de tu negocio',
                                'required'
                            ]); !!}
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="start_date" class="form-label">Fecha de inicio</label>
                            <div class="input-wrapper">
                                <i class="fas fa-calendar input-icon"></i>
                                {!! Form::text('start_date', null, [
                                    'class' => 'form-input start-date-picker',
                                    'placeholder' => 'Fecha de inicio',
                                    'readonly'
                                ]); !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="currency_id" class="form-label">Moneda *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-dollar-sign input-icon"></i>
                                {!! Form::select('currency_id', $currencies, '', [
                                    'class' => 'form-input select2_register',
                                    'placeholder' => 'Selecciona la moneda',
                                    'required'
                                ]); !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="business_logo" class="form-label">Logo del negocio</label>
                            {!! Form::file('business_logo', ['accept' => 'image/*', 'class' => 'form-input']); !!}
                        </div>

                        <div class="form-group">
                            <label for="website" class="form-label">Sitio web</label>
                            <div class="input-wrapper">
                                <i class="fas fa-globe input-icon"></i>
                                {!! Form::text('website', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'www.ejemplo.com'
                                ]); !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="mobile" class="form-label">Teléfono del negocio</label>
                            <div class="input-wrapper">
                                <i class="fas fa-phone input-icon"></i>
                                {!! Form::text('mobile', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'Teléfono'
                                ]); !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alternate_number" class="form-label">Teléfono alternativo</label>
                            <div class="input-wrapper">
                                <i class="fas fa-phone input-icon"></i>
                                {!! Form::text('alternate_number', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'Teléfono alternativo'
                                ]); !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ubicación del Negocio -->
                <div class="form-section">
                    <h3 class="section-title">Ubicación del Negocio</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="country" class="form-label">País *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-globe input-icon"></i>
                                {!! Form::text('country', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'País',
                                    'required'
                                ]); !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="state" class="form-label">Estado *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-map-marker-alt input-icon"></i>
                                {!! Form::text('state', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'Estado',
                                    'required'
                                ]); !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="city" class="form-label">Ciudad *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-map-marker-alt input-icon"></i>
                                {!! Form::text('city', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'Ciudad',
                                    'required'
                                ]); !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="zip_code" class="form-label">Código postal *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-map-pin input-icon"></i>
                                {!! Form::text('zip_code', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'Código postal',
                                    'required'
                                ]); !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="landmark" class="form-label">Punto de referencia *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-map-marker-alt input-icon"></i>
                                {!! Form::text('landmark', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'Punto de referencia',
                                    'required'
                                ]); !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="time_zone" class="form-label">Zona horaria *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-clock input-icon"></i>
                                {!! Form::select('time_zone', $timezone_list, config('app.timezone'), [
                                    'class' => 'form-input select2_register',
                                    'placeholder' => 'Zona horaria',
                                    'required'
                                ]); !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configuración Fiscal -->
                <div class="form-section">
                    <h3 class="section-title">Configuración Fiscal</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="tax_label_1" class="form-label">Nombre del impuesto 1</label>
                            <div class="input-wrapper">
                                <i class="fas fa-file-invoice input-icon"></i>
                                {!! Form::text('tax_label_1', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'Ej: IVA'
                                ]); !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tax_number_1" class="form-label">Número de impuesto 1</label>
                            <div class="input-wrapper">
                                <i class="fas fa-hashtag input-icon"></i>
                                {!! Form::text('tax_number_1', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'Número'
                                ]); !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="tax_label_2" class="form-label">Nombre del impuesto 2</label>
                            <div class="input-wrapper">
                                <i class="fas fa-file-invoice input-icon"></i>
                                {!! Form::text('tax_label_2', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'Ej: ISR'
                                ]); !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tax_number_2" class="form-label">Número de impuesto 2</label>
                            <div class="input-wrapper">
                                <i class="fas fa-hashtag input-icon"></i>
                                {!! Form::text('tax_number_2', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'Número'
                                ]); !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="fy_start_month" class="form-label">Mes de inicio del año fiscal *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-calendar input-icon"></i>
                                {!! Form::select('fy_start_month', $months, null, [
                                    'class' => 'form-input select2_register',
                                    'required'
                                ]); !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="accounting_method" class="form-label">Método contable *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-calculator input-icon"></i>
                                {!! Form::select('accounting_method', $accounting_methods, null, [
                                    'class' => 'form-input select2_register',
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
                            <label for="surname" class="form-label">Prefijo</label>
                            <div class="input-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                {!! Form::text('surname', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'Sr., Sra., Dr.'
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

                    <div class="form-row">
                        <div class="form-group">
                            <label for="last_name" class="form-label">Apellido</label>
                            <div class="input-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                {!! Form::text('last_name', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'Apellido'
                                ]); !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-envelope input-icon"></i>
                                {!! Form::text('email', null, [
                                    'class' => 'form-input',
                                    'placeholder' => 'correo@ejemplo.com',
                                    'required'
                                ]); !!}
                            </div>
                        </div>
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
                        </div>
                    </div>

                    @if(!empty($system_settings['superadmin_enable_register_tc']))
                        <div class="form-group">
                            <label class="checkbox-label">
                                {!! Form::checkbox('accept_tc', 0, false, ['required', 'class' => 'input-check-box']); !!}
                                <span class="checkbox-text">
                                    <a class="terms_condition" data-toggle="modal" data-target="#tc_modal" style="color: #7c3aed; text-decoration: none;">
                                        Acepto los términos y condiciones
                                    </a>
                                </span>
                            </label>
                        </div>
                        @include('business.partials.terms_conditions')
                    @endif
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2_register').select2({
        width: '100%'
    });

    // Initialize Datepicker
    $('.start-date-picker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

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
        
        if (confirmPassword === '') {
            $(this).css('border-color', '#e5e5e5');
        } else if (password === confirmPassword) {
            $(this).css('border-color', '#10b981');
        } else {
            $(this).css('border-color', '#ef4444');
        }
    });

    // Form validation
    $('#business_register_form').on('submit', function(e) {
        const password = $('#password').val();
        const confirmPassword = $('#confirm_password').val();
        
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Las contraseñas no coinciden');
            return false;
        }
        
        if (password.length < 8) {
            e.preventDefault();
            alert('La contraseña debe tener al menos 8 caracteres');
            return false;
        }
    });
});
</script>
@endsection
