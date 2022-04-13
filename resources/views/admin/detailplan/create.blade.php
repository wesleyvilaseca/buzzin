@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <div class="mb-2" align="right">
            <a href="{{ route('details.plan.index', $plano->id) }}" class="btn btn-sm btn-dark">
                <i class="fa-solid fa-chevron-left me-2"></i>
                Voltar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('details.plan.store', $plano->id) }}" method="post">
                @include('admin.detailplan._partials.form')
            </form>
        </div>
    </div>
@stop
