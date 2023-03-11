@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <div class="mb-2" align="right">
            <a href="{{ route('details.plan.create', $plano->id) }}" class="btn btn-sm btn-primary">Novo</a>

            <a href="{{ route('admin.plan') }}" class="btn btn-sm btn-dark">
                <i class="fa-solid fa-chevron-left me-2"></i>
                Voltar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th width="150">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($details as $detail)
                        <tr>
                            <td>
                                {{ $detail->name }}
                            </td>
                            <td style="width=10px;">
                                <a href="{{ route('details.plan.edit', [$plano->id, $detail->id]) }}"
                                    class="btn btn-sm btn-info me-1">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="{{ route('details.plan.show', [$plano->id, $detail->id]) }}"
                                    class="btn btn-sm btn-warning me-1">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <p class="text-center">Não há detalhes para listar</p>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if (isset($filters))
                {!! $details->appends($filters)->links() !!}
            @else
                {!! $details->links() !!}
            @endif
        </div>
    </div>
@stop
