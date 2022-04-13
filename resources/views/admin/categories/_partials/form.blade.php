<div class="form-group mt-2">
    <label>Nome:</label>
    <input type="text" name="name" class="form-control form-control-sm" placeholder="Nome:" value="{{ $category->name ?? old('name') }}" required>
</div>
<div class="form-group mt-2">
    <label>Descrição:</label>
    <textarea name="description" ols="30" rows="5" class="form-control form-control-sm">{{ $category->description ?? old('description') }}</textarea>
</div>
<div class="form-group mt-2 text-center">
    <button type="submit" class="btn btn-sm btn-success">Enviar</button>
</div>