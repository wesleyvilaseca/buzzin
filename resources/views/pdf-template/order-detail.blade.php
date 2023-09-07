@extends('layouts.pdf-template.base-theme')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card mt-2">
                <div class="card-header">Dados do cliente</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5" style="font-size:0.8rem">
                            Cliente: {{ $order->client?->name }} <br>
                            Email: {{ $order->client?->email }} <br>
                            Celular: {{ $order->client_mobile_phone }} <br>
                            CPF: {{ $order->client_doc }}
                        </div>
                        @if ($order?->shipping_method?->alias !== 'getonstore')
                            <div class="col-md-7" style="font-size:0.8rem">
                                Endereço: {{ $order->client_address->address }} - nº:
                                {{ $order->client_address->number }}<br>
                                Complemento: {{ $order->client_address->complement }} <br>
                                Bairro: {{ $order->client_address->district }} <br>
                                CEP: {{ $order->client_address->zip_code }} <br>
                                {{ $order->client_address->city }} - {{ $order->client_address->state }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header">
                    Número do pedido: {{ $order->identify }} <br>
                    Data: {{ $order->date_br }} <br>
                    Status: {{ $order->status_label }}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Produto</th>
                                    <th scope="col">Quantidade</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->products as $product)
                                    <tr>
                                        <td><img src="{{ $product->image }}" alt="{{ $product->title }}"
                                                style="max-width: 50px;">
                                        </td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->qty }}</td>
                                        <td>R$ {{ $product->price }}</td>
                                        <td>R$ {{ $product->qty * $product->price }}</td>
                                    </tr>
                                    @php
                                        $subtotal += $product->qty * $product->price;
                                    @endphp
                                @endforeach

                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="4" align="right">
                                        <strong>Subtotal</strong>
                                    </td>
                                    <td> R$ {{ $subtotal }}</td>
                                </tr>

                                <tr>
                                    <td colspan="4" align="right">
                                        <strong>
                                            {{ $order->shipping_method->description }}
                                        </strong>
                                    </td>

                                    @if ($order->shipping_method->alias !== 'getonstore')
                                        <td> R$ {{ $order->shipping_method->price }}</td>
                                    @else
                                        <td> R$ 0,00</td>
                                    @endif
                                </tr>

                                <tr>
                                    <td colspan="4" align="right">
                                        <strong>
                                            Forma de pagamento
                                        </strong>
                                    </td>
                                    @if ($order->payment_method?->integration)
                                        <td>
                                            @switch($order->order_integration_transaction->payment_type_id)
                                                @case('ticket')
                                                    Boleto
                                                @break

                                                @default
                                                    Cartão de crédito
                                            @endswitch
                                        </td>
                                    @else
                                        <td>{{ $order->payment_method->description }}</td>
                                    @endif
                                </tr>

                                <tr>
                                    <td colspan="4" align="right">
                                        <strong>
                                            Total
                                        </strong>
                                    </td>
                                    <td> R$ {{ $order->total }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
