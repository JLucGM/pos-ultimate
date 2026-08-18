<div class="modal fade" tabindex="-1" role="dialog" id="modal_payment">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('lang_v1.payment')</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-12">
                        <strong>@lang('lang_v1.advance_balance'):</strong> <span id="advance_balance_text"></span>
                        {!! Form::hidden('advance_balance', null, [
                            'id' => 'advance_balance',
                            'data-error-msg' => __('lang_v1.required_advance_balance_not_available'),
                        ]) !!}
                    </div>
                    <div class="col-md-9">
                        <!-- Botones de Cobro Rápido Multimoneda Venezuela -->
                        <div style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 14px; padding: 12px 16px; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-coins tw-text-[#FB4C0A]"></i>
                                <span style="font-size: 12px; font-weight: 700; color: #FFFFFF; text-transform: uppercase;">Modo de Pago Rápido:</span>
                            </div>
                            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                <button type="button" class="btn btn-sm" id="quick_pay_usd_btn" style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10B981; color: #34D399; font-weight: 800; border-radius: 8px; padding: 6px 14px;">
                                    💵 Todo en Dólares ($)
                                </button>
                                <button type="button" class="btn btn-sm" id="quick_pay_bs_btn" style="background: rgba(56, 189, 248, 0.2); border: 1px solid #38BDF8; color: #38BDF8; font-weight: 800; border-radius: 8px; padding: 6px 14px;">
                                    🇻🇪 Todo en Bolívares (Bs)
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div id="payment_rows_div">
                                @php
                                    $pos_settings = !empty(session()->get('business.pos_settings')) ? json_decode(session()->get('business.pos_settings'), true) : [];
                                    $show_in_pos = '';


                                    if (isset($pos_settings['enable_cash_denomination_on']) && ($pos_settings['enable_cash_denomination_on'] == 'all_screens' || $pos_settings['enable_cash_denomination_on'] == 'pos_screen')) {
                                        $show_in_pos = true;
                                    }
                                    
                                @endphp
                                @foreach ($payment_lines as $payment_line)
                                    @if ($payment_line['is_return'] == 1)
                                        @php
                                            $change_return = $payment_line;
                                        @endphp

                                        @continue
                                    @endif

                                    @include('sale_pos.partials.payment_row', [
                                        'removable' => !$loop->first,
                                        'row_index' => $loop->index,
                                        'payment_line' => $payment_line,
                                        'show_denomination' => true,
                                        'show_in_pos' => $show_in_pos,
                                    ])
                                @endforeach
                            </div>
                            <input type="hidden" id="payment_row_index" value="{{ count($payment_lines) }}">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-sm tw-w-full"
                                    id="add-payment-row">@lang('sale.add_payment_row')</button>
                            </div>
                        </div>
                        <br>
                        <div class="row @if ($change_return['amount'] == 0) hide @endif payment_row"
                            id="change_return_payment_data">
                            <div class="col-md-12">
                                <div class="box box-solid payment_row bg-lightgray">
                                    <div class="box-body">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('change_return_method', __('lang_v1.change_return_payment_method') . ':*') !!}
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fas fa-money-bill-alt"></i>
                                                    </span>
                                                    @php
                                                        $_payment_method = empty($change_return['method']) && array_key_exists('cash', $payment_types) ? 'cash' : $change_return['method'];

                                                        $_payment_types = $payment_types;
                                                        if (isset($_payment_types['advance'])) {
                                                            unset($_payment_types['advance']);
                                                        }
                                                    @endphp
                                                    {!! Form::select('payment[change_return][method]', $_payment_types, $_payment_method, [
                                                        'class' => 'form-control col-md-12 payment_types_dropdown',
                                                        'id' => 'change_return_method',
                                                        'style' => 'width:100%;',
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </div>
                                        @if (!empty($accounts))
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('change_return_account', __('lang_v1.change_return_payment_account') . ':') !!}
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fas fa-money-bill-alt"></i>
                                                        </span>
                                                        {!! Form::select(
                                                            'payment[change_return][account_id]',
                                                            $accounts,
                                                            !empty($change_return['account_id']) ? $change_return['account_id'] : '',
                                                            ['class' => 'form-control select2', 'id' => 'change_return_account', 'style' => 'width:100%;'],
                                                        ) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::label('change_return_payment_currency', 'Moneda de Vuelto:') !!}
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fas fa-coins"></i>
                                                    </span>
                                                    <select class="form-control" id="change_return_payment_currency">
                                                        <option value="USD">Dólares ($ USD)</option>
                                                        <option value="VES">Bolívares (Bs)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        @include('sale_pos.partials.payment_type_details', [
                                            'payment_line' => $change_return,
                                            'row_index' => 'change_return',
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('sale_note', __('sale.sell_note') . ':') !!}
                                    {!! Form::textarea('sale_note', !empty($transaction) ? $transaction->additional_notes : null, [
                                        'class' => 'form-control',
                                        'rows' => 3,
                                        'placeholder' => __('sale.sell_note'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('staff_note', __('sale.staff_note') . ':') !!}
                                    {!! Form::textarea('staff_note', !empty($transaction) ? $transaction->staff_note : null, [
                                        'class' => 'form-control',
                                        'rows' => 3,
                                        'placeholder' => __('sale.staff_note'),
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; padding: 18px;">
                            <div style="margin-bottom: 14px;">
                                <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #94A3B8;">@lang('lang_v1.total_items')</div>
                                <div style="font-size: 20px; font-weight: 800; color: #FFFFFF;" class="total_quantity">0</div>
                            </div>

                            <div style="margin-bottom: 14px; padding-top: 10px; border-top: 1px dashed rgba(255, 255, 255, 0.1);">
                                <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #94A3B8;">@lang('sale.total_payable')</div>
                                <div style="font-size: 24px; font-weight: 900; color: #FFFFFF;" class="total_payable_span">0.00</div>
                                <div style="font-size: 14px; font-weight: 800; color: #38BDF8; font-family: ui-monospace, monospace;" class="pos_dual_total_bs">Bs. 0,00</div>
                            </div>

                            <div style="margin-bottom: 14px; padding-top: 10px; border-top: 1px dashed rgba(255, 255, 255, 0.1);">
                                <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #38BDF8;">@lang('lang_v1.total_paying')</div>
                                <div style="font-size: 22px; font-weight: 800; color: #38BDF8;" class="total_paying">0.00</div>
                                <div style="font-size: 13px; font-weight: 800; color: #7DD3FC; font-family: ui-monospace, monospace;" class="pos_dual_paying_bs">Bs. 0,00</div>
                                <input type="hidden" id="total_paying_input">
                            </div>

                            <div style="margin-bottom: 14px; padding-top: 10px; border-top: 1px dashed rgba(255, 255, 255, 0.1);">
                                <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #10B981;">@lang('lang_v1.change_return') (Vuelto)</div>
                                <div style="font-size: 24px; font-weight: 900; color: #10B981;" class="change_return_span">0.00</div>
                                <div style="font-size: 14px; font-weight: 800; color: #34D399; font-family: ui-monospace, monospace;" class="pos_dual_change_bs">Bs. 0,00</div>
                                {!! Form::hidden('change_return', $change_return['amount'], [
                                    'class' => 'form-control change_return input_number',
                                    'required',
                                    'id' => 'change_return',
                                ]) !!}
                                @if (!empty($change_return['id']))
                                    <input type="hidden" name="change_return_id"
                                        value="{{ $change_return['id'] }}">
                                @endif
                            </div>

                            <div style="padding-top: 10px; border-top: 1px dashed rgba(255, 255, 255, 0.1);">
                                <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #FB4C0A;">@lang('lang_v1.balance')</div>
                                <div style="font-size: 22px; font-weight: 900; color: #FB4C0A;" class="balance_due">0.00</div>
                                <div style="font-size: 13px; font-weight: 800; color: #FCA5A5; font-family: ui-monospace, monospace;" class="pos_dual_balance_bs">Bs. 0,00</div>
                                <input type="hidden" id="in_balance_due" value=0>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn btn-default" style="border-radius: 10px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: #FFF; padding: 10px 20px; font-weight: 600;" data-dismiss="modal">@lang('messages.close')</button>
                <button type="submit" class="btn" style="border-radius: 10px; background: linear-gradient(135deg, #FB4C0A 0%, #E03E00 100%); color: #FFF; padding: 10px 24px; font-weight: 800; box-shadow: 0 4px 14px rgba(251,76,10,0.4);" id="pos-save">
                    <i class="fas fa-check-circle"></i> @lang('sale.finalize_payment')
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Used for express checkout card transaction -->
<div class="modal fade" tabindex="-1" role="dialog" id="card_details_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('lang_v1.card_transaction_details')</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('card_number', __('lang_v1.card_no')) !!}
                                {!! Form::text('', null, [
                                    'class' => 'form-control',
                                    'placeholder' => __('lang_v1.card_no'),
                                    'id' => 'card_number',
                                    'autofocus',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('card_holder_name', __('lang_v1.card_holder_name')) !!}
                                {!! Form::text('', null, [
                                    'class' => 'form-control',
                                    'placeholder' => __('lang_v1.card_holder_name'),
                                    'id' => 'card_holder_name',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('card_transaction_number', __('lang_v1.card_transaction_no')) !!}
                                {!! Form::text('', null, [
                                    'class' => 'form-control',
                                    'placeholder' => __('lang_v1.card_transaction_no'),
                                    'id' => 'card_transaction_number',
                                ]) !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('card_type', __('lang_v1.card_type')) !!}
                                {!! Form::select('', ['visa' => 'Visa', 'master' => 'MasterCard'], 'visa', [
                                    'class' => 'form-control select2',
                                    'id' => 'card_type',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('card_month', __('lang_v1.month')) !!}
                                {!! Form::text('', null, [
                                    'class' => 'form-control',
                                    'placeholder' => __('lang_v1.month'),
                                    'id' => 'card_month',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('card_year', __('lang_v1.year')) !!}
                                {!! Form::text('', null, ['class' => 'form-control', 'placeholder' => __('lang_v1.year'), 'id' => 'card_year']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('card_security', __('lang_v1.security_code')) !!}
                                {!! Form::text('', null, [
                                    'class' => 'form-control',
                                    'placeholder' => __('lang_v1.security_code'),
                                    'id' => 'card_security',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="tw-dw-btn tw-dw-btn-primary tw-text-white" id="pos-save-card">@lang('sale.finalize_payment')</button>
            </div>
        </div>
    </div>
</div>
