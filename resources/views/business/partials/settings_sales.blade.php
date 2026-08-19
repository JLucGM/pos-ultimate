<div class="pos-tab-content">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('default_sales_discount', __('business.default_sales_discount') . ':*') !!}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-percent"></i>
                    </span>
                    {!! Form::text('default_sales_discount', @num_format($business->default_sales_discount), ['class' => 'form-control input_number']); !!}
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('default_sales_tax', __('business.default_sales_tax') . ':') !!}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-info"></i>
                    </span>
                    {!! Form::select('default_sales_tax', $tax_rates, $business->default_sales_tax, ['class' => 'form-control select2','placeholder' => __('business.default_sales_tax'), 'style' => 'width: 100%;']); !!}
                </div>
            </div>
        </div>
        <!-- <div class="clearfix"></div> -->

        {{--<div class="col-sm-12 hide">
            <div class="form-group">
                {!! Form::label('sell_price_tax', __('business.sell_price_tax') . ':') !!}
                <div class="input-group">
                    <div class="radio">
                        <label>
                            <input type="radio" name="sell_price_tax" value="includes" 
                            class="input-icheck" @if($business->sell_price_tax == 'includes') {{'checked'}} @endif> Includes the Sale Tax
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="sell_price_tax" value="excludes" 
                            class="input-icheck" @if($business->sell_price_tax == 'excludes') {{'checked'}} @endif>Excludes the Sale Tax (Calculate sale tax on Selling Price provided in Add Purchase)
                        </label>
                    </div>
                </div>
            </div>
        </div>--}}
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('item_addition_method', __('lang_v1.sales_item_addition_method') . ':') !!}
                {!! Form::select('item_addition_method', [ 0 => __('lang_v1.add_item_in_new_row'), 1 =>  __('lang_v1.increase_item_qty')], $business->item_addition_method, ['class' => 'form-control select2', 'style' => 'width: 100%;']); !!}
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('amount_rounding_method', __('lang_v1.amount_rounding_method') . ':') !!} @show_tooltip(__('lang_v1.amount_rounding_method_help'))
                {!! Form::select('pos_settings[amount_rounding_method]', 
                [ 
                    '1' =>  __('lang_v1.round_to_nearest_whole_number'), 
                    '0.05' =>  __('lang_v1.round_to_nearest_decimal', ['multiple' => 0.05]), 
                    '0.1' =>  __('lang_v1.round_to_nearest_decimal', ['multiple' => 0.1]),
                    '0.5' =>  __('lang_v1.round_to_nearest_decimal', ['multiple' => 0.5])
                ], 
                !empty($pos_settings['amount_rounding_method']) ? $pos_settings['amount_rounding_method'] : null, ['class' => 'form-control select2', 'style' => 'width: 100%;', 'placeholder' => __('lang_v1.none')]); !!}
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="checkbox">
                <br>
                  <label>
                    {!! Form::checkbox('pos_settings[enable_msp]', 1,  
                        !empty($pos_settings['enable_msp']) ? true : false , 
                    [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.sale_price_is_minimum_sale_price' ) }} 
                  </label>
                  @show_tooltip(__('lang_v1.minimum_sale_price_help'))
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="checkbox">
                <br>
                  <label>
                    {!! Form::checkbox('pos_settings[allow_overselling]', 1,  
                        !empty($pos_settings['allow_overselling']) ? true : false , 
                    [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.allow_overselling' ) }} 
                  </label>
                  @show_tooltip(__('lang_v1.allow_overselling_help'))
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                    {!! Form::checkbox('pos_settings[enable_sales_order]', 1, !empty($pos_settings['enable_sales_order']) , [ 'class' => 'input-icheck', 'id' => 'enable_sales_order']); !!} {{ __( 'lang_v1.enable_sales_order' ) }}
                    </label>
                  @show_tooltip(__('lang_v1.sales_order_help_text'))
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                    {!! Form::checkbox('pos_settings[is_pay_term_required]', 1, !empty($pos_settings['is_pay_term_required']) , [ 'class' => 'input-icheck', 'id' => 'is_pay_term_required']); !!} {{ __( 'lang_v1.is_pay_term_required' ) }}
                    </label>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-md-12"><h4>@lang('lang_v1.commission_agent'):</h4></div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('sales_cmsn_agnt', __('lang_v1.sales_commission_agent') . ':') !!}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-info"></i>
                    </span>
                    {!! Form::select('sales_cmsn_agnt', $commission_agent_dropdown, $business->sales_cmsn_agnt, ['class' => 'form-control select2', 'style' => 'width: 100%;']); !!}
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('cmmsn_calculation_type', __('lang_v1.cmmsn_calculation_type') . ':') !!}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-info"></i>
                    </span>
                    {!! Form::select('pos_settings[cmmsn_calculation_type]', ['invoice_value' => __('lang_v1.invoice_value'), 'payment_received' => __('lang_v1.payment_received')], !empty($pos_settings['cmmsn_calculation_type']) ? $pos_settings['cmmsn_calculation_type'] : null, ['class' => 'form-control select2', 'style' => 'width: 100%;', 'id' => 'cmmsn_calculation_type']); !!}
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                    {!! Form::checkbox('pos_settings[is_commission_agent_required]', 1, !empty($pos_settings['is_commission_agent_required']) , [ 'class' => 'input-icheck', 'id' => 'is_commission_agent_required']); !!} {{ __( 'lang_v1.is_commission_agent_required' ) }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <h4 style="font-weight: 800; color: #0F172A; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-money-check-alt" style="color: #FB4C0A;"></i> Métodos de Pago y Datos de Cobro para Clientes
                @show_tooltip('Configura las cuentas y métodos de pago de tu negocio para que tus clientes puedan transferirte y reportar sus pagos en los enlaces de cobro y facturas.')
            </h4>
        </div>
        
        <div class="col-sm-12" style="margin-bottom: 15px;">
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('pos_settings[enable_payment_link]', 1, !empty($pos_settings['enable_payment_link']), ['class' => 'input-icheck', 'id' => 'enable_payment_link']); !!} 
                    <strong>Habilitar enlaces de pago / cobro para facturas y ventas a crédito</strong>
                </label>
            </div>
            <small class="text-muted">Al activarlo, tus clientes podrán acceder a un enlace web con el detalle de su factura y tus datos bancarios para pagar.</small>
        </div>

        <!-- 1. PAGO MÓVIL (BOLÍVARES) -->
        <div class="col-md-12">
            <div class="box box-solid" style="border: 1px solid #E2E8F0; border-radius: 10px; margin-bottom: 15px; box-shadow: none;">
                <div class="box-header with-border" style="background: #FAF5FF; padding: 10px 15px;">
                    <h5 class="box-title" style="font-weight: 700; color: #6B21A8;">
                        <i class="fas fa-mobile-alt"></i> 1. Pago Móvil (Bolívares Bs.)
                    </h5>
                    <div class="box-tools pull-right">
                        <label style="margin: 0; cursor: pointer; font-size: 12.5px;">
                            {!! Form::checkbox('pos_settings[enable_pagomovil]', 1, !empty($pos_settings['enable_pagomovil']), ['class' => 'input-icheck']); !!}
                            <strong>Habilitar</strong>
                        </label>
                    </div>
                </div>
                <div class="box-body" style="padding: 15px;">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('pm_bank', 'Banco Receptor:') !!}
                                {!! Form::text('pos_settings[pm_bank]', $pos_settings['pm_bank'] ?? '', ['class' => 'form-control', 'placeholder' => 'Ej: Banco de Venezuela (0102)']); !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('pm_phone', 'Teléfono Receptor:') !!}
                                {!! Form::text('pos_settings[pm_phone]', $pos_settings['pm_phone'] ?? '', ['class' => 'form-control', 'placeholder' => 'Ej: 0414-1234567']); !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('pm_id_doc', 'Cédula / RIF:') !!}
                                {!! Form::text('pos_settings[pm_id_doc]', $pos_settings['pm_id_doc'] ?? '', ['class' => 'form-control', 'placeholder' => 'Ej: J-12345678-0']); !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('pm_holder', 'Nombre del Titular:') !!}
                                {!! Form::text('pos_settings[pm_holder]', $pos_settings['pm_holder'] ?? '', ['class' => 'form-control', 'placeholder' => 'Ej: Mi Negocio C.A.']); !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. TRANSFERENCIA BANCARIA NACIONAL -->
        <div class="col-md-12">
            <div class="box box-solid" style="border: 1px solid #E2E8F0; border-radius: 10px; margin-bottom: 15px; box-shadow: none;">
                <div class="box-header with-border" style="background: #F0FDF4; padding: 10px 15px;">
                    <h5 class="box-title" style="font-weight: 700; color: #166534;">
                        <i class="fas fa-university"></i> 2. Transferencia Bancaria Nacional (Bolívares / Dólares)
                    </h5>
                    <div class="box-tools pull-right">
                        <label style="margin: 0; cursor: pointer; font-size: 12.5px;">
                            {!! Form::checkbox('pos_settings[enable_bank_transfer]', 1, !empty($pos_settings['enable_bank_transfer']), ['class' => 'input-icheck']); !!}
                            <strong>Habilitar</strong>
                        </label>
                    </div>
                </div>
                <div class="box-body" style="padding: 15px;">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('bt_bank', 'Banco:') !!}
                                {!! Form::text('pos_settings[bt_bank]', $pos_settings['bt_bank'] ?? '', ['class' => 'form-control', 'placeholder' => 'Ej: Banesco Banco Universal']); !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('bt_account', 'N° de Cuenta (20 dígitos):') !!}
                                {!! Form::text('pos_settings[bt_account]', $pos_settings['bt_account'] ?? '', ['class' => 'form-control', 'placeholder' => '0134-0000-00-0000000000']); !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('bt_type', 'Tipo de Cuenta:') !!}
                                {!! Form::text('pos_settings[bt_type]', $pos_settings['bt_type'] ?? 'Cuenta Corriente', ['class' => 'form-control', 'placeholder' => 'Ej: Corriente / Custodia $']); !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('bt_holder', 'Nombre del Titular:') !!}
                                {!! Form::text('pos_settings[bt_holder]', $pos_settings['bt_holder'] ?? '', ['class' => 'form-control', 'placeholder' => 'Ej: Mi Negocio C.A.']); !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('bt_id_doc', 'RIF / Cédula:') !!}
                                {!! Form::text('pos_settings[bt_id_doc]', $pos_settings['bt_id_doc'] ?? '', ['class' => 'form-control', 'placeholder' => 'Ej: J-12345678-0']); !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. ZELLE (USD) -->
        <div class="col-md-12">
            <div class="box box-solid" style="border: 1px solid #E2E8F0; border-radius: 10px; margin-bottom: 15px; box-shadow: none;">
                <div class="box-header with-border" style="background: #EEF2FF; padding: 10px 15px;">
                    <h5 class="box-title" style="font-weight: 700; color: #3730A3;">
                        <i class="fas fa-dollar-sign"></i> 3. Zelle (Dólares USD)
                    </h5>
                    <div class="box-tools pull-right">
                        <label style="margin: 0; cursor: pointer; font-size: 12.5px;">
                            {!! Form::checkbox('pos_settings[enable_zelle]', 1, !empty($pos_settings['enable_zelle']), ['class' => 'input-icheck']); !!}
                            <strong>Habilitar</strong>
                        </label>
                    </div>
                </div>
                <div class="box-body" style="padding: 15px;">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('zelle_email', 'Correo o Teléfono Zelle:') !!}
                                {!! Form::text('pos_settings[zelle_email]', $pos_settings['zelle_email'] ?? '', ['class' => 'form-control', 'placeholder' => 'Ej: pagos@minegocio.com']); !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('zelle_holder', 'Nombre del Titular Zelle:') !!}
                                {!! Form::text('pos_settings[zelle_holder]', $pos_settings['zelle_holder'] ?? '', ['class' => 'form-control', 'placeholder' => 'Ej: Nombre del Titular']); !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. BINANCE PAY / USDT -->
        <div class="col-md-12">
            <div class="box box-solid" style="border: 1px solid #E2E8F0; border-radius: 10px; margin-bottom: 15px; box-shadow: none;">
                <div class="box-header with-border" style="background: #FEFCE8; padding: 10px 15px;">
                    <h5 class="box-title" style="font-weight: 700; color: #854D0E;">
                        <i class="fas fa-coins"></i> 4. Binance Pay / Criptomonedas (USDT)
                    </h5>
                    <div class="box-tools pull-right">
                        <label style="margin: 0; cursor: pointer; font-size: 12.5px;">
                            {!! Form::checkbox('pos_settings[enable_binance]', 1, !empty($pos_settings['enable_binance']), ['class' => 'input-icheck']); !!}
                            <strong>Habilitar</strong>
                        </label>
                    </div>
                </div>
                <div class="box-body" style="padding: 15px;">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('binance_pay_id', 'Binance Pay ID:') !!}
                                {!! Form::text('pos_settings[binance_pay_id]', $pos_settings['binance_pay_id'] ?? '', ['class' => 'form-control', 'placeholder' => 'Ej: 123456789']); !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('binance_email', 'Correo o Usuario Binance:') !!}
                                {!! Form::text('pos_settings[binance_email]', $pos_settings['binance_email'] ?? '', ['class' => 'form-control', 'placeholder' => 'Ej: usuario@binance']); !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('binance_network', 'Moneda y Red:') !!}
                                {!! Form::text('pos_settings[binance_network]', $pos_settings['binance_network'] ?? 'USDT (BNB Chain / TRC20)', ['class' => 'form-control', 'placeholder' => 'Ej: USDT (BNB Chain / TRC20)']); !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. PAYPAL -->
        <div class="col-md-12">
            <div class="box box-solid" style="border: 1px solid #E2E8F0; border-radius: 10px; margin-bottom: 15px; box-shadow: none;">
                <div class="box-header with-border" style="background: #EFF6FF; padding: 10px 15px;">
                    <h5 class="box-title" style="font-weight: 700; color: #1E40AF;">
                        <i class="fab fa-paypal"></i> 5. PayPal (Dólares USD)
                    </h5>
                    <div class="box-tools pull-right">
                        <label style="margin: 0; cursor: pointer; font-size: 12.5px;">
                            {!! Form::checkbox('pos_settings[enable_paypal]', 1, !empty($pos_settings['enable_paypal']), ['class' => 'input-icheck']); !!}
                            <strong>Habilitar</strong>
                        </label>
                    </div>
                </div>
                <div class="box-body" style="padding: 15px;">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('paypal_email', 'Correo de Cuenta PayPal:') !!}
                                {!! Form::text('pos_settings[paypal_email]', $pos_settings['paypal_email'] ?? '', ['class' => 'form-control', 'placeholder' => 'Ej: pagos@minegocio.com']); !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('paypal_me_url', 'Enlace PayPal.Me (Opcional):') !!}
                                {!! Form::text('pos_settings[paypal_me_url]', $pos_settings['paypal_me_url'] ?? '', ['class' => 'form-control', 'placeholder' => 'Ej: https://paypal.me/minegocio']); !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 6. NOTAS E INSTRUCCIONES DE PAGO -->
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('payment_instructions', 'Instrucciones Adicionales o Términos de Pago:') !!}
                {!! Form::textarea('pos_settings[payment_instructions]', $pos_settings['payment_instructions'] ?? '', ['class' => 'form-control', 'rows' => 2, 'placeholder' => 'Ej: Favor enviar comprobante al WhatsApp...']); !!}
            </div>
        </div>
    </div>
</div>