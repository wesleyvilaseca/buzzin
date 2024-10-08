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
    <label>* Quantidade em estoque:</label>
    <input type="text" name="quantity" class="form-control form-control-sm"
        value="{{ $product->quantity ?? old('quantity') }}">
</div>

<div class="form-group mt-2">
    <label>* Mínimo por venda:</label>
    <input type="text" name="min_for_sale" class="form-control form-control-sm"
        value="{{ $product->min_for_sale ?? old('min_for_sale') }}">
</div>

<div class="form-group mt-2">
    <label>* Produto ativo?</label>
    <select name="status" class="form-control form-control-sm">
        <option value="1" {{ @$product->status == '1' ? 'selected' : '' }}>Sim</option>
        <option value="0" {{ @$product->status == '0' ? 'selected' : '' }}>Não</option>
    </select>
</div>

<div class="form-group mt-2">
    <label>* Reduzir estoque?</label>
    <select name="stock_controll" class="form-control form-control-sm">
        <option value="0" {{ @$product->stock_controll == '0' ? 'selected' : '' }}>Não</option>
        <option value="1" {{ @$product->stock_controll == '1' ? 'selected' : '' }}>Sim</option>
    </select>
</div>

<div class="form-group mt-2">
    <label>Se esgotado?</label>
    <select name="status_product_no_stock_id" class="form-control form-control-sm">
        @foreach ($statusStoque as $status)
            <option value="{{ $status->id }}"
                {{ @$product->status_product_no_stock_id == $status->id ? 'selected' : '' }}>{{ $status->description }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group mt-2">
    <label>* Descrição:</label>
    <textarea name="description" ols="30" rows="5" class="form-control form-control-sm">{{ @$product->description ?? old('description') }}</textarea>
</div>
<div class="form-group mt-2 text-center">
    <button type="submit" class="btn btn-sm btn-success">Enviar</button>
</div>
