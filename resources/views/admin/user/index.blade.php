@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">Novo</a>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="{{ route('user.search') }}" method="POST" class="form form-inline">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="filter" placeholder="Usuário" class="form-control form-control-sm"
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
                        @if ($superAdmin)
                            <th>Empresa</th>
                        @endif
                        <th>E-mail</th>
                        <th width="270">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            @if ($superAdmin)
                                <td>{{ $user->tenant->name }}</td>
                            @endif
                            <td>{{ $user->email }}</td>
                            <td style="width=10px;">
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-info">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="{{ route('user.show', $user->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('users.roles', $user->id) }}" class="btn btn-sm btn-info" title="Cargos">
                                    <i class="fas fa-address-card"></i>
                                </a>
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
                {!! $users->appends($filters)->links() !!}
            @else
                {!! $users->links() !!}
            @endif
        </div>
    </div>
@stop
