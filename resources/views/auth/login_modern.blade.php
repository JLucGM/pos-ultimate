@extends('layouts.auth_modern')
@section('title', __('lang_v1.login'))

@section('content')
<div class="auth-container">
    <!-- Left Side - Branding -->
    <div class="auth-left">
        <div class="auth-branding">
            <div class="brand-logo">
                <img src="{{ asset('img/logo_v2_full.png') }}" alt="{{ config('app.name', 'Kubre') }}" class="logo-img" style="max-height: 48px; width: auto;">
            </div>
            <h1 class="brand-title">{{ config('app.name', 'Kubre') }}</h1>
            <p class="brand-subtitle">Plataforma de gestión empresarial y control en la nube</p>
            
            <div class="features-list">
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Gestión de inventario en tiempo real</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Reportes y análisis detallados</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Multi-sucursal y multi-usuario</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Acceso desde cualquier dispositivo</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="auth-right">
        <div class="auth-form-container">
            <div class="auth-header">
                <h2 class="auth-title">¡Bienvenido de vuelta!</h2>
                <p class="auth-subtitle">Ingresa a tu cuenta</p>
            </div>

            <form method="POST" action="{{ route('login') }}" id="login-form" class="auth-form">
                @csrf

                <!-- Username -->
                <div class="form-group">
                    <label for="username" class="form-label">Usuario</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            class="form-input {{ $errors->has('username') ? 'error' : '' }}"
                            placeholder="Ingresa tu usuario"
                            value="{{ old('username') }}"
                            required 
                            autofocus
                        >
                    </div>
                    @if ($errors->has('username'))
                        <span class="error-message">{{ $errors->first('username') }}</span>
                    @endif
                </div>

                <!-- Password -->
                <div class="form-group">
                    <div class="form-label-row">
                        <label for="password" class="form-label">Contraseña</label>
                        @if (config('app.env') != 'demo')
                            <a href="{{ route('password.request') }}" class="forgot-link">¿Olvidaste tu contraseña?</a>
                        @endif
                    </div>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                            placeholder="Ingresa tu contraseña"
                            required
                        >
                        <button type="button" class="toggle-password" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @if ($errors->has('password'))
                        <span class="error-message">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkbox-text">Recordarme</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    <span>Iniciar Sesión</span>
                    <i class="fas fa-arrow-right"></i>
                </button>

                <!-- Register Link -->
                @if (config('constants.allow_registration'))
                    <div class="auth-footer">
                        <p class="footer-text">
                            ¿No tienes una cuenta? 
                            <a href="{{ route('business.getRegister') }}" class="footer-link">Regístrate ahora</a>
                        </p>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
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
});
</script>
@endsection
