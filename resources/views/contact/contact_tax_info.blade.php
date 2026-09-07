<strong><i class="fa fa-info margin-r-5"></i> @lang('contact.tax_no')</strong>
<p class="text-muted">
    {{ $contact->tax_number }}
    @if(!empty($contact->is_tax_withholding_agent))
        <br>
        <span class="badge" style="background-color: #0284C7; color: white; padding: 4px 8px; font-size: 11px; font-weight: 700; border-radius: 4px; display: inline-block; margin-top: 4px;">
            <i class="fas fa-university"></i> Agente de Retención SENIAT ({{ (int)($contact->tax_withholding_rate ?? 75) }}%)
        </span>
    @endif
</p>
@if($contact->pay_term_type)
    <strong><i class="fa fa-calendar margin-r-5"></i> @lang('contact.pay_term_period')</strong>
    <p class="text-muted">
        {{ __('lang_v1.' . $contact->pay_term_type) }}
    </p>
@endif
@if($contact->pay_term_number)
    <strong><i class="fas fa fa-handshake margin-r-5"></i> @lang('contact.pay_term')</strong>
    <p class="text-muted">
        {{ $contact->pay_term_number }}
    </p>
@endif