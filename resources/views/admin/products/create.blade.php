@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('admin.products') }}" class="btn btn-sm btn-dark">
            <i class="fa-solid fa-chevron-left me-2"></i>
            Voltar</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('product.store') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf

                @include('admin.products._partials.form')
            </form>
        </div>
    </div>
@stop
