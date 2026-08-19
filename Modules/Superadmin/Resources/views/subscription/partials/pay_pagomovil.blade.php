@php
    $effective_price_usd = (float)($coupon_status['status'] == 'success' ? $package_price_after_discount : $package->price);
    $rate_bcv = (!empty($bcv_rate) && $bcv_rate > 1) ? (float)$bcv_rate : 1;
    $price_bs = $effective_price_usd * $rate_bcv;

    $pm_bank = \App\System::getProperty('pagomovil_bank') ?? 'Banco de Venezuela (0102)';
    $pm_phone = \App\System::getProperty('pagomovil_phone') ?? '0414-2909870';
    $pm_id = \App\System::getProperty('pagomovil_id_doc') ?? 'J-50000000-0';
    $pm_holder = \App\System::getProperty('pagomovil_holder') ?? 'Kubre POS C.A.';
@endphp

<div class="col-md-12">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
        <div>
            <h4 style="margin: 0 0 4px 0; font-weight: 800; color: #0F172A; display: flex; align-items: center; gap: 8px;">
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: rgba(147, 51, 234, 0.12); color: #9333EA;">
                    <i class="fas fa-mobile-alt"></i>
                </span>
                Pago Móvil (Bolívares Bs. - Tasa Oficial BCV)
            </h4>
            <p style="margin: 0; color: #64748B; font-size: 13px;">
                Transfiere en segundos desde cualquier banco venezolano a tasa BCV del día.
            </p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pagoMovilModal" style="background: linear-gradient(135deg, #9333EA 0%, #7E22CE 100%); border: none; border-radius: 20px; font-weight: 700; padding: 9px 22px; box-shadow: 0 4px 15px rgba(147, 51, 234, 0.35);">
                <i class="fas fa-receipt" style="margin-right: 6px;"></i> Reportar Pago Móvil
            </button>
        </div>
    </div>

    <!-- Datos Receptores de Pago Móvil -->
    <div style="margin-top: 14px; background: #FAF5FF; border: 1px solid #E9D5FF; border-radius: 12px; padding: 14px 18px; font-size: 13px; color: #581C87;">
        <div class="row">
            <div class="col-sm-3 col-xs-6" style="margin-bottom: 6px;">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #7E22CE;">Banco Destino:</span>
                <div style="font-weight: 800; color: #1E1B4B;">{{ $pm_bank }}</div>
            </div>
            <div class="col-sm-3 col-xs-6" style="margin-bottom: 6px;">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #7E22CE;">Teléfono:</span>
                <div style="font-weight: 800; color: #1E1B4B;">{{ $pm_phone }}</div>
            </div>
            <div class="col-sm-3 col-xs-6" style="margin-bottom: 6px;">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #7E22CE;">Cédula / RIF:</span>
                <div style="font-weight: 800; color: #1E1B4B;">{{ $pm_id }}</div>
            </div>
            <div class="col-sm-3 col-xs-6" style="margin-bottom: 6px;">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #7E22CE;">Monto a Transferir:</span>
                <div style="font-weight: 800; color: #9333EA; font-size: 15px;">Bs. {{ number_format($price_bs, 2, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reporte Pago Móvil -->
<div class="modal fade" id="pagoMovilModal" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
            <form action="{{ action([\Modules\Superadmin\Http\Controllers\SubscriptionController::class, 'confirm'], [$package->id]) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="gateway" value="pagomovil">
                <input type="hidden" name="price" value="{{ $effective_price_usd }}">
                <input type="hidden" name="currency" value="VES">
                <input type="hidden" name="coupon_code" value="{{ request()->get('code') ?? null }}">

                <div class="modal-header" style="background: #0B0F1D; color: #FFFFFF; padding: 18px 24px;">
                    <button type="button" class="close" data-dismiss="modal" style="color: #FFF;"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="font-weight: 800; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-mobile-alt" style="color: #A855F7;"></i> Reportar Pago Móvil
                    </h4>
                </div>

                <div class="modal-body" style="padding: 24px;">
                    <div style="background: rgba(147, 51, 234, 0.08); border: 1px solid rgba(147, 51, 234, 0.2); border-radius: 12px; padding: 12px 16px; margin-bottom: 18px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #9333EA;">Plan: {{ $package->name }}</span>
                            <div style="font-weight: 800; font-size: 16px; color: #0F172A;">${{ number_format($effective_price_usd, 2) }} USD</div>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 11px; color: #64748B; font-weight: 600;">Monto en Bolívares:</span>
                            <div style="font-weight: 800; font-size: 18px; color: #9333EA;">Bs. {{ number_format($price_bs, 2, ',', '.') }}</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pm_bank_name" style="font-weight: 700;">Banco Emisor (Desde dónde pagaste): *</label>
                                <select name="bank_name" id="pm_bank_name" class="form-control" required style="border-radius: 8px;">
                                    <option value="" disabled selected>Selecciona tu banco...</option>
                                    <option value="Banco de Venezuela (0102)">Banco de Venezuela (0102)</option>
                                    <option value="Banesco (0134)">Banesco (0134)</option>
                                    <option value="Mercantil (0105)">Mercantil (0105)</option>
                                    <option value="BBVA Provincial (0108)">BBVA Provincial (0108)</option>
                                    <option value="BNC Banco Nacional de Crédito (0191)">BNC (0191)</option>
                                    <option value="Bancamiga (0172)">Bancamiga (0172)</option>
                                    <option value="Banplus (0174)">Banplus (0174)</option>
                                    <option value="Bancaribe (0114)">Bancaribe (0114)</option>
                                    <option value="Banco Bicentenario (0175)">Banco Bicentenario (0175)</option>
                                    <option value="Banco del Tesoro (0163)">Banco del Tesoro (0163)</option>
                                    <option value="Banco Exterior (0115)">Banco Exterior (0115)</option>
                                    <option value="Otro Banco">Otro Banco</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pm_phone_number" style="font-weight: 700;">Teléfono Emisor: *</label>
                                <input type="text" name="phone_number" id="pm_phone_number" class="form-control" placeholder="Ej: 0414-1234567" required style="border-radius: 8px;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pm_reference_no" style="font-weight: 700;">N° de Referencia (últimos dígitos): *</label>
                                <input type="text" name="reference_no" id="pm_reference_no" class="form-control" placeholder="Ej: 12345678" required style="border-radius: 8px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pm_amount_paid" style="font-weight: 700;">Monto Pagado en Bs: *</label>
                                <input type="number" step="0.01" name="amount_paid" id="pm_amount_paid" class="form-control" value="{{ number_format($price_bs, 2, '.', '') }}" required style="border-radius: 8px;">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pm_paid_on" style="font-weight: 700;">Fecha del Pago: *</label>
                        <input type="date" name="paid_on" id="pm_paid_on" class="form-control" value="{{ date('Y-m-d') }}" required style="border-radius: 8px;">
                    </div>

                    <div class="form-group">
                        <label for="pm_payment_note" style="font-weight: 700;">Notas u Observaciones (Opcional):</label>
                        <textarea name="payment_note" id="pm_payment_note" class="form-control" rows="2" placeholder="Ej: Pago realizado por Juan Pérez" style="border-radius: 8px;"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 16px 24px; background: #F8FAFC;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 20px;">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #9333EA 0%, #7E22CE 100%); border: none; border-radius: 20px; font-weight: 700; padding: 8px 22px;">
                        <i class="fas fa-paper-plane"></i> Enviar Comprobante
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
