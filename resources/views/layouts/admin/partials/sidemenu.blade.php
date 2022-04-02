<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
        <div class="sidebar-brand">
            <img src="" alt="">
            <a href="#">CodeVilaFood</a>
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

                    <li class="{{ @$plan ? 'ativo' : '' }}">
                        <a href="{{ route('admin.plan') }}">
                            <i class="fa-brands fa-font-awesome"></i>
                            <span>Planos</span>
                        </a>
                    </li>

                    <li class="{{ @$prof ? 'ativo' : '' }}">
                        <a href="{{ route('admin.profiles') }}">
                            <i class="fa-solid fa-id-badge"></i>
                            <span>Perfis</span>
                        </a>
                    </li>

                    <li class="{{ @$us ? 'ativo' : '' }}">
                        <a href="{{ route('admin.users') }}">
                            <i class="fa-solid fa-users"></i>
                            <span>Usuários</span>
                        </a>
                    </li>

                    <li class="{{ @$cat ? 'ativo' : '' }}">
                        <a href="{{ route('admin.categories') }}">
                            <i class="fa-solid fa-code-branch"></i>
                            <span>Categorias</span>
                        </a>
                    </li>

                    <li class="{{ @$prod ? 'ativo' : '' }}">
                        <a href="{{ route('admin.products') }}">
                            <i class="fa-solid fa-box"></i>
                            <span>Produtos</span>
                        </a>
                    </li>

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

                                {{-- <li class="{{ @$relatorioReativados ? 'ativo' : '' }}">
                                    <a href="#">submenu2</a>
                                </li> --}}
                            </ul>
                        </div>
                    </li>
            </div>
        </div>
</nav>
