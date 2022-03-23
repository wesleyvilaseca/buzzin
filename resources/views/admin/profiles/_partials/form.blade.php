@csrf

<div class="form-group mt-2">
    <label>* Nome:</label>
    <input type="text" name="name" class="form-control form-control-sm" placeholder="Nome:" value="{{ $profile->name ?? old('name') }}" required>
</div>
<div class="form-group mt-2">
    <label>Descrição:</label>
<input type="text" name="description" class="form-control form-control-sm" placeholder="Descrição:" value="{{ $profile->description ?? old('description') }}" required>
</div>
<div class="form-group text-center mt-2">
    <button type="submit" class="btn btn-sm btn-success">Enviar</button>
</div>