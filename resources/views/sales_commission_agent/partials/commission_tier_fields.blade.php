@php
    $cmmsn_type = !empty($user->cmmsn_type) ? $user->cmmsn_type : 'fixed';
    $cmmsn_rules = !empty($user->cmmsn_tiered_rules) && is_array($user->cmmsn_tiered_rules) ? $user->cmmsn_tiered_rules : [];
@endphp

<div class="col-md-12 commission_scheme_card">
    <div style="background: #F8FAFC; border: 1.5px solid #CBD5E1; border-left: 5px solid #F59E0B; border-radius: 10px; padding: 16px 20px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <label style="font-weight: 800; color: #0F172A; font-size: 14px; margin-bottom: 12px; display: block;">
            <i class="fas fa-percentage" style="color: #D97706; margin-right: 5px;"></i> Esquema de Comisión de Ventas
        </label>
        
        <div style="display: flex; gap: 15px; align-items: stretch; margin-bottom: 15px; flex-wrap: wrap;">
            <!-- Opción Fija -->
            <label class="cmmsn_type_option_box" style="flex: 1; min-width: 220px; background: {{ $cmmsn_type == 'fixed' ? '#EFF6FF' : '#FFFFFF' }}; border: 2px solid {{ $cmmsn_type == 'fixed' ? '#3B82F6' : '#E2E8F0' }}; border-radius: 8px; padding: 10px 14px; cursor: pointer; display: flex; align-items: center; gap: 10px; margin-bottom: 0; transition: all 0.2s;">
                <input type="radio" name="cmmsn_type" value="fixed" class="cmmsn_type_radio input-icheck" @if($cmmsn_type == 'fixed') checked @endif>
                <div>
                    <div style="font-weight: 700; color: #1E293B; font-size: 13px;">Comisión Fija (%)</div>
                    <small style="color: #64748B; font-size: 11px;">Mismo porcentaje para todas las ventas</small>
                </div>
            </label>

            <!-- Opción Escalonada -->
            <label class="cmmsn_type_option_box" style="flex: 1; min-width: 220px; background: {{ $cmmsn_type == 'tiered' ? '#EFF6FF' : '#FFFFFF' }}; border: 2px solid {{ $cmmsn_type == 'tiered' ? '#3B82F6' : '#E2E8F0' }}; border-radius: 8px; padding: 10px 14px; cursor: pointer; display: flex; align-items: center; gap: 10px; margin-bottom: 0; transition: all 0.2s;">
                <input type="radio" name="cmmsn_type" value="tiered" class="cmmsn_type_radio input-icheck" @if($cmmsn_type == 'tiered') checked @endif>
                <div>
                    <div style="font-weight: 700; color: #1E293B; font-size: 13px;">Comisión Escalonada por Días</div>
                    <small style="color: #64748B; font-size: 11px;">Varía según los días transcurridos hasta el cobro</small>
                </div>
            </label>
        </div>

        {{-- Contenedor Comisión Fija --}}
        <div class="cmmsn_fixed_container" style="@if($cmmsn_type != 'fixed') display: none; @endif">
            <div class="form-group" style="margin-bottom: 0; max-width: 260px;">
                {!! Form::label('cmmsn_percent', 'Porcentaje Fijo (%):') !!}
                <div class="input-group">
                    {!! Form::text('cmmsn_percent', !empty($user->cmmsn_percent) ? @num_format($user->cmmsn_percent) : 0, ['class' => 'form-control input_number', 'placeholder' => '0.00', 'id' => 'cmmsn_percent']) !!}
                    <span class="input-group-addon">%</span>
                </div>
            </div>
        </div>

        {{-- Contenedor Comisión Escalonada --}}
        <div class="cmmsn_tiered_container" style="@if($cmmsn_type != 'tiered') display: none; @endif">
            <div style="background: #FEF3C7; border: 1px solid #FDE68A; border-radius: 6px; padding: 10px 14px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                <i class="fa fa-info-circle" style="color: #D97706; font-size: 16px;"></i>
                <span style="font-size: 12px; color: #92400E; line-height: 1.4;">
                    Configura las escalas de comisión según los días transcurridos desde la fecha de factura hasta la fecha en que el cliente realiza el pago.
                </span>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-condensed table-striped" id="cmmsn_tier_table" style="background: white; border-radius: 6px; overflow: hidden; margin-bottom: 10px;">
                    <thead>
                        <tr style="background: #0F172A; color: #FFFFFF; font-size: 12px;">
                            <th style="width: 28%; text-align: center; vertical-align: middle;">Desde (Días)</th>
                            <th style="width: 28%; text-align: center; vertical-align: middle;">Hasta (Días)</th>
                            <th style="width: 28%; text-align: center; vertical-align: middle;">% Comisión</th>
                            <th style="width: 16%; text-align: center; vertical-align: middle;">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="cmmsn_tier_body">
                        @if(!empty($cmmsn_rules) && count($cmmsn_rules) > 0)
                            @foreach($cmmsn_rules as $idx => $rule)
                                <tr class="tier_row">
                                    <td>
                                        <input type="number" min="0" name="cmmsn_tiered_rules[{{ $idx }}][min_days]" class="form-control input-sm text-center" value="{{ $rule['min_days'] ?? 0 }}" placeholder="0" required>
                                    </td>
                                    <td>
                                        <input type="number" min="0" name="cmmsn_tiered_rules[{{ $idx }}][max_days]" class="form-control input-sm text-center" value="{{ $rule['max_days'] ?? '' }}" placeholder="Sin límite (+)">
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input type="number" step="0.01" min="0" max="100" name="cmmsn_tiered_rules[{{ $idx }}][percent]" class="form-control input-sm text-right" value="{{ $rule['percent'] ?? 0 }}" placeholder="0.00" required>
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <button type="button" class="btn btn-xs btn-danger remove_tier_row_btn" title="Eliminar Condición"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="tier_row">
                                <td>
                                    <input type="number" min="0" name="cmmsn_tiered_rules[0][min_days]" class="form-control input-sm text-center" value="0" placeholder="0" required>
                                </td>
                                <td>
                                    <input type="number" min="0" name="cmmsn_tiered_rules[0][max_days]" class="form-control input-sm text-center" value="10" placeholder="10">
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="number" step="0.01" min="0" max="100" name="cmmsn_tiered_rules[0][percent]" class="form-control input-sm text-right" value="4.00" placeholder="0.00" required>
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <button type="button" class="btn btn-xs btn-danger remove_tier_row_btn" title="Eliminar Condición"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr class="tier_row">
                                <td>
                                    <input type="number" min="0" name="cmmsn_tiered_rules[1][min_days]" class="form-control input-sm text-center" value="11" placeholder="11" required>
                                </td>
                                <td>
                                    <input type="number" min="0" name="cmmsn_tiered_rules[1][max_days]" class="form-control input-sm text-center" value="30" placeholder="30">
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="number" step="0.01" min="0" max="100" name="cmmsn_tiered_rules[1][percent]" class="form-control input-sm text-right" value="2.00" placeholder="0.00" required>
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <button type="button" class="btn btn-xs btn-danger remove_tier_row_btn" title="Eliminar Condición"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr class="tier_row">
                                <td>
                                    <input type="number" min="0" name="cmmsn_tiered_rules[2][min_days]" class="form-control input-sm text-center" value="31" placeholder="31" required>
                                </td>
                                <td>
                                    <input type="number" min="0" name="cmmsn_tiered_rules[2][max_days]" class="form-control input-sm text-center" value="" placeholder="Sin límite (+)">
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="number" step="0.01" min="0" max="100" name="cmmsn_tiered_rules[2][percent]" class="form-control input-sm text-right" value="1.00" placeholder="0.00" required>
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <button type="button" class="btn btn-xs btn-danger remove_tier_row_btn" title="Eliminar Condición"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <button type="button" class="btn btn-sm btn-primary add_tier_row_btn" style="border-radius: 6px; font-weight: 700; padding: 6px 14px;">
                <i class="fa fa-plus"></i> Agregar condición de comisión
            </button>
        </div>
    </div>
</div>

<script>
(function() {
    function initCommissionSchemeEvents() {
        function updateCommissionUI($card, val) {
            $card.find('.cmmsn_type_option_box').each(function() {
                var isChecked = $(this).find('input.cmmsn_type_radio').is(':checked') || $(this).find('input.cmmsn_type_radio').val() === val;
                if (isChecked) {
                    $(this).css({ 'background': '#EFF6FF', 'border-color': '#3B82F6' });
                } else {
                    $(this).css({ 'background': '#FFFFFF', 'border-color': '#E2E8F0' });
                }
            });

            if (val === 'tiered') {
                $card.find('.cmmsn_fixed_container').slideUp(150);
                $card.find('.cmmsn_tiered_container').slideDown(150);
                $card.find('#cmmsn_percent').prop('required', false);
            } else {
                $card.find('.cmmsn_tiered_container').slideUp(150);
                $card.find('.cmmsn_fixed_container').slideDown(150);
                $card.find('#cmmsn_percent').prop('required', true);
            }
        }

        // Eventos de cambio (nativos y iCheck)
        $(document).off('change ifChecked', 'input.cmmsn_type_radio').on('change ifChecked', 'input.cmmsn_type_radio', function() {
            var $card = $(this).closest('.commission_scheme_card');
            var val = $(this).val();
            updateCommissionUI($card, val);
        });

        // Click en la caja/label completo
        $(document).off('click', '.cmmsn_type_option_box').on('click', '.cmmsn_type_option_box', function(e) {
            var $radio = $(this).find('input.cmmsn_type_radio');
            if (!$radio.is(':checked')) {
                if ($radio.data('iCheck')) {
                    $radio.iCheck('check');
                } else {
                    $radio.prop('checked', true).trigger('change');
                }
            }
        });

        // Agregar fila
        $(document).off('click', '.add_tier_row_btn').on('click', '.add_tier_row_btn', function() {
            var tbody = $(this).closest('.cmmsn_tiered_container').find('#cmmsn_tier_body');
            var rowCount = tbody.find('tr.tier_row').length;
            
            var lastMax = tbody.find('tr.tier_row:last input[name*="[max_days]"]').val();
            var suggestedMin = (lastMax !== undefined && lastMax !== '') ? (parseInt(lastMax) + 1) : 0;

            var newRow = '<tr class="tier_row">' +
                '<td><input type="number" min="0" name="cmmsn_tiered_rules[' + rowCount + '][min_days]" class="form-control input-sm text-center" value="' + suggestedMin + '" placeholder="0" required></td>' +
                '<td><input type="number" min="0" name="cmmsn_tiered_rules[' + rowCount + '][max_days]" class="form-control input-sm text-center" value="" placeholder="Sin límite (+)"></td>' +
                '<td><div class="input-group input-group-sm"><input type="number" step="0.01" min="0" max="100" name="cmmsn_tiered_rules[' + rowCount + '][percent]" class="form-control input-sm text-right" value="1.00" placeholder="0.00" required><span class="input-group-addon">%</span></div></td>' +
                '<td class="text-center" style="vertical-align: middle;"><button type="button" class="btn btn-xs btn-danger remove_tier_row_btn" title="Eliminar Condición"><i class="fa fa-trash"></i></button></td>' +
                '</tr>';
            
            tbody.append(newRow);
        });

        // Eliminar fila
        $(document).off('click', '.remove_tier_row_btn').on('click', '.remove_tier_row_btn', function() {
            var tbody = $(this).closest('tbody');
            if (tbody.find('tr.tier_row').length > 1) {
                $(this).closest('tr').remove();
            } else {
                if (typeof toastr !== 'undefined') {
                    toastr.warning('Debe haber al menos una condición de comisión configurada');
                } else {
                    alert('Debe haber al menos una condición de comisión configurada');
                }
            }
        });

        // Inicializar iCheck si existe
        if ($.fn.iCheck) {
            $('input.cmmsn_type_radio').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue'
            });
        }

        // Ejecutar estado inicial
        $('.commission_scheme_card').each(function() {
            var initialVal = $(this).find('input.cmmsn_type_radio:checked').val() || 'fixed';
            updateCommissionUI($(this), initialVal);
        });
    }

    $(document).ready(function() {
        initCommissionSchemeEvents();
    });

    // En caso de que se cargue dentro de un modal AJAX
    $(document).ajaxComplete(function(event, xhr, settings) {
        if ($('.commission_scheme_card').length > 0) {
            initCommissionSchemeEvents();
        }
    });
})();
</script>
