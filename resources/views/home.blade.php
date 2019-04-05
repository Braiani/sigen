@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Controle de frequência</div>

                <div class="card-body">
                    <p class="text-center">Acessar o controle de frequência e alerta aos pais dos estudantes do Técnico Integrado</p>
                    <a href="{{ route('sisfalta.index') }}" class="btn btn-primary btn-block mt-3 p-2">Acessar SISFALTA</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
