@extends('layouts.admin.dashboard')

@section('content')
    @include('admin.configuration._partials.navbar')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('operation.update', [$tenantOperation->id]) }}" method="POST" class="form form-inline">
                @csrf
                @method('PUT')

                <div class="form-group mt-2">
                    <label>* Informe detalhes:
                        <small style="cursor: pointer" onclick="return alert('Ex: 8:00 as 12:00 - 13:00 as 18:00')">
                            <span class="badge rounded-pill bg-primary"><i class="fa-solid fa-info"></i></span>
                        </small>
                    </label>
                    <textarea name="description" ols="30" rows="5" class="form-control form-control-sm">{{ @$data?->detailOperation }}</textarea>
                </div>
            </form>
        </div>
    </div>
@stop
