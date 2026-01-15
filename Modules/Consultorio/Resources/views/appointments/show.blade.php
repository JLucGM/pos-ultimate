@extends('layouts.app')
@section('title', 'Detalle de Cita')

@section('content')
<section class="content-header">
    <h1>Cita: {{ $appointment->appointment_number }}</h1>
</section>

<section class="content">
    @component('components.widget', ['class' => 'box-primary'])
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th width="40%">Número de Cita:</th>
                        <td>{{ $appointment->appointment_number }}</td>
                    </tr>
                    <tr>
                        <th>Paciente/Cliente:</th>
                        <td>{{ $appointment->contact->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Teléfono:</th>
                        <td>{{ $appointment->contact->mobile ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Asignado a:</th>
                        <td>{{ $appointment->assignedTo->user_full_name ?? 'No asignado' }}</td>
                    </tr>
                    <tr>
                        <th>Estado:</th>
                        <td>{!! $appointment->status_badge !!}</td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th width="40%">Fecha y Hora:</th>
                        <td>{{ $appointment->appointment_datetime->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Duración:</th>
                        <td>{{ $appointment->duration_minutes }} minutos</td>
                    </tr>
                    <tr>
                        <th>Ubicación:</th>
                        <td>{{ $appointment->location->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Monto Estimado:</th>
                        <td><span class="display_currency" data-currency_symbol="true">{{ $appointment->estimated_amount }}</span></td>
                    </tr>
                    <tr>
                        <th>Creado por:</th>
                        <td>{{ $appointment->creator->user_full_name ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($appointment->service_description)
        <div class="row">
            <div class="col-md-12">
                <h4>Descripción del Servicio:</h4>
                <p>{{ $appointment->service_description }}</p>
            </div>
        </div>
        @endif

        @if($appointment->notes)
        <div class="row">
            <div class="col-md-12">
                <h4>Notas:</h4>
                <p>{{ $appointment->notes }}</p>
            </div>
        </div>
        @endif

        @if($appointment->transaction_id)
        <div class="row">
            <div class="col-md-12">
                <h4>Venta Asociada:</h4>
                <p>
                    <a href="{{ action([\App\Http\Controllers\SellController::class, 'show'], [$appointment->transaction_id]) }}" target="_blank">
                        Ver Venta #{{ $appointment->transaction_id }}
                    </a>
                </p>
            </div>
        </div>
        @endif

        <hr>

        <div class="row">
            <div class="col-md-12">
                @if($appointment->status == 'reserved')
                    <button type="button" class="btn btn-warning change-status" data-status="waiting">
                        <i class="fa fa-clock-o"></i> Marcar como En Espera
                    </button>
                @endif

                @if($appointment->status == 'waiting')
                    <button type="button" class="btn btn-primary change-status" data-status="attending">
                        <i class="fa fa-user-md"></i> Marcar como Atendiendo
                    </button>
                @endif

                @if($appointment->status == 'attending')
                    <button type="button" class="btn btn-success change-status" data-status="completed">
                        <i class="fa fa-check"></i> Marcar como Atendido
                    </button>
                @endif

                @if(in_array($appointment->status, ['reserved', 'waiting', 'attending']))
                    <button type="button" class="btn btn-danger change-status" data-status="cancelled">
                        <i class="fa fa-times"></i> Cancelar Cita
                    </button>
                @endif

                @if($appointment->status == 'reserved' && auth()->user()->can('consultorio.edit'))
                    <a href="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'edit'], [$appointment->id]) }}" class="btn btn-info">
                        <i class="fa fa-edit"></i> Editar
                    </a>
                @endif

                @if($appointment->status == 'completed' && !$appointment->transaction_id)
                    <a href="{{ action([\App\Http\Controllers\SellPosController::class, 'create']) }}?contact_id={{ $appointment->contact_id }}" class="btn btn-success" target="_blank">
                        <i class="fa fa-money"></i> Crear Venta en POS
                    </a>
                @endif
                
                <a href="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'index']) }}" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    @endcomponent
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $('.change-status').click(function() {
        var new_status = $(this).data('status');
        var status_names = {
            'waiting': 'En Espera',
            'attending': 'Atendiendo',
            'completed': 'Atendido',
            'cancelled': 'Cancelada'
        };
        
        swal({
            title: '¿Cambiar estado?',
            text: 'La cita se marcará como: ' + status_names[new_status],
            icon: 'info',
            buttons: true,
        }).then((willChange) => {
            if (willChange) {
                $.ajax({
                    method: 'POST',
                    url: '{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, "changeStatus"], [$appointment->id]) }}',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: new_status
                    },
                    success: function(result) {
                        if (result.success) {
                            toastr.success(result.msg);
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
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
