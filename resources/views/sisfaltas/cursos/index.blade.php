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
                                            <form action="{{ route('sisfalta.cursos.destroy', $curso->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('sisfalta.cursos.edit', $curso->id) }}" class="btn btn-warning">Editar</a>
                                                <button class="btn btn-danger">Excluir</button>
                                            </form>
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
@endsection