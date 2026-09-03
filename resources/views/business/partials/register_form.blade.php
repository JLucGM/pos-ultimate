
{!! Form::hidden('language', request()->lang); !!}
<!-- Anti-Bot Honeypot & Security Tokens (Invisible to humans, traps automated scripts) -->
<div style="position: absolute; left: -9999px; top: -9999px; opacity: 0; pointer-events: none; height: 0; width: 0; overflow: hidden;" aria-hidden="true" tabindex="-1">
    <input type="text" name="website_url_hp" id="website_url_hp" tabindex="-1" autocomplete="new-password" value="">
    <input type="text" name="user_validation_hp" id="user_validation_hp" tabindex="-1" autocomplete="off" value="">
    <input type="hidden" name="_form_load_time" value="{{ time() }}">
</div>

<!-- PASO 1: Datos del Negocio -->
<div class="auth-step-pane active" id="auth-step-1">
    <fieldset>
    <legend class="text-black"><i class="fas fa-building" style="margin-right: 6px;"></i> @lang('business.business_details'):</legend>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('name', __('business.business_name') . ':*' ) !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-suitcase"></i>
                </span>
                {!! Form::text('name', null, ['class' => 'form-control','placeholder' => __('business.business_name'), 'required']); !!}
            </div>
        </div>
    </div>
            
    <div class="col-md-6">
        <div class="form-group">
        {!! Form::label('start_date', __('business.start_date') . ':') !!}
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            {!! Form::text('start_date', null, ['class' => 'form-control start-date-picker','placeholder' => __('business.start_date'), 'readonly']); !!}
        </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
        {!! Form::label('currency_id', __('business.currency') . ':*') !!}
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fas fa-money-bill-alt"></i>
            </span>
            {!! Form::select('currency_id', $currencies, 2, ['class' => 'form-control select2_register','placeholder' => __('business.currency_placeholder'), 'required', 'style' => 'width:100%;']); !!}
        </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('business_logo', __('business.upload_logo') . ':') !!}
            <div class="auth-file-upload-box">
                <input type="file" name="business_logo" id="business_logo" accept="image/*" class="auth-file-input" onchange="previewLogoName(this)">
                <div class="auth-file-custom-ui">
                    <i class="fas fa-cloud-upload-alt auth-file-icon"></i>
                    <div class="auth-file-info">
                        <span class="auth-file-text" id="logo_filename_display">Seleccionar imagen del logo</span>
                        <span class="auth-file-hint">PNG, JPG, SVG o WEBP</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('website', __('lang_v1.website') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-globe"></i>
                </span>
                {!! Form::text('website', null, ['class' => 'form-control','placeholder' => __('lang_v1.website')]); !!}
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <div class="form-group">
        {!! Form::label('mobile', __('lang_v1.business_telephone') . ':') !!}
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-phone"></i>
            </span>
            {!! Form::text('mobile', null, ['class' => 'form-control','placeholder' => __('lang_v1.business_telephone')]); !!}
        </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('alternate_number', __('business.alternate_number') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-phone"></i>
                </span>
                {!! Form::text('alternate_number', null, ['class' => 'form-control','placeholder' => __('business.alternate_number')]); !!}
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="col-md-6">
        <div class="form-group">
        {!! Form::label('country', __('business.country') . ':*') !!}
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-globe"></i>
            </span>
            {!! Form::text('country', null, ['class' => 'form-control','placeholder' => __('business.country'), 'required']); !!}
        </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
        {!! Form::label('state',__('business.state') . ':*') !!}
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-map-marker"></i>
            </span>
            {!! Form::text('state', null, ['class' => 'form-control','placeholder' => __('business.state'), 'required']); !!}
        </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <div class="form-group">
        {!! Form::label('city',__('business.city'). ':*') !!}
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-map-marker"></i>
            </span>
            {!! Form::text('city', null, ['class' => 'form-control','placeholder' => __('business.city'), 'required']); !!}
        </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
        {!! Form::label('zip_code', __('business.zip_code') . ':*') !!}
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-map-marker"></i>
            </span>
            {!! Form::text('zip_code', null, ['class' => 'form-control','placeholder' => __('business.zip_code_placeholder'), 'required']); !!}
        </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <div class="form-group">
        {!! Form::label('landmark', __('business.landmark') . ':*') !!}
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-map-marker"></i>
            </span>
            {!! Form::text('landmark', null, ['class' => 'form-control','placeholder' => __('business.landmark'), 'required']); !!}
        </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="business_type" style="font-weight: 700; color: #1E293B;">
                Tipo de Negocio / Solución: <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <span class="input-group-addon" style="color: #FB4C0A;">
                    <i class="fas fa-store"></i>
                </span>
                <select name="business_type" id="business_type" class="form-control select2_register" required style="width: 100%;">
                    <option value="retail" selected>🛒 Comercio & Retail (Tiendas, Ropa, Variedades)</option>
                    <option value="restaurantes">🍽️ Restaurantes & Gastronomía (Mesas, Comandas, KDS)</option>
                    <option value="mayoristas">📦 Mayoristas & Distribuidoras (Multialmacén, Crédito)</option>
                    <option value="fabricas">🏭 Fábricas & Manufactura (Producción, Fórmulas)</option>
                    <option value="belleza-spa">✂️ Salones de Belleza & Barberías (Citas, Comisiones)</option>
                </select>
            </div>
            <small class="text-muted" style="font-size: 11px;">Configuraremos las funciones y módulos ideales para tu sector.</small>
        </div>
        <input type="hidden" name="time_zone" value="America/Caracas">
    </div>
    </fieldset>

    <div class="auth-wizard-actions" style="justify-content: flex-end;">
        <button type="button" class="auth-btn-primary btn-wizard-next" data-next="2" style="width: auto; padding: 12px 32px;">
            <span>Continuar a Ajustes</span>
            <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</div>

<!-- PASO 2: Configuración & Impuestos -->
<div class="auth-step-pane" id="auth-step-2">
    <fieldset>
    <legend class="text-black"><i class="fas fa-sliders-h" style="margin-right: 6px;"></i> @lang('business.business_settings'):</legend>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('tax_label_1', __('business.tax_1_name') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-info"></i>
                </span>
                {!! Form::text('tax_label_1', null, ['class' => 'form-control','placeholder' => __('business.tax_1_placeholder')]); !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('tax_number_1', __('business.tax_1_no') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-info"></i>
                </span>
                {!! Form::text('tax_number_1', null, ['class' => 'form-control']); !!}
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('tax_label_2',__('business.tax_2_name') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-info"></i>
                </span>
                {!! Form::text('tax_label_2', null, ['class' => 'form-control','placeholder' => __('business.tax_1_placeholder')]); !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('tax_number_2',__('business.tax_2_no') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-info"></i>
                </span>
                {!! Form::text('tax_number_2', null, ['class' => 'form-control',]); !!}
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('fy_start_month', __('business.fy_start_month') . ':*') !!} @show_tooltip(__('tooltip.fy_start_month'))
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
                {!! Form::select('fy_start_month', $months, null, ['class' => 'form-control select2_register', 'required', 'style' => 'width:100%;']); !!}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('accounting_method', __('business.accounting_method') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-calculator"></i>
                </span>
                {!! Form::select('accounting_method', $accounting_methods, null, ['class' => 'form-control select2_register', 'required', 'style' => 'width:100%;']); !!}
            </div>
        </div>
    </div>
    </fieldset>

    <div class="auth-wizard-actions">
        <button type="button" class="auth-btn-secondary btn-wizard-prev" data-prev="1">
            <i class="fas fa-arrow-left"></i>
            <span>Atrás</span>
        </button>
        <button type="button" class="auth-btn-primary btn-wizard-next" data-next="3" style="width: auto; padding: 12px 32px;">
            <span>Continuar a Usuario</span>
            <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</div>

<!-- PASO 3: Cuenta del Administrador / Propietario -->
<div class="auth-step-pane" id="auth-step-3">
    <fieldset>
    <legend class="text-black"><i class="fas fa-user-shield" style="margin-right: 6px;"></i> @lang('business.owner_info'):</legend>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('surname', __('business.prefix') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-info"></i>
                </span>
                {!! Form::text('surname', null, ['class' => 'form-control','placeholder' => __('business.prefix_placeholder')]); !!}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('first_name', __('business.first_name') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-info"></i>
                </span>
                {!! Form::text('first_name', null, ['class' => 'form-control','placeholder' => __('business.first_name'), 'required']); !!}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('last_name', __('business.last_name') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-info"></i>
                </span>
                {!! Form::text('last_name', null, ['class' => 'form-control','placeholder' =>  __('business.last_name')]); !!}
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('username', __('business.username') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                </span>
                {!! Form::text('username', null, ['class' => 'form-control','placeholder' => __('business.username'), 'required']); !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('email', __('business.email') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-envelope"></i>
                </span>
                {!! Form::text('email', null, ['class' => 'form-control','placeholder' => __('business.email'), 'required']); !!}
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('password', __('business.password') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-lock"></i>
                </span>
                {!! Form::password('password', ['class' => 'form-control','placeholder' => __('business.password'), 'required', 'id' => 'password']); !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('confirm_password', __('business.confirm_password') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-lock"></i>
                </span>
                {!! Form::password('confirm_password', ['class' => 'form-control','placeholder' => __('business.confirm_password'), 'required', 'id' => 'confirm_password']); !!}
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12" style="margin-top: 10px;">
        @if(!empty($system_settings['superadmin_enable_register_tc']))
            <div>
                <label style="cursor: pointer; display: inline-flex; align-items: center;">
                    {!! Form::checkbox('accept_tc', 0, false, ['required', 'class' => 'input-check-box']); !!}
                    <a class="terms_condition cursor-pointer" data-toggle="modal" data-target="#tc_modal" style="margin-left: 8px;">
                        @lang('lang_v1.accept_terms_and_conditions')
                    </a>
                </label>
            </div>
            @include('business.partials.terms_conditions')
        @endif
    </div>
    <div class="clearfix"></div>
    </fieldset>

    <div class="auth-wizard-actions">
        <button type="button" class="auth-btn-secondary btn-wizard-prev" data-prev="2">
            <i class="fas fa-arrow-left"></i>
            <span>Atrás</span>
        </button>
        <button type="submit" class="auth-btn-primary" id="btn-submit-register" style="width: auto; padding: 12px 36px;">
            <span>Crear Cuenta de Negocio</span>
            <i class="fas fa-rocket"></i>
        </button>
    </div>
</div>