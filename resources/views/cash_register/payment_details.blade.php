<div class="row mini_print">
  <div class="col-sm-12">
    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; overflow: hidden; margin-bottom: 16px;">
      <table class="table table-condensed" style="margin: 0;">
        <thead>
          <tr style="background: #F1F5F9;">
            <th style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748B; padding: 10px 14px;">@lang('lang_v1.payment_method')</th>
            <th style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #059669; padding: 10px 14px;">@lang('sale.sale') (Ingresos)</th>
            <th style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #DC2626; padding: 10px 14px;">@lang('lang_v1.expense') (Egresos)</th>
          </tr>
        </thead>
        <tbody>
          <!-- 1. Apertura de Caja -->
          <tr>
            <td style="font-weight: 600; color: #334155;">
              <i class="fas fa-wallet tw-text-emerald-500 tw-mr-1"></i> @lang('cash_register.cash_in_hand') (Monto Inicial):
            </td>
            <td>
              <span class="display_currency" data-currency_symbol="true" style="font-weight: 700;">{{ $register_details->cash_in_hand }}</span>
            </td>
            <td style="color: #94A3B8;">--</td>
          </tr>

          <!-- 2. Efectivo (Ventas y Gastos) -->
          <tr>
            <td style="font-weight: 600; color: #334155;">
              <i class="fas fa-money-bill-wave tw-text-emerald-600 tw-mr-1"></i> @lang('cash_register.cash_payment'):
            </td>
            <td>
              <span class="display_currency" data-currency_symbol="true" style="font-weight: 700; color: #059669;">{{ $register_details->total_cash }}</span>
            </td>
            <td>
              <span class="display_currency" data-currency_symbol="true" style="font-weight: 700; color: #DC2626;">{{ $register_details->total_cash_expense }}</span>
            </td>
          </tr>

          <!-- 3. Tarjeta / Débito -->
          @if($register_details->total_card > 0 || $register_details->total_card_expense > 0 || array_key_exists('card', $payment_types))
          <tr>
            <td style="font-weight: 600; color: #334155;">
              <i class="fas fa-credit-card tw-text-blue-500 tw-mr-1"></i> {{ !empty($payment_types['card']) ? $payment_types['card'] : __('cash_register.card_payment') }}:
            </td>
            <td>
              <span class="display_currency" data-currency_symbol="true" style="font-weight: 700; color: #059669;">{{ $register_details->total_card }}</span>
            </td>
            <td>
              <span class="display_currency" data-currency_symbol="true" style="font-weight: 700; color: #DC2626;">{{ $register_details->total_card_expense }}</span>
            </td>
          </tr>
          @endif

          <!-- 4. Transferencia Bancaria -->
          @if($register_details->total_bank_transfer > 0 || $register_details->total_bank_transfer_expense > 0 || array_key_exists('bank_transfer', $payment_types))
          <tr>
            <td style="font-weight: 600; color: #334155;">
              <i class="fas fa-exchange-alt tw-text-indigo-500 tw-mr-1"></i> @lang('cash_register.bank_transfer'):
            </td>
            <td>
              <span class="display_currency" data-currency_symbol="true" style="font-weight: 700; color: #059669;">{{ $register_details->total_bank_transfer }}</span>
            </td>
            <td>
              <span class="display_currency" data-currency_symbol="true" style="font-weight: 700; color: #DC2626;">{{ $register_details->total_bank_transfer_expense }}</span>
            </td>
          </tr>
          @endif

          <!-- 5. Métodos Personalizados (Pago Móvil, Biopago, etc.) - Solo si están configurados o tienen saldo -->
          @for($i = 1; $i <= 7; $i++)
            @php
              $custom_key = 'custom_pay_' . $i;
              $custom_total = $register_details->{'total_custom_pay_' . $i};
              $custom_expense = $register_details->{'total_custom_pay_' . $i . '_expense'};
              $has_name = array_key_exists($custom_key, $payment_types) && !str_contains($payment_types[$custom_key], 'Campo personalizado') && !str_contains($payment_types[$custom_key], 'Custom Payment');
            @endphp
            @if(array_key_exists($custom_key, $payment_types) && ($custom_total > 0 || $custom_expense > 0 || $has_name))
              <tr>
                <td style="font-weight: 600; color: #334155;">
                  <i class="fas fa-coins tw-text-[#FB4C0A] tw-mr-1"></i> {{$payment_types[$custom_key]}}:
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true" style="font-weight: 700; color: #059669;">{{ $custom_total }}</span>
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true" style="font-weight: 700; color: #DC2626;">{{ $custom_expense }}</span>
                </td>
              </tr>
            @endif
          @endfor

          <!-- 6. Anticipos (Solo si se usó) -->
          @if($register_details->total_advance > 0 || $register_details->total_advance_expense > 0)
          <tr>
            <td style="font-weight: 600; color: #334155;">
              <i class="fas fa-hand-holding-usd tw-text-purple-500 tw-mr-1"></i> @lang('lang_v1.advance_payment'):
            </td>
            <td>
              <span class="display_currency" data-currency_symbol="true" style="font-weight: 700; color: #059669;">{{ $register_details->total_advance }}</span>
            </td>
            <td>
              <span class="display_currency" data-currency_symbol="true" style="font-weight: 700; color: #DC2626;">{{ $register_details->total_advance_expense }}</span>
            </td>
          </tr>
          @endif

          <!-- 7. Cheques (Solo si se usó) -->
          @if($register_details->total_cheque > 0 || $register_details->total_cheque_expense > 0)
          <tr>
            <td style="font-weight: 600; color: #334155;">
              <i class="fas fa-money-check-alt tw-text-amber-500 tw-mr-1"></i> @lang('cash_register.checque_payment'):
            </td>
            <td>
              <span class="display_currency" data-currency_symbol="true" style="font-weight: 700; color: #059669;">{{ $register_details->total_cheque }}</span>
            </td>
            <td>
              <span class="display_currency" data-currency_symbol="true" style="font-weight: 700; color: #DC2626;">{{ $register_details->total_cheque_expense }}</span>
            </td>
          </tr>
          @endif

          <!-- 8. Otros Pagos (Solo si se usó) -->
          @if($register_details->total_other > 0 || $register_details->total_other_expense > 0)
          <tr>
            <td style="font-weight: 600; color: #334155;">
              <i class="fas fa-ellipsis-h tw-text-slate-500 tw-mr-1"></i> @lang('cash_register.other_payments'):
            </td>
            <td>
              <span class="display_currency" data-currency_symbol="true" style="font-weight: 700; color: #059669;">{{ $register_details->total_other }}</span>
            </td>
            <td>
              <span class="display_currency" data-currency_symbol="true" style="font-weight: 700; color: #DC2626;">{{ $register_details->total_other_expense }}</span>
            </td>
          </tr>
          @endif

        </tbody>
      </table>
    </div>

    <!-- Resumen de Totales y Balance de Caja -->
    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 12px; padding: 14px 18px; margin-bottom: 16px;">
      <table class="table table-condensed" style="margin: 0;">
        <tr>
          <td style="font-size: 13px; font-weight: 600; color: #475569;">
            @lang('cash_register.total_sales'):
          </td>
          <td style="text-align: right;">
            <span class="display_currency" data-currency_symbol="true" style="font-size: 15px; font-weight: 800; color: #0F172A;">{{ $details['transaction_details']->total_sales }}</span>
          </td>
        </tr>

        @if($register_details->total_refund > 0)
        <tr class="danger">
          <th style="font-size: 13px; font-weight: 600; color: #DC2626;">
            @lang('cash_register.total_refund'):
          </th>
          <td style="text-align: right;">
            <b><span class="display_currency" data-currency_symbol="true" style="font-size: 14px; color: #DC2626;">{{ $register_details->total_refund }}</span></b>
          </td>
        </tr>
        @endif

        @if($register_details->total_expense > 0)
        <tr class="danger">
          <th style="font-size: 13px; font-weight: 600; color: #DC2626;">
            @lang('report.total_expense'):
          </th>
          <td style="text-align: right;">
            <b><span class="display_currency" data-currency_symbol="true" style="font-size: 14px; color: #DC2626;">{{ $register_details->total_expense }}</span></b>
          </td>
        </tr>
        @endif

        <tr style="border-top: 2px solid #E2E8F0;">
          <th style="font-size: 14px; font-weight: 800; color: #059669; padding-top: 8px;">
            <i class="fas fa-cash-register tw-mr-1"></i> Total Efectivo en Caja:
          </th>
          <td style="text-align: right; padding-top: 8px;">
            <b><span class="display_currency" data-currency_symbol="true" style="font-size: 18px; font-weight: 900; color: #059669;">{{ $register_details->cash_in_hand + $register_details->total_cash - $register_details->total_cash_refund - $register_details->total_cash_expense }}</span></b>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>

@include('cash_register.register_product_details')