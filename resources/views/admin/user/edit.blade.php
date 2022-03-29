@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <div class="mb-2" align="right">
            <a href="{{ route('admin.users') }}" class="btn btn-sm btn-dark">
                <i class="fa-solid fa-chevron-left me-2"></i>
                Voltar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('user.update', $user->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')

                @include('admin.user._partials.form', ['user' => $user])
            </form>
        </div>
    </div>
@stop
