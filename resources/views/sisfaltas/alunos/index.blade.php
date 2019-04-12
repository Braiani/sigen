@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Alunos cadastrados</div>

                    <div class="card-body">
                        <div class="float-right mb-2 p-2">
                            <a href="{{ route('sisfalta.alunos.create') }}" class="btn btn-success">Adicionar Aluno</a>
                        </div>
                        <div class="p-2">
                            <table class="table table-bordered">
                                <thead>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Curso</th>
                                <th>E-mail Cadastrado</th>
                                <th>Ações</th>
                                </thead>
                                <tbody>
                                @foreach($alunos as $aluno)
                                    <tr>
                                        <td>{{ $aluno->id }}</td>
                                        <td>{{ $aluno->nome }}</td>
                                        <td>{{ $aluno->curso->nome }}</td>
                                        <td>{{ $aluno->email }}</td>
                                        <td>
                                            <a href="{{ route('sisfalta.alunos.edit', $aluno->id) }}" class="btn btn-warning">Editar</a>
                                            <button class="btn btn-danger btn-delete" data-id="{{ $aluno->id }}" data-toggle="modal" data-target="#modalExluir">
                                                Excluir
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <div class="float-right">
                                                {{ $alunos->links() }}
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
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
                    <h5 class="modal-title" id="modalTitle">Excluir Aluno</h5>
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
                $('#form-delete')[0].action = '{{ route('sisfalta.alunos.destroy', '__id') }}'.replace('__id', $(this).data('id'));
            })
        });
    </script>
@endpush