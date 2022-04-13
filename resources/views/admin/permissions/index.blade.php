@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <div class="mb-2" align="right">
            <a href="{{ route('permissions.create') }}" class="btn btn-sm btn-primary">Novo</a>

            {{-- <a href="{{ route('admin.profiles') }}" class="btn btn-sm btn-dark">
                <i class="fa-solid fa-chevron-left me-2"></i>
                Voltar</a> --}}
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="{{ route('permissions.search') }}" method="POST" class="form form-inline">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="filter" placeholder="Permissão" class="form-control form-control-sm"
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
                    @forelse($permissions as $permission)
                        <tr>
                            <td>
                                {{ $permission->name }}
                            </td>
                            <td style="width=10px;">
                                <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-sm btn-info">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="{{ route('permissions.show', $permission->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('permissions.profiles', $permission->id) }}" class="btn btn-sm btn-info"><i
                                        class="fas fa-address-book"></i>
                                    </a>
                            </td>
                        </tr>
                    @empty
                        <p class="text-center">Não há permissões para listar</p>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if (isset($filters))
                {!! $permissions->appends($filters)->links() !!}
            @else
                {!! $permissions->links() !!}
            @endif
        </div>
    </div>
@stop
