@php
    $effective_price_usd = (float)($coupon_status['status'] == 'success' ? $package_price_after_discount : $package->price);
    $rate_bcv = (!empty($bcv_rate) && $bcv_rate > 1) ? (float)$bcv_rate : 1;
    $price_bs = $effective_price_usd * $rate_bcv;

    $bt_bank = \App\System::getProperty('bank_transfer_bank') ?? 'Banesco Banco Universal (0134)';
    $bt_account = \App\System::getProperty('bank_transfer_account') ?? '0134-0000-00-0000000000';
    $bt_type = \App\System::getProperty('bank_transfer_type') ?? 'Cuenta Corriente';
    $bt_holder = \App\System::getProperty('bank_transfer_holder') ?? 'Kubre POS C.A.';
    $bt_id = \App\System::getProperty('bank_transfer_id_doc') ?? 'J-50000000-0';
@endphp

<div class="col-md-12">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
        <div>
            <h4 style="margin: 0 0 4px 0; font-weight: 800; color: #0F172A; display: flex; align-items: center; gap: 8px;">
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: rgba(16, 185, 129, 0.12); color: #10B981;">
                    <i class="fas fa-university"></i>
                </span>
                Transferencia Bancaria Nacional (Bolívares / Dólares)
            </h4>
            <p style="margin: 0; color: #64748B; font-size: 13px;">
                Transfiere directamente a nuestra cuenta bancaria nacional y reporta el número de referencia.
            </p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bankTransferModal" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); border: none; border-radius: 20px; font-weight: 700; padding: 9px 22px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.35);">
                <i class="fas fa-file-invoice" style="margin-right: 6px;"></i> Reportar Transferencia
            </button>
        </div>
    </div>

    <!-- Datos Bancarios -->
    <div style="margin-top: 14px; background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 12px; padding: 14px 18px; font-size: 13px; color: #14532D;">
        <div class="row">
            <div class="col-sm-4 col-xs-12" style="margin-bottom: 6px;">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #15803D;">Banco:</span>
                <div style="font-weight: 800; color: #052E16;">{{ $bt_bank }}</div>
            </div>
            <div class="col-sm-4 col-xs-12" style="margin-bottom: 6px;">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #15803D;">N° de Cuenta:</span>
                <div style="font-weight: 800; font-family: monospace; color: #052E16; font-size: 14px;">{{ $bt_account }}</div>
            </div>
            <div class="col-sm-4 col-xs-12" style="margin-bottom: 6px;">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #15803D;">Titular & RIF:</span>
                <div style="font-weight: 800; color: #052E16;">{{ $bt_holder }} ({{ $bt_id }})</div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reporte Transferencia -->
<div class="modal fade" id="bankTransferModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
            <form action="{{ action([\Modules\Superadmin\Http\Controllers\SubscriptionController::class, 'confirm'], [$package->id]) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="gateway" value="bank_transfer">
                <input type="hidden" name="price" value="{{ $effective_price_usd }}">
                <input type="hidden" name="coupon_code" value="{{ request()->get('code') ?? null }}">

                <div class="modal-header" style="background: #0B0F1D; color: #FFFFFF; padding: 18px 24px;">
                    <button type="button" class="close" data-dismiss="modal" style="color: #FFF;"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="font-weight: 800; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-university" style="color: #10B981;"></i> Reportar Transferencia Bancaria
                    </h4>
                </div>

                <div class="modal-body" style="padding: 24px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bt_bank_name" style="font-weight: 700;">Banco Origen: *</label>
                                <input type="text" name="bank_name" id="bt_bank_name" class="form-control" placeholder="Ej: Banesco, Mercantil, BDV..." required style="border-radius: 8px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bt_holder_name" style="font-weight: 700;">Nombre del Titular Emisor: *</label>
                                <input type="text" name="holder_name" id="bt_holder_name" class="form-control" placeholder="Ej: Empresa / Persona que transfiere" required style="border-radius: 8px;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bt_reference_no" style="font-weight: 700;">N° de Referencia / Comprobante: *</label>
                                <input type="text" name="reference_no" id="bt_reference_no" class="form-control" placeholder="Ej: 12345678" required style="border-radius: 8px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bt_amount_paid" style="font-weight: 700;">Monto Pagado: *</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="amount_paid" id="bt_amount_paid" class="form-control" value="{{ number_format($price_bs, 2, '.', '') }}" required style="border-radius: 8px 0 0 8px;">
                                    <span class="input-group-addon" style="padding: 0; border: none;">
                                        <select name="currency" style="height: 34px; border: 1px solid #d2d6de; border-left: none; border-radius: 0 8px 8px 0; background: #f8fafc; font-weight: 700; padding: 0 8px;">
                                            <option value="VES" selected>Bs. (VES)</option>
                                            <option value="USD">$ (USD)</option>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bt_paid_on" style="font-weight: 700;">Fecha de la Transferencia: *</label>
                        <input type="date" name="paid_on" id="bt_paid_on" class="form-control" value="{{ date('Y-m-d') }}" required style="border-radius: 8px;">
                    </div>

                    <div class="form-group">
                        <label for="bt_payment_note" style="font-weight: 700;">Notas u Observaciones (Opcional):</label>
                        <textarea name="payment_note" id="bt_payment_note" class="form-control" rows="2" placeholder="Detalles adicionales sobre la transferencia..." style="border-radius: 8px;"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 16px 24px; background: #F8FAFC;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 20px;">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); border: none; border-radius: 20px; font-weight: 700; padding: 8px 22px;">
                        <i class="fas fa-paper-plane"></i> Enviar Comprobante
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
