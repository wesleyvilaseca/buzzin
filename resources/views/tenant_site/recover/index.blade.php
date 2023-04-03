@extends('layouts.tenant_site.site')

@section('scripts-header')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script>
        function callbackthen(res) {
            res.json().then((data) => {
                if (data.success && data.score > 0.5) {
                    document.getElementById('recaptcha').value = 'Y'
                } else {
                    document.getElementById('recaptcha').value = 'N'
                }
            })
        }

        function callbackcatch(error) {
            console.error(error);
        }
    </script>

    {!! htmlScriptTagJsApi([
        'callback_then' => 'callbackthen',
        'callback_catch' => 'callbackcatch',
    ]) !!}

@endsection

@section('content')
    <recover-tenant-view></recover-tenant-view>
@stop
