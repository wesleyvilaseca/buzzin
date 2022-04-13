@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('profiles.create') }}" class="btn btn-sm btn-primary">Novo</a>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="{{ route('profiles.search') }}" method="POST" class="form form-inline">
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
                        <th width="270">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($profiles as $profile)
                        <tr>
                            <td>
                                {{ $profile->name }}
                            </td>
                            <td style="width=10px;">
                                <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-sm btn-info">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="{{ route('profiles.show', $profile->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('profile.permissions', $profile->id) }}" class="btn btn-sm btn-success"><i class="fa-solid fa-list-check"></i></a>
                                {{-- <a href="{{ route('profiles.plans', $profile->id) }}" class="btn btn-info"><i class="fas fa-list-alt"></i></a> --}}
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
                {!! $profiles->appends($filters)->links() !!}
            @else
                {!! $profiles->links() !!}
            @endif
        </div>
    </div>
@stop
