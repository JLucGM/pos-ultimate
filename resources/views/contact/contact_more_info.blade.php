@php
    $custom_labels = json_decode(session('business.custom_labels'), true);
@endphp

@if(!empty($contact->custom_field1))
    <strong>{{ $custom_labels['contact']['custom_field_1'] ?? __('lang_v1.contact_custom_field1') }}</strong>
    <p class="text-muted">
        {{ $contact->custom_field1 }}
    </p>
@endif