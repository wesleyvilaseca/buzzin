@extends('layouts.site.site')

@section('content')

    <section id="detail-plan">

    </section>

    <section class="bg-white pt-2 pb-2">
        <div class=" container">
            <form action="{{ route('subscription.register', $plan->url) }}" method="post">
                @csrf
                <div class="row">
                    <div class="text-center mb-2">
                        <h5>Endereço</h5>
                    </div>
                    <div class="form-group mt-2 col-md-3">
                        <label>CEP: </label>
                        <input type="text" id="zip_code" name="zip_code" class="form-control form-control-sm"
                            placeholder="CEP:" onblur="buscacep(value)" value="{{ old('zip_code') }}" required>
                    </div>

                    <div class="form-group mt-2 col-md-3">
                        <label>Bairro:</label>
                        <input type="text" id="district" name="district" class="form-control form-control-sm"
                            placeholder="Bairro:" value="{{ old('district') }}" readonly required>
                    </div>

                    <div class="form-group mt-2 col-md-3">
                        <label>Cidade:</label>
                        <input type="text" id="city" name="city" class="form-control form-control-sm"
                            placeholder="Cidade:" value="{{ old('city') }}" readonly required>
                    </div>

                    <div class="form-group mt-2 col-md-3">
                        <label>UF:</label>
                        <input type="text" id="state" name="state" class="form-control form-control-sm"
                            placeholder="UF:" value="{{ old('state') }}" readonly required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="form-group mt-2 col-md-6">
                        <label>Endereço:</label>
                        <input type="text" id="address" name="address" class="form-control form-control-sm"
                            placeholder="Endereço:" value="{{ old('address') }}" required>
                    </div>

                    <div class="form-group mt-2 col-md-2 ">
                        <label>Numero:</label>
                        <input type="text" name="number" id="number" class="form-control form-control-sm"
                            placeholder="Numero:" value="{{ old('number') }}">
                    </div>
                </div>

                <div class="mt-5 mb-5">
                    <hr>
                </div>

                <div class="text-center mb-2">
                    <h5>Dados empresa</h5>
                </div>
                <div class="form-group mt-2">
                    <label>Nome da empresa:</label>
                    <input type="text" id="tenant_name" name="tenant_name" class="form-control form-control-sm"
                        placeholder="empresa:" value="{{ old('tenant_name') }}" required>
                </div>

                <div class="form-group mt-2">
                    <label>Tipo da empresa:</label>
                    <select name="type" id="type" class="form-control form-control-sm" required>
                        <option value="J" {{ old('type') == 'J' ? 'selected' : '' }} required>Pessoa jurídica
                        </option>
                        <option value="F" {{ old('type') == 'F' ? 'selected' : '' }} required>Pessoa física
                        </option>
                    </select>
                </div>

                <div class="form-group mt-2">
                    <label id="label-type">CNPJ:</label>
                    <input type="text" id="cnpj" name="cnpj" class="form-control form-control-sm"
                        placeholder="00.000.000/0000-00" value="{{ old('cnpj') }}" required>
                </div>
                <div class="form-group mt-2">
                    <label>Nome do usuário:</label>
                    <input type="text" id="name" name="name" class="form-control form-control-sm"
                        placeholder="João da Silva" value="{{ old('name') }}" required>
                </div>

                <div class="form-group mt-2">
                    <label>Email:</label>
                    <input type="email" id="email" name="email" class="form-control form-control-sm"
                        placeholder="meuemail@mail.com" value="{{ old('email') }}" required>
                </div>

                <div class="form-group mt-2">
                    <label>Senha:</label>
                    <input type="password" name="password" class="form-control form-control-sm" placeholder="senha:"
                        value="{{ old('password') }}" required>
                </div>

                <div class="form-group mt-2 text-center">
                    <button type="submit" class="btn btn-sm btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </section>
@stop

@section('js')
    <script type="text/javascript">
        var zip_code = "";

        jQuery(function($) {
            $('#zip_code').mask("00000-000");
            $('#cnpj').mask("00.000.000/0000-00");

            $("#zip_code").val('{{ old('zip_code') }}')
            $("#district").val('{{ old('district') }}')
            $("#city").val('{{ old('city') }}')
            $("#state").val('{{ old('state') }}')
            $("#address").val('{{ old('address') }}')
            $("#number").val('{{ old('number') }}')
            $("#tenant_name").val('{{ old('tenant_name') }}')
            $("#type").val('{{ old('type') }}')
            $("#cnpj").val('{{ old('cnpj') }}')
            $("#name").val('{{ old('name') }}')
            $("#email").val('{{ old('email') }}');

            $("#type").on("change", function() {
                const TYPE = $(this).val();

                if (TYPE == 'J') {
                    $('#label-type').text('CNPJ:')
                    $('#cnpj').attr("placeholder", "00.000.000/0000-00");
                    return $('#cnpj').mask("00.000.000/0000-00");
                }

                if (TYPE == 'F') {
                    $('#label-type').text('CPF:')
                    $('#cnpj').attr("placeholder", "000.000.000-00");
                    return $('#cnpj').mask("000.000.000-00");
                }
            });
        });

        function buscacep(cep) {
            if (cep.length == 9) {
                if (cep == zip_code) {
                    return;
                }

                $.ajax({
                    url: `/api/v1/getcep/${cep}`,
                    type: 'GET',
                    dataType: 'json',
                    async: false,
                    data: null,
                    success: function(data) {
                        if (data.erro) {
                            zip_code = "";
                            alert('CEP não localizado!');
                        } else {
                            zip_code = cep;
                            $("#address").val(data?.logradouro);
                            $("#state").val(data?.estado?.sigla);
                            $("#city").val(data?.cidade?.nome);
                            $("#district").val(data?.bairro);
                        }
                    }
                });
            }
        }
    </script>
@stop
