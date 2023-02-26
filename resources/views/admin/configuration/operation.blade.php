@extends('layouts.admin.dashboard')

@section('content')
    @include('admin.configuration._partials.navbar')


    <div class="alert alert-warning">
        <strong>Atenção:</strong>
        Os detalhes do funcionamento é apenas para fins de informação do seu cliente. Sua loja só reberá pedidos
        caso ela esteja
        <strong>Aberta</strong>
        ou habilitada para rebecer pedidos quando
        <strong>Fechada</strong>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="card mb-3">
                <div class="cart-body">
                    <div class="card-header">* Receber pedidos com a loja fechada?</div>
                    <div class="form-group mt-2">
                        <form action="{{ route('tenant.order_when_closed') }}" method="POST" class="form form-inline">
                            @csrf
                            <div class="container mb-2">
                                <select name="order_when_closed" class="form-control form-control-sm">
                                    <option value="1" {{ $tenant->order_when_closed == '1' ? 'selected' : '' }}>Sim
                                    </option>
                                    <option value="0" {{ $tenant->order_when_closed == '0' ? 'selected' : '' }}>Não
                                    </option>
                                </select>
                                <div class="form-group mt-2" align="right">
                                    <button type="submit" class="btn btn-sm btn-success">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="cart-body">
                    <div class="card-header">
                        Nesse momento o seu estabelecimento está
                        <strong>{{ $tenant->open == 'N' ? 'Fechado' : 'Aberto' }}</strong>
                    </div>
                    <div class="form-group mt-2">
                        <form action="{{ route('tenant.open') }}" method="POST" class="form form-inline">
                            @csrf
                            <div class="container mb-2">
                                <input type="hidden" name="open" value="{{ $tenant->open == 'N' ? 'Y' : 'N' }}">
                                <div class="form-group mt-2" align="center">
                                    <button type="submit"
                                        class="btn btn-sm btn-{{ $tenant->open == 'N' ? 'success' : 'warning' }}">{{ $tenant->open == 'N' ? 'Abrir' : 'Fechar' }}
                                        estabelecimento</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th width="150">Ações</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($operationDays as $operationDay)
                                <tr>
                                    <td>{{ $operationDay->description }}</td>
                                    <td style="width=10px;">
                                        @if (!$tenantOperations->where('operation_day_id', $operationDay->id)->first())
                                            <form action="{{ route('operation.active') }}" method="POST"
                                                class="form form-inline">
                                                @csrf
                                                <input type="hidden" name="operation_day_id"
                                                    value="{{ $operationDay->id }}">
                                                <button class="btn btn-sm btn-success">
                                                    Habilitar
                                                </button>
                                            </form>
                                        @endif

                                        @php
                                            $tenantOperationDay = $tenantOperations->where('operation_day_id', $operationDay->id)->first();
                                        @endphp

                                        @if ($tenantOperationDay && $tenantOperationDay->status == 1)
                                            <form action="{{ route('operation.disable', [$tenantOperationDay->id]) }}"
                                                method="POST" class="form form-inline">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-sm btn-danger">
                                                    Desativar
                                                </button>
                                            </form>
                                        @endif

                                        @if ($tenantOperationDay && $tenantOperationDay->status == 0)
                                            <form action="{{ route('operation.enable', [$tenantOperationDay->id]) }}"
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
                                        @if ($tenantOperationDay && $tenantOperationDay->status == 1)
                                            <a href="{{ route('operation.detail', $tenantOperationDay->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fa-solid fa-gear"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <p class="text-center">Não há pagamentos para listar</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@stop

@section('js')
    <script>
        function openModal(modal) {

        }
    </script>
@stop
