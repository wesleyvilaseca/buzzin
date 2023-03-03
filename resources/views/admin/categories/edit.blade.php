@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('admin.categories') }}" class="btn btn-sm btn-dark">
            <i class="fa-solid fa-chevron-left me-2"></i>
            Voltar</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('category.update', $category->id) }}" class="form" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="text-center">
                    <img src="{{ @$category->image ? Storage::url("{$category->image}") : asset('images/no-image.png') }}"
                        alt="{{ $category->name }}" style="max-width: 90px;" />
                </div>

                @include('admin.categories._partials.form', ['category' => $category])
            </form>
        </div>
    </div>
@stop
