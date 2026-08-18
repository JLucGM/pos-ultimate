@extends('layouts.auth2')
@section('title', __('lang_v1.reset_password'))

@section('content')
<div class="auth-fullscreen-layout" style="align-items: center; justify-content: center; padding: 40px 20px;">
    <div style="width: 100%; max-width: 480px; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 25px; padding: 40px; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);">
        
        <div style="text-align: center; margin-bottom: 28px;">
            <div style="width: 60px; height: 60px; border-radius: 25px; background: rgba(251, 76, 10, 0.15); border: 1px solid rgba(251, 76, 10, 0.35); display: inline-flex; align-items: center; justify-content: center; color: #FB4C0A; font-size: 24px; margin-bottom: 16px;">
                <i class="fas fa-key"></i>
            </div>
            <h2 class="auth-header-title" style="font-size: 24px;">@lang('lang_v1.reset_password')</h2>
            <p class="auth-header-sub">@lang('lang_v1.send_password_reset_link')</p>
        </div>

        @if (session('status') && is_string(session('status')))
            <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 25px; padding: 14px 18px; margin-bottom: 20px; color: #6EE7B7; font-size: 13px; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-check-circle" style="flex-shrink: 0;"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div class="auth-group">
                <label for="email" class="auth-form-label">@lang('business.email')</label>
                <div class="auth-field-wrapper">
                    <input 
                        id="email" 
                        type="email" 
                        class="auth-text-input" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        placeholder="@lang('lang_v1.email_address')"
                    >
                    <i class="fas fa-envelope auth-field-icon"></i>
                </div>
                @if ($errors->has('email'))
                    <span style="color: #F87171; font-size: 12px; margin-top: 4px; display: block;">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>

            <div style="margin-top: 24px;">
                <button type="submit" class="auth-btn-primary">
                    <span>@lang('lang_v1.send_password_reset_link')</span>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>

        <div style="text-align: center; margin-top: 28px; font-size: 14px;">
            <a href="{{ route('login') }}" class="auth-forgot-link" style="display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-arrow-left"></i>
                Volver a iniciar sesión
            </a>
        </div>
    </div>
</div>
@endsection