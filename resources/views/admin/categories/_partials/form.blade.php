<div class="form-group mt-2">
    <label>Nome:</label>
    <input type="text" name="name" class="form-control form-control-sm" placeholder="Nome:"
        value="{{ $category->name ?? old('name') }}" required>
</div>
<div class="row">
    <div class="form-group mt-2">
        <label class="mb-2">Icone: <span id="selected_icon"></span>
        </label>
        {{-- <input type="text" name="icon" class="form-control form-control-sm" placeholder="fa-solid fa-pizza"
            value="{{ $category->icon ?? old('icon') }}" required> --}}
        <select class="form-select" id="icon" name="icon" id="select-field" aria-label="Default select example"
            onchange="selectIcon()">
            @foreach (fa_icons() as $key => $icon)
                <option value="{{ $key }}" {{ @$category->icon == $key ? 'selected' : '' }}>
                    {{ $icon }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group mt-2">
    <label>Descrição:</label>
    <textarea name="description" ols="30" rows="5" class="form-control form-control-sm">{{ $category->description ?? old('description') }}</textarea>
</div>
<div class="form-group mt-2 text-center">
    <button type="submit" class="btn btn-sm btn-success">Enviar</button>
</div>

@section('js')
    <script>
        var icon = "{{ @$category->icon }}";
        if (icon) {
            $("#selected_icon").html(`<i class="${icon}"></i>`);
        }

        function selectIcon() {
            $("#selected_icon").html("");
            $("#selected_icon").html(`<i class="${$("#icon").val()}"></i>`);
        }
    </script>
@stop
