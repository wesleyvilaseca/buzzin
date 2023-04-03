@extends('layouts.admin.dashboard')

@php
    $tab = @$_GET['tab'];
@endphp

@section('content')

    @if (@isset($site) && ($site->status == 1 || $site->status == 2))
        @include('admin.site._partials.navbar')

        <div class="alert alert-info text-center mt-2">
            Aqui você poderá selecinar a paleta de cores da sua página
        </div>
        <form action="{{ route('admin.site.layout_update') }}" method="POST" class="form form-inline">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mt-2">
                        <label>* Cor dos botões:</label>
                        <input type="color" class="form-control form-control-sm" name="btn_color"
                            value="{{ @$site?->data?->layout?->paleta_cores_site?->btn_color ? $site->data->layout->paleta_cores_site->btn_color : '#4040ff' }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mt-2">
                        <label>* Cor dos botões quando selecionado:</label>
                        <input type="color" class="form-control form-control-sm" name="btn_color_hover"
                            value="{{ @$site?->data?->layout?->paleta_cores_site?->btn_color_hover ? $site->data->layout->paleta_cores_site->btn_color_hover : '#4060ff' }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mt-2">
                        <label>* Cor das letras nos botões:</label>
                        <input type="color" class="form-control form-control-sm" name="btn_color_letter"
                            value="{{ @$site?->data?->layout?->paleta_cores_site?->btn_color_letter ? $site->data->layout->paleta_cores_site->btn_color_letter : '#ffffff' }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mt-2">
                        <label>* Cor dos links:</label>
                        <input type="color" class="form-control form-control-sm" name="links"
                            value="{{ @$site?->data?->layout?->paleta_cores_site->links ? $site->data->layout->paleta_cores_site->links : '#0d6efd' }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mt-2">
                        <label>* Cor dos links quando selecionados:</label>
                        <input type="color" class="form-control form-control-sm" name="links_hover"
                            value="{{ @$site?->data?->layout?->paleta_cores_site?->links_hover ? $site->data->layout->paleta_cores_site->links_hover : '#4060ff' }}">
                    </div>
                </div>
            </div>

            <div class="text-center mt-2">
                <button type="submit" class="btn btn-sm btn-success">Salvar </button>
            </div>
        </form>
    @endif
@stop
