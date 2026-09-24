@extends('layouts.app')
@section('title', __('expense.add_expense'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('expense.add_expense')</h1>
</section>

<!-- Main content -->
<section class="content">
	{!! Form::open(['url' => action([\App\Http\Controllers\ExpenseController::class, 'store']), 'method' => 'post', 'id' => 'add_expense_form', 'files' => true ]) !!}
	<div class="box box-solid">
		<div class="box-body">
			<div class="row">

				@if(count($business_locations) == 1)
					@php 
						$default_location = current(array_keys($business_locations->toArray())) 
					@endphp
				@else
					@php $default_location = null; @endphp
				@endif
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('location_id', __('purchase.business_location').':*') !!}
						{!! Form::select('location_id', $business_locations, $default_location, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required'], $bl_attributes); !!}
					</div>
				</div>

				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('expense_category_id', __('expense.expense_category').':') !!}
						{!! Form::select('expense_category_id', $expense_categories, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]); !!}
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
			            {!! Form::label('expense_sub_category_id', __('product.sub_category') . ':') !!}
			              {!! Form::select('expense_sub_category_id', [],  null, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2']); !!}
			          </div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('ref_no', __('purchase.ref_no').':') !!}
						{!! Form::text('ref_no', null, ['class' => 'form-control']); !!}
						<p class="help-block">
			                @lang('lang_v1.leave_empty_to_autogenerate')
			            </p>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('transaction_date', __('messages.date') . ':*') !!}
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							{!! Form::text('transaction_date', @format_datetime('now'), ['class' => 'form-control', 'readonly', 'required', 'id' => 'expense_transaction_date']); !!}
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('expense_for', __('expense.expense_for').':') !!} @show_tooltip(__('tooltip.expense_for'))
						{!! Form::select('expense_for', $users, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]); !!}
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('contact_id', __('lang_v1.expense_for_contact').':') !!} 
						{!! Form::select('contact_id', $contacts, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]); !!}
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-4">
                    <div class="form-group">
                        {!! Form::label('document', __('purchase.attach_document') . ':') !!}
                        {!! Form::file('document', ['id' => 'upload_document', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]); !!}
                        <small><p class="help-block">@lang('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)])
                        @includeIf('components.document_help_text')</p></small>
                    </div>
                </div>
				<div class="col-md-4">
			    	<div class="form-group">
			            {!! Form::label('tax_id', __('product.applicable_tax') . ':' ) !!}
			            <div class="input-group">
			                <span class="input-group-addon">
			                    <i class="fa fa-info"></i>
			                </span>
			                {!! Form::select('tax_id', $taxes['tax_rates'], null, ['class' => 'form-control'], $taxes['attributes']); !!}

							<input type="hidden" name="tax_calculation_amount" id="tax_calculation_amount" 
							value="0">
			            </div>
			        </div>
			    </div>
				<div class="clearfix"></div>

				<!-- Multimoneda y Tasa de Cambio -->
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('transaction_currency_id', __('lang_v1.currency') . ':*') !!}
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fas fa-coins"></i>
							</span>
							{!! Form::select('transaction_currency_id', $currencies_dropdown, !empty($ves_currency) ? $ves_currency->id : ($base_currency->id ?? null), ['class' => 'form-control select2', 'id' => 'expense_currency_id', 'style' => 'width:100%;']); !!}
						</div>
						<small class="text-muted">Moneda en la que se realizó o pagó el gasto</small>
					</div>
				</div>

				<div class="col-sm-4" id="expense_exchange_rate_div">
					<div class="form-group">
						{!! Form::label('exchange_rate', __('purchase.p_exchange_rate') . ' (Tasa BCV):*') !!}
						@show_tooltip('Tasa de cambio aplicada al momento del gasto. Quedará congelada históricamente.')
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fas fa-exchange-alt"></i>
							</span>
							{!! Form::text('exchange_rate', @num_format($current_bcv_rate), ['class' => 'form-control input_number', 'id' => 'expense_exchange_rate', 'required', 'placeholder' => 'Ej: 854.46']); !!}
						</div>
						<small class="help-block text-muted" id="exchange_rate_help">
							<i class="fas fa-lock tw-text-emerald-600"></i> <span id="exchange_rate_text">1 USD = {{ @num_format($current_bcv_rate) }} Bs.</span>
						</small>
					</div>
				</div>

			    <div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('final_total', __('sale.total_amount') . ':*') !!}
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fas fa-money-bill-wave"></i>
							</span>
							{!! Form::text('final_total', null, ['class' => 'form-control input_number', 'placeholder' => __('sale.total_amount'), 'required', 'id' => 'final_total']); !!}
						</div>
						<div id="expense_amount_converted_preview" class="tw-mt-1.5" style="display: none;">
							<span class="tw-inline-flex tw-items-center tw-gap-1.5 tw-text-xs tw-font-semibold tw-text-emerald-800 tw-bg-emerald-50 tw-px-2 tw-py-1 tw-rounded-md tw-border tw-border-emerald-200">
								<i class="fas fa-calculator tw-text-emerald-600"></i>
								<span id="converted_amount_text">≈ $ 0.00 USD</span>
							</span>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-4">
					<div class="form-group">
						{!! Form::label('additional_notes', __('expense.expense_note') . ':') !!}
								{!! Form::textarea('additional_notes', null, ['class' => 'form-control', 'rows' => 3]); !!}
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<br>
					<label>
		              {!! Form::checkbox('is_refund', 1, false, ['class' => 'input-icheck', 'id' => 'is_refund']); !!} @lang('lang_v1.is_refund')?
		            </label>@show_tooltip(__('lang_v1.is_refund_help'))
				</div>
			</div>
		</div>
	</div> <!--box end-->
	@include('expense.recur_expense_form_part')
	@component('components.widget', ['class' => 'box-solid', 'id' => "payment_rows_div", 'title' => __('purchase.add_payment')])
	<div class="payment_row">
		@include('sale_pos.partials.payment_row_form', ['row_index' => 0, 'show_date' => true])
		<hr>
		<div class="row">
			<div class="col-sm-12">
				<div class="pull-right">
					<strong>@lang('purchase.payment_due'):</strong>
					<span id="payment_due">{{@num_format(0)}}</span>
				</div>
			</div>
		</div>
	</div>
	@endcomponent
	<div class="col-sm-12 text-center">
		<button type="submit" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-lg tw-text-white">@lang('messages.save')</button>
	</div>
{!! Form::close() !!}
</section>
@endsection
@section('javascript')
<script type="text/javascript">
	var base_currency_id = {{ $base_currency ? $base_currency->id : 1 }};
	var base_currency_code = '{{ $base_currency ? $base_currency->code : "USD" }}';

	$(document).ready( function(){
		$('.paid_on').datetimepicker({
            format: moment_date_format + ' ' + moment_time_format,
            ignoreReadonly: true,
        });

		updateExpenseRateAndPreview();
	});
	
	__page_leave_confirmation('#add_expense_form');

	function updateExpenseRateAndPreview() {
		var selected_currency_id = $('#expense_currency_id').val();
		var amount = __read_number($('input#final_total'));
		var rate = __read_number($('#expense_exchange_rate')) || 1.0;

		if (selected_currency_id == base_currency_id) {
			$('#expense_exchange_rate_div').hide();
			if (amount > 0 && rate > 1) {
				var bs_equiv = amount * rate;
				$('#converted_amount_text').text('≈ Bs. ' + __currency_trans_from_en(bs_equiv, false, false) + ' (@ ' + __currency_trans_from_en(rate, false, false) + ' Bs/$)');
				$('#expense_amount_converted_preview').show();
			} else {
				$('#expense_amount_converted_preview').hide();
			}
		} else {
			$('#expense_exchange_rate_div').show();
			if (amount > 0 && rate > 0) {
				var usd_equiv = amount / rate;
				$('#converted_amount_text').text('≈ $ ' + __currency_trans_from_en(usd_equiv, false, false) + ' ' + base_currency_code + ' (Moneda Base)');
				$('#expense_amount_converted_preview').show();
			} else {
				$('#expense_amount_converted_preview').hide();
			}
		}

		// Auto sync payment amount on initial creation if payment amount matches previous
		var payment_input = $('input.payment-amount');
		if (payment_input.length && (payment_input.val() === '' || payment_input.val() == '0')) {
			__write_number(payment_input, amount);
		}

		calculateExpensePaymentDue();
	}

	$(document).on('change', '#expense_currency_id', function() {
		var selected_currency_id = $(this).val();
		if (selected_currency_id == base_currency_id) {
			$('#expense_exchange_rate_div').hide();
			updateExpenseRateAndPreview();
		} else {
			$('#expense_exchange_rate_div').show();
			$.ajax({
				url: '/get-exchange-rate',
				method: 'GET',
				data: {
					from_currency_id: base_currency_id,
					to_currency_id: selected_currency_id
				},
				success: function(response) {
					if (response.success && response.rate > 0) {
						__write_number($('#expense_exchange_rate'), response.rate);
						$('#exchange_rate_text').text('1 ' + base_currency_code + ' = ' + __currency_trans_from_en(response.rate, false, false) + ' ' + (response.to_currency_code || 'Bs.'));
					}
					updateExpenseRateAndPreview();
				},
				error: function() {
					updateExpenseRateAndPreview();
				}
			});
		}
	});

	$(document).on('input change', 'input#final_total, #expense_exchange_rate', function() {
		updateExpenseRateAndPreview();
	});

	$(document).on('input change', 'input.payment-amount', function() {
		calculateExpensePaymentDue();
	});

	function calculateExpensePaymentDue() {
		var final_total = __read_number($('input#final_total'));
		var payment_amount = __read_number($('input.payment-amount'));
		var payment_due = final_total - payment_amount;
		$('#payment_due').text(__currency_trans_from_en(payment_due, false, false));
	}

	$(document).on('change', '#recur_interval_type', function() {
	    if ($(this).val() == 'months') {
	        $('.recur_repeat_on_div').removeClass('hide');
	    } else {
	        $('.recur_repeat_on_div').addClass('hide');
	    }
	});

	$('#is_refund').on('ifChecked', function(event){
		$('#recur_expense_div').addClass('hide');
	});
	$('#is_refund').on('ifUnchecked', function(event){
		$('#recur_expense_div').removeClass('hide');
	});

	$(document).on('change', '.payment_types_dropdown, #location_id', function(e) {
	    var default_accounts = $('select#location_id').length ? 
	                $('select#location_id')
	                .find(':selected')
	                .data('default_payment_accounts') : [];
	    var payment_types_dropdown = $('.payment_types_dropdown');
	    var payment_type = payment_types_dropdown.val();
	    if (payment_type) {
	        var default_account = default_accounts && default_accounts[payment_type]['account'] ? 
	            default_accounts[payment_type]['account'] : '';
	        var payment_row = payment_types_dropdown.closest('.payment_row');
	        var row_index = payment_row.find('.payment_row_index').val();

	        var account_dropdown = payment_row.find('select#account_' + row_index);
	        if (account_dropdown.length && default_accounts) {
	            account_dropdown.val(default_account);
	            account_dropdown.change();
	        }
	    }
	});
</script>
@endsection