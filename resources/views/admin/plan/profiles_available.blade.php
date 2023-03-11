@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">

        <a href="{{ route('plans.profiles', $plan->id) }}" class="btn btn-sm btn-dark">
            <i class="fa-solid fa-chevron-left me-2"></i>
            Voltar</a>
    </div>
    <div class="card">
        <div class="card-header">
            <form action="{{ route('plans.profiles.available', $plan->id) }}" method="POST" class="form form-inline">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="filter" placeholder="Perfil" class="form-control form-control-sm"
                            value="{{ $filters['filter'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-sm btn-dark">Pesquisar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <form action="{{ route('plans.profiles.attach', $plan->id) }}" method="POST">

                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th width="50px">#</th>
                            <th>Nome</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$profiles->isEmpty())
                            @csrf
                            <tr>
                                <td colspan="500">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-sm btn-success">Vincular</button>
                                    </div>
                                </td>
                            </tr>
                        @endif

                        @foreach ($profiles as $profile)
                            <tr>
                                <td>
                                    <input type="checkbox" name="profiles[]" value="{{ $profile->id }}">
                                </td>
                                <td>
                                    {{ $profile->name }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@stop
