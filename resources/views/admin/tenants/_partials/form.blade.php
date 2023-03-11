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
    <label>* CNPJ:</label>
    <input type="text" name="cnpj" class="form-control form-control-sm" placeholder="CNPJ:"
        value="{{ $tenant->cnpj ?? old('cnpj') }}">
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
<h3>Assinatura</h3>
<div class="form-group mt-2">
    <label>Data Assinatura (início):</label>
    <input type="date" name="subscription" class="form-control form-control-sm" placeholder="Data Assinatura (início):"
        value="{{ $tenant->subscription ?? old('subscription') }}">
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
<div class="form-group mt-2">
    <label>* Assinatura Cancelada?</label>
    <select name="subscription_suspended" class="form-control form-control-sm">
        <option value="1" @if (isset($tenant) && $tenant->subscription_suspended) selected @endif>SIM</option>
        <option value="0" @if (isset($tenant) && !$tenant->subscription_suspended) selected @endif>Não</option>
    </select>
</div>
<div class="form-group mt-2 text-center">
    <button type="submit" class="btn btn-sm btn-success">Enviar</button>
</div>
