@extends('layouts.app')
@section('title', 'Citas')

@section('content')
<section class="content-header">
    <h1>Gestión de Citas
        <small>Consultorios y Salones</small>
    </h1>
</section>

<section class="content">
    @component('components.widget', ['class' => 'box-primary'])
        <div class="row">
            <div class="col-sm-12">
                @can('consultorio.create')
                <a href="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'create']) }}" class="btn btn-primary btn-sm pull-right">
                    <i class="fa fa-plus"></i> Nueva Cita
                </a>
                <a href="{{ action([\Modules\Consultorio\Http\Controllers\WaitingRoomController::class, 'index']) }}" class="btn btn-info btn-sm pull-right" style="margin-right: 10px;">
                    <i class="fa fa-users"></i> Sala de Espera
                </a>
                @endcan
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="appointments_table">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Paciente/Cliente</th>
                        <th>Fecha y Hora</th>
                        <th>Asignado a</th>
                        <th>Estado</th>
                        <th>Monto Estimado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endcomponent
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    var appointments_table = $('#appointments_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, "index"]) }}',
        columns: [
            { data: 'appointment_number', name: 'appointment_number' },
            { data: 'contact.name', name: 'contact.name' },
            { data: 'appointment_datetime', name: 'appointment_datetime' },
            { data: 'assignedTo.user_full_name', name: 'assignedTo.user_full_name' },
            { data: 'status', name: 'status' },
            { data: 'estimated_amount', name: 'estimated_amount' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[2, 'desc']]
    });

    $(document).on('click', '.cancel-appointment', function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        
        swal({
            title: '¿Cancelar cita?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((willCancel) => {
            if (willCancel) {
                $.ajax({
                    method: 'POST',
                    url: url,
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        if (result.success) {
                            toastr.success(result.msg);
                            appointments_table.ajax.reload();
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
