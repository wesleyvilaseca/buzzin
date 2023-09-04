@extends('layouts.admin.dashboard')

@section('content')
    @if (Auth::user()->internal == 'N')
        @component('components.widget.default-home-dashboard', [
            'totalUsers' => $totalUsers,
            'totalCategories' => $totalCategories,
            'totalProducts' => $totalProducts,
            'totalTenants' => $totalTenants,
            'totalPlans' => $totalPlans,
            'totalRoles' => $totalRoles,
            'totalProfiles' => $totalProfiles,
            'totalPermissions' => $totalPermissions,
        ])
        @endcomponent

    @endif

@stop
