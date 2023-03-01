@extends('layouts.admin.dashboard')

@section('content')
    @include('admin.configuration._partials.navbar')

    <div class="card">
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th width="150">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shippings as $shipping)
                        <tr>
                            <td>{{ $shipping->description }} - <strong>{{ $shipping->detail }}</strong></td>
                            <td style="width=10px;">
                                @if (!$tenantShippings->where('shipping_id', $shipping->id)->first())
                                    <form action="{{ route('shipping.active') }}" method="POST" class="form form-inline">
                                        @csrf
                                        <input type="hidden" name="shipping_id" value="{{ $shipping->id }}">
                                        <button class="btn btn-sm btn-success">
                                            Habilitar
                                        </button>
                                    </form>
                                @endif

                                @php
                                    $tenantShipping = $tenantShippings->where('shipping_id', $shipping->id)->first();
                                @endphp

                                @if ($tenantShipping && $tenantShipping->status == 1)
                                    <form action="{{ route('shipping.disable', [$tenantShipping->id]) }}" method="POST"
                                        class="form form-inline">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-danger">
                                            Desativar
                                        </button>
                                    </form>
                                @endif

                                @if ($tenantShipping && $tenantShipping->status == 0)
                                    <form action="{{ route('shipping.enable', [$tenantShipping->id]) }}" method="POST"
                                        class="form form-inline">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-primary">
                                            Ativar
                                        </button>
                                    </form>
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
@stop
