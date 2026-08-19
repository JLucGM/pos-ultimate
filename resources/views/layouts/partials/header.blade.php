@inject('request', 'Illuminate\Http\Request')
<!-- AudazPOS Pro Master Header -->
<div class="audaz-topbar no-print">
    <!-- Left Section: Sidebar Toggle & Mobile Menu -->
    <div class="audaz-topbar-left">
        <button type="button" 
            class="small-view-button audaz-top-btn lg:tw-hidden"
            title="Menu">
            <svg aria-hidden="true" class="tw-size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 6l16 0" />
                <path d="M4 12l16 0" />
                <path d="M4 18l16 0" />
            </svg>
        </button>

        <button type="button"
            class="side-bar-collapse audaz-top-btn tw-hidden lg:tw-inline-flex"
            title="Colapsar Sidebar">
            <svg aria-hidden="true" class="tw-size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                <path d="M15 4v16" />
                <path d="M10 10l-2 2l2 2" />
            </svg>
        </button>

        {{-- Active SaaS package badge --}}
        @if(Module::has('Superadmin'))
            @includeIf('superadmin::layouts.partials.active_subscription')
        @endif

        {{-- Switch back button for superadmin --}}
        @if(!empty(session('previous_user_id')) && !empty(session('previous_username')))
            <a href="{{route('sign-in-as-user', session('previous_user_id'))}}" class="btn btn-flat btn-danger btn-sm" style="border-radius: 8px;">
                <i class="fas fa-undo"></i> @lang('lang_v1.back_to_username', ['username' => session('previous_username')])
            </a>
        @endif
    </div>

    <!-- Center Section: Quick Global Search -->
    <div class="audaz-topbar-center">
        <div class="audaz-global-search">
            <i class="fas fa-search audaz-global-search-icon"></i>
            <input type="text" id="audaz-global-search-bar" class="audaz-global-search-input" placeholder="Buscar productos, clientes, ventas o facturas..." autocomplete="off">
            <span class="audaz-search-kbd">⌘K</span>
        </div>
    </div>

    <!-- Right Section: Actions, POS Button & User Profile -->
    <div class="audaz-topbar-right">
        @if (Module::has('Essentials'))
            @includeIf('essentials::layouts.partials.header_part')
        @endif

        <!-- Direct POS Action Button -->
        @if (in_array('pos_sale', $enabled_modules))
            @can('sell.create')
                <a href="{{ action([\App\Http\Controllers\SellPosController::class, 'create']) }}" class="btn-audaz-pos">
                    <i class="fas fa-cash-register"></i>
                    <span>@lang('sale.pos_sale')</span>
                </a>
            @endcan
        @endif

        <!-- Quick Calendar & Tools Dropdown -->
        <details class="tw-dw-dropdown tw-relative tw-inline-block tw-text-left">
            <summary class="audaz-top-btn" title="Herramientas y Accesos Rápidos">
                <i class="fas fa-th"></i>
            </summary>
            <ul class="audaz-dropdown-menu" role="menu" tabindex="-1">
                <div class="audaz-dropdown-header">
                    <p class="audaz-dropdown-header-subtitle">Accesos Rápidos</p>
                    <p class="audaz-dropdown-header-title">Herramientas</p>
                </div>
                <li>
                    <a href="{{ route('calendar') }}" class="audaz-dropdown-item" role="menuitem">
                        <i class="fas fa-calendar-alt tw-text-indigo-400"></i>
                        <span>@lang('lang_v1.calendar')</span>
                    </a>
                </li>

                <!-- Calculadora (Integrada en Dropdown para móvil) -->
                <li>
                    <a href="javascript:void(0);" id="btnCalculatorMobile" title="@lang('lang_v1.calculator')" 
                        data-content='@include('layouts.partials.calculator')'
                        data-trigger="click" data-html="true" data-placement="bottom"
                        class="audaz-dropdown-item" role="menuitem">
                        <i class="fas fa-calculator tw-text-amber-400"></i>
                        <span>@lang('lang_v1.calculator')</span>
                    </a>
                </li>

                <!-- Ganancias de Hoy (Integrada en Dropdown para móvil) -->
                @can('profit_loss_report.view')
                <li>
                    <a href="javascript:void(0);" id="view_todays_profit_mobile" title="{{ __('home.todays_profit') }}"
                        class="audaz-dropdown-item" role="menuitem">
                        <i class="fas fa-chart-line tw-text-emerald-400"></i>
                        <span>{{ __('home.todays_profit') }}</span>
                    </a>
                </li>
                @endcan

                @if (Module::has('Essentials'))
                <li>
                    <a href="#"
                        data-href="{{ action([\Modules\Essentials\Http\Controllers\ToDoController::class, 'create']) }}"
                        data-container="#task_modal"
                        class="btn-modal audaz-dropdown-item"
                        role="menuitem">
                        <i class="fas fa-tasks tw-text-emerald-400"></i>
                        <span>@lang('essentials::lang.add_to_do')</span>
                    </a>
                </li>
                @endif
                @if (auth()->user()->hasRole('Admin#' . auth()->user()->business_id))
                <li>
                    <a href="#" id="start_tour" class="audaz-dropdown-item" role="menuitem">
                        <i class="fas fa-compass tw-text-sky-400"></i>
                        <span>@lang('lang_v1.application_tour')</span>
                    </a>
                </li>
                @endif
            </ul>
        </details>

        <!-- Calculadora Popover (Solo Desktop) -->
        <button id="btnCalculator" title="@lang('lang_v1.calculator')" data-content='@include('layouts.partials.calculator')'
            type="button" data-trigger="click" data-html="true" data-placement="bottom" 
            class="audaz-top-btn tw-hidden lg:tw-inline-flex">
            <i class="fas fa-calculator"></i>
        </button>

        <!-- Ganancias de Hoy (Solo Desktop) -->
        @can('profit_loss_report.view')
            <button type="button" id="view_todays_profit" title="{{ __('home.todays_profit') }}"
                data-toggle="tooltip" data-placement="bottom"
                class="audaz-top-btn tw-hidden lg:tw-inline-flex">
                <i class="fas fa-chart-line tw-text-emerald-400"></i>
            </button>
        @endcan

        <!-- Reloj / Fecha en Vivo (Solo Pantallas Grandes) -->
        <div class="tw-hidden xl:tw-inline-flex tw-items-center tw-gap-1.5 tw-px-3 tw-py-1.5 tw-rounded-xl tw-bg-white/5 tw-border tw-border-white/10 tw-text-xs tw-font-semibold tw-text-slate-300">
            <i class="fas fa-clock tw-text-orange-500"></i>
            <span class="tw-font-mono">{{ @format_date('now') }}</span>
        </div>

        <!-- Notificaciones -->
        @include('layouts.partials.header-notifications')

        <!-- User Profile Dropdown -->
        <details class="tw-dw-dropdown tw-relative tw-inline-block tw-text-left">
            <summary class="audaz-user-profile-btn">
                <div class="audaz-user-avatar">
                    {{ strtoupper(substr(Auth::User()->first_name, 0, 1)) }}
                </div>
                <div class="audaz-user-info-text">
                    <span class="audaz-user-name">{{ Auth::User()->first_name }}</span>
                    <span class="audaz-user-role">
                        @if(Auth::User()->hasRole('Admin#' . Auth::User()->business_id))
                            Admin
                        @else
                            Usuario
                        @endif
                    </span>
                </div>
                <i class="fas fa-chevron-down tw-text-xs tw-text-slate-400 tw-ml-1"></i>
            </summary>

            <ul class="audaz-dropdown-menu" role="menu" tabindex="-1">
                <div class="audaz-dropdown-header">
                    <p class="audaz-dropdown-header-subtitle">
                        @lang('lang_v1.signed_in_as')
                    </p>
                    <p class="audaz-dropdown-header-title">
                        {{ Auth::User()->first_name }} {{ Auth::User()->last_name }}
                    </p>
                </div>

                <li>
                    <a href="{{ action([\App\Http\Controllers\UserController::class, 'getProfile']) }}"
                        class="audaz-dropdown-item"
                        role="menuitem">
                        <i class="fas fa-user-circle"></i>
                        <span>@lang('lang_v1.profile')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ action([\App\Http\Controllers\Auth\LoginController::class, 'logout']) }}"
                        class="audaz-dropdown-item danger"
                        role="menuitem">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>@lang('lang_v1.sign_out')</span>
                    </a>
                </li>
            </ul>
        </details>
    </div>
</div>
