@extends('layouts.admin.dashboard')

@section('content')
<div class="card">
        <div class="card-body">
            <ul>
                <li>
                    <strong>Nome: </strong> {{ $role->name }}
                </li>
                <li>
                    <strong>Descrição: </strong> {{ $role->description }}
                </li>
            </ul>

            <form action="{{ route('role.destroy', $role->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="text-center">
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> DELETAR O PERFIL: {{ $role->name }}</button>
                </div>
            </form>
        </div>
    </div>
@stop
