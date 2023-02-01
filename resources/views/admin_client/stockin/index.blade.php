@extends('layouts.admin.dashboard')

@section('content')
    <div class="top">
        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#entrada">
            Lançar entrada
        </button>
    </div>

    <div class="row mt-2">
        <div class="col-sm-12">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-title text-center">Entrada de produtos</div>
                    <div class="text-center"> Valor total: R$
                        <span class="text-success">
                            <strong>{{ numberFormat($totalPrice) }}</strong>
                        </span>
                    </div>

                    <hr>
                    <table class="table data-table">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Categoria(s)</th>
                                <th scope="col">Qtd</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Total</th>
                                <th scope="col">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stockIn as $stock)
                                <tr>
                                    <td>{{ $stock->product->title }}</td>
                                    <td>
                                        @foreach ($stock->product->categories as $category)
                                            {{ $category->name }} <br>
                                        @endforeach
                                    </td>
                                    <td>{{ $stock->quantity }}</td>
                                    <td>R$ {{ numberFormat($stock->price) }}</td>
                                    <td>R$ {{ numberFormat($stock->quantity * $stock->price) }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-danger"
                                            onclick="return confimDelete('{{ route('client.stockin.destroy', $stock->id) }}')"
                                            href="#">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <div class="alert alert-warning text-center mb-3 "> Você não tem registros de entrada para
                                    listar</div>
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
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
@endsection

@section('js')
    <script>
        $('.product').select2({
            theme: 'bootstrap-5',
            dropdownParent: "#entrada"
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

        function clearForm(id) {
            document.getElementById(id).reset();
        }
    </script>
@endsection
