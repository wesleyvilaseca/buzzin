@extends('layouts.admin.dashboard')

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

    @if (@isset($site) && $site->status == 0)
        <div class="text-center alert alert-info alert-dismissible fade show" role="alert">
            <p>Seu site está em processo de implantação, por favor aguarde</p>
        </div>
    @endif

    @if (@isset($site) && ($site->status == 1 || $site->status == 2))
        <div class="text-center">
            <a href="http://{{ $linkWebSite }}" target="_blank" class="btn btn-sm btn-info text-white"><i
                    class="fa-solid fa-eye"></i>
                WebSite</a>
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">Geral</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Layout</button>
                {{-- <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button> --}}
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <form action="#" method="PUT" class="form form-inline">
                    @csrf
                    <div class="form-group mt-2">
                        <label>* Dominio:</label>
                        <input type="text" class="form-control form-control-sm" value="{{ $site->subdomain }}" disabled>
                    </div>
                    <div class="form-group mt-2">
                        <label>* Em manutenção</label>
                        <select name="active" class="form-control form-control-sm">
                            <option value="1" {{ $site->maintence == '1' ? 'selected' : '' }}>SIM </option>
                            <option value="0" {{ $site->maintence == '0' ? 'selected' : '' }}>Não</option>
                        </select>
                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="btn btn-sm btn-outline-success">Salvar </button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
            {{-- <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div> --}}
        </div>
    @endif
@stop
