@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('admin.tables') }}" class="btn btn-sm btn-dark">
            <i class="fa-solid fa-chevron-left me-2"></i>
            Voltar</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('table.update', $table->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')
                @include('admin.tables._partials.form', ['table' => $table])
            </form>
        </div>
    </div>
@stop
