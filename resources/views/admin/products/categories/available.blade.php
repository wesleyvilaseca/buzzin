@extends('layouts.admin.dashboard')

@section('content')
    <a href="{{ route('product.categories', $product->id) }}" class="btn btn-sm btn-dark mb-2">
        <i class="fa-solid fa-chevron-left me-2"></i>
        Voltar
    </a>

    <div class="card">
        <div class="card-header">
            <form action="{{ route('products.categories.available', $product->id) }}" method="POST"
                class="form form-inline">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="filter" placeholder="Categoria" class="form-control form-control-sm"
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
                        <th width="50px">#</th>
                        <th>Nome</th>
                    </tr>
                </thead>
                <tbody>
                    <form action="{{ route('products.categories.attach', $product->id) }}" method="POST">
                        @if (!$categories->isEmpty())
                            @csrf
                            <tr>
                                <td colspan="500">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-sm btn-success">Vincular</button>
                                    </div>
                                </td>
                            </tr>
                        @endif

                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                                </td>
                                <td>
                                    {{ $category->name }}
                                </td>
                            </tr>
                        @endforeach
                    </form>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if (isset($filters))
                {!! $categories->appends($filters)->links() !!}
            @else
                {!! $categories->links() !!}
            @endif
        </div>
    </div>
@stop
