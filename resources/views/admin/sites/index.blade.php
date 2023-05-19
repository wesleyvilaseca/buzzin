@extends('layouts.admin.dashboard')

@section('content')
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
                        <th>Empresa</th>
                        <th>Subdominio</th>
                        <th>Status</th>
                        <th>Em manutenção?</th>
                        <th width="270">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sites as $site)
                        <tr>
                            <td>
                                {{ $site->tenant->name }}
                            </td>
                            <td>
                                {{ $site->subdomain }}
                            </td>
                            <td>
                                @switch($site->status)
                                    @case(0)
                                        <span class="alert alert-warning p-1">
                                            Aguardando aprovação e publicação
                                        </span>
                                    @break

                                    @case(1)
                                        <span class="alert alert-success p-1">
                                            Publicado
                                        </span>
                                    @break

                                    @case(2)
                                        <span class="alert alert-danger p-1">
                                            Desativado pela administração
                                        </span>
                                    @break
                                @endswitch
                            </td>

                            <td>
                                @if ($site->maintence == 1)
                                    <span class="alert alert-warning p-1">
                                        Sim
                                    </span>
                                @else
                                    <span class="alert alert-info p-1">
                                        Não
                                    </span>
                                @endif
                            </td>
                            <td style="width=10px;">
                                <a href="{{ route('admin.sites.edit', $site->id) }}" class="btn btn-sm btn-info me-1">
                                    <i class="fa-solid fa-pen-to-square"></i>
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
                    {!! $sites->appends($filters)->links() !!}
                @else
                    {!! $sites->links() !!}
                @endif
            </div>
        </div>
    @stop
