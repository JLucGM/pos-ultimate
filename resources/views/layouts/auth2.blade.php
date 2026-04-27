<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'POS') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    @include('layouts.partials.css')

    @include('layouts.partials.extracss_auth')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>

<body class="pace-done" data-new-gr-c-s-check-loaded="14.1172.0" data-gr-ext-installed="" cz-shortcut-listen="true">
    @inject('request', 'Illuminate\Http\Request')
    @if (session('status') && session('status.success'))
        <input type="hidden" id="status_span" data-status="{{ session('status.success') }}"
            data-msg="{{ session('status.msg') }}">
    @endif
    <div class="container-fluid">
        <div class="row eq-height-row">
            <div class="col-md-12 col-sm-12 col-xs-12 right-col tw-pb-10 tw-px-5">
                {{-- Navbar --}}
                <nav class="tw-flex tw-items-center tw-justify-between tw-px-4 md:tw-px-8 tw-py-4 tw-mb-8">
                    {{-- Logo + Nombre --}}
                    <a href="{{ url('/') }}" class="tw-flex tw-items-center tw-gap-3 tw-no-underline tw-group">
                        <div class="tw-w-10 tw-h-10 md:tw-w-12 md:tw-h-12 tw-flex tw-items-center tw-justify-center tw-overflow-hidden tw-rounded-xl tw-bg-white/10 tw-backdrop-blur-sm tw-ring-1 tw-ring-white/20 group-hover:tw-ring-white/40 tw-transition-all tw-duration-200">
                            <img src="{{ asset('img/logo-small4.png')}}" alt="{{ config('app.name') }}" class="tw-w-8 tw-h-8 md:tw-w-10 md:tw-h-10 tw-object-contain" />
                        </div>
                        <span class="tw-text-white tw-font-semibold tw-text-lg tw-hidden md:tw-inline-block">{{ config('app.name', 'Audaz POS') }}</span>
                    </a>

                    {{-- Acciones --}}
                    <div class="tw-flex tw-items-center tw-gap-3">
                        @if(config('constants.SHOW_REPAIR_STATUS_LOGIN_SCREEN') && Route::has('repair-status'))
                            <a class="tw-text-white/70 tw-font-medium tw-text-sm hover:tw-text-white tw-transition-colors tw-no-underline"
                                href="{{ action([\Modules\Repair\Http\Controllers\CustomerRepairStatusController::class, 'index']) }}">
                                @lang('repair::lang.repair_status')
                            </a>
                        @endif

                        @if(Route::has('member_scanner'))
                            <a class="tw-text-white/70 tw-font-medium tw-text-sm hover:tw-text-white tw-transition-colors tw-no-underline"
                                href="{{ action([\Modules\Gym\Http\Controllers\MemberController::class, 'member_scanner']) }}">
                                @lang('gym::lang.gym_member_profile')
                            </a>
                        @endif

                        {{-- Pricing --}}
                        @if (Route::has('pricing') && config('app.env') != 'demo' && $request->segment(1) != 'pricing')
                            <a class="tw-text-white/70 tw-font-medium tw-text-sm hover:tw-text-white tw-transition-colors tw-no-underline"
                                href="{{ route('pricing') }}">@lang('superadmin::lang.pricing')</a>
                        @endif

                        {{-- Botón Registrarse (si estamos en login) --}}
                        @if (!($request->segment(1) == 'business' && $request->segment(2) == 'register'))
                            @if (config('constants.allow_registration'))
                                <a href="{{ route('business.getRegister')}}@if(!empty(request()->lang)){{'?lang='.request()->lang}}@endif"
                                    class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-white tw-rounded-lg tw-ring-1 tw-ring-white/30 hover:tw-bg-white/10 tw-transition-all tw-duration-200 tw-no-underline hover:tw-text-white">
                                    {{ __('business.register') }}
                                </a>
                            @endif
                        @endif

                        {{-- Botón Iniciar Sesión (si estamos en registro) --}}
                        @if ($request->segment(1) != 'login')
                            <a href="{{ action([\App\Http\Controllers\Auth\LoginController::class, 'login'])}}@if(!empty(request()->lang)){{'?lang='.request()->lang}}@endif"
                                class="tw-inline-flex tw-items-center tw-gap-2 tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-white tw-bg-white/10 tw-backdrop-blur-sm tw-rounded-lg tw-ring-1 tw-ring-white/20 hover:tw-bg-white/20 tw-transition-all tw-duration-200 tw-no-underline hover:tw-text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-4 tw-h-4" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                                {{ __('business.sign_in') }}
                            </a>
                        @endif

                        @include('layouts.partials.language_btn')
                    </div>
                </nav>

                <div class="row">
                @yield('content')
                </div>
            </div>
        </div>
    </div>


    @include('layouts.partials.javascripts')

    <!-- Scripts -->
    <script src="{{ asset('js/login.js?v=' . $asset_v) }}"></script>

    @yield('javascript')

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2_register').select2();

            // $('input').iCheck({
            //     checkboxClass: 'icheckbox_square-blue',
            //     radioClass: 'iradio_square-blue',
            //     increaseArea: '20%' // optional
            // });
        });
    </script>
    <style>
        .wizard>.content {
            background-color: white !important;
        }
    </style>
</body>

</html>
