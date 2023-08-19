@extends('layouts.admin.dashboard')

@php
    $tab = @$_GET['tab'];
@endphp

@section('content')

    @if (@isset($site) && ($site->status == 1 || $site->status == 2))
        @include('admin.site._partials.navbar')

        <div class="card">
            <div class="card-body">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($extensions as $extension)
                            <tr>
                                <td>{{ $extension->description }} - <strong>{{ $extension->detail }}</strong></td>
                                <td class="text-center">
                                    @if ($extension->free)
                                        <span class="alert alert-success p-0">Grátis</span>
                                    @else
                                        <span class="alert alert-primary p-0">Limeração sob pagamento</span>
                                    @endif
                                </td>
                                <td class="text-center">

                                    <img src="{{ Storage::url("$extension->image") }}" alt="{{ $extension->title }}"
                                        style="max-width: 90px; cursor:pointer;" data-bs-toggle="modal"
                                        data-bs-target="#{{ Str::slug($extension->description) . 'modal' }}" />

                                    <!-- Modal -->
                                    <div class="modal fade" id="{{ Str::slug($extension->description) . 'modal' }}"
                                        tabindex="-1" aria-labelledby="{{ Str::slug($extension->description) . 'modal' }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Imagem de exemplo</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="{{ Storage::url("$extension->image") }}"
                                                        alt="{{ $extension->title }}" data-bs-toggle="modal"
                                                        data-bs-target="#{{ $extension->id . 'modal' }}"
                                                        style="max-width:100%;" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        data-bs-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>

                                <td class="text-center">
                                    @if (!$tenantExtensions->where('site_extension_id', $extension->id)->first())
                                        <form action="{{ route('admin.site_extension.active') }}" method="POST"
                                            class="form form-inline">
                                            @csrf
                                            <input type="hidden" name="extension_id" value="{{ $extension->id }}">
                                            <button class="btn btn-sm btn-success">
                                                Habilitar
                                            </button>
                                        </form>
                                    @endif

                                    @php
                                        $tenantExtension = $tenantExtensions->where('site_extension_id', $extension->id)->first();
                                    @endphp

                                    @if ($tenantExtension && $tenantExtension->status == 1)
                                        <form action="{{ route('admin.site_extension.disable', [$tenantExtension->id]) }}"
                                            method="POST" class="form form-inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-danger">
                                                Desativar
                                            </button>
                                        </form>
                                    @endif

                                    @if ($tenantExtension && $tenantExtension->status == 0)
                                        <form action="{{ route('admin.site_extension.enable', [$tenantExtension->id]) }}"
                                            method="POST" class="form form-inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-primary">
                                                Ativar
                                            </button>
                                        </form>
                                    @endif

                                </td>
                                <td>
                                    @if ($tenantExtension && $tenantExtension->status == 1)
                                        <a href="{{ route($extension->route_base, [$tenantExtension->id]) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fa-solid fa-gear"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <p class="text-center">Não há extensões para listar</p>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@stop
