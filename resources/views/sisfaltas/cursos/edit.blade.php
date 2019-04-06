@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Editar Curso</div>

                    <div class="card-body">
                        <form id="form-edit" method="post" action="{{ route('sisfalta.cursos.update', $curso->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group">
                                        <label for="nome">Nome:</label>
                                        <input name="nome" class="form-control" type="text" value="{{ $curso->nome }}" required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="sigla">Sigla:</label>
                                        <input name="sigla" class="form-control" type="text" value="{{ $curso->sigla }}" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="email">E-mail:</label>
                                        <input name="email" class="form-control" type="email" value="{{ $curso->email }}" required>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <button form="form-edit" class="btn btn-success">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection