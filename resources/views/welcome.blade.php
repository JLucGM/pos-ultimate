<script>window.location.href = "{{ url('/') }}";</script>
@extends('superadmin::layouts.landing')
@section('title', config('app.name', 'Audaz POS'))
@section('content')
    @include('superadmin::landing.index')
@endsection
            