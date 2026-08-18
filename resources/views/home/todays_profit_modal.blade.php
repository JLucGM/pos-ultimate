<div class="modal fade" id="todays_profit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 900px;">
    <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
      <div class="modal-header" style="background: #0B0F1D; color: #FFFFFF; padding: 18px 24px; border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 12px;">
          <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(251, 76, 10, 0.2); display: flex; align-items: center; justify-content: center; color: #FB4C0A; font-size: 16px;">
            <i class="fas fa-chart-pie"></i>
          </div>
          <div>
            <h4 class="modal-title" id="myModalLabel" style="margin: 0; font-weight: 800; font-size: 18px; color: #FFFFFF;">@lang('home.todays_profit')</h4>
            <small style="color: #94A3B8; font-size: 12px;">Resumen financiero y margen de rendimiento</small>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFFFFF; opacity: 0.8; font-size: 24px; font-weight: 400;"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" style="padding: 24px; background: #F8FAFC;">
        <input type="hidden" id="modal_today" value="{{\Carbon::now()->format('Y-m-d')}}">
        <div class="row">
          <div id="todays_profit" class="col-md-12">
          </div>
        </div>
      </div>
      <div class="modal-footer" style="background: #FFFFFF; border-top: 1px solid #E2E8F0; padding: 14px 24px;">
        <button type="button" class="btn btn-default" style="border-radius: 10px; font-weight: 700; padding: 8px 20px; background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569;" data-dismiss="modal">@lang('messages.close')</button>
      </div>
    </div>
  </div>
</div>