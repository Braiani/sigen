@extends('layouts.app')

@push('css')
    <style>
        td {
            vertical-align: middle !important;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>Faltas registradas</h3></div>

                    <div class="card-body">
                        <div class="float-right mb-2 p-2">
                            <a href="#" class="btn btn-success">Enviar E-mail</a>
                        </div>
                        <div class="p-2">
                            <table class="table table-bordered table-responsive">
                                <thead>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Curso</th>
                                <th>E-mail</th>
                                <th>Disciplinas</th>
                                <th>Período</th>
                                </thead>
                                <tbody>
                                @foreach($alunos as $aluno)
                                    <tr>
                                        <td>{{ $aluno->id }}</td>
                                        <td>{{ strtoupper($aluno->nome) }}</td>
                                        <td>{{ $aluno->curso->nome }}</td>
                                        <td>{{ $aluno->email }}</td>
                                        <td>
                                            <ul>
                                                @foreach($aluno->faltas as $falta)
                                                    <li>{{ strtoupper($falta->disciplina) }} - ({{ $falta->falta }}%)</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            De {{ $aluno->faltas->first()->data_inicio->format('d/m/Y') }}
                                            até {{ $aluno->faltas->first()->data_fim->format('d/m/Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6">
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
@endsection
