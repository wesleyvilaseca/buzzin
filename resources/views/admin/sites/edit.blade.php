@extends('layouts.admin.dashboard')

@section('content')
    <div class="mb-2" align="right">
        <a href="{{ route('admin.sites') }}" class="btn btn-sm btn-dark">
            <i class="fa-solid fa-chevron-left me-2"></i>
            Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.sites.update', $site->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mt-2">
                    <label>Empresa:</label>
                    <input type="text" class="form-control form-control-sm" value="{{ $site->tenant->name }}" disabled>
                </div>
                <div class="form-group mt-2">
                    <label>Domínio:</label>
                    <input type="text" class="form-control form-control-sm" value="{{ $site->domain }}" disabled>
                </div>
                <div class="form-group mt-2">
                    <label>Subdomínio:</label>
                    <input type="text" class="form-control form-control-sm" value="{{ $site->subdomain }}" disabled>
                </div>

                <div class="form-group mt-2">
                    <label>Status do site</label>
                    <select name="status" class="form-control form-control-sm" required>
                        <option value="0" {{ @$site->status == '0' ? 'selected' : '' }}>
                            Aguardando aprovação e publicação
                        </option>
                        <option value="1" {{ @$site->status == '1' ? 'selected' : '' }}>
                            Publicado
                        </option>
                        <option value="2" {{ @$site->status == '2' ? 'selected' : '' }}>
                            Desativado pela administração
                        </option>
                    </select>
                </div>

                <div class="form-group mt-2">
                    <label>Site em manutenção?</label>
                    <select name="maintence" class="form-control form-control-sm" required>
                        <option value="1" {{ @$site->maintence == '1' ? 'selected' : '' }}>
                            Sim
                        </option>
                        <option value="0" {{ @$site->maintence == '0' ? 'selected' : '' }}>
                            Não
                        </option>
                    </select>
                </div>

                <div class="form-group text-center mt-2">
                    <button type="submit" class="btn btn-sm btn-success">Enviar</button>
                </div>
            </form>
        </div>
    </div>
@stop
