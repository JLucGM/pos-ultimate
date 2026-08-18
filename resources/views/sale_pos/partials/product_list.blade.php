@forelse($products as $product)
	<div class="col-md-3 col-sm-4 col-xs-6 product_list no-print">
		<div class="product_box" data-variation_id="{{$product->id}}" title="{{$product->name}} @if($product->type == 'variable')- {{$product->variation}} @endif {{ '(' . $product->sub_sku . ')'}}">
			<div class="image-container" 
				style="background-image: url(
						@if(count($product->media) > 0)
							{{$product->media->first()->display_url}}
						@elseif(!empty($product->product_image))
							{{asset('/uploads/img/' . rawurlencode($product->product_image))}}
						@else
							{{asset('/img/default.png')}}
						@endif
					);">
			</div>

			<div class="text_div">
				<div class="text">
					{{$product->name}} 
					@if($product->type == 'variable')
						- {{$product->variation}}
					@endif
				</div>

				<div style="display: flex; align-items: flex-end; justify-content: space-between; margin-top: 4px;">
					<div>
						<span class="pos-card-price-badge">
							@if(!empty($show_prices))
								@format_currency($product->selling_price)
							@else
								--
							@endif
						</span>
						@if(!empty($show_prices) && !empty($bcv_rate) && $bcv_rate > 1)
							<small style="display: block; font-size: 10px; font-weight: 800; color: #38BDF8; margin-top: 2px; font-family: ui-monospace, monospace;">
								Bs. {{ number_format($product->selling_price * $bcv_rate, 2, ',', '.') }}
							</small>
						@endif
					</div>
					
					@if($product->enable_stock)
						<span class="pos-stock-indicator @if($product->qty_available <= 0) out-of-stock @endif">
							<i class="fas fa-cubes"></i> {{ @num_format($product->qty_available) }}
						</span>
					@endif
				</div>
			</div>
		</div>
	</div>
@empty
	<input type="hidden" id="no_products_found">
	<div class="col-md-12 text-center" style="padding: 40px 20px;">
		<i class="fas fa-box-open fa-3x" style="color: #CBD5E1; margin-bottom: 12px;"></i>
		<h4 style="color: #64748B; font-weight: 700;">
			@lang('lang_v1.no_products_to_display')
		</h4>
	</div>
@endforelse