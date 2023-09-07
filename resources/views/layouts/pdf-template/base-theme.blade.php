<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="sistemaphp">

    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    
    <!--css sidebar-->
    <link href="{{ asset('css/admin/all.css') }}" rel="stylesheet">

    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <title>{{ @$title ? $title : 'BuzzIn' }}</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    @yield('scripts-header')
</head>

<body>
    <div id="app" class="">
        <div id="formloader"></div>
        <div id="side-menu" class="page-wrapper chiller-theme toggled">
            <a id="show-sidebar" class="btn btn-sm" style="cursor:pointer; color: rgb(64, 64, 255);">
                <i class="fas fa-bars"></i>
            </a>

            <main class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>
            <div class="modal"></div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    {{-- popover --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    {{-- bootstrapjs --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>

    @yield('js')
    @yield('components-js')
</body>

</html>
