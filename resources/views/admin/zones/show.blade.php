@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <div class="mb-2" align="right">
            <a href="{{ route('admin.zones.geolocation') }}" class="btn btn-sm btn-dark">
                <i class="fa-solid fa-chevron-left me-2"></i>
                Voltar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @include('admin.zones._partials.form', ['zone' => @$zone, 'disabled' => true])

            <form action="{{ route('zone.destroy', $zone->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="text-center mt-2">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i> DELETAR ZONA DE ENTREGA
                        {{ $zone->name }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
