@extends('layouts.admin.dashboard')

@section('content')
    @include('admin.configuration._partials.navbar')
    <div class="mb-2" align="right">
        <button type="button" class="btn  btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Novo
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Horário</th>
                        <th width="150">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list as $time)
                        <tr>
                            <td>{{ $time->time_ini }} - {{ $time->time_end }}</td>
                            <td style="width=10px;">
                                <form method="POST" action="{{ route('operation.delete', $tenantOperation->id) }}">
                                    @csrf
                                    <input type="hidden" name="operation_day_id" value="{{ $time->id }}">
                                    <button href="#" class="btn btn-sm btn-danger show_confirm">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <p class="text-center">Não há horários registrados para listar</p>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Novo horário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('operation.store', $tenantOperation->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label>* Selecione o horário inicial:</label>
                                    <input type="time" name="time_ini" class="form-control form-control-sm"
                                        placeholder="08:00" required />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label>* Selecione o horário final:</label>
                                    <input type="time" name="time_end" class="form-control form-control-sm"
                                        placeholder="12:00" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('content')
    <script>
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Tem certeza que deseja remover esse registro?`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>
@stop
