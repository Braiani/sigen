<?php

namespace App\Http\Controllers\Sisfaltas;

use App\Aluno;
use App\Curso;
use App\Falta;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use League\Csv\Reader;

class FaltaUploadController extends Controller
{
    /**
     * @param Request $request
     * @return Reader
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'arquivo' => 'required|file',
            'data_ini' => 'required|date',
            'data_fim' => 'required|date'
        ]);

        $csv = Reader::createFromPath($data['arquivo']);

        $csv->setHeaderOffset(0);

        foreach ($csv as $item) {
            $curso = $this->verifyCoordenacao($item['coordenacao']);

            if (! $curso){
                continue;
            }
            $aluno = $this->getAluno($item['estudante'], $curso, $item['email']);

            $periodo = [
                'data_inicio' => $data['data_ini'],
                'data_fim' => $data['data_fim']
            ];

            $this->addFaltaAluno($aluno, $item, $periodo);
        }

        toastr('Importação finalizada', 'info');
        return redirect()->route('sisfalta.index');
    }

    /**
     * @param $sigla
     * @return string
     */
    protected function verifyCoordenacao($sigla)
    {
        try {
            return Curso::where('sigla', $sigla)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            toastr('Nenhuma coordenação encontrada com essa sigla: ' . $sigla, 'error');
            return false;
        }
    }

    /**
     * @param $nome
     * @param $curso
     * @param $email
     * @return mixed
     */
    protected function getAluno($nome, $curso, $email)
    {
        return Aluno::updateOrCreate(
            ['nome' => $nome, 'curso_id' => $curso->id],
            ['email' => $email]
        );
    }

    /**
     * @param Aluno $aluno
     * @param $linhaCsv
     * @param array $periodo
     */
    protected function addFaltaAluno(Aluno $aluno, $linhaCsv, array $periodo)
    {
        $nFaltas = (int) $linhaCsv['faltas'];
        $totalAulas = (int) $linhaCsv['quantidade_aulas'];
        $falta = ($nFaltas / $totalAulas) * 100;

        $addFalta = [
            'aluno_id' => $aluno->id,
            'disciplina' => $linhaCsv['Unidade Curricular'],
            'falta' => $falta,
            'data_inicio' => $periodo['data_inicio'],
            'data_fim' => $periodo['data_fim']
        ];
        $verifyData = new Collection($addFalta);

        Falta::updateOrCreate(
            $verifyData->except('falta')->toArray(),
            $addFalta
        );
    }
}
