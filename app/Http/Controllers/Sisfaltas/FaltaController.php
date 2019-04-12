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
            $q->where('data_inicio', $selectPeriodo[0])->where('data_fim', $selectPeriodo[1]);
        })->with('curso')->get();

        /*$aluno = $alunos->first();

        return view('sisfaltas.mails.mailPais', compact('aluno'));*/

        foreach ($alunos as $aluno) {
            if ($aluno->faltas->max('falta') > 0){
                $faltas = $aluno->faltas;
                $this->dispatch(new SendMailPaisJob($aluno, $faltas));
            }
        }

        toastr('Processo de envio de e-mails iniciado!', 'success');

        return redirect()->route('sisfalta.faltas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}