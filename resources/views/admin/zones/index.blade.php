@extends('layouts.admin.dashboard')

@section('scripts-header')

@stop
@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('zone.geolocation.create') }}" class="btn btn-sm btn-primary">Novo</a>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="#" method="POST" class="form form-inline">
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
                    @forelse ($zones as $zone)
                        <tr>
                            <td>
                                {{ $zone->name }}
                            </td>
                            <td style="width=10px;">
                                <a href="{{ route('zone.geolocation.edit', [$zone->id]) }}" class="btn btn-sm btn-info me-1">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-warning me-1">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <p class="text-center">Não há zonas para listar</p>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if (isset($filters))
                {!! $zones->appends($filters)->links() !!}
            @else
                {!! $zones->links() !!}
            @endif
        </div>
    </div>

@stop

@section('js')

@stop
