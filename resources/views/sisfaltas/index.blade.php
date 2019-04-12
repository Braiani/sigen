@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Carregar dados por arquivo</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            <form id="form-upload-csv" action="{{ route('sisfalta.faltas.arquivo') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="data_ini">Data início:</label>
                                            <input class="form-control" type="date" name="data_ini" id="data_ini" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="data_fim">Data final:</label>
                                            <input class="form-control" type="date" name="data_fim" id="data_fim" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="arquivo">Selecione o arquivo:</label>
                                            <input type="file" class="form-control-file" name="arquivo" id="arquivo">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <button class="btn btn-outline-info btn-block" type="submit">Enviar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Cursos</div>

                    <div class="card-body">
                        <p class="text-center">Gerenciar os cursos Técnico Integrado</p>
                        <a href="{{ route('sisfalta.cursos.index') }}" class="btn btn-primary btn-block mt-3 p-2">Acessar Cursos</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Alunos</div>

                    <div class="card-body">
                        <p class="text-center">Gerenciar os alunos dos cursos Técnico Integrado</p>
                        <a href="{{ route('sisfalta.alunos.index') }}" class="btn btn-primary btn-block mt-3 p-2">Acessar Alunos</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Faltas</div>

                    <div class="card-body">
                        <p class="text-center">Gerenciar as faltas dos alunos dos cursos Técnico Integrado</p>
                        <a href="{{ route('sisfalta.faltas.index') }}" class="btn btn-primary btn-block mt-3 p-2">Acessar Faltas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Carregando...</h5>
                </div>
                <div class="modal-body">
                    <img src="https://cdn-images-1.medium.com/max/1600/1*8NJgObmgEVhNWVt3poeTaA.gif" alt="carregando">
                    <div class="col-12 text-center">
                        <h3>Carregando informações da planilha, por favor não feche essa janela!</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).on('pageReady', function (e) {
            $("#form-upload-csv").on('submit', function (e) {
                $('.modal').modal('toggle');
            });
        });
    </script>
@endpush