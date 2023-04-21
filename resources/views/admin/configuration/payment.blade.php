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
                    @forelse ($payments as $payment)
                        <tr>
                            <td>{{ $payment->description }}</td>
                            <td style="width=10px;">
                                @if (!$tenantPayments->where('payment_id', $payment->id)->first())
                                    <form action="{{ route('payment.active') }}" method="POST" class="form form-inline">
                                        @csrf
                                        <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                        <button class="btn btn-sm btn-success">
                                            Habilitar
                                        </button>
                                    </form>
                                @endif

                                @php
                                    $tenantPayment = $tenantPayments->where('payment_id', $payment->id)->first();
                                @endphp

                                @if ($tenantPayment && $tenantPayment->status == 1)
                                    <div class="d-flex flex-row">
                                        <form action="{{ route('payment.disable', [$tenantPayment->id]) }}" method="POST"
                                            class="form form-inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-danger">
                                                Desativar
                                            </button>
                                        </form>
    
                                        @if($payment->route_base)
                                            <a href="{{ route($payment->route_base, [$tenantPayment->id]) }}" class="btn btn-sm btn-warning ms-2">
                                                <i class="fa-solid fa-gear"></i>
                                            </a>
                                        @endif
                                    </div>
                                @endif

                                @if ($tenantPayment && $tenantPayment->status == 0)
                                    <form action="{{ route('payment.enable', [$tenantPayment->id]) }}" method="POST"
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
