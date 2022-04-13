<div class="form-group mt-2">
    <label>* Título:</label>
    <input type="text" name="title" class="form-control form-control-sm" placeholder="Título:"
        value="{{ $product->title ?? old('title') }}" required>
</div>
<div class="form-group mt-2">
    <label>* Preço:</label>
    <input type="text" name="price" class="form-control form-control-sm" placeholder="Preço:"
        value="{{ $product->price ?? old('price') }}" required>
</div>
<div class="form-group mt-2">
    <label>* Imagem:</label>
    <input type="file" name="image" class="form-control form-control-sm" {{ @$product ? '' : 'required' }}>
</div>
<div class="form-group mt-2">
    <label>* Descrição:</label>
    <textarea name="description" ols="30" rows="5"
        class="form-control form-control-sm">{{ $product->description ?? old('description') }}</textarea>
</div>
<div class="form-group mt-2 text-center">
    <button type="submit" class="btn btn-sm btn-success">Enviar</button>
</div>
