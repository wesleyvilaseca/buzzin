<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-dark">
    <div class="container-fluid">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-2">
            <li class="nav-item">
                <a class="nav-link"><i class="fas fa-user-circle me-2"></i>
                    {{ Auth::user()->name }}
                </a>
            </li>
        </ul>
        <form action="{{ route('tenant.open') }}" method="POST" class="form form-inline">
            @csrf
            <div class="container mb-2">
                <input type="hidden" name="open" value="{{ Auth::user()->tenant->open == 'N' ? 'Y' : 'N' }}">
                <div class="form-group mt-2" align="center">
                    <button type="submit"
                        class="btn btn-sm btn-{{ Request::session()->get('open') == 'N' ? 'success' : 'danger' }}">
                        @if ( Auth::user()->tenant->open == 'N')
                        <i class="fa-sharp fa-solid fa-door-open"></i> Abrir
                        @else
                            <i class="fa-sharp fa-solid fa-door-closed"></i> Fechar
                        @endif
                    </button>
                </div>
            </div>
        </form>
    </div>
</nav>
