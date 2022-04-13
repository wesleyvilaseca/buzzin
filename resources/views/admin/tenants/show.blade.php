@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('admin.tenants') }}" class="btn btn-sm btn-dark">
            <i class="fa-solid fa-chevron-left me-2"></i>
            Voltar</a>
    </div>

    <div class="card">
        <div class="card-body">
            <ul>
                <div class="text-center">
                    <img src="{{ Storage::url("$tenant->logo") }}" alt="{{ $tenant->name }}" style="max-width: 90px;">
                </div>
                <li>
                    <strong>Título: </strong> {{ $tenant->name }}
                </li>
            </ul>


            <form action="{{ route('tenant.destroy', $tenant->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="text-center">
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> DELETAR o EMPRESA {{ $tenant->title }}</button>
                </div>
            </form>
        </div>
    </div>
@stop
