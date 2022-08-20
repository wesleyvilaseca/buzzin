@extends('layouts.admin.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 card-content bg-info">
                <div class="card-content-wrapper text-white">
                    <div class="card-content-left">
                        <div class="card-heading">Usuários</div>
                        {{-- <div class="card-subheading">para este mês</div> --}}
                    </div>
                    <div class="card-content-right">
                        <div class="card-numbers text-white"><span>{{ $totalUsers }}</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 card-content bg-danger">
                <div class="card-content-wrapper text-white">
                    <div class="card-content-left">
                        <div class="card-heading">Mesas</div>
                        {{-- <div class="card-subheading">para este mês</div> --}}
                    </div>
                    <div class="card-content-right">
                        <div class="card-numbers text-white"><span>{{ $totalTables }}</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 card-content bg-success">
                <div class="card-content-wrapper text-white">
                    <div class="card-content-left">
                        <div class="card-heading">Categorias</div>
                        {{-- <div class="card-subheading">para este mês</div> --}}
                    </div>
                    <div class="card-content-right">
                        <div class="card-numbers text-white"><span>{{ $totalCategories }}</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 card-content bg-dark">
                <div class="card-content-wrapper text-white">
                    <div class="card-content-left">
                        <div class="card-heading">Produtos</div>
                        {{-- <div class="card-subheading">para este mês</div> --}}
                    </div>
                    <div class="card-content-right">
                        <div class="card-numbers text-white"><span>{{ $totalProducts }}</span></div>
                    </div>
                </div>
            </div>
        </div>

        @admin
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 card-content bg-warning">
                    <div class="card-content-wrapper text-white">
                        <div class="card-content-left">
                            <div class="card-heading">Empresas</div>
                            {{-- <div class="card-subheading">para este mês</div> --}}
                        </div>
                        <div class="card-content-right">
                            <div class="card-numbers text-white"><span>{{ $totalTenants }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        @endadmin

        @admin
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 card-content bg-secondary">
                    <div class="card-content-wrapper text-white">
                        <div class="card-content-left">
                            <div class="card-heading">Planos</div>
                            {{-- <div class="card-subheading">para este mês</div> --}}
                        </div>
                        <div class="card-content-right">
                            <div class="card-numbers text-white"><span>{{ $totalPlans }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        @endadmin

        @admin
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 card-content bg-premium-dark">
                    <div class="card-content-wrapper text-white">
                        <div class="card-content-left">
                            <div class="card-heading">Cargos</div>
                            {{-- <div class="card-subheading">para este mês</div> --}}
                        </div>
                        <div class="card-content-right">
                            <div class="card-numbers text-white"><span>{{ $totalRoles }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        @endadmin

        @admin
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 card-content bg-grow-early">
                    <div class="card-content-wrapper text-white">
                        <div class="card-content-left">
                            <div class="card-heading">Perfis</div>
                            {{-- <div class="card-subheading">para este mês</div> --}}
                        </div>
                        <div class="card-content-right">
                            <div class="card-numbers text-white"><span>{{ $totalProfiles }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        @endadmin

        @admin
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 card-content bg-midnight-bloom">
                    <div class="card-content-wrapper text-white">
                        <div class="card-content-left">
                            <div class="card-heading">Permissões</div>
                            {{-- <div class="card-subheading">para este mês</div> --}}
                        </div>
                        <div class="card-content-right">
                            <div class="card-numbers text-white"><span>{{ $totalPermissions }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        @endadmin
    </div>
@stop
