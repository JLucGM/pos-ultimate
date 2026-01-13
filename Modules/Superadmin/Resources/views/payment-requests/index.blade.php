@extends('layouts.app')
@section('title', 'Solicitudes de Pago')

@section('content')
<section class="content-header">
    <h1>Solicitudes de Pago
        <small>Gestionar pagos pendientes</small>
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Solicitudes</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="payment_requests_table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Negocio</th>
                            <th>Contacto</th>
                            <th>Email</th>
                            <th>Plan</th>
                            <th>Monto</th>
                            <th>Método</th>
                            <th>Referencia</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $request->business_name }}</td>
                            <td>{{ $request->contact_name }}</td>
                            <td>{{ $request->email }}</td>
                            <td>{{ $request->package->name }}</td>
                            <td>{{ $request->package->currency }}{{ number_format($request->amount, 2) }}</td>
                            <td>
                                <span class="label label-info">{{ ucfirst($request->payment_method) }}</span>
                            </td>
                            <td>{{ $request->reference_number }}</td>
                            <td>
                                @if($request->status == 'pending')
                                    <span class="label label-warning">Pendiente</span>
                                @elseif($request->status == 'approved')
                                    <span class="label label-success">Aprobado</span>
                                @else
                                    <span class="label label-danger">Rechazado</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" onclick="viewDetails({{ $request->id }})">
                                    <i class="fa fa-eye"></i> Ver
                                </button>
                                @if($request->status == 'pending')
                                <button type="button" class="btn btn-sm btn-success" onclick="approvePayment({{ $request->id }})">
                                    <i class="fa fa-check"></i> Aprobar
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="rejectPayment({{ $request->id }})">
                                    <i class="fa fa-times"></i> Rechazar
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal de Detalles -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detalles de la Solicitud</h4>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Contenido cargado dinámicamente -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $('#payment_requests_table').DataTable({
        order: [[0, 'desc']],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        }
    });
});

function viewDetails(id) {
    $.get('/superadmin/payment-requests/' + id, function(data) {
        let html = `
            <div class="row">
                <div class="col-md-6">
                    <h4>Información del Cliente</h4>
                    <p><strong>Negocio:</strong> ${data.business_name}</p>
                    <p><strong>Contacto:</strong> ${data.contact_name}</p>
                    <p><strong>Email:</strong> ${data.email}</p>
                    <p><strong>Teléfono:</strong> ${data.phone || 'N/A'}</p>
                </div>
                <div class="col-md-6">
                    <h4>Información del Pago</h4>
                    <p><strong>Plan:</strong> ${data.package.name}</p>
                    <p><strong>Monto:</strong> ${data.package.currency}${data.amount}</p>
                    <p><strong>Método:</strong> ${data.payment_method}</p>
                    <p><strong>Referencia:</strong> ${data.reference_number}</p>
                    <p><strong>Fecha:</strong> ${new Date(data.created_at).toLocaleString()}</p>
                </div>
            </div>
            ${data.payment_proof ? `
            <div class="row">
                <div class="col-md-12">
                    <h4>Comprobante de Pago</h4>
                    <img src="/storage/${data.payment_proof}" class="img-responsive" style="max-height: 400px;">
                </div>
            </div>
            ` : '<p class="text-muted">No se subió comprobante</p>'}
        `;
        $('#modalContent').html(html);
        $('#detailsModal').modal('show');
    });
}

function approvePayment(id) {
    if (confirm('¿Aprobar esta solicitud de pago?\n\nSe creará automáticamente:\n- El negocio\n- El usuario\n- La suscripción')) {
        
        // Pedir contraseña para el nuevo usuario
        let password = prompt('Establece una contraseña para el cliente:\n(Mínimo 6 caracteres)', '');
        
        if (password === null) {
            return; // Usuario canceló
        }
        
        if (password.length < 6) {
            toastr.error('La contraseña debe tener al menos 6 caracteres');
            return;
        }
        
        $.post('/superadmin/payment-requests/' + id + '/approve', {
            _token: '{{ csrf_token() }}',
            password: password
        }, function(response) {
            if (response.success) {
                let message = 'Pago aprobado exitosamente!\n\n';
                if (response.business_id) {
                    message += 'Business ID: ' + response.business_id + '\n';
                    message += 'Subscription ID: ' + response.subscription_id + '\n';
                    message += 'Email: ' + response.email + '\n';
                    message += 'Contraseña: ' + password;
                }
                
                // Mostrar en un modal más grande
                $('#modalContent').html(`
                    <div class="alert alert-success">
                        <h4><i class="fa fa-check"></i> ¡Pago Aprobado Exitosamente!</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Credenciales de Acceso</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Business ID:</th>
                                    <td>${response.business_id}</td>
                                </tr>
                                <tr>
                                    <th>Subscription ID:</th>
                                    <td>${response.subscription_id}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>${response.email}</td>
                                </tr>
                                <tr>
                                    <th>Contraseña:</th>
                                    <td><code>${password}</code></td>
                                </tr>
                                <tr>
                                    <th>URL de Acceso:</th>
                                    <td><a href="${window.location.origin}/login" target="_blank">${window.location.origin}/login</a></td>
                                </tr>
                            </table>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> Copia estas credenciales y envíaselas al cliente por email o WhatsApp.
                            </div>
                        </div>
                    </div>
                `);
                $('#detailsModal .modal-title').text('Suscripción Creada');
                $('#detailsModal').modal('show');
                
                setTimeout(function() {
                    location.reload();
                }, 5000);
            } else {
                toastr.error(response.message || 'Error al aprobar el pago');
            }
        }).fail(function(xhr) {
            toastr.error('Error: ' + (xhr.responseJSON?.message || 'Ocurrió un error'));
        });
    }
}

function rejectPayment(id) {
    let reason = prompt('Motivo del rechazo (opcional):');
    if (reason !== null) {
        $.post('/superadmin/payment-requests/' + id + '/reject', {
            _token: '{{ csrf_token() }}',
            reason: reason
        }, function(response) {
            if (response.success) {
                toastr.success('Pago rechazado');
                location.reload();
            }
        });
    }
}
</script>
@endsection
