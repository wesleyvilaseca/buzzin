@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <div class="mb-2" align="right">
            {{-- <a href="{{  route('profiles.permissions.available', $profile->id) }}" class="btn btn-sm btn-primary">Novo</a> --}}

            <a href="{{ route('admin.profiles') }}" class="btn btn-sm btn-dark">
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
                        <th width="50">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($permissions as $permission)
                        <tr>
                            <td>
                                {{ $permission->name }}
                            </td>
                            <td style="width=10px;">
                                <a href="{{ route('profiles.permission.detach', [$profile->id, $permission->id]) }}"
                                    class="btn btn-danger">Desvincular</a>
                            </td>
                        </tr>
                    @empty
                        <p class="text-center">Não há permissions para listar</p>
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
