@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('admin.products.market') }}" class="btn btn-sm btn-dark">
            <i class="fa-solid fa-chevron-left me-2"></i>
            Voltar</a>
    </div>

    <div class="card">
        <div class="card-body">
            <ul>
                <div class="text-center">
                    <img src="{{ $product->image ? Storage::url("$product->image") : asset('images/no-image.png') }}" alt="{{ $product->title }}" style="max-width: 90px;">
                </div>
                <li>
                    <strong>Título: </strong> {{ $product->title }}
                </li>
                <li>
                    <strong>Flag: </strong> {{ $product->flag }}
                </li>
                <li>
                    <strong>Descrição: </strong> {{ $product->description }}
                </li>
            </ul>


            <form action="{{ route('market.product.destroy', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="text-center">
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> DELETAR O PRODUTO {{ $product->title }}</button>
                </div>
            </form>
        </div>
    </div>
@stop
