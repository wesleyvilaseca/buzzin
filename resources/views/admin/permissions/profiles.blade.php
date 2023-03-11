@extends('layouts.admin.dashboard')

@section('content')
<div class="mb-2" align="right">
    <div class="mb-2" align="right">
        <a href="{{ route('admin.permissions') }}" class="btn btn-sm btn-dark">
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
                    @foreach ($profiles as $profile)
                        <tr>
                            <td>
                                {{ $profile->name }}
                            </td>
                            <td style="width=10px;">
                                <a href="{{ route('profiles.permission.detach', [$profile->id, $permission->id]) }}"
                                    class="btn btn-sm btn-danger">Desvincular</a>
                            </td>
                        </tr>
                    @endforeach
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
