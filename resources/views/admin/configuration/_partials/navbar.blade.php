<nav class="navbar nav-config navbar-expand-lg bg-dark mb-3">
    <div class="container-fluid">
        {{-- <a class="navbar-brand" href="#">Navbar</a> --}}
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="fas fa-bars" style="color:#fff; font-size:15px; border:none;"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @can('tenant_payment')
                    <li class="nav-item">
                        <a class="nav-link  {{ @$_payment ? 'activated' : '' }}" aria-current="page"
                            href="{{ route('admin.payments') }}">
                            <i class="fa-solid fa-credit-card"></i>
                            Formas de pagamento
                        </a>
                    </li>
                @endcan

                <li class="nav-item">
                    <a class="nav-link  {{ @$_delivery ? 'activated' : '' }}" aria-current="page" style="a:hover: #fff"
                        href="{{ route('admin.shippings') }}">
                        <i class="fa-solid fa-truck"></i>
                        Formas de entrega
                    </a>
                </li>

                @can('tenant_operation')
                    <li class="nav-item">
                        <a class="nav-link  {{ @$_operation ? 'activated' : '' }}" aria-current="page" style="a:hover: #fff"
                            href="{{ route('admin.operations') }}">
                            <i class="fa-solid fa-clock"></i> Funcionamento
                        </a>
                    </li>
                @endcan

                @can('tenant_account')
                    <li class="nav-item">
                        <a class="nav-link  {{ @$_myaccount ? 'activated' : '' }}" aria-current="page" style="a:hover: #fff"
                            href="{{ route('admin.myaccount') }}">
                            <i class="fa-solid fa-user"></i>
                            Minha conta
                        </a>
                    </li>
                @endcan
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li> --}}
            </ul>
            {{-- <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form> --}}
        </div>
    </div>
</nav>


@if (@isset($breadcrumb_config))
    <div id="breadcrumb" class="mt-2">
        <ol class="breadcrumb">
            @foreach ($breadcrumb_config as $bread)
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
