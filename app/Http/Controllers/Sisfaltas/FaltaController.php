<?php

namespace App\Http\Controllers\Sisfaltas;

use App\Aluno;
use App\Falta;
use App\Http\Controllers\Controller;
use App\Jobs\SendMailPaisJob;
use Illuminate\Http\Request;

class FaltaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->has('periodo') ? $selectPeriodo = explode(',', $request->periodo) : $selectPeriodo = false;
        $periodos = Falta::select('data_fim', 'data_inicio')->distinct()->get();


        if ($selectPeriodo) {
            $alunos = Aluno::withAndWhereHas('faltas', function ($q) use ($selectPeriodo) {
                $q->where('data_inicio', $selectPeriodo[0])->where('data_fim', $selectPeriodo[1]);
            })->paginate();
        }

        return view('sisfaltas.faltas.index', compact('alunos', 'periodos'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendEmail(Request $request)
    {
        $request->validate([
            'periodo' => 'required'
        ]);

        $selectPeriodo = explode(',', $request->periodo);

        $alunos = Aluno::withAndWhereHas('faltas', function ($q) use ($selectPeriodo) {
            $q->where('data_inicio', $selectPeriodo[0])->where('data_fim', $selectPeriodo[1])->where('enviado', false);
        })->with('curso')->get();

        /*$aluno = $alunos->first();
        $faltas = $aluno->faltas;

        return view('sisfaltas.mails.mailPais', compact('aluno', 'faltas'));*/

        $i = 0;
        foreach ($alunos as $aluno) {
            if ($i == 15) {
                break;
            }
            if ($aluno->faltas->max('falta') > 0) {
                $faltas = $aluno->faltas;
                $this->dispatch(new SendMailPaisJob($aluno, $faltas));
                $i++;
            }
        }

        toastr('Processo de envio de e-mails iniciado!', 'success');

        return redirect()->route('sisfalta.faltas.index');
    }

    public function getData(Request $request)
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = $request->has('search') ? $request->get('search') : false;
        $sort = $request->has('sort') ? $request->get('sort') : false;
        $request->has('periodo') ? $selectPeriodo = explode(',', $request->periodo) : $selectPeriodo = false;
        $enviado = $request->has('enviado') ? $request->get('enviado') : false;

        $query = new Aluno();

        $query = $query->withAndWhereHas('faltas', function ($q) use ($selectPeriodo) {
            $q->where('data_inicio', $selectPeriodo[0])->where('data_fim', $selectPeriodo[1]);
        });


        $query = $query->when($search, function ($query) use ($search) {
            $query->where('nome', 'LIKE', "%{$search}%")->orWhereIn('curso_id', function ($query) use ($search) {
                $query->select('id')->from('cursos')->where('nome', 'LIKE', "%{$search}%");
            })->orWhere('email', 'LIKE', "%{$search}%")->orWhereHas('faltas', function ($query) use ($search) {
                $query->where('disciplina', 'LIKE', "%{$search}%");
            });
        });

        if ($enviado !== "-1") {
            $query = $query->whereHas('faltas', function ($q) use ($enviado) {
                $q->where('enviado', $enviado);
            });
        }

        $total = $query->count();
        $registros = $query->offset($offset)->limit($limit)->with('curso')->get();
        $resposta = array(
            'total' => $total,
            'count' => $registros->count(),
            'rows' => $registros,
        );
        return $resposta;
    }
}