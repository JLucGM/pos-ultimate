@php
    $effective_price_usd = (float)($coupon_status['status'] == 'success' ? $package_price_after_discount : $package->price);

    $paypal_email = \App\System::getProperty('paypal_email') ?? 'pagos@kubre.site';
    $paypal_me = \App\System::getProperty('paypal_me_url') ?? '';
@endphp

<div class="col-md-12">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
        <div>
            <h4 style="margin: 0 0 4px 0; font-weight: 800; color: #0F172A; display: flex; align-items: center; gap: 8px;">
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: rgba(30, 64, 175, 0.12); color: #1E40AF;">
                    <i class="fab fa-paypal"></i>
                </span>
                PayPal (Dólares USD)
            </h4>
            <p style="margin: 0; color: #64748B; font-size: 13px;">
                Transfiere desde tu saldo PayPal o paga mediante enlace directo y reporta el ID de transacción.
            </p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            @if(!empty($paypal_me))
                <a href="{{ $paypal_me }}/{{ $effective_price_usd }}USD" target="_blank" rel="noopener noreferrer" class="btn btn-default" style="border-radius: 20px; font-weight: 700; padding: 9px 18px; border-color: #CBD5E1;">
                    <i class="fab fa-paypal" style="color: #0070BA;"></i> Abrir PayPal.Me
                </a>
            @endif
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#paypalReportModal" style="background: linear-gradient(135deg, #0070BA 0%, #003087 100%); border: none; border-radius: 20px; font-weight: 700; padding: 9px 22px; box-shadow: 0 4px 15px rgba(0, 112, 186, 0.35);">
                <i class="fas fa-receipt" style="margin-right: 6px;"></i> Reportar PayPal
            </button>
        </div>
    </div>

    <!-- Datos Receptores PayPal -->
    <div style="margin-top: 14px; background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 12px; padding: 14px 18px; font-size: 13px; color: #1E40AF;">
        <div class="row">
            <div class="col-sm-6 col-xs-12" style="margin-bottom: 6px;">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #2563EB;">Cuenta PayPal Destino:</span>
                <div style="font-weight: 800; color: #172554; font-size: 14px;">{{ $paypal_email }}</div>
            </div>
            <div class="col-sm-6 col-xs-12" style="margin-bottom: 6px;">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #2563EB;">Monto a Enviar:</span>
                <div style="font-weight: 800; color: #0070BA; font-size: 15px;">${{ number_format($effective_price_usd, 2) }} USD</div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reporte PayPal -->
<div class="modal fade" id="paypalReportModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
            <form action="{{ action([\Modules\Superadmin\Http\Controllers\SubscriptionController::class, 'confirm'], [$package->id]) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="gateway" value="paypal">
                <input type="hidden" name="price" value="{{ $effective_price_usd }}">
                <input type="hidden" name="currency" value="USD">
                <input type="hidden" name="coupon_code" value="{{ request()->get('code') ?? null }}">

                <div class="modal-header" style="background: #0B0F1D; color: #FFFFFF; padding: 18px 24px;">
                    <button type="button" class="close" data-dismiss="modal" style="color: #FFF;"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="font-weight: 800; display: flex; align-items: center; gap: 8px;">
                        <i class="fab fa-paypal" style="color: #60A5FA;"></i> Reportar Pago por PayPal
                    </h4>
                </div>

                <div class="modal-body" style="padding: 24px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paypal_sender_email" style="font-weight: 700;">Correo Electrónico de tu Cuenta PayPal: *</label>
                                <input type="email" name="email_account" id="paypal_sender_email" class="form-control" placeholder="Ej: tu_email@paypal.com" required style="border-radius: 8px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paypal_tx_id" style="font-weight: 700;">ID de Transacción PayPal: *</label>
                                <input type="text" name="reference_no" id="paypal_tx_id" class="form-control" placeholder="Ej: 9X1234567890" required style="border-radius: 8px;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paypal_amount" style="font-weight: 700;">Monto Enviado (USD $): *</label>
                                <input type="number" step="0.01" name="amount_paid" id="paypal_amount" class="form-control" value="{{ number_format($effective_price_usd, 2, '.', '') }}" required style="border-radius: 8px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paypal_date" style="font-weight: 700;">Fecha de Envío: *</label>
                                <input type="date" name="paid_on" id="paypal_date" class="form-control" value="{{ date('Y-m-d') }}" required style="border-radius: 8px;">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="paypal_notes" style="font-weight: 700;">Notas u Observaciones (Opcional):</label>
                        <textarea name="payment_note" id="paypal_notes" class="form-control" rows="2" placeholder="Detalles de la transferencia en PayPal..." style="border-radius: 8px;"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 16px 24px; background: #F8FAFC;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 20px;">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #0070BA 0%, #003087 100%); border: none; border-radius: 20px; font-weight: 700; padding: 8px 22px;">
                        <i class="fas fa-paper-plane"></i> Enviar Comprobante
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>