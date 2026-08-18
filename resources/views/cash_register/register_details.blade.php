<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: 1px solid #E2E8F0; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
    <div class="modal-header mini_print" style="background: #0B0F1D; color: #FFFFFF; padding: 18px 24px; border-bottom: 1px solid rgba(255,255,255,0.1);">
      <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close" style="color: #FFFFFF; opacity: 0.8; font-size: 24px;"><span aria-hidden="true">&times;</span></button>
      <h3 class="modal-title" style="font-size: 17px; font-weight: 800; margin: 0; color: #FFFFFF; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-file-invoice-dollar tw-text-[#FB4C0A]"></i>
        @lang( 'cash_register.register_details' )
        <small style="color: #94A3B8; font-size: 13px; font-weight: 500;">
          ({{ \Carbon::parse($register_details->open_time)->format('d/m/Y h:i A') }} - {{ \Carbon::parse($close_time)->format('d/m/Y h:i A') }})
        </small>
      </h3>
    </div>

    <div class="modal-body" style="padding: 24px; background: #FAFAFC;">
      @include('cash_register.payment_details')

      @if(!empty($register_details->denominations))
        @php
          $total = 0;
        @endphp
        <div class="row" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 18px; margin: 0 0 16px 0;">
          <div class="col-md-12">
            <h4 style="font-size: 14px; font-weight: 800; color: #0F172A; margin-top: 0; margin-bottom: 12px;">
              <i class="fas fa-coins tw-text-amber-500 tw-mr-1"></i> @lang( 'lang_v1.cash_denominations' )
            </h4>
            <table class="table table-condensed" style="margin: 0;">
              <thead>
                <tr style="background: #F8FAFC;">
                  <th width="25%" class="text-right" style="font-size: 11px; text-transform: uppercase;">@lang('lang_v1.denomination')</th>
                  <th width="10%" class="text-center">&nbsp;</th>
                  <th width="30%" class="text-center" style="font-size: 11px; text-transform: uppercase;">@lang('lang_v1.count')</th>
                  <th width="10%" class="text-center">&nbsp;</th>
                  <th width="25%" class="text-left" style="font-size: 11px; text-transform: uppercase;">@lang('sale.subtotal')</th>
                </tr>
              </thead>
              <tbody>
                @foreach($register_details->denominations as $key => $value)
                <tr>
                  <td class="text-right" style="font-weight: 700; color: #334155;">{{$key}}</td>
                  <td class="text-center" style="color: #94A3B8;">X</td>
                  <td class="text-center" style="font-weight: 600;">{{$value ?? 0}}</td>
                  <td class="text-center" style="color: #94A3B8;">=</td>
                  <td class="text-left" style="font-weight: 700; color: #0F172A;">
                    @format_currency($key * $value)
                  </td>
                </tr>
                @php
                  $total += ($key * $value);
                @endphp
                @endforeach
              </tbody>
              <tfoot>
                <tr style="background: #F8FAFC;">
                  <th colspan="4" class="text-center" style="font-size: 12px; font-weight: 800;">@lang('sale.total')</th>
                  <td style="font-size: 14px; font-weight: 800; color: #059669;">@format_currency($total)</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      @endif
      
      <div class="row" style="color: #64748B; font-size: 12px; padding: 0 8px;">
        <div class="col-xs-12">
          <i class="fas fa-user tw-mr-1"></i> <b>@lang('report.user'):</b> {{ $register_details->user_name}} &nbsp;|&nbsp;
          <i class="fas fa-store tw-mr-1"></i> <b>@lang('business.business_location'):</b> {{ $register_details->location_name}}
        </div>
        @if(!empty($register_details->closing_note))
          <div class="col-xs-12" style="margin-top: 6px;">
            <strong>@lang('cash_register.closing_note'):</strong> {{$register_details->closing_note}}
          </div>
        @endif
      </div>
    </div>

    <div class="modal-footer" style="background: #FFFFFF; border-top: 1px solid #E2E8F0; padding: 16px 24px; display: flex; justify-content: flex-end; gap: 10px;">
      <button type="button" class="btn btn-primary no-print print-mini-button" aria-label="Print" style="border-radius: 10px; font-weight: 700; padding: 9px 18px;">
        <i class="fa fa-print tw-mr-1"></i> @lang('messages.print_mini')
      </button>
      <button type="button" class="btn btn-default no-print" aria-label="Print" onclick="$(this).closest('div.modal').printThis();" style="border-radius: 10px; font-weight: 700; padding: 9px 18px;">
        <i class="fa fa-print tw-mr-1"></i> @lang( 'messages.print_detailed' )
      </button>
      <button type="button" class="btn btn-default no-print" data-dismiss="modal" style="border-radius: 10px; font-weight: 700; padding: 9px 18px;">
        @lang( 'messages.cancel' )
      </button>
    </div>

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<style type="text/css">
  @media print {
    .modal {
        position: absolute;
        left: 0;
        top: 0;
        margin: 0;
        padding: 0;
        overflow: visible!important;
    }
}
</style>