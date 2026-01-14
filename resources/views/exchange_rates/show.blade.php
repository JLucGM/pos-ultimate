<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Detalles de Tasa de Cambio</h4>
        </div>
        
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%;">De Moneda:</th>
                            <td>{{ $rate->fromCurrency->currency }} ({{ $rate->fromCurrency->code }})</td>
                        </tr>
                        <tr>
                            <th>A Moneda:</th>
                            <td>{{ $rate->toCurrency->currency }} ({{ $rate->toCurrency->code }})</td>
                        </tr>
                        <tr>
                            <th>Tasa de Cambio:</th>
                            <td>
                                <strong class="text-primary" style="font-size: 18px;">
                                    {{ number_format($rate->rate, 6) }}
                                </strong>
                                <br>
                                <small class="text-muted">
                                    1 {{ $rate->fromCurrency->code }} = {{ number_format($rate->rate, 6) }} {{ $rate->toCurrency->code }}
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <th>Fecha Efectiva:</th>
                            <td>{{ @format_date($rate->effective_date) }}</td>
                        </tr>
                        <tr>
                            <th>Creado Por:</th>
                            <td>{{ $rate->creator ? $rate->creator->username : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Fecha de Creación:</th>
                            <td>{{ @format_datetime($rate->created_at) }}</td>
                        </tr>
                        @if($rate->updated_at != $rate->created_at)
                        <tr>
                            <th>Última Actualización:</th>
                            <td>{{ @format_datetime($rate->updated_at) }}</td>
                        </tr>
                        @endif
                        @if($rate->notes)
                        <tr>
                            <th>Notas:</th>
                            <td>{{ $rate->notes }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i>
                        <strong>Ejemplos de Conversión:</strong>
                        <ul class="mb-0 mt-2">
                            <li>10 {{ $rate->fromCurrency->code }} = {{ number_format(10 * $rate->rate, 2) }} {{ $rate->toCurrency->code }}</li>
                            <li>100 {{ $rate->fromCurrency->code }} = {{ number_format(100 * $rate->rate, 2) }} {{ $rate->toCurrency->code }}</li>
                            <li>1,000 {{ $rate->fromCurrency->code }} = {{ number_format(1000 * $rate->rate, 2) }} {{ $rate->toCurrency->code }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            @can('edit_exchange_rate')
            <a href="{{ action([\App\Http\Controllers\ExchangeRateController::class, 'edit'], [$rate->id]) }}" class="btn btn-primary">
                <i class="fa fa-edit"></i> Editar
            </a>
            @endcan
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="fa fa-times"></i> Cerrar
            </button>
        </div>
    </div>
</div>
