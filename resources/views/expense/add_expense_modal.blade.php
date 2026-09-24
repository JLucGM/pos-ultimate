<div class="modal-dialog" role="document">
    <div class="modal-content">
        {!! Form::open(['url' => action([\App\Http\Controllers\ExpenseController::class, 'store']), 'method' => 'post', 'id' => 'add_expense_modal_form', 'files' => true ]) !!}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">@lang( 'expense.add_expense' )</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                @if(count($business_locations) == 1)
                    @php 
                        $default_location = current(array_keys($business_locations->toArray())) 
                    @endphp
                @else
                    @php $default_location = request()->input('location_id'); @endphp
                @endif
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('expense_location_id', __('purchase.business_location').':*') !!}
                        {!! Form::select('location_id', $business_locations, $default_location, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required', 'id' => 'expense_location_id'], $bl_attributes); !!}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('expense_category_id', __('expense.expense_category').':') !!}
                        {!! Form::select('expense_category_id', $expense_categories, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]); !!}
                    </div>
                </div>
                <div class="col-md-6">
					<div class="form-group">
			            {!! Form::label('expense_sub_category_id', __('product.sub_category') . ':') !!}
			              {!! Form::select('expense_sub_category_id', [],  null, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2']); !!}
			          </div>
				</div>
                <div class="clearfix"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('expense_ref_no', __('purchase.ref_no').':') !!}
                        {!! Form::text('ref_no', null, ['class' => 'form-control', 'id' => 'expense_ref_no']); !!}
                        <p class="help-block">
                            @lang('lang_v1.leave_empty_to_autogenerate')
                        </p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('expense_transaction_date', __('messages.date') . ':*') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            {!! Form::text('transaction_date', @format_datetime('now'), ['class' => 'form-control', 'readonly', 'required', 'id' => 'expense_transaction_date']); !!}
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('expense_for', __('expense.expense_for').':') !!} @show_tooltip(__('tooltip.expense_for'))
                        {!! Form::select('expense_for', $users, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]); !!}
                    </div>
                </div>                
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('expense_tax_id', __('product.applicable_tax') . ':' ) !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-info"></i>
                            </span>
                            {!! Form::select('tax_id', $taxes['tax_rates'], null, ['class' => 'form-control', 'id'=>'expense_tax_id'], $taxes['attributes']); !!}

                            <input type="hidden" name="tax_calculation_amount" id="tax_calculation_amount" 
                            value="0">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('modal_transaction_currency_id', __('lang_v1.currency') . ':*') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-coins"></i>
                            </span>
                            {!! Form::select('transaction_currency_id', $currencies_dropdown, !empty($ves_currency) ? $ves_currency->id : ($base_currency->id ?? null), ['class' => 'form-control select2', 'id' => 'modal_expense_currency_id', 'style' => 'width:100%;']); !!}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" id="modal_expense_exchange_rate_div">
                    <div class="form-group">
                        {!! Form::label('modal_expense_exchange_rate', __('purchase.p_exchange_rate') . ' (Tasa BCV):*') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-exchange-alt"></i>
                            </span>
                            {!! Form::text('exchange_rate', @num_format($current_bcv_rate), ['class' => 'form-control input_number', 'id' => 'modal_expense_exchange_rate', 'required']); !!}
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('expense_final_total', __('sale.total_amount') . ':*') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-money-bill-wave"></i>
                            </span>
                            {!! Form::text('final_total', null, ['class' => 'form-control input_number', 'placeholder' => __('sale.total_amount'), 'required', 'id' => 'expense_final_total']); !!}
                        </div>
                        <div id="modal_expense_converted_preview" class="tw-mt-1.5" style="display: none;">
                            <span class="tw-inline-flex tw-items-center tw-gap-1.5 tw-text-xs tw-font-semibold tw-text-emerald-800 tw-bg-emerald-50 tw-px-2 tw-py-1 tw-rounded-md tw-border tw-border-emerald-200">
                                <i class="fas fa-calculator tw-text-emerald-600"></i>
                                <span id="modal_converted_amount_text">≈ $ 0.00 USD</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('expense_additional_notes', __('expense.expense_note') . ':') !!}
                                {!! Form::textarea('additional_notes', null, ['class' => 'form-control', 'rows' => 3, 'id' => 'expense_additional_notes']); !!}
                    </div>
                </div>
            </div>

            <div class="payment_row">
                <h4>@lang('purchase.add_payment'):</h4>
                @include('sale_pos.partials.payment_row_form', ['row_index' => 0, 'show_date' => true])
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pull-right">
                            <strong>@lang('purchase.payment_due'):</strong>
                            <span id="expense_payment_due">{{@num_format(0)}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="tw-dw-btn tw-dw-btn-primary tw-text-white">@lang( 'messages.save' )</button>
            <button type="button" class="tw-dw-btn tw-dw-btn-neutral tw-text-white" data-dismiss="modal">@lang( 'messages.close' )</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var base_currency_id = {{ $base_currency ? $base_currency->id : 1 }};
        var base_currency_code = '{{ $base_currency ? $base_currency->code : "USD" }}';

        function updateModalExpenseRateAndPreview() {
            var selected_currency_id = $('#modal_expense_currency_id').val();
            var amount = __read_number($('input#expense_final_total'));
            var rate = __read_number($('#modal_expense_exchange_rate')) || 1.0;

            if (selected_currency_id == base_currency_id) {
                $('#modal_expense_exchange_rate_div').hide();
                if (amount > 0 && rate > 1) {
                    var bs_equiv = amount * rate;
                    $('#modal_converted_amount_text').text('≈ Bs. ' + __currency_trans_from_en(bs_equiv, false, false) + ' (@ ' + __currency_trans_from_en(rate, false, false) + ' Bs/$)');
                    $('#modal_expense_converted_preview').show();
                } else {
                    $('#modal_expense_converted_preview').hide();
                }
            } else {
                $('#modal_expense_exchange_rate_div').show();
                if (amount > 0 && rate > 0) {
                    var usd_equiv = amount / rate;
                    $('#modal_converted_amount_text').text('≈ $ ' + __currency_trans_from_en(usd_equiv, false, false) + ' ' + base_currency_code + ' (Moneda Base)');
                    $('#modal_expense_converted_preview').show();
                } else {
                    $('#modal_expense_converted_preview').hide();
                }
            }

            var payment_input = $('#add_expense_modal_form input.payment-amount');
            if (payment_input.length && (payment_input.val() === '' || payment_input.val() == '0')) {
                __write_number(payment_input, amount);
            }

            var payment_amount = __read_number(payment_input);
            var payment_due = amount - payment_amount;
            $('#expense_payment_due').text(__currency_trans_from_en(payment_due, false, false));
        }

        $(document).on('change', '#modal_expense_currency_id', function() {
            var selected_currency_id = $(this).val();
            if (selected_currency_id == base_currency_id) {
                $('#modal_expense_exchange_rate_div').hide();
                updateModalExpenseRateAndPreview();
            } else {
                $('#modal_expense_exchange_rate_div').show();
                $.ajax({
                    url: '/get-exchange-rate',
                    method: 'GET',
                    data: {
                        from_currency_id: base_currency_id,
                        to_currency_id: selected_currency_id
                    },
                    success: function(response) {
                        if (response.success && response.rate > 0) {
                            __write_number($('#modal_expense_exchange_rate'), response.rate);
                        }
                        updateModalExpenseRateAndPreview();
                    },
                    error: function() {
                        updateModalExpenseRateAndPreview();
                    }
                });
            }
        });

        $(document).on('input change', '#expense_final_total, #modal_expense_exchange_rate', function() {
            updateModalExpenseRateAndPreview();
        });

        $(document).on('input change', '#add_expense_modal_form input.payment-amount', function() {
            var amount = __read_number($('input#expense_final_total'));
            var payment_amount = __read_number($('#add_expense_modal_form input.payment-amount'));
            var payment_due = amount - payment_amount;
            $('#expense_payment_due').text(__currency_trans_from_en(payment_due, false, false));
        });

        updateModalExpenseRateAndPreview();
    });
</script>
