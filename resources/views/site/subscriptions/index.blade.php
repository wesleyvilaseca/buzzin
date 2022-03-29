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
                        <label>CEP:</label>
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
                        <input type="text" id="state" name="state" class="form-control form-control-sm" placeholder="UF:"
                            value="{{ old('state') }}" readonly required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="form-group mt-2 col-md-6">
                        <label>Endereço:</label>
                        <input type="text" id="address" name="address" class="form-control form-control-sm" placeholder="Endereço:"
                            value="{{ old('address') }}" required>
                    </div>

                    <div class="form-group mt-2 col-md-2 ">
                        <label>Numero:</label>
                        <input type="text" name="number" class="form-control form-control-sm" placeholder="Numero:"
                            value="{{ old('number') }}">
                    </div>
                </div>

                <div class="mt-5 mb-5">
                    <hr>
                </div>

                <div class="text-center mb-2">
                    <h5>Dados para acesso</h5>
                </div>
                <div class="form-group mt-2">
                    <label>Nome da empresa:</label>
                    <input type="text" name="tenant_name" class="form-control form-control-sm" placeholder="empresa:"
                        value="{{ old('empresa') }}" required>
                </div>

                <div class="form-group mt-2">
                    <label>CNPJ:</label>
                    <input type="text" id="cnpj" name="cnpj" class="form-control form-control-sm" placeholder="cnpj:"
                        value="{{ old('cnpj') }}" required>
                </div>
                <div class="form-group mt-2">
                    <label>Nome do usuário:</label>
                    <input type="text" name="name" class="form-control form-control-sm" placeholder="Nome:"
                        value="{{ old('name') }}" required>
                </div>

                <div class="form-group mt-2">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control form-control-sm" placeholder="Email:"
                        value="{{ old('email') }}" required>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script type="text/javascript">
        jQuery(function($){
          $('#zip_code').mask("00000-000");
          $('#cnpj').mask("00.000.000/0000-00");
      });
      function buscacep(cep){
          if(cep.length == 9){
              $.ajax({
              url:`https://viacep.com.br/ws/${cep}/json/`,
              type: 'GET',
              dataType: 'json',
              async: false,
              data: null,
              success: function (data) {
                  if(data.erro){
                      alert('CEP não localizado!');
                  }else {
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
