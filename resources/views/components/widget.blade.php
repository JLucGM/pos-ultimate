<div class="{{$class ?? ''}} box box-solid tw-mb-5 tw-bg-white tw-shadow-sm tw-rounded-2xl tw-border tw-border-slate-200"
    @if (!empty($id)) id="{{ $id }}" @endif>
    <div style="padding: 6px 10px;">
        @if (empty($header))
            @if (!empty($title) || !empty($tool))
                <div class="box-header" style="border-bottom: 1px solid #F1F5F9; padding: 14px 18px;">
                    {!! $icon ?? '' !!}
                    <h3 class="box-title" style="margin: 0; font-size: 16px; font-weight: 800; color: #0F172A;">{{ $title ?? '' }}</h3>
                    {!! $tool ?? '' !!}

                    @if (isset($help_text))
                        <br />
                        <small style="color: #64748B; font-weight: 500;">{!! $help_text !!}</small>
                    @endif
                </div>
            @endif
        @else
            <div class="box-header" style="border-bottom: 1px solid #F1F5F9; padding: 14px 18px;">
                {!! $header !!}
            </div>
        @endif
        <div class="tw-flow-root" style="padding: 10px 14px;">
            {{ $slot }}
        </div>
    </div>
</div>
