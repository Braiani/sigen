@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Adicionar Curso</div>

                    <div class="card-body">
                        <form id="form-add" method="post" action="{{ route('sisfalta.cursos.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group">
                                        <label for="nome">Nome:</label>
                                        <input name="nome" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="sigla">Sigla:</label>
                                        <input name="sigla" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="email">E-mail:</label>
                                        <input name="email" class="form-control" type="email" required>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <hr>
                        <div class="float-right">
                            <button form="form-add" class="btn btn-success">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection