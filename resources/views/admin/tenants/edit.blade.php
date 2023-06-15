@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('admin.tenants') }}" class="btn btn-sm btn-dark">
            <i class="fa-solid fa-chevron-left me-2"></i>
            Voltar</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('tenant.update', $tenant->id) }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="text-center">
                    <img src="{{ @$tenant->logo ? getImage($tenant->logo) : asset('images/no-image.png') }}" alt="{{ $tenant->name }}" style="max-width: 90px;" />
                </div>

                @include('admin.tenants._partials.form', ['tenant' => $tenant])
            </form>
        </div>
    </div>
@stop
