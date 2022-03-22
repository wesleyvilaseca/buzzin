@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <div class="mb-2" align="right">
            <a href="{{ route('details.plan.index', $plano->id) }}" class="btn btn-sm btn-dark">
                <i class="fa-solid fa-chevron-left me-2"></i>
                Voltar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <ul>
                <li>
                    <strong>Nome:</strong> {{ $detail->name }}
                </li>
            </ul>
        </div>
        <div class="card-footer">
            <form action="{{ route('details.plan.destroy', [$plano->id, $detail->id]) }}" method="post">
                @csrf
                @method('DELETE')
                <div class="text-center">
                    <button type="submit" class="btn btn-danger">Deletar o Detalhe {{ $detail->name }}, do plano
                        {{ $plano->name }}</button>
                </div>
            </form>
        </div>
    </div>
@stop
