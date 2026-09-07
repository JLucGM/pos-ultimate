<div class="pos-tab-content">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('tax_label_1', __('business.tax_1_name') . ':') !!}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-info"></i>
                    </span>
                    {!! Form::text('tax_label_1', $business->tax_label_1, ['class' => 'form-control','placeholder' => __('business.tax_1_placeholder')]); !!}
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('tax_number_1', __('business.tax_1_no') . ':') !!}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-info"></i>
                    </span>
                    {!! Form::text('tax_number_1', $business->tax_number_1, ['class' => 'form-control']); !!}
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('tax_label_2', __('business.tax_2_name') . ':') !!}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-info"></i>
                    </span>
                    {!! Form::text('tax_label_2', $business->tax_label_2, ['class' => 'form-control','placeholder' => __('business.tax_1_placeholder')]); !!}
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('tax_number_2', __('business.tax_2_no') . ':') !!}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-info"></i>
                    </span>
                    {!! Form::text('tax_number_2', $business->tax_number_2, ['class' => 'form-control']); !!}
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="form-group">
                <div class="checkbox">
                <br>
                  <label>
                    {!! Form::checkbox('enable_inline_tax', 1, $business->enable_inline_tax , 
                    [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.enable_inline_tax' ) }}
                  </label>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <hr>
            <div style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-left: 4px solid #0284C7; border-radius: 10px; padding: 16px 20px; margin-top: 10px; margin-bottom: 15px;">
                <h4 style="margin-top: 0; color: #0F172A; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-university tw-text-sky-600"></i> Calificación SENIAT (Venezuela)
                </h4>
                <div class="row">
                    <div class="col-sm-7">
                        <div class="checkbox" style="margin-top: 8px;">
                            <label style="font-weight: 700; color: #1E293B;">
                                {!! Form::checkbox('is_tax_withholding_agent', 1, !empty($business->is_tax_withholding_agent), ['class' => 'input-icheck']) !!}
                                Esta empresa es Contribuyente Especial / Agente de Retención de IVA
                            </label>
                            <p class="help-block" style="font-size: 11px; color: #64748B; margin-left: 20px; margin-bottom: 0;">
                                Active esta opción si su empresa fue notificada por el SENIAT como Sujeto Pasivo Especial y está obligada a retener IVA a proveedores.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group" style="margin-bottom: 0;">
                            {!! Form::label('withholding_agent_resolution', 'N° Providencia / Resolución SENIAT:') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
                                {!! Form::text('withholding_agent_resolution', $business->withholding_agent_resolution, ['class' => 'form-control', 'placeholder' => 'Ej: SNAT/2025/000054']); !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>