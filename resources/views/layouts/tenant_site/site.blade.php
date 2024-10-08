<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ @$title ? $title : config('app.name') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon/favicon-96x96.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@300;400;500;700&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('images/favicon.png') }}">

    <link href="{{ asset('css/tenant_client/auth.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tenant_client/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tenant_client/tenant_site.css') }}" rel="stylesheet">
    <link rel="stylesheet" href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css'>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- sweet alert-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.1/dist/sweetalert2.all.min.js"></script>

    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="{{ mix('js/inertia.js') }}" defer></script>

    @yield('scripts-header')
    @inertiaHead
    @routes
</head>

<body>
    @inertia
    <div id="app">
        <main class="main main--footerFixed bg-gray-100">
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
                <hr>
            @endif

            @if (@isset($toptitle))
                <div class="mt-5 text-center">
                    <h5>{{ $toptitle }}</h5>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
