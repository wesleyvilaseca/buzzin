<style>

</style>

<div class="form-group mt-2">
    <label>Nome:</label>
    <input type="text" name="name" class="form-control form-control-sm" placeholder="Nome:"
        value="{{ @$category->name ?? old('name') }}" required>
</div>
{{-- <div class="row">
    <div class="form-group mt-2">
        <label class="mb-2">Icone: <span id="selected_icon"></span>
        </label>
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <button type="button" class="input-group-text btn btn-sm btn-info" id="inputGroup-sizing-sm"
                    data-bs-toggle="modal" data-bs-target="#modalIcons">Selecionar</button>
            </div>
            <input type="text" name="icon" id="icon" class="form-control" aria-label="Small"
                aria-describedby="inputGroup-sizing-sm" value="{{ $category->icon ?? old('icon') }}" readonly>
        </div>
        <div class="modal fade" id="modalIcons" tabindex="-1" aria-labelledby="modalIconsLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalIconsLabel">Selecione um icone</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @foreach (fa_icons() as $key => $icon)
                                <div class="col-1 m-1" align="center" style="cursor: pointer;"
                                    onclick="selectIcon('{{ $key }}')">
                                    <div class="card-person">
                                        <i class="{{ $key }}" style="font-size: 17px"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="form-group mt-2">
    <label>* Imagem:</label>
    <input type="file" name="image" class="form-control form-control-sm" {{ @$category->image ? '' : 'required' }}/>
</div>

<div class="form-group mt-2">
    <label>Descrição:</label>
    <textarea name="description" ols="30" rows="5" class="form-control form-control-sm">{{ @$category->description ?? old('description') }}</textarea>
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

        function selectIcon(icon) {
            $("#selected_icon").html("");
            $("#selected_icon").html(`<i class="${icon}"></i>`);
            $("#icon").val(icon);

            $('#modalIcons').modal('hide');
        }
    </script>
@stop
