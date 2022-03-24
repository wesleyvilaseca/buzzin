@extends('layouts.site.site')

@section('content')
    @include('layouts.site._partials.header')

    @include('layouts.site._partials.features-header')

    @include('layouts.site._partials.what-is')

    @include('layouts.site._partials.features')

    @if (@isset($plans))
        @include('layouts.site._partials.plans', ['plans' => $plans])
    @endif
@stop
