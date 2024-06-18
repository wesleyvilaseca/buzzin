@extends('layouts.admin.dashboard')

@php
    $tab = @$_GET['tab'];
@endphp

@section('content')
    @if (!@isset($site))
        <form action="{{ route('admin.site.enable') }}" method="POST" class="form form-inline">
            @csrf
            <div class="text-center">
                <button type="submit" class="btn btn-sm btn-outline-success"><i class="me-2 fa-solid fa-rocket"></i> Ativar
                    website </button>
            </div>
        </form>
    @endif

    {{-- @if (@isset($site) && $site->status == \App\Models\Site::STATUS_WAITING)
        <div class="text-center alert alert-info alert-dismissible fade show" role="alert">
            <p>Seu site está em processo de implantação, por favor aguarde</p>
        </div>
    @endif --}}

    {{-- @if (@isset($site) && ($site->status == \App\Models\Site::STATUS_APROVED || $site->status ==  \App\Models\Site::STATUS_DISABLED))
        @include('admin.site._partials.navbar')

        <form action="{{ route('admin.site.maintence') }}" method="POST" class="form form-inline">
            @csrf
            <div class="form-group mt-2">
                <label>* Sub dominio:</label>
                <input type="text" class="form-control form-control-sm" value="{{ $site->subdomain }}" disabled>
            </div>
            <div class="form-group mt-2">
                <label>* Em manutenção</label>
                <select name="maintence" class="form-control form-control-sm">
                    <option value="1" {{ $site->maintence == '1' ? 'selected' : '' }}>Sim</option>
                    <option value="0" {{ $site->maintence == '0' ? 'selected' : '' }}>Não</option>
                </select>
            </div>
            <div class="text-center mt-2">
                <button type="submit" class="btn btn-sm btn-outline-success">Salvar</button>
            </div>
        </form>
    @endif --}}

    @include('admin.site._partials.navbar')

    <form action="{{ route('admin.site.maintence') }}" method="POST" class="form form-inline">
        @csrf
        <div class="form-group mt-2">
            <label>* Endereço do site:</label>
            <input type="text" class="form-control form-control-sm" value="{{ request()->getHttpHost() . '/' . $site->url }}" disabled>
        </div>
        <div class="form-group mt-2">
            <label>* Em manutenção</label>
            <select name="maintence" class="form-control form-control-sm">
                <option value="1" {{ $site->maintence == '1' ? 'selected' : '' }}>Sim</option>
                <option value="0" {{ $site->maintence == '0' ? 'selected' : '' }}>Não</option>
            </select>
        </div>
        <div class="text-center mt-2">
            <button type="submit" class="btn btn-sm btn-outline-success">Salvar</button>
        </div>
    </form>
@stop
