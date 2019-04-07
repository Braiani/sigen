<?php

namespace App\Http\Controllers\Sisfaltas;

use App\Aluno;
use App\Curso;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use League\Csv\Reader;

class FaltaUploadController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'arquivo' => 'required|file',
            'data_ini' => 'required|date',
            'data_fim' => 'required|date'
        ]);

        $csv = Reader::createFromPath($data['arquivo']);

        $csv->setHeaderOffset(0);
        $i = 0;
        foreach ($csv as $item) {
//            dd($item);
            $curso = $this->verifyCoordenacao($item['coordenacao']);

            $aluno = $this->getAluno($item['estudante'], $curso, $item['email']);

            $i == 5 ? dd($aluno) : $i++;
        }

        return $csv;
    }

    protected function verifyCoordenacao($sigla)
    {
        try {
            return Curso::where('sigla', $sigla)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            toastr('Nenhuma coordenação encontrada com essa sigla: ' . $sigla, 'error');
            return $exception->getMessage();
        }
    }

    protected function getAluno($nome, $curso, $email)
    {
        return Aluno::updateOrCreate(
            ['nome' => $nome, 'curso_id' => $curso->id],
            ['email' => $email]
        );
    }
}
