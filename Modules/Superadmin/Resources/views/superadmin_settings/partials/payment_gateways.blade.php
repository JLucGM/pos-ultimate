<div class="pos-tab-content">
    <div class="alert alert-info" style="border-radius: 12px; background-color: #F0F9FF; border-color: #BAE6FD; color: #0369A1;">
        <i class="fas fa-info-circle"></i>
        <strong>Configuración de Métodos de Cobro de Suscripciones (Venezuela & Internacional):</strong>
        Configura los datos receptores para que tus clientes puedan pagar y reportar sus suscripciones en Bolívares (Pago Móvil / Transferencia) o Dólares/Cripto (Zelle, Binance Pay, PayPal).
    </div>

    <!-- 1. PAGO MÓVIL (VENEZUELA) -->
    <div class="box box-solid" style="border-radius: 12px; border: 1px solid #E2E8F0; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
        <div class="box-header with-border" style="background: #FAF5FF; border-radius: 12px 12px 0 0; padding: 14px 18px;">
            <h4 class="box-title" style="font-weight: 800; color: #6B21A8; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-mobile-alt"></i> 1. Pago Móvil (Bolívares Bs. - Tasa BCV)
            </h4>
            <div class="box-tools pull-right">
                <label style="margin: 0; cursor: pointer;">
                    {!! Form::checkbox('enable_pagomovil', 1, isset($settings["enable_pagomovil"]) ? $settings["enable_pagomovil"] : 1, ['class' => 'input-icheck']); !!}
                    <strong>Habilitar Pago Móvil</strong>
                </label>
            </div>
        </div>
        <div class="box-body" style="padding: 18px;">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('pagomovil_bank', 'Banco Receptor:') !!}
                        {!! Form::text('pagomovil_bank', $settings['pagomovil_bank'] ?? 'Banco de Venezuela (0102)', ['class' => 'form-control', 'placeholder' => 'Ej: Banco de Venezuela (0102)']); !!}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('pagomovil_phone', 'Teléfono Receptor:') !!}
                        {!! Form::text('pagomovil_phone', $settings['pagomovil_phone'] ?? '0414-2909870', ['class' => 'form-control', 'placeholder' => 'Ej: 0414-1234567']); !!}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('pagomovil_id_doc', 'Cédula / RIF Receptor:') !!}
                        {!! Form::text('pagomovil_id_doc', $settings['pagomovil_id_doc'] ?? 'J-50000000-0', ['class' => 'form-control', 'placeholder' => 'Ej: J-12345678-0 o V-12345678']); !!}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('pagomovil_holder', 'Nombre del Titular:') !!}
                        {!! Form::text('pagomovil_holder', $settings['pagomovil_holder'] ?? 'Kubre POS C.A.', ['class' => 'form-control', 'placeholder' => 'Ej: Kubre POS C.A.']); !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. TRANSFERENCIA BANCARIA NACIONAL -->
    <div class="box box-solid" style="border-radius: 12px; border: 1px solid #E2E8F0; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
        <div class="box-header with-border" style="background: #F0FDF4; border-radius: 12px 12px 0 0; padding: 14px 18px;">
            <h4 class="box-title" style="font-weight: 800; color: #166534; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-university"></i> 2. Transferencia Bancaria Nacional (Bolívares / Dólares)
            </h4>
            <div class="box-tools pull-right">
                <label style="margin: 0; cursor: pointer;">
                    {!! Form::checkbox('enable_bank_transfer', 1, isset($settings["enable_bank_transfer"]) ? $settings["enable_bank_transfer"] : 1, ['class' => 'input-icheck']); !!}
                    <strong>Habilitar Transferencia</strong>
                </label>
            </div>
        </div>
        <div class="box-body" style="padding: 18px;">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('bank_transfer_bank', 'Banco:') !!}
                        {!! Form::text('bank_transfer_bank', $settings['bank_transfer_bank'] ?? 'Banesco Banco Universal (0134)', ['class' => 'form-control', 'placeholder' => 'Ej: Banesco Banco Universal']); !!}
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('bank_transfer_account', 'Número de Cuenta (20 dígitos):') !!}
                        {!! Form::text('bank_transfer_account', $settings['bank_transfer_account'] ?? '', ['class' => 'form-control', 'placeholder' => '0134-0000-00-0000000000']); !!}
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('bank_transfer_type', 'Tipo de Cuenta:') !!}
                        {!! Form::text('bank_transfer_type', $settings['bank_transfer_type'] ?? 'Cuenta Corriente', ['class' => 'form-control', 'placeholder' => 'Ej: Cuenta Corriente / Cuenta Custodia $']); !!}
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('bank_transfer_holder', 'Titular de la Cuenta:') !!}
                        {!! Form::text('bank_transfer_holder', $settings['bank_transfer_holder'] ?? 'Kubre POS C.A.', ['class' => 'form-control', 'placeholder' => 'Ej: Kubre POS C.A.']); !!}
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('bank_transfer_id_doc', 'RIF / Cédula del Titular:') !!}
                        {!! Form::text('bank_transfer_id_doc', $settings['bank_transfer_id_doc'] ?? 'J-50000000-0', ['class' => 'form-control', 'placeholder' => 'Ej: J-50000000-0']); !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. ZELLE (USD) -->
    <div class="box box-solid" style="border-radius: 12px; border: 1px solid #E2E8F0; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
        <div class="box-header with-border" style="background: #F5F3FF; border-radius: 12px 12px 0 0; padding: 14px 18px;">
            <h4 class="box-title" style="font-weight: 800; color: #5B21B6; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-dollar-sign"></i> 3. Zelle (Dólares USD)
            </h4>
            <div class="box-tools pull-right">
                <label style="margin: 0; cursor: pointer;">
                    {!! Form::checkbox('enable_zelle', 1, isset($settings["enable_zelle"]) ? $settings["enable_zelle"] : 1, ['class' => 'input-icheck']); !!}
                    <strong>Habilitar Zelle</strong>
                </label>
            </div>
        </div>
        <div class="box-body" style="padding: 18px;">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('zelle_email', 'Correo Electrónico / Teléfono Zelle Receptor:') !!}
                        {!! Form::text('zelle_email', $settings['zelle_email'] ?? 'pagos@kubre.site', ['class' => 'form-control', 'placeholder' => 'Ej: pagos@kubre.site']); !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('zelle_holder', 'Nombre del Titular de la Cuenta Zelle:') !!}
                        {!! Form::text('zelle_holder', $settings['zelle_holder'] ?? 'Kubre Technologies LLC', ['class' => 'form-control', 'placeholder' => 'Ej: Kubre Technologies LLC']); !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. BINANCE PAY / USDT -->
    <div class="box box-solid" style="border-radius: 12px; border: 1px solid #E2E8F0; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
        <div class="box-header with-border" style="background: #FEFCE8; border-radius: 12px 12px 0 0; padding: 14px 18px;">
            <h4 class="box-title" style="font-weight: 800; color: #854D0E; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-coins"></i> 4. Binance Pay / Cripto (USDT)
            </h4>
            <div class="box-tools pull-right">
                <label style="margin: 0; cursor: pointer;">
                    {!! Form::checkbox('enable_binance', 1, isset($settings["enable_binance"]) ? $settings["enable_binance"] : 1, ['class' => 'input-icheck']); !!}
                    <strong>Habilitar Binance Pay</strong>
                </label>
            </div>
        </div>
        <div class="box-body" style="padding: 18px;">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('binance_pay_id', 'Binance Pay ID / User ID:') !!}
                        {!! Form::text('binance_pay_id', $settings['binance_pay_id'] ?? '', ['class' => 'form-control', 'placeholder' => 'Ej: 123456789']); !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('binance_email', 'Correo o Usuario Binance:') !!}
                        {!! Form::text('binance_email', $settings['binance_email'] ?? 'binance@kubre.site', ['class' => 'form-control', 'placeholder' => 'Ej: binance@kubre.site']); !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('binance_network', 'Moneda y Red Soportada:') !!}
                        {!! Form::text('binance_network', $settings['binance_network'] ?? 'USDT (BNB Smart Chain / TRC20)', ['class' => 'form-control', 'placeholder' => 'Ej: USDT (BNB Chain / TRC20)']); !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. PAYPAL -->
    <div class="box box-solid" style="border-radius: 12px; border: 1px solid #E2E8F0; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
        <div class="box-header with-border" style="background: #EFF6FF; border-radius: 12px 12px 0 0; padding: 14px 18px;">
            <h4 class="box-title" style="font-weight: 800; color: #1E40AF; display: flex; align-items: center; gap: 8px;">
                <i class="fab fa-paypal"></i> 5. PayPal (Dólares USD)
            </h4>
            <div class="box-tools pull-right">
                <label style="margin: 0; cursor: pointer;">
                    {!! Form::checkbox('enable_paypal', 1, isset($settings["enable_paypal"]) ? $settings["enable_paypal"] : 1, ['class' => 'input-icheck']); !!}
                    <strong>Habilitar PayPal</strong>
                </label>
            </div>
        </div>
        <div class="box-body" style="padding: 18px;">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('paypal_email', 'Correo Electrónico de Cuenta PayPal:') !!}
                        {!! Form::text('paypal_email', $settings['paypal_email'] ?? 'pagos@kubre.site', ['class' => 'form-control', 'placeholder' => 'Ej: pagos@kubre.site']); !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('paypal_me_url', 'Enlace Directo PayPal.me (Opcional):') !!}
                        {!! Form::text('paypal_me_url', $settings['paypal_me_url'] ?? '', ['class' => 'form-control', 'placeholder' => 'Ej: https://paypal.me/kubrepos']); !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 6. INSTRUCCIONES GENERALES -->
    <div class="box box-solid" style="border-radius: 12px; border: 1px solid #E2E8F0; margin-bottom: 20px;">
        <div class="box-header with-border" style="background: #F8FAFC; border-radius: 12px 12px 0 0; padding: 14px 18px;">
            <h4 class="box-title" style="font-weight: 700; color: #334155;">
                <i class="fas fa-file-alt text-muted"></i> Instrucciones Adicionales o Notas para el Cliente
            </h4>
        </div>
        <div class="box-body" style="padding: 18px;">
            <div class="form-group">
                {!! Form::textarea('offline_payment_details', !empty($settings["offline_payment_details"]) ? $settings["offline_payment_details"] : null, ['class' => 'form-control', 'placeholder' => 'Información complementaria que aparecerá en el checkout de suscripción...', 'rows' => 3]); !!}
            </div>
        </div>
    </div>
</div>