@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <div class="mb-2" align="right">
            <a href="{{ route('admin.profiles') }}" class="btn btn-sm btn-dark">
                <i class="fa-solid fa-chevron-left me-2"></i>
                Voltar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <ul>
                <li>
                    <strong>Nome: </strong> {{ $profile->name }}
                </li>
                <li>
                    <strong>Descrição: </strong> {{ $profile->description }}
                </li>
            </ul>

            <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="text-center">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i>
                        DELETAR O PERFIL:{{ $profile->name }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
