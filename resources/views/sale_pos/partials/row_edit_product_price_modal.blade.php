<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">{{$product->product_name}} - {{$product->sub_sku}}</h4>
		</div>
		<div class="modal-body">
			<div class="row">
				@php
					$modal_so_pieces = !empty($so_line) ? (float)($so_line->pieces_quantity ?? 0) : 0;
					$modal_so_est_weight = !empty($so_line) ? (float)($so_line->estimated_weight ?? 0) : 0;
					$modal_prod_est_weight = (float)($product->estimated_weight ?? ($product->product_estimated_weight ?? 0));
					$modal_effective_est_weight = $modal_so_est_weight > 0 ? $modal_so_est_weight : ($modal_prod_est_weight > 0 ? $modal_prod_est_weight : 0);

					$modal_is_estimated = (!empty($product->enable_estimated_weight) && $product->enable_estimated_weight == 1) 
						|| $modal_effective_est_weight > 0
						|| $modal_so_pieces > 0;

					$modal_pieces_val = (float)($product->pieces_quantity ?? 0);
					if ($modal_pieces_val <= 0 && $modal_so_pieces > 0) {
						$modal_pieces_val = $modal_so_pieces;
					}
					if ($modal_pieces_val <= 0 && $modal_effective_est_weight > 0 && !empty($product->quantity_ordered)) {
						$modal_pieces_val = round((float)$product->quantity_ordered / $modal_effective_est_weight, 2);
					}
					if ($modal_pieces_val <= 0) {
						$modal_pieces_val = 1;
					}
				@endphp

				@if($modal_is_estimated)
					<div class="col-xs-12" style="margin-bottom: 12px;">
						<div style="background: linear-gradient(135deg, #F0F9FF 0%, #E0F2FE 100%); border: 1.5px solid #38BDF8; border-radius: 10px; padding: 12px;">
							<div style="font-size: 11.5px; font-weight: 800; color: #0369A1; text-transform: uppercase; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
								<i class="fas fa-balance-scale"></i> Control de Peso y Piezas (Pesaje al Facturar)
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-6">
									<label style="font-size: 11px; font-weight: 700; color: #1E293B; margin-bottom: 3px;">Cantidad de Piezas (Pzas):</label>
									<div class="input-group">
										<span class="input-group-addon" style="background: #FFFFFF; font-size: 11px; font-weight: 700;">Pzas</span>
										<input type="text" class="form-control modal_pieces_quantity input_number" 
											data-row_index="{{$row_count}}" 
											value="{{ @format_quantity($modal_pieces_val) }}" 
											placeholder="Piezas">
									</div>
								</div>
								<div class="col-xs-12 col-sm-6">
									<label style="font-size: 11px; font-weight: 700; color: #0284C7; margin-bottom: 3px;">Peso Real Facturable ({{$product->unit}}):</label>
									<div class="input-group">
										<span class="input-group-addon" style="background: #0284C7; color: #FFFFFF; font-size: 11px; font-weight: 700;">{{$product->unit}}</span>
										<input type="text" class="form-control modal_weight_quantity input_number" 
											data-row_index="{{$row_count}}" 
											value="{{ @format_quantity($product->quantity_ordered) }}" 
											placeholder="Peso real">
									</div>
								</div>
								@if($modal_effective_est_weight > 0)
									<div class="col-xs-12" style="margin-top: 6px;">
										<small style="color: #64748B; font-weight: 600;">
											⚖️ Peso promedio estimado: <strong>{{ @format_quantity($modal_effective_est_weight) }} {{$product->unit}}/pieza</strong>. Modifique las piezas o el peso real pesado en balanza.
										</small>
									</div>
								@endif
							</div>
						</div>
					</div>
				@endif

				<div class="form-group col-xs-12 @if(!auth()->user()->can('edit_product_price_from_sale_screen')) hide @endif">
					@php
						$pos_unit_price = !empty($product->unit_price_before_discount) ? $product->unit_price_before_discount : $product->default_sell_price;
					@endphp
					<label>@lang('sale.unit_price')</label>
						<input type="text" name="products[{{$row_count}}][unit_price]" class="form-control pos_unit_price input_number mousetrap" value="{{@num_format($pos_unit_price)}}" @if(!empty($pos_settings['enable_msp'])) data-rule-min-value="{{$pos_unit_price}}" data-msg-min-value="{{__('lang_v1.minimum_selling_price_error_msg', ['price' => @num_format($pos_unit_price)])}}" @endif>
				</div>
				@if(!auth()->user()->can('edit_product_price_from_sale_screen'))
					<div class="form-group col-xs-12">
						<strong>@lang('sale.unit_price'):</strong> {{@num_format(!empty($product->unit_price_before_discount) ? $product->unit_price_before_discount : $product->default_sell_price)}}
					</div>
				@endif
				<div class="form-group col-xs-12 col-sm-6 @if(!$edit_discount) hide @endif">
					<label>@lang('sale.discount_type')</label>
						{!! Form::select("products[$row_count][line_discount_type]", ['fixed' => __('lang_v1.fixed'), 'percentage' => __('lang_v1.percentage')], $discount_type , ['class' => 'form-control row_discount_type']); !!}
				</div>
				<div class="form-group col-xs-12 col-sm-6 @if(!$edit_discount) hide @endif">
					<label>@lang('sale.discount_amount')</label>
						{!! Form::text("products[$row_count][line_discount_amount]", @num_format($discount_amount), ['class' => 'form-control input_number row_discount_amount']); !!}
				</div>
				@if(!empty($discount))
					<div class="form-group col-xs-12">
						<p class="help-block">{!! __('lang_v1.applied_discount_text', ['discount_name' => $discount->name, 'starts_at' => $discount->formated_starts_at, 'ends_at' => $discount->formated_ends_at]) !!}</p>
					</div>
				@endif
				<div class="form-group col-xs-12 {{$hide_tax}}">
					<label>@lang('sale.tax')</label>

					{!! Form::hidden("products[$row_count][item_tax]", @num_format($item_tax), ['class' => 'item_tax']); !!}
		
					{!! Form::select("products[$row_count][tax_id]", $tax_dropdown['tax_rates'], $tax_id, ['placeholder' => 'Select', 'class' => 'form-control tax_id'], $tax_dropdown['attributes']); !!}
				</div>
				@if(!empty($warranties))
					<div class="form-group col-xs-12">
						<label>@lang('lang_v1.warranty')</label>
						{!! Form::select("products[$row_count][warranty_id]", $warranties, $warranty_id, ['placeholder' => __('messages.please_select'), 'class' => 'form-control']); !!}
					</div>
				@endif
				<div class="form-group col-xs-12">
		      		<label>@lang('lang_v1.description')</label>
		      		<textarea class="form-control" name="products[{{$row_count}}][sell_line_note]" rows="3">{{$sell_line_note}}</textarea>
		      		<p class="help-block">@lang('lang_v1.sell_line_description_help')</p>
		      	</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="tw-dw-btn tw-dw-btn-neutral tw-text-white" data-dismiss="modal">@lang('messages.close')</button>
		</div>
	</div>
</div>