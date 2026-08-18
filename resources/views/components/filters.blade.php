{{-- <div class="box @if (!empty($class)) {{$class}} @else box-solid @endif" id="accordion">
  <div class="box-header with-border" style="cursor: pointer;">
    <h3 class="box-title">
      <a data-toggle="collapse" data-parent="#accordion" href="#collapseFilter">
        @if (!empty($icon)) {!! $icon !!} @else <i class="fa fa-filter" aria-hidden="true"></i> @endif {{$title ?? ''}}
      </a>
    </h3>
  </div>
  @php
    if(isMobile()) {
      $closed = true;
    }
  @endphp
  <div id="collapseFilter" class="panel-collapse active collapse @if (empty($closed)) in @endif" aria-expanded="true">
    <div class="box-body">
      {{$slot}}
    </div>
  </div>
</div> --}}


<div class="box box-solid tw-mb-4 tw-rounded-2xl tw-bg-white tw-shadow-sm tw-border tw-border-slate-200">
    <div class="box-header with-border" style="cursor: pointer; padding: 14px 20px;">
        <h3 class="box-title" style="margin: 0; font-size: 15px; font-weight: 800; color: #0F172A;">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFilter" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                @if (!empty($icon))
                    {!! $icon !!}
                @else
                    <i class="fas fa-filter tw-text-[#FB4C0A]"></i>
                @endif
                {{ $title ?? 'Filtros de Búsqueda' }}
                <i class="fas fa-chevron-down tw-text-xs tw-text-slate-400 tw-ml-auto"></i>
            </a>
        </h3>
    </div>
    @php
        $closed = true;
        if (!isMobile()) {
            $closed = false;
        }
    @endphp
    <div id="collapseFilter" class="panel-collapse active collapse @if (empty($closed)) in @endif" aria-expanded="true">
        <div class="box-body" style="padding: 16px 20px; background: #F8FAFC; border-top: 1px solid #E2E8F0; border-radius: 0 0 16px 16px;">
            {{ $slot }}
        </div>
    </div>
</div>
