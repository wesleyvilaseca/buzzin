@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('product.create') }}" class="btn btn-sm btn-primary">Novo</a>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="{{ route('product.search') }}" method="POST" class="form form-inline">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="filter" placeholder="Produto" class="form-control form-control-sm"
                            value="{{ $filters['filter'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-sm btn-dark">Pesquisar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th width="100">Imagem</th>
                        <th>Título</th>
                        <th width="190">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <img src="{{ getImage($product->image) }}" alt="{{ $product->title }}"
                                    style="max-width: 90px;">
                            </td>
                            <td>{{ $product->title }}</td>
                            <td style="width=10px;">
                                <a href="{{ route('product.categories', $product->id) }}" class="btn btn-sm btn-warning me-1"
                                    title="Categorias"><i class="fas fa-layer-group"></i></a>
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-info me-1">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if (isset($filters))
                {!! $products->appends($filters)->links() !!}
            @else
                {!! $products->links() !!}
            @endif
        </div>
    </div>
@stop
