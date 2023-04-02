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
                                @if ($transaction->payment_type_id == 'credit_card')
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Detalhes</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ $status_detail }}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        data-bs-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($transaction->payment_method_id = 'bolbradesco')
                                    @if ($transaction->status == 'pending')
                                        <a href="{{ $transaction->external_resource_url }}"
                                            class="btn btn-sm btn-light me-1" target="_blank">
                                            <i class="fa-solid fa-barcode"></i>
                                        </a>
                                    @endif
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
