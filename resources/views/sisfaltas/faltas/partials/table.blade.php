@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css">
@endpush
<div class="container">
    <div class="row mb-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h3>Filtros</h3></div>
                <div class="card-body">
                    <div class="col-3 p-2">
                        <div class="form-group">
                            <label for="enviado">Filtrar por enviados:</label>
                            <select class="form-control" name="enviado" id="enviado">
                                <option value="-1">Todos</option>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>Faltas registradas</h3></div>

                <div class="card-body">
                    <div class="p-2">
                        <table id="table"
                               class="table table-striped"
                               data-url="{{ route('sisfalta.faltas.table', Request::query()) }}"
                               data-query-params="queryParams"
                               data-side-pagination="server"
                               data-locale="pt-BR">
                            <thead>
                            <tr>
                                <th data-field="nome"
                                    data-sortable="true"
                                >Nome
                                </th>
                                <th data-field="curso.nome" data-sortable="true">Curso</th>
                                <th data-field="email"
                                    data-sortable="true"
                                >E-mail
                                </th>
                                <th data-field="faltas"
                                    data-align="center"
                                    data-sortable="true"
                                    data-formatter="faltasFormatter"
                                >Disciplinas
                                </th>
                                <th data-field="faltas"
                                    data-sortable="false"
                                    data-formatter="periodoFormatter"
                                >Período
                                </th>
                                <th data-field="faltas" data-formatter="enviadoFormatter">Enviado?</th>
                            </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/pt-BR.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.14.2/bootstrap-table.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.14.2/locale/bootstrap-table-pt-BR.min.js"></script>
    <script>
        function queryParams(params) {
            params.enviado = $("#enviado").val();

            return params;
        }

        function faltasFormatter(value) {
            var resposta;

            $.each(value, function (index, valor) {
                if (index === 0) {
                    resposta = valor.disciplina + "(" + valor.falta + "%) <br>";
                } else {
                    resposta = resposta + valor.disciplina + " (" + valor.falta + "%) <br>";
                }
            });
            return resposta;
        }

        function periodoFormatter(value) {
            var dataInicio = value[0].data_inicio.replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1');
            var dataFim = value[0].data_fim.replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1');;
            return "De " + dataInicio + " até " + dataFim;
        }

        function enviadoFormatter(value) {
            if (value[0].enviado){
                return "Sim";
            } else {
                return "Não";
            }
        }

        $(document).on('pageReady', function () {
            $("#table").bootstrapTable({
                toolbar: ".toolbar",
                clickToSelect: false,
                showRefresh: true,
                search: true,
                pagination: true,
                searchAlign: 'left',
                pageSize: 10,
                pageList: [8, 10, 25, 50, 100],
                icons: {
                    refresh: 'fa fa-sync',
                }
            });
            $("#enviado").select2();

            $("#enviado").on('change', function () {
                $("#table").bootstrapTable('refresh');
            });
        });
    </script>
@endpush