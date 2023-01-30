@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('admin.products.market') }}" class="btn btn-sm btn-dark">
            <i class="fa-solid fa-chevron-left me-2"></i>
            Voltar</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('market.product.update', $product->id) }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="text-center">
                    <img src="{{ $product->image ? Storage::url("{$product->image}") : asset('images/no-image.png') }}" alt="{{ $product->title }}" style="max-width: 90px;" />
                </div>

                @include('admin.products_market._partials.form', ['product' => $product])
            </form>
        </div>
    </div>
@stop
