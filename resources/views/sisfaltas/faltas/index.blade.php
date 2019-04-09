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
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>Selecione o período</h3></div>

                    <div class="card-body">
                        <form action="{{ route('sisfalta.faltas.index') }}">
                            <div class="row">
                                <div class="col-6">
                                    <select class="form-control" name="periodo" id="periodo" required>
                                        <option value="">Selecione o período</option>
                                        @foreach($periodos as $periodo)
                                            <option
                                                    value="{{ $periodo->data_inicio->toDateString() }},{{ $periodo->data_fim->toDateString() }}"
                                            >
                                                De {{ $periodo->data_inicio->format('d/m/Y') }}
                                                até {{ $periodo->data_fim->format('d/m/Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-success btn-block">Selecionar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @includeWhen(isset($alunos), 'sisfaltas.faltas.partials.table')
@endsection
