@extends('layouts.admin.dashboard')

@section('content')
    @if (@isset($site) && ($site->status == 1 || $site->status == 2))
        @include('admin.site._partials.navbar')

        <div class="card">
            <div class="card-body">
                <form action="{{ route($extension->extension->route_base . '.store', [$extension->id]) }}" class="form"
                    method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mt-2">
                        <label>* Número do whatsapp:</label>
                        <input type="text" class="form-control form-control-sm" name="number" id="number"
                            value="{{ $extension?->data?->number ?? old('number') }}" required>
                    </div>
                    <div class="form-group mt-2">
                        <label>* Mensagem:</label>
                        <input type="text" name="message" class="form-control form-control-sm" placeholder="Olá, venho do seu site buzzin"
                            value="{{ $extension?->data?->message ?? old('price') }}" required>
                    </div>

                    <div class="form-group mt-2 text-center">
                        <button type="submit" class="btn btn-sm btn-success">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@stop

@section('js')
    <script type="text/javascript">
        jQuery(function($) {
            $('#number').mask("(00) 00000-0000");
        });
    </script>
@stop
