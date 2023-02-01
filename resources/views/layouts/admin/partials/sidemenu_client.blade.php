<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
        <div class="sidebar-brand">
            <img src="" alt="">
            <a href="#">CodeVilaPlace</a>
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
                        <a href="{{ route('client.dashboard') }}">
                            <i class="fas fa-chart-bar"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-dropdown {{ @$stock ? 'active_side' : '' }}">
                        <a>
                            <i class="fa-solid fa-boxes-stacked"></i>
                            <span>Controle de estoque</span>
                        </a>
                        <div class="sidebar-submenu {{ @$stock ? 'd-block' : '' }}">
                            <ul>
                                <li class="{{ @$stocki ? 'ativo' : '' }}">
                                    <a href="{{ route('client.stockin.index') }}">Entrada de produtos</a>
                                </li>
                                <li class="{{ @$stocko ? 'ativo' : '' }}">
                                    <a href="{{ route('client.stockout.index') }}">Saída de produtos</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>