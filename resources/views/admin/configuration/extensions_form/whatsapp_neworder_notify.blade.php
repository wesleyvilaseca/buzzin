@extends('layouts.admin.dashboard')

@section('content')
    @include('admin.configuration._partials.navbar')

    @php
        $whatsappHelp = env('WHATSAPP_LINK_DEFAULT') . 'Preciso de ajuda para gerar um token para notificação de venda whatsapp';
    @endphp

    @component('components.widget.warning', [
        'canClose' => false,
        'class' => 'p-0 mt-2',
        'type' => 'info',
        'message' =>
            "<small>Caso precise de ajuda para gerar o seu token, <a href='{{ $whatsappHelp }}'>entre em contato com o nosso time</a> </small>",
    ])
    @endcomponent

    @component('components.widget.warning', [
        'canClose' => false,
        'class' => 'p-0',
        'type' => 'warning',
        'message' => '<small>O facebook/meta tem politicas muito restrita sobre o disparo de mensagens iniciada por parte do lojista, para que você não tenha problemas de aprovação de um template, 
                                    é importante usar um modelo padrão, você pode ver mais detalhes do modelo clicando 
                                    <b style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#staticBackdrop">aqui</b>
                                    </small>',
    ])
    @endcomponent

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
                    <label>* Informe o nome do template:</label>
                    <input type="text" class="form-control form-control-sm" placeholder="nova_venda_buzzin"
                        name="template" id="template" value="{{ $extension?->data?->template ?? old('template') }}"
                        required>
                </div>
                <div class="form-group mt-2">
                    <label>
                        * Token whatsapp business:
                        <i class="fa-solid fa-circle-info text-primary" data-bs-toggle="tooltip" data-bs-placement="top"
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


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Template notificação de venda</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>
                        <b>Iniciando a criação do modelo</b>
                    </h4>

                    <p class="ps-5">
                        Na área de criação de modelos de mensagem, click em "Criar modelo"
                    </p>
                    <div class="tutorial-image" align="center">
                        <img src="{{ getFileLink('como-criar-template-meta/meta-template-1.png', true) }}" alt="">
                    </div>

                    <h4 class="pt-2">
                        <b>Configurando o modelo</b>
                    </h4>
                    <p class="ps-5">
                        Na tela seguinte, selecione a categoria <b>Marketing</b> opção <b>Personalida</b>
                    </p>

                    <p class="ps-5">
                        Uma sugestão de nome de template é <b>nova_venda_buzzin</b>
                    </p>

                    <p class="ps-5">
                        Em idiomas selecione <b>Portuguese (BR)</b>
                    </p>

                    <p class="ps-5">
                        Abaixo uma imagem de como deve ficar o preenchimento do template
                        </b>

                    <div class="tutorial-image" align="center">
                        <img src="{{ getFileLink('como-criar-template-meta/meta-template-2.png', true) }}" alt="">
                    </div>

                    <h4 class="pt-2">
                        <b>Criando o modelo</b>
                    </h4>
                    <h5 class="ps-2">
                        Cabeçalho
                    </h5>
                    <p class="ps-5">
                        Na tela seguinte, o cabeçalho deve ser uma <b>mídia</b> do <b>tipo documento</b>, pois, é nesse
                        documento que será mostrado os detalhes da venda e os dados do cliente. No exemplo do conteudo
                        utilize
                        <a href=" {{ getFileLink('como-criar-template-meta/saída.pdf', true) }}" target="_blank">esse
                            modelo</a>
                    </p>
                    <div class="tutorial-image" align="center">
                        <img src="{{ getFileLink('como-criar-template-meta/meta-template-3.png', true) }}" alt="">
                    </div>

                    <h5 class="pt-5 ps-2">
                        Corpo/conteudo
                    </h5>
                    <p class="ps-5">
                        No corpo do modelo, cole o conteudo abaixo
                    </p>
                    <div class="form-group ps-5">
                        <input type="text" class="form-control form-control-sm" readonly
                            value="Olá {{ 1 }}, uma venda acaba de ser finalizada! As informações de entrega estão no documento em anexo :)">
                    </div>
                    <div class="tutorial-image" align="center">
                        <img src="{{ getFileLink('como-criar-template-meta/meta-template-4.png', true) }}" alt="">
                    </div>

                    <h5 class="pt-5 ps-2">
                        Exemplo do conteudo dinâmico
                    </h5>
                    <p class="ps-5">
                        Esse conteudo representa o nome da loja que vai receber a notificação de venda<br>
                        No exemplo do conteudo do corpo, informe um nome, por exemplo: <b>José</b>
                    </p>

                    <h5 class="pt-5 ps-2">
                        Rodapé
                    </h5>
                    <p class="ps-5">
                        No rodapé, cole o conteudo abaixo
                    </p>
                    <div class="form-group ps-5">
                        <input type="text" class="form-control form-control-sm" readonly
                            value="Para mais detalhes, acesse seu painel BuzzIn">
                    </div>

                    <div class="tutorial-image" align="center">
                        <img src="{{ getFileLink('como-criar-template-meta/meta-template-5.png', true) }}" alt="">
                    </div>

                    <p class="pt-5 ps-5">
                        Agóra é enviar o modelo para a meta e aguardar a aprovação :) <br>
                        Caso precise de ajuda, <a
                            href="{{ env('WHATSAPP_LINK_DEFAULT') . 'Preciso de ajuda com a crição de um template para notificação de venda whatsapp' }}">
                            entre em contato com o nosso time
                        </a>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
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
