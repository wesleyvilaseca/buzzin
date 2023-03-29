@extends('layouts.admin.dashboard')

@section('content')
    <div class="text-center">
        <h1 class="title-plan">Escolha o plano</h1>
    </div>
    <div class="row">
        @foreach ($plans as $plan)
            <div class="col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h5 class="title">{{ $plan->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="inner-content">
                            <div class="text-center">
                                <span class="">R$
                                    <span class="fw-bold fs-1">{{ number_format($plan->price, 2, ',', '.') }}</span>
                                </span>
                            </div>
                            <ul class="list-group list-group-flush">
                                @foreach ($plan->details as $detail)
                                    <li class="list-group-item"><i class="text-success fa-solid fa-check me-2"></i> {{ $detail->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="d-grid gap-2 m-3">
                        <a class="btn btn-success" href="#">Assinar</a>
                    </div>
                </div>
            </div>
            <!--end-->
        @endforeach
    </div>
@endsection
