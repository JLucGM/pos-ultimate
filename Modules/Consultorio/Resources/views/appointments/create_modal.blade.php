<div class="modal fade" id="add_appointment_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nueva Cita</h4>
            </div>
            
            {!! Form::open(['url' => action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'store']), 'method' => 'post', 'id' => 'add_appointment_form']) !!}
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('contact_id', 'Paciente/Cliente:*') !!}
                            <div class="input-group">
                                {!! Form::select('contact_id', $customers, null, ['class' => 'form-control select2', 'placeholder' => 'Seleccionar cliente', 'required', 'style' => 'width: 100%;', 'id' => 'contact_id']) !!}
                                <span class="input-group-btn">
                                    <a href="{{ action([\App\Http\Controllers\ContactController::class, 'create']) }}?type=customer" target="_blank" class="btn btn-info btn-flat" title="Agregar nuevo cliente">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </span>
                            </div>
                            <small class="text-muted">Si necesitas crear un cliente nuevo, haz click en el botón + (se abrirá en nueva pestaña)</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('appointment_datetime', 'Fecha y Hora:*') !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                {!! Form::text('appointment_datetime', null, ['class' => 'form-control', 'required', 'readonly', 'id' => 'appointment_datetime']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('duration_minutes', 'Duración (minutos):') !!}
                            {!! Form::number('duration_minutes', 30, ['class' => 'form-control', 'min' => 15, 'step' => 15]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('location_id', 'Ubicación:*') !!}
                            {!! Form::select('location_id', $business_locations, null, ['class' => 'form-control select2', 'placeholder' => 'Seleccionar ubicación', 'required', 'id' => 'location_id']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('assigned_to', 'Asignar a:') !!}
                            {!! Form::select('assigned_to', $staff, null, ['class' => 'form-control select2', 'placeholder' => 'Seleccionar personal', 'id' => 'assigned_to']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('service_description', 'Tipo de Servicio Requerido:') !!}
                            {!! Form::textarea('service_description', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => 'Ej: Corte de cabello, Consulta general, Limpieza dental, etc.']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('estimated_amount', 'Monto Estimado:') !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-money"></i>
                                </span>
                                {!! Form::text('estimated_amount', null, ['class' => 'form-control input_number', 'placeholder' => '0.00']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('notes', 'Notas Adicionales:') !!}
                            {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => 'Observaciones, alergias, preferencias, etc.']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar Cita</button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>
