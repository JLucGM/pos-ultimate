@if(isset($filtered_appointments) && $filtered_appointments->count() > 0)
    <div class="row">
        @foreach($filtered_appointments as $appointment)
        <div class="col-md-4">
            <div class="box box-widget">
                <div class="box-header with-border">
                    <div class="user-block">
                        <span class="username">
                            <a href="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'show'], [$appointment->id]) }}">
                                {{ $appointment->contact->name ?? 'N/A' }}
                            </a>
                        </span>
                        <span class="description">
                            <i class="fa fa-clock-o"></i> {{ $appointment->appointment_datetime->format('H:i') }}
                            @if($appointment->assignedTo)
                                | <i class="fa fa-user"></i> {{ $appointment->assignedTo->first_name }} {{ $appointment->assignedTo->last_name }}
                            @endif
                        </span>
                    </div>
                    <div class="box-tools">
                        {!! $appointment->status_badge !!}
                    </div>
                </div>
                <div class="box-body">
                    <p><strong>Número:</strong> {{ $appointment->appointment_number }}</p>
                    @if($appointment->service_description)
                        <p><strong>Servicio:</strong> {{ Str::limit($appointment->service_description, 50) }}</p>
                    @endif
                    <p><strong>Duración:</strong> {{ $appointment->duration_minutes }} min</p>
                    @if($appointment->estimated_amount > 0)
                        <p><strong>Monto:</strong> <span class="display_currency" data-currency_symbol="true">{{ $appointment->estimated_amount }}</span></p>
                    @endif
                </div>
                <div class="box-footer">
                    @if($appointment->status == 'reserved')
                        <button type="button" class="btn btn-warning btn-sm change-status-btn" data-id="{{ $appointment->id }}" data-status="waiting">
                            <i class="fa fa-clock-o"></i> En Espera
                        </button>
                    @endif

                    @if($appointment->status == 'waiting')
                        <button type="button" class="btn btn-primary btn-sm change-status-btn" data-id="{{ $appointment->id }}" data-status="in_service">
                            <i class="fa fa-user-md"></i> Atendiendo
                        </button>
                    @endif

                    @if($appointment->status == 'in_service')
                        <button type="button" class="btn btn-success btn-sm change-status-btn" data-id="{{ $appointment->id }}" data-status="completed">
                            <i class="fa fa-check"></i> Completar
                        </button>
                    @endif

                    <a href="{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'show'], [$appointment->id]) }}" class="btn btn-info btn-sm">
                        <i class="fa fa-eye"></i> Ver
                    </a>

                    @if(in_array($appointment->status, ['reserved', 'waiting']))
                        <button type="button" class="btn btn-danger btn-sm change-status-btn" data-id="{{ $appointment->id }}" data-status="cancelled">
                            <i class="fa fa-times"></i> Cancelar
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> No hay citas en este estado
    </div>
@endif
