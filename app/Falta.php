<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Falta extends Model
{

    protected $fillable = ['aluno_id', 'disciplina', 'falta', 'data_inicio', 'data_fim', 'enviado'];

    protected $dates = ['data_inicio', 'data_fim'];

    public function getFaltaFormatadoAttribute()
    {
        return number_format($this->falta, 1, ',', '.');
    }

    public function getDisciplinaAttribute($value)
    {
        return str_replace('*', '', $value);
    }

    public function aluno()
    {
        return $this->belongsTo('App\Aluno');
    }

    public function getDataIniBrAttribute()
    {
        return $this->data_inicio->format('d/m/Y');
    }

    public function getDataFimBrAttribute()
    {
        return $this->data_fim->format('d/m/Y');
    }
}
