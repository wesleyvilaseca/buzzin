@extends('layouts.admin.dashboard')

@section('content')
    @include('admin.configuration._partials.navbar')

    <div class="row">
        <div class="col-md-5">
            <div class="card mb-3">
                <div class="cart-body">
                    <div class="card-header">Atualizar senha</div>
                    <div class="form-group mt-2">
                        <form action="#" method="POST" class="form form-inline">
                            @csrf
                            <div class="container mb-2">

                                <div class="form-group mt-2">
                                    <label>Senha atual:</label>
                                    <input type="text" name="password" class="form-control form-control-sm" autocomplete="off">
                                </div>

                                <div class="form-group mt-2">
                                    <label>Nova senha:</label>
                                    <input type="text" name="new_password" class="form-control form-control-sm" autocomplete="off">
                                </div>

                                <div class="form-group mt-2">
                                    <label>Confirme a nova senha:</label>
                                    <input type="text" name="new_password_confirm" class="form-control form-control-sm" autocomplete="off">
                                </div>


                                <div class="form-group mt-2" align="right">
                                    <button type="submit" class="btn btn-sm btn-success">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
