@extends('layouts.guest')
@section('title', $title)
@section('content')

<div class="container" style="max-width: 760px; margin: 30px auto;">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-solid" style="border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border: 1px solid #E2E8F0;">
                <div class="box-header" style="background: #0B0F1D; color: #FFFFFF; padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
                        <div>
                            @if(!empty($transaction->business->logo))
                                <img src="{{ asset('uploads/business_logos/' . $transaction->business->logo) }}" alt="Logo" style="max-height: 50px; width: auto; margin-bottom: 8px;">
                            @endif
                            <h3 style="margin: 0; font-weight: 800; color: #FFFFFF; font-size: 20px;">{{ $transaction->business->name }}</h3>
                            <span style="font-size: 13px; opacity: 0.8;">{{ $transaction->location->name ?? '' }}</span>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #FB4C0A; letter-spacing: 0.8px;">Factura / Nota de Venta</span>
                            <div style="font-size: 18px; font-weight: 800; color: #FFFFFF;">#{{ $transaction->invoice_no }}</div>
                            <span style="font-size: 12px; opacity: 0.8;">{{ $date_formatted }}</span>
                        </div>
                    </div>
                </div>

                <div class="box-body" style="padding: 24px;">
                    <!-- Información del Cliente y Monto -->
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 16px 20px; margin-bottom: 20px;">
                        <div class="row">
                            <div class="col-sm-6">
                                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748B;">Cliente:</span>
                                <div style="font-weight: 800; color: #0F172A; font-size: 15px;">{{ $transaction->contact->name ?? 'Cliente' }}</div>
                                @if(!empty($transaction->contact->mobile))
                                    <div style="font-size: 13px; color: #64748B;"><i class="fas fa-phone-alt"></i> {{ $transaction->contact->mobile }}</div>
                                @endif
                            </div>
                            <div class="col-sm-6" style="text-align: right;">
                                <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748B;">Monto Pendiente:</span>
                                <div style="font-weight: 900; color: #FB4C0A; font-size: 24px;">{{ $total_payable_formatted }}</div>
                                @if($transaction->payment_status == 'paid')
                                    <span class="badge bg-green" style="font-size: 12px; padding: 4px 10px;">@lang('lang_v1.paid')</span>
                                @elseif($transaction->payment_status == 'partial')
                                    <span class="badge bg-orange" style="font-size: 12px; padding: 4px 10px;">@lang('lang_v1.partial')</span>
                                @else
                                    <span class="badge bg-red" style="font-size: 12px; padding: 4px 10px;">@lang('lang_v1.due')</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($transaction->payment_status != 'paid')
                        <h4 style="font-weight: 800; color: #0F172A; margin: 20px 0 14px 0;">
                            <i class="fas fa-credit-card" style="color: #FB4C0A;"></i> Métodos de Pago Disponibles:
                        </h4>

                        <!-- 1. PAGO MÓVIL -->
                        @if(!empty($pos_settings['enable_pagomovil']))
                            <div style="background: #FAF5FF; border: 1px solid #E9D5FF; border-radius: 12px; padding: 14px 18px; margin-bottom: 12px;">
                                <div style="font-weight: 800; color: #6B21A8; font-size: 14px; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-mobile-alt"></i> Pago Móvil (Bolívares)
                                </div>
                                <div class="row" style="font-size: 13px; color: #581C87;">
                                    <div class="col-xs-6 col-sm-3"><strong>Banco:</strong> {{ $pos_settings['pm_bank'] ?? 'N/A' }}</div>
                                    <div class="col-xs-6 col-sm-3"><strong>Teléfono:</strong> {{ $pos_settings['pm_phone'] ?? 'N/A' }}</div>
                                    <div class="col-xs-6 col-sm-3"><strong>RIF / C.I.:</strong> {{ $pos_settings['pm_id_doc'] ?? 'N/A' }}</div>
                                    <div class="col-xs-6 col-sm-3"><strong>Titular:</strong> {{ $pos_settings['pm_holder'] ?? 'N/A' }}</div>
                                </div>
                            </div>
                        @endif

                        <!-- 2. TRANSFERENCIA BANCARIA -->
                        @if(!empty($pos_settings['enable_bank_transfer']))
                            <div style="background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 12px; padding: 14px 18px; margin-bottom: 12px;">
                                <div style="font-weight: 800; color: #166534; font-size: 14px; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-university"></i> Transferencia Bancaria Nacional
                                </div>
                                <div class="row" style="font-size: 13px; color: #14532D;">
                                    <div class="col-sm-4"><strong>Banco:</strong> {{ $pos_settings['bt_bank'] ?? 'N/A' }}</div>
                                    <div class="col-sm-4"><strong>Cuenta:</strong> <code style="color: #052E16; background: #DCFCE7;">{{ $pos_settings['bt_account'] ?? 'N/A' }}</code></div>
                                    <div class="col-sm-4"><strong>Titular:</strong> {{ $pos_settings['bt_holder'] ?? 'N/A' }} ({{ $pos_settings['bt_id_doc'] ?? '' }})</div>
                                </div>
                            </div>
                        @endif

                        <!-- 3. ZELLE -->
                        @if(!empty($pos_settings['enable_zelle']))
                            <div style="background: #EEF2FF; border: 1px solid #C7D2FE; border-radius: 12px; padding: 14px 18px; margin-bottom: 12px;">
                                <div style="font-weight: 800; color: #3730A3; font-size: 14px; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-dollar-sign"></i> Zelle (USD)
                                </div>
                                <div class="row" style="font-size: 13px; color: #1E1B4B;">
                                    <div class="col-sm-6"><strong>Correo Zelle:</strong> <code style="color: #312E81; background: #E0E7FF;">{{ $pos_settings['zelle_email'] ?? 'N/A' }}</code></div>
                                    <div class="col-sm-6"><strong>Titular:</strong> {{ $pos_settings['zelle_holder'] ?? 'N/A' }}</div>
                                </div>
                            </div>
                        @endif

                        <!-- 4. BINANCE PAY -->
                        @if(!empty($pos_settings['enable_binance']))
                            <div style="background: #FEFCE8; border: 1px solid #FEF08A; border-radius: 12px; padding: 14px 18px; margin-bottom: 12px;">
                                <div style="font-weight: 800; color: #854D0E; font-size: 14px; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-coins"></i> Binance Pay / USDT
                                </div>
                                <div class="row" style="font-size: 13px; color: #451A03;">
                                    <div class="col-sm-4"><strong>Binance Pay ID:</strong> <code style="color: #78350F; background: #FEF9C3;">{{ $pos_settings['binance_pay_id'] ?? 'N/A' }}</code></div>
                                    <div class="col-sm-4"><strong>Correo / Usuario:</strong> {{ $pos_settings['binance_email'] ?? 'N/A' }}</div>
                                    <div class="col-sm-4"><strong>Red:</strong> {{ $pos_settings['binance_network'] ?? 'USDT' }}</div>
                                </div>
                            </div>
                        @endif

                        <!-- 5. PAYPAL -->
                        @if(!empty($pos_settings['enable_paypal']))
                            <div style="background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 12px; padding: 14px 18px; margin-bottom: 12px;">
                                <div style="font-weight: 800; color: #1E40AF; font-size: 14px; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                                    <i class="fab fa-paypal"></i> PayPal
                                </div>
                                <div class="row" style="font-size: 13px; color: #172554;">
                                    <div class="col-sm-6"><strong>Correo PayPal:</strong> <code style="color: #1E3A8A; background: #DBEAFE;">{{ $pos_settings['paypal_email'] ?? 'N/A' }}</code></div>
                                    @if(!empty($pos_settings['paypal_me_url']))
                                        <div class="col-sm-6">
                                            <a href="{{ $pos_settings['paypal_me_url'] }}" target="_blank" class="btn btn-xs btn-primary" style="border-radius: 12px;">
                                                <i class="fab fa-paypal"></i> Pagar con PayPal.Me
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if(!empty($pos_settings['payment_instructions']))
                            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 12px 16px; margin: 15px 0; font-size: 13px; color: #475569;">
                                <strong><i class="fas fa-info-circle"></i> Instrucciones:</strong> {{ $pos_settings['payment_instructions'] }}
                            </div>
                        @endif

                        <!-- Formulario de Reporte de Pago -->
                        <div style="background: #FFFFFF; border: 2px solid #FB4C0A; border-radius: 14px; padding: 20px; margin-top: 20px;">
                            <h4 style="margin: 0 0 16px 0; font-weight: 800; color: #0F172A; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-receipt" style="color: #FB4C0A;"></i> Reportar Pago Realizado
                            </h4>

                            <form action="{{ route('confirm_payment', ['id' => $transaction->id]) }}" method="POST">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label style="font-weight: 700; font-size: 13px;">Método Utilizado: *</label>
                                            <select name="gateway" class="form-control" required style="border-radius: 8px; font-weight: 600;">
                                                <option value="pagomovil">Pago Móvil (Bolívares)</option>
                                                <option value="bank_transfer">Transferencia Bancaria Nacional</option>
                                                <option value="zelle">Zelle (USD)</option>
                                                <option value="binance">Binance Pay / USDT</option>
                                                <option value="paypal">PayPal</option>
                                                <option value="offline">Otro / Efectivo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label style="font-weight: 700; font-size: 13px;">N° de Referencia / Comprobante: *</label>
                                            <input type="text" name="reference_no" class="form-control" required placeholder="Ej: 12345678" style="border-radius: 8px;">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label style="font-weight: 700; font-size: 13px;">Banco / Cuenta / Teléfono Emisor:</label>
                                            <input type="text" name="bank_name" class="form-control" placeholder="Ej: Banesco / 0414-XXXXXXX" style="border-radius: 8px;">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="col-sm-12" style="padding: 0;">
                                            <div class="form-group">
                                                <label style="font-weight: 700; font-size: 13px;">Nombre del Titular Emisor:</label>
                                                <input type="text" name="holder_name" class="form-control" placeholder="Ej: Juan Pérez" style="border-radius: 8px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="font-weight: 700; font-size: 13px;">Notas u Observaciones (Opcional):</label>
                                    <textarea name="payment_note" class="form-control" rows="2" placeholder="Comentarios adicionales..." style="border-radius: 8px;"></textarea>
                                </div>

                                <button type="submit" class="btn btn-block btn-primary" style="background: linear-gradient(135deg, #FB4C0A 0%, #E03E00 100%); border: none; border-radius: 25px; font-weight: 800; padding: 12px 20px; font-size: 15px; box-shadow: 0 4px 15px rgba(251, 76, 10, 0.35);">
                                    <i class="fas fa-paper-plane" style="margin-right: 6px;"></i> Enviar Reporte de Pago
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-success text-center" style="border-radius: 12px; margin-top: 15px; font-size: 16px; font-weight: 700;">
                            <i class="fas fa-check-circle"></i> Esta factura se encuentra pagada en su totalidad. ¡Gracias por su compra!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection