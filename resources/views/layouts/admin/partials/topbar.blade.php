<nav class="navbar fixed-top navbar-expand-lg navbar-light top-nav">
    <div class="container-fluid">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-2">
            {{-- <li class="nav-item">
                <a class="nav-link"><i class="fas fa-user-circle me-2"></i>
                    {{ Auth::user()->name }}
                </a>
            </li> --}}
            @if (Auth::user()->internal == 'N')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.tenant.tickets') }}">
                        <i class="fa-regular fa-circle-question me-2"></i>
                        <span class="position-relative">
                            Suporte
                            @php
                                $ticketNotify = DB::table('user_notifies')
                                    ->where([
                                        'user_id' => Auth::user()->id,
                                        'type' => 1, //ticket type
                                        'visualized' => 0, //not vizualized
                                    ])
                                    ->first();
                                
                                $notVisualizedMessages = DB::table('ticket_conversations')
                                    ->where([['user_id', '!=', Auth::user()->id], ['visualized', '=', 0]])
                                    ->first();
                            @endphp
                            @if ($ticketNotify || $notVisualizedMessages)
                                <span
                                    class="position-absolute start-100 translate-middle badge rounded-pill bg-danger mt-0 ms-0">
                                    1
                                </span>
                            @endif
                        </span>
                    </a>
                </li>
            @endif

        </ul>
        @if (Auth::user()->internal == 'N')
            <form action="{{ route('tenant.open') }}" method="POST" class="form form-inline">
                @csrf
                <div class="container" style="padding-bottom: 9px">
                    <input type="hidden" name="open" value="{{ Auth::user()->tenant->open == 'N' ? 'Y' : 'N' }}">
                    <div class="form-group mt-2" align="center">
                        <button type="submit"
                            class="btn btn-sm btn-{{ Request::session()->get('open') == 'N' ? 'success' : 'danger' }}">
                            @if (Auth::user()->tenant->open == 'N')
                                <i class="fa-sharp fa-solid fa-door-open"></i> Abrir
                            @else
                                <i class="fa-sharp fa-solid fa-door-closed"></i> Fechar
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        @else
            <a class="nav-link">
                <i class="fas fa-user-circle me-2" style="padding-bottom: 12.5px"></i>
                {{ explode(' ', Auth::user()->name)[0] }}
            </a>
        @endif
    </div>
</nav>
