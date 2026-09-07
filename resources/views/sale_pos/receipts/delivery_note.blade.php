<table style="width:100%;">
	<thead>
		<tr>
			<td>
				<p class="text-right color-555 font-30">
					<b>@lang('lang_v1.delivery_note')</b>
				</p>
			</td>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>

<!-- business information here -->
<div class="row invoice-info">

	<div class="col-md-6 invoice-col width-50 color-555">
		
		<!-- Logo -->
		@if(!empty($receipt_details->logo))
			<img style="max-height: 120px; width: auto;" src="{{$receipt_details->logo}}" class="img">
			<br/>
		@endif

		<!-- Shop & Location Name  -->
		@if(!empty($receipt_details->display_name))
			<p><span style="font-size:24px; font-weight:900; color:black;">
				{{$receipt_details->display_name}}</span>
				@if(!empty($receipt_details->address))
					<br/>{!! $receipt_details->address !!}
				@endif

				@if(!empty($receipt_details->contact))
					<br/>{!! $receipt_details->contact !!}
				@endif

				@if(!empty($receipt_details->website))
					<br/>{{ $receipt_details->website }}
				@endif

				@if(!empty($receipt_details->tax_info1))
					<br/>{{ $receipt_details->tax_label1 }} {{ $receipt_details->tax_info1 }}
				@endif

				@if(!empty($receipt_details->tax_info2))
					<br/>{{ $receipt_details->tax_label2 }} {{ $receipt_details->tax_info2 }}
				@endif

				@if(!empty($receipt_details->location_custom_fields))
					<br/>{{ $receipt_details->location_custom_fields }}
				@endif
			</p>
		@endif
	</div>

	<div class="col-md-6 invoice-col width-50">

		<p class="text-right font-17">
			@if(!empty($receipt_details->invoice_no_prefix))
				<span class="pull-left">{!! $receipt_details->invoice_no_prefix !!}</span>
			@endif

			{{$receipt_details->invoice_no}}
		</p>
		<!-- Date-->
		@if(!empty($receipt_details->date_label))
			<p class="text-right font-17">
				<span class="pull-left">
					{{$receipt_details->date_label}}
				</span>

				{{$receipt_details->invoice_date}}
			</p>
		@endif

		@if (!empty($receipt_details->sale_orders_invoice_no) || !empty($receipt_details->sale_orders_invoice_date))
			<p class="text-right font-17">
				@if (!empty($receipt_details->sale_orders_invoice_no))
					<span class="pull-left"><strong>@lang('restaurant.order_no'):</strong></span>
					{!! $receipt_details->sale_orders_invoice_no !!}<br>
				@endif
				@if (!empty($receipt_details->sale_orders_invoice_date))
					<span class="pull-left"><strong>@lang('lang_v1.order_dates'):</strong></span>
					{!! $receipt_details->sale_orders_invoice_date !!}
				@endif
			</p>
		@endif
	</div>

	<div class="col-md-6 invoice-col width-50 word-wrap">
		@if(!empty($receipt_details->customer_label))
			<b>{{ $receipt_details->customer_label }}</b><br/>
		@endif

		@if(!empty($receipt_details->customer_info))
			{!! $receipt_details->customer_info !!}
		@endif
		@if(!empty($receipt_details->client_id_label))
			<br/>
			<strong>{{ $receipt_details->client_id_label }}</strong> {{ $receipt_details->client_id }}
		@endif
		@if(!empty($receipt_details->customer_tax_number))
			<br/>
			<strong>{{ $receipt_details->customer_tax_label }}</strong> {{ $receipt_details->customer_tax_number }}
		@endif
		@if(!empty($receipt_details->customer_custom_fields))
			<br/>{!! $receipt_details->customer_custom_fields !!}
		@endif
		@if(!empty($receipt_details->sales_person_label))
			<br/>
			<strong>{{ $receipt_details->sales_person_label }}</strong> {{ $receipt_details->sales_person }}
		@endif
	</div>

	@if(!empty($receipt_details->shipping_address))
		<div class="col-md-6 invoice-col width-50 word-wrap">
			<strong>@lang('lang_v1.shipping_address'):</strong><br>
			{!! $receipt_details->shipping_address !!}
		</div>
	@endif
</div>

<div class="row color-555">
	<div class="col-xs-12">
		<br/>
		<table class="table table-bordered table-no-top-cell-border table-slim">
			<thead>
				<tr style="background-color: #357ca5 !important; color: white !important; font-size: 15px !important" class="table-no-side-cell-border table-no-top-cell-border text-center">
					<td style="background-color: #357ca5 !important; color: white !important; width: 4% !important">#</td>
					
					<td style="background-color: #357ca5 !important; color: white !important; width: 46% !important">
						{{$receipt_details->table_product_label}}
					</td>
					
					<td style="background-color: #357ca5 !important; color: white !important; width: 16% !important;">
						{{$receipt_details->table_qty_label}}
					</td>

					<td style="background-color: #357ca5 !important; color: white !important; width: 16% !important;">
						{{$receipt_details->table_unit_price_label}}
					</td>

					<td style="background-color: #357ca5 !important; color: white !important; width: 18% !important;">
						{{$receipt_details->table_subtotal_label}}
					</td>
				</tr>
			</thead>
			<tbody>
				@foreach($receipt_details->lines as $line)
					<tr>
						<td class="text-center">
							{{$loop->iteration}}
						</td>
						<td style="word-break: break-all;">
                            {{$line['name']}} {{$line['product_variation']}} {{$line['variation']}} 
                            @if(!empty($line['sub_sku'])), {{$line['sub_sku']}} @endif @if(!empty($line['brand'])), {{$line['brand']}} @endif
                            @if(!empty($line['product_custom_fields'])), {{$line['product_custom_fields']}} @endif
                            @if(!empty($line['sell_line_note']))<br><small class="text-muted">({!!$line['sell_line_note']!!})</small> @endif
                            @if(!empty($line['lot_number']))<br> {{$line['lot_number_label']}}:  {{$line['lot_number']}} @endif 
                            @if(!empty($line['product_expiry'])), {{$line['product_expiry_label']}}:  {{$line['product_expiry']}} @endif 
                            @if ($receipt_details->show_base_unit_details && $line['quantity'] && $line['base_unit_multiplier'] !== 1)
                                <br><small>
                                    {{ $line['quantity'] }} x {{ $line['base_unit_multiplier'] }} =
                                    {{ $line['orig_quantity'] }} {{ $line['base_unit_name'] }}
                                </small>
                            @endif
                        </td>
						<td class="text-right">
							{{$line['quantity']}} {{$line['units']}}
						</td>
						<td class="text-right">
							{{$line['unit_price_inc_tax'] ?? $line['unit_price_before_discount'] ?? $line['unit_price']}}
						</td>
						<td class="text-right">
							{{$line['line_total']}}
						</td>
					</tr>
					@if(!empty($line['modifiers']))
						@foreach($line['modifiers'] as $modifier)
							<tr>
								<td class="text-center">
									&nbsp;
								</td>
								<td>
		                            {{$modifier['name']}} {{$modifier['variation']}} 
		                            @if(!empty($modifier['sub_sku'])), {{$modifier['sub_sku']}} @endif 
		                            @if(!empty($modifier['sell_line_note']))({!!$modifier['sell_line_note']!!}) @endif 
		                        </td>
								<td class="text-right">
									{{$modifier['quantity']}} {{$modifier['units']}}
								</td>
								<td class="text-right">
									{{$modifier['unit_price_inc_tax'] ?? $modifier['unit_price_exc_tax'] ?? ''}}
								</td>
								<td class="text-right">
									{{$modifier['line_total']}}
								</td>
							</tr>
						@endforeach
					@endif
				@endforeach

				@php
					$lines = count($receipt_details->lines);
				@endphp

				@for ($i = $lines; $i < 3; $i++)
    				<tr>
    					<td>&nbsp;</td>
    					<td>&nbsp;</td>
    					<td>&nbsp;</td>
    					<td>&nbsp;</td>
    					<td>&nbsp;</td>
    				</tr>
				@endfor

			</tbody>
		</table>
	</div>
</div>

<div class="row color-555" style="margin-top: 10px; margin-bottom: 20px; page-break-inside: avoid !important">
	<div class="col-xs-6">
		<table class="table-no-side-cell-border table-no-top-cell-border width-100 table-slim">
			@if(!empty($receipt_details->total_quantity))
				<tr>
					<td style="width: 50%;"><strong>@lang('lang_v1.total_quantity'):</strong></td>
					<td class="text-right">{{$receipt_details->total_quantity}}</td>
				</tr>
			@endif
			@if(!empty($receipt_details->total_items))
				<tr>
					<td style="width: 50%;"><strong>@lang('lang_v1.total_items'):</strong></td>
					<td class="text-right">{{$receipt_details->total_items}}</td>
				</tr>
			@endif
		</table>
	</div>
	<div class="col-xs-6">
		<table class="table-no-side-cell-border table-no-top-cell-border width-100 table-slim pull-right">
			<tbody>
				@if(!empty($receipt_details->discount) && $receipt_details->discount != 0)
					<tr>
						<td style="width:50%">
							{!! $receipt_details->discount_label !!}
						</td>
						<td class="text-right">
							(-) {{$receipt_details->discount}}
						</td>
					</tr>
				@endif

				@if(!empty($receipt_details->shipping_charges) && $receipt_details->shipping_charges != 0)
					<tr>
						<td style="width:50%">
							{!! $receipt_details->shipping_charges_label !!}
						</td>
						<td class="text-right">
							(+) {{$receipt_details->shipping_charges}}
						</td>
					</tr>
				@endif

				@if(!empty($receipt_details->packing_charge) && $receipt_details->packing_charge != 0)
					<tr>
						<td style="width:50%">
							{!! $receipt_details->packing_charge_label !!}
						</td>
						<td class="text-right">
							(+) {{$receipt_details->packing_charge}}
						</td>
					</tr>
				@endif

				<!-- Monto Estimado (Sin desglosar impuestos) -->
				<tr>
					<th style="background-color: #357ca5 !important; color: white !important; font-size: 16px !important; padding: 10px !important;">
						Monto estimado:
					</th>
					<td class="text-right font-23 padding-10" style="background-color: #357ca5 !important; color: white !important; font-size: 18px !important; font-weight: bold !important; padding: 10px !important;">
						{{$receipt_details->total}}
					</td>
				</tr>
				@if(!empty($receipt_details->total_in_words))
					<tr>
						<td colspan="2" class="text-right">
							<small>({{$receipt_details->total_in_words}})</small>
						</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>

<div class="row invoice-info color-555" style="page-break-inside: avoid !important">
	<div class="col-md-6 invoice-col width-50">
		<b class="pull-left">@lang('lang_v1.above_mentioned_items_received_in_good_condition')</b>
	</div>
</div>
</br>
<div class="row invoice-info color-555" style="page-break-inside: avoid !important">
	<div class="col-md-6 invoice-col width-80">
		<b class="pull-left">@lang('lang_v1.received_by') : </b>
	</div>
</div>
</br>
<div class="row invoice-info color-555" style="page-break-inside: avoid !important">
	<div class="col-md-6 invoice-col width-50">
		<b class="pull-left">@lang('lang_v1.date'):</b>
	</div>
</div>
</br>
<div class="row invoice-info color-555" style="page-break-inside: avoid !important">
	<div class="col-md-6 invoice-col width-50">
		<b class="pull-left">@lang('lang_v1.authorized_signatory')</b>
	</div>
</div>

{{-- Barcode --}}
@if($receipt_details->show_barcode)
<br>
<div class="row">
		<div class="col-xs-12">
			<img class="center-block" src="data:image/png;base64,{{DNS1D::getBarcodePNG($receipt_details->invoice_no, 'C128', 2,30,array(39, 48, 54), true)}}">
		</div>
</div>
@endif

@if(!empty($receipt_details->footer_text))
	<div class="row color-555">
		<div class="col-xs-12">
			{!! $receipt_details->footer_text !!}
		</div>
	</div>
@endif

			</td>
		</tr>
	</tbody>
</table>

<style type="text/css">
    @page {
        size: portrait;
        margin: 8mm;
    }
    body {
        color: #000000;
    }
    @media print {
        @page {
            size: portrait;
            margin: 8mm;
        }
        body, html {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        table {
            width: 100% !important;
            max-width: 100% !important;
        }
        tr, td {
            page-break-inside: auto !important;
        }
    }
</style>