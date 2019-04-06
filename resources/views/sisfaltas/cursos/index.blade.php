@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Cursos cadastrados</div>

                    <div class="card-body">
                        <div class="float-right mb-2 p-2">
                            <a href="{{ route('sisfalta.cursos.create') }}" class="btn btn-success">Adicionar Curso</a>
                        </div>
                        <div class="p-2">
                            <table class="table table-bordered">
                                <thead>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Sigla</th>
                                <th>E-mail</th>
                                <th>Ações</th>
                                </thead>
                                <tbody>
                                @foreach($cursos as $curso)
                                    <tr>
                                        <td>{{ $curso->id }}</td>
                                        <td>{{ $curso->nome }}</td>
                                        <td>{{ $curso->sigla }}</td>
                                        <td>{{ $curso->email }}</td>
                                        <td>
                                            <a href="{{ route('sisfalta.cursos.edit', $curso->id) }}" class="btn btn-warning">Editar</a>
                                            <button class="btn btn-danger btn-delete" data-id="{{ $curso->id }}" data-toggle="modal" data-target="#modalExluir">
                                                Excluir
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalExluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Excluir curso</h5>
                </div>
                <div class="modal-body">
                    <h5>Confirma a excluão?</h5>
                    <form id="form-delete" action="#" method="post">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" form="form-delete" class="btn btn-danger">Excluir</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).on('pageReady', function () {
            $(".btn-delete").on('click', function () {
                $('#form-delete')[0].action = '{{ route('sisfalta.cursos.destroy', '__id') }}'.replace('__id', $(this).data('id'));
            })
        });
    </script>
@endpush