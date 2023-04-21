@extends('layouts.admin.dashboard')

@section('content')
    @include('admin.configuration._partials.navbar')

    <div class="card">
        <div class="card-body">
            <h4>Mercado Pago checkout transparente</h4>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route($payment->payment->route_base . '.store', [$payment->id]) }}" class="form"
                        method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mt-2">
                            <label>* Teste?
                                <i class="fa-solid fa-circle-info text-primary" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="No modo teste, a 'public key' e o 'access token' devem ser o de teste"></i>
                            </label>
                            <select name="sandbox" class="form-control form-control-sm" required>
                                <option value="0" {{ @$payment?->data?->sandbox == '0' ? 'selected' : '' }}>Não
                                </option>
                                <option value="1" {{ @$payment?->data?->sandbox == '1' ? 'selected' : '' }}>Sim
                                </option>
                            </select>
                        </div>

                        <div class="form-group mt-2">
                            <label>* Public key:</label>
                            <input type="text" class="form-control form-control-sm" name="public_key" id="public_key"
                                value="{{ $payment?->data?->public_key ?? old('public_key') }}" required>
                        </div>
                        <div class="form-group mt-2">
                            <label>* Access Token:</label>
                            <input type="text" name="access_token" class="form-control form-control-sm"
                                value="{{ $payment?->data?->access_token ?? old('access_token') }}" required>
                        </div>

                        <hr>
                            <div class="text-center">
                                <h6>Formas de pagamento</h6>
                            </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="boleto" name="slip" value="S"  {{ @$payment?->data?->slip == 'S' ? 'checked' : '' }} />
                            <label class="form-check-label" for="boleto">Pagamento por boleto bancário</label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="card" name="card" value="S" {{ @$payment?->data?->card == 'S' ? 'checked' : '' }} />
                            <label class="form-check-label" for="card">Pagamento por cartão de crédito</label>
                        </div>

                        <div class="form-group mt-5 text-center card-footer">
                            <button type="submit" class="btn btn-sm btn-success">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
