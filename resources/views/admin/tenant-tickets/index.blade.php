@extends('layouts.admin.dashboard')

@section('content')
    <div class="card">
        <div class="card-header">
            Lista de chamados <button class="ms-2 btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                data-bs-target="#exampleModal">Abrir novo chamado</button>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                        type="button" role="tab" aria-controls="home" aria-selected="true">Pendentes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                        role="tab" aria-controls="profile" aria-selected="false">Finalizados</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    Pendentes
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    finalizados
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Novo chamado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="container mb-2">
                            <div class="form-group mt-2">
                                <label>* Qual o tipo de chamado?</label>
                                <select name="ticket_type_id" class="form-control form-control-sm" required>
                                    <option disabled selected>Selecione uma opção</option>
                                    <option value="0">
                                        Dúvidas
                                    </option>
                                    <option value="1">
                                        Suporte
                                    </option>
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <label>* Descrição do chamado:</label>
                                <input type="text" name="description" class="form-control form-control-sm" required>
                            </div>
                            <div class="form-group mt-2">
                                <label>* Detalhes:</label>
                                <textarea name="message" ols="30" rows="5" class="form-control form-control-sm editor">                                    
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        var plugin_tiny = "";
        var plugin_filemanager = "";
        var external_filemanager_path_server = "";
        var templates = "";
        tinymce.init({
            content_css: 'https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css',
            relative_urls: false,
            remove_script_host: false,
            selector: ".editor",
            height: 300,
            plugins: [
                "bbcode code print preview importcss tinydrive searchreplace autolink autosave directionality visualblocks visualchars fullscreen codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap emoticons"
            ],
            // plugins: [
            //     "bbcode code print preview importcss tinydrive searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap emoticons responsivefilemanager"
            // ],
            // toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect| template",
            // toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview | code",
            toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
            toolbar2: "| link unlink anchor | forecolor backcolor",
            bbcode_dialect: 'punbb',
            image_advtab: false,
            external_filemanager_path: '',
            filemanager_title: "Responsive Filemanager",
            external_plugins: {
                "responsivefilemanager": '',
                "filemanager": ''
            },
            templates: ''
        });
    </script>
@stop
