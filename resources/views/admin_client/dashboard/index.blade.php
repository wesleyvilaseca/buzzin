@extends('layouts.admin.dashboard')

@section('content')
    <div class="top">
        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#entrada">
            Lançar entrada
        </button>

        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#saida">
            Lançar Saida
        </button>
    </div>


    <div class="row mt-2">

        @if (@$movimentacoes)
            <div class="col-md-4">
                <div class="card w-100">
                    <div class="card-body" style="max-height: 480px; overflow-y: auto">
                        <div class="card-title text-center">Movimentações</div>
                        <hr>
                        @component('components.widget.timeline-list', ['movimentacoes' => $movimentacoes])
                        @endcomponent
                    </div>
                </div>
            </div>
        @endif

        @if (@$graficoStockGroupByCategory)
            <div class="col-md-4 mb-4">
                <div class="card bg-light w-100">
                    <div class="card-body" style="max-height: 480px;">
                        @component('components.widget.commonchart', [
                            'grafobj' => $graficoStockGroupByCategory,
                            'name' => 'produtos-em-estoque-por-categoria',
                            'title' => 'Gráfico de produtos em estoque por categoria',
                            'subtitle' => 'Considerando a quantidade de produtos total por categoria',
                            'grafType' => 'pie',
                            'displayLegend' => true,
                            'positionLegend' => 'left',
                        ])
                        @endcomponent
                    </div>
                </div>
            </div>
        @endif


        @if (@$graficoStockInPriceGroupByCategory)
            <div class="col-md-4 mb-3">
                <div class="card bg-light w-100">
                    <div class="card-body">
                        @component('components.widget.commonchart', [
                            'grafobj' => $graficoStockInPriceGroupByCategory,
                            'name' => 'entrada-de-produtos-por-categoria-nos-ultimos-30-dias-preco',
                            'title' => 'Gráfico entrada de produtos nos ultimos 30',
                            'subtitle' => 'Considerando o valor total por categoria',
                            'grafType' => 'bar',
                            'displayLegend' => false,
                            'positionLegend' => 'bottom',
                        ])
                        @endcomponent
                    </div>
                </div>
            </div>
        @endif

        @if (@$graficoStockInGroupByCategory)
            <div class="col-md-4 mb-3">
                <div class="card bg-light w-100">
                    <div class="card-body">
                        @component('components.widget.commonchart', [
                            'grafobj' => $graficoStockInGroupByCategory,
                            'name' => 'entrada-de-produtos-por-categoria-nos-ultimos-30-dias',
                            'title' => 'Gráfico entrada de produtos nos ultimos 30 dias por categoria',
                            'subtitle' => 'Considerando a quantidade de produtos total por categoria',
                            'grafType' => 'pie',
                            'displayLegend' => true,
                            'positionLegend' => 'left',
                        ])
                        @endcomponent
                    </div>
                </div>
            </div>
        @endif


        @if (@$graficoStockOutGroupByCategory)
            <div class="col-md-4 mb-3">
                <div class="card bg-light w-100">
                    <div class="card-body">
                        @component('components.widget.commonchart', [
                            'grafobj' => $graficoStockOutGroupByCategory,
                            'name' => 'saida-de-produtos-por-categoria-nos-ultimos-30-dias',
                            'title' => 'Gráfico saída de produtos nos ultimos 30 dias por categoria',
                            'subtitle' => 'Considerando a quantidade de produtos total por categoria',
                            'grafType' => 'pie',
                            'displayLegend' => true,
                            'positionLegend' => 'left',
                        ])
                        @endcomponent
                    </div>
                </div>
            </div>
        @endif


        <div class="col-md-6 col-lg-4 col-sm-12">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-title text-center">Meu estoque</div>
                    <hr>
                    <table class="table data-table">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Qtd</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clientProducts as $product)
                                <tr>
                                    <td>{{ $product->product->title }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>

                                        @if ($product->quantity > 0 && $product->quantity < 3)
                                            <span class="badge bg-warning text-dark">Estoque baixo</span>
                                        @endif

                                        @if ($product->quantity > 0 && $product->quantity >= 3)
                                            <span class="badge bg-success">Em estoque</span>
                                        @endif

                                        @if ($product->quantity <= 0)
                                            <span class="badge bg-danger">Sem estoque</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <div class="alert alert-warning text-center mb-3 "> Você não tem registros de produtos em
                                    estoque para listar</div>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="entrada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content   ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Entrada de produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="clearForm('stockIn')"></button>
                </div>
                <form id="stockIn" action="{{ route('client.stockin') }}" method="POST">

                    <div class="modal-body">
                        @csrf
                        {{-- <div class="form-group mt-2">
                            <label>Número da nota/recibo (opcional)</label>
                            <input type="text" name="nota" class="form-control form-control-sm" placeholder="00010"
                                value="">
                        </div> --}}

                        <label for="produto_market_id" class="form-label">Selecione o produto</label>
                        <select class="form-select product" name="product_market_id" data-placeholder="Selecione um produto"
                            required>
                            <option></option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"> {{ $product->title }}</option>
                            @endforeach
                        </select>
                        <div class="form-group mt-2">
                            <label>Quantidade</label>
                            <input type="text" name="quantity" class="form-control form-control-sm" placeholder="10"
                                value="" required>
                        </div>

                        <div class="form-group mt-2">
                            <label>Valor da unidade</label>
                            <input type="text" name="price" class="form-control form-control-sm currency"
                                placeholder="5.50" value="" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Anotação</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" id="anotation" name="anotation"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"
                            onclick="clearForm('stockIn')">Cancelar</button>
                        <button type="submit" class="btn btn-sm btn-success">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="saida" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content   ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="clearForm('stockOut')"></button>
                </div>
                <form id="stockOut" action="{{ route('client.stockout') }}" method="POST">

                    <div class="modal-body">
                        @csrf
                        <label for="produto_market_id" class="form-label">Selecione o produto</label>
                        <select class="form-select productStokOut" id="product_market_id"
                            data-placeholder="Selecione um produto" onchange="seletecProductStockOut()" required>
                            <option></option>
                            @foreach ($clientProducts as $product)
                                <option value="{{ $product->product_market_id }}|{{ $product->quantity }}">
                                    {{ $product->product->title }}
                                </option>
                            @endforeach
                        </select>

                        <div class="form-group mt-2">
                            <label>Quantidade em estoque</label>
                            <input type="text" class="form-control form-control-sm" id="quantity_in_stock"
                                value="" disabled>
                        </div>

                        <div class="form-group mt-2">
                            <label>Quantidade</label>
                            <input type="text" name="quantity" class="form-control form-control-sm" placeholder="10"
                                value="" required>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Anotação</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" id="anotation" name="anotation"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"
                            onclick="clearForm('stockOut')">Cancelar</button>
                        <button type="submit" class="btn btn-sm btn-success">Enviar</button>
                    </div>
                    <input type="hidden" name="product_market_id" id="product_market_id_out" value="">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.product').select2({
            theme: 'bootstrap-5',
            dropdownParent: "#entrada"
        });

        $('.productStokOut').select2({
            theme: 'bootstrap-5',
            dropdownParent: "#saida"
        });

        $('.currency').maskMoney({
            symbol: 'R$', // Simbolo
            decimal: '.', // Separador do decimal
            precision: 2, // Precisão
            thousands: ',', // Separador para os milhares
            allowZero: false, // Permite que o digito 0 seja o primeiro caractere
            showSymbol: false // Exibe/Oculta o símbolo
        });

        $(document).ready(function() {
            $('.data-table').DataTable();
        });

        function confimDelete(route) {
            Swal.fire({
                title: 'Você tem certeza?',
                text: "A exclusão deste registro pode afetar o seu controle de estoque",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, quero deletar!',
                cancelButtonText: 'Não, cancelar exclusão!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = route;
                }
            })
        }

        function seletecProductStockOut() {
            var product_selected = $("#product_market_id").val();
            var product_market_id;
            var product_quantity;

            product_selected = product_selected.split("|");

            product_market_id = product_selected[0];
            product_quantity = product_selected[1];
            $("#product_market_id_out").val(product_market_id);
            $("#quantity_in_stock").val(product_quantity);
        }

        function clearForm(id) {
            document.getElementById(id).reset();
        }
    </script>
@endsection
