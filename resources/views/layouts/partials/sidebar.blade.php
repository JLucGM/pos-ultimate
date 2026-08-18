<!-- Left side column. contains the logo and sidebar -->
<aside class="side-bar tw-relative tw-hidden tw-h-full tw-bg-white tw-w-64 xl:tw-w-64 lg:tw-flex lg:tw-flex-col tw-shrink-0">

    <!-- sidebar: style can be found in sidebar.less -->

    {{-- <a href="{{route('home')}}" class="logo">
		<span class="logo-lg">{{ Session::get('business.name') }}</span>
	</a> --}}

    <a href="{{route('home')}}" class="audaz-sidebar-header">
        <img src="{{ asset('images/logo.svg') }}" alt="{{ Session::get('business.name', 'Kubre') }}" class="audaz-sidebar-logo" />
        <span class="tw-ml-auto tw-inline-flex tw-items-center tw-gap-1.5 tw-px-2 tw-py-0.5 tw-rounded-full tw-text-[10px] tw-font-semibold tw-bg-emerald-500/10 tw-text-emerald-400 tw-border tw-border-emerald-500/20">
            <span class="tw-w-1.5 tw-h-1.5 tw-rounded-full tw-bg-emerald-400 tw-animate-pulse"></span>
            PRO
        </span>
    </a>

    <!-- Sidebar Menu -->
    {!! Menu::render('admin-sidebar-menu', 'adminltecustom') !!}

    <!-- /.sidebar-menu -->
    <!-- /.sidebar -->
</aside>
