@extends('admin.layout.admin')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('plans.create') }}" class="btn btn-sm btn-primary">Novo</a>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="{{ route('plans.search') }}" method="POST" class="form form-inline">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="filter" placeholder="Plano" class="form-control form-control-sm"
                            value="{{ $filters['filter'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-sm btn-dark">Pesquisar</button>
                    </div>
                </div>

            </form>
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th width="270">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($plans as $plan)
                        <tr>
                            <td>
                                {{ $plan->name }}
                            </td>
                            <td>
                                R$ {{ number_format($plan->price, 2, ',', '.') }}
                            </td>
                            <td style="width=10px;">
                                <a href="{{ route('details.plan.index', $plan->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-info-circle"></i></a>
                                <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-sm btn-info"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <a href="{{ route('plans.show', $plan->id) }}" class="btn btn-sm btn-warning"><i
                                        class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('plans.profiles', $plan->id) }}" class="btn btn-sm btn-warning"><i
                                        class="fas fa-address-book"></i></a>
                            </td>
                        </tr>
                    @empty
                        <p class="text-center">Não há planos para listar</p>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if (isset($filters))
                {!! $plans->appends($filters)->links() !!}
            @else
                {!! $plans->links() !!}
            @endif
        </div>
    </div>
@stop
