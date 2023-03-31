@extends('layouts.admin.dashboard')

@section('content')
    @php
        $key = env('MP_PRODUCTION') ? env('MERCADO_PAGO_PUBLIC_KEY') : env('MERCADO_PAGO_SANDBOX_PUBLIC_KEY');
        $tenant = Auth::user()->tenant;
        $tenant->mpkey = $key;
    @endphp
    <subscription-tenant :tenant='@json($tenant)'>
        <subscription-tenant />
@endsection

@section('scripts-header')
    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
@endsection