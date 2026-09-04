<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">

  @php

    if(isset($update_action)) {
        $url = $update_action;
        $customer_groups = [];
        $opening_balance = 0;
        $lead_users = $contact->leadUsers->pluck('id');
    } else {
      $url = action([\App\Http\Controllers\ContactController::class, 'update'], [$contact->id]);
      $sources = [];
      $life_stages = [];
      $lead_users = [];
      $assigned_to_users = $contact->userHavingAccess->pluck('id');
    }
  @endphp

    {!! Form::open(['url' => $url, 'method' => 'PUT', 'id' => 'contact_edit_form']) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang('contact.edit_contact')</h4>
    </div>

    <div class="modal-body">

      <div class="row">

        <div class="col-md-4">
          <div class="form-group">
              {!! Form::label('type', __('contact.contact_type') . ':*' ) !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </span>
                  {!! Form::select('type', $types, $contact->type, ['class' => 'form-control', 'id' => 'contact_type','placeholder' => __('messages.please_select'), 'required']); !!}
              </div>
          </div>
        </div>
        <div class="col-md-4 mt-15">
            <label class="radio-inline">
                <input type="radio" name="contact_type_radio" @if($contact->contact_type == 'individual') checked @endif id="inlineRadio1" value="individual">
                @lang('lang_v1.individual')
            </label>
            <label class="radio-inline">
                <input type="radio" name="contact_type_radio" @if($contact->contact_type == 'business') checked @endif id="inlineRadio2" value="business">
                @lang('business.business')
            </label>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              {!! Form::label('contact_id', __('lang_v1.contact_id') . ':') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-id-badge"></i>
                  </span>
                  <input type="hidden" id="hidden_id" value="{{$contact->id}}">
                  {!! Form::text('contact_id', $contact->contact_id, ['class' => 'form-control','placeholder' => __('lang_v1.contact_id')]); !!}
              </div>
              <p class="help-block">
                @lang('lang_v1.leave_empty_to_autogenerate')
            </p>
          </div>
        </div>
        <div class="col-md-4 customer_fields">
          <div class="form-group">
              {!! Form::label('customer_group_id', __('lang_v1.customer_group') . ':') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-users"></i>
                  </span>
                  {!! Form::select('customer_group_id', $customer_groups, $contact->customer_group_id, ['class' => 'form-control']); !!}
              </div>
          </div>
        </div>
        <div class="clearfix customer_fields"></div>
        <div class="col-md-4 business" @if($contact->contact_type == 'individual' || empty($contact->contact_type)) style="display: none;"  @endif>
          <div class="form-group">
              {!! Form::label('supplier_business_name', __('business.business_name') . ':') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-briefcase"></i>
                  </span>
                  {!! Form::text('supplier_business_name', 
                  $contact->supplier_business_name, ['class' => 'form-control', 'placeholder' => __('business.business_name')]); !!}
              </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4 individual" @if($contact->contact_type == 'business' || empty($contact->contact_type)) style="display: none;"  @endif>
            <div class="form-group">
                {!! Form::label('first_name', __( 'business.first_name' ) . ':*') !!}
                {!! Form::text('first_name', $contact->first_name, ['class' => 'form-control', 'required', 'placeholder' => __( 'business.first_name' ) ]); !!}
            </div>
        </div>
        <div class="col-md-4 individual" @if($contact->contact_type == 'business' || empty($contact->contact_type)) style="display: none;"  @endif>
            <div class="form-group">
                {!! Form::label('middle_name', __( 'lang_v1.middle_name' ) . ':') !!}
                {!! Form::text('middle_name', $contact->middle_name, ['class' => 'form-control', 'placeholder' => __( 'lang_v1.middle_name' ) ]); !!}
            </div>
        </div>
        <div class="col-md-4 individual" @if($contact->contact_type == 'business' || empty($contact->contact_type)) style="display: none;"  @endif>
            <div class="form-group">
                {!! Form::label('last_name', __( 'business.last_name' ) . ':') !!}
                {!! Form::text('last_name', $contact->last_name, ['class' => 'form-control', 'placeholder' => __( 'business.last_name' ) ]); !!}
            </div>
        </div>
        <div class="clearfix"></div>

      <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('mobile', __('contact.mobile') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-mobile"></i>
                </span>
                {!! Form::text('mobile', $contact->mobile, ['class' => 'form-control', 'required', 'placeholder' => __('contact.mobile')]); !!}
            </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('alternate_number', 'Número alternativo:') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-phone"></i>
                </span>
                {!! Form::text('alternate_number', $contact->alternate_number, ['class' => 'form-control', 'placeholder' => 'Número alternativo']); !!}
            </div>
        </div>
      </div>
      <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('email', __('business.email') . ':') !!}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                    </span>
                    {!! Form::email('email', $contact->email, ['class' => 'form-control','placeholder' => __('business.email')]); !!}
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-sm-4">
            <div class="form-group individual" @if($contact->contact_type == 'business') style="display: none;"  @endif>
                {!! Form::label('dob', __('lang_v1.dob') . ':') !!}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    
                    {!! Form::text('dob', !empty($contact->dob) ? @format_date($contact->dob) : null, ['class' => 'form-control dob-date-picker','placeholder' => __('lang_v1.dob'), 'readonly']); !!}
                </div>
            </div>
        </div>
        
        <!-- lead additional field -->
        <div class="col-md-4 lead_additional_div">
          <div class="form-group">
              {!! Form::label('crm_source', __('lang_v1.source') . ':' ) !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fas fa fa-search"></i>
                  </span>
                  {!! Form::select('crm_source', $sources, $contact->crm_source , ['class' => 'form-control', 'id' => 'crm_source','placeholder' => __('messages.please_select')]); !!}
              </div>
          </div>
        </div>
        <div class="col-md-4 lead_additional_div">
          <div class="form-group">
              {!! Form::label('crm_life_stage', __('lang_v1.life_stage') . ':' ) !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fas fa fa-life-ring"></i>
                  </span>
                  {!! Form::select('crm_life_stage', $life_stages, $contact->crm_life_stage , ['class' => 'form-control', 'id' => 'crm_life_stage','placeholder' => __('messages.please_select')]); !!}
              </div>
          </div>
        </div>
        <div class="col-md-6 lead_additional_div">
          <div class="form-group">
              {!! Form::label('user_id', __('lang_v1.assigned_to') . ':*' ) !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </span>
                  {!! Form::select('user_id[]', $users, $lead_users , ['class' => 'form-control select2', 'id' => 'user_id', 'multiple', 'required', 'style' => 'width: 100%;']); !!}
              </div>
          </div>
        </div>

        @if(config('constants.enable_contact_assign') && $contact->type !== 'lead')
          <!-- User in create customer & supplier -->
          <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('assigned_to_users', __('lang_v1.assigned_to') . ':' ) !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        {!! Form::select('assigned_to_users[]', $users, $assigned_to_users ?? [] , ['class' => 'form-control select2', 'id' => 'assigned_to_users', 'multiple', 'style' => 'width: 100%;']); !!}
                    </div>
                </div>
          </div>
        @endif

        <div class="col-md-12">
            <button type="button" class="tw-dw-btn tw-dw-btn-primary tw-text-white center-block more_btn" data-target="#more_div">@lang('lang_v1.more_info') <i class="fa fa-chevron-down"></i></button>
        </div>
        
        <div id="more_div" class="hide">

            <div class="col-md-12"><hr/></div>
        
        <div class="col-md-4">
          <div class="form-group">
              {!! Form::label('tax_number', 'Número de (RIF):') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-info"></i>
                  </span>
                  {!! Form::text('tax_number', $contact->tax_number, ['class' => 'form-control', 'placeholder' => 'Número de (RIF)']); !!}
              </div>
          </div>
        </div>

        <input type="hidden" name="opening_balance" value="{{ $opening_balance ?? 0 }}">

        <div class="col-md-4 pay_term">
          <div class="form-group">
              {!! Form::label('contact_pay_term_preset', 'Término de Crédito / Pago:') !!}
              @php
                  $current_pay_term = !empty($contact->pay_term_number) ? (int)$contact->pay_term_number : 0;
              @endphp
              <select name="contact_pay_term_preset" id="contact_pay_term_preset" class="form-control select2" style="width: 100%;">
                  <option value="0" @if($current_pay_term == 0) selected @endif>Contado</option>
                  <option value="3" @if($current_pay_term == 3) selected @endif>Crédito 3 días</option>
                  <option value="7" @if($current_pay_term == 7) selected @endif>Crédito 7 días</option>
                  <option value="10" @if($current_pay_term == 10) selected @endif>Crédito 10 días</option>
                  <option value="20" @if($current_pay_term == 20) selected @endif>Crédito 20 días</option>
              </select>
              <input type="hidden" name="pay_term_number" id="contact_pay_term_number" value="{{ $contact->pay_term_number }}">
              <input type="hidden" name="pay_term_type" id="contact_pay_term_type" value="{{ $contact->pay_term_type ?? 'days' }}">
          </div>
        </div>
        
        <div class="col-md-4 customer_fields">
          <div class="form-group">
              {!! Form::label('credit_limit', __('lang_v1.credit_limit') . ':') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fas fa-money-bill-alt"></i>
                  </span>
                  {!! Form::text('credit_limit', $contact->credit_limit != null ? @num_format($contact->credit_limit) : null, ['class' => 'form-control input_number']); !!}
              </div>
              <p class="help-block">@lang('lang_v1.credit_limit_help')</p>
          </div>
        </div>
        <div class="clearfix"></div>
          
      <div class="col-md-12">
        <hr/>
      </div>
      <div class="clearfix"></div>
      
      <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('address_line_1', __('lang_v1.address_line_1') . ':') !!}
            {!! Form::text('address_line_1', $contact->address_line_1, ['class' => 'form-control', 'placeholder' => __('lang_v1.address_line_1')]); !!}
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('city', __('business.city') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                </span>
                {!! Form::text('city', $contact->city, ['class' => 'form-control', 'placeholder' => __('business.city')]); !!}
            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('state', __('business.state') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                </span>
                {!! Form::text('state', $contact->state, ['class' => 'form-control', 'placeholder' => __('business.state')]); !!}
            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('country', __('business.country') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-globe"></i>
                </span>
                {!! Form::text('country', $contact->country, ['class' => 'form-control', 'placeholder' => __('business.country')]); !!}
            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('zip_code', __('business.zip_code') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                </span>
                {!! Form::text('zip_code', $contact->zip_code, ['class' => 'form-control', 
                'placeholder' => __('business.zip_code_placeholder')]); !!}
            </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('land_mark', __('business.land_mark') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                </span>
                {!! Form::text('land_mark', $contact->land_mark, ['class' => 'form-control', 'placeholder' => __('business.land_mark')]); !!}
            </div>
        </div>
      </div>
      @php
        $contact_custom_labels = !empty($custom_labels) ? $custom_labels : json_decode(session('business.custom_labels'), true);
        $contact_custom_field1 = !empty($contact_custom_labels['contact']['custom_field_1']) ? $contact_custom_labels['contact']['custom_field_1'] : __('lang_v1.contact_custom_field1');
      @endphp
      <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('custom_field1', $contact_custom_field1 . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-info-circle"></i>
                </span>
                {!! Form::text('custom_field1', $contact->custom_field1, ['class' => 'form-control', 'placeholder' => $contact_custom_field1]); !!}
            </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12 shipping_addr_div"><hr></div>
      <div class="col-md-12 shipping_addr_div mb-10" >
          <div class="tw-flex tw-items-center tw-justify-between tw-flex-wrap tw-gap-2 tw-mb-2">
              <strong class="tw-text-sm tw-font-bold tw-text-gray-800"><i class="fas fa-truck tw-text-orange-500"></i> {{__('lang_v1.shipping_address')}}</strong>
              
              <div class="tw-flex tw-items-center tw-gap-2">
                  <!-- Botón Copiar Dirección Fiscal -->
                  <button type="button" class="btn btn-xs btn-default" id="copy_fiscal_address_btn" style="border-radius: 6px; font-weight: 600;">
                      <i class="fas fa-copy text-primary"></i> Usar dirección fiscal
                  </button>
                  
                  <!-- Botón GPS / Geolocalización en sitio -->
                  <button type="button" class="btn btn-xs btn-success" id="get_gps_location_btn" style="border-radius: 6px; font-weight: 600; color: #fff;">
                      <i class="fas fa-location-arrow"></i> 📍 Obtener Mi Ubicación GPS
                  </button>
              </div>
          </div>

          {!! Form::textarea('shipping_address', $contact->shipping_address, ['class' => 'form-control', 
                'placeholder' => __('lang_v1.search_address') . ' o enlace de GPS / Google Maps', 'id' => 'shipping_address', 'rows' => 2]); !!}
          <small class="tw-text-emerald-600 font-weight-bold" id="gps_status_msg"></small>
        <div class="mb-10" id="map"></div>
      </div>
      {!! Form::hidden('position', $contact->position, ['id' => 'position']); !!}
        @php
            $shipping_custom_label_1 = !empty($custom_labels['shipping']['custom_field_1']) ? $custom_labels['shipping']['custom_field_1'] : '';

            $shipping_custom_label_2 = !empty($custom_labels['shipping']['custom_field_2']) ? $custom_labels['shipping']['custom_field_2'] : '';

            $shipping_custom_label_3 = !empty($custom_labels['shipping']['custom_field_3']) ? $custom_labels['shipping']['custom_field_3'] : '';

            $shipping_custom_label_4 = !empty($custom_labels['shipping']['custom_field_4']) ? $custom_labels['shipping']['custom_field_4'] : '';

            $shipping_custom_label_5 = !empty($custom_labels['shipping']['custom_field_5']) ? $custom_labels['shipping']['custom_field_5'] : '';
        @endphp

        @if(!empty($custom_labels['shipping']['is_custom_field_1_contact_default']) && !empty($shipping_custom_label_1))
            @php
                $label_1 = $shipping_custom_label_1 . ':';
            @endphp

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('shipping_custom_field_1', $label_1 ) !!}
                    {!! Form::text('shipping_custom_field_details[shipping_custom_field_1]', !empty($contact->shipping_custom_field_details['shipping_custom_field_1']) ? $contact->shipping_custom_field_details['shipping_custom_field_1'] : null, ['class' => 'form-control','placeholder' => $shipping_custom_label_1]); !!}
                </div>
            </div>
        @endif
        @if(!empty($custom_labels['shipping']['is_custom_field_2_contact_default']) && !empty($shipping_custom_label_2))
            @php
                $label_2 = $shipping_custom_label_2 . ':';
            @endphp

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('shipping_custom_field_2', $label_2 ) !!}
                    {!! Form::text('shipping_custom_field_details[shipping_custom_field_2]', !empty($contact->shipping_custom_field_details['shipping_custom_field_2']) ? $contact->shipping_custom_field_details['shipping_custom_field_2'] : null, ['class' => 'form-control','placeholder' => $shipping_custom_label_2]); !!}
                </div>
            </div>
        @endif
        @if(!empty($custom_labels['shipping']['is_custom_field_3_contact_default']) && !empty($shipping_custom_label_3))
            @php
                $label_3 = $shipping_custom_label_3 . ':';
            @endphp

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('shipping_custom_field_3', $label_3 ) !!}
                    {!! Form::text('shipping_custom_field_details[shipping_custom_field_3]', !empty($contact->shipping_custom_field_details['shipping_custom_field_3']) ? $contact->shipping_custom_field_details['shipping_custom_field_3'] : null, ['class' => 'form-control','placeholder' => $shipping_custom_label_3]); !!}
                </div>
            </div>
        @endif
        @if(!empty($custom_labels['shipping']['is_custom_field_4_contact_default']) && !empty($shipping_custom_label_4))
            @php
                $label_4 = $shipping_custom_label_4 . ':';
            @endphp

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('shipping_custom_field_4', $label_4 ) !!}
                    {!! Form::text('shipping_custom_field_details[shipping_custom_field_4]', !empty($contact->shipping_custom_field_details['shipping_custom_field_4']) ? $contact->shipping_custom_field_details['shipping_custom_field_4'] : null, ['class' => 'form-control','placeholder' => $shipping_custom_label_4]); !!}
                </div>
            </div>
        @endif
        @if(!empty($custom_labels['shipping']['is_custom_field_5_contact_default']) && !empty($shipping_custom_label_5))
            @php
                $label_5 = $shipping_custom_label_5 . ':';
            @endphp

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('shipping_custom_field_5', $label_5 ) !!}
                    {!! Form::text('shipping_custom_field_details[shipping_custom_field_5]', !empty($contact->shipping_custom_field_details['shipping_custom_field_5']) ? $contact->shipping_custom_field_details['shipping_custom_field_5'] : null, ['class' => 'form-control','placeholder' => $shipping_custom_label_5]); !!}
                </div>
            </div>
        @endif
        @php
          $common_settings = session()->get('business.common_settings');
        @endphp
        @if(!empty($common_settings['is_enabled_export']))
            <div class="col-md-12 mb-12">
                <div class="form-check">
                    <input type="checkbox" name="is_export" class="form-check-input" id="is_customer_export" @if(!empty($contact->is_export)) checked @endif>
                    <label class="form-check-label" for="is_customer_export">@lang('lang_v1.is_export')</label>
                </div>
            </div>
            @php
                $i = 1;
            @endphp
            @for($i; $i <= 6 ; $i++)
                <div class="col-md-4 export_div" style="display: none;">
                    <div class="form-group">
                        {!! Form::label('export_custom_field_'.$i, __('lang_v1.export_custom_field'.$i).':' ) !!}
                        {!! Form::text('export_custom_field_'.$i, !empty($contact['export_custom_field_'.$i]) ? $contact['export_custom_field_'.$i] : null, ['class' => 'form-control','placeholder' => __('lang_v1.export_custom_field'.$i)]); !!}
                    </div>
                </div>
            @endfor
        @endif
    </div>
</div>
    </div>

    <div class="modal-footer">
      <button type="submit" class="tw-dw-btn tw-dw-btn-primary tw-text-white">@lang( 'messages.update' )</button>
      <button type="button" class="tw-dw-btn tw-dw-btn-neutral tw-text-white" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

    <script>
    $(document).ready(function() {
        // Inicializar select2 en modal
        $('#contact_edit_form #contact_pay_term_preset').select2();

        // Sincronizar preset de términos de pago
        $(document).on('change', '#contact_pay_term_preset', function() {
            var val = $(this).val();
            var form = $(this).closest('form');
            if (val === '0' || val === 0) {
                form.find('#contact_pay_term_number').val('');
                form.find('#contact_pay_term_type').val('days');
            } else {
                form.find('#contact_pay_term_number').val(val);
                form.find('#contact_pay_term_type').val('days');
            }
        });

        // 1. Botón Copiar Dirección Fiscal
        $(document).off('click', '#copy_fiscal_address_btn').on('click', '#copy_fiscal_address_btn', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var parts = [];
            
            var addr1 = form.find('input[name="address_line_1"]').val();
            var landmark = form.find('input[name="land_mark"]').val();
            var city = form.find('input[name="city"]').val();
            var state = form.find('input[name="state"]').val();
            var country = form.find('input[name="country"]').val();
            var zip = form.find('input[name="zip_code"]').val();

            if (addr1) parts.push(addr1);
            if (landmark) parts.push('Ref: ' + landmark);
            if (city) parts.push(city);
            if (state) parts.push(state);
            if (country) parts.push(country);
            if (zip) parts.push('CP: ' + zip);

            var fullFiscal = parts.join(', ');
            if (fullFiscal.trim() !== '') {
                form.find('#shipping_address').val(fullFiscal);
                toastr.success('Dirección fiscal copiada a dirección de envío');
            } else {
                toastr.warning('Primero complete los campos de dirección fiscal arriba');
            }
        });

        // 2. Botón Obtener Coordenadas GPS con Soporte Móvil Robusto
        $(document).off('click touchend', '#get_gps_location_btn').on('click touchend', '#get_gps_location_btn', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var form = $btn.closest('form');
            var $status = form.find('#gps_status_msg');

            if (!navigator.geolocation) {
                toastr.error('La geolocalización no está soportada por su navegador');
                $status.html('⚠️ Geolocalización no soportada');
                return;
            }

            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Obteniendo GPS...');
            $status.html('📡 Conectando satélites GPS...');

            function onPositionSuccess(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                var coords = lat.toFixed(6) + ',' + lng.toFixed(6);
                var mapsUrl = 'https://maps.google.com/?q=' + coords;

                form.find('#position').val(coords);

                var currentShipping = form.find('#shipping_address').val() || '';
                if (currentShipping.trim() !== '') {
                    if (currentShipping.indexOf('maps.google.com') === -1) {
                        form.find('#shipping_address').val(currentShipping + ' | GPS: ' + mapsUrl);
                    }
                } else {
                    form.find('#shipping_address').val('Ubicación GPS: ' + mapsUrl);
                }

                $status.html('✅ Coordenadas: ' + coords);
                $btn.prop('disabled', false).html('<i class="fas fa-check"></i> GPS Actualizado');
                toastr.success('Ubicación GPS capturada con éxito: ' + coords);
            }

            function handleFinalError(error) {
                $btn.prop('disabled', false).html('<i class="fas fa-location-arrow"></i> 📍 Reintentar GPS');
                var msg = 'No se pudo obtener la ubicación GPS.';
                if (error && error.code === error.PERMISSION_DENIED) {
                    msg = 'Permiso de ubicación denegado en el navegador. Por favor active los permisos de GPS en su teléfono/navegador.';
                } else if (error && error.code === error.TIMEOUT) {
                    msg = 'Tiempo de espera agotado al conectar satélites GPS.';
                } else if (!window.isSecureContext && location.protocol !== 'https:' && location.hostname !== 'localhost') {
                    msg = 'Navegadores móviles requieren conexión HTTPS para habilitar el GPS.';
                }
                $status.html('⚠️ ' + msg);
                toastr.error(msg);
            }

            navigator.geolocation.getCurrentPosition(
                onPositionSuccess,
                function(error) {
                    // Intento de respaldo con precisión estándar (red/celular) en móviles
                    $status.html('📡 Reintentando mediante red móvil...');
                    navigator.geolocation.getCurrentPosition(
                        onPositionSuccess,
                        function(err) {
                            handleFinalError(err);
                        },
                        { enableHighAccuracy: false, timeout: 15000, maximumAge: 60000 }
                    );
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        });
    });
    </script>
  
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->