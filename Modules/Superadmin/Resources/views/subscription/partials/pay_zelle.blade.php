@php
    $effective_price_usd = (float)($coupon_status['status'] == 'success' ? $package_price_after_discount : $package->price);

    $zelle_email = \App\System::getProperty('zelle_email') ?? 'pagos@kubre.site';
    $zelle_holder = \App\System::getProperty('zelle_holder') ?? 'Kubre Technologies LLC';
@endphp

<div class="col-md-12">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
        <div>
            <h4 style="margin: 0 0 4px 0; font-weight: 800; color: #0F172A; display: flex; align-items: center; gap: 8px;">
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: rgba(99, 102, 241, 0.12); color: #6366F1;">
                    <i class="fas fa-dollar-sign"></i>
                </span>
                Zelle (Dólares USD)
            </h4>
            <p style="margin: 0; color: #64748B; font-size: 13px;">
                Envía tu pago vía Zelle desde cualquier banco de EE.UU. sin comisión adicional.
            </p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#zelleModal" style="background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%); border: none; border-radius: 20px; font-weight: 700; padding: 9px 22px; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.35);">
                <i class="fas fa-receipt" style="margin-right: 6px;"></i> Reportar Zelle
            </button>
        </div>
    </div>

    <!-- Datos Receptores Zelle -->
    <div style="margin-top: 14px; background: #EEF2FF; border: 1px solid #C7D2FE; border-radius: 12px; padding: 14px 18px; font-size: 13px; color: #3730A3;">
        <div class="row">
            <div class="col-sm-6 col-xs-12" style="margin-bottom: 6px;">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #4F46E5;">Correo Zelle Receptor:</span>
                <div style="font-weight: 800; color: #1E1B4B; font-size: 14px;">{{ $zelle_email }}</div>
            </div>
            <div class="col-sm-6 col-xs-12" style="margin-bottom: 6px;">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #4F46E5;">Titular de la Cuenta:</span>
                <div style="font-weight: 800; color: #1E1B4B;">{{ $zelle_holder }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reporte Zelle -->
<div class="modal fade" id="zelleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
            <form action="{{ action([\Modules\Superadmin\Http\Controllers\SubscriptionController::class, 'confirm'], [$package->id]) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="gateway" value="zelle">
                <input type="hidden" name="price" value="{{ $effective_price_usd }}">
                <input type="hidden" name="currency" value="USD">
                <input type="hidden" name="coupon_code" value="{{ request()->get('code') ?? null }}">

                <div class="modal-header" style="background: #0B0F1D; color: #FFFFFF; padding: 18px 24px;">
                    <button type="button" class="close" data-dismiss="modal" style="color: #FFF;"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="font-weight: 800; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-dollar-sign" style="color: #818CF8;"></i> Reportar Pago por Zelle
                    </h4>
                </div>

                <div class="modal-body" style="padding: 24px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zelle_sender_name" style="font-weight: 700;">Nombre del Titular Zelle Emisor: *</label>
                                <input type="text" name="holder_name" id="zelle_sender_name" class="form-control" placeholder="Ej: John Doe" required style="border-radius: 8px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zelle_sender_email" style="font-weight: 700;">Correo / Teléfono Zelle Emisor: *</label>
                                <input type="text" name="email_account" id="zelle_sender_email" class="form-control" placeholder="Ej: cliente@gmail.com" required style="border-radius: 8px;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zelle_ref" style="font-weight: 700;">Código de Confirmación / Referencia: *</label>
                                <input type="text" name="reference_no" id="zelle_ref" class="form-control" placeholder="Ej: ZELLE-998822" required style="border-radius: 8px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zelle_amount" style="font-weight: 700;">Monto Enviado (USD $): *</label>
                                <input type="number" step="0.01" name="amount_paid" id="zelle_amount" class="form-control" value="{{ number_format($effective_price_usd, 2, '.', '') }}" required style="border-radius: 8px;">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="zelle_date" style="font-weight: 700;">Fecha de Envío: *</label>
                        <input type="date" name="paid_on" id="zelle_date" class="form-control" value="{{ date('Y-m-d') }}" required style="border-radius: 8px;">
                    </div>

                    <div class="form-group">
                        <label for="zelle_notes" style="font-weight: 700;">Notas u Observaciones (Opcional):</label>
                        <textarea name="payment_note" id="zelle_notes" class="form-control" rows="2" placeholder="Ej: Pago realizado desde Chase Bank" style="border-radius: 8px;"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 16px 24px; background: #F8FAFC;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 20px;">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%); border: none; border-radius: 20px; font-weight: 700; padding: 8px 22px;">
                        <i class="fas fa-paper-plane"></i> Enviar Comprobante
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
