<?php

namespace App\Http\Controllers\Sisfaltas;

use App\Aluno;
use App\Falta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FaltaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->has('periodo') ? $selectPeriodo = explode(',', $request->periodo) : $selectPeriodo = false;
        $periodos = Falta::select('data_fim', 'data_inicio')->distinct()->get();


        if ($selectPeriodo) {
            $alunos = Aluno::whereHas('faltas', function ($q) use ($selectPeriodo) {
                $q->where('data_inicio', $selectPeriodo[0])->where('data_fim', $selectPeriodo[1]);
            })->with(['faltas' => function ($q) use ($selectPeriodo) {
                $q->where('data_inicio', $selectPeriodo[0])->where('data_fim', $selectPeriodo[1]);
            }])->paginate();
        }

        return view('sisfaltas.faltas.index', compact('alunos', 'periodos'));
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