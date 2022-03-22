@extends('admin.layout.admin')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('admin.plan') }}" class="btn btn-sm btn-dark">
            <i class="fa-solid fa-chevron-left me-2"></i>
            Voltar</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('plans.update', $plano->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')

                @include('admin.plan._partials.form', ['plan' => $plano])
            </form>
        </div>
    </div>
@stop
