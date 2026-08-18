@extends('layouts.auth2')
@section('title', __('lang_v1.register'))

@section('content')
<div class="auth-fullscreen-layout">
    <!-- Panel Izquierdo: Branding & Beneficios de Registro -->
    <div class="auth-brand-side">
        <!-- Header de Marca -->
        <div class="auth-brand-header">
            <a href="{{ url('/') }}" class="auth-brand-logo-wrap">
                <div class="auth-brand-logo-icon">
                    <img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name', 'Kubre') }}" />
                </div>
            </a>
            
            <div style="font-size: 13px; font-weight: 700; color: #10B981; background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.25); padding: 5px 14px; border-radius: 25px;">
                Prueba 14 Días Gratis
            </div>
        </div>

        <!-- Contenido Central Hero de Marca -->
        <div class="auth-brand-main-content">
            <div class="auth-pill-live">
                <span class="auth-live-dot"></span>
                <span>Registro en 3 Simples Pasos</span>
            </div>

            <h1 class="auth-hero-title">
                Impulsa y automatiza tu negocio con <span class="gradient-highlight">Kubre</span>
            </h1>

            <p class="auth-hero-subtitle">
                Únete a cientos de empresas que gestionan sus ventas, inventario y facturación multimoneda con total fluidez.
            </p>

            <div class="auth-benefits-grid">
                <div class="auth-benefit-card">
                    <div class="auth-benefit-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div class="auth-benefit-text">
                        <h4>Configuración en 2 Minutos</h4>
                        <p>Sin instalaciones complejas. Crea tu cuenta y comienza a vender de inmediato.</p>
                    </div>
                </div>

                <div class="auth-benefit-card">
                    <div class="auth-benefit-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="auth-benefit-text">
                        <h4>Poder Multimoneda</h4>
                        <p>Soporte completo para Dólares, Euros y moneda local con tasas en tiempo real.</p>
                    </div>
                </div>

                <div class="auth-benefit-card">
                    <div class="auth-benefit-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="auth-benefit-text">
                        <h4>Seguridad & Respaldos en la Nube</h4>
                        <p>Tus datos siempre seguros y disponibles desde cualquier dispositivo.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Izquierdo -->
        <div class="auth-brand-bottom">
            <span><i class="fas fa-credit-card" style="color: #10B981; margin-right: 6px;"></i> Sin tarjeta de crédito requerida</span>
            <span>&copy; {{ date('Y') }} {{ config('app.name') }}</span>
        </div>
    </div>

    <!-- Panel Derecho: Formulario Wizard de 3 Pasos -->
    <div class="auth-form-side" style="overflow-y: auto;" id="auth-form-scroll-container">
        <!-- Top Nav en el Panel Derecho -->
        <div class="auth-form-top-nav">
            <a href="{{ url('/') }}" class="auth-nav-action-link">
                <i class="fas fa-home"></i> Inicio
            </a>
            
            <a href="{{ route('login') }}" class="auth-nav-action-link" style="color: #FB4C0A; border-color: rgba(251, 76, 10, 0.35); background: rgba(251, 76, 10, 0.1);">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </a>

            <div style="display: inline-block;">
                @include('layouts.partials.language_btn')
            </div>
        </div>

        <!-- Contenedor Central del Formulario -->
        <div class="auth-form-center-box auth-register-box">
            <!-- Barra de Progreso del Wizard (3 Pasos) -->
            <div class="auth-wizard-header">
                <div class="auth-wizard-step active" data-step="1">
                    <div class="auth-wizard-badge">1</div>
                    <span class="auth-wizard-title">Datos del Negocio</span>
                </div>
                <div class="auth-wizard-line"></div>
                <div class="auth-wizard-step" data-step="2">
                    <div class="auth-wizard-badge">2</div>
                    <span class="auth-wizard-title">Configuración</span>
                </div>
                <div class="auth-wizard-line"></div>
                <div class="auth-wizard-step" data-step="3">
                    <div class="auth-wizard-badge">3</div>
                    <span class="auth-wizard-title">Administrador</span>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <h2 class="auth-header-title" id="wizard-title-display">Datos de tu Empresa 🏢</h2>
                <p class="auth-header-sub" id="wizard-desc-display">Paso 1 de 3: Cuéntanos sobre tu negocio para preparar tu entorno</p>
            </div>

            @if ($errors->any())
                <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35); border-radius: 20px; padding: 16px 20px; margin-bottom: 24px; color: #FCA5A5; font-size: 13px;">
                    <div style="font-weight: 700; display: flex; align-items: center; gap: 8px; margin-bottom: 8px; color: #EF4444;">
                        <i class="fas fa-exclamation-triangle"></i>
                        Por favor revisa y corrige los siguientes errores:
                    </div>
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li style="margin-bottom: 4px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {!! Form::open([
                'url' => route('business.postRegister'),
                'method' => 'post',
                'id' => 'business_register_form',
                'files' => true,
            ]) !!}
            
            <div class="modern-register-wrapper">
                @include('business.partials.register_form')
            </div>
            
            {!! Form::hidden('package_id', $package_id) !!}
            {!! Form::close() !!}

            <div style="text-align: center; margin-top: 24px; font-size: 14px; color: var(--auth-text-muted);">
                ¿Ya tienes una cuenta registrada? 
                <a href="{{ route('login') }}" class="auth-forgot-link" style="margin-left: 4px;">
                    Inicia Sesión aquí
                </a>
            </div>
        </div>

        <!-- Footer Derecho -->
        <div class="auth-form-footer" style="padding-top: 24px;">
            ¿Dudas o preguntas? Escríbenos a <a href="mailto:soporte@kubre.site" style="color: #FB4C0A; text-decoration: none;">soporte@kubre.site</a>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        $('.change_lang').click(function() {
            window.location = "{{ route('business.getRegister') }}?lang=" + $(this).attr('value');
        });
        $('.select2_register').select2({
            width: '100%'
        });

        const stepTitles = {
            1: { title: "Datos de tu Empresa 🏢", desc: "Paso 1 de 3: Cuéntanos sobre tu negocio para preparar tu entorno" },
            2: { title: "Ajustes & Moneda ⚙️", desc: "Paso 2 de 3: Configura impuestos, año fiscal y método de contabilidad" },
            3: { title: "Cuenta del Propietario 👤", desc: "Paso 3 de 3: Define el usuario principal para acceder al sistema" }
        };

        let currentStep = 1;

        function validateStep(stepIndex) {
            let valid = true;
            const currentPane = $('#auth-step-' + stepIndex);
            
            currentPane.find('input[required], select[required]').each(function() {
                const val = $(this).val();
                if (!val || (typeof val === 'string' && val.trim() === '')) {
                    valid = false;
                    $(this).closest('.input-group').addClass('has-error');
                } else {
                    $(this).closest('.input-group').removeClass('has-error');
                }
            });

            if (stepIndex === 3) {
                const pass = $('#password').val();
                const confirmPass = $('#confirm_password').val();
                if (pass && pass.length < 4) {
                    valid = false;
                    $('#password').closest('.input-group').addClass('has-error');
                }
                if (pass !== confirmPass) {
                    valid = false;
                    $('#confirm_password').closest('.input-group').addClass('has-error');
                }
            }

            return valid;
        }

        function goToStep(step) {
            // Permitir siempre regresar sin bloquear
            if (step < currentStep) {
                showStep(step);
                return;
            }

            // Validar paso actual antes de avanzar
            if (step > currentStep) {
                if (!validateStep(currentStep)) {
                    // Resaltar primer campo con error
                    const firstError = $('#auth-step-' + currentStep).find('.input-group.has-error input, .input-group.has-error select').first();
                    if (firstError.length) {
                        firstError.focus();
                    }
                    return false;
                }
                showStep(step);
            }
        }

        function showStep(step) {
            // Cambiar pane activo
            $('.auth-step-pane').removeClass('active');
            $('#auth-step-' + step).addClass('active');

            // Re-render Select2 in newly visible pane
            $('.select2_register').select2({
                width: '100%'
            });

            // Actualizar wizard steps
            $('.auth-wizard-step').each(function() {
                const s = parseInt($(this).data('step'));
                $(this).removeClass('active completed');
                if (s === step) {
                    $(this).addClass('active');
                } else if (s < step) {
                    $(this).addClass('completed');
                }
            });

            // Actualizar títulos
            if (stepTitles[step]) {
                $('#wizard-title-display').text(stepTitles[step].title);
                $('#wizard-desc-display').text(stepTitles[step].desc);
            }

            currentStep = step;

            // Scroll suave hacia arriba en el panel
            $('#auth-form-scroll-container').animate({ scrollTop: 0 }, 150);
        }

        // Limpiar estado de error al escribir
        $(document).on('input change', '.modern-register-wrapper input, .modern-register-wrapper select', function() {
            if ($(this).val() && $(this).val().trim() !== '') {
                $(this).closest('.input-group').removeClass('has-error');
            }
        });

        // Botón Siguiente
        $(document).on('click', '.btn-wizard-next', function(e) {
            e.preventDefault();
            const nextStep = parseInt($(this).data('next'));
            goToStep(nextStep);
        });

        // Botón Anterior
        $(document).on('click', '.btn-wizard-prev', function(e) {
            e.preventDefault();
            const prevStep = parseInt($(this).data('prev'));
            goToStep(prevStep);
        });

        // Click en los pasos superiores
        $('.auth-wizard-step').on('click', function() {
            const targetStep = parseInt($(this).data('step'));
            goToStep(targetStep);
        });

        // Manejo del Submit Final
        $('#business_register_form').on('submit', function(e) {
            // Validar paso 1
            if (!validateStep(1)) {
                e.preventDefault();
                showStep(1);
                return false;
            }
            // Validar paso 2
            if (!validateStep(2)) {
                e.preventDefault();
                showStep(2);
                return false;
            }
            // Validar paso 3
            if (!validateStep(3)) {
                e.preventDefault();
                showStep(3);
                return false;
            }

            const btn = $('#btn-submit-register');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Registrando empresa...');
            return true;
        });
    });

    function previewLogoName(input) {
        if (input.files && input.files[0]) {
            $('#logo_filename_display').text(input.files[0].name);
        }
    }
</script>
<style>
    .modern-register-wrapper fieldset {
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 25px !important;
        padding: 24px 28px !important;
        margin-bottom: 20px !important;
        background: rgba(14, 19, 38, 0.75) !important;
        backdrop-filter: blur(16px) !important;
        -webkit-backdrop-filter: blur(16px) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35) !important;
    }
    .modern-register-wrapper legend {
        border: none !important;
        width: auto !important;
        padding: 6px 20px !important;
        font-size: 14px !important;
        font-weight: 800 !important;
        color: #FFFFFF !important;
        background: linear-gradient(135deg, #FB4C0A 0%, #E03E00 100%) !important;
        border-radius: 20px !important;
        margin-bottom: 20px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        box-shadow: 0 4px 14px rgba(251, 76, 10, 0.35) !important;
    }
    .modern-register-wrapper label {
        color: #E2E8F0 !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        margin-bottom: 6px !important;
        display: block !important;
    }
    .modern-register-wrapper .form-group {
        margin-bottom: 16px !important;
    }
    .modern-register-wrapper .input-group {
        display: flex !important;
        width: 100% !important;
        border-radius: 25px !important;
        overflow: hidden !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        background: rgba(7, 10, 22, 0.9) !important;
        transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
    }
    .modern-register-wrapper .input-group:focus-within {
        border-color: #FB4C0A !important;
        box-shadow: 0 0 0 3px rgba(251, 76, 10, 0.25) !important;
    }
    .modern-register-wrapper .input-group-addon {
        background: rgba(26, 35, 60, 0.9) !important;
        border: none !important;
        color: #FB4C0A !important;
        width: 48px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 15px !important;
        padding: 0 !important;
    }
    .modern-register-wrapper .form-control {
        background: transparent !important;
        border: none !important;
        color: #FFFFFF !important;
        height: 48px !important;
        padding: 0 16px !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        outline: none !important;
        box-shadow: none !important;
        flex: 1 !important;
    }
    .modern-register-wrapper .form-control::placeholder {
        color: #64748B !important;
    }
    .modern-register-wrapper .select2-container--default {
        flex: 1 !important;
    }
    .modern-register-wrapper .select2-container--default .select2-selection--single {
        background: transparent !important;
        border: none !important;
        height: 48px !important;
        display: flex !important;
        align-items: center !important;
    }
    .modern-register-wrapper .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #FFFFFF !important;
        padding-left: 16px !important;
        font-size: 14px !important;
    }
    .modern-register-wrapper .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 48px !important;
        right: 12px !important;
    }
    .modern-register-wrapper .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #94A3B8 transparent transparent transparent !important;
    }
    .modern-register-wrapper .auth-file-upload-box {
        position: relative;
        width: 100%;
        height: 48px;
        border-radius: 25px;
        border: 1px dashed rgba(251, 76, 10, 0.5);
        background: rgba(7, 10, 22, 0.9);
        display: flex;
        align-items: center;
        padding: 0 18px;
        cursor: pointer;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .modern-register-wrapper .auth-file-upload-box:hover {
        border-color: #FB4C0A;
        background: rgba(251, 76, 10, 0.08);
        box-shadow: 0 0 15px rgba(251, 76, 10, 0.2);
    }
    .modern-register-wrapper .auth-file-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 10;
    }
    .modern-register-wrapper .auth-file-custom-ui {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        pointer-events: none;
    }
    .modern-register-wrapper .auth-file-icon {
        font-size: 20px;
        color: #FB4C0A;
        flex-shrink: 0;
    }
    .modern-register-wrapper .auth-file-info {
        display: flex;
        align-items: baseline;
        gap: 8px;
        overflow: hidden;
    }
    .modern-register-wrapper .auth-file-text {
        font-size: 13px;
        font-weight: 600;
        color: #FFFFFF;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .modern-register-wrapper .auth-file-hint {
        font-size: 11px;
        color: #94A3B8;
    }
    .modern-register-wrapper input[type="checkbox"] {
        accent-color: #FB4C0A;
        width: 16px;
        height: 16px;
        margin-right: 8px;
    }
    .modern-register-wrapper a.terms_condition {
        color: #FB4C0A !important;
        text-decoration: none !important;
    }
    .modern-register-wrapper a.terms_condition:hover {
        text-decoration: underline !important;
    }
</style>
@endsection
