<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>Faltas registradas</h3></div>

                <div class="card-body">
                    <div class="p-2">
                        <table class="table table-bordered table-responsive">
                            <thead>
                            <th>Nome</th>
                            <th>Curso</th>
                            <th>E-mail</th>
                            <th>Disciplinas</th>
                            <th>Período</th>
                            <th>Enviado?</th>
                            </thead>
                            <tbody>
                            @foreach($alunos as $aluno)
                                <tr>
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
                                    <td>
                                        @if($aluno->faltas->first()->enviado)
                                            Sim
                                        @else
                                            Não
                                        @endif
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