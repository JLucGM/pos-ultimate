@php
    $cmmsn_type = !empty($user->cmmsn_type) ? $user->cmmsn_type : 'fixed';
    $cmmsn_rules = !empty($user->cmmsn_tiered_rules) && is_array($user->cmmsn_tiered_rules) ? $user->cmmsn_tiered_rules : [];
@endphp

<div class="col-md-12">
    <div style="background: #F8FAFC; border: 2px solid #CBD5E1; border-left: 5px solid #F59E0B; border-radius: 10px; padding: 16px 18px; margin-bottom: 20px;">
        <label style="font-weight: 800; color: #0F172A; font-size: 14px; margin-bottom: 12px; display: block;">
            <i class="fas fa-percentage" style="color: #D97706; margin-right: 6px;"></i> Esquema de Comisión de Ventas
        </label>

        {{-- Hidden input que envía el valor al backend --}}
        <input type="hidden" name="cmmsn_type" id="cmmsn_type_input" value="{{ $cmmsn_type }}">

        {{-- Botones de Selección Visual --}}
        <div class="btn-group btn-group-justified" style="margin-bottom: 15px; display: flex; gap: 10px;">
            <button type="button" id="cmmsn_btn_fixed" onclick="switchCommissionType('fixed')"
                    class="btn {{ $cmmsn_type == 'fixed' ? 'btn-primary' : 'btn-default' }}"
                    style="flex: 1; font-weight: 700; font-size: 13px; padding: 10px 14px; border-radius: 8px !important; {{ $cmmsn_type == 'fixed' ? 'background-color: #2563EB; border-color: #1D4ED8; color: #FFF;' : 'background-color: #FFF; color: #334155; border-color: #CBD5E1;' }}">
                <i class="fa fa-dot-circle"></i> 1. Comisión Fija (%)
            </button>

            <button type="button" id="cmmsn_btn_tiered" onclick="switchCommissionType('tiered')"
                    class="btn {{ $cmmsn_type == 'tiered' ? 'btn-primary' : 'btn-default' }}"
                    style="flex: 1; font-weight: 700; font-size: 13px; padding: 10px 14px; border-radius: 8px !important; {{ $cmmsn_type == 'tiered' ? 'background-color: #2563EB; border-color: #1D4ED8; color: #FFF;' : 'background-color: #FFF; color: #334155; border-color: #CBD5E1;' }}">
                <i class="fa fa-chart-line"></i> 2. Comisión Escalonada por Días de Cobro
            </button>
        </div>

        {{-- CONTENEDOR 1: COMISIÓN FIJA --}}
        <div id="cmmsn_fixed_box" style="{{ $cmmsn_type == 'tiered' ? 'display: none;' : 'display: block;' }}">
            <div class="form-group" style="margin-bottom: 0; max-width: 260px;">
                <label for="cmmsn_percent" style="font-weight: 700; color: #334155;">Porcentaje Fijo (%):</label>
                <div class="input-group">
                    <input type="text" name="cmmsn_percent" id="cmmsn_percent" class="form-control input_number"
                           value="{{ !empty($user->cmmsn_percent) ? @num_format($user->cmmsn_percent) : '0.00' }}" placeholder="0.00">
                    <span class="input-group-addon">%</span>
                </div>
                <small class="text-muted" style="font-size: 11px;">Mismo porcentaje para todas las ventas registradas.</small>
            </div>
        </div>

        {{-- CONTENEDOR 2: COMISIÓN ESCALONADA --}}
        <div id="cmmsn_tiered_box" style="{{ $cmmsn_type == 'tiered' ? 'display: block;' : 'display: none;' }}">
            <div style="background: #FEF3C7; border: 1px solid #FDE68A; border-radius: 6px; padding: 10px 14px; margin-bottom: 12px;">
                <span style="font-size: 12px; color: #92400E; line-height: 1.4; font-weight: 600;">
                    <i class="fa fa-info-circle"></i> Configura los días transcurridos entre la fecha de emisión de la factura y la fecha de pago del cliente para asignar el porcentaje correspondiente.
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
                                        <button type="button" class="btn btn-xs btn-danger" onclick="removeCommissionTierRow(this)" title="Eliminar Condición"><i class="fa fa-trash"></i></button>
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
                                    <button type="button" class="btn btn-xs btn-danger" onclick="removeCommissionTierRow(this)" title="Eliminar Condición"><i class="fa fa-trash"></i></button>
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
                                    <button type="button" class="btn btn-xs btn-danger" onclick="removeCommissionTierRow(this)" title="Eliminar Condición"><i class="fa fa-trash"></i></button>
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
                                    <button type="button" class="btn btn-xs btn-danger" onclick="removeCommissionTierRow(this)" title="Eliminar Condición"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <button type="button" class="btn btn-sm btn-primary" onclick="addCommissionTierRow()" style="border-radius: 6px; font-weight: 700; padding: 6px 14px;">
                <i class="fa fa-plus"></i> Agregar condición de comisión
            </button>
        </div>
    </div>
</div>

<script>
function switchCommissionType(type) {
    var fixedBox = document.getElementById('cmmsn_fixed_box');
    var tieredBox = document.getElementById('cmmsn_tiered_box');
    var fixedBtn = document.getElementById('cmmsn_btn_fixed');
    var tieredBtn = document.getElementById('cmmsn_btn_tiered');
    var typeInput = document.getElementById('cmmsn_type_input');

    if (typeInput) {
        typeInput.value = type;
    }

    if (type === 'tiered') {
        if (fixedBox) fixedBox.style.display = 'none';
        if (tieredBox) tieredBox.style.display = 'block';
        if (fixedBtn) {
            fixedBtn.className = 'btn btn-default';
            fixedBtn.style.backgroundColor = '#FFFFFF';
            fixedBtn.style.color = '#334155';
            fixedBtn.style.borderColor = '#CBD5E1';
        }
        if (tieredBtn) {
            tieredBtn.className = 'btn btn-primary';
            tieredBtn.style.backgroundColor = '#2563EB';
            tieredBtn.style.color = '#FFFFFF';
            tieredBtn.style.borderColor = '#1D4ED8';
        }
    } else {
        if (tieredBox) tieredBox.style.display = 'none';
        if (fixedBox) fixedBox.style.display = 'block';
        if (fixedBtn) {
            fixedBtn.className = 'btn btn-primary';
            fixedBtn.style.backgroundColor = '#2563EB';
            fixedBtn.style.color = '#FFFFFF';
            fixedBtn.style.borderColor = '#1D4ED8';
        }
        if (tieredBtn) {
            tieredBtn.className = 'btn btn-default';
            tieredBtn.style.backgroundColor = '#FFFFFF';
            tieredBtn.style.color = '#334155';
            tieredBtn.style.borderColor = '#CBD5E1';
        }
    }
}

function addCommissionTierRow() {
    var tbody = document.getElementById('cmmsn_tier_body');
    if (!tbody) return;
    
    var rows = tbody.getElementsByClassName('tier_row');
    var count = rows.length;
    var suggestedMin = 0;
    
    if (count > 0) {
        var lastMaxInput = rows[count - 1].querySelector('input[name*="[max_days]"]');
        if (lastMaxInput && lastMaxInput.value !== '' && !isNaN(lastMaxInput.value)) {
            suggestedMin = parseInt(lastMaxInput.value) + 1;
        }
    }

    var tr = document.createElement('tr');
    tr.className = 'tier_row';
    tr.innerHTML = '<td><input type="number" min="0" name="cmmsn_tiered_rules[' + count + '][min_days]" class="form-control input-sm text-center" value="' + suggestedMin + '" placeholder="0" required></td>' +
        '<td><input type="number" min="0" name="cmmsn_tiered_rules[' + count + '][max_days]" class="form-control input-sm text-center" value="" placeholder="Sin límite (+)"></td>' +
        '<td><div class="input-group input-group-sm"><input type="number" step="0.01" min="0" max="100" name="cmmsn_tiered_rules[' + count + '][percent]" class="form-control input-sm text-right" value="1.00" placeholder="0.00" required><span class="input-group-addon">%</span></div></td>' +
        '<td class="text-center" style="vertical-align: middle;"><button type="button" class="btn btn-xs btn-danger" onclick="removeCommissionTierRow(this)" title="Eliminar Condición"><i class="fa fa-trash"></i></button></td>';
    
    tbody.appendChild(tr);
}

function removeCommissionTierRow(btn) {
    var row = btn.closest('tr');
    var tbody = document.getElementById('cmmsn_tier_body');
    if (tbody && tbody.getElementsByClassName('tier_row').length > 1) {
        row.remove();
    } else {
        alert('Debe haber al menos una condición de comisión configurada.');
    }
}
</script>
