@php
    $is_mobile = isMobile();
@endphp

<div class="pos-form-actions no-print">
    <!-- 1. Left: Real-time Dual Currency Payable Display -->
    <div class="audaz-pos-bottom-total" style="display: flex; align-items: center; gap: 14px; flex-shrink: 0;">
        <input type="hidden" name="final_total" id="final_total_input" value="0.00">
        <input type="hidden" id="bcv_exchange_rate_val" value="{{ $bcv_rate ?? 1 }}">
        <div>
            <div class="label" style="font-size: 10.5px; font-weight: 700; text-transform: uppercase; color: #94A3B8; letter-spacing: 0.04em;">@lang('sale.total_payable')</div>
            <div class="amount" style="display: flex; align-items: baseline; gap: 6px;">
                <span id="total_payable" class="number" style="font-size: 22px; font-weight: 900; color: #10B981;">0.00</span>
                <span class="base_currency_symbol" style="font-size: 13px; font-weight: 800; color: #94A3B8;">{{ $base_currency->code ?? 'USD' }}</span>
            </div>
        </div>
        <div style="border-left: 1px dashed rgba(255,255,255,0.2); padding-left: 14px;" id="pos_secondary_currency_box">
            <div class="label" style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: #38BDF8; letter-spacing: 0.04em;">
                <i class="fas fa-university"></i> Tasa BCV
            </div>
            <div class="amount" style="display: flex; align-items: baseline; gap: 4px;">
                <span id="total_payable_secondary" class="number" style="font-size: 18px; font-weight: 900; color: #38BDF8; font-family: ui-monospace, monospace;">Bs. 0,00</span>
            </div>
        </div>
    </div>

    <!-- 2. Center-Left: Secondary Options (Dropup & Recent Transactions) -->
    <div class="tw-hidden xl:tw-flex tw-items-center tw-gap-2">
        @if (!isset($pos_settings['hide_recent_trans']) || $pos_settings['hide_recent_trans'] == 0)
            <button type="button" class="audaz-pos-sub-action-btn" data-toggle="modal" data-target="#recent_transactions_modal" id="recent-transactions" title="@lang('lang_v1.recent_transactions')" style="background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.15); color: #E2E8F0;">
                <i class="fas fa-history tw-text-cyan-400"></i> <span class="tw-text-xs tw-font-bold">@lang('lang_v1.recent_transactions')</span>
            </button>
        @endif

        <div class="btn-group dropup" id="pos_auxiliary_actions_dropdown">
            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" 
                style="background: rgba(255,255,255,0.08) !important; border: 1px solid rgba(255,255,255,0.18) !important; color: #E2E8F0 !important; border-radius: 10px !important; padding: 7px 12px !important; font-size: 12px !important; font-weight: 700 !important; display: flex !important; align-items: center !important; gap: 6px !important;">
                <i class="fas fa-ellipsis-h tw-text-amber-400"></i>
                <span>Opciones</span>
                <i class="fas fa-chevron-up tw-text-[10px] tw-text-slate-400"></i>
            </button>
            <ul class="dropdown-menu" style="background: #0B0F1D; border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 6px; box-shadow: 0 15px 35px rgba(0,0,0,0.5); min-width: 200px; margin-bottom: 8px;">
                @if (!Gate::check('disable_quotation') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                    <li>
                        <button type="button" id="pos-quotation" class="tw-w-full tw-text-left tw-bg-transparent hover:tw-bg-slate-800 tw-border-0 tw-text-slate-200 hover:tw-text-[#FB4C0A] tw-py-2 tw-px-3 tw-rounded-lg tw-text-xs tw-font-semibold tw-flex tw-items-center tw-gap-2.5 tw-transition-all" @if (!empty($only_payment)) disabled @endif>
                            <i class="fas fa-file-invoice-dollar tw-text-amber-400 tw-w-4"></i> @lang('lang_v1.quotation')
                        </button>
                    </li>
                @endif

                @if (!Gate::check('disable_draft') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                    <li class="@if ($pos_settings['disable_draft'] != 0) hide @endif">
                        <button type="button" id="pos-draft" class="tw-w-full tw-text-left tw-bg-transparent hover:tw-bg-slate-800 tw-border-0 tw-text-slate-200 hover:tw-text-[#FB4C0A] tw-py-2 tw-px-3 tw-rounded-lg tw-text-xs tw-font-semibold tw-flex tw-items-center tw-gap-2.5 tw-transition-all" @if (!empty($only_payment)) disabled @endif>
                            <i class="fas fa-file-alt tw-text-blue-400 tw-w-4"></i> @lang('sale.draft')
                        </button>
                    </li>
                @endif

                @if (!Gate::check('disable_suspend_sale') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                    @if (empty($pos_settings['disable_suspend']))
                        <li>
                            <button type="button" class="pos-express-finalize tw-w-full tw-text-left tw-bg-transparent hover:tw-bg-slate-800 tw-border-0 tw-text-slate-200 hover:tw-text-[#FB4C0A] tw-py-2 tw-px-3 tw-rounded-lg tw-text-xs tw-font-semibold tw-flex tw-items-center tw-gap-2.5 tw-transition-all" data-pay_method="suspend" title="@lang('lang_v1.tooltip_suspend')" @if (!empty($only_payment)) disabled @endif>
                                <i class="fas fa-pause tw-text-rose-400 tw-w-4"></i> @lang('lang_v1.suspend')
                            </button>
                        </li>
                    @endif
                @endif

                @if (!Gate::check('disable_credit_sale') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
                    @if (empty($pos_settings['disable_credit_sale_button']))
                        <input type="hidden" name="is_credit_sale" value="0" id="is_credit_sale">
                        <li>
                            <button type="button" class="pos-express-finalize tw-w-full tw-text-left tw-bg-transparent hover:tw-bg-slate-800 tw-border-0 tw-text-slate-200 hover:tw-text-[#FB4C0A] tw-py-2 tw-px-3 tw-rounded-lg tw-text-xs tw-font-semibold tw-flex tw-items-center tw-gap-2.5 tw-transition-all" data-pay_method="credit_sale" title="@lang('lang_v1.tooltip_credit_sale')" @if (!empty($only_payment)) disabled @endif>
                                <i class="fas fa-user-clock tw-text-indigo-400 tw-w-4"></i> @lang('lang_v1.credit_sale')
                            </button>
                        </li>
                    @endif
                @endif

                <li role="separator" class="divider" style="background: rgba(255,255,255,0.1); margin: 6px 0;"></li>

                @if (empty($edit))
                    <li>
                        <button type="button" id="pos-cancel" class="tw-w-full tw-text-left tw-bg-transparent hover:tw-bg-rose-500/20 tw-border-0 tw-text-rose-400 tw-py-2 tw-px-3 tw-rounded-lg tw-text-xs tw-font-semibold tw-flex tw-items-center tw-gap-2.5 tw-transition-all" title="@lang('sale.cancel')">
                            <i class="fas fa-times-circle tw-w-4"></i> @lang('sale.cancel')
                        </button>
                    </li>
                @else
                    <li>
                        <button type="button" id="pos-delete" class="tw-w-full tw-text-left tw-bg-transparent hover:tw-bg-rose-500/20 tw-border-0 tw-text-rose-400 tw-py-2 tw-px-3 tw-rounded-lg tw-text-xs tw-font-semibold tw-flex tw-items-center tw-gap-2.5 tw-transition-all" @if (!empty($only_payment)) disabled @endif>
                            <i class="fas fa-trash-alt tw-w-4"></i> @lang('messages.delete')
                        </button>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <!-- 3. Center-Right: Dynamic Direct Payment Method Buttons (Efectivo, Tarjeta, Pago Móvil, Biopago) -->
    <div class="tw-flex tw-items-center tw-gap-2 tw-overflow-x-auto no-scrollbar">
        <!-- 💵 Efectivo -->
        @if (!Gate::check('disable_express_checkout') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
            <button type="button" class="pos-express-finalize audaz-quick-pay-btn audaz-quick-pay-cash no-print @if ($pos_settings['disable_express_checkout'] != 0 || !array_key_exists('cash', $payment_types)) hide @endif" data-pay_method="cash" title="Pagar en Efectivo ($ o Bs)">
                <i class="fas fa-money-bill-wave"></i> <span>Efectivo</span>
            </button>
        @endif

        <!-- 💳 Tarjeta / Punto -->
        @if (!Gate::check('disable_card') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
            <button type="button" class="pos-express-finalize audaz-quick-pay-btn audaz-quick-pay-card no-print @if (!array_key_exists('card', $payment_types)) hide @endif" data-pay_method="card" title="Pagar con Tarjeta de Débito / Crédito">
                <i class="fas fa-credit-card"></i> <span>Tarjeta</span>
            </button>
        @endif

        <!-- 📱 Pago Móvil -->
        <button type="button" class="pos-express-finalize audaz-quick-pay-btn audaz-quick-pay-mobile no-print" data-pay_method="bank_transfer" title="Pagar con Pago Móvil / Transferencia">
            <i class="fas fa-mobile-alt"></i> <span>Pago Móvil</span>
        </button>

        <!-- 🧬 Biopago -->
        <button type="button" class="pos-express-finalize audaz-quick-pay-btn audaz-quick-pay-bio no-print" data-pay_method="other" title="Pagar con Biopago BDV">
            <i class="fas fa-fingerprint"></i> <span>Biopago</span>
        </button>
    </div>

    <!-- 4. Right: Primary Multi-Pay / Finalize Button (F4) -->
    <div class="tw-flex tw-items-center tw-gap-2 tw-flex-shrink-0">
        @if (!Gate::check('disable_pay_checkout') || auth()->user()->can('superadmin') || auth()->user()->can('admin'))
            <button type="button" class="no-print @if ($pos_settings['disable_pay_checkout'] != 0) hide @endif" id="pos-finalize" title="@lang('lang_v1.tooltip_checkout_multi_pay')"
                style="background: linear-gradient(135deg, #FB4C0A 0%, #E03E00 100%); color: #FFFFFF; border: none; border-radius: 12px; padding: 9px 22px; font-size: 13.5px; font-weight: 900; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 18px rgba(251,76,10,0.45); transition: all 0.2s ease; white-space: nowrap;">
                <i class="fas fa-cash-register"></i> <span>@lang('lang_v1.checkout_multi_pay')</span>
            </button>
        @endif
    </div>
</div>

@if (isset($transaction))
    @include('sale_pos.partials.edit_discount_modal', [
        'sales_discount' => $transaction->discount_amount,
        'discount_type' => $transaction->discount_type,
        'rp_redeemed' => $transaction->rp_redeemed,
        'rp_redeemed_amount' => $transaction->rp_redeemed_amount,
        'max_available' => !empty($redeem_details['points']) ? $redeem_details['points'] : 0,
    ])
@else
    @include('sale_pos.partials.edit_discount_modal', [
        'sales_discount' => $business_details->default_sales_discount,
        'discount_type' => 'percentage',
        'rp_redeemed' => 0,
        'rp_redeemed_amount' => 0,
        'max_available' => 0,
    ])
@endif

@if (isset($transaction))
    @include('sale_pos.partials.edit_order_tax_modal', ['selected_tax' => $transaction->tax_id])
@else
    @include('sale_pos.partials.edit_order_tax_modal', [
        'selected_tax' => $business_details->default_sales_tax,
    ])
@endif

@include('sale_pos.partials.edit_shipping_modal')
