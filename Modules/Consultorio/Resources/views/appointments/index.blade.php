@extends('layouts.app')
@section('title', 'Citas')

@section('content')
<section class="content-header">
    <h1>Gestión de Citas</h1>
</section>

<section class="content">
    <div class="row">
        @if(count($business_locations) > 1)
        <div class="col-sm-12">
            <select id="business_location_id" class="select2" style="width:50%">
                <option value="">Ubicación</option>
                @foreach($business_locations as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        @endif
    </div>
    <br>
    
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Citas de Hoy</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-condensed" id="todays_appointments_table">
                        <thead>
                            <tr>
                                <th>Paciente/Cliente</th>
                                <th>Hora</th>
                                <th>Asignado a</th>
                                <th>Ubicación</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-10">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <button type="button" class="btn btn-primary" id="add_new_appointment_btn">
                                <i class="fa fa-plus"></i> Nueva Cita
                            </button>
                            <a href="{{ action([\Modules\Consultorio\Http\Controllers\WaitingRoomController::class, 'index']) }}" class="btn btn-info">
                                <i class="fa fa-users"></i> Sala de Espera
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="box box-solid">
                <div class="box-body">
                    <div class="external-event bg-yellow text-center" style="position: relative;">
                        <small>Reservada</small>
                    </div>
                    <div class="external-event bg-yellow text-center" style="position: relative;">
                        <small>En Espera</small>
                    </div>
                    <div class="external-event bg-light-blue text-center" style="position: relative;">
                        <small>Atendiendo</small>
                    </div>
                    <div class="external-event bg-green text-center" style="position: relative;">
                        <small>Atendido</small>
                    </div>
                    <div class="external-event bg-red text-center" style="position: relative;">
                        <small>Cancelada</small>
                    </div>
                    <small>
                        <p class="help-block">
                            <i>Click en cualquier cita para ver detalles o cambiar estado<br><br>
                            Doble click en cualquier día para agregar nueva cita</i>
                        </p>
                    </small>
                </div>
            </div>
        </div>
    </div>

    @include('consultorio::appointments.create_modal')
</section>

<div class="modal fade view_modal" tabindex="-1" role="dialog"></div>

@endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function(){
    var clickCount = 0;
    
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        eventLimit: 2,
        events: '{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, "index"]) }}',
        eventRender: function (event, element) {
            var title_html = event.customer_name;
            if(event.staff){
                title_html += '<br>' + event.staff;
            }
            element.find('.fc-title').html(title_html);
            element.attr('data-href', event.url);
            element.attr('data-container', '.view_modal');
            element.addClass('btn-modal');
        },
        eventClick: function(event, jsEvent, view) {
            // Cargar el modal con los detalles de la cita
            $('div.view_modal').load(event.url, function(){
                $(this).modal('show');
            });
        },
        dayClick: function(date, jsEvent, view) {
            clickCount++;
            if(clickCount == 2){
                $('#add_appointment_modal').modal('show');
                $('form#add_appointment_form #appointment_datetime').data("DateTimePicker").date(date).ignoreReadonly(true);
            }
            var clickTimer = setInterval(function(){
                clickCount = 0;
                clearInterval(clickTimer);
            }, 500);
        }
    });

    $('#add_appointment_modal').on('shown.bs.modal', function (e) {
        $(this).find('select').each(function(){
            if(!($(this).hasClass('select2'))){
                $(this).select2({
                    dropdownParent: $('#add_appointment_modal')
                });
            }
        });
        
        appointment_form_validator = $('form#add_appointment_form').validate({
            submitHandler: function(form) {
                var data = $(form).serialize();
                $.ajax({
                    method: "POST",
                    url: $(form).attr("action"),
                    dataType: "json",
                    data: data,
                    beforeSend: function(xhr) {
                        __disable_submit_button($(form).find('button[type="submit"]'));
                    },
                    success: function(result){
                        if(result.success == true){
                            $('div#add_appointment_modal').modal('hide');
                            toastr.success(result.msg);
                            reload_calendar();
                            todays_appointments_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                        $(form).find('button[type="submit"]').attr('disabled', false);
                    }
                });
            }
        });
    });

    $('#add_appointment_modal').on('hidden.bs.modal', function (e) {
        if(typeof appointment_form_validator !== 'undefined'){
            appointment_form_validator.destroy();
        }
        reset_appointment_form();
    });

    $('form#add_appointment_form #appointment_datetime').datetimepicker({
        format: moment_date_format + ' ' + moment_time_format,
        minDate: moment(),
        ignoreReadonly: true
    });

    $('.view_modal').on('shown.bs.modal', function (e) {
        $('form#edit_appointment_form').validate({
            submitHandler: function(form) {
                var data = $(form).serialize();
                $.ajax({
                    method: "PUT",
                    url: $(form).attr("action"),
                    dataType: "json",
                    data: data,
                    beforeSend: function(xhr) {
                        __disable_submit_button($(form).find('button[type="submit"]'));
                    },
                    success: function(result){
                        if(result.success == true){
                            $('div.view_modal').modal('hide');
                            toastr.success(result.msg);
                            reload_calendar();
                            todays_appointments_table.ajax.reload();
                            $(form).find('button[type="submit"]').attr('disabled', false);
                        } else {
                            toastr.error(result.msg);
                        }
                    }
                });
            }
        });
    });

    var todays_appointments_table = $('#todays_appointments_table').DataTable({
        processing: true,
        serverSide: true,
        fixedHeader: false,
        "ordering": false,
        'searching': false,
        "pageLength": 10,
        dom: 'frtip',
        "ajax": {
            "url": "{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, 'index']) }}",
            "data": function (d) {
                d.location_id = $('#business_location_id').val();
                d.today = 1;
            }
        },
        columns: [
            {data: 'contact'},
            {data: 'appointment_datetime'},
            {data: 'assignedTo'},
            {data: 'location'},
        ]
    });

    $('button#add_new_appointment_btn').click(function(){
        $('div#add_appointment_modal').modal('show');
    });

    $(document).on('change', 'select#business_location_id', function(){
        reload_calendar();
        todays_appointments_table.ajax.reload();
    });

    $(document).on('click', 'button#delete_appointment', function(){
        swal({
            title: LANG.sure,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                var href = $(this).data('href');
                $.ajax({
                    method: "DELETE",
                    url: href,
                    dataType: "json",
                    success: function(result){
                        if(result.success == true){
                            $('div.view_modal').modal('hide');
                            toastr.success(result.msg);
                            reload_calendar();
                            todays_appointments_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    }
                });
            }
        });
    });

    function reset_appointment_form(){
        $('select#location_id').val('').change();
        $('select#contact_id').val('').change();
        $('select#assigned_to').val('').change();
        $('#notes, #appointment_datetime, #service_description, #estimated_amount').val('');
        $('#duration_minutes').val(30);
    }

    function reload_calendar(){
        var location_id = '';
        if($('select#business_location_id').val()){
            location_id = $('select#business_location_id').val();
        }

        var events_source = {
            url: '{{ action([\Modules\Consultorio\Http\Controllers\AppointmentController::class, "index"]) }}',
            type: 'get',
            data: {
                'location_id': location_id
            }
        }
        $('#calendar').fullCalendar('removeEventSource', events_source);
        $('#calendar').fullCalendar('addEventSource', events_source);         
        $('#calendar').fullCalendar('refetchEvents');
    }
});
</script>
@endsection
