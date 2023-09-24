<div class="card">
    <div class="card-body">
        <div class="card-title">
            Detalhes da zona e entrega
        </div>
        <hr>
        <div class="body">
            <div class="form-group mt-2">
                <label>Nome da zona de entrega:</label>
                <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Nome:"
                    value="{{ @$zone->name ?? old('name') }}" required minlength="5" {{ @$disabled ? 'disabled' : '' }}>
            </div>

            <div class="top-section mt-2">
                Tempo estimado para entrega
            </div>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mt-2">
                        <label>Tempo inicial:</label>
                        <input type="number" name="delivery_time_ini" id="delivery_time_ini"
                            class="form-control form-control-sm" placeholder="40"
                            value="{{ @$zone->delivery_time_ini ?? old('delivery_time_ini') }}" minlength="0"
                            required  {{ @$disabled ? 'disabled' : '' }} />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mt-2">
                        <label>Tempo final:</label>
                        <input type="number" name="delivery_time_end" id="delivery_time_end"
                            class="form-control form-control-sm" placeholder="60"
                            value="{{ @$zone->delivery_time_end ?? old('delivery_time_end') }}" minlength="0"
                            required  {{ @$disabled ? 'disabled' : '' }} />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mt-2">
                        <label>Unidade de medida do tempo:</label>
                        <select class="form-select form-select-sm" name="time_type" id="time_type"
                            aria-label="Default select example" {{ @$disabled ? 'disabled' : '' }}>
                            <option selected disabled>Selecione uma opção</option>
                            <option {{ @$zone->time_type == 1 ? 'selected' : '' }} value="1">Minutos
                            </option>
                            <option {{ @$zone->time_type == 2 ? 'selected' : '' }} value="2">Horas</option>
                            <option {{ @$zone->time_type == 3 ? 'selected' : '' }} value="3">Dias</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group mt-2">
                <label>Valor da entrega: <span class="badge rounded-pill bg-info text-dark"
                        onclick="return alert('caso seja grátis, deixe o campo vazio')">Grátis?</span></label>
                <input type="text" name="price" id="price" class="form-control form-control-sm"
                    onkeyup="Helper.prototype.formatCurrency(this)" value="{{ @$zone->price ?? old('price') }}"
                    required  {{ @$disabled ? 'disabled' : '' }} />
            </div>

            <div class="form-group mt-2">
                <label>Grátis a partir de: <span class="badge rounded-pill bg-info text-dark"
                        onclick="return alert('caso a entrega não seja grátis, ela passa a ser se o pedido atingir o valor informado abaixo')">?</span>
                    <small class="text-danger"> </small></label>
                <input type="text" name="free_when" id="free_when" class="form-control form-control-sm"
                    onkeyup="Helper.prototype.formatCurrency(this)" value="{{ @$zone->free_when ?? old('free_when') }}"
                    required {{ @$disabled ? 'disabled' : '' }} />
            </div>

            <div class="form-group mt-2">
                <label>Status</label>
                <select class="form-select form-select-sm" name="active" id="active"
                    aria-label="Default select example"  {{ @$disabled ? 'disabled' : '' }} >
                    <option {{ @$zone->active == 1 ? 'selected' : '' }} value="1">Ativo</option>
                    <option {{ @$zone->active == 0 ? 'selected' : '' }} value="0">Inativo</option>
                </select>
            </div>
        </div>
    </div>
</div>
