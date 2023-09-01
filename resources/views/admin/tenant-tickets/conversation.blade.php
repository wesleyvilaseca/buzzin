@extends('layouts.admin.dashboard')

@section('scripts-header')

    <style>
        .chatbox {
            height: 80vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 0 4px rgba(0, 0, 0, .14), 0 4px 8px rgba(0, 0, 0, .28);
        }

        .chat-window {
            flex: auto;
            max-height: calc(100% - 60px);
            background: #2f323b;
            overflow: auto;
        }

        .chat-input {
            flex: 0 0 auto;
            height: 60px;
            background: #40434e;
            border-top: 1px solid #2671ff;
            box-shadow: 0 0 4px rgba(0, 0, 0, .14), 0 4px 8px rgba(0, 0, 0, .28);
        }

        .chat-input textarea {
            height: 40px;
            line-height: 40px;
            outline: 0 none;
            border: none;
            width: calc(100% - 60px);
            color: white;
            text-indent: 10px;
            font-size: 12pt;
            padding: 0;
            background: #40434e;
            resize: none;
        }

        .chat-input textarea::-webkit-scrollbar {
            display: none;
        }

        .chat-input button {
            float: right;
            outline: 0 none;
            border: none;
            background: rgba(255, 255, 255, .25);
            height: 40px;
            width: 40px;
            border-radius: 50%;
            padding: 2px 0 0 0;
            margin: 10px;
            transition: all 0.15s ease-in-out;
        }

        .chat-input input[good]+button {
            box-shadow: 0 0 2px rgba(0, 0, 0, .12), 0 2px 4px rgba(0, 0, 0, .24);
            background: #2671ff;
        }

        .chat-input input[good]+button:hover {
            box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .chat-input input[good]+button path {
            fill: white;
        }

        .msg-container {
            position: relative;
            display: inline-block;
            width: 100%;
            margin: 0 0 10px 0;
            padding: 0;
        }

        .msg-box {
            display: flex;
            background: #5b5e6c;
            padding: 10px 10px 0 10px;
            border-radius: 0 6px 6px 0;
            max-width: 80%;
            width: auto;
            float: left;
            box-shadow: 0 0 2px rgba(0, 0, 0, .12), 0 2px 4px rgba(0, 0, 0, .24);
        }

        .user-img {
            display: inline-block;
            border-radius: 50%;
            height: 40px;
            width: 40px;
            background: #2671ff;
            margin: 0 10px 10px 0;
        }

        .flr {
            flex: 1 0 auto;
            display: flex;
            flex-direction: column;
            width: calc(100% - 50px);
        }

        .messages {
            flex: 1 0 auto;
        }

        .msg {
            display: inline-block;
            font-size: 11pt;
            line-height: 13pt;
            color: rgba(255, 255, 255, .7);
            margin: 0 0 4px 0;
        }

        .msg:first-of-type {
            margin-top: 8px;
        }

        .timestamp {
            color: rgba(0, 0, 0, .38);
            font-size: 8pt;
            margin-bottom: 10px;
        }

        .username {
            margin-right: 3px;
        }

        .posttime {
            margin-left: 3px;
        }

        .msg-self .msg-box {
            border-radius: 6px 0 0 6px;
            background: #2671ff;
            float: right;
        }

        .msg-self .user-img {
            margin: 0 0 10px 10px;
        }

        .msg-self .msg {
            text-align: right;
        }

        .msg-self .timestamp {
            text-align: right;
        }
    </style>
@stop

@section('content')
    <ticket-conversation-tenant ticketid="{{ $ticketid }}"></ticket-conversation-tenant>
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
