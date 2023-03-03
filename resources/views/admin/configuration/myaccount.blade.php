@extends('layouts.admin.dashboard')

@section('content')
    @include('admin.configuration._partials.navbar')

    <div class="row">
        <div class="col-md-7">
            <div class="card mb-3">
                <div class="cart-body">
                    <div class="card-header">Dados da empresa</div>
                    <div class="form-group mt-2">
                        <form action="{{ route('update.dataaccount') }}" method="POST" class="form form-inline"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="container mb-2">
                                <div class="text-center">
                                    <img src="{{ @$tenant->logo ? Storage::url("{$tenant->logo}") : asset('images/no-image.png') }}"
                                        alt="{{ $tenant->name }}" style="max-width: 90px;" />
                                </div>

                                <div class="form-group mt-2">
                                    <label>* Logo:</label>
                                    <input type="file" name="image" class="form-control form-control-sm">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mt-2">
                                            <label>Nome da loja:</label>
                                            <input type="text" class="form-control form-control-sm"
                                                value="{{ @$tenant->name ?? old('name') }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mt-2">
                                            <label>Email principal:</label>
                                            <input type="text" class="form-control form-control-sm"
                                                value="{{ @$tenant->email ?? old('email') }}" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group mt-2 mb-2">
                                        <label>CNPJ:</label>
                                        <input type="text" id="cnpj" name="new_password_confirm"
                                            class="form-control form-control-sm" value="{{ @$tenant->cnpj ?? old('cnpj') }}"
                                            disabled>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="text-center mb-2">
                                        <h5>Endereço</h5>
                                    </div>
                                    <div class="form-group mt-2 col-md-4">
                                        <label>CEP:</label>
                                        <input type="text" id="zip_code" name="zip_code"
                                            class="form-control form-control-sm" placeholder="CEP:" onblur="buscacep(value)"
                                            value="{{ @$tenant->zip_code ?? old('zip_code') }}" required>
                                    </div>

                                    <div class="form-group mt-2 col-md-5">
                                        <label>Cidade:</label>
                                        <input type="text" id="city" name="city"
                                            class="form-control form-control-sm" placeholder="Cidade:"
                                            value="{{ @$tenant->city ?? old('city') }}" readonly required>
                                    </div>


                                    <div class="form-group mt-2 col-md-2">
                                        <label>UF:</label>
                                        <input type="text" id="state" name="state"
                                            class="form-control form-control-sm" placeholder="UF:"
                                            value="{{ @$tenant->state ?? old('state') }}" readonly required>
                                    </div>

                                    <div class="form-group mt-2 col-md-5">
                                        <label>Bairro:</label>
                                        <input type="text" id="district" name="district"
                                            class="form-control form-control-sm" placeholder="Bairro:"
                                            value="{{ @$tenant->district ?? old('district') }}" readonly required>
                                    </div>

                                    <div class="form-group mt-2 col-md-5">
                                        <label>Endereço:</label>
                                        <input type="text" id="address" name="address"
                                            class="form-control form-control-sm" placeholder="Endereço:"
                                            value="{{ @$tenant->address ?? old('address') }}" required>
                                    </div>

                                    <div class="form-group mt-2 col-md-2">
                                        <label>Numero:</label>
                                        <input type="text" name="number" class="form-control form-control-sm"
                                            placeholder="Numero:" value="{{ @$tenant->number ?? old('number') }}">
                                    </div>
                                </div>

                                <div class="form-group mt-2" align="right">
                                    <button type="submit" class="btn btn-sm btn-success">Atualizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card mb-3">
                <div class="cart-body">
                    <div class="card-header">Atualizar senha</div>
                    <div class="form-group mt-2">
                        <form action="{{ route('update.passwordaccount') }}" method="POST" class="form form-inline">
                            @csrf
                            @method('PUT')
                            <div class="container mb-2">

                                <div class="form-group mt-2">
                                    <label>Senha atual:</label>
                                    <input type="password" name="password" class="form-control form-control-sm"
                                        autocomplete="off" minlength="8" value="{{ old('password') }}" required>
                                </div>

                                <div class="form-group mt-2">
                                    <label>Nova senha:</label>
                                    <input type="password" name="new_password" class="form-control form-control-sm"
                                        autocomplete="off" minlength="8" value="{{ old('new_password') }}" required>
                                </div>

                                <div class="form-group mt-2">
                                    <label>Confirme a nova senha:</label>
                                    <input type="password" name="new_password_confirm"
                                        class="form-control form-control-sm" autocomplete="off" minlength="8"
                                        value="{{ old('new_password_confirm') }}" required>
                                </div>


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
                    <div class="card-header">Plano</div>
                    <div class="form-group mt-2">
                        <form action="#" method="POST" class="form form-inline">
                            @csrf
                            @method('PUT')
                            <div class="container mb-2">

                                <div class="form-group mt-2">
                                    <label>Plano atual</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ $tenant->plan->name }}" disabled>
                                </div>

                                <div class="form-group mt-2" align="center">
                                    <button type="button" class="btn btn-sm btn-primary"
                                        onclick="return alert('colocar a funcionalidade')">Mudar plano</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script type="text/javascript">
        jQuery(function($) {
            $('#zip_code').mask("00000-000");
            $('#cnpj').mask("00.000.000/0000-00");
        });

        function buscacep(cep) {
            if (cep.length == 9) {
                $.ajax({
                    url: `https://viacep.com.br/ws/${cep}/json/`,
                    type: 'GET',
                    dataType: 'json',
                    async: false,
                    data: null,
                    success: function(data) {
                        if (data.erro) {
                            alert('CEP não localizado!');
                        } else {
                            $("#address").val(data.logradouro);
                            $("#state").val(data.uf);
                            $("#city").val(data.localidade);
                            $("#district").val(data.bairro);
                        }
                    }
                });
            }
        }
    </script>
@stop
