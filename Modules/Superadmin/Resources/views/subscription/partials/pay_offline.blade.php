@php
    $effective_price_usd = (float)($package_price_after_discount > 0 ? $package_price_after_discount : $package->price);
    $rate_bcv = (!empty($bcv_rate) && $bcv_rate > 1) ? (float)$bcv_rate : 1;
    $price_bs = $effective_price_usd * $rate_bcv;
@endphp

<div class="col-md-12">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
        <div>
            <h4 style="margin: 0 0 4px 0; font-weight: 800; color: #0F172A; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-university text-primary" style="color: #FB4C0A;"></i>
                Transferencia Bancaria / Pago Móvil (Venezuela)
            </h4>
            <p style="margin: 0; color: #64748B; font-size: 13px;">
                Paga en Bolívares (Bs. a tasa BCV) o en Dólares ($) y reporta tu comprobante para activación rápida.
            </p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#offlinePaymentModal" style="background: linear-gradient(135deg, #FB4C0A 0%, #E03E00 100%); border: none; border-radius: 20px; font-weight: 700; padding: 10px 24px; box-shadow: 0 4px 15px rgba(251, 76, 10, 0.35);">
                <i class="fas fa-file-invoice-dollar" style="margin-right: 6px;"></i> Reportar Pago
            </button>
        </div>
    </div>

    <!-- Cuentas Bancarias / Datos de Pago -->
    @if(!empty($offline_payment_details))
        <div style="margin-top: 16px; background: #F8FAFC; border: 1px dashed #CBD5E1; border-radius: 12px; padding: 16px; font-size: 13px; color: #334155;">
            <div style="font-weight: 700; color: #0F172A; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-info-circle text-info"></i> Datos bancarios para realizar el pago:
            </div>
            <div style="white-space: pre-line; line-height: 1.6;">{!! $offline_payment_details !!}</div>
        </div>
    @endif

    <!-- Monto a Transferir -->
    <div style="margin-top: 14px; display: flex; gap: 20px; flex-wrap: wrap; font-size: 13px; color: #475569;">
        <div>
            Monto a Pagar en USD: <strong style="color: #0F172A; font-size: 14px;">${{ number_format($effective_price_usd, 2) }}</strong>
        </div>
        @if($rate_bcv > 1)
            <div>
                Monto a Pagar en Bs (Tasa BCV): <strong style="color: #FB4C0A; font-size: 14px;">Bs. {{ number_format($price_bs, 2, ',', '.') }}</strong>
            </div>
        @endif
    </div>
</div>

<!-- Modal para Reportar Pago Offline -->
<div class="modal fade" id="offlinePaymentModal" tabindex="-1" role="dialog" aria-labelledby="offlinePaymentModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
            <form action="{{ action([\Modules\Superadmin\Http\Controllers\SubscriptionController::class, 'confirm'], [$package->id]) }}" method="POST" id="offline_payment_form">
                {{ csrf_field() }}
                <input type="hidden" name="gateway" value="offline">
                <input type="hidden" name="price" value="{{ $effective_price_usd }}">
                <input type="hidden" name="coupon_code" value="{{ request()->get('code') ?? null }}">

                <div class="modal-header" style="background: #0B0F1D; color: #FFFFFF; padding: 18px 24px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFFFFF; opacity: 0.8;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="offlinePaymentModalLabel" style="font-weight: 800; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-receipt" style="color: #FB4C0A;"></i> Reportar Pago de Suscripción
                    </h4>
                </div>

                <div class="modal-body" style="padding: 24px;">
                    <!-- Resumen del Pago -->
                    <div style="background: rgba(251, 76, 10, 0.08); border: 1px solid rgba(251, 76, 10, 0.2); border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #FB4C0A;">Plan: {{ $package->name }}</span>
                            <div style="font-weight: 800; font-size: 18px; color: #0F172A;">${{ number_format($effective_price_usd, 2) }} USD</div>
                        </div>
                        @if($rate_bcv > 1)
                            <div style="text-align: right;">
                                <span style="font-size: 11px; color: #64748B; font-weight: 600;">Equivalente en Bs:</span>
                                <div style="font-weight: 800; font-size: 16px; color: #FB4C0A;">Bs. {{ number_format($price_bs, 2, ',', '.') }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <!-- Método de Pago Utilizado -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_method" style="font-weight: 700;">Método Utilizado: *</label>
                                <select name="payment_method" id="payment_method" class="form-control" required style="border-radius: 8px;">
                                    <option value="Pago Móvil" selected>📱 Pago Móvil</option>
                                    <option value="Transferencia Bancaria">🏦 Transferencia Bancaria</option>
                                    <option value="Depósito en Dólares">💵 Depósito en Dólares / Cuenta Custodia</option>
                                    <option value="Zelle">🇺🇸 Zelle</option>
                                    <option value="Binance USDT">🪙 Binance Pay / USDT</option>
                                    <option value="Otro">Otro Método</option>
                                </select>
                            </div>
                        </div>

                        <!-- Banco Emisor -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bank_name" style="font-weight: 700;">Banco Emisor (Desde dónde pagaste): *</label>
                                <select name="bank_name" id="bank_name" class="form-control" required style="border-radius: 8px;">
                                    <option value="" disabled selected>Selecciona tu banco...</option>
                                    <option value="Banco de Venezuela (0102)">Banco de Venezuela (0102)</option>
                                    <option value="Banesco (0134)">Banesco (0134)</option>
                                    <option value="Mercantil (0105)">Mercantil (0105)</option>
                                    <option value="BBVA Provincial (0108)">BBVA Provincial (0108)</option>
                                    <option value="Banco Nacional de Crédito BNC (0191)">Banco Nacional de Crédito BNC (0191)</option>
                                    <option value="Bancamiga (0172)">Bancamiga (0172)</option>
                                    <option value="Banplus (0174)">Banplus (0174)</option>
                                    <option value="Bancaribe (0114)">Bancaribe (0114)</option>
                                    <option value="Banco Bicentenario (0175)">Banco Bicentenario (0175)</option>
                                    <option value="Banco del Tesoro (0163)">Banco del Tesoro (0163)</option>
                                    <option value="Banco Plaza (0138)">Banco Plaza (0138)</option>
                                    <option value="Banco Exterior (0115)">Banco Exterior (0115)</option>
                                    <option value="100% Banco (0156)">100% Banco (0156)</option>
                                    <option value="Zelle">Zelle (Banco Extranjero)</option>
                                    <option value="Binance">Binance</option>
                                    <option value="Otro Banco">Otro Banco / Cuenta</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Número de Referencia -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reference_no" style="font-weight: 700;">Número de Referencia / Comprobante: *</label>
                                <input type="text" name="reference_no" id="reference_no" class="form-control" placeholder="Ej: 12345678 (últimos dígitos o ID)" required style="border-radius: 8px;">
                            </div>
                        </div>

                        <!-- Teléfono Emisor -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number" style="font-weight: 700;">Teléfono Emisor (Pago Móvil):</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Ej: 0414-1234567" style="border-radius: 8px;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Monto Pagado -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount_paid" style="font-weight: 700;">Monto Pagado: *</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="amount_paid" id="amount_paid" class="form-control" value="{{ $rate_bcv > 1 ? number_format($price_bs, 2, '.', '') : number_format($effective_price_usd, 2, '.', '') }}" required style="border-radius: 8px 0 0 8px;">
                                    <span class="input-group-addon" style="padding: 0; border: none;">
                                        <select name="currency" style="height: 34px; border: 1px solid #d2d6de; border-left: none; border-radius: 0 8px 8px 0; background: #f8fafc; font-weight: 700; padding: 0 8px;">
                                            <option value="VES" selected>Bs. (VES)</option>
                                            <option value="USD">$ (USD)</option>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Fecha de Pago -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paid_on" style="font-weight: 700;">Fecha de Pago: *</label>
                                <input type="date" name="paid_on" id="paid_on" class="form-control" value="{{ date('Y-m-d') }}" required style="border-radius: 8px;">
                            </div>
                        </div>
                    </div>

                    <!-- Observaciones / Comentarios -->
                    <div class="form-group">
                        <label for="payment_note" style="font-weight: 700;">Notas u Observaciones (Opcional):</label>
                        <textarea name="payment_note" id="payment_note" class="form-control" rows="2" placeholder="Ej: Transferencia realizada desde cuenta a nombre de..." style="border-radius: 8px; resize: vertical;"></textarea>
                    </div>

                    <div style="background: #F8FAFC; border-radius: 8px; padding: 10px 14px; font-size: 12px; color: #64748B;">
                        <i class="fas fa-shield-alt text-success"></i> Una vez enviado tu reporte, nuestro equipo confirmará los fondos y tu suscripción se activará inmediatamente.
                    </div>
                </div>

                <div class="modal-footer" style="padding: 16px 24px; background: #F8FAFC; border-top: 1px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 20px; font-weight: 600;">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #FB4C0A 0%, #E03E00 100%); border: none; border-radius: 20px; font-weight: 700; padding: 8px 24px; box-shadow: 0 4px 12px rgba(251, 76, 10, 0.3);">
                        <i class="fas fa-paper-plane" style="margin-right: 6px;"></i> Enviar Reporte de Pago
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>