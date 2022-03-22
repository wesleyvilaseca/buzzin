<div class="form-group mt-2">
    <label>Nome:</label>
    <input type="text" name="name" class="form-control form-control-sm" placeholder="Nome:"
        value="{{ $plan->name ?? old('name') }}" required>
</div>
<div class="form-group mt-2">
    <label>Preço:</label>
    <input type="text" name="price" class="form-control form-control-sm" placeholder="Preço:"
        value="{{ $plan->price ?? old('price') }}" required>
</div>
<div class="form-group mt-2">
    <label>Descrição:</label>
    <input type="text" name="description" class="form-control form-control-sm" placeholder="Descrição:"
        value="{{ $plan->description ?? old('description') }}" required>
</div>
<div class="form-group mt-2 text-center">
    <button type="submit" class="btn btn-sm btn-success">Salvar</button>
</div>
