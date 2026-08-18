@extends('layouts.app')
@section('title', 'Tasas de Cambio Multimoneda')

@section('content')
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">Tasas de Cambio Multimoneda
        <small class="tw-text-sm md:tw-text-base tw-text-gray-700 tw-font-semibold">Gestionar y sincronizar tasas oficiales y paralelas</small>
    </h1>
</section>

<section class="content">
    <!-- Live BCV / DolarApi Sync Banner -->
    <div style="background: #0B0F1D; border: 1.5px solid rgba(251, 76, 10, 0.3); border-radius: 18px; padding: 20px 24px; color: #FFFFFF; margin-bottom: 24px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.2);">
        <div class="row" style="display: flex; align-items: center; flex-wrap: wrap; gap: 15px 0;">
            <div class="col-md-7 col-sm-12">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(251, 76, 10, 0.2); display: flex; align-items: center; justify-content: center; color: #FB4C0A; font-size: 22px;">
                        <i class="fas fa-university"></i>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #94A3B8;">Tasa Oficial BCV en Tiempo Real</div>
                        <div style="font-size: 24px; font-weight: 900; color: #FFFFFF; font-family: ui-monospace, monospace;" id="live_bcv_rate_text">
                            <i class="fas fa-spinner fa-spin tw-text-sm"></i> Consultando BCV...
                        </div>
                        <div style="font-size: 11px; color: #64748B;" id="live_bcv_date_text">
                            Sincronización directa vía DolarApi
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12" style="display: flex; justify-content: flex-end; gap: 10px; flex-wrap: wrap;">
                <button type="button" id="btn_sync_bcv" class="btn" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: #FFFFFF; font-weight: 800; border-radius: 10px; padding: 10px 18px; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4); display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-sync-alt" id="sync_icon"></i> Sincronizar BCV Ahora
                </button>
                @can('create_exchange_rate')
                    <a href="{{action([\App\Http\Controllers\ExchangeRateController::class, 'create'])}}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-plus"></i> Nueva Tasa Manual
                    </a>
                @endcan
            </div>
        </div>
    </div>

    @component('components.widget', ['class' => 'box-primary', 'title' => 'Historial de Tasas Registradas'])
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="exchange_rates_table">
                <thead>
                    <tr>
                        <th>Fecha Efectiva</th>
                        <th>De Moneda</th>
                        <th>A Moneda</th>
                        <th>Tasa</th>
                        <th>Creado Por</th>
                        <th>Notas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endcomponent

    <div class="modal fade view_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    var exchange_rates_table = $('#exchange_rates_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ action([\App\Http\Controllers\ExchangeRateController::class, 'getData']) }}',
        columns: [
            { data: 'effective_date', name: 'exchange_rates.effective_date' },
            { data: 'from_currency_name', name: 'from_curr.currency' },
            { data: 'to_currency_name', name: 'to_curr.currency' },
            { data: 'rate', name: 'exchange_rates.rate' },
            { data: 'creator_name', name: 'users.username' },
            { data: 'notes', name: 'exchange_rates.notes' },
            { data: 'action', orderable: false, searchable: false }
        ],
        order: [[0, 'desc']],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        }
    });

    // Preview de tasa BCV en vivo
    $.ajax({
        url: '{{ action([\App\Http\Controllers\ExchangeRateController::class, "previewApiRate"]) }}',
        dataType: 'json',
        success: function(res) {
            if (res.success && res.oficial) {
                $('#live_bcv_rate_text').html('1 USD = ' + parseFloat(res.oficial).toFixed(4) + ' Bs');
                $('#live_bcv_date_text').html('<i class="fas fa-check-circle tw-text-emerald-400"></i> Fecha oficial: ' + res.fecha);
            } else {
                $('#live_bcv_rate_text').html('1 USD = 1 USD');
            }
        },
        error: function() {
            $('#live_bcv_rate_text').html('1 USD = 1 USD');
        }
    });

    // Sincronizar BCV con un clic
    $('#btn_sync_bcv').click(function() {
        var $btn = $(this);
        var $icon = $('#sync_icon');
        $icon.addClass('fa-spin');
        $btn.prop('disabled', true);

        $.ajax({
            url: '{{ action([\App\Http\Controllers\ExchangeRateController::class, "syncFromApi"]) }}',
            data: { source: 'oficial' },
            dataType: 'json',
            success: function(res) {
                $icon.removeClass('fa-spin');
                $btn.prop('disabled', false);

                if (res.success) {
                    toastr.success(res.message);
                    exchange_rates_table.ajax.reload();
                    $('#live_bcv_rate_text').html('1 USD = ' + parseFloat(res.rate).toFixed(4) + ' Bs');
                    $('#live_bcv_date_text').html('<i class="fas fa-check-circle tw-text-emerald-400"></i> Actualizado hoy: ' + res.date);
                } else {
                    toastr.error(res.message || 'Error al sincronizar tasa');
                }
            },
            error: function() {
                $icon.removeClass('fa-spin');
                $btn.prop('disabled', false);
                toastr.error('Error de conexión con el servidor');
            }
        });
    });

    // Manejar el botón de eliminar
    $(document).on('click', '.delete_button', function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        
        swal({
            title: '¿Estás seguro?',
            text: 'Esta tasa de cambio será eliminada permanentemente',
            icon: 'warning',
            buttons: {
                cancel: {
                    text: 'Cancelar',
                    value: null,
                    visible: true,
                    className: '',
                    closeModal: true,
                },
                confirm: {
                    text: 'Sí, eliminar',
                    value: true,
                    visible: true,
                    className: 'bg-danger',
                    closeModal: true
                }
            }
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    method: 'DELETE',
                    url: url,
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        if (result.success == true) {
                            toastr.success(result.msg);
                            exchange_rates_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    }
                });
            }
        });
    });
});
</script>
@endsection
