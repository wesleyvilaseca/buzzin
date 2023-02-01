@extends('layouts.admin.dashboard')

@section('content')
    <div class="top">
        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#saida">
            Lançar Saida
        </button>
    </div>

    <div class="row mt-2">
        <div class="col-sm-12">
            <div class="card w-100">
                <div class="card-body">
                    <div class="card-title text-center">Saída de produtos</div>
                    <hr>
                    <table class="table data-table">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Qtd</th>
                                <th scope="col">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stockOut as $stock)
                                <tr>
                                    <td>{{ $stock->product->title }}</td>
                                    <td>{{ $stock->quantity }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-danger"
                                            onclick="return confimDelete('{{ route('client.stockout.destroy', $stock->id) }}')"
                                            href="#">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <div class="alert alert-warning text-center mb-3 "> Você não tem registros de saída para
                                    listar</div>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
                            <input type="text" class="form-control form-control-sm" id="quantity_in_stock" value=""
                                disabled>
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
        $('.productStokOut').select2({
            theme: 'bootstrap-5',
            dropdownParent: "#saida"
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
