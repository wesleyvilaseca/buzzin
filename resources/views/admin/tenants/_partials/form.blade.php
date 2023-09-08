<div class="form-group mt-2">
    <label>* Nome do estabelecimento:</label>
    <input type="text" name="tenant_name" class="form-control form-control-sm" placeholder="Nome:"
        value="{{ $tenant->tenant_name ?? old('tenant_name') }}">
</div>

<div class="form-group mt-2">
    <label>Logo:</label>
    <input type="file" name="logo" class="form-control form-control-sm">
</div>

<div class="form-group mt-2">
    <label>* Nome do administrador:</label>
    <input type="text" name="name" class="form-control form-control-sm" placeholder="Nome:"
        value="{{ $tenant->name ?? old('name') }}">
</div>

<div class="form-group mt-2">
    <label>* E-mail do administrador:</label>
    <input type="email" name="email" class="form-control form-control-sm" placeholder="E-mail:"
        value="{{ $tenant->email ?? old('email') }}">
</div>

<div class="form-group mt-2">
    <label>* Senha:</label>
    <input type="password" name="password" class="form-control form-control-sm">
</div>

<div class="form-group mt-2">
    <label>Tipo da empresa:</label>
    <select name="type" id="type" class="form-control form-control-sm" required>
        <option value="J" {{ @$tenant->type == 'J' ? 'selected' : '' }}>Pessoa jurídica
        </option>
        <option value="F" {{ @$tenant->type == 'F' ? 'selected' : '' }}>Pessoa física
        </option>
    </select>
</div>

<div class="form-group mt-2">
    <label id="label-type">* CNPJ:</label>
    <input type="text" name="cnpj" id="cnpj" class="form-control form-control-sm"
        placeholder="00.000.000/0000-00" value="{{ $tenant->cnpj ?? old('cnpj') }}">
</div>

<div class="form-group mt-2">
    <label>* Ativo?</label>
    <select name="active" class="form-control form-control-sm">
        <option value="Y" @if (isset($tenant) && $tenant->active == 'Y') selected @endif>SIM</option>
        <option value="N" @if (isset($tenant) && $tenant->active == 'N') selected @endif>Não</option>
    </select>
</div>

<div class="form-group mt-2">
    <label>* Plano</label>
    <select name="plan_id" class="form-control form-control-sm">
        @foreach ($plans as $plan)
            <option value="{{ $plan->id }}" @if (isset($tenant) && $tenant->plan_id == $plan->id) selected @endif>{{ $plan->name }}
            </option>
        @endforeach
    </select>
</div>
<hr>
<div class="row">
    <div class="text-center mb-2">
        <h5>Endereço</h5>
    </div>
    <div class="form-group mt-2 col-md-3">
        <label>CEP: </label>
        <input type="text" id="zip_code" name="zip_code" class="form-control form-control-sm" placeholder="CEP:"
            onblur="buscacep(value)" value="{{ @$tenant->zip_code ?? old('zip_code') }}" required>
    </div>

    <div class="form-group mt-2 col-md-3">
        <label>Bairro:</label>
        <input type="text" id="district" name="district" class="form-control form-control-sm" placeholder="Bairro:"
            value="{{ @$tenant->district ?? old('district') }}" readonly required>
    </div>

    <div class="form-group mt-2 col-md-3">
        <label>Cidade:</label>
        <input type="text" id="city" name="city" class="form-control form-control-sm" placeholder="Cidade:"
            value="{{ @$tenant->city ?? old('city') }}" readonly required>
    </div>

    <div class="form-group mt-2 col-md-3">
        <label>UF:</label>
        <input type="text" id="state" name="state" class="form-control form-control-sm" placeholder="UF:"
            value="{{ @$tenant->state ?? old('state') }}" readonly required>
    </div>
</div>

<div class="row mb-3">
    <div class="form-group mt-2 col-md-6">
        <label>Endereço:</label>
        <input type="text" id="address" name="address" class="form-control form-control-sm" placeholder="Endereço:"
            value="{{ @$tenant->address ?? old('address') }}" required>
    </div>

    <div class="form-group mt-2 col-md-2 ">
        <label>Numero:</label>
        <input type="text" name="number" id="number" class="form-control form-control-sm" placeholder="Numero:"
            value="{{ @$tenant->number ?? old('number') }}">
    </div>
</div>

<div class="mt-5 mb-5">
    <hr>
</div>

<hr>
<h3>Assinatura</h3>
<div class="form-group mt-2">
    <label>Data Assinatura (início):</label>
    <input type="date" name="subscription" class="form-control form-control-sm"
        placeholder="Data Assinatura (início):" value="{{ $tenant->subscription ?? old('subscription') }}">
</div>
<div class="form-group mt-2">
    <label>Expira (final):</label>
    <input type="date" name="expires_at" class="form-control form-control-sm" placeholder="Expira:"
        value="{{ $tenant->expires_at ?? old('expires_at') }}">
</div>
<div class="form-group mt-2">
    <label>Identificador:</label>
    <input type="text" name="subscription_id" class="form-control form-control-sm" placeholder="Identificador:"
        value="{{ $tenant->subscription_id ?? old('subscription_id') }}">
</div>
<div class="form-group mt-2">
    <label>* Assinatura Ativa?</label>
    <select name="subscription_active" class="form-control form-control-sm">
        <option value="1" @if (isset($tenant) && $tenant->subscription_active) selected @endif>SIM</option>
        <option value="0" @if (isset($tenant) && !$tenant->subscription_active) selected @endif>Não</option>
    </select>
</div>
{{-- <div class="form-group mt-2">
    <label>* Assinatura Cancelada?</label>
    <select name="subscription_suspended" class="form-control form-control-sm">
        <option value="1" @if (isset($tenant) && $tenant->subscription_suspended) selected @endif>SIM</option>
        <option value="0" @if (isset($tenant) && !$tenant->subscription_suspended) selected @endif>Não</option>
    </select>
</div> --}}
<div class="form-group mt-2 text-center">
    <button type="submit" class="btn btn-sm btn-success">Enviar</button>
</div>

@section('js')
    <script type="text/javascript">
        var zip_code = "";
        var tenant_type = '{{ @$tenant->type }}';



        jQuery(function($) {
            $('#zip_code').mask("00000-000");
            
            if (tenant_type) {
                setType(tenant_type);
            } else {
                $('#cnpj').mask("00.000.000/0000-00");
            }

            $("#type").on("change", function() {
                const TYPE = $(this).val();
                setType(TYPE);
            });
        });

        function setType(TYPE) {
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
        }

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
