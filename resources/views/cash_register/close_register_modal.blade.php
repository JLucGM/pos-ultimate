<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: 1px solid #E2E8F0; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
    {!! Form::open(['url' => action([\App\Http\Controllers\CashRegisterController::class, 'postCloseRegister']), 'method' => 'post' ]) !!}

    {!! Form::hidden('user_id', $register_details->user_id); !!}
    <div class="modal-header" style="background: #0B0F1D; color: #FFFFFF; padding: 18px 24px; border-bottom: 1px solid rgba(255,255,255,0.1);">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFFFFF; opacity: 0.8; font-size: 24px;"><span aria-hidden="true">&times;</span></button>
      <h3 class="modal-title" style="font-size: 17px; font-weight: 800; margin: 0; color: #FFFFFF; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-cash-register tw-text-[#FB4C0A]"></i>
        @lang( 'cash_register.current_register' )
        <small style="color: #94A3B8; font-size: 13px; font-weight: 500;">
          ({{ \Carbon::parse($register_details->open_time)->format('d/m/Y h:i A') }} - {{ \Carbon::now()->format('d/m/Y h:i A') }})
        </small>
      </h3>
    </div>

    <div class="modal-body" style="padding: 24px; background: #FAFAFC;">
        @include('cash_register.payment_details')

      <div class="row" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 18px; margin: 0 0 16px 0;">
        <div class="col-sm-6">
          <div class="form-group" style="margin-bottom: 0;">
            <label style="font-size: 13px; font-weight: 700; color: #0F172A;">
              <i class="fas fa-money-bill-wave tw-text-emerald-500 tw-mr-1"></i> @lang( 'cash_register.total_cash' ) a Entregar:*
            </label>
            {!! Form::text('closing_amount', @num_format($register_details->cash_in_hand + $register_details->total_cash - $register_details->total_cash_refund - $register_details->total_cash_expense), ['class' => 'form-control input_number', 'required', 'placeholder' => __( 'cash_register.total_cash' ), 'style' => 'height: 44px; font-size: 16px; font-weight: 800; border-color: #10B981; color: #065F46;' ]); !!}
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group" style="margin-bottom: 0;">
            <label style="font-size: 13px; font-weight: 700; color: #0F172A;">
              <i class="fas fa-receipt tw-text-blue-500 tw-mr-1"></i> @lang( 'cash_register.total_card_slips' ):*
            </label>
            {!! Form::number('total_card_slips', $register_details->total_card_slips, ['class' => 'form-control', 'required', 'placeholder' => __( 'cash_register.total_card_slips' ), 'min' => 0, 'style' => 'height: 44px; font-size: 15px; font-weight: 700;' ]); !!}
          </div>
        </div> 
        {!! Form::hidden('total_cheques', $register_details->total_cheques ?? 0); !!}
      </div>

      @if(!empty($pos_settings['cash_denominations']))
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
              @foreach(explode(',', $pos_settings['cash_denominations']) as $dnm)
              <tr>
                <td class="text-right" style="font-weight: 700; color: #334155;">{{$dnm}}</td>
                <td class="text-center" style="color: #94A3B8;">X</td>
                <td>{!! Form::number("denominations[$dnm]", null, ['class' => 'form-control cash_denomination input-sm', 'min' => 0, 'data-denomination' => $dnm, 'style' => 'width: 110px; margin:auto; border-radius: 6px; text-align: center;' ]); !!}</td>
                <td class="text-center" style="color: #94A3B8;">=</td>
                <td class="text-left" style="font-weight: 700; color: #0F172A;">
                  <span class="denomination_subtotal">0</span>
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr style="background: #F8FAFC;">
                <th colspan="4" class="text-center" style="font-size: 12px; font-weight: 800;">@lang('sale.total')</th>
                <td style="font-size: 14px; font-weight: 800; color: #059669;"><span class="denomination_total">0</span></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      @endif

      <div class="row" style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 18px; margin: 0 0 16px 0;">
        <div class="col-sm-12">
          <div class="form-group" style="margin-bottom: 0;">
            <label style="font-size: 13px; font-weight: 700; color: #0F172A;">
              <i class="fas fa-sticky-note tw-text-slate-500 tw-mr-1"></i> @lang( 'cash_register.closing_note' ):
            </label>
            {!! Form::textarea('closing_note', null, ['class' => 'form-control', 'placeholder' => __( 'cash_register.closing_note' ), 'rows' => 2, 'style' => 'border-radius: 8px;' ]); !!}
          </div>
        </div>
      </div>

      <div class="row" style="color: #64748B; font-size: 12px; padding: 0 8px;">
        <div class="col-xs-12">
          <i class="fas fa-user tw-mr-1"></i> <b>@lang('report.user'):</b> {{ $register_details->user_name}} &nbsp;|&nbsp;
          <i class="fas fa-store tw-mr-1"></i> <b>@lang('business.business_location'):</b> {{ $register_details->location_name}}
        </div>
      </div>
    </div>

    <div class="modal-footer" style="background: #FFFFFF; border-top: 1px solid #E2E8F0; padding: 16px 24px; display: flex; justify-content: flex-end; gap: 10px;">
      <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 10px; font-weight: 700; padding: 9px 20px;">@lang( 'messages.cancel' )</button>
      <button type="submit" class="btn btn-primary" style="border-radius: 10px; font-weight: 800; padding: 9px 24px; background: linear-gradient(135deg, #FB4C0A 0%, #E03E00 100%); border: none; box-shadow: 0 4px 14px rgba(251,76,10,0.35);">
        <i class="fas fa-lock tw-mr-1"></i> @lang( 'cash_register.close_register' )
      </button>
    </div>
    {!! Form::close() !!}
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->