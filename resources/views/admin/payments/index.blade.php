@extends('layouts.admin.dashboard')

@section('content')
    @extends('layouts.admin.dashboard')

@section('content')
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
                                    <form action="{{ route('payment.disable', [$tenantPayment->id]) }}" method="POST"
                                        class="form form-inline">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-danger">
                                            Desativar
                                        </button>
                                    </form>
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
@stop
