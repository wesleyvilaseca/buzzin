@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <div class="mb-2" align="right">
            <a href="{{ route('admin.users') }}" class="btn btn-sm btn-dark">
                <i class="fa-solid fa-chevron-left me-2"></i>
                Voltar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <ul>
                <li>
                    <strong>Nome: </strong> {{ $user->name }}
                </li>
                <li>
                    <strong>E-mail: </strong> {{ $user->email }}
                </li>
                <li>
                    <strong>Empresa: </strong> {{ $user->tenant->name }}
                </li>
            </ul>

            <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="text-center">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i> DELETAR O USUÁRIO
                        {{ $user->name }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
