@extends('layouts.app')

@section('content')
    <div class="container">
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
@endsection
