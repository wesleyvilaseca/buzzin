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

    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@300;400;500;700&display=swap" rel="stylesheet" />

    <script src="{{ mix('js/app.js') }}" defer></script>

    <title>{{ @$title ? $title : 'BuzzIn' }}</title>

    @yield('scripts-header')

    <script>
        let w = window.innerWidth;
    </script>
</head>

<body>
    <div id="app" class="">
        <div id="formloader"></div>
        <div id="side-menu" class="page-wrapper chiller-theme toggled">
            <a id="show-sidebar" class="btn btn-sm" style="cursor:pointer; color: rgb(64, 64, 255);">
                <i class="fas fa-bars"></i>
            </a>

            @include('layouts.admin.partials.sidemenu')

            @include('layouts.admin.partials.topbar')

            <main class="page-content">
                <div class="container-fluid">
                    @include('layouts.admin.alerts')

                    @if (@isset($toptitle))
                        <h5>{{ $toptitle }}</h5>
                    @endif

                    @if (Auth::user()->tenant->subscription_active == 0)
                        @if (@!isset($showSubscriptionMessage))
                            <div class="text-center alert alert-danger alert-dismissible fade show" role="alert">
                                A sua assinatura está expirada e seus serviços estão inativos, para regularizar
                                <strong><a href="{{ route('admin.subscriptions') }}">click aqui</a></strong>
                            </div>
                        @endif
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

                    @if (@isset($toptitle) || @isset($breadcrumb))
                        <hr>
                    @endif

                    @yield('content')

                </div>
            </main>
            <div class="modal"></div>
        </div>
    </div>

    <script>
        if (w <= 660) {
            $(".page-wrapper").removeClass("toggled");
        } else {
            $(".page-wrapper").addClass("toggled");
        }
    </script>

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>

    {{-- jquery mask --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"
        integrity="sha512-jTgBq4+dMYh73dquskmUFEgMY5mptcbqSw2rmhOZZSJjZbD2wMt0H5nhqWtleVkyBEjmzid5nyERPSNBafG4GQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- jquery maskmoney --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"
        integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('js/admin/sidebar/sidebar.js') }}"></script>
    <script src="{{ asset('js/helper.js') }}"></script>

    @yield('js')
    @yield('components-js')
</body>

</html>
