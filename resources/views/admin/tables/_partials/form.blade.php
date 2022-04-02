
<div class="form-group mt-2">
    <label>Identificador da Mesa:</label>
    <input type="text" name="identify" class="form-control form-control-sm" placeholder="Identificador da Mesa:" value="{{ $table->identify ?? old('identify') }}">
</div>
<div class="form-group mt-2">
    <label>Descrição:</label>
    <textarea name="description" ols="30" rows="5" class="form-control form-control-sm">{{ $table->description ?? old('description') }}</textarea>
</div>
<div class="form-group mt-2 text-center">
    <button type="submit" class="btn btn-sm btn-success">Enviar</button>
</div>