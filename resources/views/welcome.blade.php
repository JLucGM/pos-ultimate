<script>window.location.href = "{{ url('/') }}";</script>
@extends('superadmin::layouts.landing')
@section('title', config('app.name', 'Kubre'))
@section('content')
    @include('superadmin::landing.index')
@endsection
            