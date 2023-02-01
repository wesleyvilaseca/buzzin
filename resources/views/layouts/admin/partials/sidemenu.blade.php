<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
        <div class="sidebar-brand">
            <img src="" alt="">
            <a href="#">CodeVila - Finanças</a>
            <div id="close-sidebar">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="sidebar-header">
            <div class="sidebar-menu">
                <ul id="sitemaps">
                    <li class="header-menu">
                        <span>Navegação</span>
                    </li>
                    <li class="{{ @$dashboard ? 'ativo' : '' }}">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-chart-bar"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

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
                                <span>Perfis</span>
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

                    @can('categoryMarkets')
                        <li class="{{ @$marketCateg ? 'ativo' : '' }}">
                            <a href="{{ route('admin.categories.market') }}">
                                <i class="fa-solid fa-code-branch"></i>
                                <span>Categorias Supermercados</span>
                            </a>
                        </li>
                    @endcan

                    @can('productsMarkets')
                        <li class="{{ @$marketProd ? 'ativo' : '' }}">
                            <a href="{{ route('admin.products.market') }}">
                                <i class="fa-solid fa-box"></i>
                                <span>Produtos Supermercados</span>
                            </a>
                        </li>
                    @endcan

                    {{-- @can('categories')
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

                    @can('tables')
                        <li class="{{ @$tab ? 'ativo' : '' }}">
                            <a href="{{ route('admin.tables') }}">
                                <i class="fa-solid fa-spoon"></i>
                                <span>Mesas</span>
                            </a>
                        </li>
                    @endcan

                    @can('pedidos')
                        <li class="{{ @$order_m ? 'ativo' : '' }}">
                            <a href="{{ route('orders.index') }}">
                                <i class="fa-solid fa-spoon"></i>
                                <span>Pedidos</span>
                            </a>
                        </li>
                    @endcan

                    @can('tenants')
                        <li class="{{ @$ten ? 'ativo' : '' }}">
                            <a href="{{ route('admin.tenants') }}">
                                <i class="fa-solid fa-building"></i>
                                <span>empresas</span>
                            </a>
                        </li>
                    @endcan --}}


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

                                    <li class="{{ @$rol ? 'ativo' : '' }}">
                                        <a href="{{ route('admin.roles') }}">Cargos</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan
            </div>
        </div>
</nav>
