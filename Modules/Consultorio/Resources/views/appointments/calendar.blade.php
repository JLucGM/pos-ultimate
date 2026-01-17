@extends('layouts.app')
@section('title', 'Calendario de Citas')

@section('content')
<section class="content-header">
    <h1>Calendario de Citas</h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Calendario</h3>
                    <div class="box-tools pull-right">
                        <a href="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'create']) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Nueva Cita
                        </a>
                        <a href="{{ action([\Modules\Consultorio\Http\Controllers\WaitingRoomController::class, 'index']) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-users"></i> Sala de Espera
                        </a>
                        <a href="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'index']) }}" class="btn btn-default btn-sm">
                            <i class="fa fa-list"></i> Ver Lista
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Leyenda</h3>
                </div>
                <div class="box-body">
                    <div class="external-event bg-blue" style="margin-bottom: 10px; padding: 5px;">
                        <small>Reservada</small>
                    </div>
                    <div class="external-event bg-yellow" style="margin-bottom: 10px; padding: 5px;">
                        <small>En Espera</small>
                    </div>
                    <div class="external-event bg-aqua" style="margin-bottom: 10px; padding: 5px;">
                        <small>Atendiendo</small>
                    </div>
                    <div class="external-event bg-green" style="margin-bottom: 10px; padding: 5px;">
                        <small>Atendido</small>
                    </div>
                    <div class="external-event bg-red" style="margin-bottom: 10px; padding: 5px;">
                        <small>Cancelada</small>
                    </div>
                    <hr>
                    <p class="text-muted">
                        <small>
                            <i class="fa fa-info-circle"></i> Click en una cita para ver detalles
                        </small>
                    </p>
                </div>
            </div>
            
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Citas de Hoy</h3>
                </div>
                <div class="box-body">
                    @php
                        $today = \Carbon\Carbon::now()->format('Y-m-d');
                        $business_id = session('user.business_id');
                        $todays_appointments = \Modules\Consultorio\Entities\Appointment::where('business_id', $business_id)
                            ->whereDate('appointment_datetime', $today)
                            ->whereIn('status', ['reserved', 'waiting', 'in_service'])
                            ->with(['contact'])
                            ->orderBy('appointment_datetime')
                            ->get();
                    @endphp
                    
                    @if($todays_appointments->count() > 0)
                        <ul class="list-unstyled">
                            @foreach($todays_appointments as $apt)
                            <li style="margin-bottom: 10px;">
                                <a href="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'show'], [$apt->id]) }}">
                                    <strong>{{ $apt->appointment_datetime->format('H:i') }}</strong><br>
                                    {{ $apt->contact->name ?? 'N/A' }}<br>
                                    {!! $apt->status_badge !!}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No hay citas para hoy</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        locale: 'es',
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día'
        },
        events: function(start, end, timezone, callback) {
            $.ajax({
                url: '{{ route("consultorio.appointments.calendarEvents") }}',
                type: 'GET',
                data: {
                    start: start.format(),
                    end: end.format()
                },
                success: function(data) {
                    callback(data);
                }
            });
        },
        eventClick: function(event) {
            window.location.href = event.url;
        },
        eventRender: function(event, element) {
            element.find('.fc-title').html(
                '<strong>' + event.title + '</strong><br>' +
                '<small>' + event.time + '</small>'
            );
        }
    });
});
</script>
@endsection
