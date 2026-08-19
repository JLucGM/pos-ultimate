<!-- Modal Status Change -->
<div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
     {!! Form::open(['url' => action([\Modules\Superadmin\Http\Controllers\SuperadminSubscriptionsController::class, 'update'],$subscription->id), 'method' => 'PUT', 'id' => 'status_change_form']) !!}

      <div class="modal-header" style="background: #0B0F1D; color: #FFFFFF; padding: 16px 20px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFF;"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" style="font-weight: 800; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-check-double text-warning"></i> @lang( "superadmin::lang.subscription_status")
        </h4>
      </div>

      <div class="modal-body" style="padding: 20px;">
            @php
                $offline_info = $subscription->package_details['offline_payment_info'] ?? null;
            @endphp

            @if(!empty($offline_info))
                <!-- Tarjeta con Datos del Reporte de Pago Offline -->
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-left: 4px solid #FB4C0A; border-radius: 10px; padding: 14px 16px; margin-bottom: 18px;">
                    <div style="font-weight: 800; color: #0F172A; margin-bottom: 10px; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-receipt text-primary" style="color: #FB4C0A;"></i> Datos del Pago Reportado por el Cliente:
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 13px; color: #334155;">
                        <div><strong>Método:</strong> {{ $offline_info['payment_method'] ?? 'Transferencia/Pago Móvil' }}</div>
                        <div><strong>Referencia:</strong> <span class="badge bg-purple">{{ $offline_info['reference_no'] ?? $subscription->payment_transaction_id }}</span></div>
                        <div><strong>Monto Reportado:</strong> <strong style="color: #10B981;">{{ $offline_info['amount_paid'] ?? '' }} {{ $offline_info['currency'] ?? '' }}</strong></div>
                        <div><strong>Fecha de Pago:</strong> {{ $offline_info['paid_on'] ?? '' }}</div>
                        @if(!empty($offline_info['bank_name']))
                            <div><strong>Banco Emisor:</strong> {{ $offline_info['bank_name'] }}</div>
                        @endif
                        @if(!empty($offline_info['phone_number']))
                            <div><strong>Teléfono:</strong> {{ $offline_info['phone_number'] }}</div>
                        @endif
                        @if(!empty($offline_info['holder_name']))
                            <div><strong>Titular Emisor:</strong> {{ $offline_info['holder_name'] }}</div>
                        @endif
                        @if(!empty($offline_info['email_account']))
                            <div><strong>Cuenta/Email:</strong> {{ $offline_info['email_account'] }}</div>
                        @endif
                        @if(!empty($offline_info['payment_note']))
                            <div style="grid-column: span 2; margin-top: 4px; padding-top: 6px; border-top: 1px dashed #CBD5E1;">
                                <strong>Observaciones:</strong> <em>{{ $offline_info['payment_note'] }}</em>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="form-group">
                {!! Form::label('status', __( "superadmin::lang.status") . ':*') !!}
                {!! Form::select('status', $status, $subscription->status, ['class' => 'form-control', 'style' => 'border-radius: 8px; font-weight: 700;']); !!}
            </div>

            <div class="form-group">
                {!! Form::label('payment_transaction_id', __("superadmin::lang.payment_transaction_id") . ':') !!}
                {!! Form::text('payment_transaction_id', $subscription->payment_transaction_id, ['class' => 'form-control', 'style' => 'border-radius: 8px;']);!!}
            </div>
      </div>

      <div class="modal-footer" style="background: #F8FAFC; border-top: 1px solid #E2E8F0;">
        <button type="submit" class="btn btn-primary" style="border-radius: 20px; font-weight: 700; padding: 6px 20px;">
            <i class="fas fa-save"></i> @lang( "superadmin::lang.update")
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 20px; font-weight: 600;">
            @lang( "superadmin::lang.close")
        </button>
      </div>
      {!! Form::close() !!}
    </div>
</div>
