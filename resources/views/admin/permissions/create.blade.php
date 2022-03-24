@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <div class="mb-2" align="right">
            {{-- <a href="{{ route('permissions.create') }}" class="btn btn-sm btn-primary">Novo</a> --}}

            <a href="{{ route('admin.permissions') }}" class="btn btn-sm btn-dark">
                <i class="fa-solid fa-chevron-left me-2"></i>
                Voltar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('permissions.store') }}" class="form" method="POST">
                @include('admin.permissions._partials.form')
            </form>
        </div>
    </div>
@stop
