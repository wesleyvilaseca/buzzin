@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('admin.tables') }}" class="btn btn-sm btn-dark">
            <i class="fa-solid fa-chevron-left me-2"></i>
            Voltar</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div style="text-align: center;" class="visible-print">
                {!! QrCode::size(300)->generate($uri) !!}
                <p>{{ $uri }}</p>
            </div>

        </div>
    </div>
@stop
