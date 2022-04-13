<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-dark">
    <div class="container-fluid">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-2">
            <li class="nav-item">
                <a class="nav-link"><i class="fas fa-user-circle me-2"></i> {{ Auth::user()->name }} </a>
            </li>
        </ul>
        <form action="{{ route('logout') }}" method="POST">
			@csrf
        <button class="btn btn-sm btn-outline-success" type="submit"> Sair </button>
        </form>
    </div>
</nav>