@if(!empty($__subscription) && env('APP_ENV') != 'demo')
    @php
        $is_trial = $__subscription->paid_via == 'trial';
        $end_carbon = !empty($__subscription->end_date) ? \Carbon\Carbon::parse($__subscription->end_date) : null;
        $days_left = $end_carbon ? \Carbon\Carbon::today()->diffInDays($end_carbon, false) : 0;
    @endphp

    @if($is_trial)
        <a href="{{ action([\Modules\Superadmin\Http\Controllers\SubscriptionController::class, 'index']) }}" 
           class="tw-inline-flex tw-items-center tw-gap-1.5 tw-px-2.5 tw-py-1 tw-rounded-full tw-text-xs tw-font-semibold tw-bg-amber-500/15 tw-text-amber-400 tw-border tw-border-amber-500/30 hover:tw-bg-amber-500/25 tw-transition-all"
           title="Período de prueba gratuito. Haz clic para activar tu suscripción definitiva.">
            <span class="tw-w-1.5 tw-h-1.5 tw-rounded-full tw-bg-amber-400 tw-animate-pulse"></span>
            <i class="fas fa-clock"></i>
            <span>Prueba: {{ $days_left > 0 ? $days_left . ' días' : ($days_left == 0 ? 'Último día' : 'Vencida') }}</span>
        </a>
    @else
        <a href="{{ action([\Modules\Superadmin\Http\Controllers\SubscriptionController::class, 'index']) }}" 
           class="tw-inline-flex tw-items-center tw-gap-1.5 tw-px-2.5 tw-py-1 tw-rounded-full tw-text-xs tw-font-semibold tw-bg-emerald-500/15 tw-text-emerald-400 tw-border tw-border-emerald-500/30 hover:tw-bg-emerald-500/25 tw-transition-all"
           title="{{ $__subscription->package_details['name'] ?? 'Plan Activo' }}">
            <i class="fas fa-check-circle"></i>
            <span>{{ $__subscription->package_details['name'] ?? 'Plan Activo' }}</span>
        </a>
    @endif
@endif