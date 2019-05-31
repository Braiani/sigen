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
                        <form id="form-faltas" action="{{ route('sisfalta.faltas.index') }}">
                            <div class="row">
                                <div class="col-6">
                                    <select class="form-control" name="periodo" id="periodo" required>
                                        <option value="">Selecione o período</option>
                                        @foreach($periodos as $periodo)
                                            @php
                                            $selectValue = $periodo->data_inicio->toDateString() . ',' . $periodo->data_fim->toDateString();
                                            $selected = Request::get('periodo') == $selectValue ? 'selected' : '';
                                            @endphp
                                            <option
                                                    value="{{ $selectValue }}" {{ $selected }}
                                            >
                                                De {{ $periodo->data_inicio->format('d/m/Y') }}
                                                até {{ $periodo->data_fim->format('d/m/Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <button id="gerarLista" class="btn btn-success btn-block">Selecionar</button>
                                </div>
                                <div class="col-2">
                                    <button id="enviarEmail" class="btn btn-primary btn-block">Enviar E-mails</button>
                                </div>
                                <div class="col-2">
                                    <button id="relatorioCoords" class="btn btn-info btn-block">Relatório Coords</button>
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

@push('script')
    <script>
        $(document).on('pageReady', function () {
            $("#enviarEmail").on('click', function (e) {
                e.preventDefault();
                $('#form-faltas')[0].action = '{{ route('sisfalta.faltas.enviar') }}';
                $('#form-faltas').trigger('submit');
            });
            $("#gerarLista").on('click', function (e) {
                e.preventDefault();
                $('#form-faltas')[0].action = '{{ route('sisfalta.faltas.index') }}';
                $('#form-faltas').trigger('submit');
            });
            $("#relatorioCoords").on('click', function (e) {
                e.preventDefault();
                $('#form-faltas')[0].action = '{{ route('sisfalta.faltas.relatorio.coords') }}';
                $('#form-faltas').trigger('submit');
            });
        });
    </script>
@endpush