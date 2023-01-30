<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="sistemaphp">

    {{-- <link rel="icon" href="{{URL_BASE}}assets/global/icons/icone.ico" type="image/x-icon"> --}}

    <!--css sidebar-->
    <link href="{{ asset('css/admin/all.css') }}" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- sweet alert-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.1/dist/sweetalert2.all.min.js"></script>

    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>{{ @$title ? $title : 'CodeVilaFood' }}</title>

    @yield('scripts-header')
</head>

<body>
    <div id="formloader"></div>
    <div id="side-menu" class="page-wrapper chiller-theme toggled">
        <a id="show-sidebar" class="btn btn-sm btn-dark" style="cursor:pointer;">
            <i class="fas fa-bars"></i>
        </a>


        @if (Request::session()->get('tipo_login')[0] == 1)
            @include('layouts.admin.partials.sidemenu')
        @endif

        @if (Request::session()->get('tipo_login')[0] == 2)
            @include('layouts.admin.partials.sidemenu_client')
        @endif

        @include('layouts.admin.partials.topbar')

        <main class="page-content">
            <div class="container-fluid">
                @include('layouts.admin.alerts')
                @if (@isset($toptitle))
                    <h5>{{ $toptitle }}</h5>
                @endif
                @if (@isset($breadcrumb))
                    <div id="breadcrumb" class="mt-2">
                        <ol class="breadcrumb">
                            @foreach ($breadcrumb as $bread)
                                @if (@$bread['active'])
                                    <li class="breadcrumb-item active">
                                        {{ $bread['title'] }}
                                    </li>
                                @else
                                    <li class="breadcrumb-item">
                                        <a href="{{ $bread['route'] }}">{{ $bread['title'] }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </div>
                @endif

                <hr>

                @yield('content')

            </div>
        </main>
        <div class="modal"></div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/admin/sidebar/sidebar.js') }}"></script>

    <script>
        /*********************************************
         * Gif para requisições request
         ********************************************/
        // $(document).ready(function() {
        //     $("form").on("submit", function() {
        //         var spinner = $('#formloader');
        //         spinner.show();
        //     });
        // });
    </script>

    @yield('js')
    @yield('components-js')

</body>

</html>
