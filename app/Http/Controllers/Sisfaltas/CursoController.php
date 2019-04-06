<?php

namespace App\Http\Controllers\Sisfaltas;

use App\Curso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cursos = Curso::all();
        return view('sisfaltas.cursos.index')->with(['cursos' => $cursos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sisfaltas.cursos.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required',
            'sigla' => 'required|max:5',
            'email' => 'required|email'
        ]);

        Curso::create($data);
        toastr('Curso adicionado com sucesso!', 'success');
        return redirect()->route('sisfalta.cursos.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Curso $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(Curso $curso)
    {
        return view('sisfaltas.cursos.edit', compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curso $curso)
    {
        $data = $request->validate([
            'nome' => 'required',
            'sigla' => 'required|max:5',
            'email' => 'required|email'
        ]);

        $curso->update($data);
        toastr('Curso editado com sucesso!', 'success');
        return redirect()->route('sisfalta.cursos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Curso $curso
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Curso $curso)
    {
        $curso->delete();
        toastr('Curso Excluido com sucesso!', 'success');
        return redirect()->route('sisfalta.cursos.index');
    }
}
