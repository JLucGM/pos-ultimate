<div class="pos-tab-content">
    <div class="row">
        <div class="col-xs-12">
            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 18px 22px; margin-bottom: 25px;">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <h4 style="margin: 0 0 6px 0; font-weight: 700; color: #0F172A; display: flex; align-items: center; gap: 10px;">
                            <i class="fa fa-cubes text-primary" style="font-size: 20px;"></i>
                            <span>@lang('lang_v1.enable_disable_modules')</span>
                        </h4>
                        <p style="margin: 0; color: #64748B; font-size: 13px;">
                            Gestiona las herramientas activas en tu empresa. Los módulos especializados dependen del plan contratado o autorizaciones especiales del Superadministrador.
                        </p>
                    </div>
                    <div class="col-sm-4 text-right" style="padding-top: 5px;">
                        @if(Module::has('Superadmin'))
                            <a href="{{ action([\Modules\Superadmin\Http\Controllers\SubscriptionController::class, 'index']) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 8px; font-weight: 600; border: 1px solid #3B82F6; color: #2563EB; background: #EFF6FF;">
                                <i class="fa fa-crown text-warning"></i> Ver Mi Plan / Suscripción
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!empty($modules))
        @php
            $allowed_list = $allowed_modules ?? array_keys($modules);
            $core_modules = [];
            $specialized_modules = [];

            foreach ($modules as $k => $v) {
                if (isset($v['category']) && $v['category'] === 'core') {
                    $core_modules[$k] = $v;
                } else {
                    $specialized_modules[$k] = $v;
                }
            }
        @endphp

        <!-- Sección: Módulos Operativos Base -->
        @if(!empty($core_modules))
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-xs-12">
                    <div style="display: flex; align-items: center; margin-bottom: 15px; border-bottom: 2px solid #F1F5F9; padding-bottom: 8px;">
                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 6px; background: #EEF2FF; color: #4F46E5; margin-right: 10px;">
                            <i class="fa fa-layer-group"></i>
                        </span>
                        <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #1E293B;">
                            Módulos Operativos Base
                        </h4>
                        <span class="badge" style="margin-left: 10px; background: #E0E7FF; color: #3730A3; font-weight: 600; font-size: 11px;">
                            Incluidos en tu plan
                        </span>
                    </div>
                </div>

                @foreach($core_modules as $k => $v)
                    @php
                        $is_enabled = in_array($k, $enabled_modules);
                        $is_allowed = in_array($k, $allowed_list);
                    @endphp
                    <div class="col-sm-6 col-md-4" style="margin-bottom: 16px;">
                        <div style="background: #FFFFFF; border: 1px solid {{ $is_enabled ? '#BFDBFE' : '#E2E8F0' }}; border-radius: 10px; padding: 14px 16px; height: 100%; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s ease; box-shadow: 0 1px 2px rgba(0,0,0,0.03);">
                            <div>
                                <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 8px;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 36px; height: 36px; border-radius: 8px; background: {{ $is_enabled ? '#EFF6FF' : '#F8FAFC' }}; color: {{ $is_enabled ? '#2563EB' : '#64748B' }}; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                            <i class="{{ $v['icon'] ?? 'fa fa-cube' }}"></i>
                                        </div>
                                        <div>
                                            <strong style="color: #0F172A; font-size: 14px; display: block; line-height: 1.2;">{{ $v['name'] }}</strong>
                                        </div>
                                    </div>
                                    @if($is_enabled)
                                        <span class="badge" style="background: #DCFCE7; color: #166534; font-size: 11px; font-weight: 600; border: 1px solid #BBF7D0;">
                                            <i class="fa fa-check"></i> Activo
                                        </span>
                                    @else
                                        <span class="badge" style="background: #F1F5F9; color: #64748B; font-size: 11px; font-weight: 600;">
                                            Inactivo
                                        </span>
                                    @endif
                                </div>
                                <p style="color: #64748B; font-size: 12px; margin: 0 0 10px 0; line-height: 1.4;">
                                    {{ $v['description'] ?? '' }}
                                </p>
                            </div>
                            
                            <div style="border-top: 1px dashed #E2E8F0; padding-top: 10px; margin-top: 5px;">
                                <div class="checkbox" style="margin: 0;">
                                    <label style="font-weight: 600; color: #334155; font-size: 13px; cursor: pointer; padding-left: 0;">
                                        {!! Form::checkbox('enabled_modules[]', $k, $is_enabled, ['class' => 'input-icheck']) !!}
                                        <span style="margin-left: 6px;">Habilitar en el sistema</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Sección: Módulos Especializados y Extensiones -->
        @if(!empty($specialized_modules))
            <div class="row">
                <div class="col-xs-12">
                    <div style="display: flex; align-items: center; margin-bottom: 15px; border-bottom: 2px solid #F1F5F9; padding-bottom: 8px; margin-top: 10px;">
                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 6px; background: #FEF3C7; color: #D97706; margin-right: 10px;">
                            <i class="fa fa-star"></i>
                        </span>
                        <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #1E293B;">
                            Módulos Especializados y Soluciones de Nicho
                        </h4>
                    </div>
                </div>

                @foreach($specialized_modules as $k => $v)
                    @php
                        $is_enabled = in_array($k, $enabled_modules);
                        $is_allowed = in_array($k, $allowed_list);
                    @endphp
                    <div class="col-sm-6 col-md-4" style="margin-bottom: 16px;">
                        <div style="background: {{ $is_allowed ? '#FFFFFF' : '#FAFAFA' }}; border: 1px solid {{ $is_allowed ? ($is_enabled ? '#BFDBFE' : '#E2E8F0') : '#E2E8F0' }}; border-radius: 10px; padding: 14px 16px; height: 100%; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s ease; box-shadow: 0 1px 2px rgba(0,0,0,0.03); opacity: {{ $is_allowed ? '1' : '0.92' }};">
                            <div>
                                <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 8px;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 36px; height: 36px; border-radius: 8px; background: {{ $is_allowed ? ($is_enabled ? '#EFF6FF' : '#F8FAFC') : '#F1F5F9' }}; color: {{ $is_allowed ? ($is_enabled ? '#2563EB' : '#475569') : '#94A3B8' }}; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                            <i class="{{ $v['icon'] ?? 'fa fa-cube' }}"></i>
                                        </div>
                                        <div>
                                            <strong style="color: {{ $is_allowed ? '#0F172A' : '#475569' }}; font-size: 14px; display: block; line-height: 1.2;">{{ $v['name'] }}</strong>
                                        </div>
                                    </div>
                                    
                                    @if($is_allowed)
                                        @if($is_enabled)
                                            <span class="badge" style="background: #DCFCE7; color: #166534; font-size: 11px; font-weight: 600; border: 1px solid #BBF7D0;">
                                                <i class="fa fa-check"></i> Activo
                                            </span>
                                        @else
                                            <span class="badge" style="background: #F1F5F9; color: #64748B; font-size: 11px; font-weight: 600;">
                                                Inactivo
                                            </span>
                                        @endif
                                    @else
                                        <span class="badge" style="background: #FEF3C7; color: #92400E; font-size: 10px; font-weight: 600; border: 1px solid #FCD34D;">
                                            <i class="fa fa-lock"></i> Requiere Plan
                                        </span>
                                    @endif
                                </div>
                                <p style="color: #64748B; font-size: 12px; margin: 0 0 10px 0; line-height: 1.4;">
                                    {{ $v['description'] ?? '' }}
                                </p>
                            </div>
                            
                            <div style="border-top: 1px dashed #E2E8F0; padding-top: 10px; margin-top: 5px;">
                                @if($is_allowed)
                                    <div class="checkbox" style="margin: 0;">
                                        <label style="font-weight: 600; color: #334155; font-size: 13px; cursor: pointer; padding-left: 0;">
                                            {!! Form::checkbox('enabled_modules[]', $k, $is_enabled, ['class' => 'input-icheck']) !!}
                                            <span style="margin-left: 6px;">Habilitar en el sistema</span>
                                        </label>
                                    </div>
                                @else
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span style="color: #94A3B8; font-size: 12px; display: flex; align-items: center; gap: 5px;">
                                            <i class="fa fa-lock text-muted"></i> No incluido en plan
                                        </span>
                                        <button type="button" class="btn btn-xs btn-primary btn-upgrade-modal-trigger" 
                                                data-module="{{ $k }}" 
                                                data-name="{{ $v['name'] }}" 
                                                data-desc="{{ $v['description'] ?? '' }}"
                                                data-icon="{{ $v['icon'] ?? 'fa fa-cube' }}"
                                                style="border-radius: 6px; font-weight: 600; font-size: 11px; padding: 4px 10px;">
                                            <i class="fa fa-arrow-circle-up"></i> Solicitar Módulo
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>

<!-- Modal: Solicitar Módulo / Mejorar Plan -->
<div class="modal fade" id="module_upgrade_modal" tabindex="-1" role="dialog" aria-labelledby="moduleUpgradeModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
            <div class="modal-header" style="background: #0F172A; color: white; padding: 20px 24px; border-bottom: none;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.8; font-size: 24px;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div id="modal_module_icon_box" style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 20px; color: #38BDF8;">
                        <i id="modal_module_icon" class="fa fa-cube"></i>
                    </div>
                    <div>
                        <h4 class="modal-title" id="modal_module_name" style="font-weight: 700; font-size: 18px; margin: 0; color: white;">
                            Módulo Especializado
                        </h4>
                        <span style="font-size: 12px; color: #94A3B8;">Función Avanzada de AudazPOS</span>
                    </div>
                </div>
                   <div class="modal-body" style="padding: 24px;">
                <input type="hidden" id="modal_module_key" value="">
                <div style="background: #FEF3C7; border: 1px solid #FCD34D; border-radius: 10px; padding: 14px 16px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 12px;">
                    <i class="fa fa-lock text-warning" style="font-size: 20px; color: #D97706; margin-top: 2px;"></i>
                    <div>
                        <strong style="color: #92400E; font-size: 14px; display: block;">Módulo no disponible en tu plan actual</strong>
                        <p style="color: #B45309; font-size: 12px; margin: 2px 0 0 0;">
                            Para activar esta función necesitas un plan que incluya este módulo o solicitar la habilitación personalizada con el Superadministrador.
                        </p>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <h5 style="font-weight: 700; color: #1E293B; margin-bottom: 8px;">Descripción del Módulo:</h5>
                    <p id="modal_module_desc" style="color: #475569; font-size: 13px; line-height: 1.5; background: #F8FAFC; padding: 12px 14px; border-radius: 8px; border: 1px solid #E2E8F0; margin: 0;">
                        Descripción del módulo.
                    </p>
                </div>

                <div style="background: #F1F5F9; border-radius: 10px; padding: 16px; margin-bottom: 10px;">
                    <h5 style="font-weight: 700; color: #0F172A; margin: 0 0 8px 0; font-size: 13px;">
                        <i class="fa fa-lightbulb text-primary"></i> ¿Cómo activarlo?
                    </h5>
                    <ul style="margin: 0; padding-left: 20px; color: #475569; font-size: 12px; line-height: 1.6;">
                        <li><strong>Notificar al Administrador:</strong> Pulsa el botón para enviar una solicitud formal de habilitación.</li>
                        <li><strong>Actualizar Plan:</strong> Revisa nuestros planes de suscripción que incluyen este y otros módulos.</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer" style="background: #F8FAFC; border-top: 1px solid #E2E8F0; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">
                    <i class="fa fa-times"></i> Cerrar
                </button>
                <div style="display: flex; gap: 8px;">
                    <button type="button" class="btn btn-info" id="btn_send_module_request" style="border-radius: 8px; font-weight: 600;">
                        <i class="fa fa-paper-plane"></i> Notificar al Administrador
                    </button>
                    @if(Module::has('Superadmin'))
                        <a href="{{ action([\Modules\Superadmin\Http\Controllers\SubscriptionController::class, 'index']) }}" class="btn btn-primary" style="border-radius: 8px; font-weight: 600;">
                            <i class="fa fa-crown text-warning"></i> Ver Planes
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).on('click', '.btn-upgrade-modal-trigger', function(e) {
        e.preventDefault();
        var moduleKey = $(this).data('module');
        var moduleName = $(this).data('name');
        var moduleDesc = $(this).data('desc');
        var moduleIcon = $(this).data('icon');

        $('#modal_module_key').val(moduleKey);
        $('#modal_module_name').text(moduleName);
        $('#modal_module_desc').text(moduleDesc);
        $('#modal_module_icon').attr('class', moduleIcon);

        $('#module_upgrade_modal').modal('show');
    });

    $(document).on('click', '#btn_send_module_request', function(e) {
        e.preventDefault();
        var $btn = $(this);
        var originalHtml = $btn.html();
        var moduleKey = $('#modal_module_key').val();
        var moduleName = $('#modal_module_name').text();

        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Enviando...');

        $.ajax({
            url: "{{ route('subscription.request-module') }}",
            type: 'POST',
            data: {
                module_key: moduleKey,
                module_name: moduleName,
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    toastr.success(response.msg);
                    $btn.html('<i class="fa fa-check"></i> Solicitud Enviada');
                    setTimeout(function() {
                        $('#module_upgrade_modal').modal('hide');
                        $btn.prop('disabled', false).html(originalHtml);
                    }, 1500);
                } else {
                    toastr.error(response.msg);
                    $btn.prop('disabled', false).html(originalHtml);
                }
            },
            error: function() {
                toastr.error('Ocurrió un error al enviar la solicitud.');
                $btn.prop('disabled', false).html(originalHtml);
            }
        });
    });
</script>