@extends('layouts.admin.dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $key => $transaction)
                        @php
                            $status_pt = __('mercadopago.' . $transaction->status);
                            $status_detail = __('mercadopago.' . $transaction->status_detail, [
                                'statement_descriptor' => $transaction->description,
                                'payment_method_id' => $transaction->payment_method_id,
                            ]);
                            $transaction->data = json_decode($transaction->data);
                        @endphp
                        <tr>
                            <td>
                                @if ($transaction->type_transaction == 'subscription')
                                    Assinatura de plano - <strong>{{ $transaction?->data?->name }}</strong>
                                @endif
                            </td>
                            <td>
                                @switch($transaction->payment_type_id)
                                    @case('credit_card')
                                        Cartão de crédito
                                    @break

                                    @case('ticket')
                                        Boleto
                                    @break
                                @endswitch
                            </td>

                            <td>
                                @switch($transaction->status)
                                    @case('approved')
                                        <span class="alert alert-success p-1">
                                            {{ $status_pt }}
                                        </span>
                                    @break

                                    @case('cancelled')
                                        <span class="alert alert-danger p-1">
                                            {{ $status_pt }}
                                        </span>
                                    @break

                                    @default
                                        <span class="alert alert-warning p-1">
                                            {{ $status_pt }}
                                        </span>
                                @endswitch
                            </td>
                            <td style="width=10px;">
                                <a href="#" class="btn btn-sm btn-warning me-1" title="Categorias"><i
                                        class="fas fa-layer-group"></i></a>
                                <a href="#" class="btn btn-sm btn-info me-1">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                @if ('ticket')
                                    <a href="{{ $transaction->external_resource_url }}" class="btn btn-sm btn-warning me-1"
                                        target="_blank">
                                        <i class="fa-solid fa-barcode"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {!! $transactions->links() !!}
        </div>
    @endsection
