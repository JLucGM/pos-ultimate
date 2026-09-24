@extends('layouts.app')
@section('title', __('expense.edit_expense'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('expense.edit_expense')</h1>
</section>

<!-- Main content -->
<section class="content">
  {!! Form::open(['url' => action([\App\Http\Controllers\ExpenseController::class, 'update'], [$expense->id]), 'method' => 'PUT', 'id' => 'add_expense_form', 'files' => true ]) !!}
  <div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('location_id', __('purchase.business_location').':*') !!}
            {!! Form::select('location_id', $business_locations, $expense->location_id, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required']); !!}
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('expense_category_id', __('expense.expense_category').':') !!}
            {!! Form::select('expense_category_id', $expense_categories, $expense->expense_category_id, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]); !!}
          </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('expense_sub_category_id', __('product.sub_category')  . ':') !!}
                  {!! Form::select('expense_sub_category_id', $sub_categories, $expense->expense_sub_category_id, ['placeholder' => __('messages.please_select'), 'class' => 'form-control select2']); !!}
            </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('ref_no', __('purchase.ref_no').':*') !!}
            {!! Form::text('ref_no', $expense->ref_no, ['class' => 'form-control', 'required']); !!}
            <p class="help-block">
                @lang('lang_v1.leave_empty_to_autogenerate')
            </p>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('transaction_date', __('messages.date') . ':*') !!}
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </span>
              {!! Form::text('transaction_date', @format_datetime($expense->transaction_date), ['class' => 'form-control', 'readonly', 'required', 'id' => 'expense_transaction_date']); !!}
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('expense_for', __('expense.expense_for').':') !!} @show_tooltip(__('tooltip.expense_for'))
            {!! Form::select('expense_for', $users, $expense->expense_for, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]); !!}
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('contact_id', __('lang_v1.expense_for_contact').':') !!} 
            {!! Form::select('contact_id', $contacts, $expense->contact_id, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]); !!}
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('document', __('purchase.attach_document') . ':') !!}
                {!! Form::file('document', ['id' => 'upload_document', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]); !!}
                <p class="help-block">@lang('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)])
                @includeIf('components.document_help_text')</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('tax_id', __('product.applicable_tax') . ':' ) !!}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-info"></i>
                    </span>
                    {!! Form::select('tax_id', $taxes['tax_rates'], $expense->tax_id, ['class' => 'form-control'], $taxes['attributes']); !!}

            <input type="hidden" name="tax_calculation_amount" id="tax_calculation_amount" 
            value="0">
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        @php
            $is_diff_currency = (!empty($expense->transaction_currency_id) && $expense->transaction_currency_id != $base_currency->id) || (!empty($expense->exchange_rate) && $expense->exchange_rate > 1);
            $selected_curr_id = $expense->transaction_currency_id ?? ($is_diff_currency && !empty($ves_currency) ? $ves_currency->id : $base_currency->id);
            $display_rate = !empty($expense->exchange_rate) && $expense->exchange_rate > 0 ? $expense->exchange_rate : $current_bcv_rate;
            $display_amount = ($is_diff_currency && $display_rate > 1) ? ($expense->final_total * $display_rate) : $expense->final_total;
        @endphp

        <!-- Selector de Moneda -->
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('transaction_currency_id', __('lang_v1.currency') . ':*') !!}
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fas fa-coins"></i>
              </span>
              {!! Form::select('transaction_currency_id', $currencies_dropdown, $selected_curr_id, ['class' => 'form-control select2', 'id' => 'expense_currency_id', 'style' => 'width:100%;']); !!}
            </div>
            <small class="text-muted">Moneda del gasto</small>
          </div>
        </div>

        <!-- Tasa de Cambio Histórica Congelada -->
        <div class="col-sm-4" id="expense_exchange_rate_div">
          <div class="form-group">
            {!! Form::label('exchange_rate', __('purchase.p_exchange_rate') . ' (Tasa congelada):*') !!}
            @show_tooltip('Tasa de cambio fijada en la fecha del gasto. Modifíquela solo si requiere corregir la tasa histórica.')
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fas fa-exchange-alt"></i>
              </span>
              {!! Form::text('exchange_rate', @num_format($display_rate), ['class' => 'form-control input_number', 'id' => 'expense_exchange_rate', 'required']); !!}
            </div>
            <small class="help-block text-muted" id="exchange_rate_help">
              <i class="fas fa-lock tw-text-emerald-600"></i> <span id="exchange_rate_text">1 USD = {{ @num_format($display_rate) }} Bs.</span>
            </small>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('final_total', __('sale.total_amount') . ':*') !!}
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fas fa-money-bill-wave"></i>
              </span>
              {!! Form::text('final_total', @num_format($display_amount), ['class' => 'form-control input_number', 'placeholder' => __('sale.total_amount'), 'required', 'id' => 'final_total']); !!}
            </div>
            <div id="expense_amount_converted_preview" class="tw-mt-1.5" style="display: none;">
              <span class="tw-inline-flex tw-items-center tw-gap-1.5 tw-text-xs tw-font-semibold tw-text-emerald-800 tw-bg-emerald-50 tw-px-2 tw-py-1 tw-rounded-md tw-border tw-border-emerald-200">
                <i class="fas fa-calculator tw-text-emerald-600"></i>
                <span id="converted_amount_text">≈ $ 0.00 USD</span>
              </span>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('additional_notes', __('expense.expense_note') . ':') !!}
                {!! Form::textarea('additional_notes', $expense->additional_notes, ['class' => 'form-control', 'rows' => 3]); !!}
          </div>
        </div>
      </div>
    </div>
  </div> <!--box end-->
  @include('expense.recur_expense_form_part')
  <div class="col-sm-12 text-center">
    <button type="submit" class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-lg">@lang('messages.update')</button>
  </div>

{!! Form::close() !!}
</section>
@stop
@section('javascript')
<script type="text/javascript">
  var base_currency_id = {{ $base_currency ? $base_currency->id : 1 }};
  var base_currency_code = '{{ $base_currency ? $base_currency->code : "USD" }}';

  $(document).ready(function() {
    updateExpenseRateAndPreview();
  });

  __page_leave_confirmation('#add_expense_form');

  function updateExpenseRateAndPreview() {
    var selected_currency_id = $('#expense_currency_id').val();
    var amount = __read_number($('input#final_total'));
    var rate = __read_number($('#expense_exchange_rate')) || 1.0;

    if (selected_currency_id == base_currency_id) {
      $('#expense_exchange_rate_div').hide();
      if (amount > 0 && rate > 1) {
        var bs_equiv = amount * rate;
        $('#converted_amount_text').text('≈ Bs. ' + __currency_trans_from_en(bs_equiv, false, false) + ' (@ ' + __currency_trans_from_en(rate, false, false) + ' Bs/$)');
        $('#expense_amount_converted_preview').show();
      } else {
        $('#expense_amount_converted_preview').hide();
      }
    } else {
      $('#expense_exchange_rate_div').show();
      if (amount > 0 && rate > 0) {
        var usd_equiv = amount / rate;
        $('#converted_amount_text').text('≈ $ ' + __currency_trans_from_en(usd_equiv, false, false) + ' ' + base_currency_code + ' (Moneda Base)');
        $('#expense_amount_converted_preview').show();
      } else {
        $('#expense_amount_converted_preview').hide();
      }
    }
  }

  $(document).on('change', '#expense_currency_id', function() {
    var selected_currency_id = $(this).val();
    if (selected_currency_id == base_currency_id) {
      $('#expense_exchange_rate_div').hide();
      updateExpenseRateAndPreview();
    } else {
      $('#expense_exchange_rate_div').show();
      updateExpenseRateAndPreview();
    }
  });

  $(document).on('input change', 'input#final_total, #expense_exchange_rate', function() {
    updateExpenseRateAndPreview();
  });
</script>
@endsection