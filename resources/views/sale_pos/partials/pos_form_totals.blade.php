<div class="audaz-pos-totals-container">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="pos-totals-row">
				<span><i class="fas fa-boxes tw-text-slate-400 tw-mr-1"></i> @lang('sale.item'):</span>
				<span class="total_quantity val">0</span>
			</div>
			<div class="pos-totals-row">
				<span><i class="fas fa-calculator tw-text-slate-400 tw-mr-1"></i> @lang('sale.total'):</span>
				<span class="val"><span class="price_total">0.00</span> <span class="transaction_currency_symbol"></span></span>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6">
			@if(!Gate::check('disable_discount') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
				<div class="pos-totals-row">
					<span>
						<i class="fas fa-tag tw-text-orange-500 tw-mr-1"></i> @lang('sale.discount') (-):
						@if($edit_discount)
							<i class="fas fa-edit cursor-pointer tw-text-orange-500 tw-ml-1" id="pos-edit-discount" title="@lang('sale.edit_discount')" data-toggle="modal" data-target="#posEditDiscountModal"></i>
						@endif
					</span>
					<span class="val tw-text-rose-500" id="total_discount">0.00</span>
					<input type="hidden" name="discount_type" id="discount_type" value="@if(empty($edit)){{'percentage'}}@else{{$transaction->discount_type}}@endif" data-default="percentage">
					<input type="hidden" name="discount_amount" id="discount_amount" value="@if(empty($edit)) {{@num_format($business_details->default_sales_discount)}} @else {{@num_format($transaction->discount_amount)}} @endif" data-default="{{$business_details->default_sales_discount}}">
					<input type="hidden" name="rp_redeemed" id="rp_redeemed" value="@if(empty($edit)){{'0'}}@else{{$transaction->rp_redeemed}}@endif">
					<input type="hidden" name="rp_redeemed_amount" id="rp_redeemed_amount" value="@if(empty($edit)){{'0'}}@else {{$transaction->rp_redeemed_amount}} @endif">
				</div>
			@endif

			<div class="pos-totals-row @if($pos_settings['disable_order_tax'] != 0) hide @endif">
				<span>
					<i class="fas fa-percentage tw-text-slate-400 tw-mr-1"></i> @lang('sale.order_tax') (+):
					<i class="fas fa-edit cursor-pointer tw-text-slate-400 tw-ml-1" title="@lang('sale.edit_order_tax')" data-toggle="modal" data-target="#posEditOrderTaxModal" id="pos-edit-tax"></i>
				</span>
				<span class="val" id="order_tax">@if(empty($edit)) 0.00 @else {{$transaction->tax_amount}} @endif</span>
				<input type="hidden" name="tax_rate_id" id="tax_rate_id" value="@if(empty($edit)) {{$business_details->default_sales_tax}} @else {{$transaction->tax_id}} @endif" data-default="{{$business_details->default_sales_tax}}">
				<input type="hidden" name="tax_calculation_amount" id="tax_calculation_amount" value="@if(empty($edit)) {{@num_format($business_details->tax_calculation_amount)}} @else {{@num_format($transaction->tax?->amount)}} @endif" data-default="{{$business_details->tax_calculation_amount}}">
			</div>

			<div class="pos-totals-row">
				<span>
					<i class="fas fa-truck tw-text-slate-400 tw-mr-1"></i> @lang('sale.shipping') (+):
					<i class="fas fa-edit cursor-pointer tw-text-slate-400 tw-ml-1" title="@lang('sale.shipping')" data-toggle="modal" data-target="#posShippingModal"></i>
				</span>
				<span class="val" id="shipping_charges_amount">0.00</span>
				<input type="hidden" name="shipping_details" id="shipping_details" value="@if(empty($edit)){{''}}@else{{$transaction->shipping_details}}@endif" data-default="">
				<input type="hidden" name="shipping_address" id="shipping_address" value="@if(empty($edit)){{''}}@else{{$transaction->shipping_address}}@endif">
				<input type="hidden" name="shipping_status" id="shipping_status" value="@if(empty($edit)){{''}}@else{{$transaction->shipping_status}}@endif">
				<input type="hidden" name="delivered_to" id="delivered_to" value="@if(empty($edit)){{''}}@else{{$transaction->delivered_to}}@endif">
				<input type="hidden" name="delivery_person" id="delivery_person" value="@if(empty($edit)){{''}}@else{{$transaction->delivery_person}}@endif">
				<input type="hidden" name="shipping_charges" id="shipping_charges" value="@if(empty($edit)){{@num_format(0.00)}} @else{{@num_format($transaction->shipping_charges)}} @endif" data-default="0.00">
			</div>
		</div>
	</div>
</div>