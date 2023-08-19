@extends('layouts.admin.dashboard')

@section('content')
    @include('admin.configuration._partials.navbar')

    <div class="card">
        <div class="card-body">
            <form action="{{ route($extension->extension->route_base . '.store', [$extension->id]) }}" class="form"
                method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mt-2">
                    <label>* Número do whatsapp que irá enviar a notificação da venda:</label>
                    <input type="text" class="form-control form-control-sm" name="sendernumber" id="sendernumber"
                        value="{{ $extension?->data?->sendernumber ?? old('sendernumber') }}" required>
                </div>
                <div class="form-group mt-2">
                    <label>* Número do whatsapp que irá receber a notificação da venda:</label>
                    <input type="text" class="form-control form-control-sm" name="number" id="number"
                        value="{{ $extension?->data?->number ?? old('number') }}" required>
                </div>
                <div class="form-group mt-2">
                    <label>
                        * Token whatsapp business:
                        <i class="fa-solid fa-circle-info text-primary" 
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        data-bs-html="true"
                        title="O token deve ser gerado em na página facebook developers - https://developers.facebook.com/">
                        </i>
                    </label>
                    <input type="text" class="form-control form-control-sm" name="token" id="token"
                        value="{{ $extension?->data?->token ?? old('token') }}" required>
                </div>
                <div class="form-group mt-2 text-center">
                    <button type="submit" class="btn btn-sm btn-success">Enviar</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script type="text/javascript">
        jQuery(function($) {
            $('#number').mask("(00) 00000-0000");
        });
    </script>
@stop
