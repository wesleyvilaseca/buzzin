<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title>{{ @$title ? $title : config('app.name') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon/favicon-96x96.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@300;400;500;700&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <link href="{{ asset('css/site.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
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
            <hr>
        @endif

        <main class="main main--footerFixed bg-gray-100">
            @yield('content')
        </main>
        @include('layouts.site._partials.footer')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
