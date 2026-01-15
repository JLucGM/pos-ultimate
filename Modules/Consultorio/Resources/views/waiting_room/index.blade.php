@extends('layouts.app')
@section('title', 'Sala de Espera')

@section('content')
<section class="content-header">
    <h1>Sala de Espera
        <small>Citas del día</small>
    </h1>
</section>

<section class="content">
    @component('components.widget', ['class' => 'box-primary'])
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-info pull-right" id="refresh_appointments">
                    <i class="fa fa-refresh"></i> Actualizar
                </button>
                <a href="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'create']) }}" class="btn btn-primary pull-right" style="margin-right: 10px;">
                    <i class="fa fa-plus"></i> Nueva Cita
                </a>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#reserved" data-toggle="tab">Reservadas ({{ $appointments->where('status', 'reserved')->count() }})</a></li>
                        <li><a href="#waiting" data-toggle="tab">En Espera ({{ $appointments->where('status', 'waiting')->count() }})</a></li>
                        <li><a href="#attending" data-toggle="tab">Atendiendo ({{ $appointments->where('status', 'attending')->count() }})</a></li>
                    </ul>
                    <div class="tab-content" id="appointments_container">
                        <div class="tab-pane active" id="reserved">
                            @include('consultorio::waiting_room.partials.appointments_list', ['filtered_appointments' => $appointments->where('status', 'reserved')])
                        </div>
                        <div class="tab-pane" id="waiting">
                            @include('consultorio::waiting_room.partials.appointments_list', ['filtered_appointments' => $appointments->where('status', 'waiting')])
                        </div>
                        <div class="tab-pane" id="attending">
                            @include('consultorio::waiting_room.partials.appointments_list', ['filtered_appointments' => $appointments->where('status', 'attending')])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcomponent
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    // Auto-refresh cada 30 segundos
    setInterval(function() {
        refreshAppointments();
    }, 30000);

    $('#refresh_appointments').click(function() {
        refreshAppointments();
    });

    function refreshAppointments() {
        $.ajax({
            url: '{{ action([\Modules\Consultorio\Http\Controllers\WaitingRoomController::class, "refresh"]) }}',
            method: 'GET',
            success: function(html) {
                $('#appointments_container').html(html);
                toastr.info('Lista actualizada');
            }
        });
    }

    $(document).on('click', '.change-status-btn', function(e) {
        e.preventDefault();
        var appointment_id = $(this).data('id');
        var new_status = $(this).data('status');
        var status_names = {
            'waiting': 'En Espera',
            'attending': 'Atendiendo',
            'completed': 'Atendido',
            'cancelled': 'Cancelada'
        };
        
        $.ajax({
            method: 'POST',
            url: '/consultorio/appointments/' + appointment_id + '/change-status',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                status: new_status
            },
            success: function(result) {
                if (result.success) {
                    toastr.success(result.msg);
                    refreshAppointments();
                } else {
                    toastr.error(result.msg);
                }
            }
        });
    });
});
</script>
@endsection
