@extends('layouts.app')
@section('title', __('role.add_role'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header" style="padding: 15px 15px 5px 15px;">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black" style="display: flex; align-items: center; gap: 10px;">
        <i class="fa fa-user-shield text-primary"></i> 
        <span>@lang('role.add_role')</span>
        <small class="tw-text-sm tw-text-gray-500 tw-font-normal" style="font-size: 14px; margin-left: 10px;">Configuración de accesos y permisos del sistema</small>
    </h1>
</section>

<!-- Main content -->
<section class="content" style="padding-top: 10px;">
    {!! Form::open(['url' => action([\App\Http\Controllers\RoleController::class, 'store']), 'method' => 'post', 'id' => 'role_add_form']) !!}
    
    <div class="box box-primary" style="border-radius: 12px; border-top: 4px solid #3B82F6; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); margin-bottom: 25px;">
        <div class="box-body" style="padding: 24px;">
            <div class="row">
                <div class="col-md-6 col-lg-5">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="name" style="font-size: 14px; font-weight: 700; color: #1E293B; margin-bottom: 8px; display: block;">
                            <i class="fa fa-tag text-primary" style="margin-right: 4px;"></i> {{ __('user.role_name') }}:*
                        </label>
                        {!! Form::text('name', null, [
                            'class' => 'form-control',
                            'required',
                            'placeholder' => __('user.role_name'),
                            'id' => 'name',
                            'style' => 'height: 44px; font-size: 15px; border-radius: 8px; border: 1.5px solid #CBD5E1; box-shadow: none; font-weight: 600; padding: 10px 14px;'
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('role.partials.permission_cards')

    <div class="row" style="margin-top: 20px; margin-bottom: 30px;">
        <div class="col-md-12 text-center">
            <button type="submit" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-lg tw-text-white" style="border-radius: 8px; font-weight: 700; padding: 12px 36px; font-size: 16px; box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);">
                <i class="fa fa-save" style="margin-right: 6px;"></i> @lang('messages.save')
            </button>
        </div>
    </div>

    {!! Form::close() !!}
</section>
<!-- /.content -->
@endsection

@section('javascript')
    @include('role.partials.permission_cards_js')
@endsection