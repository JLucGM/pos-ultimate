@php
    $effective_price_usd = (float)($coupon_status['status'] == 'success' ? $package_price_after_discount : $package->price);

    $binance_pay_id = \App\System::getProperty('binance_pay_id') ?? '123456789';
    $binance_email = \App\System::getProperty('binance_email') ?? 'binance@kubre.site';
    $binance_network = \App\System::getProperty('binance_network') ?? 'USDT (BNB Smart Chain / TRC20)';
@endphp

<div class="col-md-12">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
        <div>
            <h4 style="margin: 0 0 4px 0; font-weight: 800; color: #0F172A; display: flex; align-items: center; gap: 8px;">
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: rgba(245, 158, 11, 0.12); color: #F59E0B;">
                    <i class="fas fa-coins"></i>
                </span>
                Binance Pay / Criptomonedas (USDT)
            </h4>
            <p style="margin: 0; color: #64748B; font-size: 13px;">
                Paga de forma instantánea y sin comisiones usando Binance Pay ID o transferencia USDT.
            </p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#binanceModal" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); border: none; border-radius: 20px; font-weight: 700; padding: 9px 22px; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.35);">
                <i class="fas fa-receipt" style="margin-right: 6px;"></i> Reportar Binance Pay
            </button>
        </div>
    </div>

    <!-- Datos Receptores Binance -->
    <div style="margin-top: 14px; background: #FEFCE8; border: 1px solid #FEF08A; border-radius: 12px; padding: 14px 18px; font-size: 13px; color: #854D0E;">
        <div class="row">
            <div class="col-sm-4 col-xs-12" style="margin-bottom: 6px;">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #B45309;">Binance Pay ID:</span>
                <div style="font-weight: 800; font-family: monospace; color: #451A03; font-size: 15px;">{{ $binance_pay_id }}</div>
            </div>
            <div class="col-sm-4 col-xs-12" style="margin-bottom: 6px;">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #B45309;">Correo / Usuario:</span>
                <div style="font-weight: 800; color: #451A03;">{{ $binance_email }}</div>
            </div>
            <div class="col-sm-4 col-xs-12" style="margin-bottom: 6px;">
                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #B45309;">Moneda y Red:</span>
                <div style="font-weight: 800; color: #451A03;">{{ $binance_network }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reporte Binance -->
<div class="modal fade" id="binanceModal" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
            <form action="{{ action([\Modules\Superadmin\Http\Controllers\SubscriptionController::class, 'confirm'], [$package->id]) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="gateway" value="binance">
                <input type="hidden" name="price" value="{{ $effective_price_usd }}">
                <input type="hidden" name="currency" value="USDT">
                <input type="hidden" name="coupon_code" value="{{ request()->get('code') ?? null }}">

                <div class="modal-header" style="background: #0B0F1D; color: #FFFFFF; padding: 18px 24px;">
                    <button type="button" class="close" data-dismiss="modal" style="color: #FFF;"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="font-weight: 800; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-coins" style="color: #FBBF24;"></i> Reportar Pago por Binance Pay
                    </h4>
                </div>

                <div class="modal-body" style="padding: 24px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="binance_tx_id" style="font-weight: 700;">Binance Pay Order ID / TxID: *</label>
                                <input type="text" name="reference_no" id="binance_tx_id" class="form-control" placeholder="Ej: 21987364501" required style="border-radius: 8px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="binance_sender_user" style="font-weight: 700;">Tu Binance Pay ID / Nickname: *</label>
                                <input type="text" name="holder_name" id="binance_sender_user" class="form-control" placeholder="Ej: usuario_binance" required style="border-radius: 8px;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="binance_amount" style="font-weight: 700;">Monto Transferido (USDT): *</label>
                                <input type="number" step="0.01" name="amount_paid" id="binance_amount" class="form-control" value="{{ number_format($effective_price_usd, 2, '.', '') }}" required style="border-radius: 8px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="binance_date" style="font-weight: 700;">Fecha de la Transacción: *</label>
                                <input type="date" name="paid_on" id="binance_date" class="form-control" value="{{ date('Y-m-d') }}" required style="border-radius: 8px;">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="binance_notes" style="font-weight: 700;">Notas u Observaciones (Opcional):</label>
                        <textarea name="payment_note" id="binance_notes" class="form-control" rows="2" placeholder="Detalles de la transacción en Binance..." style="border-radius: 8px;"></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 16px 24px; background: #F8FAFC;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 20px;">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); border: none; border-radius: 20px; font-weight: 700; padding: 8px 22px;">
                        <i class="fas fa-paper-plane"></i> Enviar Comprobante
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
