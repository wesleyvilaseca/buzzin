@csrf
<div class="form-group">
    <label>Nome:</label>
    <input type="text" name="name" placeholder="Nome" class="form-control form-control-sm"
        value="{{ $detail->name ?? old('name') }}" required>
</div>
<div class="form-group mt-2 text-center">
    <button type="submit" class="btn btn-sm btn-success">Enviar</button>
</div>
