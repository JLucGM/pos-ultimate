<!-- Kubre OS Floating Island Sidebar -->
<aside class="side-bar" id="kubre-classic-sidebar">

    <!-- Floating Sidebar Header -->
    <div class="audaz-sidebar-header">
        <a href="{{route('home')}}" class="audaz-sidebar-brand">
            <img src="{{ asset('img/logo_v2_full.png') }}" alt="{{ Session::get('business.name', 'Kubre') }}" class="audaz-sidebar-logo" style="max-height: 38px; width: auto;" />
            <span class="tw-inline-flex tw-items-center tw-gap-1 tw-px-2 tw-py-0.5 tw-rounded-full tw-text-[9px] tw-font-bold tw-bg-emerald-500/15 tw-text-emerald-400 tw-border tw-border-emerald-500/20">
                <span class="tw-w-1.5 tw-h-1.5 tw-rounded-full tw-bg-emerald-400 tw-animate-pulse"></span>
                PRO
            </span>
        </a>

        <!-- Botón de repliegue / cerrar sidebar dentro de la isla -->
        <button type="button" class="side-bar-collapse kubre-sidebar-close-btn" title="Ocultar barra lateral">
            <svg class="tw-w-4 tw-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>
    </div>

    <!-- Sidebar Menu Scrollable Area -->
    <div class="kubre-sidebar-menu-wrapper">
        {!! Menu::render('admin-sidebar-menu', 'adminltecustom') !!}
    </div>

    <!-- Floating Sidebar Footer Status Pill -->
    <div class="kubre-sidebar-footer">
        <div class="tw-flex tw-items-center tw-gap-1.5">
            <span class="kubre-status-dot"></span>
            <span class="tw-font-medium">Kubre OS</span>
        </div>
        <span class="tw-text-[10px] tw-opacity-60 tw-font-mono">v6.7</span>
    </div>
</aside>
