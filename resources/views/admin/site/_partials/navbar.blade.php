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
                @can('site')
                    <li class="nav-item">
                        <a class="nav-link  {{ @$_site ? 'activated' : '' }}" aria-current="page"
                            href="{{ route('admin.site') }}">
                            <i class="fa-solid fa-gear"></i>
                            Geral
                        </a>
                    </li>
                @endcan

                @can('site')
                    <li class="nav-item">
                        <a class="nav-link  {{ @$_sitelayout ? 'activated' : '' }}" aria-current="page"
                            style="a:hover: #fff" href="{{ route('admin.site.layout') }}">
                            <i class="fa-solid fa-palette"></i>
                            Layout
                        </a>
                    </li>
                @endcan

                @can('site')
                    <li class="nav-item">
                        <a class="nav-link  {{ @$_siteextensions ? 'activated' : '' }}" aria-current="page"
                            style="a:hover: #fff" href="{{ route('admin.site.extensions') }}">
                            <i class="fa-solid fa-puzzle-piece"></i>
                            Extensões
                        </a>
                    </li>
                @endcan
            </ul>
            <form class="d-flex mb-1" style="margin-left: 5px;">
                <a href="http://{{ \App\Supports\Helper\Utils::getSiteTenantLink() }}" target="_blank" class="btn btn-sm btn-outline-warning">
                    <i class="fa-solid fa-eye"></i>
                    WebSite
                </a>
            </form>
            <form class="d-flex mb-1" method="POST" action="{{ route('admin.site.clearcache') }}" style="margin-left: 5px;">
                @csrf
                <button class="btn btn-sm btn-danger text-white" type="submit">
                    <i class="fa-solid fa-eraser"></i>
                    Limpar cache
                </button>
            </form>
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
