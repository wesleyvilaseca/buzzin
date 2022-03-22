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
                    <li class="{{ @$home ? 'ativo' : '' }}">
                        <a href="{{ route('admin.home') }}">
                            <i class="fas fa-chart-bar"></i>
                            <span>Home</span>
                        </a>
                    </li>

                    <li class="sidebar-dropdown {{ @$relatorio ? 'active_side' : '' }}">
                        <a>
                            <i class="fas fa-chart-line"></i>
                            <span>Relatório</span>
                        </a>
                        <div class="sidebar-submenu {{ @$relatorio ? 'd-block' : '' }}">
                            <ul>
                                <li class="{{ @$matriculageral ? 'ativo' : '' }}">
                                    <a href="#">submenu1</a>
                                </li>

                                <li class="{{ @$relatorioReativados ? 'ativo' : '' }}">
                                    <a href="#">submenu2</a>
                                </li>
                            </ul>
                        </div>
                    </li>
            </div>
        </div>
</nav>
