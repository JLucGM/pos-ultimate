@php
    $cmmsn_type = !empty($user->cmmsn_type) ? $user->cmmsn_type : 'fixed';
    $cmmsn_rules = !empty($user->cmmsn_tiered_rules) && is_array($user->cmmsn_tiered_rules) ? $user->cmmsn_tiered_rules : [];
@endphp

<div class="col-md-12">
    <div style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-left: 4px solid #F59E0B; border-radius: 10px; padding: 14px 18px; margin-bottom: 15px;">
        <label style="font-weight: 800; color: #1E293B; font-size: 13px; margin-bottom: 10px; display: block;">
            <i class="fas fa-percentage tw-text-amber-500"></i> Esquema de Comisión de Ventas
        </label>
        
        <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 12px; flex-wrap: wrap;">
            <label style="font-weight: 600; cursor: pointer; color: #334155; display: inline-flex; align-items: center; gap: 6px;">
                <input type="radio" name="cmmsn_type" value="fixed" class="cmmsn_type_radio" @if($cmmsn_type == 'fixed') checked @endif>
                <span>Comisión Fija (%)</span>
            </label>
            <label style="font-weight: 600; cursor: pointer; color: #334155; display: inline-flex; align-items: center; gap: 6px;">
                <input type="radio" name="cmmsn_type" value="tiered" class="cmmsn_type_radio" @if($cmmsn_type == 'tiered') checked @endif>
                <span>Comisión Escalonada por Días de Cobro</span>
            </label>
        </div>

        {{-- Contenedor Comisión Fija --}}
        <div class="cmmsn_fixed_container" style="@if($cmmsn_type != 'fixed') display: none; @endif">
            <div class="form-group" style="margin-bottom: 0; max-width: 250px;">
                {!! Form::label('cmmsn_percent', 'Porcentaje Fijo (%):') !!}
                <div class="input-group">
                    {!! Form::text('cmmsn_percent', !empty($user->cmmsn_percent) ? @num_format($user->cmmsn_percent) : 0, ['class' => 'form-control input_number', 'placeholder' => '0.00', 'id' => 'cmmsn_percent']) !!}
                    <span class="input-group-addon">%</span>
                </div>
            </div>
        </div>

        {{-- Contenedor Comisión Escalonada --}}
        <div class="cmmsn_tiered_container" style="@if($cmmsn_type != 'tiered') display: none; @endif">
            <p class="help-block" style="font-size: 11px; color: #64748B; margin-bottom: 8px;">
                El sistema aplicará el porcentaje correspondiente según la cantidad de días transcurridos entre la emisión de la factura y la fecha de pago.
            </p>
            
            <div class="table-responsive">
                <table class="table table-bordered table-condensed table-striped" id="cmmsn_tier_table" style="background: white; border-radius: 6px; overflow: hidden; margin-bottom: 8px;">
                    <thead>
                        <tr style="background: #E2E8F0; color: #334155; font-size: 12px;">
                            <th style="width: 28%;">Desde (Días)</th>
                            <th style="width: 28%;">Hasta (Días)</th>
                            <th style="width: 28%;">% Comisión</th>
                            <th style="width: 16%; text-align: center;">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="cmmsn_tier_body">
                        @if(!empty($cmmsn_rules) && count($cmmsn_rules) > 0)
                            @foreach($cmmsn_rules as $idx => $rule)
                                <tr class="tier_row">
                                    <td>
                                        <input type="number" min="0" name="cmmsn_tiered_rules[{{ $idx }}][min_days]" class="form-control input-sm" value="{{ $rule['min_days'] ?? 0 }}" placeholder="0" required>
                                    </td>
                                    <td>
                                        <input type="number" min="0" name="cmmsn_tiered_rules[{{ $idx }}][max_days]" class="form-control input-sm" value="{{ $rule['max_days'] ?? '' }}" placeholder="Sin límite (+)">
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input type="number" step="0.01" min="0" max="100" name="cmmsn_tiered_rules[{{ $idx }}][percent]" class="form-control input-sm" value="{{ $rule['percent'] ?? 0 }}" placeholder="0.00" required>
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
                                    <input type="number" min="0" name="cmmsn_tiered_rules[0][min_days]" class="form-control input-sm" value="0" placeholder="0" required>
                                </td>
                                <td>
                                    <input type="number" min="0" name="cmmsn_tiered_rules[0][max_days]" class="form-control input-sm" value="10" placeholder="10">
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="number" step="0.01" min="0" max="100" name="cmmsn_tiered_rules[0][percent]" class="form-control input-sm" value="4.00" placeholder="0.00" required>
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <button type="button" class="btn btn-xs btn-danger remove_tier_row_btn" title="Eliminar Condición"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr class="tier_row">
                                <td>
                                    <input type="number" min="0" name="cmmsn_tiered_rules[1][min_days]" class="form-control input-sm" value="11" placeholder="11" required>
                                </td>
                                <td>
                                    <input type="number" min="0" name="cmmsn_tiered_rules[1][max_days]" class="form-control input-sm" value="30" placeholder="30">
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="number" step="0.01" min="0" max="100" name="cmmsn_tiered_rules[1][percent]" class="form-control input-sm" value="2.00" placeholder="0.00" required>
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <button type="button" class="btn btn-xs btn-danger remove_tier_row_btn" title="Eliminar Condición"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr class="tier_row">
                                <td>
                                    <input type="number" min="0" name="cmmsn_tiered_rules[2][min_days]" class="form-control input-sm" value="31" placeholder="31" required>
                                </td>
                                <td>
                                    <input type="number" min="0" name="cmmsn_tiered_rules[2][max_days]" class="form-control input-sm" value="" placeholder="Sin límite (+)">
                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="number" step="0.01" min="0" max="100" name="cmmsn_tiered_rules[2][percent]" class="form-control input-sm" value="1.00" placeholder="0.00" required>
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

            <button type="button" class="btn btn-xs btn-primary add_tier_row_btn" style="border-radius: 6px; font-weight: 700;">
                <i class="fa fa-plus"></i> Agregar condición de comisión
            </button>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $(document).off('change', '.cmmsn_type_radio').on('change', '.cmmsn_type_radio', function() {
        var container = $(this).closest('div').parent();
        var val = $(this).val();
        if (val === 'tiered') {
            container.find('.cmmsn_fixed_container').slideUp(200);
            container.find('.cmmsn_tiered_container').slideDown(200);
            container.find('#cmmsn_percent').prop('required', false);
        } else {
            container.find('.cmmsn_tiered_container').slideUp(200);
            container.find('.cmmsn_fixed_container').slideDown(200);
            container.find('#cmmsn_percent').prop('required', true);
        }
    });

    $(document).off('click', '.add_tier_row_btn').on('click', '.add_tier_row_btn', function() {
        var tbody = $(this).closest('.cmmsn_tiered_container').find('#cmmsn_tier_body');
        var rowCount = tbody.find('tr.tier_row').length;
        
        var lastMax = tbody.find('tr.tier_row:last input[name*="[max_days]"]').val();
        var suggestedMin = lastMax ? (parseInt(lastMax) + 1) : 0;

        var newRow = '<tr class="tier_row">' +
            '<td><input type="number" min="0" name="cmmsn_tiered_rules[' + rowCount + '][min_days]" class="form-control input-sm" value="' + suggestedMin + '" placeholder="0" required></td>' +
            '<td><input type="number" min="0" name="cmmsn_tiered_rules[' + rowCount + '][max_days]" class="form-control input-sm" value="" placeholder="Sin límite (+)"></td>' +
            '<td><div class="input-group input-group-sm"><input type="number" step="0.01" min="0" max="100" name="cmmsn_tiered_rules[' + rowCount + '][percent]" class="form-control input-sm" value="1.00" placeholder="0.00" required><span class="input-group-addon">%</span></div></td>' +
            '<td class="text-center" style="vertical-align: middle;"><button type="button" class="btn btn-xs btn-danger remove_tier_row_btn" title="Eliminar Condición"><i class="fa fa-trash"></i></button></td>' +
            '</tr>';
        
        tbody.append(newRow);
    });

    $(document).off('click', '.remove_tier_row_btn').on('click', '.remove_tier_row_btn', function() {
        var tbody = $(this).closest('tbody');
        if (tbody.find('tr.tier_row').length > 1) {
            $(this).closest('tr').remove();
        } else {
            toastr.warning('Debe haber al menos una condición de comisión configurada');
        }
    });
});
</script>
