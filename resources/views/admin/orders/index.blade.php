@extends('layouts.admin.dashboard')

@section('content')
@stop

@section('scripts-header')
    <script>
        window.Laravel = {!! json_encode([
            'tenantId' => auth()->check() ? auth()->user()->tenant_id : '',
        ]) !!}
    </script>
@stop
