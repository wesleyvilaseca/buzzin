<div class="form-group mt-2">
    <label>Nome:</label>
    <input type="text" name="name" class="form-control form-control-sm" placeholder="Nome:" value="{{ @$user->name ?? old('name') }}" required minlength="5">
</div>
<div class="form-group mt-2">
    <label>E-mail:</label>
    <input type="email" name="email" class="form-control form-control-sm" placeholder="email:" value="{{ @$user->email ?? old('email') }}" required>
</div>
<div class="form-group mt-2">
    <label>Senha:</label>
    <input type="password" name="password" class="form-control form-control-sm" placeholder="Senha:" {{ !@$user ?? 'required'}} minlength="8"/>
</div>
<div class="form-group text-center mt-2">
    <button type="submit" class="btn btn-sm btn-success">Enviar</button>
</div>