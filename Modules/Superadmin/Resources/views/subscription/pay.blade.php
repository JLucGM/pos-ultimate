@extends($layout)

@section('title', __('superadmin::lang.subscription'))

@section('content')

<!-- Main content -->
<section class="content">

	@include('superadmin::layouts.partials.currency')

    @php
        $effective_price_usd = (float)($coupon_status['status'] == 'success' ? $package_price_after_discount : $package->price);
        $rate_bcv = (!empty($bcv_rate) && $bcv_rate > 1) ? (float)$bcv_rate : 1;
        $price_bs = $effective_price_usd * $rate_bcv;
    @endphp

	<div class="box box-success" style="border-top-color: #FB4C0A; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.06);">
        <div class="box-header with-border" style="padding: 20px 24px;">
            <h3 class="box-title" style="font-weight: 800; color: #0F172A; font-size: 20px;">
                <i class="fas fa-credit-card" style="color: #FB4C0A; margin-right: 8px;"></i>
                @lang('superadmin::lang.pay_and_subscribe')
            </h3>
        </div>

        <div class="box-body" style="padding: 24px;">
    		<div class="col-md-9">
                <!-- Resumen de Plan y Dualidad de Monedas (USD / Bs BCV) -->
                <div style="background: linear-gradient(135deg, rgba(251, 76, 10, 0.06) 0%, rgba(15, 23, 42, 0.04) 100%); border: 1px solid rgba(251, 76, 10, 0.25); border-radius: 16px; padding: 22px 24px; margin-bottom: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                        <div>
                            <span style="font-size: 11px; text-transform: uppercase; font-weight: 800; color: #FB4C0A; letter-spacing: 0.8px;">Plan de Suscripción</span>
                            <h2 style="margin: 4px 0 2px 0; font-weight: 800; color: #0F172A; font-size: 24px;">{{ $package->name }}</h2>
                            <span style="color: #64748B; font-weight: 600; font-size: 13px;">
                                <i class="far fa-calendar-alt"></i> Facturación: Cada {{ $package->interval_count }} {{ ucfirst($package->interval) }}
                            </span>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 28px; font-weight: 900; color: #0F172A; line-height: 1.1;">
                                $ {{ number_format($effective_price_usd, 2) }} <span style="font-size: 14px; font-weight: 700; color: #64748B;">USD</span>
                            </div>
                            @if($rate_bcv > 1)
                                <div style="font-size: 20px; font-weight: 800; color: #FB4C0A; margin-top: 4px;">
                                    Bs. {{ number_format($price_bs, 2, ',', '.') }}
                                </div>
                                <div style="font-size: 11px; font-weight: 600; color: #64748B; margin-top: 2px;">
                                    <i class="fas fa-university"></i> Tasa Oficial BCV: <strong>Bs. {{ number_format($rate_bcv, 2, ',', '.') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Características incluidas en el paquete -->
        		<div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px;">
                    <div style="font-weight: 700; color: #334155; margin-bottom: 12px; font-size: 14px;">
                        <i class="fas fa-check-circle text-success"></i> Beneficios y límites de tu plan:
                    </div>
                    <div class="row" style="font-size: 13px; color: #475569;">
                        <div class="col-sm-6" style="margin-bottom: 8px;">
                            <i class="fa fa-check text-success"></i> 
                            <strong>{{ $package->location_count == 0 ? __('superadmin::lang.unlimited') : $package->location_count }}</strong> @lang('business.business_locations')
                        </div>
                        <div class="col-sm-6" style="margin-bottom: 8px;">
                            <i class="fa fa-check text-success"></i> 
                            <strong>{{ $package->user_count == 0 ? __('superadmin::lang.unlimited') : $package->user_count }}</strong> @lang('superadmin::lang.users')
                        </div>
                        <div class="col-sm-6" style="margin-bottom: 8px;">
                            <i class="fa fa-check text-success"></i> 
                            <strong>{{ $package->product_count == 0 ? __('superadmin::lang.unlimited') : $package->product_count }}</strong> @lang('superadmin::lang.products')
                        </div>
                        <div class="col-sm-6" style="margin-bottom: 8px;">
                            <i class="fa fa-check text-success"></i> 
                            <strong>{{ $package->invoice_count == 0 ? __('superadmin::lang.unlimited') : $package->invoice_count }}</strong> @lang('superadmin::lang.invoices')
                        </div>
                        @if($package->trial_days != 0)
                            <div class="col-sm-6" style="margin-bottom: 8px;">
                                <i class="fa fa-clock text-warning"></i> 
                                <strong>{{ $package->trial_days }}</strong> @lang('superadmin::lang.trial_days')
                            </div>
                        @endif
                    </div>
                </div>

				@php
				  if($coupon_status['status'] == 'success')	{
					$package->price =  number_format($package_price_after_discount , 2, '.', '');
				  }
				@endphp

				<div class="row" style="margin-bottom: 20px;">
					@if (request()->has('code'))
						<div class="col-xs-12">
                            <div class="alert alert-{{ $coupon_status['status'] }}" style="border-radius: 10px;">
                                @if($coupon_status['status'] == 'success')
                                    @lang('superadmin::lang.package_price_after_discount') = 
                                    <span class="display_currency" data-currency_symbol="true">{{ number_format($package_price_after_discount , 2, '.', '') }}</span>
                                    (@lang('superadmin::lang.you_save') <span class="display_currency" data-currency_symbol="true">{{ number_format($discount_amount , 2, '.', '') }}</span>)
                                @else
                                    {{ $coupon_status['msg'] }}
                                @endif
                            </div>
                        </div>
					@endif

                    <div class="col-md-7">
                        {!! Form::open([
                            'method' => 'get',
                            'id' => 'coupon_check',
                        ]) !!}
                        <div style="display: flex; gap: 8px; align-items: flex-end;">
                            <div style="flex: 1;">
                                {!! Form::label('coupon_code', '¿Tienes un Cupón de Descuento?', ['style' => 'font-size: 13px; font-weight: 700; color: #475569;']) !!}
                                {!! Form::text('code', request()->get('code') ?? null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'Ingresa tu código aquí...',
                                    'style' => 'border-radius: 8px;'
                                ]) !!}
                            </div>
                            <div>
                                {!! Form::submit('Aplicar', ['class' => 'btn btn-default', 'style' => 'border-radius: 8px; font-weight: 600; padding: 6px 18px;']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
				</div>

                <h4 style="font-weight: 800; color: #0F172A; margin: 24px 0 16px 0;">
                    Selecciona tu Método de Pago:
                </h4>

				<div class="list-group" style="box-shadow: 0 4px 15px rgba(0,0,0,0.03); border-radius: 12px; overflow: hidden;">
					@foreach($gateways as $k => $v)
						<div class="list-group-item" style="padding: 16px 20px; border-color: #E2E8F0;">
							<div class="row" id="paymentdiv_{{$k}}">
								@php 
									$view = 'superadmin::subscription.partials.pay_'.$k;
								@endphp
								@includeIf($view)
							</div>
						</div>
					@endforeach
				</div>
			</div>
        </div>
    </div>
</section>
@endsection