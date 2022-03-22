@extends('admin.layout.admin')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('admin.plan') }}" class="btn btn-sm btn-dark">
            <i class="fa-solid fa-chevron-left me-2"></i>
            Voltar</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('plans.store') }}" class="form" method="POST">
                @csrf
                @include('admin.plan._partials.form')
            </form>
        </div>
    </div>
@stop
