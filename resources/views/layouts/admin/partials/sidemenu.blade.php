<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
        <div class="sidebar-brand text-center">
            <img src="" alt="">
            <a href="#">Buzz<span style="color: #4040ff;">In!</span></a>
            <div id="close-sidebar">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="sidebar-header">
            <div class="sidebar-menu">
                <ul id="sitemaps">
                    <li class="{{ @$dashboard ? 'ativo' : '' }}">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-chart-bar"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    @can('support')
                        <li class="{{ @$ticket_support ? 'ativo' : '' }}">
                            <a href="{{ route('admin.tickets') }}">
                                <i class="fa-brands fa-font-awesome position-relative">
                                    @php
                                        $tickets = DB::table('tickets')
                                            ->where('status', 0)
                                            ->count();
                                    @endphp
                                    @if ($tickets > 0)
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger mt-0 ms-0">
                                            {{ $tickets }}
                                        </span>
                                    @endif
                                </i>
                                <span>Suporte</span>
                            </a>
                        </li>
                    @endcan

                    @can('plans')
                        <li class="{{ @$plan ? 'ativo' : '' }}">
                            <a href="{{ route('admin.plan') }}">
                                <i class="fa-brands fa-font-awesome"></i>
                                <span>Planos</span>
                            </a>
                        </li>
                    @endcan

                    @can('profiles')
                        <li class="{{ @$prof ? 'ativo' : '' }}">
                            <a href="{{ route('admin.profiles') }}">
                                <i class="fa-solid fa-id-badge"></i>
                                <span>Modulos do sistema</span>
                            </a>
                        </li>
                    @endcan

                    @can('user')
                        <li class="{{ @$us ? 'ativo' : '' }}">
                            <a href="{{ route('admin.users') }}">
                                <i class="fa-solid fa-users"></i>
                                <span>Usuários</span>
                            </a>
                        </li>
                    @endcan

                    @can('profession')
                        <li class="{{ @$rol ? 'ativo' : '' }}">
                            <a href="{{ route('admin.roles') }}">
                                <i class="fa fa-address-card"></i>
                                <span>Cargos</span>
                            </a>
                        </li>
                    @endcan

                    @can('categories')
                        <li class="{{ @$cat ? 'ativo' : '' }}">
                            <a href="{{ route('admin.categories') }}">
                                <i class="fa-solid fa-code-branch"></i>
                                <span>Categorias</span>
                            </a>
                        </li>
                    @endcan

                    @can('products')
                        <li class="{{ @$prod ? 'ativo' : '' }}">
                            <a href="{{ route('admin.products') }}">
                                <i class="fa-solid fa-box"></i>
                                <span>Produtos</span>
                            </a>
                        </li>
                    @endcan

                    {{-- @can('tables')
                        <li class="{{ @$tab ? 'ativo' : '' }}">
                            <a href="{{ route('admin.tables') }}">
                                <i class="fa-solid fa-check"></i>
                                <span>Mesas</span>
                            </a>
                        </li>
                    @endcan --}}

                    @can('tenant_orders')
                        <li class="{{ @$order_m ? 'ativo' : '' }}">
                            <a href="{{ route('orders.index') }}">
                                <i class="fa-solid fa-cart-shopping position-relative">
                                    @php
                                        $orders = Auth::user()
                                            ->tenant->order->where('status', 'open')
                                            ->count();
                                    @endphp
                                    @if ($orders > 0)
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger mt-0 ms-0">
                                            {{ $orders }}
                                        </span>
                                    @endif
                                </i>
                                <span>Pedidos</span>
                            </a>
                        </li>
                    @endcan

                    @if (Auth::user()->internal == 'N')
                        <li class="{{ @$transactions ? 'ativo' : '' }}">
                            <a href="{{ route('admin.transactions') }}">
                                <i class="fa-solid fa-money-bill"></i>
                                <span>Minhas transações</span>
                            </a>
                        </li>
                    @endif

                    @can('tenants')
                        <li class="{{ @$ten ? 'ativo' : '' }}">
                            <a href="{{ route('admin.tenants') }}">
                                <i class="fa-solid fa-building"></i>
                                <span>Empresas</span>
                            </a>
                        </li>
                    @endcan

                    @can('config')
                        <li class="{{ @$_configuration ? 'ativo' : '' }}">
                            <a href="{{ route('admin.configuration') }}">
                                <i class="fa-solid fa-gear"></i>
                                <span>Configurações da loja</span>
                            </a>
                        </li>
                    @endcan

                    @can('site')
                        <li class="{{ @$_sitearea ? 'ativo' : '' }}">
                            <a href="{{ route('admin.site') }}">
                                <i class="fa-solid fa-store"></i>
                                <span>Meu Site</span>
                            </a>
                        </li>
                    @endcan

                    @can('admsites')
                        <li class="{{ @$_sites ? 'ativo' : '' }}">
                            <a href="{{ route('admin.sites') }}">
                                <i class="fa-solid fa-building position-relative">
                                    @php
                                        $sites = DB::table('sites')
                                            ->where(['status' => 0, 'status_domain' => 0])
                                            ->count();
                                    @endphp
                                    @if ($sites > 0)
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger mt-0 ms-0">
                                            {{ $sites }}
                                        </span>
                                    @endif
                                </i>
                                <span>Sites</span>
                            </a>
                        </li>
                    @endcan

                    @can('zones')
                        <li class="sidebar-dropdown {{ @$_zone ? 'active_side' : '' }}">
                            <a>
                                <i class="fa-solid fa-location-dot"></i>
                                <span>Zonas de entrega</span>
                            </a>
                            <div class="sidebar-submenu {{ @$_zone ? 'd-block' : '' }}">
                                <ul>
                                    @can('geolocation_zones')
                                        <li class="{{ @$geo ? 'ativo' : '' }}">
                                            <a href="{{ route('admin.zones.geolocation') }}">Por geolocalização</a>
                                        </li>
                                    @endcan
                                    {{-- <li class="{{ @$cep ? 'ativo' : '' }}">
                                        <a href="#">Por CEP</a>
                                    </li> --}}
                                </ul>
                            </div>
                        </li>
                    @endcan

                    @can('acl')
                        <li class="sidebar-dropdown {{ @$perm ? 'active_side' : '' }}">
                            <a>
                                <i class="fa-solid fa-lock"></i>
                                <span>Controle de acesso</span>
                            </a>
                            <div class="sidebar-submenu {{ @$perm ? 'd-block' : '' }}">
                                <ul>
                                    <li class="{{ @$permi ? 'ativo' : '' }}">
                                        <a href="{{ route('admin.permissions') }}">Permissões</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan
                </ul>
            </div>
        </div>
    </div>
    <div class="sidebar-footer">
        {{--  
        <a href="#">
            <i class="fa fa-bell"></i>
            <span class="badge badge-pill badge-warning notification"> 3</span>
        </a>
        <a href="#">
            <i class="fa fa-envelope"></i>
            <span class="badge badge-pill badge-success notification">7</span>
        </a>
        <a href="#">
            <i class="fa fa-cog"></i>
            <span class="badge-sonar"></span>
        </a> --}}
        <a href="{{ route('logout') }}">
            <i class="fa fa-power-off"></i>
        </a>
    </div>
</nav>
