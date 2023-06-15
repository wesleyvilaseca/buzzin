@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('admin.products') }}" class="btn btn-sm btn-dark">
            <i class="fa-solid fa-chevron-left me-2"></i>
            Voltar</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('product.update', $product->id) }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="text-center">
                    <img src="{{ getImage($product->image) }}" alt="{{ $product->title }}" style="max-width: 90px;" />
                </div>

                @include('admin.products._partials.form', ['product' => $product])
            </form>
        </div>
    </div>
@stop
