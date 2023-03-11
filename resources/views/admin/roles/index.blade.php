@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <div class="mb-2" align="right">
            <a href="{{ route('role.create') }}" class="btn btn-sm btn-primary">Novo</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="{{ route('role.search') }}" method="POST" class="form form-inline">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="filter" placeholder="Cargo" class="form-control form-control-sm"
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
                        <th width="250">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>
                                {{ $role->name }}
                            </td>
                            <td style="width=10px;">
                                <a href="{{ route('role.edit', $role->id) }}" class="btn btn-sm btn-primary me-1">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="{{ route('role.show', $role->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('roles.permissions', $role->id) }}" class="btn btn-sm btn-info"><i
                                        class="fas fa-address-book"></i>
                                    </a>
                            </td>
                        </tr>
                    @empty
                        <p class="text-center">Não há cargos para listar</p>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if (isset($filters))
                {!! $roles->appends($filters)->links() !!}
            @else
                {!! $roles->links() !!}
            @endif
        </div>
    </div>
@stop
