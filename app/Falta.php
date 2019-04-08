<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Falta extends Model
{

    protected $fillable = ['aluno_id', 'disciplina', 'falta', 'data_inicio', 'data_fim', 'enviado'];

    protected $dates = ['data_inicio', 'data_fim'];

    public function getFaltaAttribute($value)
    {
        return number_format($value, 1, ',', '.');
    }

    public function getDisciplinaAttribute($value)
    {
        return str_replace('*', '', $value);
    }

    public function aluno()
    {
        return $this->belongsTo('App\Aluno');
    }
}
