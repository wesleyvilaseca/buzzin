@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('admin.plan') }}" class="btn btn-sm btn-dark">
            <i class="fa-solid fa-chevron-left me-2"></i>
            Voltar</a>
    </div>
    <div class="card">
        <div class="card-body">
            <ul>

                <li>
                    <strong>Nome: </strong> {{ $plano->name }}
                </li>
                @if (@$plabo->url)
                    <li>
                        <strong>URL: </strong> {{ $plano->url }}
                    </li>
                @endif
                <li>
                    <strong>Preço: </strong> R$ {{ number_format($plano->price, 2, ',', '.') }}
                </li>
                <li>
                    <strong>Descrição: </strong> {{ $plano->description }}
                </li>
            </ul>

            <form action="{{ route('plans.destroy', $plano->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="text-center">
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> DELETAR O PLANO
                        {{ $plano->name }}</button>
                </div>
            </form>
        </div>
    </div>
@stop
